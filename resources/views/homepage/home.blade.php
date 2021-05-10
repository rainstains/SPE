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
                    @if ($extracurricular->status == "Active")
                    <table width="100%">
                      <tbody>
                        <tr>
                          <td rowspan="5" style="text-align:center">
                          <img src="/uploaded_files/Extracurricular/{{$extracurricular->id}}/logo/{{$extracurricular->logo}}" width="200px" height="200px" alt="">
                          </td>
                          <td></td>
                          <td colspan="4" rowspan="2" style="text-align:center"><h5>{{$extracurricular->name}}</h5></td>
                        </tr>
                        <tr>
                          <td></td>
                        </tr>
                        <tr>
                          <td></td>
                          <td>Tanggal Berdiri</td>
                          <td>:</td>
                          <td colspan="2">{{$extracurricular->dateEstablished}}</td>
                        </tr>
                        <tr>
                          <td></td>
                          <td>Jumlah Anggota Aktif</td>
                          <td>:</td>
                          <td colspan="2">{{$activeMember}}</td>
                        </tr>
                        <tr>
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
                              <button id="btnEditEkskul" type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalEditEkskul">Edit Ekstrakurikuler</button>
                            @endif
                          </td>
                        </tr>
                      </tbody>
                    </table>

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
                        <div class="tab-pane fade active show" id="kegiatan" role="tabpanel" aria-labelledby="kegiatan-tab">
                          @if($user->role == "Pembina")
                            <button id="btnAddKegiatan" type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalAddJadwalKegiatan">Add Jadwal Kegiatan</button>
                          @elseif($user->role == "Kesiswaan")
                            <button id="btnExportKegiatan" type="button" class="btn btn-primary">Export Data Kegiatan</button>
                          @endif
                          <table class="table table-striped">
                            <thead class="thead-dark">
                              <tr>
                                <th scope="col">No.</th>
                                <th scope="col">Nama Kegiatan</th>
                                <th scope="col">Deskripsi</th>
                                <th scope="col">Tanggal Pelaksanaan</th>
                                <th scope="col">Dokumentasi Kegiatan</th>
                                <th scope="col">Action</th>
                              </tr>
                            </thead>
                            <tbody>
                              @php ($noKegiatan = 1 ) @endphp
                              @foreach($activities as $activity)
                                <tr>
                                  <td scope="row">{{$noKegiatan}}</td>
                                  <td>{{$activity->name}}</td>
                                  <td>{{$activity->desc}}</td>
                                  <td>{{date('d F Y', strtotime($activity->date))}}</td>
                                  <td>
                                  <button id="btnPhoto" type="button" class="btn btn-primary" data-toggle="modal" data-name="{{$activity->name}}" data-date="{{$activity->date}}" data-photo="{{$activity->photo}}"  data-target="#modalPhoto" >Lihat Photo</button>
                                  </td>
                                  <td>
                                  @if($activity->confirm != "Confirmed")
                                    @if($user->role == "Pembina")
                                      <button id="btnKonfirmasiKegiatan" type="button" class="btn btn-primary" data-toggle="modal" data-id="{{ $activity->id}}" data-name="{{$activity->name}}" data-date="{{$activity->date}}" data-desc="{{$activity->desc}}"  data-photo="{{$activity->photo}}" data-confirm="{{$activity->confirm}}" data-target="#modalKonfirmasiKegiatan" >Konfirmasi</button>
                                      <button id="btnEditJadwalKegiatan" type="button" class="btn btn-primary" data-toggle="modal" data-id="{{ $activity->id}}" data-name="{{$activity->name}}" data-date="{{$activity->date}}" data-desc="{{$activity->desc}}"  data-photo="{{$activity->photo}}" data-confirm="{{$activity->confirm}}" data-target="#modalEditJadwalKegiatan" >Edit Jadwal</button>
                                      <button id="btnDelJadwalKegiatan" type="button" class="btn btn-primary" data-toggle="modal" data-id="{{ $activity->id}}" data-name="{{$activity->name}}" data-date="{{$activity->date}}" data-desc="{{$activity->desc}}"  data-photo="{{$activity->photo}}" data-confirm="{{$activity->confirm}}" data-target="#modalDelJadwalKegiatan" >Delete Jadwal</button>
                                    @elseif($user->role == "Pengurus")
                                      <button id="btnExportKegiatan" type="button" class="btn btn-primary" >Export</button>
                                    @elseif($user->role == "Kesiswaan")
                                      <button id="btnEditDetailKegiatan" type="button" class="btn btn-primary" data-toggle="modal" data-id="{{ $activity->id}}" data-name="{{$activity->name}}" data-date="{{$activity->date}}" data-desc="{{$activity->desc}}"  data-photo="{{$activity->photo}}" data-confirm="{{$activity->confirm}}" data-target="#modalEditDetailKegiatan" >Edit Detail</button>
                                    @endif
                                  @endif
                                  </td>
                                </tr>
                                @php ($noKegiatan++ ) @endphp
                              @endforeach
                            </tbody>
                          </table>
                        </div>

                        <div class="tab-pane fade" id="prestasi" role="tabpanel" aria-labelledby="prestasi-tab">
                          @if($user->role == "Pembina")
                            <button id="btnAddPrestasi" type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalAddPrestasi">Add Prestasi</button>
                          @elseif($user->role == "Kesiswaan")
                            <button id="btnExportPrestasi" type="button" class="btn btn-primary" >Export Data Prestasi</button>
                          @endif
                          <table class="table table-striped">
                            <thead class="thead-dark">
                              <tr>
                                <th scope="col">No.</th>
                                <th scope="col">Nama Prestasi</th>
                                <th scope="col">Status</th>
                                <th scope="col">Tanggal Penghargaaan</th>
                                <th scope="col">Action</th>
                              </tr>
                            </thead>
                            <tbody>
                            @php ($noPrestasi = 1 ) @endphp
                            @foreach($achievements as $achievement)
                              <tr>
                                <td scope="row">{{$noPrestasi}}</td>
                                <td>{{$achievement->name}}</td>
                                <td>{{$achievement->status}}</td>
                                <td>{{date('d F Y', strtotime($achievement->date))}}</td>
                                <td>
                                  @if($achievement->confirm != "Confirmed")
                                    @if($user->role == "Kesiswaan")
                                      <button id="btnKonfirmasiPrestasi" type="button" class="btn btn-primary" data-toggle="modal" data-id="{{ $achievement->id}}" data-name="{{$achievement->name}}" data-date="{{$achievement->date}}"  data-status="{{$achievement->status}}" data-confirm="{{$achievement->confirm}}" data-target="#modalKonfirmasiPrestasi" >Konfirmasi</button>
                                    @elseif($user->role == "Pembina")
                                      <button id="btnEditPrestasi" type="button" class="btn btn-primary" data-toggle="modal" data-id="{{ $achievement->id}}" data-name="{{$achievement->name}}" data-date="{{$achievement->date}}"  data-status="{{$achievement->status}}" data-confirm="{{$achievement->confirm}}" data-target="#modalEditPrestasi" >Edit</button>
                                      <button id="btnDelPrestasi" type="button" class="btn btn-primary" data-toggle="modal" data-id="{{ $achievement->id}}" data-name="{{$achievement->name}}"  data-date="{{$achievement->date}}"  data-status="{{$achievement->status}}" data-confirm="{{$achievement->confirm}}" data-target="#modalDelPrestasi">Delete</button>   
                                    @endif
                                  @endif
                                </td>
                              </tr>
                              @php ($noPrestasi++ ) @endphp
                              @endforeach
                            </tbody>
                          </table>
                        </div>
                        
                        <div class="tab-pane fade" id="anggota" role="tabpanel" aria-labelledby="anggota-tab">
                          @if($user->role == "Pengurus")
                            <button id="btnAddAnggota" type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalAddAnggota">Add Anggota</button>
                          @elseif($user->role == "Kesiswaan")
                            <button id="btnExportAnggota" type="button" class="btn btn-primary">Export Data Anggota</button>
                          @endif
                          <table class="table table-striped">
                            <thead class="thead-dark">
                              <tr>
                                <th scope="col">No.</th>
                                <th scope="col">Nama Siswa</th>
                                <th scope="col">Kelas</th>
                                <th scope="col">Status</th>
                                <th scope="col">Angkatan</th>
                                <th scope="col">Action</th>
                              </tr>
                            </thead>
                            <tbody>
                              @php ($noAnggota = 1 ) @endphp
                              @foreach($members as $member)
                                <tr>
                                  <td scope="row">{{$noAnggota}}</td>
                                  <td>{{$member->student->name}}</td>
                                  <td>{{$member->student->class}}</td>
                                  <td>{{$member->status}}</td>
                                  <td>{{$member->angkatan}}</td>
                                  <td>
                                  @if($user->role == "Pengurus")
                                    <button id="btnEditAnggota" type="button" class="btn btn-primary" data-toggle="modal" data-id="{{ $member->id}}" data-name="{{$member->student->name}}" data-nis="{{$member->student->nis}}" data-class="{{$member->student->class}}" data-angkatan="{{$member->angkatan}}" data-status="{{$member->status}}" data-target="#modalEditAnggota">Edit</button>
                                    <button id="btnDelAnggota" type="button" class="btn btn-primary" data-toggle="modal" data-id="{{ $member->id}}" data-name="{{$member->student->name}}" data-nis="{{$member->student->nis}}" data-class="{{$member->student->class}}" data-angkatan="{{$member->angkatan}}" data-status="{{$member->status}}" data-target="#modalDelAnggota">Delete</button>
                                  @endif
                                  </td>
                                </tr>
                                @php ($noAnggota++ ) @endphp
                              @endforeach
                            </tbody>
                          </table>
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
        
      <form method="POST" action="{{ route('member.create') }}">
        @csrf

        <div class="form-group row">
            <label for="student_id" class="col-md-4 col-form-label text-md-right">{{ __('Nama Calon Anggota') }}</label>

            <div class="col-md-6">
                <select name="student_id" id="student_id" placeholder="Cari Siswa ..." required>
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

        <input id="id" type="hidden" name="id" value="">
        <h6 style="text-align:center">Detail Data Anggota : </h6>
        <div class="form-group row">
            <label for="nis" class="col-md-4 col-form-label text-md-right">No. Induk Siswa</label>

            <div class="col-md-6">
            <p id="nis2"></p>
            </div>
        </div>
        <div class="form-group row">
            <label for="name" class="col-md-4 col-form-label text-md-right">Nama</label>

            <div class="col-md-6">
            <p id="name2"></p>
            </div>
        </div>
        <div class="form-group row">
            <label for="class" class="col-md-4 col-form-label text-md-right">Kelas</label>

            <div class="col-md-6">
            <p id="class2"></p>
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
        <div class="form-group row">
            <label for="status" class="col-md-4 col-form-label text-md-right">{{ __('Status') }}</label>

            <div class="col-md-6">
                <select name="status" id="status" class="form-control" required>
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
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">{{ __('Edit Anggota') }}</button>
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
        <p id="nis1"></p>
        <p id="name1"></p>
        <p id="class1"></p>
        <p id="angkatan1"></p>
        <p id="status1"></p>
      <form method="POST" action="{{ route('member.delete') }}" >
        @csrf           
        <input id="id" type="hidden" name="id" value="">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">{{ __('Delete') }}</button>
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
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">{{ __('Add Prestasi') }}</button>
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
      <p id="confirm2"></p>
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

      <input type="hidden" id="id" name="id" value="">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">{{ __('Edit Prestasi') }}</button>
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
        <p id="name3"></p>
        <p id="date3"></p>
        <p id="status3"></p>
        <p id="confirm3"></p>
      <form method="POST" action="{{ route('achievement.delete') }}" >
        @csrf           
        <input id="id" type="hidden" name="id" value="">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">{{ __('Delete') }}</button>
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
        <p id="name4"></p>
        <p id="date4"></p>
        <p id="status4"></p>
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
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">{{ __('Konfirmasi Prestasi') }}</button>
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
                <input id="nameAddAct" type="text" class="form-control @error('nameAddAct') is-invalid @enderror" name="nameAddAct" value="{{ old('nameAddAct') }}" required autocomplete="nameAddAct" autofocus>

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
                <textarea id="descAddAct" class="form-control @error('descAddAct') is-invalid @enderror" name="descAddAct" value="{{ old('descAddAct') }}" autocomplete="descAddAct" autofocus></textarea>
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
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">{{ __('Add Jadwal Kegiatan') }}</button>
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
        <p id="nameConfirmAct"></p>
        <p id="dateConfirmAct"></p>
        <p id="descConfirmAct"></p>
        <p id="photoConfirmAct"></p>
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
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">{{ __('Konfirmasi Kegiatan') }}</button>
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
      <p id="confirmEditAct"></p>
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
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">{{ __('Edit Jadwal Kegiatan') }}</button>
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
        <p id="nameDelAct"></p>
        <p id="dateDelAct"></p>
        <p id="descDelAct"></p>
        <p id="confirmDelAct"></p>
      <form method="POST" action="{{ route('activity.delete') }}" >
        @csrf           
        <input id="id" type="hidden" name="id" value="">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">{{ __('Delete') }}</button>
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
      <p id="confirmEditDetailAct"></p>
      <p id="nameEditDetailAct"></p>
      <p id="dateEditDetailAct"></p>
      <p id="descEditDetailAct"></p>
      <p id="photoEmpty"></p>
      <img id="photoKegiatan2" src="" width="200px" height="200px" alt="" style="display:none;">
      <form method="POST" action="{{ route('activity.updateDetail') }}" enctype="multipart/form-data">
        @csrf
        
        <div class="form-group row">
            <label for="photoEditDetailAct" class="col-md-4 col-form-label text-md-right">{{ __('Photo Kegiatan') }}</label>

            <div class="col-md-6">
                <input id="photoEditDetailAct" type="file" class="form-control @error('photoEditDetailAct') is-invalid @enderror" name="photoEditDetailAct" value="{{ old('photoEditDetailAct') }}" required autocomplete="photoEditDetailAct" autofocus>

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
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">{{ __('Edit Detail Kegiatan') }}</button>
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
              <td></td>
            </tr>
          </tbody>
        </table>

        <img id="photoKegiatan3" src="" width="400px" height="400px" alt="" class="rounded mx-auto d-block">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
    });

    $('#student_id').on('change', function(){
        var s = $('#student_id')[0].selectize; 
        var data = s.options[s.items[0]]; 
        document.getElementById("nis").innerHTML = ": "+data.nis;
        document.getElementById("nameS").innerHTML = ": "+data.nama;
        document.getElementById("class").innerHTML = ": "+data.kelas; 
    });

    $(document).on('click','#btnDelAnggota', function(){
        var id = $(this).data('id');
        var nis = $(this).data('nis');
        var name = $(this).data('name');
        var class1 = $(this).data('class');
        var angkatan = $(this).data('angkatan');
        var status = $(this).data('status');
        $(".modal-body #id").val(id);
        document.getElementById("nis1").innerHTML = "Nis : "+nis;
        document.getElementById("name1").innerHTML = "name : "+name;
        document.getElementById("class1").innerHTML = "class : "+class1;
        document.getElementById("angkatan1").innerHTML = "angkatan : "+angkatan;
        document.getElementById("status1").innerHTML = "status : "+status;
    });

    $(document).on('click','#btnEditAnggota', function(){
        var id = $(this).data('id');
        var nis = $(this).data('nis');
        var name = $(this).data('name');
        var class1 = $(this).data('class');
        var angkatan = $(this).data('angkatan');
        var status = $(this).data('status');
        $(".modal-body #id").val(id);
        $(".modal-body #angkatan").val(angkatan);
        document.getElementById("nis2").innerHTML = ": "+nis;
        document.getElementById("name2").innerHTML = ": "+name;
        document.getElementById("class2").innerHTML = ": "+class1;

        if (status === "Aktif") {
            document.getElementById("status").selectedIndex = 0;
        }else if (status === "Tidak Aktif") {
            document.getElementById("status").selectedIndex = 1;
        }
        else if (status === "Pengurus") {
            document.getElementById("status").selectedIndex = 2;
        }
        else if (status === "Spesial") {
            document.getElementById("status").selectedIndex = 3;
        }
        else if (status === "Alumni") {
            document.getElementById("status").selectedIndex = 4;
        }
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
        if (confirm2 === "Not Confirmed") {
          document.getElementById("confirm2").innerHTML = "Prestasi belum dikonfirmasi";
        }else{
          document.getElementById("confirm2").innerHTML = "Prestasi sudah dikonfirmasi";
        }
        
        $("#lainnyaInput").hide()
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
            $("#lainnyaInput").show()
            $(".modal-body #lainnya").val(status2);
        }
    });

    $(document).on('click','#btnDelPrestasi', function(){
        var id3 = $(this).data('id');
        var name3 = $(this).data('name');
        var confirm3 = $(this).data('confirm');
        var date3 = $(this).data('date');
        var status3 = $(this).data('status');
        $(".modal-body #id").val(id3);
        document.getElementById("name3").innerHTML = "name : "+name3;
        document.getElementById("date3").innerHTML = "date : "+date3;
        document.getElementById("status3").innerHTML = "status : "+status3;
        document.getElementById("confirm3").innerHTML = "confirm : "+confirm3;
    });

    $(document).on('click','#btnKonfirmasiPrestasi', function(){
        var id = $(this).data('id');
        var name4 = $(this).data('name');
        var date4 = $(this).data('date');
        var confirm4 = $(this).data('confirm');
        var status4 = $(this).data('status');
        $(".modal-body #id").val(id);
        document.getElementById("name4").innerHTML = "name : "+name4;
        document.getElementById("date4").innerHTML = "date : "+date4;
        document.getElementById("status4").innerHTML = "status : "+status4;
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
        document.getElementById("nameConfirmAct").innerHTML = "name : "+nameConfirmAct;
        document.getElementById("dateConfirmAct").innerHTML = "date : "+dateConfirmAct;
        document.getElementById("descConfirmAct").innerHTML = "desc : "+descConfirmAct;
        if (confirmAct === "Not Confirmed") {
          document.getElementById("confirmAct").selectedIndex = 0;
        }else if (confirmAct === "Confirmed") {
          document.getElementById("confirmAct").selectedIndex = 1;
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

        if (confirmEditAct === "Not Confirmed") {
          document.getElementById("confirmEditAct").innerHTML = "Prestasi belum dikonfirmasi";
        }else{
          document.getElementById("confirmEditAct").innerHTML = "Prestasi sudah dikonfirmasi";
        }
    });

    $(document).on('click','#btnDelJadwalKegiatan', function(){
        var id = $(this).data('id');
        var nameDelAct = $(this).data('name');
        var confirmDelAct = $(this).data('confirm');
        var dateDelAct = $(this).data('date');
        var descDelAct = $(this).data('desc');
        $(".modal-body #id").val(id);
        document.getElementById("nameDelAct").innerHTML = "name : "+nameDelAct;
        document.getElementById("dateDelAct").innerHTML = "date : "+dateDelAct;
        document.getElementById("descDelAct").innerHTML = "desc : "+descDelAct;
        document.getElementById("confirmDelAct").innerHTML = "confirm : "+confirmDelAct;
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
        document.getElementById("nameEditDetailAct").innerHTML = "name : "+nameEditDetailAct;
        document.getElementById("dateEditDetailAct").innerHTML = "date : "+dateEditDetailAct;
        document.getElementById("descEditDetailAct").innerHTML = "desc : "+descEditDetailAct;
        document.getElementById("confirmEditDetailAct").innerHTML = "confirm : "+confirmEditDetailAct;
        
        if (photoEditDetailAct === "") {
          $("#photoKegiatan2").hide();
          document.getElementById("photoEmpty").innerHTML = "Documentation Photo has not been added";
        }else{
          document.getElementById("photoEmpty").innerHTML = "Documentation : ";
          document.getElementById("photoKegiatan2").src = "/uploaded_files/Extracurricular/"+extracurricularId+"/Activity/photo/"+photoEditDetailAct;
          $("#photoKegiatan2").show();
        }
    });

    $(document).on('click','#btnPhoto', function(){
        var extracurricularId = {{$extracurricular->id}};
        var nameAct = $(this).data('name');
        var photoAct = $(this).data('photo');
        var dateAct = $(this).data('date');
        document.getElementById("PhotoModalLabel").innerHTML = "Dokumentasi Kegiatan "+nameAct;
        document.getElementById("nameAct").innerHTML = nameAct;
        document.getElementById("dateAct").innerHTML = dateAct;
        document.getElementById("photoKegiatan3").src = "/uploaded_files/Extracurricular/"+extracurricularId+"/Activity/photo/"+photoAct;
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
