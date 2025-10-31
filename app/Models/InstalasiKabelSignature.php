<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstalasiKabelSignature extends Model
{
    use HasFactory;

    protected $fillable = [
        'instalasi_kabel_header_id',
        'no',
        'role',
        'name',
        'perusahaan',
        'tanda_tangan_path', // Jika Anda menyimpan path file
    ];

    public function header()
    {
        return $this->belongsTo(InstalasiKabelHeader::class, 'instalasi_kabel_header_id');
    }
}