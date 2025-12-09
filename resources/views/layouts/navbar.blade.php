<nav class="bg-white">
    <div class="flex items-center justify-between w-full max-w-[1130px] py-[22px] mx-auto">
        <a href="{{ route('home') }}">
            <img src="/images/logos/logo.svg" alt="logo">
        </a>
        <ul class="flex items-center gap-[50px] w-fit">
            <li>
                <a href="{{ route('home') }}">Home</a>
            </li>
            <li>
                <a href="{{ route('asset.front') }}">Aset</a>
            </li>
            <li>
                <a href="{{ route('category.front') }}">Categories</a>
            </li>
            <li>
                <a href="">Lapor</a>
            </li>
        </ul>
        @auth
        <a href="{{ getDashboardRedirect() }}"
            class="flex items-center gap-[10px] rounded-full border border-[#000929] py-3 px-5">
            <span class="font-semibold">Dashboard</span>
        </a>
        @else
        <a href="{{ route('login') }}"
            class="flex items-center gap-[10px] rounded-full border border-[#000929] py-3 px-5">
            <span class="font-semibold">Sign In</span>
        </a>
        @endauth
    </div>
</nav>