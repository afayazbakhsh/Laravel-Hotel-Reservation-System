<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Hotel extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'name',
        'city_id',
        'user_id',
    ];


    public function address()
    {
        return $this->morphOne(Address::class, 'addressable');
    }

    public function phones()
    {
        return $this->morphMany(Phone::class, 'phoneable');
    }

    public function emails()
    {
        return $this->morphMany(Email::class, 'emailable');
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function newestEmail()
    {
        return $this->morphOne(Email::class, 'emailable')->latestOfMany();
    }

    public function host()
    {
        return $this->belongsTo(Host::class);
    }

    public function features()
    {
        return $this->hasMany(Feature::class);
    }

    public function scopeConfirmed($query, $bool)
    {
        return $query->where('is_confirm', $bool);
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
