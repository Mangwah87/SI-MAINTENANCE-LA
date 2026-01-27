<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BatteryReading extends Model
{
    protected $fillable = [
        'battery_maintenance_id',
        'bank_number',
        'battery_brand',
        'battery_number',
        'voltage',
        'photo_path',
        'photo_latitude',
        'photo_longitude',
        'photo_timestamp',
        'soh',
        'battery_brand',
        'battery_type',
        'end_device_batt',
    ];

    protected $casts = [
        'voltage' => 'decimal:2',
        'photo_latitude' => 'decimal:8',
        'photo_longitude' => 'decimal:8',
        'photo_timestamp' => 'datetime',
    ];

    public function maintenance()
    {
        return $this->belongsTo(BatteryMaintenance::class, 'battery_maintenance_id');
    }
}
