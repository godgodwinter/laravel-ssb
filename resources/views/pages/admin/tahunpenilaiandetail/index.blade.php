@extends('layouts.default')

@section('title')
Proses Penilaian {{$tahunpenilaian->nama}}
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
            <div class="breadcrumb-item">@yield('title')</div>
        </div>
    </div>

    <div class="section-body">

        <div class="row">

        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="card card-statistic-2">
              <div class="card-stats">
                <div class="card-stats-title">
                    <h5>Master Kriteria</h5>
                  <div class="dropdown d-inline">

                  </div>
                </div>

                <div class="row">
                    <div class="card-stats-item col-6">
                      <div class="card-stats-item-count">{{$jmlkriteria}}</div>
                      <div class="card-stats-item-label">Kriteria</div>
                    </div>
                    <div class="card-stats-item col-6">
                      <div class="card-stats-item-count">{{$jmlkriteriadetail}}</div>
                      <div class="card-stats-item-label">Sub Kriteria</div>
                    </div>
                  </div>
                </div>
              <div class="text-right pt-4 pb-1 mr-2 mb-2">
                  @if ($tahunpenilaian->status!='Selesai')
                  <a href="{{route('seeder.kriteria.th',$tahunpenilaian->id)}}" class="btn btn-dark btn-sm btn-round">
                    Seeder Kriteria dan Sub
                  </a>
                  @endif
                <a href="{{route('kriteria',$tahunpenilaian->id)}}" class="btn btn-primary btn-lg btn-round">
                  Lihat Selengkapnya
                </a>
              </div>

            </div>
          </div>



          <div class="col-lg-4 col-md-4 col-sm-12">
              <div class="card card-statistic-2">
                <div class="card-stats">
                  <div class="card-stats-title">
                      <h5>Master Pemain</h5>
                    <div class="dropdown d-inline">

                    </div>
                  </div>

                  <div class="row">
                    <div class="card-stats-item col-4">
                      <div class="card-stats-item-count">{{$jmlposisi}}</div>
                      <div class="card-stats-item-label"><a class="btn btn-sm btn-info" href="{{route('posisiseleksi',$tahunpenilaian->id)}}">Posisi</a></div>
                    </div>
                    <div class="card-stats-item col-4">
                      <div class="card-stats-item-count">{{$jmprosespenilaian}}</div>
                      <div class="card-stats-item-label"><a class="btn btn-sm btn-info" href="{{route('prosespenilaian',$tahunpenilaian->id)}}">Proses Penilaian</a></div>
                    </div>
                      <div class="card-stats-item col-4">
                        <div class="card-stats-item-count">{{$jmlpemain}}</div>
                        <div class="card-stats-item-label">Pemain</div>
                      </div>
                    </div>
                  </div>
                <div class="text-right pt-4 pb-1 mr-2 mb-2">
                    @if ($tahunpenilaian->status!='Selesai')
                    <a href="{{route('seeder.posisi.th',$tahunpenilaian->id)}}" class="btn btn-dark btn-sm btn-round mb-2">
                      Seeder Posisi
                    </a>

                    <a href="{{route('seeder.prosespenilaian.th',$tahunpenilaian->id)}}" class="btn btn-dark btn-sm btn-round mb-2">
                    Seeder Proses Penilaian
                  </a>

                  <a href="{{route('seeder.pemain.th',$tahunpenilaian->id)}}" class="btn btn-dark btn-sm btn-round mb-2">
                    Seeder  Pemain
                  </a>
                  <a href="{{route('seeder.randomnilaipemain.th',$tahunpenilaian->id)}}" class="btn btn-danger btn-sm btn-round">
                    Seeder Random nilai Pemain
                  </a>
                  @endif
                  <a href="{{route('pemainseleksi',$tahunpenilaian->id)}}" class="btn btn-primary btn-lg btn-round">
                    Lihat Selengkapnya
                  </a>
                </div>

              </div>
            </div>



        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="card card-statistic-2">
              <div class="card-stats">
                <div class="card-stats-title">
                    <h5>Proses Penilaian</h5>
                  <div class="dropdown d-inline">

                  </div>
                </div>

                <div class="row">
                    <div class="card-stats-item col-6">
                      <div class="card-stats-item-count">{{$tahunpenilaian->jml}}</div>
                      <div class="card-stats-item-label">
                        <button class="btn btn-light open-modalKuota" data-toggle="modal" data-target="#modalKuota" data-judul="Jumlah Kuota"  href="#modalDialog">Kuota</button>

                        @push('before-script')
                        <script>
                            $(document).on("click", ".open-modalKuota", function () {
                            var myJudul = $(this).data('judul');
                            document.getElementById("modalJudulKuota").innerHTML = myJudul;
                        });
                        </script>
                        @endpush

                      </div>
                    </div>
                    <div class="card-stats-item col-6">
                      <div class="card-stats-item-count">Proses</div>
                      <div class="card-stats-item-label">Status</div>
                    </div>
                  </div>
                </div>
              <div class="text-right pt-4 pb-1 mr-2 mb-2">
                <button  class="btn btn-warning btn-lg btn-round modalProses" data-toggle="modal" data-target="#modalProses" >
                  Lanjutkan Proses
                </button>

                @push('before-script')
                <script>
                    $(document).on("click", ".modalProses", function () {
                    // var myJudul = $(this).data('judul');
                    // document.getElementById("modalJudulKuota").innerHTML = myJudul;
                    periksaposes();
                });

                            // fungsi kirim data periksa
                            function periksaposes(query = null) {
                            // console.log(datapertanyaan);
                                $.ajax({
                                    url: "{{ route('api.periksaminimum',$tahunpenilaian->id) }}",
                                    method: 'GET',
                                    data: {
                                        "_token": "{{ csrf_token() }}",
                                        query:query,
                                    },
                                    dataType: 'json',
                                    success: function (data) {
                $('#btnLanjutProses').prop('disabled',true);
                    if((data.pemainstatus !=null) && (data.kriteriastatus !=null) && (data.posisistatus!=null)){
                        $('#btnLanjutProses').prop('disabled',false);
                }

                                        let warna='warning';
                                        let status='Tidak Cukup';
                                        if(data.kriteriastatus!=null){
                                             warna='success';
                                             status='Ok';
                                        }

                                        let warnaposisi='warning';
                                        let statusposisi='Tidak Cukup';
                                        if(data.posisistatus!=null){
                                            warnaposisi='success';
                                            statusposisi='Ok';
                                        }

                                        let warnapemain='warning';
                                        let statuspemain='Tidak Cukup';
                                        if(data.pemainstatus!=null){
                                            warnapemain='success';
                                            statuspemain='Ok';
                                        }

                                        let warnaproses='warning';
                                        let statusproses='Tidak Cukup';
                                        if(data.prosesstatus!=null){
                                            warnaproses='success';
                                            statusproses='Ok';
                                        }
                    let divKriteria=`
                    <div class="col-8">
                        <p>Jumlah Sub Kriteria : ${data.kriteria} - min(3)</p>
                    </div>
                    <div class="col-4"><a class="btn btn-${warna} btn-sm" href="#"><i class="far fa-check-circle"></i> ${status}</a></div>
                    `;
                    let divPosisi=`
                    <div class="col-8">
                        <p>Jumlah Posisi Pemain : ${data.posisi} - min (1)</p>
                    </div>
                    <div class="col-4"><a class="btn btn-${warnaposisi} btn-sm" href="#"><i class="far fa-check-circle"></i> ${statusposisi}</a></div>
                    `;
                    let divPemain=`
                    <div class="col-8">
                        <p>Jumlah Pemain : ${data.pemain} - min (3)</p>
                    </div>
                    <div class="col-4"><a class="btn btn-${warnapemain} btn-sm" href="#"><i class="far fa-check-circle"></i> ${statuspemain}</a></div>
                    `;
                    let divProses=`
                    <div class="col-8">
                        <p>Jumlah Proses Penilaian : ${data.proses} - (1)</p>
                    </div>
                    <div class="col-4"><a class="btn btn-${warnaproses} btn-sm" href="#"><i class="far fa-check-circle"></i> ${statusproses}</a></div>
                    `;
                                        // console.log(data.kriteria);
                                        $('#divProses').html(divProses);
                                        $('#divKriteria').html(divKriteria);
                                        $('#divPosisi').html(divPosisi);
                                        $('#divPemain').html(divPemain);

                                    }
                                })
                            }
                </script>
                @endpush
              </div>

            </div>
          </div>


        </div>



        <div class="card">
            <div class="card-body"  id="babengcardDate" >

                @if ($tahunpenilaian->status!='Selesai')
                <a href="{{route('seeder.parameter.th',$tahunpenilaian->id)}}" class="btn btn-dark btn-sm btn-round">
                    Seeder Parameter Posisi
                  </a>
                  @endif




                <table id="example" class="table table-striped table-bordered mt-1 table-sm" style="width:100%">
                    <thead>
                        <tr style="background-color: #F1F1F1">
                            <th colspan="8" class="text-center"> Kesimpulan Parameter Posisi</th>
                        </tr>
                        <tr style="background-color: #F1F1F1">
                            <th class="babeng-min-row">No </th>
                            <th >Posisi </th>
                            @forelse ($datakriteria as $kriteria)
                                <th colspan="2" class="text-center">{{$kriteria->nama}}</th>

                            @empty

                            <th class="text-center">Krtieria tidak ditemukan</th>

                            @endforelse
                            {{-- <th colspan="2" class="text-center">Fisik</th>
                            <th  colspan="2" class="text-center">Teknik</th>
                            <th  colspan="2" class="text-center">Taktik</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($dataakhir as $data)
                            <tr>
                                <td>{{$loop->index+1}}</td>
                                <td>{{$data->nama}}</td>

                            @forelse ($data->kriteria as $kriteria)
                                    <td class="babeng-min-row">
                                    {{-- {{$kriteria->nama}} --}}
                                    @forelse ($kriteria->posisiseleksidetail as $posisiseleksidetail)
                                            {{-- {{$posisiseleksidetail->nama}} --}}
                                            <form action="{{ route('tahunpenilaian.detail.destroy',[$tahunpenilaian->id,$posisiseleksidetail->id]) }}" method="post" class="d-inline">
                                                @method('delete')
                                                @csrf
                                                <button class="btn btn-light btn-sm"
                                                    onclick="return  confirm('Anda yakin menghapus data ini? Y/N')"  data-toggle="tooltip" data-placement="top" title="Hapus Data!"><span
                                                        class="pcoded-micon">{{$posisiseleksidetail->nama}}</span></button>
                                            </form>
                                    @empty
                                        Data tidak ditemukan
                                    @endforelse
                                    </td>
                                    <td class="babeng-min-row">
                                        <button class="btn btn-sm btn-info open-Modal" data-toggle="modal" data-posisiseleksi_id="{{$data->id}}"   data-nama="{{$kriteria->nama}}" data-judul="Tambahkan Kriteria {{$kriteria->nama}}"  href="#modalDialog">
                                            <i class="fas fa-plus-square"></i>
                                        </button>
                                    </td>

                            @empty

                            <th class="text-center">Krtieria tidak ditemukan</th>

                            @endforelse

                                @push('before-script')
                                    <script>
                                        $(document).on("click", ".open-Modal", function () {
                                        var myNama = $(this).data('nama');
                                        var myJudul = $(this).data('judul');
                                        var posisiseleksi_id = $(this).data('posisiseleksi_id');
                                        $(".modal-body #namaKriteria").val( myNama );
                                        $(".modal-body #posisiseleksi_id").val( posisiseleksi_id );
                                        document.getElementById("modalJudul").innerHTML = myJudul;
                                        // As pointed out in comments,
                                        // it is unnecessary to have to manually call the modal.
                                        // $('#addBookDialog').modal('show');
                                        ambildata(myNama,posisiseleksi_id);
                                    });

                            // fungsi kirim data periksa
                            function ambildata(myNama = null,posisiseleksi_id=null) {
                            // console.log(datapertanyaan);
                                $.ajax({
                                    url: "{{ route('api.kriteriadetail',$tahunpenilaian->id) }}",
                                    method: 'GET',
                                    data: {
                                        "_token": "{{ csrf_token() }}",
                                        kriteria:myNama,
                                        posisiseleksi_id:posisiseleksi_id,
                                    },
                                    dataType: 'json',
                                    success: function (data) {
                                        let selectku=`
                    <select class="js-example-basic-single form-control-sm @error('kriteriadetail_id')
                    is-invalid
                @enderror" name="kriteriadetail_id"  style="width: 75%" required>`;
                // for (var item in data.datas) {
                //         selectku+=`<option value="${item}">${item}</option>`;
                // }
                data.datas.forEach(function(item){
                        selectku+=`<option value="${item.id}">${item.nama}</option>`;
                });

                  selectku+=`</select>
                  `;
                                        // console.log(data.output);
                                        // console.log(data.datas);
                                        $('#dataKriteriadetail').html(selectku);
                                        // $('#tk').prop('class',data.warna);

                                        // switalert('success',data.output);
                                        // console.log(data.output);
                                        // $("#datasiswa").html(data.output);
                                        // console.log(data.output);
                                        // console.log(data.datas);
                                    }
                                })
                            }
                                    </script>
                                @endpush
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
<!-- Modal -->
<div class="modal fade" id="modalDialog" tabindex="-1" role="dialog" aria-labelledby="modalJudul" aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalJudul">Modal</h5>
          </div>
          <form action="{{route('tahunpenilaian.detail.store',$tahunpenilaian->id)}}" method="POST" >
              @csrf
          <div class="modal-body">


                        <input type="hidden" class="form-control " required name="idProduk" id="idProduk">
                        {{-- <input  type="hidden" class="form-control " required name="stokProduk" id="stokProduk"> --}}

                {{-- <div class="form-group col-md-12 col-12 mt-0">
                    <label>Nama </label>
                    <div class="input-group"> --}}
                        <input type="hidden" class="form-control " required name="namaKriteria" id="namaKriteria" readonly>
                        <input type="hidden" class="form-control " required name="posisiseleksi_id" id="posisiseleksi_id" readonly>
                    {{-- </div>
                </div> --}}


                <div class="form-group col-md-12 col-12 mt-0" id="dataKriteriadetail">
                    <select class="js-example-basic-single form-control-sm @error('kriteriadetail_id')
                    is-invalid
                @enderror" name="kriteriadetail_id"  style="width: 75%" required>
                    @if($kriteriadetail!=null)
                    @foreach ($kriteriadetail as $t)
                        <option value="{{ $t->id }}"> {{ $t->nama }}</option>
                    @endforeach
                    @endif
                  </select>
                </div>




          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button class="btn btn-primary" id="BtnSimpanKeKeranjang">Simpan</button>
          </div>
        </form>

        </div>
    </div>
  </div>


<!-- Modal -->
<div class="modal fade" id="modalKuota" tabindex="-1" role="dialog" aria-labelledby="modalKuota" aria-hidden="true">
  <div class="modal-dialog " role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalJudulKuota">Modal</h5>
        </div>
        <form action="{{route('tahunpenilaiandetail.updatekuota',$tahunpenilaian->id)}}" method="POST" >
            @csrf
        <div class="modal-body">


                      {{-- <input  type="hidden" class="form-control " required name="stokProduk" id="stokProduk"> --}}

              {{-- <div class="form-group col-md-12 col-12 mt-0">
                  <label>Nama </label>
                  <div class="input-group"> --}}
                  {{-- </div>
              </div> --}}


              <div class="form-group col-md-12 col-12 mt-0" id="dataKriteriadetail">
                <input type="number" class="form-control " required name="jml" id="jml" min="1" value="{{$tahunpenilaian->jml?$tahunpenilaian->jml:'3'}}">
              </div>




        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button class="btn btn-primary" id="BtnSimpanKeKeranjang">Simpan</button>
        </div>
      </form>

      </div>
  </div>
</div>



<!-- Modal -->
<div class="modal fade" id="modalProses" tabindex="-1" role="dialog" aria-labelledby="modalProses" aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" >Lanjutkan Proses</h5>
          </div>
          <form action="{{route('prosesperhitungan',$tahunpenilaian->id)}}" method="GET" id="formLanjutProses">
              @csrf
          <div class="modal-body">
            <div class="row" id="divProses">
                <div class="col-8">
                    <p>Jumlah Proses Penilaian : Error</p>
                </div>
                <div class="col-4"><a class="btn btn-warning btn-sm" href="#"><i class="far fa-check-circle"></i> Ok</a></div>
            </div>
                <div class="row" id="divKriteria">
                    <div class="col-8">
                        <p>Jumlah Sub Kriteria :Error</p>
                    </div>
                    <div class="col-4"><a class="btn btn-warning btn-sm" href="#"><i class="far fa-check-circle"></i> Ok</a></div>
                </div>

                <div class="row" id="divPosisi">
                    <div class="col-8">
                        <p>Jumlah Posisi : Error </p>
                    </div>
                    <div class="col-4"><a class="btn btn-warning btn-sm" href="#"><i class="far fa-check-circle"></i> Ok</a></div>
                </div>

                <div class="row" id="divPemain">
                    <div class="col-8">
                        <p>Jumlah Pemain :Error</p>
                    </div>
                    <div class="col-4"><a class="btn btn-warning btn-sm" href="#"><i class="far fa-check-circle"></i> Ok</a></div>
                </div>





          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button class="btn btn-primary" id="btnLanjutProses" disabled>Proses</button>
          </div>
        </form>

        </div>
    </div>
  </div>
@endsection
