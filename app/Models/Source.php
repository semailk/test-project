<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
     * @return BelongsTo
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Извлекаем названия ресурса
     *
     * @param $id
     * @return mixed
     */
    public static function getSourceTitle($id): string
    {
        $title = Source::query()
            ->where('id', $id)
            ->get()->all()[0]->title;
        return $title;
    }
}
