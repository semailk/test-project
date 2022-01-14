<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string $name
 * @property string $surname
 * @property float $salary
 */
class Manager extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'surname',
        'salary',
    ];

    /**
     * Возращаем всех клиектов менеджера
     *
     * @return HasMany
     */
    public function clients(): HasMany
    {
        return $this->hasMany(Client::class);
    }

    /**
     * @return HasMany
     */
    public function managerPlains(): HasMany
    {
        return $this->hasMany(ManagerPlain::class);
    }

    /**
     * @param Manager $manager
     * @return string
     */
    public static function getFullName(Manager $manager): string
    {
        return $manager->name . ' ' . $manager->surname;
    }

    /**
     * Возвращаем сумму депозитов клиентов-менеджера
     *
     * @return float|int
     */
    public function getClientsSumDepositsAttribute()
    {
        $result = $this->clients()->with('deposits')->get()->map(function (Client $client) {
            return $client->deposits->sum('value');
        });

        return array_sum($result->toArray());
    }
}
