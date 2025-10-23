<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TindakLanjut extends Model
{
    use HasFactory;

    protected $table = 'tindak_lanjut';
    protected $fillable = [
        'user_id',
        'tanggal',
        'jam',
        'lokasi',
        'ruang',
        'permasalahan',
        'tindakan_penyelesaian',
        'hasil_perbaikan',
        'department',
        'sub_department',
        'permohonan_tindak_lanjut',
        'pelaksanaan_pm',
        'selesai',
        'selesai_tanggal',
        'selesai_jam',
        'tidak_selesai',
        'tidak_lanjut',
        'pelaksana',
        'mengetahui',
    ];

    protected $casts = [
        'pelaksana' => 'array',
        'mengetahui' => 'array',
        'permohonan_tindak_lanjut' => 'boolean',
        'pelaksanaan_pm' => 'boolean',
        'selesai' => 'boolean',
        'tidak_selesai' => 'boolean',
        'tanggal' => 'date',
        'selesai_tanggal' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
