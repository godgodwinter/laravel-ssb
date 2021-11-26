@extends('layouts.default')

@section('title')
Posisi Pemain
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
            <div class="breadcrumb-item"><a href="{{route('tahunpenilaian')}}">Tahun Penilaian</a></div>
            <div class="breadcrumb-item"><a href="{{route('tahunpenilaian.detail',$tahunpenilaian->id)}}">Detail</a></div>
            <div class="breadcrumb-item"><a href="{{route('pemainseleksi',$tahunpenilaian->id)}}">@yield('title')</a></div>
            <div class="breadcrumb-item">Tambah</div>
        </div>
    </div>

    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <h5>Tambah</h5>
            </div>
            <div class="card-body">

                <form action="{{route('pemainseleksi.store',$tahunpenilaian->id)}}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="row">


                    <div class="form-group col-md-5 col-5 mt-0 ml-5">
                        <select class="js-example-basic-single form-control-sm @error('pemain_id')
                        is-invalid
                    @enderror" name="pemain_id"  style="width: 75%" required>

                        @foreach ($pemain as $t)
                            <option value="{{ $t->id }}"> {{ $t->nama }}</option>
                        @endforeach
                      </select>
                    </div>


                    </div>

                    <div class="card-footer text-right mr-5">
                        <button class="btn btn-primary">Simpan</button>
                    </div>
                </form>


            </div>
        </div>
    </div>
</section>
@endsection
