<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inverter extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nomor_dokumen',
        'lokasi',
        'tanggal_dokumentasi',
        'waktu',
        'brand',
        'reg_num',
        'serial_num',
        'keterangan',
        'dc_input_voltage',
        'dc_current_input',
        'ac_current_output',
        'ac_output_voltage',
        'equipment_temperature',

        // Personnel
        'executor_1', 'mitra_internal_1',
        'executor_2', 'mitra_internal_2',
        'executor_3', 'mitra_internal_3',
        'executor_4', 'mitra_internal_4',

        // Mengetahui
        'verifikator', 'verifikator_nik',
        'head_of_sub_department', 'head_of_sub_department_nik',

        'data_checklist', // JSON field
        'user_id',
    ];

    protected $casts = [
        'tanggal_dokumentasi' => 'datetime',
        'data_checklist' => 'array', // Auto cast ke array
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
