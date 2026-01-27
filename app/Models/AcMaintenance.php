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
        'central_id',
        'date_time',
        'brand_type',
        'capacity',
        'reg_number',
        'sn',

        // 1. Physical Check
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

        // 2. PSI Pressure
        'psi_pressure',
        'status_psi_pressure',

        // 3. Input Current Air Cond
        'input_current_ac',
        'status_input_current_ac',

        // 4. Output Temperature AC
        'output_temperature_ac',
        'status_output_temperature_ac',

        // Notes
        'notes',

        // Personnel
        'executor_1',
        'mitra_internal_1',
        'executor_2',
        'mitra_internal_2',
        'executor_3',
        'mitra_internal_3',
        'executor_4',
        'mitra_internal_4',

        // Mengetahui
        'verifikator',
        'verifikator_nik',
        'head_of_sub_department',
        'head_of_sub_department_nik',

        // Images
        'images',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'date_time' => 'datetime',
        'images' => 'array',  // Cast JSON to array automatically
        'psi_pressure' => 'decimal:2',
        'input_current_ac' => 'decimal:2',
        'output_temperature_ac' => 'decimal:2',
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

    /**
     * Get the central location.
     */
    public function central()
    {
        return $this->belongsTo(Central::class);
    }
}
