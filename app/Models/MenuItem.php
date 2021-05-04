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
            'name' => 'required|max:30'
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
     * Get max order number
     *
     * @return int
     */
    public function getMaxOrder(): int
    {
        $modules = $this->sortByOrder($this->getAll());

        return $modules ? last($modules)['order'] + 1 : 1;
    }

    /**
     * Get all active items sorted by order
     *
     * @return array
     */
    public function getAllActiveSortedByOrder(): array
    {
        return $this->sortByOrder($this->getAllActive()) ?: [];
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
