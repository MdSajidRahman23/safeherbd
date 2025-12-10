<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForumReport extends Model
{
protected $fillable = ['post_id','forumreporter_id','reason','status'];


public function post(){
return $this->belongsTo(ForumPost::class, 'post_id');
}


public function forumreporter(){
return $this->belongsTo(User::class, 'forumreporter_id');
}
}