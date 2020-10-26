@extends('layouts.app')

@section('title')
    Identitas Pengusul
@endsection

@section('breadcrumb')
    @parent
    <li><a href="{{ route('pengabdian.index') }}">Pengabdian</a></li>
    <li>Pengusul</li>
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading"><strong>H-INDEX: {{ $peneliti->hindex }}</strong> <div class="pull-right"><strong>USULAN BARU</strong></div></div>
            
            <div class="panel-body">
                
                <div class="panel panel-default">
                    <div class="panel-body"><strong>Identitas Pengusul - Ketua </strong></div>
            
                    <div class="panel-footer">
                        <div class="row">
                            <div class="col-sm-2">
                                <label class="control-label col-sm-offset-2"> Nama</label>
                            </div>
                            <div class="col-sm-6">
                                <label class="control-label text-green">: {{ $peneliti->nama }}</label>
                            </div>
                        </div>
                        <p></p>
                        <div class="row">
                            <div class="col-sm-2">
                                <label class="control-label col-sm-offset-2">NIDN/NIDK</label>
                            </div>
                            <div class="col-sm-6">
                                <label class="control-label text-green">: {{ $peneliti->nidn }}</label>
                            </div>
                        </div>
                        <p></p>
                        <div class="row">
                            <div class="col-sm-2">
                                <label class="control-label col-sm-offset-2">Perguruan Tinggi</label>
                            </div>
                            <div class="col-sm-6">
                                <label class="control-label text-green">: {{ $peneliti->universitas->pt }}</label>
                            </div>
                        </div>
                        <p></p>
                        <div class="row">
                            <div class="col-sm-2">
                                <label class="control-label col-sm-offset-2">Program Studi</label>
                            </div>
                            <div class="col-sm-6">
                                <label class="control-label text-green">: {{ $peneliti->prodi->prodi }} - {{$peneliti->fakultas->fakultas}}</label>
                            </div>
                        </div>
                        <p></p>
                        <div class="row">
                            <div class="col-sm-2">
                                <label class="control-label col-sm-offset-2">ID Sinta</label>
                            </div>
                            <div class="col-sm-6">
                                <label class="control-label text-green">: {{ $peneliti->sinta }}</label>
                            </div>
                        </div>
                        <p></p>
                        <div class="row">
                            <div class="col-sm-2">
                                <label class="control-label col-sm-offset-2">Kualifikasi</label>
                            </div>
                            <div class="col-sm-6">
                                <label class="control-label text-green">: {{ $peneliti->pendidikan->pendidikan }} - ({{$peneliti->fungsional->fungsional}})</label>
                            </div>
                        </div>
                        <p></p>
                        <div class="row">
                            <div class="col-sm-2">
                                <label class="control-label col-sm-offset-2">Alamat Surel</label>
                            </div>
                            <div class="col-sm-6">
                                <label class="control-label text-dark">: <i>{{ $peneliti->email }}</i></label>
                            </div>
                        </div>
                    </div>
                </div>  
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-body">
                <div class="panel panel-default">
                    <div class="panel-heading"><strong>Program Pengabdian Kepada Masyarakat: {{ $peneliti->universitas->pt }}</strong></div>
            
                     <div class="panel-body">
                     <table class="table table-condensed">
                        <tbody {{ $no = 1 }}>

                            @foreach ($program as $data)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $data->program}}</td>
                                <td>

                                    <form method="POST" action="{{ route('pengabdian.proposal', '0'.$data->id) }}">
                                    {{ csrf_field() }} {{method_field('GET')}}
                                        <input type="hidden" name="tahun" id="tahun" value="{{ $thn }}">
                                        
                                        <button type="submit" class="btn btn-success pull-right"><span class="fa fa-angle-double-right fa-fw"></span> Lanjutkan</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                            <tr><td></td><td></td><td></td></tr>
                            
                        </tbody>                        
                     </table>

                    </div>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-body">
                <div class="panel panel-default">
                    <div class="panel-heading"><strong>Rekam Jejak</strong></div>
            
                     <div class="panel-body">
                     <table class="table table-condensed">
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Publikasi Artikel Jurnal Internasional <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="label label-danger">2</span></a></td>
                                <td>
                                    <form method="POST" action="#">
                                    {{ csrf_field() }} {{method_field('GET')}}
                                        <button type="submit" class="btn btn-primary pull-right"><span class="fa fa-plus fa-fw"></span> Tambah</button>
                                    </form>
                                </td>
                            </tr>
                             <tr>
                                <td>2</td>
                                <td>Publikasi Artikel Jurnal Nasional <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="label label-danger">1</span></a></td>
                                <td>
                                    <form method="POST" action="#">
                                    {{ csrf_field() }} {{method_field('GET')}}
                                        <button type="submit" class="btn btn-primary pull-right"><span class="fa fa-plus fa-fw"></span> Tambah</button>
                                    </form>
                                </td>
                            </tr>
                             <tr>
                                <td>3</td>
                                <td>Publikasi Artikel Prosiding</td>
                                <td>
                                    <form method="POST" action="#">
                                    {{ csrf_field() }} {{method_field('GET')}}
                                        <button type="submit" class="btn btn-primary pull-right"><span class="fa fa-plus fa-fw"></span> Tambah</button>
                                    </form>
                                </td>
                            </tr>
                             <tr>
                                <td>4</td>
                                <td>Kekayaan Intelektual</td>
                                <td>
                                    <form method="POST" action="#">
                                    {{ csrf_field() }} {{method_field('GET')}}
                                        <button type="submit" class="btn btn-primary pull-right"><span class="fa fa-plus fa-fw"></span> Tambah</button>
                                    </form>
                                </td>
                            </tr>
                             <tr>
                                <td>5</td>
                                <td>Buku</td>
                                <td>
                                    <form method="POST" action="#">
                                    {{ csrf_field() }} {{method_field('GET')}}
                                        <button type="submit" class="btn btn-primary pull-right"><span class="fa fa-plus fa-fw"></span> Tambah</button>
                                    </form>
                                </td>
                            </tr>
                            
                            <tr><td></td><td></td><td></td></tr>
                            
                        </tbody>                        
                     </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection