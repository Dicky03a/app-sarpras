<nav class="bg-white border-b" x-data="{ open: false }">
    <div class="flex items-center justify-between w-full max-w-[1130px] py-[22px] mx-auto px-4">

        <!-- Logo -->
        <a href="{{ route('home') }}">
            <img src="/images/logos/logo.svg" alt="logo" class="h-8">
        </a>

        <!-- Desktop Menu -->
        <ul class="hidden md:flex items-center gap-[50px] font-medium">
            <li><a href="{{ route('home') }}" class="hover:text-blue-600">Home</a></li>
            <li><a href="{{ route('asset.front') }}" class="hover:text-blue-600">Aset</a></li>
            <li><a href="{{ route('category.front') }}" class="hover:text-blue-600">Categories</a></li>
            <li><a href="{{ route('public.report.damage.form') }}" class="hover:text-blue-600">Lapor</a></li>
        </ul>

        <!-- Desktop Auth Button -->
        <div class="hidden md:flex">
            @auth
            <a href="{{ getDashboardRedirect() }}"
                class="flex items-center gap-[10px] rounded-full border border-[#000929] py-3 px-5 font-semibold">
                Dashboard
            </a>
            @else
            <a href="{{ route('login') }}"
                class="flex items-center gap-[10px] rounded-full border border-[#000929] py-3 px-5 font-semibold">
                Sign In
            </a>
            @endauth
        </div>

        <!-- Mobile Hamburger -->
        <button @click="open = !open"
            class="md:hidden flex items-center justify-center w-10 h-10 rounded-lg border">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                    stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </div>

    <!-- Mobile Menu -->
    <div x-show="open" x-transition
        class="md:hidden bg-white border-t px-6 py-4 space-y-4">

        <a href="{{ route('home') }}" class="block font-medium">Home</a>
        <a href="{{ route('asset.front') }}" class="block font-medium">Aset</a>
        <a href="{{ route('category.front') }}" class="block font-medium">Categories</a>
        <a href="#" class="block font-medium">Lapor</a>

        <div class="pt-4 border-t">
            @auth
            <a href="{{ getDashboardRedirect() }}"
                class="block text-center rounded-full border border-[#000929] py-3 font-semibold">
                Dashboard
            </a>
            @else
            <a href="{{ route('login') }}"
                class="block text-center rounded-full border border-[#000929] py-3 font-semibold">
                Sign In
            </a>
            @endauth
        </div>
    </div>
</nav>