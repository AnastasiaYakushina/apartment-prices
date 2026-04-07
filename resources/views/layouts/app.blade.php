<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
        <div class="container">
            <a class="navbar-brand" href="/">Цены на квартиры</a>
        </div>
    </nav>

    <main class="container">
        @yield('content')
    </main>

    <footer class="container mt-5 py-3 border-top text-center text-muted">
    </footer>
</body>
</html>
