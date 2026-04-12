<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use App\Models\Apartment;

class UpdateApartmentPrices extends Command
{
    protected $signature = 'prices:update';
    protected $description = 'Обновляет цены квартир с сайта застройщиков';

    public function handle()
    {
        $apartments = Apartment::all();
        $this->info("Начинаю обновление цен для {$apartments->count()} квартир...");

        foreach ($apartments as $apartment) {
            $newData = Apartment::getRemoteData($apartment->url);

            if ($newData) {
                if ($apartment->refreshData($newData['price'])) {
                    $this->line("Обновлена цена для ЖК: {$apartment->complex}");
                }
            }
        }

        $this->info('Обновление завершено!');
    }
}
