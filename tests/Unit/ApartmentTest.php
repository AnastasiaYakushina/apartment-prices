<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\Apartment;

class ApartmentTest extends TestCase
{
    public function testPriceCalculations(): void
    {
        $apartment = new Apartment(['initial_price' => 10000000, 'price' => 10500000]);

        $this->assertEquals(500000, $apartment->getPriceTotalDiff());
        $this->assertEquals(5, $apartment->getPriceTotalDiffPercent());
    }

    public function testHandlesZeroInitialPrice(): void
    {
        $apartment = new Apartment(['initial_price' => 0, 'price' => 10000000]);

        $this->assertEquals(0, $apartment->getPriceTotalDiffPercent());
    }
}
