<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

/**
 * Class Page
 *
 * @package App\Models
 * @mixin EloquentBuilder
 */
class Page extends BaseModel
{
    use HasFactory;

    /**
     * Get all active items
     *
     * @return array
     */
    public function getAllActive(): array
    {
        return $this->select('*')
            ->where('status', '=', 'active')
            ->get()
            ->toArray();
    }

    /**
     * Get all active page list
     *
     * @param string|null $uid
     * @return array
     */
    public function getActivePageList(?string $uid = null): array
    {
        return [
            [
                'value' => '1',
                'text' => 'Page 1'
            ],
            [
                'value' => '2',
                'text' => 'Page 2'
            ],
            [
                'value' => '3',
                'text' => 'Page 3'
            ],
        ];


//        $pages = $this->getAllActive();
//        $options = [];
//
//        foreach ($pages as $page) {
//            $options[] = [
//                'value' => $page['uid'],
//                'text' => $page['title']
//            ];
//        }
//
//        $data['values'] = $uid ? self::getSelectedPages($uid) : [];
//        $data['options'] = $options;
//
//        return $data;
    }
}
