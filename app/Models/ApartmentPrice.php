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

    public function getPriceDiff()
    {
         $previous = $this->apartment->prices()
        ->where('created_at', '<', $this->created_at)
        ->latest()
        ->first();

        if (!$previous) {
            return 0;
        }

        return $this->price - $previous->price;
    }

    public function getPriceDiffPercent()
    {
        $previous = $this->apartment->prices()
        ->where('created_at', '<', $this->created_at)
        ->latest()
        ->first();

        if (!$previous || $previous->price == 0) {
            return 0;
        }

        return ($this->price / $previous->price) * 100 - 100;
    }
}
