<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SafeRoute extends Model
{
    use HasFactory;


    protected $fillable = [
        'route_name',
        'coordinates',
        'total_score',
        'theft_count',
        'robbery_count',
        'kidnapping_count',
        'is_active',
        'created_by',
    ];

    protected $casts = [
        'coordinates' => 'array',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}