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
                              <li><a href="{{ route('user.dashboard') }}" class="flex gap-x-2 font-semibold text-base {{ request()->routeIs('user.dashboard') ? 'text-violet-700' : '' }}">My Overview</a></li>
                              <li><a href="{{ route('user.requests') }}" class="flex gap-x-2 font-semibold text-base {{ request()->routeIs('user.requests') ? 'text-violet-700' : '' }}">Pengajuan Saya</a></li>
                              <li><a href="{{ route('home') }}" class="flex gap-x-2 font-semibold text-base">Home</a></li>
                        </ul>
                  </div>

                  <div>
                        <h6 class="text-sm text-gray-400 font-semibold mb-4">OTHERS</h6>
                        <ul class="flex flex-col gap-y-7">
                              <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <li>
                                          <button type="submit" class="flex gap-x-2 font-semibold text-base text-left w-full hover:text-violet-700">
                                                Log Out
                                          </button>
                                    </li>
                              </form>
                        </ul>
                  </div>

            </div>
      </div>
</div>