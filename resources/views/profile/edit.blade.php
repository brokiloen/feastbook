@extends('layouts.admin')

@section('page-title', 'Profile')

@section('content')
<div class="max-w-xl space-y-6">
    <div class="bg-white rounded-lg shadow p-6">
        @include('profile.partials.update-profile-information-form')
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        @include('profile.partials.update-password-form')
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        @include('profile.partials.delete-user-form')
    </div>
</div>
@endsection
