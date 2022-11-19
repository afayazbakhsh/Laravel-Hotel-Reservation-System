<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function hotel()
    {
        return $this->hasOne(Hotel::class);
    }

    public function scopeConfirmed($query)
    {
        return $query->where('is_confirm', 1);
    }
}
