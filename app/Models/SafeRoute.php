<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SafeRoute extends Model
{
    use HasFactory;

    protected $fillable = [
        'route_name',
        'coordinates_json',
        'total_score',
        'created_by',
    ];

    protected $casts = [
        'coordinates_json' => 'array',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}