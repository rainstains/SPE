@extends('layouts.app')

@section('content')
<style>
.card:hover{
  transform: scale(1.05);
  box-shadow: 0 10px 20px rgba(0,0,0,.12), 0 4px 8px rgba(0,0,0,.06);
}
</style>
<div class="container" >
  <div class="row ">
    <div class="col-md-12" style="display: flex; justify-content: flex-end;">
      <button id="btnExportAnggotaAll" type="button" class="btn btn-primary">Export Data Anggota</button>
      &nbsp;&nbsp;
      <button id="btnExportPrestasiAll" type="button" class="btn btn-primary">Export Data Prestasi</button>
      &nbsp;&nbsp;
      <button id="btnExportKegiatanAll" type="button" class="btn btn-primary">Export Data Kegiatan</button>
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
            <a href="{{url('/home/kesiswaan',$extracurricular->id)}}">
                <div class="card bg-secondary text-center my-auto" style="width: 17rem; display: inline-block"">
                    <br>
                    <img src="/uploaded_files/Extracurricular/{{$extracurricular->id}}/logo/{{$extracurricular->logo}}" style="text-align:center; margin: 0 auto; width: 200px; height: 200px; "  alt="...">
                    <div class="card-body">
                        <h5 class="card-title" style="color:white;">{{ $extracurricular->name}}</h5>
                        <p style="color:white;">Status : {{$extracurricular->status}}</p>
                    </div>
                </div>
            </a>
        </div>    
      
    @endforeach  
  </div>

    
</div>

<div id="allTable" style="display:none;"> >
    <table id="tableKegiatanEx" class="table-bordered">
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

    <table id="tablePrestasiEx" class="table-bordered">
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

    <table id="tableAnggotaEx" class="table-bordered">
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
    Table2Excel.extend((cell, cellText) => {
        if (typeof cellText === 'string'){
            return { t: 's', v: cellText } 
        }
        
        return null;
    });
    $(document).on('click','#btnExportKegiatanAll', function(){
      var date = new Date();
      var year = date.getFullYear();
      var month = date.getMonth();
      var date = date.getDate();
      var hour = new Date().getHours() 
      var minutes = new Date().getMinutes();
      var date = year+"-"+month+"-"+date+"_"+hour+":"+minutes;
      var table2excel1 = new Table2Excel();
      table2excel1.export(document.querySelectorAll("#tableKegiatanEx"),"Laporan_Kegiatan_Ektrakurikuler_"+date);
    });
    $(document).on('click','#btnExportPrestasiAll', function(){
      var date = new Date();
      var year = date.getFullYear();
      var month = date.getMonth();
      var date = date.getDate();
      var hour = new Date().getHours() 
      var minutes = new Date().getMinutes();
      var date = year+"-"+month+"-"+date+"_"+hour+":"+minutes;
      var table2excel2 = new Table2Excel();
      table2excel2.export(document.querySelectorAll("#tablePrestasiEx"),"Laporan_Prestasi_Ektrakurikuler_"+date);
    });
    $(document).on('click','#btnExportAnggotaAll', function(){
      var date = new Date();
      var year = date.getFullYear();
      var month = date.getMonth();
      var date = date.getDate();
      var hour = new Date().getHours() 
      var minutes = new Date().getMinutes();
      var date = year+"-"+month+"-"+date+"_"+hour+":"+minutes;
      var table2excel3 = new Table2Excel();
      table2excel3.export(document.querySelectorAll("#tableAnggotaEx"),"Laporan_Anggota_Ektrakurikuler_"+date);
    });
</script>
@endsection