@extends('errors::guest')

@section('title', 'Not Found')
@section('code', 404)
@section('message', $exception->getMessage() ?: 'The page you are looking for could not be found.')
