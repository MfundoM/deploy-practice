<!DOCTYPE html>
<html lang="en-ZA">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stack('meta')
    <title>@yield('page_title', config('app.name'))</title>
    <link rel="preconnect" href="//fonts.googleapis.com">
    <link rel="preconnect" href="//fonts.gstatic.com">
    <link rel="stylesheet" href="{{ mix('css/guest.css') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
@stack('head')
</head>
<body>
    <div id="app">
        @include('partials.guest.navbar')

        <main role="main" class="py-4">
            @yield('content')
        </main>

        @include('partials.guest.footer')

        @if(session()->has('sweetalert'))<sweet-alert alert="{{ json_encode(session('sweetalert')) }}"></sweet-alert>@endif
    </div>

    <script src="{{ mix('js/manifest.js') }}"></script>
    <script src="{{ mix('js/vendor.js') }}"></script>
    <script src="{{ mix('js/guest.js') }}"></script>
    @stack('scripts')

</body>
</html>
