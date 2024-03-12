<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMoviesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::dropIfExists('movies');
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table
                ->string('title',100)
                ->unique()
                ->comment('映画タイトル');
            $table->text('image_url')->comment('画像URL');
            $table->integer('published_year')->comment('公開年');
            $table->tinyInteger('is_showing')->comment('上映中かどうか')->default(false);
            $table->text('description')->comment('概要');
            $table->foreignId('genre_id')->constrained('genres');
            // 'genre' => function() 
            // {                    
            //     return User::factory()->create()->id;                
            // },

            $table->timestamps();
        });
    }

  

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('movies');
    }
}