<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ibudaya - Authentication</title>
    {{-- Panggil CSS & JS via Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" type="image/jpg" href="{{ asset('images/icon.jpg') }}">
</head>
<body>
    <main>
        @yield('content')
    </main>
</body>
</html>