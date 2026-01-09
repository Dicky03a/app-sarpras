<div class="h-screen fixed left-sidebar flex-none bg-white py-6 px-4 w-[250px] lg:block hidden">
      <div class="flex flex-col h-full">

            {{-- Logo --}}
            <div class="logo flex flex-row justify-center items-center gap-x-2">
                  <svg id="logo-85" width="40" height="40" viewBox="0 0 40 40" fill="none">
                        <path ... /> {{-- SVG tetap --}}
                  </svg>
                  <h2 class="font-bold text-2xl text-indigo-950">
                        DashPro
                  </h2>
            </div>

            {{-- MENU --}}
            <div class="flex flex-col gap-y-10 mt-20">

                  <div>
                        <h6 class="text-sm text-gray-400 font-semibold mb-4">GENERAL</h6>
                        <ul class="flex flex-col gap-y-7">
                              <li><a href="#" class="flex gap-x-2 font-semibold text-base text-violet-700">My Overview</a></li>
                              <li><a href="{{ route('categories.index') }}" class="flex gap-x-2 font-semibold text-base">Category</a></li>
                              <li><a href="{{ route('assets.index') }}" class="flex gap-x-2 font-semibold text-base">Asset</a></li>
                              <li><a href="{{ route('borrowings.index') }}" class="flex gap-x-2 font-semibold text-base">Peminjaman</a></li>
                              <!-- <li><a href="{{ route('reportdamages.index') }}" class="flex gap-x-2 font-semibold text-base">Report Damages</a></li> -->
                              <li><a href="{{ route('home') }}" class="flex gap-x-2 font-semibold text-base">Home</a></li>
                        </ul>
                  </div>

                  <div>
                        <h6 class="text-sm text-gray-400 font-semibold mb-4">OTHERS</h6>
                        <ul class="flex flex-col gap-y-7">
                              <form method="POST" action="{{ route('logout') }}">
                                    @csrf

                                    <x-responsive-nav-link :href="route('logout')"
                                          onclick="event.preventDefault();
                                        this.closest('form').submit();">
                                          {{ __('Log Out') }}
                                    </x-responsive-nav-link>
                              </form>
                        </ul>
                  </div>

            </div>
      </div>
</div>