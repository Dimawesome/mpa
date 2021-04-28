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
        'name',
        'url',
        'order',
        'is_active'
    ];

    /**
     * @var Page
     */
    protected Page $page;

    /**
     * MenuItem constructor.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->page = new Page();

        parent::__construct($attributes);
    }

    /**
     * Get validation rules.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required|max:20'
        ];
    }

    /**
     * Bootstrap any application services
     *
     * @return void
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
     * Get selected page uid
     *
     * @param string|null $muid
     * @return string|null
     */
    public function getSelectedPageUid(?string $muid): ?string
    {
        $menu = $this->findByUid($muid);

        if ($menu !== null && $menu->url !== null) {
            $urlSegments = explode('/', trim($menu->url, '/'));
            return end($urlSegments);
        }

        return null;
    }

    /**
     * Get all active page list
     *
     * @param string|null $muid
     * @return array
     */
    public function getActivePageList(?string $muid = null): array
    {
        $pages = $this->page->getAllActive();
        $options = [];

        foreach ($pages as $page) {
            $options[] = [
                'value' => $page['uid'],
                'text' => $page['title']
            ];
        }

        $data['values'] = $muid ? $this->getSelectedPageUid($muid) : [];
        $data['options'] = $options;

        return $data;
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
     */
    public function createPageUrl($menu, string $puid): string
    {
        return '/page/' . Str::slug($menu->name, '-') . "/$menu->$puid/$puid";
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
