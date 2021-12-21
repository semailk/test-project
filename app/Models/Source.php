<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string $title
 */
class Source extends Model
{
    use HasFactory;

    protected $fillable = [
        'title'
    ];

    /**
     * Возвращаем Клиента
     *
     * @return HasMany
     */
    public function client(): HasMany
    {
        return $this->hasMany(Client::class);
    }

}
