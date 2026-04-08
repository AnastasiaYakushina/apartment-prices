<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApartmentPrice extends Model
{
    protected $fillable = ['price', 'apartment_id'];

    public function apartment()
    {
        return $this->belongsTo(Apartment::class);
    }
}
