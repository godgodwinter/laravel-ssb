<x-cetak-css></x-cetak-css>
<body>
<x-cetak-kop></x-cetak-kop>

    <div style="margin-bottom: 0;text-align:center;margin-top:16px" id="judul">
        <h2>Laporan Proses Penilaian {{$tahunpenilaian->nama}} </h2>
        <p for=""></p>
    </div>


    <div id="judul2">
        <h4>1. Posisi Terbaik Pemain</h4>
    </div>

    {{-- <center><h2>@yield('title')</h2></center> --}}


    <br>
    <table width="100%" id="tableBiasa">
        <tr>
            <th rowspan="2">
                No
            </th>
            <th rowspan="2">
                Nama Pemain
            </th>
            <th colspan="{{$tahunpenilaian->jml}}">
                Posisi Terbaik
            </th>


        </tr>
        <tr>
            <td align="center">1</td>
            <td align="center">2</td>
            <td align="center">3</td>
        </tr>
        @forelse ($datas as $data)
        <tr>

            <td class="babeng-min-row">{{$loop->index+1}}</td>

            <td>{{$data->nama}}</td>
            @forelse ($data->posisiterbaik as $posisi)
            <td>
                {{$posisi->nama}} - <i>Skor = {{$posisi->total}}</i>
            </td>
            @empty
            <td>Data tidak ditemukan</td>
            @endforelse
            {{-- <td > {{$data->member->nama}}</td> --}}
            {{-- <td > {{$data->treatment->nama}}</td> --}}
        </tr>

        @empty
        <tr>


            <td colspan="5"> Data tidak ditemukan</td>
        </tr>

        @endforelse
    </table>


    <br>
    <br>
    <br>

    <div id="judul2">
        <h4>2. Posisi Terbaik keseluruhan</h4>
    </div>

    {{-- <center><h2>@yield('title')</h2></center> --}}


    <br>
    <table width="100%" id="tableBiasa">
        <tr>
            <th rowspan="2">
                No
            </th>
            <th rowspan="2">
                Nama Pemain
            </th>
            <th colspan="{{$tahunpenilaian->jml}}">
                Pemain Terbaik
            </th>


        </tr>
        <tr>
            <td align="center">1</td>
            <td align="center">2</td>
            <td align="center">3</td>
        </tr>
        @forelse ($hasil2 as $data)
        <tr>

            <td class="babeng-min-row">{{$loop->index+1}}</td>

            <td>{{$data->nama}}</td>
            @forelse ($data->pemainterbaik as $pemain)
            <td>
                {{$pemain->nama}} - <i>Skor = {{$pemain->total}}</i>
            </td>
            @empty
            <td>Data tidak ditemukan</td>
            @endforelse
            {{-- <td > {{$data->member->nama}}</td> --}}
            {{-- <td > {{$data->treatment->nama}}</td> --}}
        </tr>

        @empty
        <tr>


            <td colspan="5"> Data tidak ditemukan</td>
        </tr>

        @endforelse
    </table>



</body>

</html>
