@extends('layouts.defaultlanding')

@section('title')
Beranda
@endsection

@push('before-script')

@if (session('status'))
<x-sweetalertsession tipe="{{session('tipe')}}" status="{{session('status')}}"/>
@endif
@endpush

@section('content')

<section class="py-8">
    <div class="container">
      <div class="row">
        <div class="bg-holder bg-size" style="background-image:url(assets/img/gallery/dot-bg.png);background-position:bottom right;background-size:auto;">
        </div>
        <!--/.bg-holder-->

        <div class="col-lg-6 z-index-2 mb-5"><img class="w-100" src="{{url('/')}}/assets/img/undraw_junior_soccer.svg" alt="..." /></div>
        <div class="col-lg-6 z-index-2">
          <form class="row g-3" action="{{ route('login') }}" method="POST" >
            @csrf
            <div class="col-md-12">
              <label  for="inputName">Username :</label>
              <input class="form-control form-livedoc-contro @error('identity')
              is-invalid
              @enderror" id="inputName"  placeholder="Username" autocomplete="nope" name="identity" />
                @error('identity')
                <div class="invalid-feedback text-danger">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="col-md-12">
              <label  for="inputPhone">Password :</label>
              <input class="form-control form-livedoc-control @error('password')
              is-invalid
              @enderror" type="password" placeholder="Password" autocomplete="nope" name="password" />
              @error('password')
              <div class="invalid-feedback text-danger">
                  {{ $message }}
              </div>
              @enderror
            </div>
            <div class="d-flex flex-row-reverse">
                <button class="btn btn-primary rounded-pill" type="submit">Login</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>




@endsection

