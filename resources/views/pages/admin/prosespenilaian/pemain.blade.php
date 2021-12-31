@extends('layouts.default')

@section('title')
Penilaian Pemain
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

                        <form action="{{ route('pemain.cari') }}" method="GET">
                            <input type="text" class="babeng babeng-select  ml-0" name="cari">
                        </div>
                        <div class="p-2 bd-highlight">
                            <span>
                                <input class="btn btn-info ml-1 mt-2 mt-sm-0" type="submit" id="babeng-submit"
                                    value="Cari">
                            </span>
                        </div>

                    </form>
                        <div class="ml-auto p-2 bd-highlight">

                            <a href="{{route('pemainseleksi.create',$tahunpenilaian->id)}}" type="submit"
                                class="btn btn-icon btn-primary  ml-0 btn-sm" data-toggle="tooltip" data-placement="top" title="Tambah data!"><span class="pcoded-micon"> <i class="fas fa-feather"></i> Tambah Pemain</span></a>


                                <a href="{{route('pemainseleksi.createangkatan',$tahunpenilaian->id)}}" type="submit"
                                    class="btn btn-icon btn-primary  ml-0 btn-sm" data-toggle="tooltip" data-placement="top" title="Tambah data!"><span class="pcoded-micon"> <i class="fas fa-feather"></i> Tambah Angkatan Pemain</span></a>

                            <a class="btn btn-dark btn-sm" href="{{route('tahunpenilaian.detail',$tahunpenilaian->id)}}">
                                Kembali
                            </a>

                    </div>
                </div>




                @if($datas->count()>0)
                    <x-jsdatatable/>
                @endif

                <x-jsmultidel link="{{route('pemain.multidel')}}" />

                <table id="example" class="table table-striped table-bordered mt-1 table-sm" style="width:100%">
                    <thead>
                        <tr style="background-color: #F1F1F1">
                            <th class="text-center py-2 babeng-min-row"> <input type="checkbox" id="chkCheckAll"> All</th>
                            <th >Nama </th>
                            @forelse ($prosespenilaian as $proses)
                                <th  class="text-center">
                                    {{$proses->nama}}
                                </th>
                            @empty

                            @endforelse
                            {{-- <th >Aksi</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($datas as $data)
                        <tr id="sid{{ $data->id }}">
                                <td class="text-center">
                                    <input type="checkbox" name="ids" class="checkBoxClass " value="{{ $data->id }}">
                                    {{ ((($loop->index)+1)+(($datas->currentPage()-1)*$datas->perPage())) }}</td>
                                <td>
                                    {{$data->pemain->nama}}
                                </td>

                            @forelse ($prosespenilaian as $proses)
                            <td class="text-center">
                                <a href="{{route('penilaian.pemain.input',[$tahunpenilaian->id,$data->id,$proses->id])}}" class="btn btn-primary btn-sm">
                                    Input Nilai
                                </a>
                            </td>
                        @empty

                        @endforelse

                                {{-- <td class="text-center babeng-min-row">
                                    <x-button-edit link="{{route('pemain.edit',[$data->id])}}" />
                                    <x-button-delete link="{{route('pemain.destroy',[$data->id])}}" />
                                </td> --}}


                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Data tidak ditemukan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

@php
$cari=$request->cari;
@endphp
<div class="d-flex justify-content-between flex-row-reverse mt-3">
    <div >
{{ $datas->onEachSide(1)
    ->links() }}
    </div>
    <div>
<a href="#" class="btn btn-sm  btn-danger mb-2" id="deleteAllSelectedRecord"
            onclick="return  confirm('Anda yakin menghapus data ini? Y/N')"  data-toggle="tooltip" data-placement="top" title="Hapus Terpilih">
            <i class="fas fa-trash-alt mr-2"></i> Hapus Terpilih</i>
        </a></div></div>

            </div>
        </div>
    </div>
</section>
@endsection


@section('containermodal')

@endsection
