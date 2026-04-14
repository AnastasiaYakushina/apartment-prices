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
        try {
            $flatId = basename($url);

            $response = Http::withHeaders([
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/120.0.0.0 Safari/537.36',
            ])->timeout(5)->get("https://api.pik.ru/v2/flat?id={$flatId}");

            if ($response->successful()) {
                $flat = $response->json();

                if (isset($flat['price'], $flat['rooms'], $flat['area'])) {
                    return [
                        'price'       => $flat['price'],
                        'rooms_count' => $flat['rooms'],
                        'area'        => $flat['area'],
                        'developer'   => 'ПИК',
                        'complex'     => $flat['block']['name'] ?? 'Неизвестный ЖК'
                    ];
                }
            }
        } catch (\Exception $e) {
            \Log::error("Ошибка парсинга квартиры {$url}: " . $e->getMessage());
        }

        return null;
    }


    public function getPriceTotalDiff()
    {
        return $this->price - $this->initial_price;
    }

    public function getPriceTotalDiffPercent()
    {
        if (!$this->initial_price) {
            return 0;
        }

        return ($this->price / $this->initial_price) * 100 - 100;
    }

    public function refreshData($newPrice)
    {
        $this->price = $newPrice;
        if ($this->isDirty('price')) {
            $this->save();
            $this->prices()->create(['price' => $newPrice]);
            return true;
        }
        return false;
    }
}
