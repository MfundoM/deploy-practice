@extends('errors::guest')

@section('title', 'Service Unavailable')
@section('code', 503)
@section('message', $exception->getMessage() ?: 'Sorry, we are doing some maintenance. Please check back soon.')
