<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

/**
 * Class BaseModel
 *
 * @package App\Models
 * @mixin EloquentBuilder
 */
class BaseModel extends Model
{
    use HasFactory;

    /**
     * Get all items
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->select('*')->get();
    }

    /**
     * Sort page modules
     *
     * @param $items
     * @return array
     */
    public function sortByOrder($items): array
    {
        return $items ? collect($items)->sortBy('order')->toArray() : [];
    }

    /**
     * Get all active items
     *
     * @return Collection
     */
    public function getAllActive(): Collection
    {
        return $this->select('*')->where('is_active', '=', true)->get();
    }

    /**
     * Find item by uid.
     *
     * @param string|null $uid
     * @return BaseModel|Model|object|null
     */
    public function findByUid(?string $uid)
    {
        return $this->where('uid', '=', $uid)->first();
    }

    /**
     * Set item active parameter to 0
     *
     * @return void
     */
    public function disable(): void
    {
        $this->update([
            'is_active' => 0
        ]);
    }

    /**
     * Set item active parameter to 1
     *
     * @return void
     */
    public function enable(): void
    {
        $this->update([
            'is_active' => 1
        ]);
    }

    /**
     * Get all active page list
     *
     * @param array $pages
     * @param string|null $uid
     * @return array
     */
    public function getActivePageList(array $pages, ?string $uid = null): array
    {
        $options = [];

        foreach ($pages as $page) {
            $options[] = [
                'value' => $page['uid'],
                'text' => $page['title']
            ];
        }

        $data['values'] = $uid ? $this->getSelectedPageUid($uid) : [];
        $data['options'] = $options;

        return $data;
    }

    /**
     * Get selected page uid
     *
     * @param string|null $uid
     * @return string|null
     */
    public function getSelectedPageUid(?string $uid): ?string
    {
        $model = $this->findByUid($uid);

        if ($model !== null && $model->url !== null) {
            $urlSegments = explode('/', trim($model->url, '/'));

            return $urlSegments['2'];
        }

        return null;
    }

    /**
     * Create page url
     *
     * @param $page
     * @param $menu
     * @return string
     */
    public function createPageUrl($page, $menu = null): string
    {
        return '/page/' . Str::slug($menu ? $menu->name : $page->title)
            . "/$page->uid"
            . (isset($menu->uid) ? "/$menu->uid" : '');
    }
}
