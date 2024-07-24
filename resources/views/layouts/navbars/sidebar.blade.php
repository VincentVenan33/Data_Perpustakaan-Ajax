<div class="sidebar" data-color="orange">
  <!--
    Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red | yellow"
-->
  <div class="logo">
    <a href="home" class="simple-text logo-mini">
      {{ __('DS') }}
    </a>
    <a href="home" class="simple-text logo-normal">
      {{ __('Data Sekolah') }}
    </a>
  </div>
  <div class="sidebar-wrapper" id="sidebar-wrapper">
    <ul class="nav">
      <li class="@if ($activePage == 'home') active @endif">
        <a href="{{ route('home') }}">
          <i class="now-ui-icons business_bank"></i>
          <p>{{ __('Dashboard') }}</p>
        </a>
      </li>
      <li class="@if ($activePage == 'buku') active @endif">
        <a href="{{ route('buku.index') }}">
          <i class="now-ui-icons education_agenda-bookmark"></i>
          <p>{{ __('Buku') }}</p>
        </a>
      </li>
      <li class="@if ($activePage == 'kategoribuku') active @endif">
        <a href="{{ route('kategori.index') }}">
          <i class="now-ui-icons location_bookmark"></i>
          <p>{{ __('Kategori Buku') }}</p>
        </a>
      </li>
      <li class = "@if ($activePage == 'Log Out') active @endif">
        <a href="actionlogout">
          <i class="now-ui-icons media-1_button-power"></i>
          <p>{{ __('Log Out') }}</p>
        </a>
      </li>
    </ul>
  </div>
</div>
