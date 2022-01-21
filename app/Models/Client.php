<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string $name
 * @property string $surname
 * @property string $email
 * @property string $phone
 * @property integer $source_id
 * @property integer $balance
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
        'source_id',
        'manager_id',
        'balance'
    ];


    /**
     * Возращаем всех менеджеров клиента
     *
     * @return belongsToMany
     */
    public function manager(): belongsTo
    {
        return $this->belongsTo(Manager::class);
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


    /**
     * @return HasMany
     */
    public function deposits(): HasMany
    {
        return $this->hasMany(Deposit::class)->orderByDesc('created_at');
    }

    /**
     * @return HasMany
     */
    public function depositsSum(): HasMany
    {
        return $this->hasMany(Deposit::class)->sum('value');
    }

    public function getDepositsSumAttribute()
    {
        return $this->deposits->sum('value');
    }

    /**
     * @return HasMany
     */
    public function certificates(): HasMany
    {
        return $this->hasMany(Certificate::class);
    }


    /**
     * @return int
     */
    public function certificatesSum(): int
    {
        return $this->hasMany(Certificate::class)
            ->whereNull('canceled_at')
            ->sum('shares');
    }
}
