<?php

namespace App\Console\Commands;

use App\Models\Apartment;
use App\Services\ApartmentParserManager;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

class UpdateApartmentPrices extends Command
{
    protected $signature = 'prices:update';
    protected $description = 'Обновляет цены квартир с сайта застройщиков';

    public function handle(ApartmentParserManager $manager)
    {
        $apartments = Apartment::all();
        $this->info("Начинаю обновление цен для {$apartments->count()} квартир...");

        foreach ($apartments as $apartment) {
            $parser = $manager->getParser($apartment->url);
            if ($parser) {
                $newData = $parser->parse($apartment->url);

                if ($newData) {
                    if ($apartment->refreshData($newData['price'])) {
                        $this->line("Обновлена цена для ЖК: {$apartment->complex}");
                    }
                }
            }
            sleep(1);
        }

        $this->info('Обновление завершено!');
    }
}
