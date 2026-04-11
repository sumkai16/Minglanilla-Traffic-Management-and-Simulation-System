<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
class TrafficAdvisory extends Model
{
    //
    use LogsActivity;
  protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'status',
        'map_data',
        'created_by',
        'expires_at',
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
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['title', 'status', 'start_date', 'end_date', 'expires_at'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn(string $eventName) => "Advisory {$eventName}");
    }
}
