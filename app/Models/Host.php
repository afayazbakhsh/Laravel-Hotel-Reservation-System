<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Host extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'national_code',
        'phone_number',
        'email',
        'address',
    ];

    public function hotel() : HasMany
    {
        return $this->hasMany(Hotel::class);
    }

    public function scopeConfirmed($query,$bool = false)
    {
        return $query->where('is_confirm', $bool);
    }
}
