@extends('layouts.guest')

@section('page_title')@yield('code') - @yield('title')@endsection

@section('content')
    <div class="container py-md-5">
        <div class="row justify-content-center">
            <div class="col-md-8 text-center py-4">
                <div class="display-1">
                    OOPS!
                </div>
                <div class="h3">@yield('code') - @yield('title')</div>
                <div class="my-4 h5 text-muted">@yield('message')</div>
                <div class="">
                    <a class="btn btn-primary" href="{{ url()->previous() }}" role="button">
                        <i class="fas fa-arrow-left mr-1"></i> Go Back
                    </a>
                    <a class="btn btn-primary" href="/" role="button">
                        <i class="fas fa-home mr-1"></i> Go Home
                    </a>
                    <a class="btn btn-primary" href="{{ url()->current() }}" role="button">
                        <i class="fas fa-sync mr-1"></i> Retry
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
