@extends('layouts.default')

@section('title')
Tahun Penilaian
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
            <div class="card-body">

                <div class="d-flex bd-highlight mb-3 align-items-center">

                    <div class="p-2 bd-highlight">

                        <form action="{{ route('tahunpenilaian.cari') }}" method="GET">
                            <input type="text" class="babeng babeng-select  ml-0" name="cari">
                        </div>
                        <div class="p-2 bd-highlight">
                            <span>
                                <input class="btn btn-info ml-1 mt-2 mt-sm-0" type="submit" id="babeng-submit"
                                    value="Cari">
                            </span>
                        </div>

                        <div class="ml-auto p-2 bd-highlight">
                        </form>

                    </div>
                </div>




                @if($datas->count()>0)
                    <x-jsdatatable/>
                @endif

                <x-jsmultidel link="{{route('tahunpenilaian.multidel')}}" />

                <table id="example" class="table table-striped table-bordered mt-1 table-sm" style="width:100%">
                    <thead>
                        <tr style="background-color: #F1F1F1">
                            <th class="text-center py-2 babeng-min-row">
                                 No</th>
                            <th >Nama </th>
                            <th class="text-center" >Status </th>
                            <th  class="text-center">Kuota </th>
                            <th >Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($datas as $data)

                        @php
                        $status='Proses';
                        $warna='info';
                        if($data->status=='Selesai'){
                            $status='Selesai';
                            $warna='success';
                        }
                    @endphp
                        <tr id="sid{{ $data->id }}">
                                <td class="text-center">

                                    {{ ((($loop->index)+1)+(($datas->currentPage()-1)*$datas->perPage())) }}</td>
                                <td>
                                    {{$data->nama}}
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-{{$warna}} btn-round btn-sm">{{$status}}</button>
                                </td>
                                <td class="text-center">
                                    {{$data->jml}}
                                </td>
                                <td class="text-center babeng-min-row">

                                    @if ($status=='Selesai')

                                    {{-- <a class="btn btn-info btn-sm" href="{{route('tahunpenilaian.detail',$data->id)}}"  data-toggle="tooltip" data-placement="top" title="Lihat Nilai Saya!">
                                        <i class="fas fa-angle-double-right"></i>
                                    </a> --}}

                                    <a href="{{route('pemain.prosesperhitungan.grafikhasilpenilaian',$data->id)}}" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="Lihat Grafik!"><i class="fas fa-chart-bar"></i></a>

                                    {{-- <a href="{{route('pemain.prosesperhitungan.cetakhasilpenilaian',$data->id)}}" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="Cetak PDF!"><i class="fas fa-file-pdf"></i></a> --}}

                                    @else

                                    {{-- <a class="btn btn-dark btn-sm" href="#"  data-toggle="tooltip" data-placement="top" title="Lihat Nilai Saya! Tunggu Proses Selesai">
                                        <i class="fas fa-angle-double-right"></i>
                                    </a> --}}

                                    <a href="#" class="btn btn-dark btn-sm" data-toggle="tooltip" data-placement="top" title=" Selesaikan Proses dahulu untuk Lihat Grafik!"><i class="fas fa-chart-bar"></i></a>

                                    {{-- <a href="#" class="btn btn-dark btn-sm" data-toggle="tooltip" data-placement="top" title="Selesaikan Proses dahulu untuk Cetak PDF!"><i class="fas fa-file-pdf"></i></a> --}}
                                    @endif
                                </td>


                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Data tidak ditemukan</td>
                            </tr>
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
