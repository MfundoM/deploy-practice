{{-- <link rel="icon" type="image/png" href="{{ asset('/img/favicon.png') }} "> --}}
<meta name="api-token" content="{{ auth('admin')->user()->api_token ?? null }}">
