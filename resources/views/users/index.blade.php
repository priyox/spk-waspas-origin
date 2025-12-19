@extends('layouts.app')

@section('title', 'Users')

@section('content')
    <div class="container-fluid">
        <h3>Users</h3>
        @livewire('user-manager')
    </div>
@endsection
