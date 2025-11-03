<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PMPermohonan extends Model
{
    use HasFactory;

    protected $table = 'pm_permohonan';

    protected $fillable = [
        'user_id',
        'nama',
        'tanggal',
        'jam',
        'lokasi',
        'ruang',
        'permasalahan',
        'usulan_tindak_lanjut',
        'department',
        'sub_department',
        'ditujukan_department',
        'ditujukan_sub_department',
        'diinformasikan_melalui',
        'catatan',
        'status',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    /**
     * Get the user that owns the PM permohonan.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}