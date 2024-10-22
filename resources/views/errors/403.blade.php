<!-- resources/views/errors/403.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container text-center">
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <h1 class="display-4 ">403 - Forbidden</h1>
    <p>You are not authorized to access this page.</p>
    <p>Please <a href="{{ route('register') }}">register</a> or <a href="{{ route('login') }}">login</a> to gain access.</p>
</div>
@endsection
