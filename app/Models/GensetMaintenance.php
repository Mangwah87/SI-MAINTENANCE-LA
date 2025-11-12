<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GensetMaintenance extends Model
{
    use HasFactory;
    
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id']; // Gunakan guarded, ini lebih mudah

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'maintenance_date' => 'datetime',
        'images' => 'array', // <-- TAMBAHKAN INI
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}