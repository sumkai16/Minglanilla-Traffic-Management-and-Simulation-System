<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrafficAdvisory extends Model
{
    //
    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'status',
        'map_data',
        'created_by',
    ];

    protected $casts = [
        'map_data' => 'array',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
