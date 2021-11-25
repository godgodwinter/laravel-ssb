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
            <div class="breadcrumb-item"><a href="{{route('prosespenilaian',$tahunpenilaian->id)}}">@yield('title')</a></div>
            <div class="breadcrumb-item">Edit</div>
        </div>
    </div>

    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <h5>Edit</h5>
            </div>
            <div class="card-body">

                <form action="{{route('prosespenilaian.update',[$tahunpenilaian->id,$id->id])}}" method="post" enctype="multipart/form-data">
                    @method('put')
                    @csrf

                    <div class="row">

                        <div class="form-group col-md-5 col-5 mt-0 ml-5">
                            <label for="nama">Nama  <code>*)</code></label>
                            <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" value="{{old('nama')!=null?old('nama'):$id->nama}}" required>
                            @error('nama')<div class="invalid-feedback"> {{$message}}</div>
                            @enderror
                        </div>




                        <div class="form-group col-md-5 col-5 mt-0 ml-5">
                            <label for="tgl">Tanggal Penilaian  <code>*)</code></label>
                            <input type="date" min="1"  name="tgl" id="tgl" class="form-control @error('tgl') is-invalid @enderror" value="{{old('tgl')?old('tgl'):$id->tgl}}" required>
                            @error('tgl')<div class="invalid-feedback"> {{$message}}</div>
                            @enderror
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
