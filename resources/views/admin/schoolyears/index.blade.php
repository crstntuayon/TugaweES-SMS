@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white rounded-xl shadow-md">
    <h1 class="text-2xl font-bold mb-4">School Years</h1>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif

    <table class="w-full border-collapse text-sm">
        <thead>
            <tr class="bg-gray-100">
                <th class="border px-4 py-2 text-left">Name</th>
                <th class="border px-4 py-2 text-center">Active</th>
                <th class="border px-4 py-2 text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($schoolYears as $sy)
            <tr class="hover:bg-gray-50">
                <td class="border px-4 py-2">{{ $sy->name }}</td>
                <td class="border px-4 py-2 text-center">
                    @if($sy->is_active)
                        <span class="text-green-600 font-semibold">Active</span>
                    @else
                        <span class="text-gray-400">Inactive</span>
                    @endif
                </td>
                <td class="border px-4 py-2 text-center">
                    @if(!$sy->is_active)
                        <form method="POST" action="{{ route('schoolyears.activate', $sy->id) }}">
                            @csrf
                            <button class="bg-blue-500 text-white px-4 py-1 rounded hover:bg-blue-600">
                                Set Active
                            </button>
                        </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
