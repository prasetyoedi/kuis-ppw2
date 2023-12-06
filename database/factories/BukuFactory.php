<?php

namespace Database\Factories;
use App\Models\Buku;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Buku>
 */
class BukuFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

     protected $model = Buku::class;
     
     public function definition()
    {
        return [
            'judul' => $this->faker->sentence(),
            'penulis' => $this->faker->name(),
            'harga' => $this->faker->numberBetween(20000, 100000),
            'tgl_terbit' => $this->faker->date($format='Y-m-d', $max='now')
        ];
    }
}
