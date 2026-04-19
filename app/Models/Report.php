<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
class Report extends Model 
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'user_id',
        'reporter_name',
        'reporter_email',
        'reporter_phone',
        'issue_type',
        'description',
        'location',
        'latitude',
        'longitude',
        'status',
        'image_path',
        'verified_by',
        'verified_at',
        'assigned_to',
        'assigned_at',
        'proof_image',
        'resolved_at',
        'parent_id',
        'proof_remarks',
        'proof_latitude',
        'proof_longitude',
    ];

    protected $casts = [
        'verified_at' => 'datetime',
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
        'assigned_at' => 'datetime',
    ];
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['status', 'assigned_to', 'issue_type', 'location'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn(string $eventName) => "Report {$eventName}");
    }
    // Relationship: Report belongs to a user (nullable for guests)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship: Report verified by an officer/admin
    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    // Helper: Get reporter name (from user or guest field)
    public function getReporterNameAttribute()
    {
        return $this->user ? $this->user->first_name . ' ' . $this->user->last_name : $this->attributes['reporter_name'];
    }

    // Helper: Get reporter email (from user or guest field)
    public function getReporterEmailAttribute()
    {
        return $this->user ? $this->user->email : $this->attributes['reporter_email'];
    }
    public function assignedEnforcer(){
        
    return $this->belongsTo(User::class, 'assigned_to');
    }

    public function parent()
    {
        return $this->belongsTo(Report::class, 'parent_id');
    }

    public function duplicates()
    {
        return $this->hasMany(Report::class, 'parent_id');
    }

    public function getAllReportersCountAttribute()
    {
        return $this->duplicates->count() + 1;
    }

    /**
     * Scope a query to filter reports.
     */
    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('location', 'like', '%' . $search . '%')
                    ->orWhere('issue_type', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%')
                    ->orWhere('reporter_name', 'like', '%' . $search . '%')
                    ->orWhereHas('user', function ($query) use ($search) {
                        $query->where('first_name', 'like', '%' . $search . '%')
                            ->orWhere('last_name', 'like', '%' . $search . '%')
                            ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ['%' . $search . '%']);
                    });
            });
        });

        $query->when($filters['status'] ?? null, function ($query, $status) {
            if ($status !== 'all') {
                $query->where('status', $status);
            }
        });

        $query->when($filters['issue_type'] ?? null, function ($query, $issueType) {
            if ($issueType !== 'all') {
                $query->where('issue_type', $issueType);
            }
        });
    }

    /**
     * Centralized logic to find a potential duplicate parent report.
     */
    public static function findDuplicate($issueType, $lat, $lng, $radiusMeters = 50, $hoursBack = 12)
    {
        $potentialParents = self::where('issue_type', $issueType)
            ->whereNull('parent_id')
            ->whereNotIn('status', ['resolved', 'rejected'])
            ->where('created_at', '>=', now()->subHours($hoursBack))
            ->get();

        foreach ($potentialParents as $parent) {
            $distance = self::calculateDistance($lat, $lng, $parent->latitude, $parent->longitude);
            if ($distance <= $radiusMeters) {
                return $parent;
            }
        }

        return null;
    }

    public static function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000; // meters
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        return $earthRadius * $c;
    }
}