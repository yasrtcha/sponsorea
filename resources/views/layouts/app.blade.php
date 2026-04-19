<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>Sponsorea</title>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50 text-gray-800">
    
    @if(auth()->check())
        @include('components.navbar-app')
    @else
        @include('components.navbar')
    @endif

    <main>
        @yield('content')
    </main>

    @if(!auth()->check())
        @include('components.footer')
    @endif

</body>
</html>