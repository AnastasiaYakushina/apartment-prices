<?php

namespace App\Services;

use App\Services\Parsers\ApartmentParserInterface;
use App\Services\Parsers\PikParserService;
use Illuminate\Support\Str;

class ApartmentParserManager
{
    /**
     * Карта соответствия доменов и сервисов.
     */
    protected array $parsers = [
        'pik.ru' => PikParserService::class,
        // 'samolet.ru' => SamoletParserService::class, // Сюда добавим новых
    ];

    /**
     * Возвращает нужный парсер на основе URL.
     */
    public function getParser(string $url): ?ApartmentParserInterface
    {
        foreach ($this->parsers as $domain => $serviceClass) {
            if (Str::contains($url, $domain)) {
                // Извлекаем объект из контейнера Laravel
                return app($serviceClass);
            }
        }

        return null;
    }
}
