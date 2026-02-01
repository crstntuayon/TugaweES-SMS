@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6 bg-gray-100 min-h-screen">

    <!-- PAGE HEADER -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Manage Users</h1>
        <a href="#" 
           @click.prevent="$dispatch('open-add-admin-modal')"
           class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
           ➕ Add Admin
        </a>
    </div>

    <!-- USERS TABLE -->
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50 text-gray-700 text-sm">
                <tr>
                    <th class="px-6 py-3 text-left">Name</th>
                    <th class="px-6 py-3 text-left">Username</th>
                    <th class="px-6 py-3 text-left">Email</th>
                    <th class="px-6 py-3 text-left">Role</th>
                    <th class="px-6 py-3 text-left">Created</th>
                    <th class="px-6 py-3 text-center">Actions</th>
                </tr>
            </thead>

            <tbody class="bg-white divide-y divide-gray-200 text-sm">
                @foreach($users as $user)
                <tr>
                    <td class="px-6 py-3">
                        {{ $user->first_name }} {{ $user->last_name }}
                    </td>
                    <td class="px-6 py-3">{{ $user->username }}</td>
                    <td class="px-6 py-3">{{ $user->email }}</td>
                    <td class="px-6 py-3">{{ $user->role->name ?? 'N/A' }}</td>
                    <td class="px-6 py-3">{{ $user->created_at->format('M d, Y') }}</td>
                    <td class="px-6 py-3 text-center flex justify-center gap-2">

                        <!-- EDIT BUTTON -->
                        <a href="{{ route('admin.users.edit', $user->id) }}"
                           class="px-2 py-1 bg-yellow-400 text-white rounded hover:bg-yellow-500">
                           ✏️ Edit
                        </a>

                        <!-- DELETE BUTTON -->
                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" 
                              onsubmit="return confirm('Are you sure you want to delete this user?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600">
                                🗑️ Delete
                            </button>
                        </form>

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- PAGINATION -->
    <div class="mt-4">
        {{ $users->links() }}
    </div>
</div>
@endsection
