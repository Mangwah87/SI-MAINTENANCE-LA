<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PmShelter extends Model
{
    use HasFactory;

    protected $fillable = [
        'document_number',
        'version',
        'user_id',
        'location',
        'date',
        'time',
        'brand_type',
        'reg_number',
        'serial_number',
        'kondisi_ruangan_result',
        'kondisi_ruangan_status',
        'kondisi_kunci_result',
        'kondisi_kunci_status',
        'layout_tata_ruang_result',
        'layout_tata_ruang_status',
        'kontrol_keamanan_result',
        'kontrol_keamanan_status',
        'aksesibilitas_result',
        'aksesibilitas_status',
        'aspek_teknis_result',
        'aspek_teknis_status',
        'notes',
        'photos',
        'executors',
        'approver_name',
    ];

    protected $casts = [
        'date' => 'date',
        'photos' => 'array',
        'executors' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->document_number)) {
                $model->document_number = 'FM-LAP-D2-SOP-003-009';
            }
        });
    }
}