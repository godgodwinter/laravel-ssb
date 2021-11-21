<li {{ $pages == 'dashboard' ? 'class=active' : '' }}><a class="nav-link" href="{{ route('dashboard') }}"><i
            class="fas fa-home"></i> <span>Dashboard</span></a></li>
<li
    class="nav-item dropdown {{ $pages == 'settings' || $pages == 'resetpassword' || $pages == 'passwordujian' ? 'active' : '' }}">
    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-cog"></i>
        <span>Pengaturan</span></a>
    <ul class="dropdown-menu">

        <li {{ $pages == 'settings' ? 'class=active' : '' }}><a class="nav-link" href="{{ route('settings') }}"><i
                    class="fas fa-cog"></i> <span>Aplikasi</span></a></li>
    </ul>
</li>
<li
    class="nav-item dropdown {{ $pages == 'pemain' || $pages == 'pelatih' || $pages == 'kriteria' || $pages == 'penilaian' || $pages == 'users' || $pages == 'posisipemain' ? 'active' : '' }}">
    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-dumpster"></i>
        <span>Mastering</span></a>
    <ul class="dropdown-menu">

        <li {{ $pages == 'pemain' ? 'class=active' : '' }}><a class="nav-link" href="{{route('pemain')}}"><i class="fas fa-user-tie"></i> <span>Pemain</span></a></li>

        <li {{ $pages == 'pelatih' ? 'class=active' : '' }}><a class="nav-link" href="{{route('pelatih')}}"><i class="fas fa-user-astronaut"></i> <span>Pelatih</span></a></li>

        <li {{ $pages == 'kriteria' ? 'class=active' : '' }}><a class="nav-link" href="{{route('kriteria')}}"><i
                    class="fas fa-passport"></i> <span>Kriteria</span></a></li>
        <li {{ $pages == 'posisipemain' ? 'class=active' : '' }}><a class="nav-link" href="{{route('posisipemain')}}"><i class="fas fa-arrows-alt"></i><span>Posisi Pemain</span></a></li>

        <li {{ $pages == 'users' ? 'class=active' : '' }}><a class="nav-link" href="{{ route('users') }}"><i class="fas fa-user"></i> <span>User</span></a></li>

        <li {{ $pages == 'tipepemain' ? 'class=active' : '' }}><a class="nav-link" href="#"><i class="fas fa-text-height"></i> <span>Tipe Penilaian</span></a></li>

    </ul>

<li {{ $pages == 'penilaian' ? 'class=active' : '' }}><a class="nav-link" href="{{route('tahunpenilaian')}}"><i class="fas fa-id-card-alt"></i><span>Penilaian </span></a></li>


<li {{ $pages == 'penilaian' ? 'class=active' : '' }}><a class="nav-link" href="#"><i class="fas fa-flag-checkered"></i><span>Hasil Penilaian </span></a></li>
