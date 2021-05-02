<?php

namespace App\Models;

use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Http\Request;

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
     * Items per page
     *
     * @var int
     */
    public static int $itemsPerPage = 25;

    /**
     * The attributes that are mass assignable
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'is_active',
        'is_deleted'
    ];

    /**
     * @var array
     */
    public $timestamps = [
        'created_at',
        'updated_at'
    ];

    /**
     * Get validation rules
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'title' => 'required|max:30',
            'page_name' => 'regex:/^\S*$/u'
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
            while (Page::where('uid', '=', $uid)->count() > 0) {
                $uid = uniqid();
            }
            $item->uid = $uid;
        });
    }


    /**
     * Get all active items
     *
     * @return array
     */
    public function getAllActiveNotDeleted(): array
    {
        return $this->select('*')
            ->where('is_active', '=', 1)
            ->where('is_deleted', '=', 0)
            ->get()
            ->toArray();
    }

    /**
     * Search items
     *
     * @param Request $request
     * @param bool $isDeleted
     * @return EloquentBuilder
     */
    public function search(Request $request, bool $isDeleted = false): EloquentBuilder
    {
        $query = $this->filter($request)
            ->where('is_deleted', '=', $isDeleted)
            ->where('title', '!=', null);

        if (!empty($request->sort_order)) {
            $query = $query->orderBy($request->sort_order, $request->sort_direction);
        }

        return $query;
    }

    /**
     * Filter items
     *
     * @param Request $request
     * @return EloquentBuilder
     */
    public function filter(Request $request): EloquentBuilder
    {
        $query = $this->select('pages.*');

        if (!empty(trim($request->keyword))) {
            foreach (explode(' ', trim($request->keyword)) as $keyword) {
                $query = $query->where(function ($q) use ($keyword) {
                    $q->orwhere('pages.title', 'like', "%$keyword%");
                });
            }
        }

        return $query;
    }

    /**
     * Delete all items where is_deleted is 1
     *
     * @return void
     * @throws Exception
     */
    public function deleteAll(): void
    {
        $this->where('is_deleted', '=', 1)->delete();
    }

    /**
     * Get page view
     *
     * @param array $modules
     * @param string $template
     * @return Application|Factory|View
     */
    public function getPage($page, array $modules, $menu, string $template = 'dashboard._page', bool $preview = false)
    {
        return \view($template, [
            'page' => $page,
            'menu' => $menu,
            'modules' => $modules,
            'preview' => $preview
        ]);
    }
}
