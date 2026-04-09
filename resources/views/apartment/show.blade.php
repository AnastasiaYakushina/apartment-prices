@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <h1 class="mb-4">Квартира #{{ $apartment->id }}</h1>

        <!-- Основная карточка -->
        <div class="card shadow-sm mb-5">
            <div class="card-body">
                <h3 class="card-title h5 mb-4">Данные о квартире:</h3>
                <table class="table table-borderless align-middle">
                    <tbody>
                        <tr>
                            <th class="text-muted" style="width: 300px;">Застройщик:</th>
                            <td>{{ $apartment->developer }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted">ЖК:</th>
                            <td>{{ $apartment->complex }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted">Цена:</th>
                            <td class="fw-bold">{{ number_format($apartment->price, 0, '.', ' ') }} руб.</td>
                        </tr>
                        <tr>
                            <th class="text-muted">Изменение с начала отслеживания:</th>
                            <td>
                                @php
                                    $totalDiff = $apartment->price - $apartment->initial_price;
                                    $totalPercent =
                                        $apartment->initial_price > 0
                                            ? ($totalDiff / $apartment->initial_price) * 100
                                            : 0;
                                @endphp

                                <span
                                    class="fw-bold {{ $totalDiff > 0 ? 'text-danger' : ($totalDiff < 0 ? 'text-success' : 'text-dark') }}">
                                    {{ $totalDiff > 0 ? '+' : '' }}{{ number_format($totalDiff, 0, '.', ' ') }} руб.
                                    ({{ number_format($totalPercent, 2) }}%)
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th class="text-muted">Комнат:</th>
                            <td>{{ $apartment->rooms_count }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted">Площадь:</th>
                            <td>{{ $apartment->area }} м²</td>
                        </tr>
                        <tr>
                            <th class="text-muted">Ссылка:</th>
                            <td><a href="{{ $apartment->url }}" target="_blank"
                                    class="btn btn-outline-primary btn-sm">Перейти на сайт ПИК</a></td>
                        </tr>
                    </tbody>
                </table>
                <p class="text-muted small mt-3 mb-0">
                    Добавлено: {{ $apartment->created_at->format('d.m.Y H:i') }}
                </p>
            </div>
        </div>

        <!-- Таблица истории -->
        <div class="mt-4">
            <h3 class="h5 mb-3">История цен</h3>
            <div class="table-responsive">
                <table class="table table-striped table-hover border">
                    <thead class="table-light">
                        <tr>
                            <th>Дата изменения</th>
                            <th>Цена</th>
                            <th>Изменение цены</th>
                            <th>В процентах</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($apartment->prices->sortByDesc('created_at')->values() as $index => $price_entry)
                            @php
                                $allPrices = $apartment->prices->sortBy('created_at')->values();
                                $currentPos = $allPrices->search(fn($item) => $item->id === $price_entry->id);
                                $previous_entry = $allPrices[$currentPos - 1] ?? null;

                                $diff = $previous_entry ? $price_entry->price - $previous_entry->price : 0;
                                $percent =
                                    $previous_entry && $previous_entry->price != 0
                                        ? ($diff / $previous_entry->price) * 100
                                        : 0;
                            @endphp
                            <tr>
                                <td>{{ $price_entry->created_at->format('d.m.Y') }}</td>
                                <td class="fw-bold">{{ number_format($price_entry->price, 0, '.', ' ') }} ₽</td>
                                <td class="{{ $diff > 0 ? 'text-danger' : ($diff < 0 ? 'text-success' : 'text-muted') }}">
                                    {{ $diff > 0 ? '+' : '' }}{{ $diff != 0 ? number_format($diff, 0, '.', ' ') : '—' }}
                                </td>
                                <td
                                    class="{{ $percent > 0 ? 'text-danger' : ($percent < 0 ? 'text-success' : 'text-muted') }}">
                                    {{ $percent != 0 ? number_format($percent, 2) . '%' : '—' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
