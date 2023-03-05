<div class="widget widget-dashboard">
    <ul class="list">
        @auth()
            <li class="{{ Request::is('user/hesabim') ? 'active':'' }}"><a href="{{route('user.dashboard')}}">Hesabım</a></li>
            <li class="{{ Request::is('user/profil') ? 'active':'' }}"><a href="{{route('user.detail')}}">Profil</a></li>
            <li class="{{ Request::is('user/siparisler') ? 'active':'' }}"><a href="{{route('user.orders')}}">Siparişlerim</a></li>
            <li class="{{ Request::is('user/adresler') ? 'active':'' }}"><a href="{{ route('user.addresses') }}">Adreslerim</a></li>
            <li class="{{ Request::is('user/favorilerim') ? 'active':'' }}"><a href="{{ route('user.favorites') }}">Favorilerim</a></li>
        @elseauth()
            <li class="{{ Request::is('user/favorilerim') ? 'active':'' }}"><a href="{{ route('user.favorites') }}">Favorilerim</a></li>
        @endauth
    </ul>
</div>
