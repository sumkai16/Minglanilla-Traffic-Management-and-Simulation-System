<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EnforcerStation extends Model
{
    //
    protected $fillable = [
        'enforcer_id',
        'label',
        'latitude',
        'longitude',
        'assigned_at',
        'expires_at',
        'notes',
        'is_active',
    ];
    protected $casts = [
    'assigned_at' => 'date',
    'expires_at' => 'date',
    'is_active' => 'boolean',
    ];

    public function enforcer(){
        return $this->belongsTo(User::class, 'enforcer_id');
    }
    public function isExpired(): bool
    {
        return $this->expires_at->isPast();
    }
}
