<li {{ $pages == 'dashboard' ? 'class=active' : '' }}><a class="nav-link" href="{{ route('dashboard') }}"><i
            class="fas fa-home"></i> <span>Dashboard</span></a></li>

<li {{ $pages == 'tahunpenilaian' ? 'class=active' : '' }}><a class="nav-link" href="{{route('pemain.tahunpenilaian')}}"><i class="fas fa-flag-checkered"></i><span>Penilaian </span></a></li>
