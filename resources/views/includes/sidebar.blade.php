<!-- Menu -->
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
      <a href="#" class="app-brand-link">
        <span class="app-brand-logo demo">
          <img 
            src="{{ asset('assets/img/logo/inet_logo.png') }}" 
            alt="Logo Perusahaan" 
            width="44" 
            height="44" 
            style="vertical-align: middle;"
          />
        </span>
        <span class="app-brand-text demo menu-text fw-bolder ms-2">Inet</span>
      </a>

      <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
        <i class="bx bx-chevron-left bx-sm align-middle"></i>
      </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
      <!-- Dashboard -->
      <li class="menu-item {{ \Route::is('home') ? 'active' : '' }}">
        <a href="{{ route('home') }}" class="menu-link">
          <i class="menu-icon tf-icons bx bx-home-circle"></i>
          <div data-i18n="Analytics">Dashboard</div>
        </a>
      </li>
      <!-- product -->
      <li class="menu-header small text-uppercase">
        <span class="menu-header-text">Products</span>
      </li>
      {{-- paket internet --}}
      <li class="menu-item {{ \Route::is('internet-package.*') ? 'open active' : '' }}">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class="menu-icon tf-icons bx bx-wifi"></i>
          <div data-i18n="Account Settings">Paket Internet</div>
        </a>
        <ul class="menu-sub">
          <li class="menu-item {{ \Route::is('internet-package.index') ? 'active' : '' }}">
            <a href="{{ route('internet-package.index') }}" class="menu-link">
              <div data-i18n="Account">Lihat Paket</div>
            </a>
          </li>
          <li class="menu-item {{ \Route::is('internet-package.create') ? 'active' : '' }}">
            <a href="{{ route('internet-package.create') }}" class="menu-link">
              <div data-i18n="Notifications">Tambah Paket</div>
            </a>
          </li>
        </ul>
      </li>
      {{-- category --}}
      <li class="menu-item {{ \Route::is('category.*') ? 'open active' : '' }}">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class='menu-icon tf-icons bx bx-category'></i>
          <div data-i18n="Account Settings">Category</div>
        </a>
        <ul class="menu-sub">
          <li class="menu-item {{ \Route::is('category.index') ? 'active' : '' }}">
            <a href="{{ route('category.index') }}" class="menu-link">
              <div data-i18n="Account">Lihat Category</div>
            </a>
          </li>
          <li class="menu-item {{ \Route::is('category.create') ? 'active' : '' }}">
            <a href="{{ route('category.create') }}" class="menu-link">
              <div data-i18n="Notifications">Tambah Category</div>
            </a>
          </li>
        </ul>
      </li>

      {{-- banner --}}
      <li class="menu-item {{ \Route::is('banner.*') ? 'open active' : '' }}">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class='menu-icon bx bx-book-content'></i>
          <div data-i18n="Account Settings">Banner Data</div>
        </a>
        <ul class="menu-sub">
          <li class="menu-item {{ \Route::is('banner.index') ? 'active' : '' }}">
            <a href="{{ route('banner.index') }}" class="menu-link">
              <div data-i18n="Account">Lihat Banner</div>
            </a>
          </li>
          <li class="menu-item {{ \Route::is('banner.create') ? 'active' : '' }}">
            <a href="{{ route('banner.create') }}" class="menu-link">
              <div data-i18n="Notifications">Tambah Banner</div>
            </a>
          </li>
        </ul>
      </li>

      <!-- client -->
      <li class="menu-header small text-uppercase"><span class="menu-header-text">clients</span></li>
      <!-- pemasangan -->
      <li class="menu-item {{ \Route::is('internet-installation.*') ? 'open active' : '' }}">
        <a href="javascript:void(0)" class="menu-link menu-toggle">
          <i class="menu-icon tf-icons bx bx-user-plus"></i>
          <div data-i18n="Extended UI">Pemasangan</div>
        </a>
        <ul class="menu-sub">
          <li class="menu-item {{ \Route::is('internet-installation.index') ? 'active' : '' }}">
            <a href="{{ route('internet-installation.index') }}" class="menu-link">
              <div data-i18n="Perfect Scrollbar">Daftar</div>
            </a>
          </li>
        </ul>
      </li>
      
      <!-- users -->
      <li class="menu-item {{ \Route::is('user.*') ? 'active' : '' }}">
        <a href="{{ route('user.index') }}" class="menu-link">
          <i class="menu-icon tf-icons bx bx-user"></i>
          <div data-i18n="Basic">Users</div>
        </a>
      </li>

      <!-- notifications -->
      <li class="menu-item {{ \Route::is('notifications.*') ? 'active' : '' }}">
        <a href="{{ route('notifications.create') }}" class="menu-link">
          <i class="menu-icon tf-icons bx bx-bell-plus"></i>
          <div data-i18n="Basic">Notification</div>
        </a>
      </li>

      <!-- Assets -->
      <li class="menu-header small text-uppercase"><span class="menu-header-text">Assets</span></li>
      <!-- Region -->
      <li class="menu-item {{ \Route::is('region.*') ? 'open active' : '' }} ">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class="menu-icon tf-icons bx bx-map-pin"></i>
          <div data-i18n="Form Elements">Regions</div>
        </a>
        <ul class="menu-sub">
          <li class="menu-item {{ \Route::is('region.index') ? 'active' : '' }}">
            <a href="{{ route("region.index") }}" class="menu-link">
              <div data-i18n="Basic Inputs">Lihat Region</div>
            </a>
          </li>
          <li class="menu-item {{ \Route::is('region.create') ? 'active' : '' }}">
            <a href="{{ route("region.create") }}" class="menu-link">
              <div data-i18n="Input groups">Tambah Region</div>
            </a>
          </li>
        </ul>
      </li>
      
    </ul>
  </aside>
  <!-- / Menu -->