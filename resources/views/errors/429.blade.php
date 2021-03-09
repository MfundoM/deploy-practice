@extends('errors::guest')

@section('title', 'Too Many Requests')
@section('code', 429)
@section('message', 'You have reached your request limit, please try again later.')
