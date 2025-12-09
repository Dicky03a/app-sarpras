<aside
  :class="sidebarToggle ? 'translate-x-0 lg:w-[90px]' : '-translate-x-full'"
  class="sidebar fixed left-0 top-0 z-9999 flex h-screen w-[290px] flex-col overflow-y-hidden border-r border-gray-200 bg-white px-5 lg:static lg:translate-x-0">
  <!-- SIDEBAR HEADER -->
  <div
    :class="sidebarToggle ? 'justify-center' : 'justify-between'"
    class="flex items-center gap-2 pt-8 sidebar-header pb-7">
    <a href="index.html">
      <span class="logo" :class="sidebarToggle ? 'hidden' : ''">
        <img class="dark:hidden" src="./images/logo/logo.svg" alt="Logo" />
        <img
          class="hidden"
          src="./images/logo/logo-dark.svg"
          alt="Logo" />
      </span>

      <img
        class="logo-icon"
        :class="sidebarToggle ? 'lg:block' : 'hidden'"
        src="./images/logo/logo-icon.svg"
        alt="Logo" />
    </a>
  </div>
  <!-- SIDEBAR HEADER -->

  <div
    class="flex flex-col overflow-y-auto duration-300 ease-linear no-scrollbar">
    <!-- Sidebar Menu -->
    <nav x-data="{selected: $persist('Dashboard')}">
      <!-- Menu Group -->
      <div>
        <h3 class="mb-4 text-xs uppercase leading-[20px] text-gray-400">
          <span
            class="menu-group-title"
            :class="sidebarToggle ? 'lg:hidden' : ''">
            MENU
          </span>

          <svg
            :class="sidebarToggle ? 'lg:block hidden' : 'hidden'"
            class="mx-auto fill-current menu-group-icon"
            width="24"
            height="24"
            viewBox="0 0 24 24"
            fill="none"
            xmlns="http://www.w3.org/2000/svg">
            <path
              fill-rule="evenodd"
              clip-rule="evenodd"
              d="M5.99915 10.2451C6.96564 10.2451 7.74915 11.0286 7.74915 11.9951V12.0051C7.74915 12.9716 6.96564 13.7551 5.99915 13.7551C5.03265 13.7551 4.24915 12.9716 4.24915 12.0051V11.9951C4.24915 11.0286 5.03265 10.2451 5.99915 10.2451ZM17.9991 10.2451C18.9656 10.2451 19.7491 11.0286 19.7491 11.9951V12.0051C19.7491 12.9716 18.9656 13.7551 17.9991 13.7551C17.0326 13.7551 16.2491 12.9716 16.2491 12.0051V11.9951C16.2491 11.0286 17.0326 10.2451 17.9991 10.2451ZM13.7491 11.9951C13.7491 11.0286 12.9656 10.2451 11.9991 10.2451C11.0326 10.2451 10.2491 11.0286 10.2491 11.9951V12.0051C10.2491 12.9716 11.0326 13.7551 11.9991 13.7551C12.9656 13.7551 13.7491 12.9716 13.7491 12.0051V11.9951Z"
              fill="" />
          </svg>
        </h3>

        <ul class="flex flex-col gap-4 mb-6">
          <!-- Menu Item Dashboard -->
          <li>
            <a
              href="dashboard"
              @click="selected = (selected === 'Dashboard' ? '' : 'Dashboard')"
              class="menu-item group"
              :class=" (selected === 'Dashboard') && (page === 'dashboard') ? 'menu-item-active' : 'menu-item-inactive'">

              <!-- ICON DASHBOARD BARU -->
              <svg
                :class="(selected === 'Dashboard') && (page === 'dashboard') ? 'menu-item-icon-active' : 'menu-item-icon-inactive'"
                width="24"
                height="24"
                viewBox="0 0 24 24"
                fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path d="M3 13H11V3H3V13Z" />
                <path d="M13 21H21V11H13V21Z" />
                <path d="M13 3V9H21V3H13Z" />
                <path d="M3 21H9V15H3V21Z" />
              </svg>

              <span
                class="menu-item-text"
                :class="sidebarToggle ? 'lg:hidden' : ''">
                Dashboard
              </span>
            </a>
          </li>

          <!-- Menu Item Dashboard -->

          <!-- Menu Item Calendar -->
          <li>
            <a
              href="{{ route('categories.index') }}"
              @click="selected = (selected === 'Category' ? '' : 'Category')"
              class="menu-item group"
              :class=" (selected === 'Category') && (page === 'category') ? 'menu-item-active' : 'menu-item-inactive'">

              <!-- ICON BARU: GRID / CATEGORY -->
              <svg
                :class="(selected === 'Category') && (page === 'category') ? 'menu-item-icon-active' : 'menu-item-icon-inactive'"
                width="24"
                height="24"
                viewBox="0 0 24 24"
                fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path d="M4 4H10V10H4V4Z" />
                <path d="M14 4H20V10H14V4Z" />
                <path d="M4 14H10V20H4V14Z" />
                <path d="M14 14H20V20H14V14Z" />
              </svg>

              <span
                class="menu-item-text"
                :class="sidebarToggle ? 'lg:hidden' : ''">
                Category
              </span>
            </a>
          </li>

          <!-- Menu Item Asset -->
          <li>
            <a
              href="{{ route('assets.index') }}"
              @click="selected = (selected === 'Asset' ? '' : 'Asset')"
              class="menu-item group"
              :class=" (selected === 'Asset') && (page === 'asset') ? 'menu-item-active' : 'menu-item-inactive'">

              <!-- ICON: ASSET -->
              <svg
                :class="(selected === 'Asset') && (page === 'asset') ? 'menu-item-icon-active' : 'menu-item-icon-inactive'"
                width="24"
                height="24"
                viewBox="0 0 24 24"
                fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path d="M20 7H4C2.9 7 2.01 7.9 2.01 9L2 18C2 19.1 2.9 20 4 20H20C21.1 20 22 19.1 22 18V9C22 7.9 21.1 7 20 7ZM20 18H4V10H20V18ZM4 8V5H20V8H4Z" />
              </svg>

              <span
                class="menu-item-text"
                :class="sidebarToggle ? 'lg:hidden' : ''">
                Asset
              </span>
            </a>
          </li>

          <!-- Menu Item Borrowings -->
          <li>
            <a
              href="{{ route('borrowings.index') }}"
              @click="selected = (selected === 'Borrowing' ? '' : 'Borrowing')"
              class="menu-item group"
              :class=" (selected === 'Borrowing') && (page === 'borrowing') ? 'menu-item-active' : 'menu-item-inactive'">

              <!-- ICON: BORROWING -->
              <svg
                :class="(selected === 'Borrowing') && (page === 'borrowing') ? 'menu-item-icon-active' : 'menu-item-icon-inactive'"
                width="24"
                height="24"
                viewBox="0 0 24 24"
                fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path d="M20 2H8C6.9 2 6 2.9 6 4V16C6 17.1 6.9 18 8 18H20C21.1 18 22 17.1 22 16V4C22 2.9 21.1 2 20 2ZM20 16H8V4H20V16ZM4 6H2V20C2 21.1 2.9 22 4 22H18V20H4V6Z" />
              </svg>

              <span
                class="menu-item-text"
                :class="sidebarToggle ? 'lg:hidden' : ''">
                Borrowing
              </span>
            </a>
          </li>

          <!-- Menu Item Report Damage -->
          <li>
            <a
              href="{{ route('reportdamages.index') }}"
              @click="selected = (selected === 'ReportDamage' ? '' : 'ReportDamage')"
              class="menu-item group"
              :class=" (selected === 'ReportDamage') && (page === 'reportdamage') ? 'menu-item-active' : 'menu-item-inactive'">

              <!-- ICON: REPORT DAMAGE -->
              <svg
                :class="(selected === 'ReportDamage') && (page === 'reportdamage') ? 'menu-item-icon-active' : 'menu-item-icon-inactive'"
                width="24"
                height="24"
                viewBox="0 0 24 24"
                fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z" />
              </svg>

              <span
                class="menu-item-text"
                :class="sidebarToggle ? 'lg:hidden' : ''">
                Report Damage
              </span>
            </a>
          </li>
        </ul>
      </div>

      <!-- Others Group -->
      <div>
        <h3 class="mb-4 text-xs uppercase leading-[20px] text-gray-400">
          <span
            class="menu-group-title"
            :class="sidebarToggle ? 'lg:hidden' : ''">
            others
          </span>

          <svg
            :class="sidebarToggle ? 'lg:block hidden' : 'hidden'"
            class="mx-auto fill-current menu-group-icon"
            width="24"
            height="24"
            viewBox="0 0 24 24"
            fill="none"
            xmlns="http://www.w3.org/2000/svg">
            <path
              fill-rule="evenodd"
              clip-rule="evenodd"
              d="M5.99915 10.2451C6.96564 10.2451 7.74915 11.0286 7.74915 11.9951V12.0051C7.74915 12.9716 6.96564 13.7551 5.99915 13.7551C5.03265 13.7551 4.24915 12.9716 4.24915 12.0051V11.9951C4.24915 11.0286 5.03265 10.2451 5.99915 10.2451ZM17.9991 10.2451C18.9656 10.2451 19.7491 11.0286 19.7491 11.9951V12.0051C19.7491 12.9716 18.9656 13.7551 17.9991 13.7551C17.0326 13.7551 16.2491 12.9716 16.2491 12.0051V11.9951C16.2491 11.0286 17.0326 10.2451 17.9991 10.2451ZM13.7491 11.9951C13.7491 11.0286 12.9656 10.2451 11.9991 10.2451C11.0326 10.2451 10.2491 11.0286 10.2491 11.9951V12.0051C10.2491 12.9716 11.0326 13.7551 11.9991 13.7551C12.9656 13.7551 13.7491 12.9716 13.7491 12.0051V11.9951Z"
              fill="" />
          </svg>
        </h3>

        <ul class="flex flex-col gap-4 mb-6">
          <!-- Menu Item Authentication -->
          <li>
            <a
              href="#"
              @click.prevent="selected = (selected === 'Authentication' ? '':'Authentication')"
              class="menu-item group"
              :class="(selected === 'Authentication') || (page === 'basicChart' || page === 'advancedChart') ? 'menu-item-active' : 'menu-item-inactive'">
              <svg
                :class="(selected === 'Authentication') || (page === 'basicChart' || page === 'advancedChart') ? 'menu-item-icon-active'  :'menu-item-icon-inactive'"
                width="24"
                height="24"
                viewBox="0 0 24 24"
                fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path
                  fill-rule="evenodd"
                  clip-rule="evenodd"
                  d="M14 2.75C14 2.33579 14.3358 2 14.75 2C15.1642 2 15.5 2.33579 15.5 2.75V5.73291L17.75 5.73291H19C19.4142 5.73291 19.75 6.0687 19.75 6.48291C19.75 6.89712 19.4142 7.23291 19 7.23291H18.5L18.5 12.2329C18.5 15.5691 15.9866 18.3183 12.75 18.6901V21.25C12.75 21.6642 12.4142 22 12 22C11.5858 22 11.25 21.6642 11.25 21.25V18.6901C8.01342 18.3183 5.5 15.5691 5.5 12.2329L5.5 7.23291H5C4.58579 7.23291 4.25 6.89712 4.25 6.48291C4.25 6.0687 4.58579 5.73291 5 5.73291L6.25 5.73291L8.5 5.73291L8.5 2.75C8.5 2.33579 8.83579 2 9.25 2C9.66421 2 10 2.33579 10 2.75L10 5.73291L14 5.73291V2.75ZM7 7.23291L7 12.2329C7 14.9943 9.23858 17.2329 12 17.2329C14.7614 17.2329 17 14.9943 17 12.2329L17 7.23291L7 7.23291Z"
                  fill="" />
              </svg>

              <span
                class="menu-item-text"
                :class="sidebarToggle ? 'lg:hidden' : ''">
                Authentication
              </span>

              <svg
                class="menu-item-arrow absolute right-2.5 top-1/2 -translate-y-1/2 stroke-current"
                :class="[(selected === 'Authentication') ? 'menu-item-arrow-active' : 'menu-item-arrow-inactive', sidebarToggle ? 'lg:hidden' : '' ]"
                width="20"
                height="20"
                viewBox="0 0 20 20"
                fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path
                  d="M4.79175 7.39584L10.0001 12.6042L15.2084 7.39585"
                  stroke=""
                  stroke-width="1.5"
                  stroke-linecap="round"
                  stroke-linejoin="round" />
              </svg>
            </a>

            <!-- Dropdown Menu Start -->
            <div
              class="overflow-hidden transform translate"
              :class="(selected === 'Authentication') ? 'block' :'hidden'">
              <ul
                :class="sidebarToggle ? 'lg:hidden' : 'flex'"
                class="flex flex-col gap-1 mt-2 menu-dropdown pl-9">
                <li>
                  <a
                    href="signin.html"
                    class="menu-dropdown-item group"
                    :class="page === 'signin' ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive'">
                    Sign In
                  </a>
                </li>
                <li>
                  <a
                    href="signup.html"
                    class="menu-dropdown-item group"
                    :class="page === 'signup' ? 'menu-dropdown-item-active' : 'menu-dropdown-item-inactive'">
                    Sign Up
                  </a>
                </li>
              </ul>
            </div>
            <!-- Dropdown Menu End -->
          </li>
          <!-- Menu Item Authentication -->
        </ul>
      </div>
    </nav>
    <!-- Sidebar Menu -->

  </div>
</aside>