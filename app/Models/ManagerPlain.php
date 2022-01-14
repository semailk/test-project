<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

class ManagerPlain extends Model
{
    use HasFactory;

    protected $fillable = [
        'plain',
        'date',
        'manager_id'
    ];


    protected $dates = [
        'date'
    ];

    /**
     * @return BelongsTo
     */
    public function manager(): BelongsTo
    {
        return $this->belongsTo(Manager::class);
    }


    public function getCheckQuarterAttribute()
    {
        if (Carbon::create($this->date->toDateTimeString())->quarter === Carbon::now()->quarter
            &&
            $this->date->year === Carbon::now()->year) {
            return $this;
        }
    }
}
