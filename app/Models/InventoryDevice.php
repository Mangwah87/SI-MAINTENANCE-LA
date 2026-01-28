<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryDevice extends Model
{
    protected $fillable = [
        'central_id',
        'date',
        'time',
        'device_sentral',
        'supporting_facilities',
        'notes',
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
        'images',
    ];

    protected $casts = [
        'device_sentral' => 'array',
        'supporting_facilities' => 'array',
        'images' => 'array',
        'date' => 'date',
    ];

    public function central()
    {
        return $this->belongsTo(Central::class);
    }
}
