@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in! But as a {{$user->role}}
                    <hr>
                    <button id="btnEditEkskul" type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalEditEkskul">Edit Ekstrakurikuler</button>
                    <p>{{$ekskul->namaEkskul}}</p>
                    <p>{{$ekskul->tglBerdiri}}</p>
                    <img src="uploaded_files/Ekstrakurikuler/{{$ekskul->namaEkskul}}/logo/{{$ekskul->logo}}" width="200px" height="200px" alt="">
                    <hr>
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="kegiatan-tab" data-toggle="tab" href="#kegiatan" role="tab" aria-controls="home" aria-selected="true">Kegiatan</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="prestasi-tab" data-toggle="tab" href="#prestasi" role="tab" aria-controls="profile" aria-selected="false">Prestasi</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="anggota-tab" data-toggle="tab" href="#anggota" role="tab" aria-controls="contact" aria-selected="false">Anggota</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade active show" id="kegiatan" role="tabpanel" aria-labelledby="kegiatan-tab">...</div>
                        <div class="tab-pane fade" id="prestasi" role="tabpanel" aria-labelledby="prestasi-tab">...</div>
                        <div class="tab-pane fade" id="anggota" role="tabpanel" aria-labelledby="anggota-tab">
                        <button id="btnAddAnggota" type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalAddAnggota">Add Anggota</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal Edit Ekskul -->
<div class="modal fade" id="modalEditEkskul" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Ekstrakurikuler</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
      <form method="POST" action="{{ route('ekskul.create') }}" enctype="multipart/form-data">
        @csrf

        <div class="form-group row">
            <label for="firstname" class="col-md-4 col-form-label text-md-right">{{ __('Nama Ekstrakurikuler') }}</label>

            <div class="col-md-6">
                <input id="namaEkskul" type="text" value="{{$ekskul->namaEkskul}}" class="form-control @error('namaEkskul') is-invalid @enderror" name="namaEkskul" value="{{ old('namaEkskul') }}" required autocomplete="namaEkskul" autofocus>

                @error('namaEkskul')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="username" class="col-md-4 col-form-label text-md-right">{{ __('Tanggal Berdiri') }}</label>

            <div class="col-md-6">
                <input id="tglBerdiri" type="date" value="{{$ekskul->tglBerdiri}}" class="form-control @error('tglBerdiri') is-invalid @enderror" name="tglBerdiri" value="{{ old('tglBerdiri') }}" required autocomplete="tglBerdiri">

                @error('tglBerdiri')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="logo" class="col-md-4 col-form-label text-md-right">{{ __('Logo') }}</label>

            <div class="col-md-6">
                <input id="logo" type="file" class="form-control @error('logo') is-invalid @enderror" name="logo" value="{{ old('logo') }}" required autocomplete="logo">

                @error('logo')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">{{ __('Edit Ekstrakurikuler') }}</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal Add Anggota -->
<div class="modal fade" id="modalAddAnggota" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Anggota {{$ekskul->namaEkskul}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
      <form method="POST" action="{{ route('ekskul.create') }}" enctype="multipart/form-data">
        @csrf

        <div class="form-group row">
            <label for="firstname" class="col-md-4 col-form-label text-md-right">{{ __('Nama Ekstrakurikuler') }}</label>

            <div class="col-md-6">
                <input id="namaEkskul" type="text" value="{{$ekskul->namaEkskul}}" class="form-control @error('namaEkskul') is-invalid @enderror" name="namaEkskul" value="{{ old('namaEkskul') }}" required autocomplete="namaEkskul" autofocus>

                @error('namaEkskul')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="username" class="col-md-4 col-form-label text-md-right">{{ __('Tanggal Berdiri') }}</label>

            <div class="col-md-6">
                <input id="tglBerdiri" type="date" value="{{$ekskul->tglBerdiri}}" class="form-control @error('tglBerdiri') is-invalid @enderror" name="tglBerdiri" value="{{ old('tglBerdiri') }}" required autocomplete="tglBerdiri">

                @error('tglBerdiri')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="logo" class="col-md-4 col-form-label text-md-right">{{ __('Logo') }}</label>

            <div class="col-md-6">
                <input id="logo" type="file" class="form-control @error('logo') is-invalid @enderror" name="logo" value="{{ old('logo') }}" required autocomplete="logo">

                @error('logo')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">{{ __('Edit Ekstrakurikuler') }}</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
