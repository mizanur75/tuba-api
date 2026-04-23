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
        'practitioner_user_id',
        'practitioner_type',
        'patient_name',
        'age',
        'sex',
        'address',
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

    public function practitioner()
    {
        return $this->belongsTo(User::class, 'practitioner_user_id');
    }
}
