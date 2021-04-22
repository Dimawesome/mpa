<?php

namespace Database\Seeders;

use App\Models\MenuItem;
use Illuminate\Database\Seeder;

/**
 * Class MenuItemsSeeder
 *
 * @package Database\Seeders
 */
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
                'name' => 'Test 1',
                'url' => json_encode(['/page/test_1/123,123']),
                'order' => 1
            ],
            [
                'name' => 'Test 2',
                'url' => json_encode(['/page/test_2/123,123']),
                'order' => 2
            ],
            [
                'name' => 'Test 3',
                'url' => json_encode(['/page/test_3/123,123']),
                'order' => 3
            ],
            [
                'name' => 'Test 4',
                'url' => json_encode(['/page/test_3/123,123']),
                'order' => 4
            ],
            [
                'name' => 'Test 5',
                'url' => json_encode(['/page/test_3/123,123']),
                'order' => 5
            ],
            [
                'name' => 'Test 6',
                'url' => json_encode(['/page/test_3/123,123']),
                'order' => 6
            ],
            [
                'name' => 'Test 7',
                'url' => json_encode(['/page/test_3/123,123']),
                'order' => 7
            ],
            [
                'name' => 'Test 8',
                'url' => json_encode(['/page/test_3/123,123']),
                'order' => 8
            ],
            [
                'name' => 'Test 9',
                'url' => json_encode(['/page/test_3/123,123']),
                'order' => 9
            ],
            [
                'name' => 'Test 10',
                'url' => json_encode(['/page/test_3/123,123']),
                'order' => 10
            ],
            [
                'name' => 'Test 11',
                'url' => json_encode(['/page/test_3/123,123']),
                'order' => 11
            ],
            [
                'name' => 'Test 12',
                'url' => json_encode(['/page/test_3/123,123']),
                'order' => 12
            ],
            [
                'name' => 'Test 13',
                'url' => json_encode(['/page/test_3/123,123']),
                'order' => 13
            ],
            [
                'name' => 'Test 14',
                'url' => json_encode(['/page/test_3/123,123']),
                'order' => 14
            ],
            [
                'name' => 'Test 15',
                'url' => json_encode(['/page/test_3/123,123']),
                'order' => 15
            ],
            [
                'name' => 'Test 16',
                'url' => json_encode(['/page/test_3/123,123']),
                'order' => 16
            ],
        ];

        foreach ($items as $item) {
            MenuItem::firstOrCreate($item);
        }
    }
}
