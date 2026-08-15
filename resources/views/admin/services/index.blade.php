@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
    <div class="grid gap-8 lg:grid-cols-[220px_1fr]">
        @include('partials.dashboard-nav', ['role' => 'admin'])

        <div>
            <h1 class="font-serif text-2xl font-bold text-brand-900">Services</h1>
            <p class="mt-1 text-brand-400">Manage the services shown on your Services page.</p>

            <div class="mt-6 space-y-4">
                @foreach ($services as $service)
                    <details class="card p-5">
                        <summary class="cursor-pointer font-semibold text-brand-800">{{ $service->title_en }} <span class="text-brand-400">({{ $service->title_np }})</span></summary>
                        <form method="POST" action="{{ route('admin.services.update', $service) }}" class="mt-4 grid gap-3 sm:grid-cols-2">
                            @csrf @method('PATCH')
                            <div>
                                <label class="form-label">Title (English)</label>
                                <input type="text" name="title_en" value="{{ $service->title_en }}" class="form-input" required>
                            </div>
                            <div>
                                <label class="form-label">Title (Nepali)</label>
                                <input type="text" name="title_np" value="{{ $service->title_np }}" class="form-input">
                            </div>
                            <div class="sm:col-span-2">
                                <label class="form-label">Description (English)</label>
                                <textarea name="description_en" rows="2" class="form-textarea" required>{{ $service->description_en }}</textarea>
                            </div>
                            <div class="sm:col-span-2">
                                <label class="form-label">Description (Nepali)</label>
                                <textarea name="description_np" rows="2" class="form-textarea">{{ $service->description_np }}</textarea>
                            </div>
                            <div>
                                <label class="form-label">Icon</label>
                                <select name="icon" class="form-select">
                                    @foreach (['building', 'calculator', 'ruler', 'map', 'bank', 'draft', 'home'] as $icon)
                                        <option value="{{ $icon }}" @selected($service->icon === $icon)>{{ ucfirst($icon) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="form-label">Sort order</label>
                                <input type="number" name="sort_order" value="{{ $service->sort_order }}" class="form-input">
                            </div>
                            <div class="flex items-end gap-2 sm:col-span-2">
                                <button type="submit" class="btn-primary !px-4 !py-2 text-xs">Save</button>
                            </div>
                        </form>
                        <form method="POST" action="{{ route('admin.services.destroy', $service) }}" class="mt-2" onsubmit="return confirm('Remove this service?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-xs font-semibold text-red-500 hover:text-red-600">Remove service</button>
                        </form>
                    </details>
                @endforeach
            </div>

            <div class="card mt-6 p-5">
                <h2 class="font-semibold text-brand-800">Add a new service</h2>
                <form method="POST" action="{{ route('admin.services.store') }}" class="mt-4 grid gap-3 sm:grid-cols-2">
                    @csrf
                    <div>
                        <label class="form-label">Title (English)</label>
                        <input type="text" name="title_en" class="form-input" required>
                    </div>
                    <div>
                        <label class="form-label">Title (Nepali)</label>
                        <input type="text" name="title_np" class="form-input">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="form-label">Description (English)</label>
                        <textarea name="description_en" rows="2" class="form-textarea" required></textarea>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="form-label">Description (Nepali)</label>
                        <textarea name="description_np" rows="2" class="form-textarea"></textarea>
                    </div>
                    <div>
                        <label class="form-label">Icon</label>
                        <select name="icon" class="form-select">
                            @foreach (['building', 'calculator', 'ruler', 'map', 'bank', 'draft', 'home'] as $icon)
                                <option value="{{ $icon }}">{{ ucfirst($icon) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Sort order</label>
                        <input type="number" name="sort_order" value="0" class="form-input">
                    </div>
                    <div class="sm:col-span-2">
                        <button type="submit" class="btn-primary !px-4 !py-2 text-xs">Add Service</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
