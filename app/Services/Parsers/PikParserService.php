<?php

namespace App\Services\Parsers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PikParserService
{
    public function parse($url)
    {
        try {
            $flatId = basename($url);

            $response = Http::withHeaders([
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/120.0.0.0 Safari/537.36',
            ])->timeout(5)->get("https://api.pik.ru/v2/flat?id={$flatId}");

            if ($response->successful()) {
                $flat = $response->json();
                 return [
                    'price'       => $flat['price'],
                    'rooms_count' => $flat['rooms'],
                    'area'        => $flat['area'],
                    'developer'   => 'ПИК',
                    'complex'     => $flat['block']['name'] ?? 'Неизвестный ЖК'
                 ];
            }
        } catch (\Exception $e) {
            Log::error("Ошибка парсинга квартиры {$url}: " . $e->getMessage());
        }
        return null;
    }
}
