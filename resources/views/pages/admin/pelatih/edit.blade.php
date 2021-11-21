@extends('layouts.default')

@section('title')
Pelatih
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
            <div class="breadcrumb-item"><a href="{{route('pelatih')}}">@yield('title')</a></div>
            <div class="breadcrumb-item">Edit</div>
        </div>
    </div>

    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <h5>Edit</h5>
            </div>
            <div class="card-body">

                <form action="{{route('pelatih.update',$id->id)}}" method="post" enctype="multipart/form-data">
                    @method('put')
                    @csrf

                    <div class="row">

                        <div class="form-group col-md-5 col-5 mt-0 ml-5">
                            <label for="nama">Nama pelatih <code>*)</code></label>
                            <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" value="{{old('nama')!=null?old('nama'):$id->nama}}" required>
                            @error('nama')<div class="invalid-feedback"> {{$message}}</div>
                            @enderror
                        </div>

                        <div class="form-group col-md-5 col-5 mt-0 ml-5">
                            <label for="spesialis">Pilih Spesiaiasai <code></code></label>

                            <select class="form-control  @error('spesialis') is-invalid @enderror" name="spesialis" required>
                                @if(old('spesialis'))
                                <option>{{old('spesialis')}}</option>
                            @else
                                @if($id->spesialis)
                                <option>{{$id->spesialis}}</option>
                                @endif
                            @endif
                                <option>Teknik</option>
                                <option>Taktik</option>
                                <option>Fisik</option>
                                <option>Umum</option>
                            </select>
                            @error('spesialis')<div class="invalid-feedback"> {{$message}}</div>
                            @enderror
                        </div>

                        <div class="form-group col-md-5 col-5 mt-0 ml-5">
                            <label for="jk">Pilih Jenis Kelamin <code></code></label>

                            <select class="form-control  @error('jk') is-invalid @enderror" name="jk" required>
                                @if(old('jk'))
                                <option>{{old('jk')}}</option>
                            @else
                                @if($id->jk)
                                <option>{{$id->jk}}</option>
                                @endif
                            @endif
                                <option>Laki-laki</option>
                                <option>Perempuan</option>
                            </select>
                            @error('jk')<div class="invalid-feedback"> {{$message}}</div>
                            @enderror
                        </div>


                        <div class="form-group col-md-5 col-5 mt-0 ml-5">
                            <label for="telp">Telp<code>*)</code></label>
                            <input type="text" name="telp" id="telp" class="form-control @error('telp') is-invalid @enderror" value="{{old('telp')?old('telp') : $id->telp}}" required>
                            @error('telp')<div class="invalid-feedback"> {{$message}}</div>
                            @enderror
                        </div>

                        <div class="form-group col-md-5 col-5 mt-0 ml-5">
                            <label for="tgllahir">Tanggal Lahir<code>*)</code></label>
                            @php
                                if($id->tgllahir)
                                    $tgl=$id->tgllahir;
                                else
                                    $tgl=date('Y-m-d');
                            @endphp
                            <input type="date" name="tgllahir" id="tgllahir" class="form-control @error('tgllahir') is-invalid @enderror" value="{{old('tgllahir')?old('tgllahir') : $tgl}}" required>
                            @error('tgllahir')<div class="invalid-feedback"> {{$message}}</div>
                            @enderror
                        </div>


                        <div class="form-group col-md-5 col-5 mt-0 ml-5">
                            <label for="alamat">Alamat<code>*)</code></label>
                            <input type="text" name="alamat" id="alamat" class="form-control @error('alamat') is-invalid @enderror" value="{{old('alamat')?old('alamat'):$id->alamat}}" required>
                            @error('alamat')<div class="invalid-feedback"> {{$message}}</div>
                            @enderror
                        </div>

                        <div class="form-group col-md-5 col-5 mt-0 ml-5">
                            <label for="username">Username<code>*)</code></label>

                              <input type="text" class="form-control  @error('username') is-invalid @enderror" name="username" required  value="{{old('username')?old('username'):$id->users->username}}">

                              @error('username')<div class="invalid-feedback"> {{$message}}</div>
                              @enderror

                          </div>

                        <div class="form-group col-md-5 col-5 mt-0 ml-5">
                            <label for="emaiL">Email<code>*)</code></label>

                            <input type="text" class="form-control  @error('email') is-invalid @enderror" name="email" required  value="{{old('email')?old('email'):$id->users->email}}">

                            @error('email')<div class="invalid-feedback"> {{$message}}</div>
                            @enderror

                        </div>


                        <div class="form-group col-md-5 col-5 mt-0 ml-5">
                            <label for="password">Password<code>*)</code></label>


                            <input type="password" class="form-control  @error('password') is-invalid @enderror" name="password" >

                            @error('password')<div class="invalid-feedback"> {{$message}}</div>
                            @enderror

                        </div>
                        <div class="form-group col-md-5 col-5 mt-0 ml-5">
                            <label for="password2">Konfirmasi Password<code>*)</code></label>

                            <input type="password" class="form-control  @error('password2') is-invalid @enderror" name="password2" >

                            @error('password2')<div class="invalid-feedback"> {{$message}}</div>
                            @enderror

                        </div>

                        @push('after-script')
                        <script type="text/javascript">
                            $(document).ready(function() {
                              $.uploadPreview({
                                input_field: "#image-upload",   // Default: .image-upload
                                preview_box: "#image-preview",  // Default: .image-preview
                                label_field: "#image-label",    // Default: .image-label
                                label_default: "Logo Sekolah",   // Default: Choose File
                                label_selected: "Ganti Logo Sekolah",  // Default: Change File
                                no_label: false                 // Default: false
                              });



                            });
                            </script>
                        @endpush
                        <div class="form-group col-md-5 col-5 mt-0 ml-5">
                          <div id="image-preview" class="image-preview">
                            <label for="image-upload" id="image-label2">UPLOAD FOTO</label>
                            <input type="file" name="files" id="image-upload" class="@error('files')
                            is_invalid
                        @enderror"  accept="image/png, image/gif, image/jpeg" />

                        @error('files')<div class="invalid-feedback"> {{$message}}</div>
                        @enderror
                          </div>
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
