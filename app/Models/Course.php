<?php

namespace App\Models;

use App\Enums\CourseLevel;
use App\Traits\WithHashId;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Course extends Model implements HasMedia
{
    use HasFactory;
    use WithHashId;
    use Sluggable;
    use InteractsWithMedia;

    protected $fillable = [
        'user_id',
        'category_id',
        'subcategory_id',
        'title',
        'subtitle',
        'slug',
        'description',
        'level',
        'price',
        'published_at',
    ];

    protected $casts = [
        'level' => CourseLevel::class,
        'published_at' => 'datetime',
        'price' => 'float'
    ];

    public function author() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category() : BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory() : BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function sections() : HasMany
    {
        return $this->hasMany(Section::class);
    }

    public function lectures() : HasMany
    {
        return $this->hasMany(Lecture::class);
    }

    public function scopePublished(Builder $builder)
    {
        return $builder->whereNotNull('published_at');
    }

    public function isPublished()
    {
        return ! is_null($this->published_at);
    }

    public function canBePublished()
    {
        if((bool)$this->getFirstMedia('cover')) {
            return true;
        }

        return false;
    }

    // price_formatted
    public function getPriceFormattedAttribute()
    {
        if($this->price > 0) {
            return money(
                $this->price,
                config('site.currency'),
                true
            )->format();
        }

        return 'Free';
    }

    public function sluggable() : array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function registerMediaCollections() : void
    {
        $this->addMediaCollection('cover')
            ->useDisk('covers');
    }

    //cover_image_url
    public function getCoverImageUrlAttribute()
    {
        if($this->hasMedia('cover')) {
            return $this->getFirstMediaUrl('cover');
        }

        return Storage::disk('covers')->url('default.jpg');
    }
}
