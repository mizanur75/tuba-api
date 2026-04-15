<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = ['package_id', 'name', 'age', 'sex', 'address', 'email', 'phone', 'date', 'time', 'status', 'comments'];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}
