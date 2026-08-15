@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
    <div class="grid gap-8 lg:grid-cols-[220px_1fr]">
        @include('partials.dashboard-nav', ['role' => 'admin'])

        <div>
            <h1 class="font-serif text-2xl font-bold text-brand-900">Inquiries</h1>

            <form method="GET" class="mt-4 flex flex-wrap gap-2">
                <a href="{{ route('admin.inquiries.index') }}" class="btn-outline !px-3 !py-1.5 text-xs {{ request('status') ? '' : '!bg-brand-600 !text-white' }}">All</a>
                @foreach (['new', 'contacted', 'closed'] as $status)
                    <a href="{{ route('admin.inquiries.index', ['status' => $status]) }}" class="btn-outline !px-3 !py-1.5 text-xs capitalize {{ request('status') === $status ? '!bg-brand-600 !text-white' : '' }}">{{ $status }}</a>
                @endforeach
            </form>

            <div class="mt-6 space-y-4">
                @forelse ($inquiries as $inquiry)
                    <div class="card p-5">
                        <div class="flex flex-wrap items-start justify-between gap-3">
                            <div>
                                <p class="font-semibold text-brand-800">{{ $inquiry->name }} &middot; {{ $inquiry->email }}</p>
                                @if ($inquiry->phone)
                                    <p class="text-sm text-brand-400">{{ $inquiry->phone }}</p>
                                @endif
                                <p class="mt-1 text-sm font-medium text-brand-500">
                                    {{ $inquiry->property ? 'Re: '.$inquiry->property->title : 'General inquiry' }}
                                </p>
                            </div>
                            <form method="POST" action="{{ route('admin.inquiries.update', $inquiry) }}" class="flex items-center gap-2">
                                @csrf @method('PATCH')
                                <select name="status" onchange="this.form.submit()" class="form-select !py-1.5 text-xs">
                                    @foreach (['new', 'contacted', 'closed'] as $status)
                                        <option value="{{ $status }}" @selected($inquiry->status === $status)>{{ ucfirst($status) }}</option>
                                    @endforeach
                                </select>
                            </form>
                        </div>
                        <p class="mt-3 text-sm text-brand-600">{{ $inquiry->message }}</p>
                        <div class="mt-3 flex items-center justify-between text-xs text-brand-300">
                            <span>{{ $inquiry->created_at->diffForHumans() }}</span>
                            <form method="POST" action="{{ route('admin.inquiries.destroy', $inquiry) }}" onsubmit="return confirm('Delete this inquiry?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="font-semibold text-red-500 hover:text-red-600">Delete</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="py-10 text-center text-brand-400">No inquiries yet.</p>
                @endforelse
            </div>

            <div class="mt-6">{{ $inquiries->links() }}</div>
        </div>
    </div>
</div>
@endsection
