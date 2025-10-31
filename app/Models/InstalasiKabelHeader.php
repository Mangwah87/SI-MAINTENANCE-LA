<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\InstalasiKabelDetail; 
use App\Models\InstalasiKabelSignature; 

class InstalasiKabelHeader extends Model
{
    use HasFactory;
    
    // Asumsi nama tabel Anda: instalasi_kabel_headers
    protected $guarded = ['id'];
    
    protected $fillable = [
        'user_id',
        'no_dokumen',
        'location',
        'date_time',
        'brand_type',
        'reg_number',
        'serial_number',
        'notes',
        'bulan',
        'dibuat_oleh',
    ];

    protected $casts = [
        'date_time' => 'datetime',
    ];
    
    // ✅ Relasi ke Detail Item
    public function details()
    {
        return $this->hasMany(InstalasiKabelDetail::class, 'instalasi_kabel_header_id');
    }

    // ✅ Relasi ke Tanda Tangan (menggantikan 'pelaksana' yang menyebabkan error)
    public function signatures()
    {
        return $this->hasMany(InstalasiKabelSignature::class, 'instalasi_kabel_header_id');
    }
}