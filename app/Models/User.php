<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class User extends Authenticatable
{

    use HasFactory, Notifiable, LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['first_name', 'last_name', 'email', 'role'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn(string $eventName) => "User has been {$eventName}");
    }

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'profile_image',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }



    public function reports(): HasMany
    {
        return $this->hasMany(Report::class);
    }

    // Add these helper methods:
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isEnforcer()
    {
        return $this->role === 'enforcer';
    }

    public function isHeadMitcom()
    {
        return $this->role === 'head-mitcom';
    }

    public function isUser()
    {
        return $this->role === 'user';
    }

    public function assignedReports(): HasMany
    {
        return $this->hasMany(Report::class, 'assigned_to');
    }

    public function announcements(): HasMany
    {
        return $this->hasMany(Announcement::class, 'created_by');
    }
}
