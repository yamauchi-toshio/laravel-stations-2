<?php

namespace Database\Factories;

use App\Models\Genre;
use Illuminate\Database\Eloquent\Factories\Factory;


class MovieFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->realText(10),
            'image_url' => 'https://techbowl.co.jp/_nuxt/img/6074f79.png',
            'published_year' => 2023,
            'is_showing' => false,
            'description' => 'おもしろい',
            'genre_id' => function() 
                            { 
                                   return Genre::factory()->create()->id;                
                            },
        ];
    }
}
