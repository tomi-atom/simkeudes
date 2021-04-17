@extends('layouts.app')

@section('title')
    Daftar Usulan Baru
@endsection

@section('breadcrumb')
    @parent
    <li>Pengabdian</li>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/sweetalert2/1.3.3/sweetalert2.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/sweetalert2/0.4.5/sweetalert2.css">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/sweetalert2/1.3.3/sweetalert2.min.js"></script>

@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading"><strong>H-INDEX: {{ $peneliti->hindex }}</strong> <div class="pull-right"><strong>USULAN BARU: {{ $total }}</strong></div></div>
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
                        'Data Gagal Disimpan',
                        'error'
                    );
                </script>
            @elseif($errors->first('bersedia'))
                <script type="text/javascript">

                    "use strict";
                    swal(
                        'Bersedia!',
                        'Anda Telah Bersedia Untuk Berpartisipasi',
                        'success'
                    );
                </script>
            @elseif($errors->first('tolak'))
                <script type="text/javascript">

                    "use strict";
                    swal(
                        'Ditolak!',
                        'Anda Telah Menolak Untuk Berpartisipasi',
                        'info'
                    );
                </script>
            @elseif($errors->first('sistemtolak'))
                <script type="text/javascript">

                    "use strict";
                    swal(
                        'Ditolak Sistem!',
                        'Quota Keanggotaan pada Skema ini Telah Terpenuhi',
                        'info'
                    );
                </script>
            @else
            @endif
            <div class="panel-body">
                <div class="panel panel-default">
                    <div class="panel-heading"><strong>Persyaratan Umum: </strong></div>
            
                    <div class="panel-body">
                        <div class="box-header">
                            <i class="ion ion-clipboard"></i>
                            <h4 class="box-title"></h4>
                        </div>
            
                        <div class="box-body">
                            <ul class="todo-list">
                                <li>
                                    <span class="handle">
                                        <i class="fa fa-ellipsis-v"></i> <i class="fa fa-ellipsis-v"></i>
                                    </span>
                                    @if($peneliti->sinta != '')
                                    <i class="glyphicon glyphicon-ok-circle text-green"></i><span class="text text-blue"> Terdaftar Dalam Sinta : <b class="text-black">{{ $peneliti->sinta }}</b></span>
                                    @else
                                    <i class="glyphicon glyphicon-remove-circle text-red"></i><span class="text text-blue"> Terdaftar Dalam Sinta : <b class="text-black">Belum Terdaftar</b></span>
                                    <small class="label label-danger"><i class="ion ion-android-person"></i> Silakan hubungi Administrator LPPM</small> 
                                    @endif
                                </li>
                                <li>
                                    <span class="handle">
                                        <i class="fa fa-ellipsis-v"></i> <i class="fa fa-ellipsis-v"></i>
                                    </span>
                                    @if($peneliti->status == 1)
                                    <i class="glyphicon glyphicon-ok-circle text-green"></i><span class="text text-blue"> Status Pegawai : <b class="text-black">Aktif Mengajar</b></span>
                                    @else
                                    <i class="glyphicon glyphicon-remove-circle text-red"></i><span class="text text-blue"> Status Pegawai : <b class="text-black">Tidak Aktif</span>
                                    <small class="label label-danger"><i class="ion ion-android-person"></i> Silakan hubungi Administrator LPPM</small> 
                                    @endif
                                </li>
                                <li>
                                    <span class="handle">
                                        <i class="fa fa-ellipsis-v"></i> <i class="fa fa-ellipsis-v"></i>
                                    </span>
                                    @if($peneliti->tanggungan == 0)
                                    <i class="glyphicon glyphicon-ok-circle text-green"></i><span class="text text-blue"> Tanggungan Kegiatan : <b class="text-black">Tidak Ada</b></span> 
                                    @else
                                    <i class="glyphicon glyphicon-remove-circle text-red"></i><span class="text text-blue"> Tanggungan Kegiatan : <b class="text-black">Ada Tangunggan</b></span>
                                    <small class="label label-danger"><i class="ion ion-android-person"></i> Silakan hubungi Administrator LPPM</small> 
                                    @endif
                                </li>
                                <li>
                                    <span class="handle">
                                        <i class="fa fa-ellipsis-v"></i> <i class="fa fa-ellipsis-v"></i>
                                    </span>
                                    @if(($ketuaditerima < 1) && ($member < 2)) 
                                    <i class="glyphicon glyphicon-ok-circle text-green"></i><span class="text text-blue"> Kuota Usulan : <b class="text-black">Kuota Usulan Sebagai Ketua Tersedia</b></span> 
                                    @elseif($member >= 2)
                                    <i class="glyphicon glyphicon-remove-circle text-red"></i><span class="text text-blue"> Kuota Usulan : <b class="text-black">Kuota Usulan Sebagai Anggota Telah Terpenuhi</b></span><small class="label label-danger"><i class="ion ion-ios-pricetags-outline"></i> {{ $total}} Proposal</small> 
                                    @else
                                    <i class="glyphicon glyphicon-remove-circle text-red"></i><span class="text text-blue"> Kuota Usulan : <b class="text-black">Kuota Usulan Sebagai Ketua Telah Terpenuhi</b></span><small class="label label-danger"><i class="ion ion-ios-pricetags-outline"></i> {{ $ketua}} Proposal</small> 
                                    @endif
                                </li>

                            </ul>
                        </div>
                    </div>
                </div> 

                @if(($peneliti->sinta != '') && ($peneliti->status == 1) && ($peneliti->tanggungan == 0) &&  ($ketuaditerima < 1) && ($member < 2))
                <form class="form-horizontal" method="POST" action="{{ route('pengabdianng.create') }}">
                {{ csrf_field() }} {{method_field('GET')}}
                @endif 

                <div class="row">
                    <div class="col-sm-3">
                        <label class="control-label col-sm-9">Periode Pengusulan</label>
                    </div>
                    <div class="col-sm-2 input-group input-group-sm">
                        <select id="idtahun" class="form-control" name="idtahun" required>
                            <option value="">--Pilih periode--</option>
                            {{$periodeaktif = false}}
                            @foreach($periode as $list)
                                @if(($waktu > $list->tanggal_mulai) && ($waktu < $list->tanggal_akhir))
                                    {{$periodeaktif = true}}
                                    <option value="{{ $list->id }}"> Pengabdian tahun {{$list->tahun}} |  {{$list->idprogram->program}}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- validator jalan dengan tanda dibawah 
                <div class="form-group{{ $errors->has('buka') ? ' has-error' : '' }}">
                    <label for="buka" class="col-md-4 control-label">Name</label>

                    <div class="col-sm-6 input-group input-group-sm">
                        <input id="buka" type="text" class="form-control" name="buka" required autofocus>
                                
                        @if ($errors->has('buka'))
                            <span class="help-block">
                                <strong>{{ $errors->first('buka') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                -->
                
                @if(($peneliti->sinta != '') && ($peneliti->status == 1) && ($peneliti->tanggungan == 0) && ($ketuaditerima < 1)  && ($member < 2) && ($periodeaktif))
                <div class="form-group row">
                    <div class="col-md-8 col-md-offset-4">
                        <button type="submit" class="btn btn-success pull-right">
                          <span class="ion ion-android-exit"></span>
                            LANJUTKAN
                        </button>
                    </div>
                </div>
                </form>
                @endif
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-body">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <strong>Daftar Usul Pengandian Baru</strong> <small class="label label-success">{{$total}}</small>
                    </div>
            
                    <div class="panel-body">
                        @if($total == 0)
                        <div>Belum Ada Usulan Baru..</div>
                        @else
                        <div class="box-header">
                            <i class="ion ion-paper-airplane"></i>
                            <h4 class="box-title">Periode: 2021:</h4>
                        </div>
            
                        <div class="box-body">
                            <ul class="todo-list" style="overflow-x: hidden">
                                @foreach ($proposal as $detail)
                                <li>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <span class="text text-blue">{{ $detail->judul }}</span>
                                            <br>
                                            <br>
                                            &nbsp;&nbsp;<span class="text text-green">{{$detail->program->program}} - {{$detail->skema->skema}}</span>
                                            <br>
                                            &nbsp;&nbsp;<span class="text text-red">Periode Usulan Tahun {{ $detail->periode->tahun}} Batch {{ $detail->periode->sesi}} | Tahun Pelaksanaan {{ $detail->thnkerja }} </span>
                                            <br>
                                            &nbsp;&nbsp;<span class="text text-dark">Bidang Fokus : </span> {{$detail->fokus->fokus}}&nbsp; &nbsp;- <small class="label label-primary">Ketua Pengusul</small>
                                            <br>
                                            &nbsp;&nbsp;<span class="text bg-green text-dark">&nbsp; {{$status[$detail->status]->jenis}} &nbsp;</span> 
                                             @if($detail->status == 4)
                                            <br>
                                            &nbsp;&nbsp;<span class="text bg-green text-dark">&nbsp; Dana Disetujui  Rp {{ format_uang($detail->dana)}} &nbsp;</span>                                           
                                            @endif
                                            @if ($minat)
                                            <span class="text bg-red text-dark">&nbsp; {{$minat}} Anggota Belum Menyetujui &nbsp;</span>
                                            @endif
                                            <br>
                                            <br>  
                                        </div>
                                        
                                        <div class="tools col-sm-12 pull-left">
                                            @if($detail->periode->tanggal_mulai == null )
                                                <span class="text bg-red text-dark">&nbsp;Waktu Untuk Upload Data Belum di Buka</span>
                                            @elseif($waktu < $detail->periode->tanggal_mulai )
                                                <span class="text text-dark">Waktu Untuk Upload Data di Buka Pada Tanggal</span> <span class="text bg-blue text-dark">&nbsp;{{$detail->periode->tanggal_mulai}}</span> - <span class="text bg-red text-dark">&nbsp;{{$detail->periode->tanggal_mulai}}</span>
                                            @else

                                                @if($waktu >= $detail->periode->tanggal_mulai && $waktu <= $detail->periode->tanggal_akhir )
                                                     <a onclick="bacaProposalRinci({{'2'.mt_rand(1,9).($detail->prosalid*2)}})" class="btn btn-app btn-sm" id="baca"><i class="ion ion-ios-book-outline text-blue"></i> Baca </a>
                                                        <a onclick="unduhProposal({{'2'.mt_rand(1,9).($detail->prosalid*2)}})" class="btn btn-app btn-sm" id="down"><i class="ion ion-ios-cloud-download-outline text-blue"></i> Unduh </a>
                                                    <a onclick="editProposal({{mt_rand(10,99).($detail->prosalid*2+29)}} )" class="btn btn-app btn-xs" id="edit"><i class="ion ion-edit text-red"></i> Validasi </a>


                                                @elseif($waktu > $detail->periode->tanggal_akhir)
                                                  
                                                        <a onclick="bacaProposalRinci({{'2'.mt_rand(1,9).($detail->prosalid*2)}})" class="btn btn-app btn-sm" id="baca"><i class="ion ion-ios-book-outline text-blue"></i> Baca </a>
                                                        <a onclick="unduhProposal({{'2'.mt_rand(1,9).($detail->prosalid*2)}})" class="btn btn-app btn-sm" id="down"><i class="ion ion-ios-cloud-download-outline text-blue"></i> Unduh </a>
                                                        <span class="text bg-red text-dark">&nbsp;Periode Upload Data Telah Habis {{$waktu}}{{$detail->periode->tanggal_mulai}}</span>

                                                   
                                                @endif
                                            @endif

                                        </div>
                                    </div>                
                                </li>
                                @endforeach
                                <br>
                                @foreach ($peserta as $detail)
                                <li>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <span class="text text-blue">{{ $detail->judul }}</span>
                                            <br>
                                            <br>
                                            &nbsp;&nbsp;<span class="text text-green">{{$detail->program->program}} - {{$detail->skema->skema}}</span>
                                            <br>
                                            &nbsp;&nbsp;<span class="text text-red">Periode Usulan Tahun {{ $detail->periode->tahun}} Batch {{ $detail->periode->sesi}} | Tahun Pelaksanaan {{ $detail->thnkerja }} </span>
                                            <br>
                                            &nbsp;&nbsp;<span class="text text-dark">Bidang Fokus : </span> {{$detail->fokus->fokus}} &nbsp; &nbsp;- <small class="label label-primary">Anggota Pengusul {{$detail->peran}}</small> 
                                            @if($detail->setuju == 0)
                                            <small class="label label-warning">Belum Disetujui</small>
                                            @elseif($detail->setuju == 1)
                                            <small class="label label-success">Disetujui</small>
                                            @else
                                            <small class="label label-danger">Tidak Setuju</small>
                                            @endif
                                            <br>
                                            &nbsp;&nbsp;<span class="text bg-green text-dark">&nbsp; {{$status[$detail->status]->jenis}} &nbsp;</span>
                                            <br>
                                            <br>
                                        </div>
                                        
                                        <div class="tools col-sm-12 pull-left">
                                            @if(!$detail->setuju)
                                            <a onclick="setujuiProposal({{mt_rand(1,9).($detail->prosalid+$peneliti->id*3)}})" class="btn btn-app btn-sm" id="baca"><i class="ion ion-ios-checkmark-outline text-blue"></i> Approve </a>
                                            @endif
                                            <a onclick="bacaProposal({{mt_rand(1,9).($detail->prosalid*9+$peneliti->id)}})" class="btn btn-app btn-sm" id="baca"><i class="ion ion-ios-book-outline text-blue"></i> Baca </a>
                                            @if($detail->setuju)
                                                <a onclick="unduhProposal({{'2'.mt_rand(1,9).($detail->prosalid*2)}})" class="btn btn-app btn-sm" id="down"><i class="ion ion-ios-cloud-download-outline text-blue"></i> Unduh </a>
                                            @endif
                                        </div>
                                    </div>                
                                </li>
                                @endforeach
                                <li></li>
                            </ul>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script type="text/javascript">

    function bacaProposalRinci(id) {
        window.location = "{{route('pengabdianng.resume', '')}}/"+btoa(id);
    }

    function unduhProposal(id) {
        window.location = "{{route('pengabdianng.unduh', '')}}/"+btoa(id)
    }

    function editProposal(id) {
        window.location = "{{route('validasipengabdian.show','')}}/"+btoa(id);
    }

    function hapusProposal(id) {
        swal({
            title: 'Anda Yakin?',
            text: "Apakah yakin proposal dari kegiatan ini akan dihapus?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#5bc0de',
            cancelButtonColor: '#f0ad4e',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then(function(isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        url  : "{{route('pengabdianng.destroy','')}}/"+id,
                        type : "POST",
                        data : {'_method' : 'DELETE', '_token' : $('input[name = "_token"]').val()},
                        success : function(data) {
                            swal(
                                'Selamat!',
                                'Data Berhasil Dihapus',
                                'success'
                            );
                            window.location = "{{route('pengabdianng.index')}}";
                        },
                        error : function() {
                            swal(
                                'Terjadi Kesalahan!',
                                'Data Gagal Dihapus',
                                'error'
                            );
                        }

                    });

                }
            }
        );

    }

    function setujuiProposal(id) {
        window.location = "{{route('pengabdianng.setuju','')}}/"+btoa(id);
    }

    function bacaProposal(id) {
        window.location = "{{route('pengabdianng.baca', '')}}/"+btoa(id);
    }

    
</script>
@endsection