@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Квартира #{{ $apartment->id }}</h1>

        <div class="card" style="margin-top: 20px; padding: 20px; border: 1px solid #ccc;">
            <h3>Данные об объекте:</h3>
            <ul>
                <li><strong>Адрес:</strong> {{ $apartment->address }}</li>
                <li><strong>Цена:</strong> {{ number_format($apartment->price, 0, '.', ' ') }} руб.</li>
                <li><strong>Количество комнат:</strong> {{ $apartment->rooms_count }}</li>
                <li><strong>Площадь:</strong> {{ $apartment->area }} м²</li>
                <li>
                    <strong>Ссылка на объявление:</strong> 
                    <a href="{{ $apartment->url }}" target="_blank">Перейти на сайт</a>
                </li>
            </ul>

            <p style="color: gray; font-size: 0.8em;">
                Добавлено: {{ $apartment->created_at->format('d.m.Y H:i') }}
            </p>
        </div>
    </div>
@endsection
