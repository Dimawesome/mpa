<?php

namespace Database\Seeders;

use App\Models\Module;
use Illuminate\Database\Seeder;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $moduleObj = new Module();

        $modules = [
            [
                'name' => 'text',
            ],
            [
                'name' => 'file',
            ],
            [
                'name' => 'card',
            ],
            [
                'name' => 'video_card',
            ],
        ];

        foreach ($modules as $module) {
            $moduleObj->firstOrCreate($module);
        }
    }
}
