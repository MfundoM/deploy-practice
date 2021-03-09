@extends('errors::guest')

@section('title', 'Unauthorized')
@section('code', 401)
@section('message', $exception->getMessage() ?: 'You are not authorized to access this page.')
