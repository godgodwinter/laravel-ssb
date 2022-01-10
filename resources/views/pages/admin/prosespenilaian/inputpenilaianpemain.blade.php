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
    @push('before-script')
        <script>
            let ele=null;
            function getData(link=null,pemain=null,dkd=null){
(async()=>{
const requestOptions={
    method : 'GET',
    headers:{
        "Content-Type":"application/json",
        "Accept": "application/json",
        "X-Requested-with": "XMLHttpRequest",
        "X-CSRF-Token": $('input[name="_token"]').val()
    },
};
const response = await fetch(link, requestOptions);
let data = await response.json();
if(response.ok){
    // console.log(data.data);
    $(`#isi${pemain}-${dkd}`).val(data.data);
        // ele.value=data.data;
}else{
    console.log('Eror');
}
})();
                // console.log(dkd);
            }
        </script>
    @endpush

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
                <a href="{{route('penilaian.pemain.input',[$tahunpenilaian->id,$pemain->id,$proses->id])}}" class="btn btn-{{$warna}} btn-sm ml-2">
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
                            <label for="telp">{{$dkd->nama}}<code>*)</code>
                                {{-- {{$prosesid->id}} - {{$pemain->id}} -  {{$dkd->id}} --}}
                            {{-- @php
                                $getpenilaian_id=\App\Models\penilaian::where('pemainseleksi_id',$pemain->id)->where('kriteriadetail_id',$dkd->id)->first();
                            @endphp
                            {{$getpenilaian_id}} --}}
                            </label>
                            <input type="number" name="isi" min="0" max="100" id="isi{{$pemain->id}}-{{$dkd->id}}" class="form-control @error('isi') is-invalid @enderror" value="{{old('isi')?old('isi') : '0' }}" required>
                            @error('isi')<div class="invalid-feedback"> {{$message}}</div>
                            @enderror
@push('before-script')
<script>
$(function () {
getData("{{route('api.nilaipersiswa',[$prosesid->id,$pemain->id,$dkd->id])}}",{{$pemain->id}},{{$dkd->id}});
});
</script>
@endpush
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
