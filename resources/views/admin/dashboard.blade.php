@extends('layouts.admin')

@section('page_title', 'Dashboard')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                 <div class="card shadow-sm">
                    <div class="card-header">
                        Admin Dashboard
                    </div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                            You are logged in as an admin!
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
