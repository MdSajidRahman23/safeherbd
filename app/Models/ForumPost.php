<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForumPost extends Model
{
<<<<<<< HEAD
protected $fillable = ['title','body','user_id'];


public function user(){
return $this->belongsTo(User::class);
}


public function replies(){
return $this->hasMany(ForumReply::class, 'post_id');
}


public function forumreports(){
return $this->hasMany(ForumReport::class, 'post_id');
}
}
=======
    protected $fillable = ['title', 'body', 'user_id'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function replies()
    {
        return $this->hasMany(ForumReply::class, 'post_id');
    }
}

>>>>>>> b0cb2efddad894b83ece0451a04ec967047a9524
