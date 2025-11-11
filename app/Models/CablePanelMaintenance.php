<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CablePanelMaintenance extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terkait dengan model.
     *
     * @var string
     */
    protected $table = 'cable_panel_maintenances';

    /**
     * Atribut yang tidak boleh diisi secara massal.
     *
     * @var array<int, string>
     */
    protected $guarded = ['id'];

    /**
     * Atribut yang harus di-cast ke tipe bawaan.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'maintenance_date' => 'datetime',
        'images' => 'array',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}