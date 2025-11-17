<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BatteryMaintenance extends Model
{
    use HasFactory;

    protected $fillable = [
        'doc_number',
        'location',
        'maintenance_date',
        'battery_temperature',
        'notes',
        'company',
        'user_id',
        'technician_name',
        'technician_1_name',
        'technician_1_company',
        'technician_2_name',
        'technician_2_company',
        'technician_3_name',
        'technician_3_company',
        'supervisor',
        'supervisor_id',
    ];

    protected $casts = [
        'maintenance_date' => 'datetime',
        'battery_temperature' => 'decimal:1',
    ];

    public function readings()
    {
        return $this->hasMany(BatteryReading::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Auto-generate doc_number
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->doc_number)) {
                $model->doc_number = 'BAT-' . date('Ymd') . '-' . str_pad(
                    static::whereDate('created_at', today())->count() + 1,
                    4,
                    '0',
                    STR_PAD_LEFT
                );
            }
        });
    }
    public function central()
{
    return $this->belongsTo(Central::class, 'location', 'id');
}

// Accessor untuk mendapatkan nama lengkap
public function getLocationNameAttribute()
{
    return $this->central
        ? "{$this->central->id_sentral} - {$this->central->nama}"
        : 'Unknown Location';
}
}
