<div x-show="sidebarOpen"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="-translate-x-full"
     x-transition:enter-end="translate-x-0"
     x-transition:leave="transition ease-in duration-300"
     x-transition:leave-start="translate-x-0"
     x-transition:leave-end="-translate-x-full"
     class="h-screen fixed left-0 top-0 z-40 bg-white py-6 px-4 w-[250px] transform lg:translate-x-0 lg:z-auto lg:relative lg:block transition-all duration-300"
     :class="{'lg:w-[70px]': !sidebarOpen}"
     x-cloak>
      <div class="flex flex-col h-full">

            {{-- Logo --}}
            <div class="logo flex flex-row justify-center items-center gap-x-2">
                  <svg id="logo-85" width="40" height="40" viewBox="0 0 40 40" fill="none">
                        <path d="M20 38C30.4934 38 38 30.4934 38 20C38 9.50659 30.4934 2 20 2C9.50659 2 2 9.50659 2 20C2 30.4934 9.50659 38 20 38Z" stroke="#4F46E5" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M20 27C23.866 27 27 23.866 27 20C27 16.134 23.866 13 20 13C16.134 13 13 16.134 13 20C13 23.866 16.134 27 20 27Z" stroke="#4F46E5" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M33 20H31" stroke="#4F46E5" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M9 20H7" stroke="#4F46E5" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M20 33V31" stroke="#4F46E5" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M20 9V7" stroke="#4F46E5" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                  <h2 x-show="sidebarOpen" class="font-bold text-2xl text-indigo-950 transition-all duration-300 overflow-hidden">
                        DashPro
                  </h2>
            </div>

            {{-- MENU --}}
            <div x-show="sidebarOpen" class="flex flex-col gap-y-10 mt-20 transition-all duration-300">

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
                              <!-- <li><a href="{{ route('reportdamages.index') }}" class="flex gap-x-2 font-semibold border-2 text-base p-2 rounded-lg text-gray-700 hover:bg-green-400 hover:text-white transition">Report Damages</a></li> -->
                              <li>
                                  <a href="{{ route('home') }}" class="flex items-center gap-x-2 font-semibold border-2 text-base p-2 rounded-lg text-gray-700 hover:bg-green-400 hover:text-white transition">
                                      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                      </svg>
                                      <span x-show="sidebarOpen" class="truncate">Home</span>
                                  </a>
                              </li>
                        </ul>
                  </div>

                  <div>
                        <ul class="flex gap-x-2 font-semibold border-2 text-base p-2 rounded-lg text-gray-700 hover:bg-green-400 hover:text-white transition">
                              <form method="POST" action="{{ route('logout') }}">
                                    @csrf

                                    <x-responsive-nav-link :href="route('logout')"
                                          onclick="event.preventDefault();
                                        this.closest('form').submit();">
                                          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                          </svg>
                                          <span x-show="sidebarOpen" class="truncate">{{ __('Log Out') }}</span>
                                    </x-responsive-nav-link>
                              </form>
                        </ul>
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