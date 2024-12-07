<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pegawai>
 */
class PegawaiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "name" => $this->faker->name,
            "jabatan" => $this->faker->randomElement(['Chief', 'Manager', 'Supervisor', 'Staff', 'Outsource']),
            "tanggal_lahir" => $this->faker->date('Y-m-d', 'now'),
            "email" => $this->faker->email,
        ];
    }
}
