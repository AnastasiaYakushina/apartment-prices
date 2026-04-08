<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class Apartment extends Model
{
    protected $fillable = ['url', 'price', 'initial_price', 'rooms_count', 'area', 'developer', 'complex'];

    public function prices()
    {
        return $this->hasMany(ApartmentPrice::class);
    }

    public static function getRemoteData($url)
    {
        $flatId = basename($url);

        $response = Http::withHeaders([
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/120.0.0.0 Safari/537.36',
            ])->get("https://api.pik.ru/v2/flat?id={$flatId}");

        if ($response->successful()) {
            $flat = $response->json() ?? null;    

            if ($flat) {
                return [
                    'price'       => $flat['price'],
                    'rooms_count' => $flat['rooms'],
                    'area'        => $flat['area'],
                    'developer'   => 'ПИК',
                    'complex'     => $flat['block']['name']
                ];
            }
        }

        return null;
    }
}
