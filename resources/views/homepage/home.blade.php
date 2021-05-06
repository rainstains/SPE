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
                    @if ($extracurricular->status == "Active")
                    <hr>
                    <button id="btnEditEkskul" type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalEditEkskul">Edit Ekstrakurikuler</button>
                    <p>{{$extracurricular->name}}</p>
                    <p>{{$extracurricular->dateEstablished}}</p>
                    <img src="uploaded_files/Extracurricular/{{$extracurricular->id}}/logo/{{$extracurricular->logo}}" width="200px" height="200px" alt="">
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
                @else
                <p>You cannot Access this Ekstrakurikuler page due to InActive Status of {{$extracurricular->name}}</p>
                @endif
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
        
      <form method="POST" action="{{ route('ekskul.update') }}" enctype="multipart/form-data">
        @csrf

        <div class="form-group row">
            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nama Ekstrakurikuler') }}</label>

            <div class="col-md-6">
                <input id="name" type="text" value="{{$extracurricular->name}}" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="dateEstablished" class="col-md-4 col-form-label text-md-right">{{ __('Tanggal Berdiri') }}</label>

            <div class="col-md-6">
                <input id="dateEstablished" type="date" value="{{$extracurricular->dateEstablished}}" class="form-control @error('dateEstablished') is-invalid @enderror" name="dateEstablished" value="{{ old('dateEstablished') }}" required autocomplete="dateEstablished">

                @error('dateEstablished')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="logo" class="col-md-4 col-form-label text-md-right">{{ __('Logo') }}</label>

            <div class="col-md-6">
                <input id="logo" type="file" class="form-control @error('logo') is-invalid @enderror" name="logo" value="{{ old('logo') }}" autocomplete="logo">

                @error('logo')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <input id="id" type="hidden" name="id" value="{{$extracurricular->id}}">
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
        <h5 class="modal-title" id="exampleModalLabel">Add Anggota {{$extracurricular->name}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
      <form method="POST" action="{{ route('anggota.add') }}">
        @csrf

        <div class="form-group row">
            <label for="siswa_id" class="col-md-4 col-form-label text-md-right">{{ __('Nama Calon Anggota') }}</label>

            <div class="col-md-6">
                <select name="siswa_id" id="siswa_id" placeholder="Cari Siswa ..." required>
                @foreach($students as $student)
                <option value="{{ $student->id}}" data-nis="{{$student->nis}}" data-nama="{{$student->name}}" data-kelas="{{$student->class}}"> {{$student->name}} ({{$student->class}})</option>
                @endforeach
                </select>
            </div>
            <input id="extracurricular_id" type="hidden" name="extracurricular_id" value="{{$extracurricular->id}}">
        </div>
        <h6 style="text-align:center">Detail Data Calon Anggota : </h6>
        <div class="form-group row">
            <label for="nis" class="col-md-4 col-form-label text-md-right">No. Induk Siswa</label>

            <div class="col-md-6">
            <p id="nis"></p>
            </div>
        </div>
        <div class="form-group row">
            <label for="name" class="col-md-4 col-form-label text-md-right">Nama</label>

            <div class="col-md-6">
            <p id="nameS"></p>
            </div>
        </div>
        <div class="form-group row">
            <label for="class" class="col-md-4 col-form-label text-md-right">Kelas</label>

            <div class="col-md-6">
            <p id="class"></p>
            </div>
        </div>
        <div class="form-group row">
            <label for="angkatan" class="col-md-4 col-form-label text-md-right">{{ __('Angkatan') }}</label>

            <div class="col-md-6">
                <input id="angkatan" type="number" class="form-control @error('angkatan') is-invalid @enderror" name="angkatan" value="{{ old('angkatan') }}" required autocomplete="angkatan" autofocus>

                @error('angkatan')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">{{ __('Add Anggota') }}</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scriptplus')
<script>
    $(document).ready(function () {
      $('#siswa_id').selectize({
          onInitialize: function(){
			var s = this;
			this.revertSettings.$children.each( function(){
				   $.extend(s.options[this.value], $(this).data());
		    });
		  }
      });
    });

    $('#siswa_id').on('change', function(){
        var s = $('#siswa_id')[0].selectize; 
        var data = s.options[s.items[0]]; 
        document.getElementById("nis").innerHTML = ": "+data.nis;
        document.getElementById("nameS").innerHTML = ": "+data.nama;
        document.getElementById("class").innerHTML = ": "+data.kelas; 
    });
</script>
@endsection
