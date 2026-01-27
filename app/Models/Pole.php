<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pole extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'central_id',
        'date',
        'time',
        'type_pole',

        // Physical Check
        'foundation_condition',
        'status_foundation_condition',
        'pole_tower_foundation_flange',
        'status_pole_tower_foundation_flange',
        'pole_tower_support_flange',
        'status_pole_tower_support_flange',
        'flange_condition_connection',
        'status_flange_condition_connection',
        'pole_tower_condition',
        'status_pole_tower_condition',
        'arm_antenna_condition',
        'status_arm_antenna_condition',
        'availability_basbar_ground',
        'status_availability_basbar_ground',
        'bonding_bar',
        'status_bonding_bar',

        // Performance Measurement
        'inclination_measurement',
        'status_inclination_measurement',

        // Personnel
        'executor_1',
        'mitra_internal_1',
        'executor_2',
        'mitra_internal_2',
        'executor_3',
        'mitra_internal_3',
        'executor_4',
        'mitra_internal_4',
        'verifikator',
        'verifikator_nik',
        'head_of_sub_department',
        'head_of_sub_department_nik',

        'notes',
        'data_checklist',
        'images',
        'user_id',
    ];

    protected $casts = [
        'date' => 'date',
        'data_checklist' => 'array',
        'images' => 'array',
        'deleted_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function central()
    {
        return $this->belongsTo(Central::class);
    }
}
