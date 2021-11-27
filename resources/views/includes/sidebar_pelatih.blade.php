<li {{ $pages == 'dashboard' ? 'class=active' : '' }}><a class="nav-link" href="{{ route('dashboard') }}"><i
            class="fas fa-home"></i> <span>Dashboard</span></a></li>

<li {{ $pages == 'pemain' ? 'class=active' : '' }}><a class="nav-link" href="{{route('pemain')}}"><i class="fas fa-user-tie"></i> <span>Pemain </span></a></li>

<li {{ $pages == 'posisipemain' ? 'class=active' : '' }}><a class="nav-link" href="{{route('posisipemain')}}"><i class="fas fa-arrows-alt"></i><span>Posisi Pemain </span></a></li>

<li {{ $pages == 'tahunpenilaian' ? 'class=active' : '' }}><a class="nav-link" href="{{route('tahunpenilaian')}}"><i class="fas fa-flag-checkered"></i><span>Penilaian </span></a></li>
