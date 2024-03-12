<?php

namespace Database\Seeders;

use App\Models\Movie;
use App\Models\Genre;
use App\Models\Sheet;
use App\Models\Schedule;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Genre::factory(5)->create();
        Movie::factory(5)->create();
        $this->call(SheetTableSeeder::class);
        Schedule::factory(5)->create();

    }
}
