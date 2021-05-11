<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Text
 *
 * @package App\Models
 */
class Text extends Module
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'module_text';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'module_name',
        'text',
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
            'module' => 'required',
            'text' => 'required'
        ];
    }

    /**
     * Bootstrap any application services
     */
    public static function boot(): void
    {
        parent::boot();
        // Create uid when creating item.
        static::creating(function ($item) {
            // Create new uid
            $uid = uniqid('', false);
            while ((new Text)->where('uid', '=', $uid)->count() > 0) {
                $uid = uniqid('', false);
            }
            $item->uid = $uid;
        });
    }
}
