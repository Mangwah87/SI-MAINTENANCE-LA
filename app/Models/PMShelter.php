<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PMShelter extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'central_id',
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
        'photos',
        'notes',
        'executors',
        'approvers',
    ];

    protected $casts = [
        'date' => 'date',
        'photos' => 'array',
        'executors' => 'array',
        'approvers' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Tambahkan relasi ke Central
    public function central()
    {
        return $this->belongsTo(Central::class);
    }

    // Accessor untuk memfilter foto berdasarkan field
    public function getKondisiRuanganPhotosAttribute()
    {
        return $this->filterPhotosByField('kondisi_ruangan_photos');
    }

    public function getKondisiKunciPhotosAttribute()
    {
        return $this->filterPhotosByField('kondisi_kunci_photos');
    }

    public function getLayoutTataRuangPhotosAttribute()
    {
        return $this->filterPhotosByField('layout_tata_ruang_photos');
    }

    public function getKontrolKeamananPhotosAttribute()
    {
        return $this->filterPhotosByField('kontrol_keamanan_photos');
    }

    public function getAksesibilitasPhotosAttribute()
    {
        return $this->filterPhotosByField('aksesibilitas_photos');
    }

    public function getAspekTeknisPhotosAttribute()
    {
        return $this->filterPhotosByField('aspek_teknis_photos');
    }

    private function filterPhotosByField($fieldName)
    {
        if (!$this->photos || !is_array($this->photos)) {
            return [];
        }

        $filtered = array_filter($this->photos, function ($photo) use ($fieldName) {
            return isset($photo['field']) && $photo['field'] === $fieldName;
        });

        return array_values($filtered);
    }
}