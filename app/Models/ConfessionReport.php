<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConfessionReport extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'confession_id',
        'ip_address',
        'reason'
    ];

    /**
     * Get the confession that was reported.
     */
    public function confession()
    {
        return $this->belongsTo(Confession::class);
    }
}