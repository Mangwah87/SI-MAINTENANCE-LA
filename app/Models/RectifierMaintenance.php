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

        // Visual Check (Physical Check)
        'env_condition',
        'status_env_condition',
        'led_display',
        'status_led_display',
        'battery_connection',
        'status_battery_connection',
        'rectifier_module_installed', // NEW
        'status_rectifier_module_installed', // NEW
        'alarm_modul_rectifier', // NEW
        'status_alarm_modul_rectifier', // NEW

        // Performance and Capacity Check
        'ac_input_voltage',
        'status_ac_input_voltage',
        'ac_current_input',
        'status_ac_current_input',
        'dc_current_output',
        'status_dc_current_output',
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

        // Personnel - Executor
        'executor_1',
        'executor_1_department',
        'executor_1_type', // NEW
        'executor_2',
        'executor_2_department',
        'executor_2_type', // NEW
        'executor_3',
        'executor_3_department',
        'executor_3_type', // NEW

        // Personnel - Supervisor
        'supervisor',
        'supervisor_id_number',
        'department',

        // Personnel - Verifikator (NEW)
        'verifikator_name',
        'verifikator_id_number',

        // Personnel - Head of Sub Department (NEW)
        'head_of_sub_dept_name',
        'head_of_sub_dept_id',
    ];

    protected $casts = [
        'date_time' => 'datetime',
        'images' => 'array',
        'ac_input_voltage' => 'decimal:2',
        'ac_current_input' => 'decimal:2',
        'dc_current_output' => 'decimal:2',
        'charging_voltage_dc' => 'decimal:2',
        'charging_current_dc' => 'decimal:2',
        'backup_test_voltage_measurement1' => 'decimal:2',
        'backup_test_voltage_measurement2' => 'decimal:2',
    ];

    /**
     * Accessor - Return Collection
     */
    public function getImagesAttribute($value)
    {
        if (is_null($value)) {
            return collect([]);
        }

        if (is_string($value)) {
            $decoded = json_decode($value, true);
            return collect($decoded ?? []);
        }

        if (is_array($value)) {
            return collect($value);
        }

        return collect([]);
    }

    /**
     * Mutator - Ensure images disimpan sebagai array
     */
    public function setImagesAttribute($value)
    {
        if ($value instanceof \Illuminate\Support\Collection) {
            $this->attributes['images'] = json_encode($value->toArray());
        } elseif (is_array($value)) {
            $this->attributes['images'] = json_encode($value);
        } elseif (is_string($value)) {
            $this->attributes['images'] = $value;
        } else {
            $this->attributes['images'] = json_encode([]);
        }
    }

    /**
     * Get images by category
     */
    public function getImagesByCategory($category)
    {
        return $this->images->filter(function ($img) use ($category) {
            return isset($img['category']) && $img['category'] == $category;
        });
    }

    /**
     * Get images as array
     */
    public function getImagesArray()
    {
        return $this->images->toArray();
    }

    /**
     * Relationships
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function central()
    {
        return $this->belongsTo(Central::class, 'location', 'id');
    }

    public function getLocationNameAttribute()
    {
        return $this->central
            ? "{$this->central->id_sentral} - {$this->central->nama}"
            : 'Unknown Location';
    }
}
