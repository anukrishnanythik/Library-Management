<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'uuid' => str()->uuid(),
            'name' => 'Librarian',
            'email' => config('user.librarian_email'),
            'password' => Hash::make(config('user.password')),
            'role' => 'librarian',
        ]);

        User::create([
            'uuid' => str()->uuid(),
            'name' => 'Member',
            'email' => config('user.member_email'),
            'password' => Hash::make(config('user.password')),
            'role' => 'member',
        ]);

        User::factory(4)->member()->create();
        User::factory(4)->librarian()->create();
    }
}
