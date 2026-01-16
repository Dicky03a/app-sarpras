<div x-show="sidebarOpen"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="-translate-x-full"
    x-transition:enter-end="translate-x-0"
    x-transition:leave="transition ease-in duration-300"
    x-transition:leave-start="translate-x-0"
    x-transition:leave-end="-translate-x-full"
    class="h-screen fixed left-0 top-0 z-40 bg-white border-r border-gray-200 py-6 px-4 w-[280px] transform lg:translate-x-0 lg:z-auto lg:relative lg:block transition-all duration-300 shadow-xl lg:shadow-none"
    :class="{'lg:w-[80px]': !sidebarOpen}"
    x-cloak>

    <div class="flex flex-col h-full">
        {{-- Logo Section --}}
        <div class="flex items-center justify-between px-2 mb-8">
            <div class="flex items-center gap-3">

                <img src="{{ asset('images/logo-unugiri.png') }}" alt="logo" class="w-7 h-7 object-contain">

                <div x-show="sidebarOpen" x-transition class="overflow-hidden">
                    <h2 class="font-bold text-xl text-gray-900">Sarpras</h2>
                    <p class="text-xs text-gray-500">Management System</p>
                </div>
            </div>

            {{-- Mobile Close Button --}}
            <button @click="sidebarOpen = false" class="lg:hidden p-2 hover:bg-gray-100 rounded-lg transition">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        {{-- Navigation Menu --}}
        <div class="flex flex-col flex-1 justify-between overflow-y-auto">
            <div>
                {{-- General Section --}}
                <div class="mb-6">
                    <h6 x-show="sidebarOpen" class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-3 mb-3">
                        General
                    </h6>
                    <nav class="space-y-1">
                        {{-- Dashboard --}}
                        <a href="{{ route('admin.dashboard') }}"
                            class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200
                                   {{ request()->routeIs('admin.dashboard') 
                                       ? 'bg-gradient-to-r from-[#0D903A] to-[#0a6b2b] text-white shadow-lg shadow-green-500/30' 
                                       : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }}"
                            :class="{'justify-center': !sidebarOpen}">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            <span x-show="sidebarOpen" class="truncate">Dashboard</span>
                            <div x-show="!sidebarOpen" class="absolute left-full ml-6 px-2 py-1 bg-gray-900 text-white text-xs rounded-md opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap pointer-events-none">
                                Dashboard
                            </div>
                        </a>

                        {{-- Category --}}
                        <a href="{{ route('categories.index') }}"
                            class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200
                                   {{ request()->routeIs('categories.*') 
                                       ? 'bg-gradient-to-r from-[#0D903A] to-[#0a6b2b] text-white shadow-lg shadow-green-500/30' 
                                       : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }}"
                            :class="{'justify-center': !sidebarOpen}">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                            <span x-show="sidebarOpen" class="truncate">Kategori</span>
                            <div x-show="!sidebarOpen" class="absolute left-full ml-6 px-2 py-1 bg-gray-900 text-white text-xs rounded-md opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap pointer-events-none">
                                Kategori
                            </div>
                        </a>

                        {{-- Assets --}}
                        <a href="{{ route('assets.index') }}"
                            class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200
                                   {{ request()->routeIs('assets.*') 
                                       ? 'bg-gradient-to-r from-[#0D903A] to-[#0a6b2b] text-white shadow-lg shadow-green-500/30' 
                                       : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }}"
                            :class="{'justify-center': !sidebarOpen}">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            <span x-show="sidebarOpen" class="truncate">Aset</span>
                            <div x-show="!sidebarOpen" class="absolute left-full ml-6 px-2 py-1 bg-gray-900 text-white text-xs rounded-md opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap pointer-events-none">
                                Aset
                            </div>
                        </a>

                        {{-- Borrowings --}}
                        <a href="{{ route('borrowings.index') }}"
                            class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200
                                   {{ request()->routeIs('borrowings.*') 
                                       ? 'bg-gradient-to-r from-[#0D903A] to-[#0a6b2b] text-white shadow-lg shadow-green-500/30' 
                                       : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }}"
                            :class="{'justify-center': !sidebarOpen}">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                            </svg>
                            <span x-show="sidebarOpen" class="truncate">Peminjaman</span>
                            <div x-show="!sidebarOpen" class="absolute left-full ml-6 px-2 py-1 bg-gray-900 text-white text-xs rounded-md opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap pointer-events-none">
                                Peminjaman
                            </div>
                        </a>
                    </nav>
                </div>
            </div>

            {{-- Bottom Section - Settings & Logout --}}
            <div class="border-t border-gray-200 pt-4 mt-4">
                {{-- User Profile Card --}}
                <div x-show="sidebarOpen" class="mb-3 px-3 py-3 bg-gradient-to-r from-[#0D903A] to-[#0a6b2b] text-white shadow-lg shadow-green-500/30 rounded-xl">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center flex-shrink-0">
                            <span class="text-white font-semibold text-sm">{{ substr(auth()->user()->name ?? 'A', 0, 1) }}</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-white truncate">{{ auth()->user()->name ?? 'Admin' }}</p>
                            <p class="text-xs text-white truncate">{{ auth()->user()->email ?? 'admin@example.com' }}</p>
                        </div>
                    </div>
                </div>

                {{-- Settings Dropdown --}}
                <div x-data="{ open: false }" class="relative">
                    <button
                        @click="open = !open"
                        class="group w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-900 transition-all duration-200"
                        :class="{'justify-center': !sidebarOpen}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span x-show="sidebarOpen" class="flex-1 text-left">Pengaturan</span>
                        <svg x-show="sidebarOpen" class="w-4 h-4 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                        <div x-show="!sidebarOpen" class="absolute left-full ml-6 px-2 py-1 bg-gray-900 text-white text-xs rounded-md opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap pointer-events-none">
                            Pengaturan
                        </div>
                    </button>

                    {{-- Dropdown Menu --}}
                    <div
                        x-show="open"
                        @click.outside="open = false"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95"
                        x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 scale-100"
                        x-transition:leave-end="opacity-0 scale-95"
                        class="absolute bottom-full mb-2 w-full bg-white border border-gray-200 rounded-xl shadow-lg overflow-hidden z-50">
                        <div class="py-1">
                            <a href="{{ route('home') }}"
                                class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                </svg>
                                <span>Beranda</span>
                            </a>

                            <a href="{{ route('profile.edit') }}"
                                class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <span>Profil Saya</span>
                            </a>

                            <div class="border-t border-gray-100 my-1"></div>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                    </svg>
                                    <span>Keluar</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Collapsed State Indicator (Desktop Only) --}}
        <div x-show="!sidebarOpen" class="hidden lg:block absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
            <div class="flex flex-col items-center gap-1">
                <div class="w-1 h-1 bg-gray-400 rounded-full"></div>
                <div class="w-1 h-1 bg-gray-400 rounded-full"></div>
                <div class="w-1 h-1 bg-gray-400 rounded-full"></div>
            </div>
        </div>
    </div>
</div>

{{-- Overlay for mobile --}}
<div x-show="sidebarOpen"
    @click="sidebarOpen = false"
    x-transition:enter="transition-opacity ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition-opacity ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 bg-black/50 backdrop-blur-sm z-30 lg:hidden"
    x-cloak>
</div>