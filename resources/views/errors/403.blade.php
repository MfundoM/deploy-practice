@extends('errors::guest')

@section('title', 'Forbidden')
@section('code', 403)
@section('message', $exception->getMessage() ?: 'You are forbidden from accessing this page.')
