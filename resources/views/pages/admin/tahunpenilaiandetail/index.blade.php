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
                      <div class="card-stats-item-count">24</div>
                      <div class="card-stats-item-label">Kriteria</div>
                    </div>
                    <div class="card-stats-item col-6">
                      <div class="card-stats-item-count">12</div>
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
                        <div class="card-stats-item-count">24</div>
                        <div class="card-stats-item-label">Pemain</div>
                      </div>
                      <div class="card-stats-item col-6">
                        <div class="card-stats-item-count">12</div>
                        <div class="card-stats-item-label">Posisi</div>
                      </div>
                    </div>
                  </div>
                <div class="text-right pt-4 pb-1 mr-2 mb-2">
                  <a href="#" class="btn btn-primary btn-lg btn-round">
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
                      <div class="card-stats-item-count">3</div>
                      <div class="card-stats-item-label">Terbaik</div>
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
                            <th colspan="5" class="text-center"> Kesimpulan Parameter Posisi</th>
                        </tr>
                        <tr style="background-color: #F1F1F1">
                            <th >No </th>
                            <th >Posisi </th>
                            <th >Fisik</th>
                            <th >Teknik</th>
                            <th >Taktik</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>


            </div>
        </div>



    </div>
</section>
@endsection


@section('containermodal')

@endsection
