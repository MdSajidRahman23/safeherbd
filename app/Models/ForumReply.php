<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForumReply extends Model
{
    protected $fillable = ['post_id', 'user_id', 'reply_text'];

<<<<<<< HEAD
    /**
     * Get the post that this reply belongs to.
     */
=======
    // Reply belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

>>>>>>> 31412428283c9ee6d9665e14eec9f32776b0261c
    public function post()
    {
        // Explicitly define the foreign key 'post_id'
        return $this->belongsTo(ForumPost::class, 'post_id');
    }
<<<<<<< HEAD

    /**
     * Get the user who created the reply.
     */
    public function user()
    {
        // Laravel assumes 'user_id' as the foreign key
        return $this->belongsTo(User::class);
    }
}
=======
}
>>>>>>> 31412428283c9ee6d9665e14eec9f32776b0261c
