<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // jangan dipakai di prod yahhh
        User::updateOrCreate(
            ['email' => 'admin@wfsc.local'],
            [
                'name' => 'WFSC Administrator',
                'password' => Hash::make('password'),
            ]
        );
    }
}
