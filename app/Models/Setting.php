<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'site_name',
        'site_tagline',
        'admin_logo',
        'admin_favicon',
        'support_email',
        'support_phone',
        'office_address',
        'footer_text',
        'facebook_url',
        'linkedin_url',
    ];
}
