<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string $name
 * @property string $surname
 * @property string $email
 * @property string $phone
 * @property integer $source_id
 * @property integer $balance
 * @property integer $manager_id
 * @property string $birth_date
 * @property-read string dateOfBirthCarbon
 */
class Client extends Model
{
    use HasFactory, SoftDeletes;

    private string $carbonDate = '';

    public const MONTH = [
        'Jan', 'Feb', 'Mar',
        ' Apr', 'May', 'Jun',
        'Jul', 'Aug', 'Sep',
        'Oct', 'Nov', 'Dec'
    ];

    protected $softDelete = true;

    protected $fillable = [
        'name',
        'surname',
        'email',
        'phone',
        'deleted_at',
        'source_id',
        'manager_id',
        'balance',
        'birth_date'
    ];


    /**
     * Возращаем всех менеджеров клиента
     *
     * @return belongsTo
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

    /**
     * @return string
     */
    public function getDateOfBirthCarbonAttribute(): string
    {
        $birthDate = explode('-', $this->birth_date);
        $this->carbonDate = $birthDate[2] . ' ' . self::MONTH[--$birthDate[1]] . ' ' . $birthDate[0];

        return $this->carbonDate;
    }
}
