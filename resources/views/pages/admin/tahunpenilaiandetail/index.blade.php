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
            {{-- <div class="breadcrumb-item"><a href="#">Layout</a></div> --}}
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
                      <div class="card-stats-item col-6">
                        <div class="card-stats-item-count">{{$jmlpemain}}</div>
                        <div class="card-stats-item-label">Pemain</div>
                      </div>
                      <div class="card-stats-item col-6">
                        <div class="card-stats-item-count">{{$jmlposisi}}</div>
                        <div class="card-stats-item-label"><a class="btn btn-sm btn-info" href="{{route('posisiseleksi',$tahunpenilaian->id)}}">Posisi</a></div>
                      </div>
                    </div>
                  </div>
                <div class="text-right pt-4 pb-1 mr-2 mb-2">
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
                      <div class="card-stats-item-label">Kuota</div>
                    </div>
                    <div class="card-stats-item col-6">
                      <div class="card-stats-item-count">Proses</div>
                      <div class="card-stats-item-label">Status</div>
                    </div>
                  </div>
                </div>
              <div class="text-right pt-4 pb-1 mr-2 mb-2">
                <a href="#" class="btn btn-warning btn-lg btn-round">
                  Lanjutkan Proses
                </a>
              </div>

            </div>
          </div>


        </div>



        <div class="card">
            <div class="card-body">





                <table id="example" class="table table-striped table-bordered mt-1 table-sm" style="width:100%">
                    <thead>
                        <tr style="background-color: #F1F1F1">
                            <th colspan="8" class="text-center"> Kesimpulan Parameter Posisi</th>
                        </tr>
                        <tr style="background-color: #F1F1F1">
                            <th class="babeng-min-row">No </th>
                            <th >Posisi </th>
                            <th colspan="2" class="text-center">Fisik</th>
                            <th  colspan="2" class="text-center">Teknik</th>
                            <th  colspan="2" class="text-center">Taktik</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($dataakhir as $data)
                            <tr>
                                <td>{{$loop->index+1}}</td>
                                <td>{{$data->nama}}</td>
                                <td class="babeng-min-row">
                                    @forelse ($data->fisik as $fisik)
                                        <button class="btn btn-light">{{$fisik->nama}}</button>
                                    @empty
                                    <button class="btn btn-warning">Kriteria Penilaian Masih Kosong</button>
                                    @endforelse
                                </td>
                                <td class="babeng-min-row">
                                    <button class="btn btn-sm btn-info">
                                        <i class="fas fa-plus-square"></i>
                                    </button>
                                </td>
                                <td class="babeng-min-row">
                                    @forelse ($data->teknik as $teknik)
                                        <button class="btn btn-light">{{$teknik->nama}}</button>
                                    @empty
                                    <button class="btn btn-warning">Kriteria Penilaian Masih Kosong</button>
                                    @endforelse

                                </td>
                                <td class="babeng-min-row">
                                    <button class="btn btn-sm btn-info">
                                        <i class="fas fa-plus-square"></i>
                                    </button>
                                </td>
                                <td class="babeng-min-row">
                                    @forelse ($data->taktik as $taktik)
                                        <button class="btn btn-light">{{$taktik->nama}}</button>
                                    @empty
                                    <button class="btn btn-warning">Kriteria Penilaian Masih Kosong</button>
                                    @endforelse

                                </td>
                                <td class="babeng-min-row">
                                    <button class="btn btn-sm btn-info">
                                        <i class="fas fa-plus-square"></i>
                                    </button>
                                </td>
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
