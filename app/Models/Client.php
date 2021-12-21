<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string $name
 * @property string $surname
 * @property string $email
 * @property string $phone
 * @property integer $source_id
 */
class Client extends Model
{
    use HasFactory, SoftDeletes;
    protected $softDelete = true;

    protected $fillable = [
        'name',
        'surname',
        'email',
        'phone',
        'deleted_at',
        'source_id'
    ];


    /**
     * Возращаем всех менеджеров клиента
     *
     * @return BelongsToMany
     */
    public function managers(): BelongsToMany
    {
        return $this->belongsToMany(Manager::class)->withPivot('fee')->as('fee');
    }

    /**
     * Возращаем полное имя клиента
     *
     * @param Client $client
     * @return string
     */
    public function getFullNameAttribute(): string
    {
        return $this->name . ' ' . $this->surname;
    }

    /**
     * @return BelongsTo
     */
    public function source(): BelongsTo
    {
        return $this->belongsTo(Source::class);
    }
}
