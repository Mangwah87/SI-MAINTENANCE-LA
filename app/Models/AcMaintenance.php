<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcMaintenance extends Model
{
    use HasFactory;

    protected $table = 'maintenance_ac';

    /**
     * The attributes that are mass assignable.
     * FIXED: Updated field names to match database
     */
    protected $fillable = [
        'user_id',

        // Informasi Lokasi dan Perangkat
        'location',
        'date_time',
        'brand_type',
        'capacity',
        'reg_number',
        'sn',

        // 1. Visual Check
        'environment_condition',
        'status_environment_condition',
        'filter',
        'status_filter',
        'evaporator',
        'status_evaporator',
        'led_display',
        'status_led_display',
        'air_flow',
        'status_air_flow',

        // 2. Room Temperature - FIXED: Removed _odc suffix
        'temp_shelter',
        'status_temp_shelter',
        'temp_outdoor_cabinet',
        'status_temp_outdoor_cabinet',

        // 3. Input Current Air Cond
        'ac1_current',
        'status_ac1',
        'ac2_current',
        'status_ac2',
        'ac3_current',
        'status_ac3',
        'ac4_current',
        'status_ac4',
        'ac5_current',
        'status_ac5',
        'ac6_current',
        'status_ac6',
        'ac7_current',
        'status_ac7',

        // Notes
        'notes',

        // Personnel
        'executor_1',
        'executor_2',
        'executor_3',
        'supervisor',
        'supervisor_id_number',
        'department',
        'sub_department',

        // Images
        'images',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'date_time' => 'datetime',
        'images' => 'array',  // Cast JSON to array automatically
        'temp_shelter' => 'decimal:2',
        'temp_outdoor_cabinet' => 'decimal:2',
        'ac1_current' => 'decimal:2',
        'ac2_current' => 'decimal:2',
        'ac3_current' => 'decimal:2',
        'ac4_current' => 'decimal:2',
        'ac5_current' => 'decimal:2',
        'ac6_current' => 'decimal:2',
        'ac7_current' => 'decimal:2',
    ];

    /**
     * The attributes that should be mutated to dates.
     */
    protected $dates = [
        'date_time',
        'created_at',
        'updated_at',
    ];

    /**
     * Get the user that owns the maintenance record.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
