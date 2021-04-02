<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class MenuItem
 *
 * @package App\Models
 * @mixix EloquentBuilder
 */
class MenuItem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'creator_id',
        'type',
        'name',
        'url',
        'order',
        'status',
        'target',
        'language'
    ];

    /**
     * Get validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required'
        ];
    }

    /**
     * Rel to model.
     *
     * @return BelongsTo
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    /**
     * Bootstrap any application services.
     */
    public static function boot()
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
     * Get all menu elements
     *
     * @return mixed
     */
    public function getAll()
    {
        return $this->select('*')->get()->toArray();
    }






    /**
     * Find item by uid.
     *
     * @param $uid
     * @return mixed
     */
    public function findByUid($uid)
    {
        return $this->where('uid', '=', $uid)->first();
    }

    /**
     * Disable event.
     */
    public function disable()
    {
        $this->status = 'inactive';
        $this->save();
    }

    /**
     * Enable event.
     */
    public function enable()
    {
        $this->status = 'active';
        $this->save();
    }

    /**
     * Get allowed role list
     *
     * @param string $uid
     * @return array|Application|Translator|string|null
     */
    public static function getAllowedRoleList(string $uid)
    {
        $roles = self::select('visible_to')
            ->where('uid', '=', $uid)
            ->get()->first();

        return Role::getRoleList($roles);
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

        while($child) {
            array_unshift($tree, $child->name);

            $child = $child->parent;
        }

        return $tree;
    }

    /**
     * Get all active page list
     *
     * @param string $uid
     * @return array
     */
    public static function getActivePageList(string $uid): array
    {
        $pages = Page::getAllActive();
        $options = [];

        foreach ($pages->all() as $page) {
            $roles = Role::getRoleList($page);
            $name = (Lang::has("app.{$page->title}") && $page->is_default) ? trans("app.{$page->title}") : $page->title;
            $options[] = [
                'value' => $page->uid,
                'text' => "$name ($roles)"
            ];
        }

        $data['values'] = self::getSelectedPages($uid);
        $data['options'] = $options;

        return $data;
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
}
