<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',
        'company_short_name',
        'tagline',
        'hero_badge',
        'hero_title',
        'hero_highlight',
        'hero_description',
        'accent_color',
        'accent_color_secondary',
        'cta_label',
        'cta_url',
        'email',
        'phone',
        'whatsapp',
        'location',
        'linkedin_url',
        'instagram_url',
        'seo_title',
        'seo_description',
    ];
}
