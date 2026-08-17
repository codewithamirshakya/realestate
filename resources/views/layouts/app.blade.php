<!DOCTYPE html>
<html lang="en">
@php($cms = app(\App\Support\Cms::class))
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? $cms->value('seo.title') }} | {{ config('company.name_en') }}</title>
    <meta name="description" content="{{ $description ?? $cms->value('seo.description') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/apple-touch-icon.png') }}">
    <meta property="og:image" content="{{ asset('images/logo.png') }}">

    @fonts

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-screen flex-col bg-white text-brand-900 font-sans {{ $cms->canEdit() ? 'has-cms-bar' : '' }}">

    @include('partials.nav')

    @include('partials.flash-messages')

    <main class="flex-1">
        @yield('content')
    </main>

    @include('partials.footer')

    @include('partials.cms-toolbar')

</body>
</html>
