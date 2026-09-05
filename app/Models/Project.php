<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'category',
        'client_name',
        'project_year',
        'project_url',
        'summary',
        'challenge',
        'solution',
        'result',
        'metric',
        'metric_label',
        'tags',
        'cover_image',
        'gallery_images',
        'theme',
        'sort_order',
        'is_featured',
        'is_published',
    ];

    protected $casts = [
        'tags' => 'array',
        'gallery_images' => 'array',
        'project_year' => 'integer',
        'sort_order' => 'integer',
        'is_featured' => 'boolean',
        'is_published' => 'boolean',
    ];

    public function coverImageUrl(): ?string
    {
        return $this->cover_image
            ? Storage::disk(config('portfolio.media_disk'))->url($this->cover_image)
            : null;
    }

    public function galleryImageUrl(string $path): string
    {
        return Storage::disk(config('portfolio.media_disk'))->url($path);
    }
}
