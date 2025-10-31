<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RectifierMaintenance extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'location',
        'date_time',
        'reg_number',
        'sn',
        'brand_type',
        'power_module',

        // Visual Check
        'env_condition',
        'status_env_condition',
        'led_display',
        'status_led_display',
        'battery_connection',
        'status_battery_connection',

        // Performance and Capacity Check
        'ac_input_voltage',
        'status_ac_input_voltage',
        'ac_current_input_single',
        'ac_current_input_dual',
        'ac_current_input_three',
        'status_ac_current_input',
        'dc_current_output_single',
        'dc_current_output_dual',
        'dc_current_output_three',
        'status_dc_current_output',
        'battery_temperature',
        'status_battery_temperature',
        'charging_voltage_dc',
        'status_charging_voltage_dc',
        'charging_current_dc',
        'status_charging_current_dc',

        // Backup Tests
        'backup_test_rectifier',
        'status_backup_test_rectifier',
        'backup_test_voltage_measurement1',
        'backup_test_voltage_measurement2',
        'status_backup_test_voltage',

        // Power Alarm Monitoring Test
        'power_alarm_test',
        'status_power_alarm_test',

        // Notes & Images
        'notes',
        'images',

        // Personnel
        'executor_1',
        'executor_2',
        'executor_3',
        'supervisor',
        'supervisor_id_number',
        'department',
        'sub_department',
    ];

    protected $casts = [
        'date_time' => 'datetime',
        'images' => 'array',
        'ac_input_voltage' => 'decimal:2',
        'ac_current_input_single' => 'decimal:2',
        'ac_current_input_dual' => 'decimal:2',
        'ac_current_input_three' => 'decimal:2',
        'dc_current_output_single' => 'decimal:2',
        'dc_current_output_dual' => 'decimal:2',
        'dc_current_output_three' => 'decimal:2',
        'battery_temperature' => 'decimal:2',
        'charging_voltage_dc' => 'decimal:2',
        'charging_current_dc' => 'decimal:2',
        'backup_test_voltage_measurement1' => 'decimal:2',
        'backup_test_voltage_measurement2' => 'decimal:2',
    ];
}
