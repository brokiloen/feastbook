@extends('layouts.admin')

@section('page-title', 'Add User')

@section('content')
<div class="max-w-xl">
    <a href="{{ route('admin.users.index') }}" class="text-burgundy hover:underline mb-4 inline-block">&larr; Back to Users</a>

    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf

            <div class="mb-6">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Name *</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}"
                       class="w-full border-gray-300 rounded-md shadow-sm focus:ring-burgundy focus:border-burgundy @error('name') border-red-500 @enderror"
                       required>
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}"
                       class="w-full border-gray-300 rounded-md shadow-sm focus:ring-burgundy focus:border-burgundy @error('email') border-red-500 @enderror"
                       required>
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password *</label>
                <input type="password" name="password" id="password"
                       class="w-full border-gray-300 rounded-md shadow-sm focus:ring-burgundy focus:border-burgundy @error('password') border-red-500 @enderror"
                       required>
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirm Password *</label>
                <input type="password" name="password_confirmation" id="password_confirmation"
                       class="w-full border-gray-300 rounded-md shadow-sm focus:ring-burgundy focus:border-burgundy"
                       required>
            </div>

            <div class="mb-6">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_admin" value="1" {{ old('is_admin') ? 'checked' : '' }}
                           class="rounded border-gray-300 text-burgundy focus:ring-burgundy">
                    <span class="text-sm font-medium text-gray-700">Administrator</span>
                </label>
            </div>

            <div class="flex gap-4 pt-4 border-t">
                <button type="submit" class="bg-burgundy text-white px-6 py-2 rounded hover:bg-burgundy-dark transition-colors">
                    Create User
                </button>
                <a href="{{ route('admin.users.index') }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded hover:bg-gray-300 transition-colors">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
