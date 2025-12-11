<?php

namespace App\Models;

use App\Models\ForumReply;
use App\Models\ForumReport; // Make sure to add this use statement if ForumReport exists
use Illuminate\Database\Eloquent\Model;

class ForumPost extends Model
{
<<<<<<< HEAD
    // Attributes that are mass assignable
    protected $fillable = ['title', 'body', 'user_id'];

    /**
     * Get the user that owns the forum post.
     */
=======
    protected $fillable = ['title', 'body', 'user_id'];

>>>>>>> 31412428283c9ee6d9665e14eec9f32776b0261c
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the replies for the forum post.
     */
    public function replies()
    {
        return $this->hasMany(ForumReply::class, 'post_id');
    }
<<<<<<< HEAD

    /**
     * Get the reports filed against the forum post.
     */
    public function forumreports()
    {
        return $this->hasMany(ForumReport::class, 'post_id');
    }
}

=======

    public function forumreports()
    {
        return $this->hasMany(ForumReport::class, 'post_id');
    }
}
>>>>>>> 31412428283c9ee6d9665e14eec9f32776b0261c
