<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

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
    ];

    protected $casts = [
        'verified_at' => 'datetime',
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
        'assigned_at' => 'datetime',
    ];

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
    
}