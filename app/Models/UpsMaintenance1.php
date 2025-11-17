<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UpsMaintenance1 extends Model
{
    use HasFactory;

    protected $table = 'ups_maintenances1';

    protected $fillable = [
        'user_id',

        // Images
        'images', // Field JSON untuk menyimpan semua gambar

        // Informasi Lokasi dan Perangkat
        'central_id',
        'date_time',
        'brand_type',
        'capacity',
        'reg_number',
        'sn',

        // 1. Visual Check
        'env_condition',
        'status_env_condition',
        'led_display',
        'status_led_display',
        'battery_connection',
        'status_battery_connection',

        // 2. Performance and Capacity Check
        'ac_input_voltage',
        'status_ac_input_voltage',
        'ac_output_voltage',
        'status_ac_output_voltage',
        'neutral_ground_voltage',
        'status_neutral_ground_voltage',
        'ac_current_input',
        'status_ac_current_input',
        'ac_current_output',
        'status_ac_current_output',
        'ups_temperature',
        'status_ups_temperature',
        'output_frequency',
        'status_output_frequency',
        'charging_voltage',
        'status_charging_voltage',
        'charging_current',
        'status_charging_current',
        'fan',
        'status_fan',

        // 3. Backup Tests
        'ups_switching_test',
        'status_ups_switching_test',
        'battery_voltage_measurement_1',
        'status_battery_voltage_measurement_1',
        'battery_voltage_measurement_2',
        'status_battery_voltage_measurement_2',

        // 4. Power Alarm Monitoring Test
        'simonica_alarm_test',
        'status_simonica_alarm_test',

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
        'ac_input_voltage' => 'decimal:2',
        'ac_output_voltage' => 'decimal:2',
        'neutral_ground_voltage' => 'decimal:2',
        'ac_current_input' => 'decimal:2',
        'ac_current_output' => 'decimal:2',
        'ups_temperature' => 'decimal:2',
        'output_frequency' => 'decimal:2',
        'charging_voltage' => 'decimal:2',
        'charging_current' => 'decimal:2',
        'battery_voltage_measurement_1' => 'decimal:2',
        'battery_voltage_measurement_2' => 'decimal:2',
        'images' => 'array', // Cast field JSON ke array
    ];

    /**
     * Get overall status of the maintenance
     */
    public function getOverallStatusAttribute()
    {
        $statuses = [
            $this->status_env_condition,
            $this->status_led_display,
            $this->status_battery_connection,
            $this->status_ac_input_voltage,
            $this->status_ac_output_voltage,
            $this->status_neutral_ground_voltage,
            $this->status_ac_current_input,
            $this->status_ac_current_output,
            $this->status_ups_temperature,
            $this->status_output_frequency,
            $this->status_charging_voltage,
            $this->status_charging_current,
            $this->status_fan,
            $this->status_ups_switching_test,
            $this->status_battery_voltage_measurement_1,
            $this->status_battery_voltage_measurement_2,
            $this->status_simonica_alarm_test,
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
            return $query->where('status_env_condition', 'OK')
                ->where('status_led_display', 'OK')
                ->where('status_battery_connection', 'OK')
                ->where('status_ac_input_voltage', 'OK')
                ->where('status_ac_output_voltage', 'OK')
                ->where('status_neutral_ground_voltage', 'OK')
                ->where('status_ac_current_input', 'OK')
                ->where('status_ac_current_output', 'OK')
                ->where('status_ups_temperature', 'OK')
                ->where('status_output_frequency', 'OK')
                ->where('status_charging_voltage', 'OK')
                ->where('status_charging_current', 'OK')
                ->where('status_fan', 'OK')
                ->where('status_ups_switching_test', 'OK')
                ->where('status_battery_voltage_measurement_1', 'OK')
                ->where('status_battery_voltage_measurement_2', 'OK')
                ->where('status_simonica_alarm_test', 'OK');
        }

        return $query->where(function ($q) {
            $q->where('status_env_condition', 'NOK')
                ->orWhere('status_led_display', 'NOK')
                ->orWhere('status_battery_connection', 'NOK')
                ->orWhere('status_ac_input_voltage', 'NOK')
                ->orWhere('status_ac_output_voltage', 'NOK')
                ->orWhere('status_neutral_ground_voltage', 'NOK')
                ->orWhere('status_ac_current_input', 'NOK')
                ->orWhere('status_ac_current_output', 'NOK')
                ->orWhere('status_ups_temperature', 'NOK')
                ->orWhere('status_output_frequency', 'NOK')
                ->orWhere('status_charging_voltage', 'NOK')
                ->orWhere('status_charging_current', 'NOK')
                ->orWhere('status_fan', 'NOK')
                ->orWhere('status_ups_switching_test', 'NOK')
                ->orWhere('status_battery_voltage_measurement_1', 'NOK')
                ->orWhere('status_battery_voltage_measurement_2', 'NOK')
                ->orWhere('status_simonica_alarm_test', 'NOK');
        });
    }

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
