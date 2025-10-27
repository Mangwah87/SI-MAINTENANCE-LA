<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PMShelterExecutor extends Model
{
    use HasFactory;

    protected $table = 'pm_shelter_executors';

    protected $fillable = [
        'pm_shelter_id',
        'name',
        'department',
        'sub_department',
        'role',
        'order',
    ];

    public function pmShelter()
    {
        return $this->belongsTo(PMShelter::class);
    }
}