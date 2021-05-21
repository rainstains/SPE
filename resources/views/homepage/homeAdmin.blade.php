@extends('layouts.app')

@section('content')
<div class="container" >
  <div class="row ">
    <div class="col-md-12" style="display: flex; justify-content: flex-end;">
      <button id="btnAddUser" type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalAddUser">Add User</button>
      &nbsp;&nbsp;
      <button id="btnAddEkskul" type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalAddEkskul">Add Ekstrakurikuler</button>
    </div>
  </div>
  <div class="row" > 
    <div class="col-md-12"> 
      <!--
      @if (session('status'))
          <div class="alert alert-success" role="alert">
              {{ session('status') }}
          </div>
      @endif
      -->
      <h2 class="font-weight-bold" style="color:black;">Ekstrakurikuler</h2>
    </div>        
  </div>
  <div class="row">
    @foreach($extracurriculars as $extracurricular)
      <div class="col-md-3 m-0 p-0" >
        <div class="card bg-secondary text-center my-auto" style="width: 17rem;">
          <br>
          <img src="/uploaded_files/Extracurricular/{{$extracurricular->id}}/logo/{{$extracurricular->logo}}" style="text-align:center; margin: 0 auto; width: 200px; height: 200px; "  alt="...">
          <div class="card-body">
            <h5 class="card-title" style="color:white;">{{ $extracurricular->name}}</h5>
            <button id="btnDelEkskul" type="button" class="btn btn-danger" data-toggle="modal" data-id="{{ $extracurricular->id}}" data-name="{{ $extracurricular->name}}" data-target="#modalDelEkskul">Delete</button>
            &nbsp;&nbsp;
            <button id="btnStatEkskul" type="button" class="btn btn-info" data-toggle="modal" data-id="{{ $extracurricular->id}}" data-status="{{ $extracurricular->status}}" data-name="{{ $extracurricular->name}}" data-target="#modalStatEkskul">{{ $extracurricular->status}}</button>
          </div>
        </div>
      </div>      
    @endforeach  
  </div>

    
</div>

<!-- Modal Add User-->
<div class="modal fade" id="modalAddUser" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
      <form method="POST" action="{{ route('adduser.create') }}">
        @csrf

        <div class="form-group row">
            <label for="firstname" class="col-md-4 col-form-label text-md-right">{{ __('First Name') }}</label>

            <div class="col-md-6">
                <input id="firstname" type="text" class="form-control @error('firstname') is-invalid @enderror" placeholder="firstname" name="firstname" value="{{ old('firstname') }}" required autocomplete="firstname" autofocus>

                @error('firstname')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label for="lastname" class="col-md-4 col-form-label text-md-right">{{ __('Last Name') }}</label>

            <div class="col-md-6">
                <input id="lastname" type="text" class="form-control @error('lastname') is-invalid @enderror" placeholder="lastname" name="lastname" value="{{ old('lastname') }}" required autocomplete="lastname" autofocus>

                @error('lastname')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="username" class="col-md-4 col-form-label text-md-right">{{ __('Username') }}</label>

            <div class="col-md-6">
                <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" placeholder="username" name="username" value="{{ old('username') }}" required autocomplete="username">

                @error('username')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

            <div class="col-md-6">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="password" name="password" required autocomplete="new-password">

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

            <div class="col-md-6">
                <input id="password-confirm" type="password" class="form-control" placeholder="confirm password" name="password_confirmation" required autocomplete="new-password">
            </div>
        </div>

        <div class="form-group row">
            <label for="role" class="col-md-4 col-form-label text-md-right">{{ __('Role') }}</label>

            <div class="col-md-6">
                <select name="role" id="role" required autocomplete="role" class="form-control">
                    <option value="" disabled selected>Pilih Role</option>
                    <option value="Kesiswaan">Kesiswaan</option>
                    <option value="Pengurus">Pengurus</option>
                    <option value="Pembina">Pembina</option>
                </select>
                @error('role')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row" id="ekskulinput" style="display:none;">
            <label for="ekskul_id" class="col-md-4 col-form-label text-md-right">{{ __('Ekstrakurikuler') }}</label>
            
            <div class="col-md-6">
                <select name="extracurricular_id" id="extracurricular_id" class="form-control">
                    @foreach($extracurriculars as $extracurricular)
                    <option value="{{ $extracurricular->id }}">{{ $extracurricular->name }}</option>
                    @endforeach
                </select>
                @error('extracurricular_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success">{{ __('Add User') }}</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal Add Ekskul -->
<div class="modal fade" id="modalAddEkskul" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Ekstrakurikuler</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
      <form method="POST" action="{{ route('ekskul.create') }}" enctype="multipart/form-data">
        @csrf

        <div class="form-group row">
          <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nama Ekstrakurikuler') }}</label>

          <div class="col-md-6">
              <input id="name" type="text" class="form-control @error('namaEkskul') is-invalid @enderror" placeholder="nama ekstrakurikuler" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

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
              <input id="dateEstablished" type="date" class="form-control @error('dateEstablished') is-invalid @enderror" name="dateEstablished" value="{{ old('dateEstablished') }}" required autocomplete="dateEstablished">

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
              <input id="logo" type="file" class="form-control-file my-1 @error('logo') is-invalid @enderror" name="logo" value="{{ old('logo') }}" required autocomplete="logo">

              @error('logo')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
              @enderror
          </div>
      </div>
                        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success">{{ __('Add Ekstrakurikuler') }}</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal Delete Ekskul -->
<div class="modal fade" id="modalDelEkskul" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Delete Ekstrakurikuler</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p id="delConfirm"></p>
      <form method="POST" action="{{ route('ekskul.delete') }}" >
        @csrf           
        <input id="id" type="hidden" name="id" value="">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-danger">{{ __('Delete') }}</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal Status Ekskul -->
<div class="modal fade" id="modalStatEkskul" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Status Ekstrakurikuler</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p id="statusConfirm"></p>
      <form method="POST" action="{{ route('ekskul.status') }}" >
        @csrf           
        <input id="id" type="hidden" name="id" value="">
        <div class="form-group row">
          <label for="logo" class="col-md-4 col-form-label text-md-right">{{ __('Status') }}</label>

          <div class="col-md-6">
            <select id="status" name='status' required class="form-control" required>
              <option value="Active">Active</option>
              <option value="InActive">InActive</option>
            </select>
            @error('status')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
            @enderror

          </div>
        </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success">{{ __('Update Status') }}</button>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection

@section('scriptplus')
<script>
$(document).ready(function () {
    $('#role').on('change',function(){
        if( $(this).val()==="Kesiswaan" || $(this).val() === null){
            $("#ekskulinput").hide()
        }
        else{
            $("#ekskulinput").show()
        }
    });
});

$(document).on('click','#btnDelEkskul', function(){
    var id = $(this).data('id');
    var name = $(this).data('name');
    var p = "are you sure you want to delete "+name+"?";
    $(".modal-body #id").val(id);
    document.getElementById("delConfirm").innerHTML = p;
});

$(document).on('click','#btnStatEkskul', function(){
    var id = $(this).data('id');
    var name = $(this).data('name');
    var status = $(this).data('status');
    var p = "Status Ekstrakurikuler "+name+" is "+status+"!";
    $(".modal-body #id").val(id);
    if (status === "Active") {
        document.getElementById("status").selectedIndex = 0;
    }else if (status === "InActive") {
        document.getElementById("status").selectedIndex = 1;
    }
    document.getElementById("statusConfirm").innerHTML = p;
});
</script>
@endsection
