@extends('layouts.app')

@section('title')
	Dashboard
@endsection

@section('breadcrumb')
	@parent
	<li>Dashboard</li>
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/sweetalert2/1.3.3/sweetalert2.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/sweetalert2/0.4.5/sweetalert2.css">
	<script type="text/javascript" src="https://cdn.jsdelivr.net/sweetalert2/1.3.3/sweetalert2.min.js"></script>
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading"><strong>Selamat Datang</strong> <div class="pull-right"><strong>Anda login sebagai Dosen</strong></div></div>
            	@if($errors->first('success'))
						<script type="text/javascript">
							"use strict";
							swal(
									'Selamat!',
									'Password Berhasil Diperbaharui',
									'success'
							);
						</script>
					@elseif($errors->first('error'))
						<script type="text/javascript">

							"use strict";
							swal(
									'Terjadi Kesalahan!',
									'Password Gagal Diperbaharui',
									'error'
							);
						</script>
					@endif

            <div class="panel-body">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <strong>Template</strong> <small class="label label-success"></small>
                    </div>
                  
                  
                    <div class="panel-body">
                     
                            <div class="box-header">
                                <i class="ion ion-paper-airplane"></i>
                                <h4 class="box-title">Template Laporan ::</h4>
                            </div>

                            <div class="box-body">
                                <ul class="todo-list" style="overflow-x: hidden">
                                    <a  href="{{url('/public/docs/template/sistematikapenelitian2021.pdf')}}" type="application/pdf"  class="btn btn-app btn-sm" id="baca"><i class="ion ion-ios-cloud-download-outline text-blue"></i> Sistematika Penelitian </a>
                                     <a   href="{{url('/public/docs/template/sistematikapengabdian.pdf')}}" type="application/pdf" class="btn btn-app btn-sm" id="baca"><i class="ion ion-ios-cloud-download-outline text-blue"></i> Sistematika Pengabdian </a>
                                      <a  href="{{url('/public/docs/template/templateluaran.docx')}}" type="application/docx" class="btn btn-app btn-sm" id="baca"><i class="ion ion-ios-cloud-download-outline text-blue"></i> Contoh Format Luaran Lainnya 1 </a>
                                       <a    href="{{url('/public/docs/template/templateluaranlain.docx')}}" type="application/docx" class="btn btn-app btn-sm" id="baca"><i class="ion ion-ios-cloud-download-outline text-blue"></i> Contoh Format Luaran Lainnya 2 </a>
                                </ul>
                            </div>
                      
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

