@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Список квартир</h1>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-hover border">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Застройщик</th>
                        <th>ЖК</th>
                        <th>Площадь (м²)</th>
                        <th>Комнат</th>
                        <th>Цена (руб.)</th>
                        <th>Изменение цены</th>
                        <th>Подробнее</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($apartments as $apartment)
                        <tr>
                            <td>{{ $apartment->id }}</td>
                            <td>{{ $apartment->developer }}</td>
                            <td>{{ $apartment->complex }}</td>
                            <td>{{ $apartment->area }}</td>
                            <td>{{ $apartment->rooms_count }}</td>
                            <td>{{ number_format($apartment->price, 0, '.', ' ') }}</td>
                            <td
                                class="fw-bold {{ $apartment->getPriceTotalDiff() > 0 ? 'text-danger' : ($apartment->getPriceTotalDiff() < 0 ? 'text-success' : 'text-dark') }}">
                                {{ $apartment->getPriceTotalDiff() > 0 ? '+' : '' }}
                                {{ number_format($apartment->getPriceTotalDiff(), 0, '.', ' ') }} руб.
                                ({{ number_format($apartment->getPriceTotalDiffPercent(), 2) }}%)
                            </td>
                            <td>
                                <a href="{{ route('apartments.show', $apartment) }}" class="btn btn-sm btn-info text-white">
                                    Просмотр
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if ($apartments->isEmpty())
            <div class="alert alert-warning text-center">
                Квартир пока нет. Добавьте первую!
            </div>
        @endif
    </div>
@endsection
