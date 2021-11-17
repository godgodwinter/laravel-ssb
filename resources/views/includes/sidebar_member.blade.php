<li {{ $pages == 'dashboard' ? 'class=active' : '' }}><a class="nav-link" href="{{ route('dashboard') }}"><i
            class="fas fa-home"></i> <span>Dashboard</span></a></li>

<li {{ $pages == 'testimoni' ? 'class=active' : '' }}><a class="nav-link" href="{{ route('member.testimoni') }}"><i class="fas fa-comments"></i><span>Testimoni</span></a></li>

<li {{ $pages == 'chat' ? 'class=active' : '' }}><a class="nav-link" href="{{ route('member.chat') }}"><i class="fas fa-id-card-alt"></i><span>Kontak Admin</span></a></li>


{{-- <li {{ $pages == 'keranjang' ? 'class=active' : '' }}><a class="nav-link" href="{{ route('member.keranjang') }}"><i class="fas fa-cart-arrow-down"></i><span>Keranjang</span></a></li>--}}

<li {{ $pages == 'jadwal' ? 'class=active' : '' }}><a class="nav-link" href="{{ route('member.jadwal') }}"><i class="fas fa-id-card-alt"></i><span>Jadwal treatment </span></a></li>


<li {{ $pages == 'invoice' ? 'class=active' : '' }}><a class="nav-link" href="{{ route('member.invoice') }}"><i class="fas fa-id-card-alt"></i><span>Invoice</span></a></li>

