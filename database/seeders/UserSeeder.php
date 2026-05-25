<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Seller;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('12341234'),
            'role_id' => Role::ROLE_ADMIN,
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]);
    }
}
