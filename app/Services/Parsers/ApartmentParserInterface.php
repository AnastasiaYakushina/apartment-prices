<?php

namespace App\Services\Parsers;

interface ApartmentParserInterface
{
    public function parse(string $url): ?array;
}
