<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string $name
 * @property string $surname
 * @property string $email
 * @property string $phone
 */
class Client extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'surname',
        'email',
        'phone'
    ];

    /**
     * Возвращаем откуда пришёл Клиент
     *
     * @return HasOne
     */
    public function source(): HasOne
    {
        return $this->hasOne(Source::class);
    }

    /**
     * Возращаем всех менеджеров клиента
     *
     * @return BelongsToMany
     */
    public function managers(): BelongsToMany
    {
        return $this->belongsToMany(Manager::class)->withPivot('fee')->as('fee');
    }
}
