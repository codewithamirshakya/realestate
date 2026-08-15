@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
    <div class="grid gap-8 lg:grid-cols-[220px_1fr]">
        @include('partials.dashboard-nav', ['role' => 'admin'])

        <div>
            <h1 class="font-serif text-2xl font-bold text-brand-900">Users</h1>

            <form method="GET" class="mt-4 flex flex-wrap gap-2">
                <a href="{{ route('admin.users.index') }}" class="btn-outline !px-3 !py-1.5 text-xs {{ request('role') ? '' : '!bg-brand-600 !text-white' }}">All</a>
                @foreach (['admin', 'agent', 'buyer'] as $role)
                    <a href="{{ route('admin.users.index', ['role' => $role]) }}" class="btn-outline !px-3 !py-1.5 text-xs capitalize {{ request('role') === $role ? '!bg-brand-600 !text-white' : '' }}">{{ $role }}s</a>
                @endforeach
            </form>

            <div class="mt-6 overflow-x-auto rounded-xl border border-brand-100">
                <table class="min-w-full divide-y divide-brand-100 text-sm">
                    <thead class="bg-brand-50 text-left text-xs uppercase tracking-wide text-brand-400">
                        <tr>
                            <th class="px-4 py-3">Name</th>
                            <th class="px-4 py-3">Email</th>
                            <th class="px-4 py-3">Role</th>
                            <th class="px-4 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-brand-50">
                        @forelse ($users as $user)
                            <tr>
                                <td class="px-4 py-3 font-medium text-brand-800">{{ $user->name }}</td>
                                <td class="px-4 py-3 text-brand-500">{{ $user->email }}</td>
                                <td class="px-4 py-3">
                                    <form method="POST" action="{{ route('admin.users.update', $user) }}">
                                        @csrf @method('PATCH')
                                        <select name="role" onchange="this.form.submit()" class="form-select !py-1.5 text-xs">
                                            @foreach (['admin', 'agent', 'buyer'] as $role)
                                                <option value="{{ $role }}" @selected($user->role === $role)>{{ ucfirst($role) }}</option>
                                            @endforeach
                                        </select>
                                    </form>
                                </td>
                                <td class="px-4 py-3 text-right">
                                    @if ($user->id !== auth()->id())
                                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Delete this user?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="font-semibold text-red-500 hover:text-red-600">Delete</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="px-4 py-6 text-center text-brand-400">No users found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6">{{ $users->links() }}</div>
        </div>
    </div>
</div>
@endsection
