<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

/**
 * Class User
 *
 * @package App\Models
 * @mixin EloquentBuilder
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'surname',
        'username',
        'email',
        'password',
        'last_login_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password'
    ];

    /**
     * @var array
     */
    public $timestamps = [
        'created_at',
        'updated_at'
    ];

    /**
     * User form rules
     *
     * @return array
     */
    public function rules():array
    {
        return [
            'username' => 'required',
            'password' => 'required'
        ];
    }
}
