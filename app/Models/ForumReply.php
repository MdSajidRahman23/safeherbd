<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForumReply extends Model
{
    protected $fillable = ['post_id', 'user_id', 'reply_text'];

    /**
     * Get the post that this reply belongs to.
     */
    public function post()
    {
        // Explicitly define the foreign key 'post_id'
        return $this->belongsTo(ForumPost::class, 'post_id');
    }

    /**
     * Get the user who created the reply.
     */
    public function user()
    {
        // Laravel assumes 'user_id' as the foreign key
        return $this->belongsTo(User::class);
    }
}