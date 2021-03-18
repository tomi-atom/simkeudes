@extends('layouts.app')

@section('title')
    Luaran Penelitian Sebelumnya
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
                        <strong>Luaran Penelitian Sebelumnya</strong> <small class="label label-success"></small>
                    </div>

                    <div class="panel-body">
                        @if($proposal)
                        <div class="box-header">
                            <i class="ion ion-paper-airplane"></i>
                            <span>{{$peneliti->nama}}</span>
                        </div>

                        <div class="box-body">
                            <ul class="todo-list" style="overflow-x: hidden">
                                
                                <li>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <span class="text text-blue">{{ $proposal->judul }}</span>
                                            <br>
                                            <br>
                                            &nbsp;&nbsp;<span class="text text-green">{{$proposal->program->program}} - {{$proposal->skema->skema}}</span>
                                            <br>
                                            &nbsp;&nbsp;<span class="text text-red">Periode Usulan Tahun {{ $proposal->periode->tahun}} Batch {{ $proposal->periode->sesi}} | Tahun Pelaksanaan {{ $proposal->thnkerja }} </span>
                                            <br>
                                            &nbsp;&nbsp;<span class="text text-dark">Bidang Fokus : </span> {{$proposal->fokus->fokus}}&nbsp; &nbsp;- <small class="label label-primary">Ketua Pengusul</small>
                                            <br>
                                            &nbsp;&nbsp;<span class="text bg-green text-dark">&nbsp; {{$status[$proposal->status]->jenis}} &nbsp;</span>
                                             @if($proposal->status == 4)
                                            <br>
                                            &nbsp;&nbsp;<span class="text bg-green text-dark">&nbsp; Dana Disetujui  Rp {{ format_uang($proposal->dana)}} &nbsp;</span>                                           
                                            @endif
                                            @if ($minat)
                                            <span class="text bg-red text-dark">&nbsp; {{$minat}} Anggota Belum Menyetujui &nbsp;</span>
                                            @endif
                                            <br>
                                             @if ($luaranlainnya)
                                             <small class="label label-primary">Luaran Lainnya </small>:<small class="label label-success">sudah</small><br>
                                        
                                            @else
                                             <small class="label label-primary">Luaran Lainnya </small>:<small class="label label-danger">belum </small><br>
                                            @endif
                                            
                                            @if ($luaranwajib)
                                            <small class="label label-primary">Luaran Wajib </small>:<small class="label label-success">sudah</small><br>
                                        
                                            @else
                                             <small class="label label-primary">Luaran Wajib </small>:<small class="label label-danger">belum </small><br>
                                           @endif
                    
                                        
                                        @if ($luarantambahan)
                                             <small class="label label-primary">Luaran Tambahan </small>:<small class="label label-success">sudah</small><br>
                                        
                                        @else
                                             <small class="label label-primary">Luaran Tambahan </small>:<small class="label label-danger">belum </small><br>
                                        @endif   
                    
                                        
                                            <br>
                                        </div>

                                        <div class="tools col-sm-12 pull-left">
                                            <a onclick="bacaProposalRinci({{mt_rand(10, 99).($proposal->prosalid)}})" class="btn btn-app btn-sm" id="baca"><i class="ion ion-ios-book-outline text-blue"></i> Baca Luaran Sebelumnya </a>
                                           
                                        </div>
                                    </div>
                                </li>
                             
                                <br>
                              
                                <li></li>
                                
                            </ul>
                        </div>
                        @else
                        <div>Belum Ada Proposal disetujui..</div>
                        <script type="text/javascript">
        
                            "use strict";
                            swal(
                                'Luaran Penelitian Tidak Ada!',
                                'Peneliti Belum Mempunyai Proposal di setujui sebelumnya',
                                'info'
                            );
                        </script>
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
        window.location = "{{route('penelitianr.resumeluaranlama', '')}}/"+btoa(id);
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