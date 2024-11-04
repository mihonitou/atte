<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attendance_id')
                ->constrained('attendances') // attendancesテーブルを明示的に指定
                ->cascadeOnDelete();
            $table->time('start');
            $table->time('end')->nullable();
            $table->timestamps();

            // 同じattendance_id内で重複した休憩時間を防ぐためのユニーク制約
            $table->unique(['attendance_id', 'start']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rests');
    }
}
