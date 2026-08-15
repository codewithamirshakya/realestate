<footer class="bg-brand-800 text-brand-100">
    <div class="mx-auto grid max-w-7xl gap-10 px-4 py-14 sm:px-6 md:grid-cols-4 lg:px-8">
        <div class="md:col-span-2">
            <x-logo dark />
            <x-editable key="footer.about_text" as="p" multiline class="mt-4 max-w-sm text-sm text-brand-200" />
            <x-editable key="footer.about_text_np" as="p" multiline class="mt-3 max-w-sm text-sm text-brand-300" />
        </div>

        <div>
            <x-editable key="footer.explore_title" as="h3" class="text-sm font-semibold uppercase tracking-wider text-white" />
            <ul class="mt-4 space-y-2 text-sm text-brand-200">
                <li><a href="{{ route('properties.index', ['listing_type' => 'sale']) }}" class="hover:text-accent-300">Properties for sale</a></li>
                <li><a href="{{ route('properties.index', ['listing_type' => 'rent']) }}" class="hover:text-accent-300">Properties for rent</a></li>
                <li><a href="{{ route('services.index') }}" class="hover:text-accent-300">Our services</a></li>
                <li><a href="{{ route('register') }}" class="hover:text-accent-300">List your property</a></li>
            </ul>
        </div>

        <div>
            <x-editable key="footer.contact_title" as="h3" class="text-sm font-semibold uppercase tracking-wider text-white" />
            <ul class="mt-4 space-y-2 text-sm text-brand-200">
                <li>{{ config('company.address_en') }}</li>
                <li>{{ config('company.address_np') }}</li>
                <li><a href="tel:{{ config('company.phone') }}" class="hover:text-accent-300">{{ config('company.phone') }}</a></li>
                <li><a href="mailto:{{ config('company.email') }}" class="hover:text-accent-300">{{ config('company.email') }}</a></li>
            </ul>
        </div>
    </div>

    <div class="border-t border-white/10">
        <div class="mx-auto flex max-w-7xl flex-col items-center justify-between gap-2 px-4 py-5 text-xs text-brand-300 sm:flex-row sm:px-6 lg:px-8">
            <p>&copy; {{ now()->year }} {{ config('company.name_en') }}. All rights reserved.</p>
            <p>{{ config('company.contact_person') }} &middot; {{ config('company.name_np') }}</p>
        </div>
    </div>
</footer>
