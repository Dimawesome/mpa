<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Support\Str;

/**
 * Class MenuItem
 *
 * @package App\Models
 * @mixin EloquentBuilder
 */
class MenuItem extends BaseModel
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type',
        'name',
        'url',
        'order',
        'status'
    ];

    /**
     * Get validation rules.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required'
        ];
    }

    /**
     * Bootstrap any application services.
     */
    public static function boot(): void
    {
        parent::boot();
        // Create uid when creating item.
        static::creating(function ($item) {
            // Create new uid
            $uid = uniqid();

            while (self::where('uid', '=', $uid)->count() > 0) {
                $uid = uniqid();
            }

            $item->uid = $uid;
        });
    }

    /**
     * Get nested parents path
     *
     * @param string|null $uid
     * @param null $item
     * @return array
     */
    public static function getNestedParentsPath(?string $uid, $item = null): array
    {
        $child = $item ?: self::findByUid($uid);
        $tree = [];

        while ($child) {
            array_unshift($tree, $child->name);

            $child = $child->parent;
        }

        return $tree;
    }

    /**
     * Get selected pages uid
     *
     * @param string|null $uid
     * @return array|null
     */
    public static function getSelectedPages(?string $uid): ?array
    {
        $menu = self::findByUid($uid);

        if ($menu !== null && $menu->url_type === self::PAGE_TYPE && $menu->url !== null) {
            $urls = json_decode($menu->url, true);

            $pages = [];

            foreach ($urls as $url) {
                $urlSegments = explode('/', trim($url, '/'));
                $pages[] = end($urlSegments);
            }

            return $pages;
        }

        return null;
    }

    /**
     * Find by url path
     *
     * @return mixed
     */
    public static function findByUrl()
    {
        return self::where('url', '=', '/' . request()->path())->first();
    }

    /**
     * Get max order number
     *
     * @return int
     */
    public function getMaxOrder(): int
    {
        $modules = $this->getSortedMenuItems($this->getAll()->toArray());

        return $modules ? last($modules)['order'] + 1 : 1;
    }

    /**
     * Sort page modules
     *
     * @param array|null $items
     * @return array|null
     */
    public function getSortedMenuItems(?array $items): ?array
    {
        return $items ? collect($items)->sortBy('order')->toArray() : null;
    }


    /**
     * Create page url
     *
     * @param  $menu
     * @param string $puid
     * @return string
     * TODO add page name
     */
    public function createPageUrl($menu, string $puid): string
    {
//        return json_encode(
//            '/' . Page::findByUid($puid)->page_name . '/' . Str::slug($menu->name, '-') . "/$menu->$puid/$puid",
//            JSON_THROW_ON_ERROR
//        );

        return json_encode('/' . 'lalala' . '/' . Str::slug($menu->name, '-') . "/$menu->uid/$puid");
    }

    /**
     * Rebuild items order
     *
     * @param array $items
     */
    public function rebuildOrder(array $items): void
    {
        foreach ($items as $key => $item) {
            if ($menu = $this->findByUid($item['uid'])) {
                $menu->order = $key + 1;
                $menu->save();
            }
        }
    }
}
