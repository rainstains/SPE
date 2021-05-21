@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card bg-secondary">
        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            @if ($extracurricular->status == "Active")
            <table width="100%" class="text-white">
              <tbody>
                <tr>
                  <td rowspan="5" style="text-align:center">
                  <img src="/uploaded_files/Extracurricular/{{$extracurricular->id}}/logo/{{$extracurricular->logo}}" width="200px" height="200px" alt="">
                  </td>
                  <td></td>
                  <td colspan="4" rowspan="2" style="text-align:center;" ><h4 style="font-weight: 700; font-size: 2rem;">{{$extracurricular->name}}</h4></td>
                </tr>
                <tr>
                  <td></td>
                </tr>
                <tr style="font-weight: 600; font-size: 1.25rem;">
                  <td></td>
                  <td>Tanggal Berdiri</td>
                  <td>:</td>
                  <td colspan="2">{{$extracurricular->dateEstablished}}</td>
                </tr>
                <tr style="font-weight: 600; font-size: 1.25rem;">
                  <td></td>
                  <td>Jumlah Anggota Aktif</td>
                  <td>:</td>
                  <td colspan="2">{{$activeMember}}</td>
                </tr>
                <tr style="font-weight: 600; font-size: 1.25rem;">
                  <td></td>
                  <td>Pembina</td>
                  <td>:</td>
                  <td colspan="2">
                      @foreach($pembinas as $pembina)
                        @if($loop->last)
                        {{$pembina->firstname}} {{$pembina->lastname}}
                        @else
                        {{$pembina->firstname}} {{$pembina->lastname}},
                        @endif
                      @endforeach 
                  </td>
                </tr>
                  <tr>
                  <td colspan="6">&nbsp;</td>
                </tr>
                <tr>
                  <td colspan="5"></td>
                  <td style="text-align:right">
                    @if($user->role != "Kesiswaan")
                      <button id="btnEditEkskul" type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalEditEkskul">Edit Ekstrakurikuler <i class="fas fa-edit"></i></button>
                    @endif
                  </td>
                </tr>
              </tbody>
            </table>


          @else
          <p class="text-light">You cannot Access this Ekstrakurikuler page due to InActive Status of {{$extracurricular->name}}</p>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>

