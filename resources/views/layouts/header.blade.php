<div class="w-full bg-white py-4 px-7">
      <div class="flex justify-between items-center">

            {{-- BURGER MENU BUTTON --}}
            <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden p-2 rounded-md text-gray-700 focus:outline-none">
                  <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                  </svg>
            </button>

            {{-- DESKTOP TOGGLE BUTTON --}}
            <button @click="sidebarOpen = !sidebarOpen" class="hidden lg:block p-2 rounded-md text-gray-700 focus:outline-none">
                  <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="sidebarOpen ? 'M15 18l-6-6 6-6' : 'M9 5l7 7-7 7'"></path>
                  </svg>
            </button>

            {{-- SEARCH --}}
            <div class="relative w-full md:w-[500px] lg:ml-4">
                  <input type="text" placeholder="Search new report here"
                        class="w-full py-3 rounded-full pl-5 pr-10 border border-gray-300">
                  <button class="absolute top-2 right-2 p-2 bg-violet-700 rounded-full">
                        <svg width="18" height="18" viewBox="0 0 24 24">
                              <path fill="white" d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
                        </svg>
                  </button>
            </div>

            {{-- USER --}}
            <div class="hidden md:flex items-center gap-x-3">
                  <div class="text-right">
                        <h3 class="text-indigo-950 font-semibold">Shayna Xuna</h3>
                        <p class="text-gray-500 text-sm">@shayna</p>
                  </div>
                  <img src="https://images.unsplash.com/photo-1616325629936-99a9013c29c6?q=80"
                        class="h-[50px] w-[50px] rounded-full object-cover">
            </div>

      </div>
</div>