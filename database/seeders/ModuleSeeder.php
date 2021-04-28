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
        ];

        foreach ($modules as $module) {
            $moduleObj->firstOrCreate($module);
        }
    }
}
