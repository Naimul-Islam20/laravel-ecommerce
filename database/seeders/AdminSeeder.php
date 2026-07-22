<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@xperciainc.com'],
            [
                'name' => 'Admin',
                'password' => 'Admin@Xpercia2026!',
                'is_admin' => true,
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );
    }
}
