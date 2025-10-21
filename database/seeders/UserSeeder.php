<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'role_id' => 1,
            'name' => 'Admin Besar',
            'email' => 'siadmin@gmail.com',
            'password' => Hash::make('123123qwe'),
            'date_of_birth' => '2000-12-22',
            'gender' => 'L',
        ]);
    }
}
