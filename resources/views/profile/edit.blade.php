@extends('layouts.app')

@section('title', 'Profile')

@section('body')
<div class="row">
    <div class="col-md-12 mb-3">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4 class="card-title mb-0">Profile Information</h4>
            </div>
            <div class="card-body">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>
    </div>

    <div class="col-md-12 mb-3">
        <div class="card shadow-sm">
            <div class="card-header bg-success text-white">
                <h4 class="card-title mb-0">Update Password</h4>
            </div>
            <div class="card-body">
                @include('profile.partials.update-password-form')
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="card shadow-sm border border-danger">
            <div class="card-header bg-danger text-white">
                <h4 class="card-title mb-0">Delete Account</h4>
            </div>
            <div class="card-body">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</div>
@endsection
