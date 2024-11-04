<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Attendance;
use App\Models\Rest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class AttendanceController extends Controller
{
    // ホーム画面表示
    public function punch()
    {
        $now_date = Carbon::now()->format('Y-m-d');
        $user_id = Auth::user()->id;

        // 日付が変わっていれば status をリセット
        $last_attendance = Attendance::where('user_id', $user_id)->latest()->first();
        if ($last_attendance && $last_attendance->date < $now_date) {
            // 日付が変わったら status をリセット
            $user = Auth::user();
            $user->status = 0;
            $user->save();
        }

        $confirm_date = Attendance::where('user_id', $user_id)
            ->where('date', $now_date)
            ->first();

        if (!$confirm_date) {
            $status = 0;  // まだ勤務を開始していない
        } else {
            $status = Auth::user()->status;  // 既に勤務中または休憩中
        }

        return view('index', compact('status'));
    }

    // 打刻処理
    public function work(Request $request)
    {
        $now_date = Carbon::now()->format('Y-m-d');
        $now_time = Carbon::now()->format('H:i:s');
        $user_id = Auth::user()->id;

        // 勤務開始時の処理
        if ($request->has('start_work')) {
            $attendance = new Attendance();
            $attendance->date = $now_date;
            $attendance->start = $now_time;
            $attendance->user_id = $user_id;
            $attendance->save();  // 勤務開始時刻を保存

            // 勤務中に変更
            $user = User::find($user_id);
            $user->status = 1;
            $user->save();
        }

        // 休憩開始時の処理（何度でも休憩可能）
        if ($request->has('start_rest')) {
            $attendance = Attendance::where('user_id', $user_id)
                ->where('date', $now_date)
                ->first();

            if ($attendance) {
                // 休憩開始時刻を保存（複数回の休憩を管理）
                $rest = new Rest();
                $rest->start = $now_time;
                $rest->attendance_id = $attendance->id; // attendancesテーブルのIDに関連付け
                $rest->save();

                // 休憩中に変更
                $user = User::find($user_id);
                $user->status = 2;
                $user->save();
            }
        }

        // 休憩終了時の処理
        if ($request->has('end_rest')) {
            $attendance = Attendance::where('user_id', $user_id)
                ->where('date', $now_date)
                ->first();

            if ($attendance) {
                // 休憩終了時刻を保存（最後の未終了の休憩を更新）
                $rest = Rest::where('attendance_id', $attendance->id)
                    ->whereNotNull('start')
                    ->whereNull('end')
                    ->latest()  // 最新の休憩を取得
                    ->first();

                if ($rest) {
                    $rest->end = $now_time;
                    $rest->save();

                    // 勤務中に戻す
                    $user = User::find($user_id);
                    $user->status = 1;
                    $user->save();
                }
            }
        }

        // 勤務終了時の処理
        if ($request->has('end_work')) {
            $attendance = Attendance::where('user_id', $user_id)
                ->where('date', $now_date)
                ->first();

            if ($attendance) {
                $attendance->end = $now_time;
                $attendance->save();

                // 勤務終了後は status を 0 に戻す
                $user = User::find($user_id);
                $user->status = 0;
                $user->save();
            }
        }

        return redirect('/')->with(compact('status'));
    }
}
