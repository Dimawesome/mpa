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
                'table_name' => 'module_text'
            ],
            [
                'name' => 'file',
                'table_name' => 'module_file'
            ],
            [
                'name' => 'card',
                'table_name' => 'module_card'
            ],
            [
                'name' => 'video_card',
                'table_name' => 'module_video_card'
            ],
        ];

        foreach ($modules as $module) {
            $moduleObj->firstOrCreate($module);
        }
    }
}
