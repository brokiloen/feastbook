@extends('layouts.admin')

@section('page-title', 'Users')

@section('content')
<div class="flex justify-between items-center mb-6">
    <p class="text-gray-600">Manage users</p>
    <a href="{{ route('admin.users.create') }}" class="bg-burgundy text-white px-4 py-2 rounded hover:bg-burgundy-dark transition-colors">
        + Add User
    </a>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($users as $user)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap font-medium text-wood">{{ $user->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-gray-500">{{ $user->email }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($user->is_admin)
                            <span class="px-2 py-1 text-xs font-semibold bg-burgundy text-white rounded-full">Admin</span>
                        @else
                            <span class="px-2 py-1 text-xs font-semibold bg-gray-200 text-gray-700 rounded-full">User</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-gray-500 text-sm">{{ $user->created_at->format('d.m.Y') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                        <a href="{{ route('admin.users.edit', $user) }}" class="text-burgundy hover:underline mr-4">Edit</a>
                        @if($user->id !== auth()->id())
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Delete</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                        No users yet.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
