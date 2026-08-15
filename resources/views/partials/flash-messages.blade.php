@if (session('status'))
    <div class="mx-auto mt-4 max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="rounded-lg border border-accent-200 bg-accent-50 px-4 py-3 text-sm font-medium text-accent-700">
            {{ session('status') }}
        </div>
    </div>
@endif

@if ($errors->any())
    <div class="mx-auto mt-4 max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            <p class="font-semibold">Please fix the following:</p>
            <ul class="mt-1 list-inside list-disc">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif
