<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

/**
 * Class File
 *
 * @package App\Models
 */
class File extends Module
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'module_file';

    /**
     * @var string
     */
    protected string $filesTableName = 'module_file_has_files';

    /**
     * @var Builder
     */
    protected Builder $filesTable;

    /**
     * File constructor
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->filesTable = DB::table($this->filesTableName);

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
        'order',
        'is_active',
        'open'
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
            'module' => 'required',
            'filename_*' => 'required',
            'width_*' => 'required',
            'open_*' => 'required',
            'url_*' => 'required'
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
     * Get formatted files array
     *
     * @param array $post
     * @param string $key
     * @param int $order
     * @param string $modelFileId
     * @return array
     */
    public function getFilesFormattedArray(array $post, string $key, int $order, string $modelFileId): array
    {
        $url = str_replace('?open=1', '', $post["url_$key"]);

        return [
            'name' => $post["filename_$key"],
            'url' => $post["open_$key"]
                ? "$url?open=1"
                : $url,
            'width' => $post["width_$key"],
            'open' => $post["open_$key"],
            'order' => $order,
            'module_file_id' => $modelFileId
        ];
    }

    /**
     * Insert or update records
     *
     * @param array $post
     */
    public function saveAdditionalRecords(array $post): void
    {
        $order = 0;

        $this->removeDeletedFiles($post, $this->id);

        if (!empty($post['keys'])) {
            foreach ($post['keys'] as $key) {
                DB::table($this->filesTableName)->updateOrInsert(
                    ['id' => $post["id_$key"]],
                    $this->getFilesFormattedArray($post, $key, $order, $this->id)
                );

                ++$order;
            }
        }
    }

    /**
     * Remove deleted files
     *
     * @param array $post
     * @param string $modelFileId
     */
    public function removeDeletedFiles(array $post, string $modelFileId): void
    {
        $formIds = [];
        $dbIds = DB::table($this->filesTableName)->select('id')
            ->where('module_file_id', '=', $modelFileId)
            ->get()->pluck('id')->toArray();

        if (!empty($post['keys'])) {
            foreach ($post['keys'] as $key) {
                $formIds[] = (int)$post["id_$key"];
            }
        }

        DB::table($this->filesTableName)
            ->where('module_file_id', '=', $modelFileId)
            ->whereIn('id', array_diff($dbIds, $formIds))
            ->delete();
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
        }, DB::table($this->filesTableName)->select('*')
            ->where('module_file_id', '=', $model->id)
            ->orderBy('order')->get()->toArray()
        );
    }
}
