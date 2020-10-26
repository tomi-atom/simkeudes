@extends('layouts.app')

@section('title')
    Ringkasan Usulan Penelitian
@endsection

@section('breadcrumb')
    @parent
    <li><a href="{{ route('penelitianng.index') }}">Penelitian</a></li>
    <li>Pengusul</li>
    <li>Ringkasan</li>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/sweetalert2/1.3.3/sweetalert2.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/sweetalert2/0.4.5/sweetalert2.css">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/sweetalert2/1.3.3/sweetalert2.min.js"></script>
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading"><strong></strong> <div class="pull-right"><strong></strong></div></div>
            
            <div class="panel-body">


                <div class="panel panel-default">
                    <div class="panel-heading"><strong>Periode:  {{$periode->tahun}} | Batch {{$periode->sesi}} | Tanggal Mulai <small class="label label-success">{{$periode->tm_rancangan}}</small> | Tanggal Selesai <small class="label label-danger">{{$periode->ta_rancangan}}</small> </strong></div>
            
                    <div class="panel-body">
                        <div class="">
                            <div class="box-header">
                                <i class="ion ion-clipboard"></i>
                                <h4 class="box-title">Pengusul: {{$ketua->nama}}</h4><br>
                                <tr>

                                </tr>
                            </div>
                            <br>
                            <form action="{{ route('r_rancangan.update', $penelitian->id) }}" method="POST" data-toggle="validator" class="form form-horizontal"  enctype="multipart/form-data" >
                                {{ csrf_field() }} {{method_field('PATCH')}}

                                @if($errors->first('success'))



                                    <script type="text/javascript">

                                        "use strict";
                                        swal({
                                            title:  'Selamat!',
                                            text: "Data Berhasil Diupdate",
                                            type: 'success',
                                            showCancelButton: true,
                                            confirmButtonColor: '#5bc0de',
                                            cancelButtonColor: '#f0ad4e',
                                            confirmButtonText: 'Kembali!',
                                            cancelButtonText: 'Tutup'
                                        }).then(function(isConfirm) {
                                                if (isConfirm) {

                                                    window.location = "{{route('r_rancangan.index', '')}}"
                                                }
                                            }
                                        );
                                    </script>
                                @elseif($errors->first('error'))

                                    <script type="text/javascript">

                                        "use strict";
                                        swal(
                                            'Selamat!',
                                            'Data Berhasil Disimpan',
                                            'success'
                                        );
                                    </script>
                                @endif

                                <div class="panel-body">
                                    <div class="panel panel-default">
                                        <div class="panel-heading"><strong>Berkas Seminar Hasil: </strong></div>

                                        <input type="hidden"  name="prosalid" id="prosalid" value="{{$penelitian->prosalid}}" readonly>

                                        <div class="row">
                                            <div class="col-sm-2">
                                                <label class="control-label col-sm-offset-1 pull-right">Judul</label>
                                            </div>
                                            <div class="col-sm-8">
                                                <h5>{{$prop->judul}}
                                                    @if ($prop->jenis==1)
                                                        <small class="label bg-blue label-primary">Penelitian</small>
                                                    @else
                                                        <small class="label bg-warning label-warning">Pengabdian</small>
                                                    @endif
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-2">
                                                <label class="control-label col-sm-offset-1 pull-right">Anggota</label>
                                            </div>
                                            <div class="col-sm-8">
                                                @foreach($peserta as $anggota)
                                                    <h5>{{$anggota->nama}} <small class="label label-warning">Anggota Pengusul {{$anggota->peran}}</small></h5>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-2">
                                                <label class="control-label col-sm-offset-1 pull-right">Judul</label>
                                            </div>
                                            <div class="col-sm-8">
                                                <h5>{{$prop->judul}} <span class="label label-warning">{{$prop->program->program}}</span><span class="label label-primary"> {{$prop->skema->skema}}</span></h5>
                                            </div>
                                        </div>
                                        <br>
                                        <p></p>
                                        <div class="row">
                                            <div class="col-sm-2">
                                                <label class="control-label col-sm-offset-1 pull-right">Komentar</label>
                                            </div>
                                            <div class="col-sm-8">

                                                <textarea class="form-control" rows="2" placeholder="Komentar..." name="komentar" id="komentar"   cols="50" required>{{$penelitian->komentar}}</textarea>

                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-sm-10">
                                                <button type="submit" class="btn btn-primary btn-save pull-right" ><i class="fa fa-floppy-o"></i> Simpan </button>
                                            </div>
                                        </div>
                                        <br>
                                    </div>
                                </div>
                            </form>
                            <br>
                            <div>
                                @if ($penelitian->upload)
                                    <embed src="{{url('/public/docs/periode2/rancangan/'.$penelitian->upload)}}" type="application/pdf" width="100%" height="600px" />
                                @else
                                @endif
                            </div>

                        </div>

                    </div>
                    <form class="form-horizontal" method="POST" action="{{ route('r_rancangan.index') }}">
                        {{ csrf_field() }} {{ method_field('GET') }}

                        <div class="form-group row">
                            <div class="col-md-8 ">
                                <button type="submit" class="btn btn-default pull-left">
                                    <span class="fa fa-reply fa-fw"></span>
                                    Kembali
                                </button>
                            </div>
                        </div>
                    </form>
            </div>
        </div>

    </div>
</div>

@endsection
