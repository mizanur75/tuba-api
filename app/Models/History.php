<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;

    protected $fillable = [
        'package_id',
        'appointment_id',
        'patient_name',
        'phone',
        'chief_complaint',
        'diagnosis',
        'advice',
        'status'
    ];

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }

    // ✅ ADD THIS
    public function package()
    {
        return $this->belongsTo(\App\Models\Package::class);
    }
}