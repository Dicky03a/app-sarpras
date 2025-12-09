<?php

namespace Database\Factories;

use App\Models\AssetCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Asset>
 */
class AssetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->word(),
            'kode_aset' => 'A-' . fake()->unique()->numberBetween(1000, 9999),
            'lokasi' => fake()->address(),
            'deskripsi' => fake()->sentence(),
            'kondisi' => fake()->randomElement(['baik', 'rusak ringan', 'rusak berat']),
            'status' => 'tersedia', // available in Indonesian
            'category_id' => AssetCategory::factory(), // Create a category if needed
        ];
    }
}