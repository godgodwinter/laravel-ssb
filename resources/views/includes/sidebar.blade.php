<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{route('dashboard')}}">{{Fungsi::app_nama()}}</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{route('dashboard')}}">{{Fungsi::app_namapendek()}}</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Layout 0.1</li>


@if((Auth::user()->tipeuser)=='admin')

@include('includes.sidebar_admin')

@elseif((Auth::user()->tipeuser)=='pemain')

@include('includes.sidebar_pemain')

@else
@include('includes.sidebar_pelatih')
@endif
        </ul>


    </aside>
</div>
