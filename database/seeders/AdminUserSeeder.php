<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AdminUser;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AdminUser::updateOrCreate(
            ['email' => 'admin@tanzaniadailytours.com'],
            [
                'name' => 'Admin',
                'password' => 'admin123',
                'is_active' => true,
            ]
        );
    }
}
