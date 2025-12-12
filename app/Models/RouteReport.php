<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RouteReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'safe_route_id',
        'user_id',
        'incident_type',
        'message',
        'location',
        'status',
    ];

    protected $casts = [
        'location' => 'array',
    ];

    /**
     * Get the safe route that this report is about.
     */
    public function safeRoute()
    {
        return $this->belongsTo(SafeRoute::class);
    }

    /**
     * Get the user who submitted this report.
     */
    public function reporter()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Scope to get reports by status.
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope to get reports by incident type.
     */
    public function scopeByIncidentType($query, $type)
    {
        return $query->where('incident_type', $type);
    }
}
