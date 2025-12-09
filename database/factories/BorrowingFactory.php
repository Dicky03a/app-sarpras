<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Asset;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Borrowing>
 */
class BorrowingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'asset_id' => Asset::factory(),
            'tanggal_mulai' => now()->addDays(fake()->numberBetween(1, 10)),
            'tanggal_selesai' => now()->addDays(fake()->numberBetween(11, 20)),
            'keperluan' => fake()->sentence(),
            'lampiran_bukti' => 'borrowing_documents/test_document.pdf',
            'status' => fake()->randomElement(['pending', 'disetujui', 'ditolak', 'dipinjam', 'selesai']),
            'admin_id' => null,
        ];
    }
}