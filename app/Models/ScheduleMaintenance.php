<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduleMaintenance extends Model
{
    use HasFactory;
    
    // Asumsi nama tabel adalah 'schedule_maintenances'
    
    /**
     * Kolom yang dapat diisi secara massal (mass assignable).
     */
    protected $fillable = [
        'user_id',       // Kunci asing ke User (yang membuat jadwal)
        'doc_number',    // Nomor dokumen
        'tanggal_pembuatan', // Ganti dari 'bulan'
        'dibuat_oleh',   // Nama yang membuat dokumen
        'mengetahui',    // Nama yang mengetahui dokumen
    ];

    /**
     * Kolom yang harus di-cast menjadi tipe data tertentu.
     * 'tanggal_pembuatan' di-cast menjadi Carbon instance agar mudah dimanipulasi.
     */
    protected $casts = [
        'tanggal_pembuatan' => 'date', // Ganti dari 'bulan'
    ];

    /**
     * Relasi ke detail lokasi (ScheduleLocation).
     * Satu ScheduleMaintenance memiliki banyak ScheduleLocation.
     */
    public function locations()
    {
        return $this->hasMany(ScheduleLocation::class);
    }
    
    /**
     * Relasi ke User (pembuat jadwal).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

} // ✅ PASTIKAN TANDA KURUNG KURAWAL PENUTUP KELAS INI ADA!