<?php

namespace Database\Factories;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Seller>
 */
class SellerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $role = fake()->numberBetween(Role::ROLE_SELLER, Role::ROLE_MANAGER);

        return [
            'company_id' => fake()->numberBetween(1, 4),
            'user_id' => User::factory()->create(['role_id' => $role]),
        ];
    }
}
