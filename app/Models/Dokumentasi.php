<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dokumentasi extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'dokumentasi';

    protected $fillable = [
        'nomor_dokumen',
        'lokasi',
        'tanggal_dokumentasi',
        'perusahaan',
        'keterangan',
        'pengawas',
        'pelaksana',           // ✅ kolom JSON baru
        'perangkat_sentral',
        'sarana_penunjang',
        'user_id',
    ];

    protected $casts = [
        'tanggal_dokumentasi' => 'datetime',
        'pelaksana' => 'array',            // ✅ otomatis decode JSON ke array
        'perangkat_sentral' => 'array',
        'sarana_penunjang' => 'array',
    ];

    /**
     * Relasi ke tabel users
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getPelaksanaListAttribute()
    {
        if (!$this->pelaksana || !is_array($this->pelaksana)) {
            return '-';
        }

        return collect($this->pelaksana)
            ->map(fn($p) => "{$p['nama']} ({$p['perusahaan']})")
            ->implode(', ');
    }
}
