<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Schema\Builder;
use Illuminate\Support\Collection;

/**
 * @property integer $client_id
 * @property integer $number
 * @property string $name
 * @property integer $shares
 * @property integer $canceled_shares
 * @property string $canceled_at
 * @property string $uuid
 * @method Collection where()
 */
class Certificate extends Model
{
    use HasFactory, SoftDeletes, Uuids;

    protected $fillable = [
        'client_id',
        'number',
        'name',
        'shares',
        'canceled_shares',
        'canceled_at',
        'uuid'
    ];

    /**
     * @return BelongsTo
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * @return string
     */
    public function getKeyName(): string
    {
        return 'uuid';
    }
}
