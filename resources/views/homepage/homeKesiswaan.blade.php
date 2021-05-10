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

                    You are logged in! But as a Kesiswaan
                    <br>
                    <button id="btnExportKegiatanAll" type="button" class="btn btn-primary">Export Data Kegiatan</button>
                    <br>
                    <button id="btnExportPrestasiAll" type="button" class="btn btn-primary">Export Data Prestasi</button>
                    <br>
                    <button id="btnExportAnggotaAll" type="button" class="btn btn-primary">Export Data Anggota</button>
                    <hr>
                    <ol>
                    @foreach($extracurriculars as $extracurricular)
                        <li>
                            <a href="{{url('/home/kesiswaan',$extracurricular->id)}}">{{$extracurricular->name}}</a>
                            <p>Status : {{$extracurricular->status}}</p>
                        </li>
                    @endforeach
                    </ol>
                </div>
            </div>
        </div>
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