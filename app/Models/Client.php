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
    protected $softDelete = true;

    protected $fillable = [
        'name',
        'surname',
        'email',
        'phone',
        'deleted_at'
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
    public static function getFullName(Client $client): string
    {
        return $client->name . ' ' . $client->surname;
    }
}
