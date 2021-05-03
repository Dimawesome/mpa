<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Card
 *
 * @package App\Models
 */
class Card extends Module
{
    use HasFactory;

    public const PAGE_TYPE = 'page',
        EXTERNAL_TYPE = 'external';

    /**
     * @var string
     */
    protected $table = 'module_card';

    /**
     * @var Page
     */
    protected Page $page;

    /**
     * Card constructor.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->page = new Page();

        parent::__construct($attributes);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'page_id',
        'module_name',
        'title',
        'url',
        'url_type',
        'text',
        'width',
        'align',
        'order',
        'is_active'
    ];

    /**
     * @var array
     */
    public $timestamps = [
        'created_at',
        'updated_at'
    ];

    /**
     * Get validation rules.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'module_name' => 'max:100',
            'title' => 'max:200',
            'module' => 'required',
            'text' => 'required|max:400',
            'width' => 'required',
            'align' => 'required',
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
     * Get file module files
     *
     * @param $model
     * @return array
     */
    public function getAdditionalData($model): array
    {
        return array_map(static function ($object) {
            return (array)$object;
        }, $this->getActivePageList($this->page->getAllActiveNotDeleted(), $this->uid));
    }

    /**
     * Insert or update records
     *
     * @param array $post
     * @return void
     */
    public function saveAdditionalRecords(array $post): void
    {
        if (isset($post['page']) && $post['page']) {
            $this->url = $this->createPageUrl($this->page->findByUid($post['page']));
        } elseif (isset($post['external']) && $post['external']) {
            $this->url = $post['external'];
        } else {
            $this->url = null;
        }

        $this->save();
    }
}
