<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

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
            'crew_id' => 'SA-1',
            'username' => 'test',
            'name' => 'Test User',
            'email' => 'test@example.com',
            'user_type' => 'System Admin',
            'password' => Hash::make('password'), // Or any password you prefer
        ]);
    }
}
