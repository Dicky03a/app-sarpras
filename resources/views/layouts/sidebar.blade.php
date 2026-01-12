<div x-show="sidebarOpen"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="-translate-x-full"
    x-transition:enter-end="translate-x-0"
    x-transition:leave="transition ease-in duration-300"
    x-transition:leave-start="translate-x-0"
    x-transition:leave-end="-translate-x-full"
    class="h-screen rounded-tr-3xl rounded-br-3xl fixed left-0 top-0 z-40 bg-slate-50 py-6 px-4 w-[250px] transform lg:translate-x-0 lg:z-auto lg:relative lg:block transition-all duration-300"
    :class="{'lg:w-[70px]': !sidebarOpen}"
    x-cloak>
    <div class="flex flex-col h-full">

        {{-- Logo --}}
        <div class="logo flex flex-row justify-center items-center gap-x-2">
            <img src="{{ asset('images/logo-unugiri.png') }}" alt="logo" class="w-10">
            <h2 x-show="sidebarOpen" class="font-bold text-2xl text-indigo-950 transition-all duration-300 overflow-hidden">
                Sarpras
            </h2>
        </div>

        {{-- MENU --}}
        <div x-show="sidebarOpen" class="flex flex-col gap-y-10 mt-20 transition-all duration-30 justify-between h-full" :class="{'lg:items-center': !sidebarOpen}">

            <div>
                <h6 class="text-sm text-gray-400 font-semibold mb-4">GENERAL</h6>
                <ul class="flex flex-col gap-y-2">
                    <li>
                        <a href="{{ route('admin.dashboard') }}"
                            class="flex items-center gap-x-2 font-semibold border-2 text-base p-2 rounded-lg text-gray-700 hover:bg-green-400 hover:text-white transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            <span x-show="sidebarOpen" class="truncate">Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('categories.index') }}" class="flex items-center gap-x-2 font-semibold border-2 text-base p-2 rounded-lg text-gray-700 hover:bg-green-400 hover:text-white transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                            </svg>
                            <span x-show="sidebarOpen" class="truncate">Category</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('assets.index') }}" class="flex items-center gap-x-2 font-semibold border-2 text-base p-2 rounded-lg text-gray-700 hover:bg-green-400 hover:text-white transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            <span x-show="sidebarOpen" class="truncate">Asset</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('borrowings.index') }}" class="flex items-center gap-x-2 font-semibold border-2 text-base p-2 rounded-lg text-gray-700 hover:bg-green-400 hover:text-white transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path>
                            </svg>
                            <span x-show="sidebarOpen" class="truncate">Peminjaman</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div x-data="{ open: false }" class="relative">
                <!-- Button Setting -->
                <button
                    @click="open = !open"
                    class="w-full flex items-center gap-x-2 font-semibold border-2 text-base p-2 rounded-lg text-gray-700 hover:bg-green-400 hover:text-white transition">
                    <!-- Icon Setting -->
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11.983 13.93a1.947 1.947 0 100-3.894 1.947 1.947 0 000 3.894z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 11-2.83 2.83l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 11-4 0v-.09a1.65 1.65 0 00-1-1.51 1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 11-2.83-2.83l.06-.06a1.65 1.65 0 00.33-1.82 1.65 1.65 0 00-1.51-1H3a2 2 0 110-4h.09a1.65 1.65 0 001.51-1 1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 112.83-2.83l.06.06a1.65 1.65 0 001.82.33H9a1.65 1.65 0 001-1.51V3a2 2 0 114 0v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 112.83 2.83l-.06.06a1.65 1.65 0 00-.33 1.82V9c0 .69.4 1.31 1.51 1.31H21a2 2 0 110 4h-.09a1.65 1.65 0 00-1.51 1z" />
                    </svg>

                    <span x-show="sidebarOpen">Setting</span>

                    <!-- Arrow -->
                    <svg class="w-4 h-4 ml-auto transition-transform"
                        :class="open ? 'rotate-180' : ''"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <!-- Dropdown Menu (ke atas) -->
                <div
                    x-show="open"
                    @click.outside="open = false"
                    x-transition
                    class="absolute bottom-full mb-2 w-full bg-white border rounded-lg shadow-lg overflow-hidden">
                    <a href="{{ route('home') }}"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-100">
                        Home
                    </a>

                    <a href="{{ route('profile.edit') }}"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-100">
                        Profile
                    </a>

                    <!-- Logout -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-100">
                            Logout
                        </button>
                    </form>
                </div>
            </div>


        </div>

        {{-- Collapsed sidebar indicator for desktop --}}
        <div x-show="!sidebarOpen" class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 hidden lg:block">
            <div class="flex flex-col items-center">
                <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </div>
        </div>
    </div>
</div>