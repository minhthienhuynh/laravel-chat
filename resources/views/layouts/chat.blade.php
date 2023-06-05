<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('layouts.partials.title-meta')

        @stack('styles')

        @include('layouts.partials.head-css')
    </head>
    <body @if(auth()->user()->options['dark-mode']) data-layout-mode="dark" @endif>
        {{ $slot }}

        @include('layouts.partials.vendor-scripts')

        @stack('scripts')

        @vite('resources/assets/js/app.js')
    </body>
</html>
