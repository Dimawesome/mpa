<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class VideoCard extends Module
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'module_video_card';

    /**
     * @var Page
     */
    protected Page $page;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'page_id',
        'module_name',
        'video_url',
        'video_autoplay',
        'text',
        'width',
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
     * Get validation rules.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'module_name' => 'max:100',
            'module' => 'required',
            'video_url' => [
                'required',
                'regex:/^(?:https?:\/\/)?(?:www\.)?youtube\.com\/watch\?(?=.*v=((\w|-){11}))(?:\S+)?$/'
            ],
            'text' => 'required',
            'width' => 'required',
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
            $uid = uniqid('', false);
            while ((new VideoCard)->where('uid', '=', $uid)->count() > 0) {
                $uid = uniqid('', false);
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
        }, ['youtube_url' => $this->getYouTubeUrl($model->video_url, $model->video_autoplay)]);
    }

    /**
     * Insert or update records
     *
     * @param array $post
     * @return void
     */
    public function saveAdditionalRecords(array $post): void
    {
        $this->video_autoplay = $post['video_autoplay'] ?? 0;

        $this->save();
    }

    /**
     * Get youtube url
     *
     * @param string|null $url
     * @param string|null $autoplay
     * @return string
     */
    public function getYouTubeUrl(?string $url, ?string $autoplay): string
    {
        preg_match(
            '/(https:|http:|):(\/\/www\.|\/\/|)(.*?)\/(embed\/|watch.*?v=|)([a-z_A-Z0-9\-]{11})/i',
            $url,
            $vid
        );

        return $url
            ? 'https://www.youtube.com/embed/' . $vid[5] . "?autoplay=$autoplay&hl=lt&mute=$autoplay"
            : '';
    }
}
