@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="py-4">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Dashboard</h4>
                    <p class="card-text">{{ __("You're logged in!") }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
