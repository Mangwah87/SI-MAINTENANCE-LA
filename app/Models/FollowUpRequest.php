<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FollowUpRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
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
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    /**
     * Get the user that owns the follow up request.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}