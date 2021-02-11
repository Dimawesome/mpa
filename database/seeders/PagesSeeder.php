<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PagesSeeder extends Seeder
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
            Page::firstOrCreate($item);
        }
    }
}
