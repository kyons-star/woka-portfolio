<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Demo login:  Demo User  /  password123
        $user = User::create([
            'name'     => 'Demo User',
            'name_key' => 'demo user',
            'password' => 'password123',
        ]);

        $user->portfolios()->create([
            'number' => 1,
            'style'  => 'Modern',
            'data'   => [
                'name'   => 'Demo User',
                'email'  => 'demo@example.com',
                'about'  => 'This is a demo portfolio created by the seeder.',
                'skills' => 'Laravel, PHP, Design',
            ],
        ]);
    }
}