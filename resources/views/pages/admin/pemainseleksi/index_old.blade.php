@extends('layouts.default')

@section('title')
Pemain Seleksi (Rata-rata dari Proses Penilaian)
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
            <div class="card-body " id="babengcardDate">

                <div class="d-flex bd-highlight mb-3 align-items-center">

                    <div class="p-2 bd-highlight">
                        @forelse ($prosespenilaian as $proses)
                        <a class="btn btn-md btn-round btn-info" href="{{route('penilaiandetail',[$tahunpenilaian->id,$proses->id])}}">{{$proses->nama}}</a>

                        @empty
                        <a class="btn btn-md btn-round btn-warning" href="{{route('prosespenilaian',[$tahunpenilaian->id])}}">Belum ada proses penilaian</a>

                        @endforelse

                        </div>

                        <div class="ml-auto p-2 bd-highlight">
                            <x-button-create link="{{route('pemainseleksi.create',$tahunpenilaian->id)}}"></x-button-create>
                        </form>

                    </div>
                </div>




                @if($datas->count()>0)
                    <x-jsdatatable/>
                @endif

                <x-jsmultidel link="{{route('pemainseleksi.multidel',$tahunpenilaian->id)}}" />

                <table id="example" class="table table-striped table-bordered mt-1 table-sm" style="width:100%">
                    <thead>
                        <tr style="background-color: #F1F1F1">
                            <th class="text-center py-2 babeng-min-row"> <input type="checkbox" id="chkCheckAll"> All</th>
                            <th >Aksi</th>

                            <th >Nama </th>
                            @forelse ($datakriteriadetail as $dkd)
                                <th>
                                    {{$dkd->nama}}
                                </th>
                            @empty

                            @endforelse
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($datas as $data)
                        <tr id="sid{{ $data->id }}">
                                <td class="text-center">
                                    <input type="checkbox" name="ids" class="checkBoxClass " value="{{ $data->id }}">
                                    {{-- {{ ((($loop->index)+1)+(($datas->currentPage()-1)*$datas->perPage())) }} --}}
                                    {{$loop->index+1}}
                                </td>

                                <td class="text-center babeng-min-row">
                                    {{-- <a class="btn btn-info btn-sm" href="#">
                                        <i class="fas fa-angle-double-right"></i>
                                    </a> --}}
                                    {{-- <x-button-reset-pass link="/admin/{{ $pages }}/{{$data->id}}/reset" /> --}}
                                    {{-- <x-button-edit link="{{route('pemainseleksi.edit',[$tahunpenilaian->id,$data->id])}}" /> --}}
                                    <x-button-delete link="{{route('pemainseleksi.destroy',[$tahunpenilaian->id,$data->id])}}" />
                                </td>
                                <td>
                                    {{$data->nama}}
                                </td>
                                @forelse ($data->kriteriadetail as $item)
                                        <td id="inputnilai{{$data->id}}_{{$item->id}}" class="text-center">
                                            {{$item->nilai?$item->nilai:'Belum diisi'}}
                                            {{-- <input class="babeng text-center text-info mb-2" type="text" value="10" type="number" min="1"> --}}
                                        </td>
                                        @push('before-script')
                                            <script>


                                                $('#inputnilai{{$data->id}}_{{$item->id}}').click(function () {
                                                        let datalama='{{$item!=null? $item->nilai : '0'}}';
                                                        let td=$('#inputnilai{{$data->id}}_{{$item->id}}');
                                                    // $(this).html(`{{$data->id}}_{{$item->id}}`);

                                                    let inputan=`<input  class="babeng text-center text-info mb-2" id="inputan_{{$data->id}}_{{$item->id}}" value="{{$item->nilai?$item->nilai:'0'}}" type="number">`;
                                                    $(this).html(inputan);
                                                    let inputanobj=$('#inputan_{{$data->id}}_{{$item->id}}');
                                                    inputanobj.focusTextToEnd();


                                                    inputanobj.focusout(function (e) {
                                                        $cek=cekperubahan(datalama,inputanobj.val());
                                                        if($cek=='ok'){
                                                            nilaiakhir=bulatkan(inputanobj.val());
                                                            // console.log('kirim update');
                                                            td.html(nilaiakhir);
                                                            // switalert('success','Data berhasil diubah!');
                                                        }else{
                                                            // console.log('Data tidak berubah');
                                                            td.html(`{{$item!=null? $item->nilai : ' Belum diisi '}}`);
                                                        }
                                                    });


                                                    inputanobj.keypress(function (e) {
                                                            // e.preventDefault(e);
                                                            // ketika di enter
                                                            if (e.which == 13) {
                                                        $cek=cekperubahan(datalama,inputanobj.val());
                                                        if($cek=='ok'){
                                                                nilaiakhir=bulatkan(inputanobj.val());
                                                                console.log('kirim update');
                                                                let pemainseleksi_id={{$data->id}};
                                                                let kriteriadetail_id={{$item->id}};
                                                                let nilai=nilaiakhir;
                                                                fetch_customer_data(pemainseleksi_id,kriteriadetail_id,nilai)
                                                                $(this).html(nilaiakhir);
                                                                // switalert('success','Data berhasil diubah!');
                                                        }else{
                                                                //  console.log('Data tidak berubah');
                                                        }

                                                            }
                                                    });

                                                });



    function switalert(tipe='success',status='Berhasil!'){

Swal.fire({
    icon: tipe,
    title: status,
    // text: 'Something went wrong!',
    showConfirmButton: true,
    timer: 1000
})
}
// fungsi cek apakah data berubah
function cekperubahan(datalama='',databaru='') {
    hasil='no';
    if(datalama!=databaru){
        hasil='ok';
    }
return hasil;
}

function bulatkan(databaru=0){
if(databaru>100){
    hasil=100;
}else if(databaru<0){
    hasil=0;
}else if(databaru==null || databaru==''){
    hasil=0;
}else{
    hasil=databaru;
}
return hasil;
}

    // fungsi kirim data perubahan
    function fetch_customer_data(pemainseleksi_id = '',kriteriadetail_id='',nilai=0) {
    console.log(pemainseleksi_id);
        $.ajax({
            url: "{{ route('api.pemainseleksi.inputnilai',$tahunpenilaian->id) }}",
            method: 'GET',
            data: {
                "_token": "{{ csrf_token() }}",
                pemainseleksi_id:pemainseleksi_id,
                kriteriadetail_id:kriteriadetail_id,
            nilai:nilai,
            },
            dataType: 'json',
            success: function (data) {
                // console.log(query);

                switalert('success',data.output);
                // console.log(data.output);
                // $("#datasiswa").html(data.output);
                // console.log(data.output);
                // console.log(data.datas);
            }
        })
    }
                                            </script>
                                        @endpush
                                @empty
                                       <td> Data Belum diisi</td>
                                @endforelse


                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Data tidak ditemukan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

{{-- @php
$cari=$request->cari;
@endphp
<div class="d-flex justify-content-between flex-row-reverse mt-3">
    <div >
{{ $datas->onEachSide(1)
    ->links() }}
    </div>
    <div> --}}
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
