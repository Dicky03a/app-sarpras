<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased" x-data="{ sidebarOpen: true }" @resize.window="if (window.innerWidth < 1024) sidebarOpen = false;">

    <div class="flex flex-row justify-start">

        {{-- BACKDROP --}}
        <div x-show="sidebarOpen"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-30 bg-black bg-opacity-50 lg:hidden"
            @click="sidebarOpen = false"
            x-cloak>
        </div>

        {{-- SIDEBAR --}}
        @include('layouts.sidebar')

        <div class="flex-auto w-screen transition-all duration-300" :class="{'lg:pl-[10px]': sidebarOpen, 'lg:pl-[20px]': !sidebarOpen}">

            {{-- HEADER --}}
            @include('layouts.header')

            {{-- PAGE CONTENT --}}
            <main class="p-7 pt-10">
                @yield('content')
            </main>

        </div>
    </div>

    @stack('scripts')

</body>

</html>