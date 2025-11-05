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