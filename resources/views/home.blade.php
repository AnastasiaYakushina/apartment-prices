@extends('layouts.app')

@section('content')
<div class="row justify-content-center align-items-center" style="min-height: 70vh;">
    <div class="col-md-8 text-center">
        <h1 class="display-4 mb-4">Мониторинг цен на квартиры</h1>
        
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <div class="card shadow-lg p-4 mb-4">
            {{ html()->form('POST', route('apartments.store'))->open() }}

                <div class="mb-3">
                    {{ html()->label('Вставьте ссылку на квартиру:', 'url')->class('form-label') }}
                    
                    {{ html()->input('url', 'url')
                        ->class('form-control form-control-lg')
                        ->placeholder('https://pik.ru...')
                        ->required()
                        ->id('url') }}
                </div>

                {{ html()->submit('Добавить в отслеживаемые')->class('btn btn-primary btn-lg w-100') }}

            {{-- Закрываем форму --}}
            {{ html()->form()->close() }}
        </div>

        <div class="mt-4">
            <a href="{{ route('apartments.index') }}" class="btn btn-outline-secondary">
                📊 Отслеживаемые квартиры
            </a>
        </div>
    </div>
</div>
@endsection
