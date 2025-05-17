<!DOCTYPE html>
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/style.css'])
    <title>@yield('title', 'Dashboard')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;700&display=swap" rel="stylesheet">
    @stack('styles')
</head>
<body>
    @include('partials.header')
    @include('partials.sidebar')

    <div class="main-content" id="main-content">
        <div class="container-fluid mt-4">
            @yield('content')
        </div>
    </div>

    @include('partials.logout-modal')

    @stack('scripts')
</body>
</html>

