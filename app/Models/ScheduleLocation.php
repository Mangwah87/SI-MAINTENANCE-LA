<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduleLocation extends Model
{
    use HasFactory;
    
    // Asumsi nama tabel adalah 'schedule_locations'
    
    protected $fillable = [
        'schedule_maintenance_id', 
        'nama', 
        'petugas', 
        'rencana', 
        'realisasi'
    ]; 

    /**
     * ✅ PERBAIKAN KRUSIAL: Kolom yang akan di-cast menjadi tipe data native.
     * Ini memastikan 'rencana' dan 'realisasi' diakses sebagai PHP Array,
     * yang dibutuhkan oleh fungsi in_array() di Blade.
     */
    protected $casts = [
        'rencana' => 'array',    
        'realisasi' => 'array',  
    ];

    // Relasi kembali ke header utama
    public function scheduleMaintenance()
    {
        return $this->belongsTo(ScheduleMaintenance::class);
    }
}       