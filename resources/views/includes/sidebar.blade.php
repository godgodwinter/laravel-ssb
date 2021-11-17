<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <img src='{{asset('/assets/img/kopek/cosmetics.png')}}' alt="Your Logo">
            <a href="{{route('dashboard')}}">{{Fungsi::app_nama()}}</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{route('dashboard')}}">{{Fungsi::app_namapendek()}}</a>
        </div>
        <ul class="sidebar-menu">
            {{-- <li class="menu-header">Layout v4.0</li> --}}


@if((Auth::user()->tipeuser)=='admin')

@include('includes.sidebar_admin')

@elseif((Auth::user()->tipeuser)=='member')

@include('includes.sidebar_member')

@else
@endif
        </ul>


    </aside>
</div>
