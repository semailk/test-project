<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
        'plain'
    ];

    protected $casts = [
      'plain' => 'array'
    ];
    /**
     * Возращаем всех клиектов менеджера
     *
     * @return BelongsToMany
     */
    public function clients(): BelongsToMany
    {
        return $this->belongsToMany(Client::class)->withPivot('fee')->as('fee');
    }

    /**
     * @param Manager $manager
     * @return string
     */
    public static function getFullName(Manager $manager): string
    {
        return $manager->name . ' ' . $manager->surname;
    }
}
