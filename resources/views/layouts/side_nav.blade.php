<div class="sec_logo">
    <a href="" id="codeDashboardLink">
        {{-- <img class="gmb_logo" src="{{ asset('/assets/img/utama/logokunci.png') }}"
            alt="l21" /> --}}
        <h2 class="h2-title">Mini<span class="h2-title-game">Game</span></h2>
    </a>
    <svg id="icon_expand" xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-category"
        viewBox="0 0 24 24" stroke-width="1.5" fill="none" stroke-linecap="round" stroke-linejoin="round">
        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
        <path d="M4 4h6v6h-6z" />
        <path d="M14 4h6v6h-6z" />
        <path d="M4 14h6v6h-6z" />
        <path d="M17 17m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
    </svg>
</div>
<div class="sec_list_sidemenu">
    <div class="bagsearch side">
        <div class="grubsearchnav">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-search" viewBox="0 0 24 24"
                stroke-width="1.5" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                <path d="M21 21l-6 -6" />
            </svg>
            <input type="text" placeholder="Cari Tabel..." id="searchTabel" />
        </div>
    </div>
    @foreach ($menus as $groupName => $groupMenus)
        <div class="nav_group">
            <span class="title_Nav">{{ $groupName }}</span>
            <div class="list_sidejsx">
                @foreach ($groupMenus as $menu)
                    @if($menu->route == 'menu')
                        <div class="data_sidejsx {{ Request::is($menu->route . '*') || Request::is('groupmenu*') ? 'active' : '' }}">
                    @elseif($menu->route == 'user') 
                        <div class="data_sidejsx {{ Request::is($menu->route . '*') || Request::is('useraccess*') ? 'active' : '' }}">
                    @else
                        <div class="data_sidejsx {{ Request::is($menu->route . '/*') || Request::is($menu->route) ? 'active' : '' }}">
                    @endif
                        <a href="/{{ $menu->route }}">
                            {!! $menu->icon !!}
                            <span class="nav_title1">{{ $menu->name }}</span>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach

</div>
