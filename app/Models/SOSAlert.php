<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SOSAlert extends Model
{
    use HasFactory;
    
    // এই লাইনগুলো খুবই জরুরি
    protected $table = 'sos_alerts';
    protected $fillable = ['user_id', 'latitude', 'longitude', 'status', 'message'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}