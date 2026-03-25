<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{

    use HasFactory, Notifiable;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
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



        public function reports()
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

    public function assignedReports()
    {
        return $this->hasMany(Report::class, 'assigned_to');
    }
   
}