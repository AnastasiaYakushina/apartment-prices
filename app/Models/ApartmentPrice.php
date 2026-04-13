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
        $allPrices = $this->apartment->prices->sortBy('created_at')->values();
        $currentPos = $allPrices->search(fn($item) => $item->id === $this->id);
        $previous = $allPrices[$currentPos - 1] ?? null;

        return $previous ? ($this->price - $previous->price) : 0;
    }

    public function getPriceDiffPercent()
    {
        $allPrices = $this->apartment->prices->sortBy('created_at')->values();
        $currentPos = $allPrices->search(fn($item) => $item->id === $this->id);
        $previous = $allPrices[$currentPos - 1] ?? null;

        if (!$previous || $previous->price == 0) {
            return 0;
        }

        return ($this->price / $previous->price) * 100 - 100;
    }
}
