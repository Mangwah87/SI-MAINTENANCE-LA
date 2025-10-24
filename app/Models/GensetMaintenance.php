<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GensetMaintenance extends Model
{
    use HasFactory;
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];


    // protected $fillable = [
    //     'doc_number',
    //     'location',
    //     'maintenance_date',
    //     'brand_type',
    //     'capacity',
    //     'environment_condition_result',
    //     'environment_condition_comment',
    //     'engine_oil_press_display_result',
    //     'engine_oil_press_display_comment',
    //     'engine_water_temp_display_result',
    //     'engine_water_temp_display_comment',
    //     'battery_connection_result',
    //     'battery_connection_comment',
    //     'engine_oil_level_result',
    //     'engine_oil_level_comment',
    //     'engine_fuel_level_result',
    //     'engine_fuel_level_comment',
    //     'running_hours_result',
    //     'running_hours_comment',
    //     'cooling_water_level_result',
    //     'cooling_water_level_comment',
    //     'no_load_ac_voltage_rs',
    //     'no_load_ac_voltage_st',
    //     'no_load_ac_voltage_tr',
    //     'no_load_ac_voltage_rn',
    //     'no_load_ac_voltage_sn',
    //     'no_load_ac_voltage_tn',
    //     'no_load_output_frequency',
    //     'no_load_battery_charging_current',
    //     'no_load_engine_cooling_water_temp',
    //     'no_load_engine_oil_press',
    //     'load_ac_voltage_rs',
    //     'load_ac_voltage_st',
    //     'load_ac_voltage_tr',
    //     'load_ac_voltage_rn',
    //     'load_ac_voltage_sn',
    //     'load_ac_voltage_tn',
    //     'load_ac_current_r',
    //     'load_ac_current_s',
    //     'load_ac_current_t',
    //     'load_output_frequency',
    //     'load_battery_charging_current',
    //     'load_engine_cooling_water_temp',
    //     'load_engine_oil_press',
    //     'notes',
    //     'technician_1_name',
    //     'technician_1_department',
    //     'technician_2_name',
    //     'technician_2_department',
    //     'technician_3_name',
    //     'technician_3_department',
    // ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'maintenance_date' => 'datetime',
    ];
}