@extends('layouts.app')

@section('title', 'Profile')

@section('content')
    <div class="py-4">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">{{ __('Profile') }}</h5>
                            <div class="mb-4">
                                <livewire:profile.update-profile-information-form />
                            </div>
                            <div class="mb-4">
                                <livewire:profile.update-password-form />
                            </div>
                            <div>
                                <livewire:profile.delete-user-form />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
