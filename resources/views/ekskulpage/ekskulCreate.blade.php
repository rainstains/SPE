@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Create Ekstrakurikuler') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('ekskul.create') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label for="firstname" class="col-md-4 col-form-label text-md-right">{{ __('Nama Ekstrakurikuler') }}</label>

                            <div class="col-md-6">
                                <input id="namaEkskul" type="text" class="form-control @error('namaEkskul') is-invalid @enderror" name="namaEkskul" value="{{ old('namaEkskul') }}" required autocomplete="namaEkskul" autofocus>

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
                                <input id="tglBerdiri" type="date" class="form-control @error('tglBerdiri') is-invalid @enderror" name="tglBerdiri" value="{{ old('tglBerdiri') }}" required autocomplete="tglBerdiri">

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

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Create') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
