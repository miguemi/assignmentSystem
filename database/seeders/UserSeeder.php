<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        $analystRole = Role::where('name', 'Analyst')->first();
        $employerRole = Role::where('name', 'Employer')->first();

        User::create([
            'name' => 'John Analyst',
            'email' => 'john.analyst@example.com',
            'password' => Hash::make('password'),
            'role_id' => $analystRole->id,
        ]);

        User::create([
            'name' => 'Jane Employer',
            'email' => 'jane.employer@example.com',
            'password' => Hash::make('password'),
            'role_id' => $employerRole->id,
        ]);

        User::create([
            'name' => 'Alice Analyst',
            'email' => 'alice.analyst@example.com',
            'password' => Hash::make('password'),
            'role_id' => $analystRole->id,
        ]);

        User::create([
            'name' => 'Bob Employer',
            'email' => 'bob.employer@example.com',
            'password' => Hash::make('password'),
            'role_id' => $employerRole->id,
        ]);

        User::create([
            'name' => 'Charlie Analyst',
            'email' => 'charlie.analyst@example.com',
            'password' => Hash::make('password'),
            'role_id' => $analystRole->id,
        ]);
    }
}