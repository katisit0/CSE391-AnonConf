<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    
    protected $fillable = [
        'content',        
        'confession_id',  
        'user_id',        
        'parent_id',      
    ];

    // Parent comment (for threaded comments)
    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    // Replies to the comment (for threaded comments)
    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    
    public function confession()
    {
        return $this->belongsTo(Confession::class);
    }

    public function reports()
    {
        return $this->hasMany(CommentReport::class);
    }
}
