@extends('layouts.guest')

@section('page_title', 'Home')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                 <div class="card shadow-sm">
                    <div class="card-header">
                        Homepage
                    </div>
                    <div class="card-body">
                        @auth('user')
                            You are logged in as a user!
                        @elseauth('admin')
                            You are logged in as an admin!
                        @else
                            You are not logged in!
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
