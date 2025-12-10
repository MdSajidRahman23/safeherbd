<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class SosAlert extends Model
{
    use HasFactory;

    protected $table = 'sos_alerts';

    protected $fillable = [
        'user_id',
        'latitude',
        'longitude',
        'message',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}