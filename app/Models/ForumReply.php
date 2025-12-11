<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumReply extends Model
{
    use HasFactory;

    protected $fillable = ['post_id', 'user_id', 'reply_text'];

    /**
     * Get the post that this reply belongs to.
     */
    public function post()
    {
        return $this->belongsTo(ForumPost::class, 'post_id');
    }

    /**
     * Get the user who created the reply.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
