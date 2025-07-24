@extends('layouts.app')

@section('content')
<div class="container">
    <div class="jumbotron text-center">
        <h1 class="display-4">Welcome to Document Submission App</h1>
        <p class="lead">Submit your documents and track their processing status</p>
        <hr class="my-4">
        @guest
            <p>Please login or register to submit documents</p>
            <a class="btn btn-primary btn-lg" href="{{ route('login') }}" role="button">Login</a>
            <a class="btn btn-success btn-lg" href="{{ route('register') }}" role="button">Register</a>
        @else
            <p>Go to your dashboard to submit or view documents</p>
            <a class="btn btn-primary btn-lg" href="{{ route('home') }}" role="button">Dashboard</a>
        @endguest
    </div>
</div>
@endsection