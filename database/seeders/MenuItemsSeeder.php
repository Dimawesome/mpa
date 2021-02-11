<?php

namespace Database\Seeders;

use App\Models\MenuItems;
use Illuminate\Database\Seeder;

class MenuItemsSeeder extends Seeder
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
                'password' => 'asda'
            ]
        ];

        foreach ($items as $item) {
            MenuItems::firstOrCreate($item);
        }
    }
}
