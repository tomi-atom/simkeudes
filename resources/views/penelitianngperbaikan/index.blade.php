@extends('layouts.app')

@section('title')
    Daftar Perbaikan Proposal
@endsection

@section('breadcrumb')
    @parent
    <li>Penelitian</li>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
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
            @elseif($errors->first('error0'))
                <script type="text/javascript">

                    "use strict";
                    swal(
                        'Terjadi Kesalahan!',
                        'Data Tidak Ditemukan',
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
           
        </div>

        <div class="panel panel-default">
            <div class="panel-body">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <strong>Daftar Perbaikan Proposal Penelitian</strong> <small class="label label-success">{{$total}}</small>
                    </div>

                    <div class="panel-body">
                        @if($total == 0)
                        <div>Belum Ada Proposal disetujui..</div>
                        @else
                        <div class="box-header">
                            <i class="ion ion-paper-airplane"></i>
                            <h4 class="box-title">Periode: 2020:</h4>
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
                                            <a onclick="bacaProposalRinci({{'2'.mt_rand(1,9).($detail->prosalid*2)}})" class="btn btn-app btn-sm" id="baca"><i class="ion ion-ios-book-outline text-blue"></i> Baca </a>
                                            <a onclick="unduhProposal({{'2'.mt_rand(1,9).($detail->prosalid*2)}})" class="btn btn-app btn-sm" id="down"><i class="ion ion-ios-cloud-download-outline text-blue"></i> Unduh </a>
                                            <a onclick="editProposal({{mt_rand(10,99).($detail->prosalid*2+29)}} )" class="btn btn-app btn-xs" id="edit"><i class="ion ion-edit text-red"></i> Perbaikan </a>
                                           <!-- <a onclick="hapusProposal({{mt_rand(10,99).($detail->prosalid*3)}} )" class="btn btn-app btn-sm" id="hapus"><i class="ion ion-ios-trash text-red"></i> Hapus </a>-->
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
        window.location = "{{route('penelitianng.resume', '')}}/"+btoa(id);
    }

    function unduhProposal(id) {
        window.location = "{{route('penelitianng.unduh', '')}}/"+btoa(id)
    }

    function editProposal(id) {
        window.location = "{{route('validasipenelitian.show','')}}/"+btoa(id);
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
                        url  : "{{route('penelitianng.destroy','')}}/"+id,
                        type : "POST",
                        data : {'_method' : 'DELETE', '_token' : $('input[name = "_token"]').val()},
                        success : function(data) {
                            swal(
                                'Selamat!',
                                'Data Berhasil Dihapus',
                                'success'
                            );
                            window.location = "{{route('penelitianng.index')}}";
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
        window.location = "{{route('penelitianng.setuju','')}}/"+btoa(id);
    }

    function bacaProposal(id) {
        window.location = "{{route('penelitianng.baca', '')}}/"+btoa(id);
    }


</script>
@endsection