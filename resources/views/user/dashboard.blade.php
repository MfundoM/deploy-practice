@extends('layouts.user')

@section('page_title', 'Dashboard')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            Dashboard
                        </li>
                    </ol>
                </nav>
            </div>
            <div class="col-12">
                 <div class="card shadow-sm">
                    <div class="card-header">
                        User Dashboard
                    </div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                            You are logged in as a user!
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
