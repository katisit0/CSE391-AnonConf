<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Confession extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'content', 'mood_id', 'user_id', 'upvotes', 'reports', 'created_at'
    ];

    protected $dates = ['deleted_at'];

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function mood()
    {
        return $this->belongsTo(Mood::class);
    }

    public function upvotes()
    {
        return $this->hasMany(ConfessionUpvote::class);
    }

    public function reports()
    {
        return $this->hasMany(\App\Models\ConfessionReport::class, 'confession_id');
    }

    public function isActive()
    {
        return $this->created_at->diffInHours(now()) < 24;
    }
}