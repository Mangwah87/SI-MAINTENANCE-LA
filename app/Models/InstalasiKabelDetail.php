<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstalasiKabelDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'instalasi_kabel_header_id',
        'item_description',
        'photo_path', // Tambahan untuk menyimpan path foto
        'operational_standard',
        'result',
        'status',
    ];

    /**
     * Relasi ke Header (Many to One)
     */
    public function header()
    {
        return $this->belongsTo(InstalasiKabelHeader::class, 'instalasi_kabel_header_id');
    }

    /**
     * Accessor untuk mendapatkan URL foto lengkap
     */
public function getPhotoUrlAttribute()
{
    if ($this->photo_path) {
        return asset('storage/' . $this->photo_path);
    }
    return null;
}

    /**
     * Scope untuk filter berdasarkan status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope untuk mendapatkan item dengan foto
     */
    public function scopeWithPhoto($query)
    {
        return $query->whereNotNull('photo_path');
    }
    
}