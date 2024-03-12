<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->date('date')->comment('上映日');
/*
            $table
                    ->foreignId('movie_id')
                    ->constrained('movies')
                    ->comment('映画ID');
*/
            $table
                    ->foreignId('schedule_id')
                    ->constrained('schedules')
                    ->comment('スケジュールID');
            $table
                    ->foreignId('sheet_id')
                    ->constrained('sheets')
                    ->comment('シートID');
            $table->integer('screen_no')->nullable(true)->comment('スクリーンNo');  //20
            $table->string('email',255)->comment('予約者メールアドレス');
            $table->string('name',255)->comment('予約者名');
            $table->tinyInteger('is_canceled')->comment('予約キャンセル済み')->default(false);
            $table->timestamps();
            $table->unique(['schedule_id','sheet_id'],'aaa');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservations');
    }
}
