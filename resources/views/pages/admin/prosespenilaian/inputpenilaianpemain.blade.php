@extends('layouts.default')

@section('title')
Pemain
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
            <div class="breadcrumb-item"><a href="{{route('pemain')}}">@yield('title')</a></div>
            <div class="breadcrumb-item">Edit</div>
        </div>
    </div>

    <div class="section-body">
        <div class="card">
            <div class="card-header">
                @forelse ($prosespenilaian as $proses)
                @php
                    $warna='primary';
                    if($proses->id==$prosesid->id){
                        $warna='success';
                    }
                @endphp
                <a href="{{route('penilaian.pemain.input',[$tahunpenilaian->id,$id->id,$proses->id])}}" class="btn btn-{{$warna}} btn-sm ml-2">
                    {{$proses->nama}}
                </a>

                @empty

                @endforelse

                <a href="{{route('penilaian.pemain',[$tahunpenilaian->id])}}" class="btn btn-dark btn-sm ml-2">
                    Kembali
                </a>

            </div>
            <div class="card-body">

                <form action="{{route('penilaian.pemain.input.store',[$tahunpenilaian->id,$id->id,$prosesid->id])}}" method="post" enctype="multipart/form-data">
                    @method('put')
                    @csrf

                    <div class="row">

                        <div class="form-group col-md-5 col-5 mt-0 ml-5">
                            <label for="nama">Nama pemain <code>*)</code></label>
                            <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" value="{{old('nama')!=null?old('nama'):$id->nama}}" readonly>
                            @error('nama')<div class="invalid-feedback" > {{$message}}</div>
                            @enderror
                        </div>

                    </div>


                        @php
                            $datakriteria=\App\Models\kriteria::where('tahunpenilaian_id',$tahunpenilaian->id)->get();
                            // dd($datakriteria);
                        @endphp
                        @forelse ($datakriteria as $kriteria)


                        <div class=" ml-5"">
                                <h3>{{$kriteria->nama}}</h3>

                                @php
                                    $datakriteriadetail=\App\Models\kriteriadetail::where('kriteria_id',$kriteria->id)->get();
                                    // dd($datakriteriadetail);
                                @endphp
                                <br>
                                <div class="row">
                        @forelse ($datakriteriadetail as $dkd)

                        <div class="form-group col-md-5 col-5 mt-0">
                            <label for="telp">{{$dkd->nama}}<code>*)</code></label>
                            <input type="number" name="isi" min="0" max="100" id="isi" class="form-control @error('isi') is-invalid @enderror" value="{{old('isi')?old('isi') : '0' }}" required>
                            @error('isi')<div class="invalid-feedback"> {{$message}}</div>
                            @enderror
                        </div>

                        @empty

                        @endforelse

                    </div>

                            </div>
                        @empty

                        @endforelse



                    <div class="card-footer text-right mr-5">
                        <button class="btn btn-primary">Simpan</button>
                    </div>
                </form>


            </div>
        </div>
    </div>
</section>
@endsection
