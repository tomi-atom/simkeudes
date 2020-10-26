@extends('layouts.app')

@section('title')
    Dokumen Pelaksanaan Kegiatan
@endsection

@section('breadcrumb')
    @parent
    <li>Penggunaan Anggaran</li>
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading"><strong>Ungahan Dokumen</strong></div>
            <form action="{{ route('penggunaananggaran.update', $proposal->prosalid) }}" method="POST" class="form form-horizontal"  enctype="multipart/form-data" >
                {{ csrf_field() }} {{method_field('PATCH')}}

                @if($errors->first('kesalahan'))
                    <br>
                    <div class="row">
                        <div class="col col-sm-2">.</div>
                        <div class="alert alert-info col-sm-8"><b>{{{ $errors->first('kesalahan') }}}</b></div>
                    </div>
                @endif

            <div class="panel-body">
                <div class="panel panel-default">
                    <div class="panel-heading"><strong>Dokumen Penggunaan Anggaran: </strong></div>
            
                    <div class="panel-body">
                        <div class="box-header">
                            <i class="fa fa-upload"></i>
                            <h4 class="box-title">Unggah File Penggunaan Anggaran</h4>
                        </div>
            
                        <div class="box-body">
                            <div class="row">
                            <p class="margin" align="justify"><b>PENGGUNAAN ANGGARAN</b> <br><code>Dokumen Penggunaan Anggaran berupa file dokumen berbentuk PDF yang telah ditandatangani dengan ukuran (maks: 5 MB) sesuai panduan.</code></p>
                            
                            <div class="col-sm-12">
                                <input type="file" accept="application/pdf" name="upload" id="upload" class="form-control" required>
                                <b>Max. 5 MB</b>
                                <br> 
                                <br>
                                @if($proposal->upload)
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
          

                


        </div>
    </div>
</div>    

@endsection