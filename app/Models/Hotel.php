<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Scout\Attributes\SearchUsingFullText;
use Laravel\Scout\Attributes\SearchUsingPrefix;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Laravel\Scout\Searchable;

class Hotel extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, Searchable;

    protected $fillable = [
        'name',
        'title',
        'description',
        'motto',
        'slug',
        'city_id',
        'host_id',
    ];

    protected $casts = [

        'is_confirm' => 'boolean',
    ];

    #[SearchUsingPrefix(['id', 'name'])]
    #[SearchUsingFullText(['description'])]
    public function toSearchableArray()
    {
        return [
            'id' => (int) $this->id,
            'name' => $this->name,
            'title' => $this->title,
            'description' => $this->description,
        ];
    }

    public function searchableAs(): string
    {
        return 'hotels';
    }

    public function address(): MorphOne
    {
        return $this->morphOne(Address::class, 'addressable');
    }

    public function phones(): MorphMany
    {
        return $this->morphMany(Phone::class, 'phoneable');
    }

    public function emails(): MorphMany
    {
        return $this->morphMany(Email::class, 'emailable');
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function newestEmail(): MorphOne
    {
        return $this->morphOne(Email::class, 'emailable')->latestOfMany();
    }

    public function host(): BelongsTo
    {
        return $this->belongsTo(Host::class);
    }

    public function features(): HasMany
    {
        return $this->hasMany(Feature::class);
    }

    public function scopeConfirmed($query, $bool = false)
    {
        return $query->where('is_confirm', $bool);
    }

    public function images(): MorphMany
    {
        return $this->morphMany(Media::class, 'model');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(368)
            ->height(232);
    }


    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('hotel_images_collection');
    }
}
