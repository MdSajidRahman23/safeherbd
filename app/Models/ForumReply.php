<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForumReply extends Model
{
protected $fillable = ['post_id','user_id','reply_text'];


public function post(){
return $this->belongsTo(ForumPost::class, 'post_id');
}


public function user(){
return $this->belongsTo(User::class);
}
}