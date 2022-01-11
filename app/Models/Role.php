<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Arr;

/** @property string $title */
class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'title'
    ];

    /**
     * @return HasOne
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }

    /**
     * @param string $role
     * @return int
     */
    public static function getRoleId(string $role): int
    {
        $id = Role::where('name', $role)->first()->id;
        return $id;
    }
}
