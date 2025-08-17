<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConfessionUpvote extends Model
{
    protected $fillable = [
        'confession_id',
        'user_id',
        'ip_address'
    ];

    public function confession()
    {
        return $this->belongsTo(Confession::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}