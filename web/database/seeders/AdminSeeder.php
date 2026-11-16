<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => config('sekolah.admin.email')],
            [
                'name' => 'Super Admin',
                'password' => config('sekolah.admin.password'),
                'role' => User::ROLE_SUPER_ADMIN,
                'is_active' => true,
            ],
        );
    }
}
