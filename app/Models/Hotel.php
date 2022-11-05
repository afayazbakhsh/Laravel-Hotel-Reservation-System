<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;

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

    public function Host()
    {
        return $this->belongsTo(Host::class);
    }

    public function features()
    {
        return $this->hasMany(Feature::class);
    }
}
