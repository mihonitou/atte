<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained('users') // usersテーブルを明示的に指定
                ->cascadeOnDelete();
            $table->time('start_time');
            $table->time('end_time')->nullable();
            $table->date('date');
            $table->timestamps();

            // ユーザーが同じ日に複数の出席データを持たないようにするユニーク制約
            $table->unique(['user_id', 'date']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attendances');
    }
}
