<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    use HasFactory;
    protected $fillable = [
        'history_id',
        'medicine_name',
        'dose',
        'duration'
    ];

    public function history()
    {
        return $this->belongsTo(History::class);
    }
}