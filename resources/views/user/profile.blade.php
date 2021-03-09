@extends('layouts.user')

@section('page_title', 'Profile')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('user.dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Profile</li>
                    </ol>
                </nav>
            </div>
            @include('partials.user.sidebar')
            <div class="col-md-8">
                <div class="card shadow-sm mb-4">
                    <div class="card-header">
                        Update Profile
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('user.profile.update') }}">
                            @csrf
                            @method('PUT')

                            <div class="form-group required row">
                                <label for="first_name" class="col-md-4 col-form-label text-md-right">First Name</label>
                                <div class="col-md-7">
                                    <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name', $user->first_name) }}" placeholder="John" autocomplete="first_name" required>
                                    @error('first_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group required row">
                                <label for="last_name" class="col-md-4 col-form-label text-md-right">Last Name</label>
                                <div class="col-md-7">
                                    <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name', $user->last_name) }}" placeholder="Doe" autocomplete="last_name" required>
                                    @error('last_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group required row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>
                                <div class="col-md-7">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $user->email) }}" placeholder="john.doe@example.com" autocomplete="email" required>
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="offset-md-4 col-md-7">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="subscribed" value="1" {{ $user->subscribed ? 'checked' : null }}> Subscribed to receive emails
                                        </label>
                                    </div>
                                    @error('subscribed')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Update Profile
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card shadow-sm">
                    <div class="card-header">
                        Change password
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('user.profile.password') }}">
                            @csrf
                            @method('PUT')

                            <div class="form-group required row">
                                <label for="old_password" class="col-md-4 col-form-label text-md-right">Old Password</label>
                                <div class="col-md-7">
                                    <input id="old_password" type="password" class="form-control @error('old_password') is-invalid @enderror" name="old_password" placeholder="Old password" autocomplete="password" required>
                                    @error('old_password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group required row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">New Password</label>
                                <div class="col-md-7">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="New password" autocomplete="new-password" required>
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group required row">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirm Password</label>
                                <div class="col-md-7">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirm new password" autocomplete="new-password" required>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Update Password
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
