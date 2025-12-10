<?php

namespace App\Models;

use App\Models\ForumPost; // Assuming this model exists
use Illuminate\Database\Eloquent\Model;

class ForumReport extends Model
{
<<<<<<< HEAD
    // Keeping the most complete list of fillable attributes
    protected $fillable = ['post_id', 'forumreporter_id', 'reason', 'status'];
=======
    protected $fillable = ['post_id', 'user_id', 'reason'];
>>>>>>> 31412428283c9ee6d9665e14eec9f32776b0261c

    /**
     * Get the forum post that was reported.
     */
    public function post()
    {
        return $this->belongsTo(ForumPost::class, 'post_id');
    }

    /**
     * Get the user who filed the report (using the specific 'forumreporter_id' column).
     */
    public function forumreporter()
    {
<<<<<<< HEAD
        return $this->belongsTo(User::class, 'forumreporter_id');
    }
}
=======
        return $this->belongsTo(User::class, 'user_id');
    }
}
>>>>>>> 31412428283c9ee6d9665e14eec9f32776b0261c
