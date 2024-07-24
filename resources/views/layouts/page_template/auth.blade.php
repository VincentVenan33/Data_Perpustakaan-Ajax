
<form id="logout-form" action="{{ route('actionlogout') }}" method="POST" style="display: none;">
    @csrf
</form>
@include('layouts.navbars.sidebar')
<div class="main-panel">
    @include('layouts.navbars.navs.auth')
    @yield('content')
    {{-- @include('layouts.footer') --}}
</div>
