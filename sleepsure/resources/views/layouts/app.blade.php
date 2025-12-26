<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SleepSure - @yield('title', 'Premium Mattress & Sleep Solutions')</title>

    <!-- Styles -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="icon" href="{{ $favicon_url }}" type="image/x-icon">

    @stack('styles')
</head>
<body>
    <!-- Alert Bar -->
    <div class="top-alert-bar">
        Use code SLEEP (till 1st Oct) to get up to 30% off + Additional 11% off with bank offers.
    </div>

    <!-- Header -->
    @include('partials.header')

    <!-- Main Content -->
    <main class="main-content">
        @yield('content')
    </main>

    <!-- Footer -->
    @include('partials.footer')

    <!-- Chat Button -->
    <div class="chat-button">
        <span class="material-icons">chat</span>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
    
    @stack('scripts')
</body>
</html>