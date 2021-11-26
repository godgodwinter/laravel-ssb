@extends('layouts.default')

@section('title')
Grafik Hasil Penilaian
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
            {{-- <div class="breadcrumb-item"><a href="#">Layout</a></div> --}}
            <div class="breadcrumb-item">@yield('title')</div>
        </div>
    </div>


</section>


@push('after-style')

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>
@endpush

<div class="section-body">
    <h2 class="section-title">Hasil 1. Posisi Terbaik Setiap Pemain</h2>
    <div class="row">
@forelse ($datas as $data)

      <div class="col-12 col-md-6 col-lg-6">
        <div class="card">
          <div class="card-header">
            <h4>{{$data->nama}}</h4>
          </div>
          <div class="card-body">
            <canvas id="myChartHasilSatu{{$data->id}}"></canvas>
          </div>
        </div>
      </div>


    {{-- @php
    $arr=[];
    @endphp
        @forelse ($data->posisiterbaik as $posisi)
            @php
                array_push($arr,"'".$posisi->nama."'");
            @endphp
        @empty

        @endforelse --}}

        {{-- {{dd($arr)}} --}}


@push('after-style')

<script>
$(document).ready(function() {

//barchart
var ctx = document.getElementById('myChartHasilSatu{{$data->id}}').getContext('2d');
var myChart = new Chart(ctx, {
type: 'bar',
data: {
  labels: [
      @forelse ($data->posisiterbaik as $posisi)
      '{{$posisi->nama}}',

      @empty

      @endforelse
   ],
  datasets: [{
    label: '# of Votes',
    data: [
      @forelse ($data->posisiterbaik as $posisi)
      '{{$posisi->total}}',

      @empty

      @endforelse
   ],
    backgroundColor: [
      'rgba(255, 99, 132, 0.2)',
      'rgba(54, 162, 235, 0.2)',
      'rgba(255, 206, 86, 0.2)',
      'rgba(75, 192, 192, 0.2)',
      'rgba(153, 102, 255, 0.2)',
      'rgba(255, 159, 64, 0.2)'
    ],
    borderColor: [
      'rgba(255, 99, 132, 1)',
      'rgba(54, 162, 235, 1)',
      'rgba(255, 206, 86, 1)',
      'rgba(75, 192, 192, 1)',
      'rgba(153, 102, 255, 1)',
      'rgba(255, 159, 64, 1)'
    ],
    borderWidth: 1
  }]
},
options: {
  scales: {
    yAxes: [{
      ticks: {
        beginAtZero: true
      }
    }]
  }
}
});



});

</script>
@endpush


@empty

@endforelse
    </div>
</section>




<div class="section-body">
    <h2 class="section-title">Hasil 2. Pemain Terbaik Setiap Posisi</h2>
    <div class="row">
@forelse ($hasil2 as $data)

        <div class="col-12 col-md-6 col-lg-6">
        <div class="card">
          <div class="card-header">
            <h4>{{$data->nama}}</h4>
          </div>
          <div class="card-body">
            <canvas id="myChartHasilDua{{$data->id}}"></canvas>
          </div>
        </div>
      </div>


    {{-- @php
    $arr=[];
    @endphp
        @forelse ($data->posisiterbaik as $posisi)
            @php
                array_push($arr,"'".$posisi->nama."'");
            @endphp
        @empty

        @endforelse --}}

        {{-- {{dd($arr)}} --}}


@push('after-style')

<script>
$(document).ready(function() {

//barchart
var ctx = document.getElementById('myChartHasilDua{{$data->id}}').getContext('2d');
var myChart = new Chart(ctx, {
type: 'bar',
data: {
  labels: [
      @forelse ($data->pemainterbaik as $pemain)
      '{{$pemain->nama}}',

      @empty

      @endforelse
   ],
  datasets: [{
    label: '# of Votes',
    data: [
      @forelse ($data->pemainterbaik as $pemain)
      '{{$pemain->total}}',

      @empty

      @endforelse
   ],
    backgroundColor: [
      'rgba(255, 99, 132, 0.2)',
      'rgba(54, 162, 235, 0.2)',
      'rgba(255, 206, 86, 0.2)',
      'rgba(75, 192, 192, 0.2)',
      'rgba(153, 102, 255, 0.2)',
      'rgba(255, 159, 64, 0.2)'
    ],
    borderColor: [
      'rgba(255, 99, 132, 1)',
      'rgba(54, 162, 235, 1)',
      'rgba(255, 206, 86, 1)',
      'rgba(75, 192, 192, 1)',
      'rgba(153, 102, 255, 1)',
      'rgba(255, 159, 64, 1)'
    ],
    borderWidth: 1
  }]
},
options: {
  scales: {
    yAxes: [{
      ticks: {
        beginAtZero: true
      }
    }]
  }
}
});



});

</script>
@endpush


@empty

@endforelse
</div>
</section>
@endsection


@section('containermodal')

@endsection
