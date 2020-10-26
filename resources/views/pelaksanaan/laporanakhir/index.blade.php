@extends('layouts.app')

@section('title')
    Laporan Akhir
@endsection

@section('breadcrumb')
    @parent
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/sweetalert2/1.3.3/sweetalert2.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/sweetalert2/0.4.5/sweetalert2.css">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/sweetalert2/1.3.3/sweetalert2.min.js"></script>

@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading"><strong>H-INDEX: {{ $peneliti->hindex }}</strong> <div class="pull-right"><strong>USULAN BARU: {{ $total }}</strong></div></div>
            <div class="panel-body">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <strong>Laporan Akhir</strong> <small class="label label-success">{{$total}}</small>
                    </div>
                    @if($errors->first('error'))
                        <script type="text/javascript">

                            "use strict";
                            swal(
                                'Terjadi Kesalahan!',
                                'Data Tidak di Temukan',
                                'error'
                            );
                        </script>
                    @else
                    @endif
                    <div class="panel-body">
                        @if($total == 0)
                            <div>Belum Ada Penelitian Yang Disetujui..</div>
                        @else
                            <div class="box-header">
                                <i class="ion ion-paper-airplane"></i>
                                <h4 class="box-title">Periode: 2019 - Batch 1:</h4>
                            </div>

                            <div class="box-body">
                                <ul class="todo-list" style="overflow-x: hidden">
                                    @foreach ($proposal as $detail)
                                        <li>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    @if ($detail->jenis==1)
                                                        <small class="label bg-blue label-primary">Penelitian</small>
                                                        <span class="text text-blue">{{ $detail->judul }}</span>
                                                    @else
                                                        <small class="label bg-warning label-warning">Pengabdian</small>
                                                        <span class="text text-blue">{{ $detail->judul }}</span>
                                                    @endif
                                                        <br>
                                                        &nbsp;&nbsp;<span class="text text-green">{{$detail->program->program}} - {{$detail->skema->skema}}</span>
                                                        <br>
                                                        &nbsp;&nbsp;<span class="text text-red">Periode Usulan Tahun {{ $detail->periode->tahun}} Batch {{ $detail->periode->sesi}} | Tahun Pelaksanaan {{ $detail->thnkerja }} </span>
                                                        <br>
                                                        &nbsp;&nbsp;<span class="text text-dark">Bidang Fokus : </span> {{$detail->fokus->fokus}}&nbsp; &nbsp;- <small class="label label-primary">Ketua Pengusul</small>
                                                        <br>
                                                        @if ($detail->status == null)
                                                            &nbsp;&nbsp;<span class="text bg-red text-dark">&nbsp; Belum Submit&nbsp;</span>
                                                        @else
                                                            &nbsp;&nbsp;<span class="text bg-green text-dark">&nbsp; {{$status[$detail->status]->jenis}} &nbsp;</span>
                                                        @endif

                                                        @if ($minat)
                                                            <span class="text bg-red text-dark">&nbsp; {{$minat}} Anggota Belum Menyetujui &nbsp;</span>
                                                        @endif
                                                        <br>
                                                        <br>
                                                </div>

                                                <div class="tools col-sm-12 pull-left">
                                                    @if($periodeterbaru->tm_laporanakhir == null && $periodeterbaru->tm_laporanakhir == null)
                                                        <span class="text bg-red text-dark">&nbsp;Waktu Untuk Upload Data Belum di Buka</span>
                                                    @elseif($waktu < $periodeterbaru->tm_laporanakhir )
                                                        <span class="text text-dark">Waktu Untuk Upload Data di Buka Pada Tanggal</span> <span class="text bg-blue text-dark">&nbsp;{{$periodeterbaru->tm_laporanakhir}}</span> - <span class="text bg-red text-dark">&nbsp;{{$periodeterbaru->tm_laporanakhir}}</span>
                                                    @else

                                                        @if($waktu >= $periodeterbaru->tm_laporanakhir && $waktu <= $periodeterbaru->ta_laporanakhir )
                                                            @if($detail->aktif == 1 && $detail->upload == null )
                                                                <a href="{{ route('laporanakhir.edit',base64_encode(mt_rand(10,99).$detail->prosalid) )}}"  class="btn btn-app btn-sm" ><i class="ion ion-ios-cloud-upload-outline text-blue"></i> Upload </a>
                                                            @elseif ($detail->status > 0 && $detail->upload != null)
                                                                <a  href="{{ route('laporanakhir.show',base64_encode(mt_rand(10,99).$detail->prosalid) )}}" class="btn btn-app btn-sm" id="baca"><i class="ion ion-ios-book-outline text-blue"></i> Baca </a>
                                                                <a href="{{ route('laporanakhir.edit',base64_encode(mt_rand(10,99).$detail->prosalid) )}}" class="btn btn-app btn-xs" id="edit"><i class="ion ion-edit text-red"></i> Validasi </a>
                                                                <a onclick="hapusProposal({{mt_rand(10,99).($detail->prosalid*3)}} )" class="btn btn-app btn-sm" id="hapus"><i class="ion ion-ios-trash text-red"></i> Hapus </a>
                                                            @endif

                                                        @elseif($waktu > $periodeterbaru->ta_laporanakhir)
                                                            @if ($detail->status > 0 && $detail->upload != null)
                                                                <a  href="{{ route('laporanakhir.show',base64_encode(mt_rand(10,99).$detail->prosalid) )}}" class="btn btn-app btn-sm" id="baca"><i class="ion ion-ios-book-outline text-blue"></i> Baca </a>
                                                                <span class="text bg-red text-dark">&nbsp;Periode Upload Data Telah Habis</span>

                                                            @else
                                                                <br>
                                                                <span class="text bg-red text-dark">&nbsp;Periode Upload Data Telah Habis</span>
                                                            @endif
                                                        @endif
                                                    @endif

                                                </div>

                                            </div>
                                        </li>
                                    @endforeach
                                    <br>
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

 function hapusProposal(id) {
        if (confirm("Apakah yakin data dari kegiatan ini akan dihapus?")) {
            $.ajax({
                url  : "{{route('laporanakhir.destroy','')}}/"+id,
                type : "POST",
                data : {'_method' : 'DELETE', '_token' : $('input[name = "_token"]').val()},
                success : function(data) {
                    window.location = "{{route('laporanakhir.index')}}";
                },
                error : function() {
                    alert("Tidak dapat menghapus data");
                }

            });
        }
    }



    function upload(id) {
        window.location = "{{route('laporanakhir.edit', '')}}/"+btoa(id);
    }


</script>
@endsection