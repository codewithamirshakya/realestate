@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
    <div class="grid gap-8 lg:grid-cols-[220px_1fr]">
        @include('partials.dashboard-nav', ['role' => 'admin'])

        <div>
            <div class="flex flex-wrap items-end justify-between gap-3">
                <div>
                    <h1 class="font-serif text-2xl font-bold text-brand-900">Site Content</h1>
                    <p class="mt-1 text-brand-400">Edit the text and images on the public pages. Blank fields fall back to the built-in default.</p>
                </div>

                <form method="POST" action="{{ route('admin.content.edit-mode') }}">
                    @csrf
                    <button type="submit" class="btn-outline !px-4 !py-2 text-xs">
                        {{ session(\App\Support\Cms::SESSION_KEY) ? 'Turn off inline editing' : 'Turn on inline editing' }}
                    </button>
                </form>
            </div>

            <div class="mt-6 flex flex-wrap gap-2">
                @foreach ($groups as $slug => $group)
                    <a href="{{ route('admin.content.index', ['group' => $slug]) }}"
                       class="rounded-lg px-3 py-1.5 text-sm font-semibold {{ $slug === $current ? 'bg-brand-600 text-white' : 'bg-brand-50 text-brand-600 hover:bg-brand-100' }}">
                        {{ $group['label'] }}
                    </a>
                @endforeach
            </div>

            <form method="POST" action="{{ route('admin.content.update') }}" enctype="multipart/form-data" class="card mt-6 p-6">
                @csrf

                <h2 class="font-semibold text-brand-800">{{ $definition['label'] }}</h2>
                @isset ($definition['description'])
                    <p class="mt-1 text-sm text-brand-400">{{ $definition['description'] }}</p>
                @endisset

                @error('value')
                    <p class="mt-4 rounded-lg bg-red-50 px-3 py-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
                @error('image')
                    <p class="mt-4 rounded-lg bg-red-50 px-3 py-2 text-sm text-red-600">{{ $message }}</p>
                @enderror

                <div class="mt-6 space-y-6">
                    @foreach ($definition['fields'] as $key => $field)
                        @php
                            $type = $field['type'] ?? 'text';
                            $overridden = $cms->isOverridden($key);
                        @endphp

                        <div class="border-b border-brand-50 pb-6 last:border-0 last:pb-0">
                            <div class="flex flex-wrap items-center justify-between gap-2">
                                <label class="form-label !mb-0" for="cms-{{ $loop->index }}">
                                    {{ $field['label'] }}
                                    @if ($overridden)
                                        <span class="badge ml-1 bg-accent-50 text-accent-600">edited</span>
                                    @else
                                        <span class="badge ml-1 bg-brand-50 text-brand-400">default</span>
                                    @endif
                                </label>
                                <code class="text-[11px] text-brand-300">{{ $key }}</code>
                            </div>

                            @isset ($field['help'])
                                <p class="mb-1.5 text-xs text-brand-400">{{ $field['help'] }}</p>
                            @endisset

                            @if ($type === 'image')
                                <div class="mt-2 flex flex-wrap items-center gap-4">
                                    @if ($cms->imageUrl($key))
                                        <img src="{{ $cms->imageUrl($key) }}" alt="" class="h-24 w-40 rounded-lg border border-brand-100 object-cover">
                                    @endif
                                    <input type="file" id="cms-{{ $loop->index }}" name="files[{{ $key }}]" accept="image/*"
                                           class="text-sm text-brand-600 file:mr-3 file:rounded-lg file:border-0 file:bg-brand-600 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white">
                                </div>
                            @elseif ($type === 'textarea')
                                <textarea id="cms-{{ $loop->index }}" name="values[{{ $key }}]" rows="3" class="form-textarea mt-1.5"
                                          placeholder="{{ $cms->default($key) }}">{{ $cms->override($key) }}</textarea>
                            @else
                                <input type="text" id="cms-{{ $loop->index }}" name="values[{{ $key }}]" value="{{ $cms->override($key) }}"
                                       class="form-input mt-1.5" placeholder="{{ $cms->default($key) }}">
                            @endif

                            @if ($overridden)
                                <label class="mt-2 inline-flex items-center gap-2 text-xs text-brand-400">
                                    <input type="checkbox" name="reset[{{ $key }}]" value="1" class="rounded border-brand-200">
                                    Reset to default
                                </label>
                            @endif
                        </div>
                    @endforeach
                </div>

                <div class="mt-6 flex items-center gap-3">
                    <button type="submit" class="btn-primary !px-5 !py-2.5 text-sm">Save changes</button>
                    <a href="{{ route('home') }}" class="text-sm font-semibold text-brand-500 hover:text-accent-500">View site &rarr;</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
