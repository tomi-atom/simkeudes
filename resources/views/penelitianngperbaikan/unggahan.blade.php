@extends('layouts.app')

@section('title')
    Dokumen Pendukung Usulan
@endsection

@section('breadcrumb')
    @parent
    <li><a href="{{ route('penelitianng.index') }}">Penelitian</a></li>
    <li>Pengusul</li>
    <li>Validasi</li>
    <li>Unggah Proposal</li>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/sweetalert2/1.3.3/sweetalert2.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/sweetalert2/0.4.5/sweetalert2.css">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/sweetalert2/1.3.3/sweetalert2.min.js"></script>

@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading"><strong>Ungahan Dokumen</strong></div>
            <form action="{{ route('validasipenelitian.update', $proposal->id) }}" method="POST" class="form form-horizontal"  enctype="multipart/form-data" >
                {{ csrf_field() }} {{method_field('PATCH')}}

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
                            'Gagal mengunggah, ukuran dokumen pengesahan melebihi aturan..',
                            'error'
                        );
                    </script>
                @endif

            <div class="panel-body">
                <div class="panel panel-default">
                    <div class="panel-heading"><strong>Lembaran Pengesahan: </strong></div>
            
                    <div class="panel-body">
                        <div class="box-header">
                            <i class="fa fa-upload"></i>
                            <h4 class="box-title">Unggah Lembaran Pengesahan</h4>
                        </div>
            
                        <div class="box-body">
                            <div class="row">
                            <p class="margin" align="justify"><b>LEMBARAN PENGESAHAN</b> <br><code>Lembaran pengesahan berupa file dokumen berbentuk PDF yang telah ditandatangani dengan ukuran (maks: 500KB) sesuai panduan.</code></p>
                            
                            <div class="col-sm-12">
                                <input type="file" accept="application/pdf" name="filepengesahan" id="filepengesahan" class="form-control" required>
                                <b>Max. 500KB</b>
                                <br> 
                                <br>
                                @if($proposal->pengesahan)
                                <ul class="mailbox-attachments clearfix">
                                    <li>
                                        <span class="mailbox-attachment-icon"><i class="fa fa-file-pdf-o"></i></span>

                                        <div class="mailbox-attachment-info">
                                            <a href="#" class="mailbox-attachment-name"><i class="fa fa-paperclip"></i> {{$proposal->pengesahan}}</a>
                                            <span class="mailbox-attachment-size">
                                            1,245 KB
                                            <a href="#" class="btn btn-default btn-xs pull-right"><i class="fa fa-cloud-download"></i></a>
                                            </span>
                                        </div>
                                    </li>
                                </ul>
                                @endif
                            </div>
                            </div>
                        </div>
                    </div>
                </div> 

                <div class="panel panel-default">
                    <div class="panel-heading"><strong>Proposal Lengkap Usulan: </strong></div>
            
                    <div class="panel-body">
                        <div class="box-header">
                            <i class="fa fa-upload"></i>
                            <h4 class="box-title">Unggah Proposal Usulan</h4>
                        </div>
            
                        <div class="box-body">
                            <div class="row">
                            <p class="margin" align="justify"><b>PROPOSAL USULAN</b> <br><code>Proposal usulan lengkap berupa file dokumen berbentuk PDF yang telah dibuat berdasarka aturan yang telah ditetapkan dengan ukuran (maks: 5MB) sesuai panduan.</code></p>
                            
                            <div class="col-sm-12">
                                <input type="file" accept="application/pdf" name="fileproposal" id="fileproposal" class="form-control input-group input-group-sm" required>
                                Max. 5MB
                                <br>
                                @if($proposal->usulan)
                                <ul class="mailbox-attachments clearfix">
                                    <li>
                                        <span class="mailbox-attachment-icon"><i class="fa fa-file-pdf-o"></i></span>

                                        <div class="mailbox-attachment-info">
                                            <a href="#" class="mailbox-attachment-name"><i class="fa fa-paperclip"></i> {{$proposal->usulan}}</a>
                                            <span class="mailbox-attachment-size">
                                            1,245 KB
                                            <a href="#" class="btn btn-default btn-xs pull-right"><i class="fa fa-cloud-download"></i></a>
                                            </span>
                                        </div>
                                    </li>
                                </ul>
                                @endif
                            </div>
                            </div>
                        </div>
                    </div>
                </div> 

                <div class="form-group row">
                    <div class="col-md-8 col-md-offset-4">
                        <button type="submit" class="btn btn-primary pull-right">
                          <span class="ion ion-ios-cloud-upload-outline"></span>
                            UNGGAH
                        </button>
                    </div>
                </div>
            </div>
              
            </form>    
          

                

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
        </div>
    </div>
</div>    

@endsection