@extends('layouts.app')

@section('title')
	Identitas Pengusul
@endsection

@section('breadcrumb')
	@parent
    <li><a href="{{ route('perbaikanpengabdianng.index') }}">Pengabdian</a></li>
    <li>Konfirmasi anggota</li>
@endsection

@section('content')

<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <div class="panel panel-primary">
            <div class="panel-heading"><div class="pull-right"><strong></strong></div></div>
            @if($errors->first('success'))
                <script type="text/javascript">
                    "use strict";
                    swal(
                        'Selamat!',
                        'Data Berhasil Disimpan',
                        'success'
                    );
                </script>
            @elseif($errors->first('error'))
                <script type="text/javascript">

                    "use strict";
                    swal(
                        'Terjadi Kesalahan!',
                        'Gagal Menolak atau Bersedia Untuk Berpartisipasi..',
                        'error'
                    );
                </script>
            @else
            @endif
            <div class="panel-footer bg-white">
                <div class="row">

                    <div class="col-md-12">
                    <div class="box box-widget widget-user">
                        <div class="widget-user-header bg-aqua-active">
                            <h3 class="widget-user-username">{{$peneliti->nama}}</h3>
                            <h5 class="widget-user-desc">{{$peneliti->fakultas->fakultas}}</h5>
                        </div>
                        <div class="widget-user-image">
                            <img class="img-circle" src="{{asset('public/images/'.$peneliti->foto)}}" alt="User Avatar">
                        </div>
                        <div class="box-footer">
                        <div class="row">
                            <div class="col-sm-4 border-right">
                                <div class="description-block">
                                    <h5 class="description-header">{{$toteliti}}</h5>
                                    <span class="description-text">PENELITIAN</span>
                                </div>
                            </div>
                            <div class="col-sm-4 border-right">
                                <div class="description-block">
                                    <h5 class="description-header">{{$peneliti->hindex}}</h5>
                                    <span class="description-text">H-INDEX</span>
                                </div>                                   
                            </div>
                            <div class="col-sm-4">
                                <div class="description-block">
                                    <h5 class="description-header">{{$totabdi}}</h5>
                                    <span class="description-text">PENGABDIAN</span>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-12">
                    <div class="box-footer">
                        <div class="row">
                            <div class="col-sm-12 border-right">
                                <div class="description-block">
                                    <h5 class="description-header">Judul Usulan:</h5>
                                    <span class="description-text">{{$proposal->judul}}</span>
                                    <hr>
                                </div>

                                Skema: {{$proposal->skema->skema}}
                                <br><br>
                                Bidang Ilmu: {{$proposal->rumpun->ilmu3}}
                                <br><hr>
                                <i>Clausule:</i>
                                <br>
                                Bersamaan dengan lembaran ini dan berdasarkan ringkasan kegiatan, apakah saudara <b>{{$dosen->nama}}</b> bersedia berpartisipasi dalam kegiatan tersebut dengan tugas dan peran sebagai berikut: <br> <b>Peran : </b> Anggota Pengusul {{$peneliti->peran}} <br> <b>Tugas : </b> {{$peneliti->tugas}}  
                                <br><br> 
                            </div>  
                        </div>
                    </div>
                    </div> 
                </div>
                <div class="row">
                <br>
                <form class="form-horizontal" method="POST">
                {{ csrf_field() }} {{method_field('PATCH')}}
                    <div class="col-md-10">
                        <a href="{{route('perbaikanpengabdianng.response', base64_encode(('2'.mt_rand(1,9).$peneliti->id)+$peneliti->anggotaid) )}}" class="btn btn-danger pull-right" name="tolak" id="tolak"><span class="glyphicon glyphicon-thumbs-down"></span> TOLAK</a>
                        <a href="{{route('perbaikanpengabdianng.index')}}" class="btn btn-default pull-left" name="lanjut" id="lanjut"><span class="fa fa-reply fa-fw"></span> Kembali</a>
                    </div>
                    <div class="col-md-2">
                        <a href="{{route('perbaikanpengabdianng.response', base64_encode(('1'.mt_rand(1,9).$peneliti->id)+$peneliti->anggotaid) )}}" class="btn btn-primary pull-right" name="setuju" id="setuju"><span class="glyphicon glyphicon-thumbs-up"></span> BERSEDIA</a> &nbsp;
                    </div>
                </form>
                </div>
            </div> 
        </div>
    </div>
</div>

@endsection
