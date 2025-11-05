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
        'brand',
        'reg_num',
        'serial_num',
        'perusahaan',
        'keterangan',
        'dc_input_voltage',
        'dc_current_input',
        'dc_current_inverter_type',
        'ac_current_output',
        'ac_current_inverter_type',
        'neutral_ground_output_voltage',
        'equipment_temperature',
        'boss',
        'pelaksana', // JSON field
        'pengawas', // JSON field
        'data_checklist', // JSON field
        'user_id',
    ];

    protected $casts = [
        'tanggal_dokumentasi' => 'datetime',
        'pelaksana' => 'array', // Auto cast ke array
        'pengawas' => 'array', // Auto cast ke array
        'data_checklist' => 'array', // Auto cast ke array
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}