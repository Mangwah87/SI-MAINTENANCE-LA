<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroundingMaintenance extends Model
{
    use HasFactory;

    /**
     * Use guarded instead of fillable for simplicity.
     * This means all attributes are mass assignable except 'id'.
     */
    protected $guarded = ['id'];

    /**
     * Cast JSON 'images' column to array and the date column.
     */
    protected $casts = [
        'maintenance_date' => 'datetime',
        'images' => 'array', // Automatically encodes/decodes the JSON column
    ];
}
