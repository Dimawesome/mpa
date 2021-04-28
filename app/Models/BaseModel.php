<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class BaseModel
 *
 * @package App\Models
 * @mixin EloquentBuilder
 */
class BaseModel extends Model
{
    use HasFactory;

    /**
     * Get all items
     *
     * @return BaseModel[]|Collection
     */
    public function getAll()
    {
        return $this->select('*')->get();
    }

    /**
     * Get all items by order
     *
     * @return Collection
     */
    public function getAllSortedByOrder(): Collection
    {
        return $this->getAll()->sortBy('order');
    }

    /**
     * Find item by uid.
     *
     * @param string $uid
     * @return BaseModel|Model|object|null
     */
    public function findByUid(string $uid)
    {
        return $this->where('uid', '=', $uid)->first();
    }

    /**
     * Set item active parameter to 0
     *
     * @return void
     */
    public function disable(): void
    {
        $this->update([
            'is_active' => 0
        ]);
    }

    /**
     * Set item active parameter to 1
     *
     * @return void
     */
    public function enable(): void
    {
        $this->update([
            'is_active' => 1
        ]);
    }
}
