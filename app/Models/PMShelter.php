<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PMShelter extends Model
{
    use HasFactory;

    protected $table = 'pm_shelters';
    protected $fillable = [
        'location',
        'date_time',
        'brand_type',
        'reg_number',
        'serial_number',
        'kondisi_ruangan_result',
        'kondisi_ruangan_status',
        'kondisi_kunci_result',
        'kondisi_kunci_status',
        'layout_result',
        'layout_status',
        'kontrol_keamanan_result',
        'kontrol_keamanan_status',
        'aksesibilitas_result',
        'aksesibilitas_status',
        'aspek_teknis_result',
        'aspek_teknis_status',
        'notes',
        'pelaksana',
        'mengetahui',
        'created_by',
    ];

    protected $casts = [
        'date_time' => 'datetime',
        'pelaksana' => 'array',
        'kondisi_ruangan_status' => 'boolean',
        'kondisi_kunci_status' => 'boolean',
        'layout_status' => 'boolean',
        'kontrol_keamanan_status' => 'boolean',
        'aksesibilitas_status' => 'boolean',
        'aspek_teknis_status' => 'boolean',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}