<br>
@if($extracurricular->status == "Active")
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card bg-secondary">
                <div class="card-header" style="background-color: #22D6C2;">
                  <ul class="nav nav-pills" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active text-white" style="font-weight: 700; font-size: 1.05em;" id="kegiatan-tab" data-toggle="tab" href="#kegiatan" role="tab" aria-controls="home" aria-selected="true">Kegiatan</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link text-white" style="font-weight: 700; font-size: 1.05em;" id="prestasi-tab" data-toggle="tab" href="#prestasi" role="tab" aria-controls="profile" aria-selected="false">Prestasi</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link text-white" style="font-weight: 700; font-size: 1.05em;" id="anggota-tab" data-toggle="tab" href="#anggota" role="tab" aria-controls="contact" aria-selected="false">Anggota</a>
                        </li>
                    </ul>
                </div>

                <div class="card-body">
                   

                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade active show" id="kegiatan" role="tabpanel" aria-labelledby="kegiatan-tab">
                          <div class="col-md-12" style="display: flex; justify-content: flex-end;">
                            @if($user->role == "Pembina")
                              <button id="btnAddKegiatan" type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalAddJadwalKegiatan">Add Jadwal Kegiatan <i class="fas fa-plus"></i></button>
                            @elseif($user->role == "Kesiswaan")
                              <button id="btnExportKegiatan" type="button" class="btn btn-primary">Export Data Kegiatan</button>
                            @endif
                          </div>
                          <br>
                          <table class="table table-secondary" >
                            <thead class="thead-dark" >
                              <tr>
                                <th scope="col">No.</th>
                                <th scope="col">Nama Kegiatan</th>
                                <th scope="col">Deskripsi</th>
                                <th scope="col">Tanggal Pelaksanaan</th>
                                <th scope="col" style="text-align:center;">Dokumentasi Kegiatan</th>
                                <th scope="col" style="text-align:center;">Action</th>
                              </tr>
                            </thead>
                            <tbody style="color:black; background-color:white;">
                              @php ($noKegiatan = 1 ) @endphp
                              @foreach($activities as $activity)
                                <tr>
                                  <td scope="row">{{$noKegiatan}}</td>
                                  <td>{{$activity->name}}</td>
                                  <td>{{$activity->desc}}</td>
                                  <td>{{date('d F Y', strtotime($activity->date))}}</td>
                                  <td style="text-align:center;">
                                  <button id="btnPhoto" type="button" class="btn btn-info" data-toggle="modal" data-name="{{$activity->name}}" data-date="{{$activity->date}}" data-photo="{{$activity->photo}}"  data-target="#modalPhoto" ><i class="fas fa-eye"></i></button>
                                  </td>
                                  <td style="text-align:center;">
                                  @if($activity->confirm != "Confirmed")
                                    @if($user->role == "Pembina")
                                      <button id="btnKonfirmasiKegiatan" type="button" class="btn btn-success" data-toggle="modal" data-id="{{ $activity->id}}" data-name="{{$activity->name}}" data-date="{{$activity->date}}" data-desc="{{$activity->desc}}"  data-photo="{{$activity->photo}}" data-confirm="{{$activity->confirm}}" data-target="#modalKonfirmasiKegiatan" ><i class="fas fa-check"></i></button>
                                      <button id="btnEditJadwalKegiatan" type="button" class="btn btn-info" data-toggle="modal" data-id="{{ $activity->id}}" data-name="{{$activity->name}}" data-date="{{$activity->date}}" data-desc="{{$activity->desc}}"  data-photo="{{$activity->photo}}" data-confirm="{{$activity->confirm}}" data-target="#modalEditJadwalKegiatan" ><i class="fas fa-edit"></i></button>
                                      <button id="btnDelJadwalKegiatan" type="button" class="btn btn-danger" data-toggle="modal" data-id="{{ $activity->id}}" data-name="{{$activity->name}}" data-date="{{$activity->date}}" data-desc="{{$activity->desc}}"  data-photo="{{$activity->photo}}" data-confirm="{{$activity->confirm}}" data-target="#modalDelJadwalKegiatan" ><i class="fas fa-trash-alt"></i></button>
                                    @elseif($user->role == "Kesiswaan")
                                      <button id="btnExportKegiatan" type="button" class="btn btn-primary" >Export</button>
                                    @elseif($user->role == "Pengurus")
                                      <button id="btnEditDetailKegiatan" type="button" class="btn btn-info" data-toggle="modal" data-id="{{ $activity->id}}" data-name="{{$activity->name}}" data-date="{{$activity->date}}" data-desc="{{$activity->desc}}"  data-photo="{{$activity->photo}}" data-confirm="{{$activity->confirm}}" data-target="#modalEditDetailKegiatan" ><i class="fas fa-edit"></i></button>
                                    @else
                                    Not Available.
                                    @endif
                                  @else
                                  Confirmed
                                  @endif
                                  </td>
                                </tr>
                                @php ($noKegiatan++ ) @endphp
                              @endforeach
                            </tbody>
                          </table>
                        </div>

                        <div class="tab-pane fade" id="prestasi" role="tabpanel" aria-labelledby="prestasi-tab">
                          <div class="col-md-12" style="display: flex; justify-content: flex-end;">
                            @if($user->role == "Pembina")
                              <button id="btnAddPrestasi" type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalAddPrestasi">Add Prestasi <i class="fas fa-plus"></i></button>
                            @elseif($user->role == "Kesiswaan")
                              <button id="btnExportPrestasi" type="button" class="btn btn-primary" >Export Data Prestasi</button>
                            @endif
                          </div>
                          <br>
                          <table class="table table-striped">
                            <thead class="thead-dark">
                              <tr>
                                <th scope="col">No.</th>
                                <th scope="col">Nama Prestasi</th>
                                <th scope="col">Status</th>
                                <th scope="col">Tanggal Penghargaaan</th>
                                <th scope="col" style="text-align:center;">Action</th>
                              </tr>
                            </thead>
                            <tbody style="color:black; background-color:white;">
                            @php ($noPrestasi = 1 ) @endphp
                            @foreach($achievements as $achievement)
                              <tr>
                                <td scope="row">{{$noPrestasi}}</td>
                                <td>{{$achievement->name}}</td>
                                <td>{{$achievement->status}}</td>
                                <td>{{date('d F Y', strtotime($achievement->date))}}</td>
                                <td style="text-align:center;">
                                  @if($achievement->confirm != "Confirmed")
                                    @if($user->role == "Kesiswaan")
                                      <button id="btnKonfirmasiPrestasi" type="button" class="btn btn-success" data-toggle="modal" data-id="{{ $achievement->id}}" data-name="{{$achievement->name}}" data-date="{{$achievement->date}}"  data-status="{{$achievement->status}}" data-confirm="{{$achievement->confirm}}" data-target="#modalKonfirmasiPrestasi" ><i class="fas fa-check"></i></button>
                                    @elseif($user->role == "Pembina")
                                      <button id="btnEditPrestasi" type="button" class="btn btn-info" data-toggle="modal" data-id="{{ $achievement->id}}" data-name="{{$achievement->name}}" data-date="{{$achievement->date}}"  data-status="{{$achievement->status}}" data-confirm="{{$achievement->confirm}}" data-target="#modalEditPrestasi" ><i class="fas fa-edit"></i></button>
                                      <button id="btnDelPrestasi" type="button" class="btn btn-danger" data-toggle="modal" data-id="{{ $achievement->id}}" data-name="{{$achievement->name}}"  data-date="{{$achievement->date}}"  data-status="{{$achievement->status}}" data-confirm="{{$achievement->confirm}}" data-target="#modalDelPrestasi"><i class="fas fa-trash-alt"></i></button>   
                                    @else
                                    Not Available.
                                    @endif
                                  @else
                                  Confirmed
                                  @endif
                                </td>
                              </tr>
                              @php ($noPrestasi++ ) @endphp
                              @endforeach
                            </tbody>
                          </table>
                        </div>
                        
                        <div class="tab-pane fade" id="anggota" role="tabpanel" aria-labelledby="anggota-tab">
                          <div class="col-md-12" style="display: flex; justify-content: flex-end;">
                          @if($user->role == "Pengurus")
                            <button id="btnAddAnggota" type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalAddAnggota">Add Anggota <i class="fas fa-plus"></i></button>
                          @elseif($user->role == "Kesiswaan")
                            <button id="btnExportAnggota" type="button" class="btn btn-primary">Export Data Anggota</button>
                          @endif
                          </div>
                          <br>
                          <table class="table table-striped" >
                            <thead class="thead-dark">
                              <tr>
                                <th scope="col">No.</th>
                                <th scope="col">Nama Siswa</th>
                                <th scope="col">Kelas</th>
                                <th scope="col">Status</th>
                                <th scope="col">Angkatan</th>
                                <th scope="col" style="text-align:center;">Action</th>
                              </tr>
                            </thead>
                            <tbody style="color:black; background-color:white;">
                              @php ($noAnggota = 1 ) @endphp
                              @foreach($members as $member)
                                <tr>
                                  <td scope="row">{{$noAnggota}}</td>
                                  <td>{{$member->student->name}}</td>
                                  <td>{{$member->student->class}}</td>
                                  <td>{{$member->status}}</td>
                                  <td>{{$member->angkatan}}</td>
                                  <td style="text-align:center;">
                                  @if($user->role == "Pengurus")
                                    <button id="btnEditAnggota" type="button" class="btn btn-info" data-toggle="modal" data-id="{{ $member->id}}" data-name="{{$member->student->name}}" data-nis="{{$member->student->nis}}" data-class="{{$member->student->class}}" data-angkatan="{{$member->angkatan}}" data-status="{{$member->status}}" data-target="#modalEditAnggota"><i class="fas fa-edit"></i></button>
                                    <button id="btnDelAnggota" type="button" class="btn btn-danger" data-toggle="modal" data-id="{{ $member->id}}" data-name="{{$member->student->name}}" data-nis="{{$member->student->nis}}" data-class="{{$member->student->class}}" data-angkatan="{{$member->angkatan}}" data-status="{{$member->status}}" data-target="#modalDelAnggota"><i class="fas fa-trash-alt"></i></button>
                                  @else
                                    Not Available.
                                  @endif
                                  </td>
                                </tr>
                                @php ($noAnggota++ ) @endphp
                              @endforeach
                            </tbody>
                          </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

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
                <input id="nameEditEkskul" type="text" value="{{$extracurricular->name}}" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

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
                <input id="dateEstablishedEditEkskul" type="date" value="{{$extracurricular->dateEstablished}}" class="form-control @error('dateEstablished') is-invalid @enderror" name="dateEstablished" value="{{ old('dateEstablished') }}" required autocomplete="dateEstablished">

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
                <input id="logoEditEkskul" type="file" class="form-control-file my-1 @error('logo') is-invalid @enderror" name="logo" value="{{ old('logo') }}" autocomplete="logo">

                @error('logo')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <input id="idEditEkskul" type="hidden" name="id" value="{{$extracurricular->id}}">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success">{{ __('Edit Ekstrakurikuler') }}</button>
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
        
      <form method="POST" action="{{ route('member.create') }}">
        @csrf

        <div class="form-group row">
            <label for="student_id" class="col-md-4 col-form-label text-md-right">{{ __('Nama Calon Anggota') }}</label>

            <div class="col-md-6">
                <select name="student_id" id="student_id" placeholder="Cari Siswa ..." required class="form-control @error('student_id') is-invalid @enderror">
                  <option value="" disabled selected>Pilih Calon Anggota</option>
                  @foreach($students as $student)
                    <option value="{{ $student->id}}" data-nis="{{$student->nis}}" data-nama="{{$student->name}}" data-kelas="{{$student->class}}"> {{$student->name}} ({{$student->class}})</option>
                  @endforeach
                </select>
                @error('student_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <input id="extracurricular_id" type="hidden" name="extracurricular_id" value="{{$extracurricular->id}}">
        <div class="form-group row">
            <label for="angkatan" class="col-md-4 col-form-label text-md-right">{{ __('Angkatan') }}</label>

            <div class="col-md-6">
                <input id="angkatanAddAnggota" type="number" class="form-control @error('angkatan') is-invalid @enderror" placeholder="Angkatan" name="angkatan" value="{{ old('angkatan') }}" required autocomplete="angkatan" autofocus>

                @error('angkatan')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        
        <h6 style="text-align:center">Detail Data Calon Anggota : </h6>
        <table class="offset-md-2">
          <tbody>
            <tr>
              <td>No. Induk Siswa </td>
              <td style="padding-left:15px;">&nbsp;:</td>
              <td id="nis"></td>
            </tr>
            <tr>
              <td>Nama </td>
              <td style="padding-left:15px;">&nbsp;:</td>
              <td id="nameS"></td>
            </tr>
            <tr>
              <td>Kelas </td>
              <td style="padding-left:15px;">&nbsp;:</td>
              <td id="class"></td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success">{{ __('Add Anggota') }}</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal Edit Anggota -->
<div class="modal fade" id="modalEditAnggota" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit Anggota {{$extracurricular->name}}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          
        <form method="POST" action="{{ route('member.update') }}">
          @csrf
  
          <input id="idEditAnggota" type="hidden" name="id" value="">
          <h6 >Detail Data Anggota : </h6>
          
          <table>
            <tbody>
              <tr>
                <td>No. Induk Siswa </td>
                <td style="padding-left:15px;">&nbsp;:</td>
                <td id="nisEditAnggota"></td>
              </tr>
              <tr>
                <td>Nama </td>
                <td style="padding-left:15px;">&nbsp;:</td>
                <td id="nameEditAnggota"></td>
              </tr>
              <tr>
                <td>Kelas </td>
                <td style="padding-left:15px;">&nbsp;:</td>
                <td id="classEditAnggota"></td>
              </tr>
            </tbody>
          </table>
  
          <br>
          <div class="form-group row">
              <label for="angkatan" class="col-md-4 col-form-label text-md-right">{{ __('Angkatan') }}</label>
  
              <div class="col-md-6">
                  <input id="angkatanEditAnggota" type="number" class="form-control @error('angkatan') is-invalid @enderror" name="angkatan" value="{{ old('angkatan') }}" required autocomplete="angkatan" autofocus>
  
                  @error('angkatan')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
              </div>
          </div>
          <div class="form-group row">
              <label for="status" class="col-md-4 col-form-label text-md-right">{{ __('Status') }}</label>
  
              <div class="col-md-6">
                  <select name="status" id="statusEditAnggota" class="form-control" required>
                      <option value="Aktif">Aktif</option>
                      <option value="Tidak Aktif">Tidak Aktif</option>
                      <option value="Pengurus">Pengurus</option>
                      <option value="Spesial">Spesial</option>
                      <option value="Alumni">Alumni</option>
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
          <button type="submit" class="btn btn-success">{{ __('Edit Anggota') }}</button>
          </form>
        </div>
      </div>
    </div>
</div>

<!-- Modal Delete Anggota -->
<div class="modal fade" id="modalDelAnggota" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Delete Anggota Ekstrakurikuler</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Are you sure want to get this member out from {{$extracurricular->name}}?</p>
        <table class="">
          <tbody>
            <tr>
              <td>No. Induk Siswa </td>
              <td style="padding-left:15px;">&nbsp;:</td>
              <td id="nis1"></td>
            </tr>
            <tr>
              <td>Nama </td>
              <td style="padding-left:15px;">&nbsp;:</td>
              <td id="name1"></td>
            </tr>
            <tr>
              <td>Kelas </td>
              <td style="padding-left:15px;">&nbsp;:</td>
              <td id="class1"></td>
            </tr>
            <tr>
              <td>Angkatan </td>
              <td style="padding-left:15px;">&nbsp;:</td>
              <td id="angkatan1"></td>
            </tr>
            <tr>
              <td>Status </td>
              <td style="padding-left:15px;">&nbsp;:</td>
              <td id="status1"></td>
            </tr>
          </tbody>
        </table>

      <form method="POST" action="{{ route('member.delete') }}" >
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

<!-- Modal Add Prestasi -->
<div class="modal fade" id="modalAddPrestasi" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Prestasi {{$extracurricular->name}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
      <form method="POST" action="{{ route('achievement.create') }}">
        @csrf
        
        <div class="form-group row">
            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nama Prestasi') }}</label>

            <div class="col-md-6">
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Nama Prestasi" value="{{ old('name') }}" required autocomplete="name" autofocus>

                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="date" class="col-md-4 col-form-label text-md-right">{{ __('Tanggal Penghargaan') }}</label>

            <div class="col-md-6">
                <input id="date" type="date" class="form-control @error('date') is-invalid @enderror" name="date" value="{{ old('date') }}" required autocomplete="date" autofocus>

                @error('date')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="status" class="col-md-4 col-form-label text-md-right">{{ __('Status') }}</label>

            <div class="col-md-6">
            
                <select id="statusPres" name="statusPres" class="form-control">
                  <option value="" disabled selected>Pilih Status Prestasi</option>
                  <option value="Juara 1">Juara 1</option>
                  <option value="Juara 2">Juara 2</option>
                  <option value="Juara 3">Juara 3</option>
                  <option value="Juara Umum">Juara Umum</option>
                  <option value="Finalis">Finalis</option>
                  <option value="Lainnya">Lainnya</option>
                </select>

                @error('status')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                
            </div>
        </div>
        <div class="form-group row" id="lainnyaInput" style="display:none;">
            <label for="lainnya" class="col-md-4 col-form-label text-md-right"></label>

            <div class="col-md-6">
                <input id="lainnya" type="text" class="form-control @error('lainnya') is-invalid @enderror" placeholder="Lainnya..." name="lainnya" value="{{ old('lainnya') }}" autocomplete="lainnya">
                
                @error('lainnya')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                
            </div>
        </div>

      <input type="hidden" id="extracurricular_id" name="extracurricular_id" value="{{$extracurricular->id}}">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success">{{ __('Add Prestasi') }}</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal Edit Prestasi -->
<div class="modal fade" id="modalEditPrestasi" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Prestasi {{$extracurricular->name}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form method="POST" action="{{ route('achievement.update') }}">
        @csrf
        
        <div class="form-group row">
            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nama Prestasi') }}</label>

            <div class="col-md-6">
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="date" class="col-md-4 col-form-label text-md-right">{{ __('Tanggal Penghargaan') }}</label>

            <div class="col-md-6">
                <input id="date" type="date" class="form-control @error('angkatan') is-invalid @enderror" name="date" value="{{ old('date') }}" required autocomplete="date" autofocus>

                @error('date')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="statusPres1" class="col-md-4 col-form-label text-md-right">{{ __('Status') }}</label>

            <div class="col-md-6">
            
                <select id="statusPres1" name="statusPres" class="form-control">
                  <option value="Juara 1">Juara 1</option>
                  <option value="Juara 2">Juara 2</option>
                  <option value="Juara 3">Juara 3</option>
                  <option value="Juara Umum">Juara Umum</option>
                  <option value="Finalis">Finalis</option>
                  <option value="Lainnya">Lainnya</option>
                </select>

                @error('status')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                
            </div>
        </div>
        <div class="form-group row" id="lainnyaInput1" style="display:none;">
            <label for="lainnya" class="col-md-4 col-form-label text-md-right"></label>

            <div class="col-md-6">
                <input id="lainnya1" type="text" class="form-control @error('lainnya') is-invalid @enderror" placeholder="Lainnya..." name="lainnya" value="{{ old('lainnya') }}" autocomplete="lainnya">
                
                @error('lainnya')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                
            </div>
        </div>

      <input type="hidden" id="id" name="id" value="">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success">{{ __('Edit Prestasi') }}</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal Delete Prestasi -->
<div class="modal fade" id="modalDelPrestasi" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Delete Prestasi Ekstrakurikuler</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Are you sure want to delete this Achievement?</p>
        <table class="">
          <tbody>
            <tr>
              <td>Nama Prestasi</td>
              <td style="padding-left:15px;">&nbsp;:</td>
              <td id="name3"></td>
            </tr>
            <tr>
              <td>Tanggal Penghargaan </td>
              <td style="padding-left:15px;">&nbsp;:</td>
              <td id="date3"></td>
            </tr>
            <tr>
              <td>Status Prestasi</td>
              <td style="padding-left:15px;">&nbsp;:</td>
              <td id="status3"></td>
            </tr>
          </tbody>
        </table>

      <form method="POST" action="{{ route('achievement.delete') }}" >
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

<!-- Modal Konfirmasi Prestasi -->
<div class="modal fade" id="modalKonfirmasiPrestasi" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Prestasi {{$extracurricular->name}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Data Prestasi Yang Akan Dikonfirmasi:</p>
        <table >
          <tbody>
            <tr>
              <td>Nama Prestasi</td>
              <td style="padding-left:15px;">&nbsp;:</td>
              <td id="name4"></td>
            </tr>
            <tr>
              <td>Tanggal Penghargaan </td>
              <td style="padding-left:15px;">&nbsp;:</td>
              <td id="date4"></td>
            </tr>
            <tr>
              <td>Status Prestasi </td>
              <td style="padding-left:15px;">&nbsp;:</td>
              <td id="status4"></td>
            </tr>
          </tbody>
        </table>
      <br>
      <form method="POST" action="{{ route('achievement.confirm') }}">
        @csrf
        
        <div class="form-group row">
            <label for="confirm" class="col-md-4 col-form-label text-md-right">{{ __('Konfirmasi') }}</label>

            <div class="col-md-6">
            
                <select id="confirm" name="confirm" class="form-control">
                  <option value="Not Confirmed">Belum Dikonfirmasi</option>
                  <option value="Confirmed">Sudah Dikonfirmasi</option>
                </select>

                @error('confirm')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                
            </div>
        </div>
                

      <input type="hidden" id="id" name="id" value="">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success">{{ __('Konfirmasi Prestasi') }}</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal Add Jadwal Kegiatan -->
<div class="modal fade" id="modalAddJadwalKegiatan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Jadwal Kegiatan {{$extracurricular->name}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
      <form method="POST" action="{{ route('activity.create') }}">
        @csrf
        
        <div class="form-group row">
            <label for="nameAddAct" class="col-md-4 col-form-label text-md-right">{{ __('Nama Kegiatan') }}</label>

            <div class="col-md-6">
                <input id="nameAddAct" type="text" class="form-control @error('nameAddAct') is-invalid @enderror" placeholder="Nama Kegiatan" name="nameAddAct" value="{{ old('nameAddAct') }}" required autocomplete="nameAddAct" autofocus>

                @error('nameAddAct')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="dateAddAct" class="col-md-4 col-form-label text-md-right">{{ __('Tanggal Pelaksanaan') }}</label>

            <div class="col-md-6">
                <input id="dateAddAct" type="date" class="form-control @error('dateAddAct') is-invalid @enderror" name="dateAddAct" value="{{ old('dateAddAct') }}" required autocomplete="dateAddAct" autofocus>

                @error('dateAddAct')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="descAddAct" class="col-md-4 col-form-label text-md-right">{{ __('Deskripsi Kegiatan') }}</label>

            <div class="col-md-6">
                <textarea id="descAddAct" class="form-control @error('descAddAct') is-invalid @enderror" placeholder="Deskripsi" name="descAddAct" value="{{ old('descAddAct') }}" autocomplete="descAddAct" autofocus></textarea>
                @error('descAddAct')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

      <input type="hidden" id="extracurricular_id" name="extracurricular_id" value="{{$extracurricular->id}}">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success">{{ __('Add Jadwal Kegiatan') }}</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal Konfirmasi Kegiatan -->
<div class="modal fade" id="modalKonfirmasiKegiatan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Kegiatan {{$extracurricular->name}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Data Kegiatan Yang Akan Dikonfirmasi:</p>
        <table>
          <tbody>
            <tr>
              <td>Nama Kegiatan </td>
              <td style="padding-left:15px;">&nbsp;:</td>
              <td id="nameConfirmAct"></td>
            </tr>
            <tr>
              <td>Tanggal Penghargaan </td>
              <td style="padding-left:15px;">&nbsp;:</td>
              <td id="dateConfirmAct"></td>
            </tr>
            <tr>
              <td>Deskripsi Kegiatan </td>
              <td style="padding-left:15px;">&nbsp;:</td>
              <td id="descConfirmAct"></td>
            </tr>
            <tr>
              <td>Dokumentasi Kegiatan </td>
              <td style="padding-left:15px;">&nbsp;:</td>
              <td id="photoConfirmAct"></td>
            </tr>
          </tbody>
        </table>
        <img id="photoKegiatan4" src="" width="200px" height="200px" alt="" class="rounded mx-auto d-none" >
      <br>
      <form method="POST" action="{{ route('activity.confirm') }}">
        @csrf
        
        <div class="form-group row">
            <label for="confirm" class="col-md-4 col-form-label text-md-right">{{ __('Konfirmasi') }}</label>

            <div class="col-md-6">
            
                <select id="confirmAct" name="confirmAct" class="form-control">
                  <option value="Not Confirmed">Belum Dikonfirmasi</option>
                  <option value="Confirmed">Sudah Dikonfirmasi</option>
                </select>

                @error('confirm')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                
            </div>
        </div>
                

      <input type="hidden" id="id" name="id" value="">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success">{{ __('Konfirmasi Kegiatan') }}</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal Edit Jadwal Kegiatan -->
<div class="modal fade" id="modalEditJadwalKegiatan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Jadwal Kegiatan {{$extracurricular->name}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form method="POST" action="{{ route('activity.update') }}">
        @csrf
        
        <div class="form-group row">
            <label for="nameEditAct" class="col-md-4 col-form-label text-md-right">{{ __('Nama Kegiatan') }}</label>

            <div class="col-md-6">
                <input id="nameEditAct" type="text" class="form-control @error('nameEditAct') is-invalid @enderror" name="nameEditAct" value="{{ old('nameEditAct') }}" required autocomplete="nameEditAct" autofocus>

                @error('nameEditAct')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="dateEditAct" class="col-md-4 col-form-label text-md-right">{{ __('Tanggal Pelaksanaan') }}</label>

            <div class="col-md-6">
                <input id="dateEditAct" type="date" class="form-control @error('dateEditAct') is-invalid @enderror" name="dateEditAct" value="{{ old('dateEditAct') }}" required autocomplete="dateEditAct" autofocus>

                @error('dateEditAct')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="descEditAct" class="col-md-4 col-form-label text-md-right">{{ __('Deskripsi Kegiatan') }}</label>

            <div class="col-md-6">
                <textarea id="descEditAct" class="form-control @error('descEditAct') is-invalid @enderror" name="descEditAct" value="{{ old('descEditAct') }}" autocomplete="descEditAct" autofocus></textarea>
                @error('descEditAct')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

      <input type="hidden" id="id" name="id" value="">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success">{{ __('Edit Jadwal Kegiatan') }}</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal Delete Jadwal Kegiatan -->
<div class="modal fade" id="modalDelJadwalKegiatan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Delete Jadwal Kegiatan Ekstrakurikuler</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Are you sure want to delete this Activity?</p>
        <table >
          <tbody>
            <tr>
              <td>Nama Kegiatan </td>
              <td style="padding-left:15px;">&nbsp;:</td>
              <td id="nameDelAct"></td>
            </tr>
            <tr>
              <td>Tanggal Penghargaan </td>
              <td style="padding-left:15px;">&nbsp;:</td>
              <td id="dateDelAct"></td>
            </tr>
            <tr>
              <td>Deskripsi Kegiatan </td>
              <td style="padding-left:15px;">&nbsp;:</td>
              <td id="descDelAct"></td>
            </tr>
          </tbody>
        </table>
      <form method="POST" action="{{ route('activity.delete') }}" >
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

<!-- Modal Edit Detail Kegiatan -->
<div class="modal fade" id="modalEditDetailKegiatan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Detail Kegiatan {{$extracurricular->name}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <table>
        <tbody>
          <tr>
            <td>Nama Kegiatan </td>
            <td>:</td>
            <td id="nameEditDetailAct"></td>
          </tr>
          <tr>
            <td>Tanggal Pelaksanaan </td>
            <td>:</td>
            <td id="dateEditDetailAct"></td>
          </tr>
          <tr>
            <td>Deskripsi </td>
            <td>:</td>
            <td id="descEditDetailAct"></td>
          </tr>
          <tr>
            <td>Konfirmasi Kegiatan </td>
            <td>:</td>
            <td id="confirmEditDetailAct"></td>
          </tr>
          <tr>
            <td>Dokumentasi Kegiatan </td>
            <td>:</td>
            <td id="photoEmpty"></td>
          </tr>
        </tbody>
      </table>

      <img id="photoKegiatan2" src="" width="200px" height="200px" alt="" class="rounded mx-auto d-none" >
      <br>
      <form method="POST" action="{{ route('activity.updateDetail') }}" enctype="multipart/form-data">
        @csrf
        
        <div class="form-group row">
            <label for="photoEditDetailAct" class="col-md-4 col-form-label text-md-right">{{ __('Photo Kegiatan') }}</label>

            <div class="col-md-6">
                <input id="photoEditDetailAct" type="file" class="form-control-file my-1 @error('photoEditDetailAct') is-invalid @enderror" name="photoEditDetailAct" value="{{ old('photoEditDetailAct') }}" required autocomplete="photoEditDetailAct" autofocus>

                @error('photoEditDetailAct')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

      <input type="hidden" id="id" name="id" value="">
      <input type="hidden" id="extracurricular_id" name="extracurricular_id" value="{{$extracurricular->id}}">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success">{{ __('Edit Detail Kegiatan') }}</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal Photo -->
<div class="modal fade" id="modalPhoto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="PhotoModalLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table>
          <tbody>
            <tr>
              <td>Nama Kegiatan</td>
              <td>:</td>
              <td id="nameAct"></td>
            </tr>
            <tr>
              <td>Tanggal Pelaksanaan</td>
              <td>:</td>
              <td id="dateAct"></td>
            </tr>
            <tr>
              <td>Dokumentasi Kegiatan</td>
              <td>:</td>
              <td id="dokPhoto"></td>
            </tr>
          </tbody>
        </table>

        <img id="photoKegiatan3" src="" width="400px" height="400px" alt="" class="rounded mx-auto d-none" >
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div id="Table" style="display:none;">
    <table id="tableKegiatan" class="table-bordered">
        <thead>
        <tr>
            <th>No.</th>
            <th>Ekstrakurikuler</th>
            <th>Periode</th>
            <th>Nama Kegiatan</th>
            <th>Deskripsi Kegiatan</th>
            <th>Tanggal Pelaksanaan</th>
        </tr>
        </thead>
        <tbody>
            @foreach($activities as $activity)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$activity->extracurricular->name}}</td>
                    <td>{{$activity->period}}</td>
                    <td>{{$activity->name}}</td>
                    <td>{{$activity->desc}}</td>
                    <td>{{date('d F Y', strtotime($activity->date))}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table id="tablePrestasi" class="table-bordered">
        <thead>
        <tr>
            <th>No.</th>
            <th>Ekstrakurikuler</th>
            <th>Periode</th>
            <th>Nama Prestasi</th>
            <th>Status</th>
            <th>Tanggal Penghargaan</th>
        </tr>
        </thead>
        <tbody>
            @foreach($achievements as $achievement)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$achievement->extracurricular->name}}</td>
                    <td>{{$achievement->period}}</td>
                    <td>{{$achievement->name}}</td>
                    <td>{{$achievement->status}}</td>
                    <td>{{date('d F Y', strtotime($achievement->date))}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table id="tableAnggota" class="table-bordered">
        <thead>
        <tr>
            <th>No.</th>
            <th>Ekstrakurikuler</th>
            <th>Nis</th>
            <th>Nama</th>
            <th>Kelas</th>
            <th>Status</th>
            <th>Angkatan</th>
        </tr>
        </thead>
        <tbody>
            @foreach($members as $member)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$member->extracurricular->name}}</td>
                    <td>{{$member->student->nis}}</td>
                    <td>{{$member->student->name}}</td>
                    <td>{{$member->student->class}}</td>
                    <td>{{$member->status}}</td>
                    <td>{{$member->angkatan}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>


</div>
@endsection

@section('scriptplus')
<script>
    $(document).ready(function () {
      $('#student_id').selectize({
          onInitialize: function(){
			var s = this;
			this.revertSettings.$children.each( function(){
				   $.extend(s.options[this.value], $(this).data());
		    });
		  }
      });

      $('#statusPres').on('change',function(){
        if( $(this).val()==="Lainnya"){
          $("#lainnyaInput").show()
        }
        else{
          $("#lainnyaInput").hide()
        }
      });

      $('#statusPres1').on('change',function(){
        if( $(this).val()==="Lainnya"){
          $("#lainnyaInput1").show()
        }
        else{
          $("#lainnyaInput1").hide()
        }
      });
    });

    $('#student_id').on('change', function(){
        var s = $('#student_id')[0].selectize; 
        var data = s.options[s.items[0]]; 
        document.getElementById("nis").innerHTML = data.nis;
        document.getElementById("nameS").innerHTML = data.nama;
        document.getElementById("class").innerHTML = data.kelas; 
    });

    $(document).on('click','#btnEditAnggota', function(){
      var idEditAnggota = $(this).data('id');
      var nisEditAnggota = $(this).data('nis');
      var nameEditAnggota = $(this).data('name');
      var classEditAnggota = $(this).data('class');
      var angkatanEditAnggota = $(this).data('angkatan');
      var statusEditAnggota = $(this).data('status');
      $(".modal-body #idEditAnggota").val(idEditAnggota);
      $(".modal-body #angkatanEditAnggota").val(angkatanEditAnggota);
      document.getElementById("nisEditAnggota").innerHTML = nisEditAnggota;
      document.getElementById("nameEditAnggota").innerHTML = nameEditAnggota;
      document.getElementById("classEditAnggota").innerHTML = classEditAnggota;

      if (statusEditAnggota === "Aktif") {
          document.getElementById("statusEditAnggota").selectedIndex = 0;
      }else if (status === "Tidak Aktif") {
          document.getElementById("statusEditAnggota").selectedIndex = 1;
      }
      else if (status === "Pengurus") {
          document.getElementById("statusEditAnggota").selectedIndex = 2;
      }
      else if (status === "Spesial") {
          document.getElementById("statusEditAnggota").selectedIndex = 3;
      }
      else if (status === "Alumni") {
          document.getElementById("statusEditAnggota").selectedIndex = 4;
      }
    });

    $(document).on('click','#btnDelAnggota', function(){
        var id = $(this).data('id');
        var nis = $(this).data('nis');
        var name = $(this).data('name');
        var class1 = $(this).data('class');
        var angkatan = $(this).data('angkatan');
        var status = $(this).data('status');
        $(".modal-body #id").val(id);
        document.getElementById("nis1").innerHTML = nis;
        document.getElementById("name1").innerHTML = name;
        document.getElementById("class1").innerHTML = class1;
        document.getElementById("angkatan1").innerHTML = angkatan;
        document.getElementById("status1").innerHTML = status;
    });

    $(document).on('click','#btnEditPrestasi', function(){
        var id = $(this).data('id');
        var name2 = $(this).data('name');
        var date2 = $(this).data('date');
        var confirm2 = $(this).data('confirm');
        var status2 = $(this).data('status');
        $(".modal-body #id").val(id);
        $(".modal-body #name").val(name2);
        $(".modal-body #date").val(date2);

        $("#lainnyaInput1").hide()
        if (status2 === "Juara 1") {
            document.getElementById("statusPres1").selectedIndex = 0;
        }else if (status2 === "Juara 2") {
            document.getElementById("statusPres1").selectedIndex = 1;
        }
        else if (status2 === "Juara 3") {
            document.getElementById("statusPres1").selectedIndex = 2;
        }
        else if (status2 === "Juara Umum") {
            document.getElementById("statusPres1").selectedIndex = 3;
        }
        else if (status2 === "Finalis") {
            document.getElementById("statusPres1").selectedIndex = 4;
        }else{
            document.getElementById("statusPres1").selectedIndex = 5;
            $("#lainnyaInput1").show()
            $(".modal-body #lainnya1").val(status2);
        }
    });

    $(document).on('click','#btnDelPrestasi', function(){
        var id3 = $(this).data('id');
        var name3 = $(this).data('name');
        var confirm3 = $(this).data('confirm');
        var date3 = $(this).data('date');
        var status3 = $(this).data('status');
        $(".modal-body #id").val(id3);
        document.getElementById("name3").innerHTML = name3;
        document.getElementById("date3").innerHTML = date3;
        document.getElementById("status3").innerHTML = status3;

    });

    $(document).on('click','#btnKonfirmasiPrestasi', function(){
        var id = $(this).data('id');
        var name4 = $(this).data('name');
        var date4 = $(this).data('date');
        var confirm4 = $(this).data('confirm');
        var status4 = $(this).data('status');
        $(".modal-body #id").val(id);
        document.getElementById("name4").innerHTML = name4;
        document.getElementById("date4").innerHTML = date4;
        document.getElementById("status4").innerHTML = status4;
        if (confirm4 === "Not Confirmed") {
          document.getElementById("confirm").selectedIndex = 0;
        }else if (confirm4 === "Confirmed") {
          document.getElementById("confirm").selectedIndex = 1;
        }

    });

    $(document).on('click','#btnKonfirmasiKegiatan', function(){
        var id = $(this).data('id');
        var nameConfirmAct = $(this).data('name');
        var dateConfirmAct = $(this).data('date');
        var confirmAct = $(this).data('confirm');
        var descConfirmAct = $(this).data('desc');
        var photoConfirmAct = $(this).data('photo');
        $(".modal-body #id").val(id);
        document.getElementById("nameConfirmAct").innerHTML = nameConfirmAct;
        document.getElementById("dateConfirmAct").innerHTML = dateConfirmAct;
        document.getElementById("descConfirmAct").innerHTML = descConfirmAct;
        if (confirmAct === "Not Confirmed") {
          document.getElementById("confirmAct").selectedIndex = 0;
        }else if (confirmAct === "Confirmed") {
          document.getElementById("confirmAct").selectedIndex = 1;
        }
        if(photoConfirmAct.length === 0) {
          document.getElementById("photoConfirmAct").innerHTML = "Dokumentasi belum ditambahkan";
          document.getElementById("photoKegiatan4").className = "rounded mx-auto d-none";
        }else{
          document.getElementById("photoConfirmAct").innerHTML = "Dokumentasi sudah ditambahkan";
          document.getElementById("photoKegiatan4").src = "/uploaded_files/Extracurricular/"+{{$extracurricular->id}}+"/Activity/photo/"+photoConfirmAct;
          document.getElementById("photoKegiatan4").className = "rounded mx-auto d-block";
        }
    });

    $(document).on('click','#btnEditJadwalKegiatan', function(){
        var id = $(this).data('id');
        var nameEditAct = $(this).data('name');
        var dateEditAct = $(this).data('date');
        var confirmEditAct = $(this).data('confirm');
        var descEditAct = $(this).data('desc');
        $(".modal-body #id").val(id);
        $(".modal-body #nameEditAct").val(nameEditAct);
        $(".modal-body #dateEditAct").val(dateEditAct);
        $(".modal-body #descEditAct").val(descEditAct);

    });

    $(document).on('click','#btnDelJadwalKegiatan', function(){
        var id = $(this).data('id');
        var nameDelAct = $(this).data('name');
        var confirmDelAct = $(this).data('confirm');
        var dateDelAct = $(this).data('date');
        var descDelAct = $(this).data('desc');
        $(".modal-body #id").val(id);
        document.getElementById("nameDelAct").innerHTML = nameDelAct;
        document.getElementById("dateDelAct").innerHTML = dateDelAct;
        document.getElementById("descDelAct").innerHTML = descDelAct;

    });
    
    $(document).on('click','#btnEditDetailKegiatan', function(){
        var id = $(this).data('id');
        var extracurricularId = {{$extracurricular->id}};
        var nameEditDetailAct = $(this).data('name');
        var confirmEditDetailAct = $(this).data('confirm');
        var dateEditDetailAct = $(this).data('date');
        var descEditDetailAct = $(this).data('desc');
        var photoEditDetailAct = $(this).data('photo');
        $(".modal-body #id").val(id);
        document.getElementById("nameEditDetailAct").innerHTML = nameEditDetailAct;
        document.getElementById("dateEditDetailAct").innerHTML = dateEditDetailAct;
        document.getElementById("descEditDetailAct").innerHTML = descEditDetailAct;
        document.getElementById("confirmEditDetailAct").innerHTML = confirmEditDetailAct;
        
        if (photoEditDetailAct === "") {
          $("#photoKegiatan2").hide();
          document.getElementById("photoEmpty").innerHTML = "Documentation Photo has not been added";
          document.getElementById("photoKegiatan2").className = "rounded mx-auto d-none";
        }else{
          $("#photoKegiatan2").show();
          document.getElementById("photoEmpty").innerHTML = "";
          document.getElementById("photoKegiatan2").src = "/uploaded_files/Extracurricular/"+extracurricularId+"/Activity/photo/"+photoEditDetailAct;
          document.getElementById("photoKegiatan2").className = "rounded mx-auto d-block";          
        }
    });

    $(document).on('click','#btnPhoto', function(){
        var nameAct = $(this).data('name');
        var photoAct = $(this).data('photo');
        var dateAct = $(this).data('date');
        document.getElementById("PhotoModalLabel").innerHTML = "Dokumentasi Kegiatan "+nameAct;
        document.getElementById("nameAct").innerHTML = nameAct;
        document.getElementById("dateAct").innerHTML = dateAct;
        
        if(photoAct.length === 0) {
          document.getElementById("dokPhoto").innerHTML = "Dokumentasi belum ditambahkan";
          document.getElementById("photoKegiatan3").className = "rounded mx-auto d-none";
        }else{
          document.getElementById("dokPhoto").innerHTML = "";
          document.getElementById("photoKegiatan3").src = "/uploaded_files/Extracurricular/"+{{$extracurricular->id}}+"/Activity/photo/"+photoAct;
          document.getElementById("photoKegiatan3").className = "rounded mx-auto d-block";
        }
        
    });

    $(document).on('click','#btnExportKegiatan', function(){
      var ekskul = "{{$extracurricular->name}}";
      var date = new Date();
      var year = date.getFullYear();
      var month = date.getMonth();
      var date = date.getDate();
      var hour = new Date().getHours() 
      var minutes = new Date().getMinutes();
      var date = year+"-"+month+"-"+date+"_"+hour+":"+minutes;
      var table2excel1 = new Table2Excel();
      table2excel1.export(document.querySelectorAll("#tableKegiatan"),"Laporan_Kegiatan_"+ekskul+"_"+date);
    });

    $(document).on('click','#btnExportPrestasi', function(){
      var ekskul = "{{$extracurricular->name}}";
      var date = new Date();
      var year = date.getFullYear();
      var month = date.getMonth();
      var date = date.getDate();
      var hour = new Date().getHours() 
      var minutes = new Date().getMinutes();
      var date = year+"-"+month+"-"+date+"_"+hour+":"+minutes;
      var table2excel2 = new Table2Excel();
      table2excel2.export(document.querySelectorAll("#tablePrestasi"),"Laporan_Prestasi_"+ekskul+"_"+date);
    });

    $(document).on('click','#btnExportAnggota', function(){
      var ekskul = "{{$extracurricular->name}}";
      var date = new Date();
      var year = date.getFullYear();
      var month = date.getMonth();
      var date = date.getDate();
      var hour = new Date().getHours() 
      var minutes = new Date().getMinutes();
      var date = year+"-"+month+"-"+date+"_"+hour+":"+minutes;
      var table2excel3 = new Table2Excel();
      table2excel3.export(document.querySelectorAll("#tableAnggota"),"Laporan_Anggota_"+ekskul+"_"+date);
    });
</script>
@endsection
