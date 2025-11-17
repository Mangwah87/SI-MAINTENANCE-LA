<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Central extends Model
{
    use HasFactory;

    protected $table = 'central';

    protected $fillable = [
        'id_sentral',
        'nama',
        'area',
    ];
    // Relasi ke Battery Maintenances
    public function batteryMaintenances()
    {
        return $this->hasMany(BatteryMaintenance::class, 'location', 'id');
    }

    // Relasi ke Rectifier Maintenances
    public function rectifierMaintenances()
    {
        return $this->hasMany(RectifierMaintenance::class, 'location', 'id');
    }

    // Relasi ke Genset Maintenances
    public function gensetMaintenances()
    {
        return $this->hasMany(GensetMaintenance::class, 'location', 'id');
    }

}
