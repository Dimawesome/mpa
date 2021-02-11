<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $items = [
            [
                'username' => 'admin',
                'password' => Hash::make('admin')
            ]
        ];

        foreach ($items as $item) {
            User::firstOrCreate($item);
        }
    }
}
