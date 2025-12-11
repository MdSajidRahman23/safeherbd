<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumReport extends Model
{
    use HasFactory;

    protected $fillable = ['post_id', 'user_id', 'reason', 'status'];

    /**
     * Get the forum post that was reported.
     */
    public function post()
    {
        return $this->belongsTo(ForumPost::class, 'post_id');
    }

    /**
     * Get the user who filed the report.
     */
    public function reporter()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
