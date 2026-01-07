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

<body>

    <div class="bg-gray-50">

        <div class="min-h-screen flex items-center justify-center px-4">

            {{-- CARD LOGIN --}}
            <div class="w-full max-w-md bg-white p-10 rounded-2xl shadow-md">

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="flex flex-col gap-y-7">
                        <h3 class="xl:text-4xl md:text-3xl text-2xl text-indigo-950 font-bold text-center">
                            Sign In to Your Account
                        </h3>

                        {{-- EMAIL --}}
                        <div>
                            <p class="font-semibold text-indigo-950 text-base mb-2">Email Address</p>
                            <input type="email" name="email" value="{{ old('email') }}"
                                class="w-full py-3 rounded-full pl-5 pr-10 border border-gray-300 text-indigo-950 font-semibold"
                                required autofocus>
                            @error('email')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- PASSWORD --}}
                        <div>
                            <p class="font-semibold text-indigo-950 text-base mb-2">Password</p>
                            <input type="password" name="password"
                                class="w-full py-3 rounded-full pl-5 pr-10 border border-gray-300 text-indigo-950 font-semibold"
                                required>

                            <a href="{{ route('password.request') }}"
                                class="text-sm text-blue-700 text-right mt-1 block">
                                Forgot Password?
                            </a>

                            @error('password')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- SUBMIT --}}
                        <button type="submit"
                            class="w-full rounded-full py-3 font-semibold text-white bg-violet-700">
                            Log In
                        </button>

                        <p class="text-sm text-center text-gray-600">
                            Don't have an account?
                            <a href="{{ route('register') }}" class="text-blue-700 font-semibold">
                                Sign Up
                            </a>
                        </p>
                    </div>
                </form>

            </div>
        </div>

    </div>



    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const btndropdown = document.getElementById('btn-dropdown');
            const dropdownmenu = document.getElementById('dropdown-menu');

            btndropdown?.addEventListener("click", function() {
                dropdownmenu.classList.toggle("hidden");
            });
        });
    </script>

</body>

</html>