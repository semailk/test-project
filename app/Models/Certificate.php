<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer $client_id
 * @property integer $number
 * @property string $name
 * @property integer $shares
 * @property integer $canceled_shares
 * @property string $canceled_at
 */
class Certificate extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'client_id',
        'number',
        'name',
        'shares',
        'canceled_shares',
        'canceled_at'
    ];

    /**
     * @return BelongsTo
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
}
