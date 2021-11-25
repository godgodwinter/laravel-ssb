@extends('layouts.default')

@section('title')
Proses Perhitungan
@endsection

@push('before-script')

@if (session('status'))
<x-sweetalertsession tipe="{{session('tipe')}}" status="{{session('status')}}"/>
@endif
@endpush


@section('content')
<section class="section">
    <div class="section-header">
        <h1>@yield('title')</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{route('dashboard')}}">Dashboard</a></div>
            {{-- <div class="breadcrumb-item"><a href="#">Layout</a></div> --}}
            <div class="breadcrumb-item">@yield('title')</div>
        </div>
    </div>

    <div class="section-body">


        <div class="card">
            <div class="card-body" id="babengcardDate">
                <h5>Ambil nilai Weight: bobot kriteria / 100</h5>
                <table id="example" class="table table-striped table-bordered mt-1 table-sm" style="width:100%">
                    <thead>
                        <tr style="background-color: #F1F1F1">
                            <th class="text-center py-2 babeng-min-row"  rowspan="2"  class="text-center"  style="vertical-align: middle">
                                No</th>
                            <th rowspan="2"  class="text-center" style="vertical-align: middle">Nama </th>
                            @forelse ($ambildataposisiseleksi as $item)
                                <th colspan="4"  class="text-center" >{{$item->posisipemain->nama}}</th>
                            @empty
                                <th>Data tidak ditemukan</th>
                            @endforelse
                        </tr>
                        <tr style="background-color: #F1F1F1">
                            @forelse ($ambildataposisiseleksi as $item)
                                @forelse ($ambildatakriteria as $item2)

                                <th class="text-center" >{{$item2->nama}}</th>
                                @empty

                                @endforelse


                                <th class="text-center" >Nilai Akhir</th>
                            @empty
                                <th>Data tidak ditemukan</th>
                            @endforelse
                        </tr>

                    </thead>
                    <tbody>
                        @forelse ($datas as $data)
                        <tr>
                            <td  class="babeng-min-row">
                                {{$loop->index+1}}
                            </td>
                            <td>
                                {{$data->nama}}
                            </td>

                                @forelse ($data->posisiseleksi as $item)
                                @forelse ($item->kriteria as $k)
                                    <td>
                                        {{$k->weightevaluation}}
                                    </td>
                                @empty

                                @endforelse
                                    <td class="babeng-min-row">
                                        <button class="btn btn-primary btn-sm"> {{number_format($item->nilaiakhir,2)}}</button>
                                    </td>

                                @empty
                                    Data tidak ditemukan
                                @endforelse

                        </tr>

                        @empty

                        @endforelse
                    </tbody>
                </table>


            </div>
        </div>


        <div class="card">
            <div class="card-body" id="babengcardDate">
                <h5>Langkah 1-2 : Jumlahkan semua proses penilaian per pemain per sub kriteria kemudian dibagi 100 untuk mendapatkan bobot</h5>
                <table id="example" class="table table-striped table-bordered mt-1 table-sm" style="width:100%">
                    <thead>
                        <tr style="background-color: #F1F1F1">
                            <th class="text-center py-2 babeng-min-row"  rowspan="2"  class="text-center"  style="vertical-align: middle">
                                No</th>
                            <th rowspan="2"  class="text-center" style="vertical-align: middle">Nama </th>
                            @forelse ($ambildatakriteriadetail as $item)
                                <th colspan="5"  class="text-center" >{{$item->nama}}</th>
                            @empty
                                <th>Data tidak ditemukan</th>
                            @endforelse
                        </tr>
                        <tr style="background-color: #F1F1F1">

                            @forelse ($ambildatakriteriadetail as $item)
                                @forelse ($ambilprosespenilaian as $p)
                                    <th >{{$p->nama}}</th>
                                @empty

                                <th rowspan="5">Proses Penilaia ntidak ditemukan</th>

                                @endforelse

                            <th rowspan="2">AVG </th>
                            <th rowspan="2">Bobot</th>
                            @empty
                                <th>Data tidak ditemukan</th>
                            @endforelse
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($datas as $data)
                        <tr>
                            <td  class="babeng-min-row">
                                {{$loop->index+1}}
                            </td>
                            <td>
                                {{$data->nama}}
                            </td>

                                @forelse ($data->kriteriadetail as $kd)
                                    @forelse ($kd->nilai as $n)
                                    <td class="babeng-min-row" >
                                       {{number_format($n->nilai,2)}}
                                    </td>
                                    @empty
                                    <td>

                                        Data tidak ditemukan
                                    </td>
                                    @endforelse
                                    <td class="babeng-min-row">
                                        <button class="btn btn-light btn-sm">{{number_format($kd->avg,2)}}</button>
                                    </td>
                                    <td class="babeng-min-row">
                                        <button class="btn btn-primary btn-sm"> {{number_format($kd->bobot,2)}}</button>
                                    </td>
                                    </td>

                                @empty
                                    Data tidak ditemukan
                                @endforelse

                        </tr>

                        @empty

                        @endforelse
                    </tbody>
                </table>


            </div>
        </div>



        <div class="card">
            <div class="card-body" id="babengcardDate">
                <h5>Langkah 3 : Tempatkan sub kriteria ke dalam posisi kemudiam Jumlah kan dan bagi dengan Jumlah data sub kriteria(Evolution)</h5>
                <table id="example" class="table table-striped table-bordered mt-1 table-sm" style="width:100%">
                    <thead>
                        <tr style="background-color: #F1F1F1">
                            <th class="text-center py-2 babeng-min-row"  rowspan="2"  class="text-center"  style="vertical-align: middle">
                                No</th>
                            <th rowspan="2"  class="text-center" style="vertical-align: middle">Nama </th>
                            @forelse ($ambildataposisiseleksi as $item)
                                <th colspan="4"  class="text-center" >{{$item->posisipemain->nama}}</th>
                            @empty
                                <th>Data tidak ditemukan</th>
                            @endforelse
                        </tr>
                        <tr style="background-color: #F1F1F1">
                            @forelse ($ambildataposisiseleksi as $item)
                                @forelse ($ambildatakriteria as $item2)

                                <th class="text-center" >{{$item2->nama}}</th>
                                @empty

                                @endforelse


                                <th class="text-center" >Nilai Akhir</th>
                            @empty
                                <th>Data tidak ditemukan</th>
                            @endforelse
                        </tr>

                    </thead>
                    <tbody>
                        @forelse ($datas as $data)
                        <tr>
                            <td  class="babeng-min-row">
                                {{$loop->index+1}}
                            </td>
                            <td>
                                {{$data->nama}}
                            </td>

                                @forelse ($data->posisiseleksi as $item)
                                @forelse ($item->kriteria as $k)
                                    <td>
                                        {{$k->weightevaluation}}
                                    </td>
                                @empty

                                @endforelse
                                    <td class="babeng-min-row">
                                        <button class="btn btn-primary btn-sm"> {{number_format($item->nilaiakhir,2)}}</button>
                                    </td>

                                @empty
                                    Data tidak ditemukan
                                @endforelse

                        </tr>

                        @empty

                        @endforelse
                    </tbody>
                </table>


            </div>
        </div>





        <div class="card">
            <div class="card-body" id="babengcardDate">
                <h5>Langkah 4 : Ambil weight kriteria kemudian kalikan Evolution (Evolution)</h5>
                <table id="example" class="table table-striped table-bordered mt-1 table-sm" style="width:100%">
                    <thead>
                        <tr style="background-color: #F1F1F1">
                            <th class="text-center py-2 babeng-min-row"  rowspan="2"  class="text-center"  style="vertical-align: middle">
                                No</th>
                            <th rowspan="2"  class="text-center" style="vertical-align: middle">Nama </th>
                            @forelse ($ambildataposisiseleksi as $item)
                                <th colspan="4"  class="text-center" >{{$item->posisipemain->nama}}</th>
                            @empty
                                <th>Data tidak ditemukan</th>
                            @endforelse
                        </tr>
                        <tr style="background-color: #F1F1F1">
                            @forelse ($ambildataposisiseleksi as $item)
                                @forelse ($ambildatakriteria as $item2)

                                <th class="text-center" >{{$item2->nama}}</th>
                                @empty

                                @endforelse


                                <th class="text-center" >Nilai Akhir</th>
                            @empty
                                <th>Data tidak ditemukan</th>
                            @endforelse
                        </tr>

                    </thead>
                    <tbody>
                        @forelse ($datas as $data)
                        <tr>
                            <td  class="babeng-min-row">
                                {{$loop->index+1}}
                            </td>
                            <td>
                                {{$data->nama}}
                            </td>

                                @forelse ($data->posisiseleksi as $item)
                                @forelse ($item->kriteria as $k)
                                    <td>
                                        {{$k->weightevaluation}}
                                    </td>
                                @empty

                                @endforelse
                                    <td class="babeng-min-row">
                                        <button class="btn btn-primary btn-sm"> {{number_format($item->nilaiakhir,2)}}</button>
                                    </td>

                                @empty
                                    Data tidak ditemukan
                                @endforelse

                        </tr>

                        @empty

                        @endforelse
                    </tbody>
                </table>


            </div>
        </div>


        <div class="card">
            <div class="card-body" id="babengcardDate">
                <h5>Langkah 5 : Jumlahkan Weight Evolution</h5>
                <table id="example" class="table table-striped table-bordered mt-1 table-sm" style="width:100%">
                    <thead>
                        <tr style="background-color: #F1F1F1">
                            <th class="text-center py-2 babeng-min-row"  rowspan="2"  class="text-center"  style="vertical-align: middle">
                                No</th>
                            <th rowspan="2"  class="text-center" style="vertical-align: middle">Nama </th>
                            @forelse ($ambildataposisiseleksi as $item)
                                <th colspan="4"  class="text-center" >{{$item->posisipemain->nama}}</th>
                            @empty
                                <th>Data tidak ditemukan</th>
                            @endforelse
                        </tr>
                        <tr style="background-color: #F1F1F1">
                            @forelse ($ambildataposisiseleksi as $item)
                                @forelse ($ambildatakriteria as $item2)

                                <th class="text-center" >{{$item2->nama}}</th>
                                @empty

                                @endforelse


                                <th class="text-center" >Nilai Akhir</th>
                            @empty
                                <th>Data tidak ditemukan</th>
                            @endforelse
                        </tr>

                    </thead>
                    <tbody>
                        @forelse ($datas as $data)
                        <tr>
                            <td  class="babeng-min-row">
                                {{$loop->index+1}}
                            </td>
                            <td>
                                {{$data->nama}}
                            </td>

                                @forelse ($data->posisiseleksi as $item)
                                @forelse ($item->kriteria as $k)
                                    <td>
                                        {{$k->weightevaluation}}
                                    </td>
                                @empty

                                @endforelse
                                    <td class="babeng-min-row">
                                        <button class="btn btn-primary btn-sm"> {{number_format($item->nilaiakhir,2)}}</button>
                                    </td>

                                @empty
                                    Data tidak ditemukan
                                @endforelse

                        </tr>

                        @empty

                        @endforelse
                    </tbody>
                </table>


            </div>
        </div>



        <div class="card">
            <div class="card-body" id="babengcardDate">
                <h5>Hasil 1 : Posisi Terbaik Pemain</h5>
                <table id="example" class="table table-striped table-bordered mt-1 table-sm" style="width:100%">
                    <thead>
                        <tr style="background-color: #F1F1F1">
                            <th class="text-center py-2 babeng-min-row"  rowspan="2"  class="text-center"  style="vertical-align: middle">
                                No</th>
                            <th rowspan="2"  class="text-center" style="vertical-align: middle">Nama </th>
                            @forelse ($ambildataposisiseleksi as $item)
                                <th colspan="4"  class="text-center" >{{$item->posisipemain->nama}}</th>
                            @empty
                                <th>Data tidak ditemukan</th>
                            @endforelse
                        </tr>
                        <tr style="background-color: #F1F1F1">
                            @forelse ($ambildataposisiseleksi as $item)
                                @forelse ($ambildatakriteria as $item2)

                                <th class="text-center" >{{$item2->nama}}</th>
                                @empty

                                @endforelse


                                <th class="text-center" >Nilai Akhir</th>
                            @empty
                                <th>Data tidak ditemukan</th>
                            @endforelse
                        </tr>

                    </thead>
                    <tbody>
                        @forelse ($datas as $data)
                        <tr>
                            <td  class="babeng-min-row">
                                {{$loop->index+1}}
                            </td>
                            <td>
                                {{$data->nama}}
                            </td>

                                @forelse ($data->posisiseleksi as $item)
                                @forelse ($item->kriteria as $k)
                                    <td>
                                        {{$k->weightevaluation}}
                                    </td>
                                @empty

                                @endforelse
                                    <td class="babeng-min-row">
                                        <button class="btn btn-primary btn-sm"> {{number_format($item->nilaiakhir,2)}}</button>
                                    </td>

                                @empty
                                    Data tidak ditemukan
                                @endforelse

                        </tr>

                        @empty

                        @endforelse
                    </tbody>
                </table>


            </div>
        </div>


        <div class="card">
            <div class="card-body" id="babengcardDate">
                <h5>Hasil 2 : Squad Terbaik</h5>
                <table id="example" class="table table-striped table-bordered mt-1 table-sm" style="width:100%">
                    <thead>
                        <tr style="background-color: #F1F1F1">
                            <th class="text-center py-2 babeng-min-row"  rowspan="2"  class="text-center"  style="vertical-align: middle">
                                No</th>
                            <th rowspan="2"  class="text-center" style="vertical-align: middle">Nama </th>
                            @forelse ($ambildataposisiseleksi as $item)
                                <th colspan="4"  class="text-center" >{{$item->posisipemain->nama}}</th>
                            @empty
                                <th>Data tidak ditemukan</th>
                            @endforelse
                        </tr>
                        <tr style="background-color: #F1F1F1">
                            @forelse ($ambildataposisiseleksi as $item)
                                @forelse ($ambildatakriteria as $item2)

                                <th class="text-center" >{{$item2->nama}}</th>
                                @empty

                                @endforelse


                                <th class="text-center" >Nilai Akhir</th>
                            @empty
                                <th>Data tidak ditemukan</th>
                            @endforelse
                        </tr>

                    </thead>
                    <tbody>
                        @forelse ($datas as $data)
                        <tr>
                            <td  class="babeng-min-row">
                                {{$loop->index+1}}
                            </td>
                            <td>
                                {{$data->nama}}
                            </td>

                                @forelse ($data->posisiseleksi as $item)
                                @forelse ($item->kriteria as $k)
                                    <td>
                                        {{$k->weightevaluation}}
                                    </td>
                                @empty

                                @endforelse
                                    <td class="babeng-min-row">
                                        <button class="btn btn-primary btn-sm"> {{number_format($item->nilaiakhir,2)}}</button>
                                    </td>

                                @empty
                                    Data tidak ditemukan
                                @endforelse

                        </tr>

                        @empty

                        @endforelse
                    </tbody>
                </table>


            </div>
        </div>





    </div>
</section>
@endsection


@section('containermodal')

@endsection
