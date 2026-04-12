@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <h1 class="mb-4">Квартира #{{ $apartment->id }}</h1>

        <div class="card shadow-sm mb-5">
            <div class="card-body">
                <h3 class="card-title h5 mb-4">Данные о квартире:</h3>
                <p class="text-muted small mt-3 mb-0">
                    Цена отслеживается с: {{ $apartment->created_at->format('d.m.Y H:i') }}
                </p>
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
                            <td
                                class="fw-bold {{ $apartment->getPriceTotalDiff() > 0 ? 'text-danger' : ($apartment->getPriceTotalDiff() < 0 ? 'text-success' : 'text-dark') }}">
                                {{ $apartment->getPriceTotalDiff() > 0 ? '+' : '' }}
                                {{ number_format($apartment->getPriceTotalDiff(), 0, '.', ' ') }} руб.
                                ({{ number_format($apartment->getPriceTotalDiffPercent(), 2) }}%)
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

                <form action="{{ route('apartments.destroy', $apartment->id) }}" method="POST"
                    onsubmit="return confirm('Вы уверены, что хотите прекратить отслеживание этой квартиры?')">
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-outline-danger btn-sm">
                        Удалить квартиру из отслеживаемых
                    </button>
                </form>

            </div>
        </div>

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
                            <tr>
                                <td>{{ $price_entry->created_at->format('d.m.Y') }}</td>
                                <td class="fw-bold">{{ number_format($price_entry->price, 0, '.', ' ') }} ₽</td>
                                <td
                                    class="{{ $price_entry->getPriceDiff() > 0 ? 'text-danger' : ($price_entry->getPriceDiff() < 0 ? 'text-success' : 'text-muted') }}">
                                    {{ $price_entry->getPriceDiff() > 0 ? '+' : '' }}{{ $price_entry->getPriceDiff() != 0 ? number_format($price_entry->getPriceDiff(), 0, '.', ' ') : '—' }}
                                </td>
                                <td
                                    class="{{ $price_entry->getPriceDiffPercent() > 0 ? 'text-danger' : ($price_entry->getPriceDiffPercent() < 0 ? 'text-success' : 'text-muted') }}">
                                    {{ $price_entry->getPriceDiffPercent() != 0 ? number_format($price_entry->getPriceDiffPercent(), 2) . '%' : '—' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
