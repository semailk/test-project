<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $date
 * @property integer $value
 * @property integer $client_id
 */
class Deposit extends Model
{
    use HasFactory;

    protected $fillable = [
      'date',
      'value',
      'client_id'
    ];

    /**
     * @return BelongsTo
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
}
