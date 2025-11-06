<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UpsMaintenance extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',

        // Informasi Lokasi dan Perangkat
        'location',
        'date_time',
        'brand_type',
        'capacity',
        'reg_number',
        'sn',
        'images', // Field JSON untuk menyimpan semua gambar

        // Visual Check
        'env_condition',
        'led_display',
        'battery_connection',

        // Visual Check - Individual Status (BARU)
        'status_env_condition',
        'status_led_display',
        'status_battery_connection',

        // AC Input Voltage
        'ac_input_voltage_rs',
        'ac_input_voltage_st',
        'ac_input_voltage_tr',
        'status_ac_input_voltage',

        // AC Output Voltage
        'ac_output_voltage_rs',
        'ac_output_voltage_st',
        'ac_output_voltage_tr',
        'status_ac_output_voltage',

        // AC Current Input
        'ac_current_input_r',
        'ac_current_input_s',
        'ac_current_input_t',
        'status_ac_current_input',

        // AC Current Output
        'ac_current_output_r',
        'ac_current_output_s',
        'ac_current_output_t',
        'status_ac_current_output',

        // UPS Temperature
        'ups_temperature',
        'status_ups_temperature',

        // Output Frequency
        'output_frequency',
        'status_output_frequency',

        // Charging Voltage
        'charging_voltage',
        'status_charging_voltage',

        // Charging Current
        'charging_current',
        'status_charging_current',

        // Notes
        'notes',

        // Personnel
        'executor_1',
        'executor_2',
        'supervisor',
        'supervisor_id_number',
        'department',
        'sub_department',
    ];

    protected $casts = [
        'date_time' => 'datetime',
        'ac_input_voltage_rs' => 'decimal:2',
        'ac_input_voltage_st' => 'decimal:2',
        'ac_input_voltage_tr' => 'decimal:2',
        'ac_output_voltage_rs' => 'decimal:2',
        'ac_output_voltage_st' => 'decimal:2',
        'ac_output_voltage_tr' => 'decimal:2',
        'ac_current_input_r' => 'decimal:2',
        'ac_current_input_s' => 'decimal:2',
        'ac_current_input_t' => 'decimal:2',
        'ac_current_output_r' => 'decimal:2',
        'ac_current_output_s' => 'decimal:2',
        'ac_current_output_t' => 'decimal:2',
        'ups_temperature' => 'decimal:2',
        'output_frequency' => 'decimal:2',
        'charging_voltage' => 'decimal:2',
        'charging_current' => 'decimal:2',
        'images' => 'array', // Cast field JSON ke array
    ];

    /**
     * Get overall status of the maintenance
     */
    public function getOverallStatusAttribute()
    {
        $statuses = [
            $this->status_visual_check,
            $this->status_ac_input_voltage,
            $this->status_ac_output_voltage,
            $this->status_ac_current_input,
            $this->status_ac_current_output,
            $this->status_ups_temperature,
            $this->status_output_frequency,
            $this->status_charging_voltage,
            $this->status_charging_current,
        ];

        return in_array('NOK', $statuses) ? 'NOK' : 'OK';
    }

    /**
     * Scope to filter by location
     */
    public function scopeByLocation($query, $location)
    {
        return $query->where('location', 'like', "%{$location}%");
    }

    /**
     * Scope to filter by date range
     */
    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('date_time', [$startDate, $endDate]);
    }

    /**
     * Scope to filter by status
     */
    public function scopeByStatus($query, $status)
    {
        if ($status === 'OK') {
            return $query->where('status_visual_check', 'OK')
                ->where('status_ac_input_voltage', 'OK')
                ->where('status_ac_output_voltage', 'OK')
                ->where('status_ac_current_input', 'OK')
                ->where('status_ac_current_output', 'OK')
                ->where('status_ups_temperature', 'OK')
                ->where('status_output_frequency', 'OK')
                ->where('status_charging_voltage', 'OK')
                ->where('status_charging_current', 'OK');
        }

        return $query->where(function ($q) {
            $q->where('status_visual_check', 'NOK')
                ->orWhere('status_ac_input_voltage', 'NOK')
                ->orWhere('status_ac_output_voltage', 'NOK')
                ->orWhere('status_ac_current_input', 'NOK')
                ->orWhere('status_ac_current_output', 'NOK')
                ->orWhere('status_ups_temperature', 'NOK')
                ->orWhere('status_output_frequency', 'NOK')
                ->orWhere('status_charging_voltage', 'NOK')
                ->orWhere('status_charging_current', 'NOK');
        });
    }

    /**
     * Get the user that owns the maintenance record.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
