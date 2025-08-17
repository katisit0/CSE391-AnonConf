<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mood extends Model
{
    use HasFactory;

    protected $table = 'moods';
    protected $fillable = ['name'];
    public $timestamps = true;

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function confessions()
    {
        return $this->hasMany(Confession::class, 'mood_id')->orderBy('created_at', 'desc');
    }
}
