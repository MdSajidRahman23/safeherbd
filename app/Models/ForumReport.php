<?php

namespace App\Models;

use App\Models\ForumPost; // Assuming this model exists
use Illuminate\Database\Eloquent\Model;

class ForumReport extends Model
{
    // Keeping the most complete list of fillable attributes
    protected $fillable = ['post_id', 'forumreporter_id', 'reason', 'status'];

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
        return $this->belongsTo(User::class, 'forumreporter_id');
    }
}