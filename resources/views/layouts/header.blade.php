<div class="w-full bg-white border-b border-gray-200 py-4 px-4 lg:px-7 sticky top-0 z-20 shadow-sm">
      <div class="flex justify-between items-center">
            {{-- BURGER MENU BUTTON (Mobile) --}}
            <button @click="sidebarOpen = !sidebarOpen"
                  class="lg:hidden p-2.5 rounded-xl text-gray-700 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-[#0D903A] focus:ring-offset-2 transition-all duration-200 active:scale-95">
                  <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                  </svg>
            </button>

            {{-- DESKTOP TOGGLE BUTTON --}}
            <button @click="sidebarOpen = !sidebarOpen"
                  class="hidden lg:flex items-center gap-2 p-2.5 rounded-xl text-gray-700 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-[#0D903A] focus:ring-offset-2 transition-all duration-200 active:scale-95 group">
                  <svg class="w-5 h-5 transition-transform duration-300"
                        :class="sidebarOpen ? 'rotate-180' : ''"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"></path>
                  </svg>
                  <span class="text-sm font-medium" x-text="sidebarOpen ? 'Sembunyikan Menu' : 'Tampilkan Menu'"></span>
            </button>
      </div>
</div>

{{-- Custom Scrollbar Style --}}
<style>
      .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
      }

      .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
      }

      .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 10px;
      }

      .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #9ca3af;
      }

      /* Smooth transitions for all interactive elements */
      * {
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
      }
</style>