@extends('layouts.app')

@section('title')
    @if($penelitian->status == 4)
    Perbaikan Proposal Penelitian
    @else
    Ringkasan dan Validasi Usulan 
    @endif
@endsection

@section('breadcrumb')
    @parent
    <li><a href="{{ route('perbaikanpenelitianng.index') }}">Penelitian</a></li>
    <li>Pengusul</li>
    <li>Validasi</li>
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
                    <div class="panel-heading"><strong>Periode: 2020</strong></div>
                    @if($errors->first('success'))
                        <script type="text/javascript">
                            "use strict";
                            swal(
                                'Selamat!',
                                'Data Berhasil Diperbaharui',
                                'success'
                            );
                        </script>
                    @elseif($errors->first('error'))
                        <script type="text/javascript">

                            "use strict";
                            swal(
                                'Terjadi Kesalahan!',
                                'Data Gagal Diperbaharui',
                                'error'
                            );
                        </script>
                    @else
                    @endif
                    <div class="panel-body">
                        <div class="">
                            <div class="box-header">
                                <i class="ion ion-clipboard"></i>
                                <h4 class="box-title">Pengusul: {{$dsn->nama}}</h4>
                            </div>
                            @if($penelitian->status == 4)
                            Halaman ini merupakan lembaran perbaikan untuk proposal yang telah disetujui, setiap item pemeriksaan harus memiliki status "Lengkap" . Silakan lakukan Perbaikan atau Pelengkapan untuk setiap item pemeriksaan yang bermasalah.
                            
                            @else
                            Halaman ini merupakan lembaran pemeriksaan sebelum melakukan validasi akhir, setiap item pemeriksaan harus memiliki status "Lengkap" agar dapat melakukan Validasi. Jika terdapat bahagian item pemeriksaan yang bertatus "Belum Lengkap", maka validasi akhir tidak dapat dilakukan. Silakan lakukan Perbaikan atau Pelengkapan untuk setiap item pemeriksaan yang bermasalah.
                            @endif
                            <hr>
                            <table class="table table-bordered">
                                <thead>
                                    
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-center"><b>No.</b></td>
                                        <td class="text-center" colspan="6"><b>Item Pemeriksaan</b></td>
                                        <td class="text-center" colspan="2"><b>Status</b></td>
                                        <td class="text-center" colspan="3"><b>Aksi</b></td>
                                      
                                    </tr> 
                                    <tr>
                                        <td class="text-center">A</td>
                                        <td class="text-left" colspan="6">USULAN PROPSAL</td>
                                        @if($err == 0)
                                        <td class="text-center" colspan="2"><span class="label label-success">Lengkap</span></td>
                                        <td class="text-center" colspan="2">
                                        <a onclick="editProposal({{mt_rand(10,99).($proposal->id+13)}})" class="btn btn-sm btn-default btn-flat center"><i class="fa fa-edit"></i> Perbaharui</a>
                                        </td>
                                        @elseif($err < 99)
                                        <td class="text-center" colspan="2"><span class="label label-warning">Belum Lengkap</span></td>
                                        <td class="text-center" colspan="2">
                                        <a onclick="editProposal({{mt_rand(10,99).($proposal->id+13)}})" class="btn btn-sm btn-default btn-flat center"><i class="fa fa-edit"></i> Perbaharui</a>
                                        </td>
                                        @else
                                        <td class="text-center" colspan="2"><span class="label label-danger">Belum Mengerjakan</span></td>
                                        <td class="text-center" colspan="2">
                                        <a onclick="bukaProposal({{mt_rand(10,99).($proposal->id+13)}})" class="btn btn-sm btn-default btn-flat center"><i class="fa fa-pencil"></i> Lengkapi</a>
                                        </td>
                                        @endif
                                        <td data-toggle="collapse" data-target="#accordionproposal" class="clickable text-center">
                                        <a onclick="#" class="btn btn-sm btn-info btn-flat center"><i class="fa  fa-folder-open-o"></i> Rincikan</a>  
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="12">
                                        <tbody id="accordionproposal" class="collapse table-bordered">
                                            <tr>
                                                <td class="text-right">1</td>
                                                <td class="text-left"   colspan="6">&nbsp;&nbsp;&nbsp;Kesamaan Judul</td>
                                                @if(!($judul-1))
                                                <td class="text-center" colspan="2">
                                                    <div class="progress progress-xs">
                                                      <div class="progress-bar progress-bar-success" style="width: 0%"></div>
                                                    </div>
                                                </td>
                                                <td class="text-center" colspan="2">0%</td>
                                                <td class="text-center"><span class="label label-success">Terpenuhi</span></td>
                                                @else
                                                <td class="text-center" colspan="2">
                                                    <div class="progress progress-xs">
                                                      <div class="progress-bar progress-bar-danger" style="width: 100%"></div>
                                                    </div>
                                                </td>
                                                <td class="text-center" colspan="2">100%</td>
                                                <td class="text-center"><span class="label label-danger">Bermasalah</span></td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <td class="text-right">2</td>
                                                <td class="text-left"   colspan="6">&nbsp;&nbsp;&nbsp;TKT</td>
                                                @if($mtkt < 100)
                                                <td class="text-center" colspan="2">
                                                    <div class="progress progress-xs">
                                                      <div class="progress-bar progress-bar-danger" style="width: {{$mtkt}}%"></div>
                                                    </div>
                                                </td>
                                                <td class="text-center" colspan="2">{{$mtkt}}%</td>
                                                <td class="text-center"><span class="label label-danger">Bermasalah</span></td>
                                                @else
                                                <td class="text-center" colspan="2">
                                                    <div class="progress progress-xs">
                                                      <div class="progress-bar progress-bar-success" style="width: 100%"></div>
                                                    </div>
                                                </td>
                                                <td class="text-center" colspan="2">100%</td>
                                                <td class="text-center"><span class="label label-success">Terpenuhi</span></td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <td class="text-right">3</td>
                                                <td class="text-left"   colspan="6">&nbsp;&nbsp;&nbsp;Program Penelitian: {{$proposal->program->program}}</td>
                                                <td class="text-center" colspan="2">
                                                    <div class="progress progress-xs">
                                                        <div class="progress-bar progress-bar-success" style="width: 2%"></div>
                                                    </div>
                                                </td>
                                                <td class="text-center" colspan="2">2%</td>
                                                <td class="text-center"><span class="label label-success">Terpenuhi</span></td>
                                            </tr>
                                            <tr>
                                                <td class="text-right">4</td>
                                                <td class="text-left"   colspan="6">&nbsp;&nbsp;&nbsp;Skema: {{ $proposal->skema->skema}}</td>
                                                <td class="text-center" colspan="2">
                                                    <div class="progress progress-xs">
                                                        <div class="progress-bar progress-bar-success" style="width: 30%"></div>
                                                    </div>
                                                </td>
                                                <td class="text-center" colspan="2">30%</td>
                                                <td class="text-center"><span class="label label-success">Terpenuhi</span></td>
                                            </tr>
                                            <tr>
                                                <td class="text-right">5</td>
                                                <td class="text-left"   colspan="6">&nbsp;&nbsp;&nbsp;Rumpun Bidang Ilmu: {{$proposal->rumpun->ilmu3}}</td>
                                                <td class="text-center" colspan="2">
                                                    <div class="progress progress-xs">
                                                        <div class="progress-bar progress-bar-success" style="width: 50%"></div>
                                                    </div>
                                                </td>
                                                <td class="text-center" colspan="2">50%</td>
                                                <td class="text-center"><span class="label label-success">Terpenuhi</span></td>
                                            </tr>
                                            <tr>
                                                <td class="text-right">6</td>
                                                <td class="text-left"   colspan="6">&nbsp;&nbsp;&nbsp;Bidang Fokus: {{$proposal->fokus->fokus}}</td>
                                                <td class="text-center" colspan="2">
                                                    <div class="progress progress-xs">
                                                        <div class="progress-bar progress-bar-success" style="width: 35%"></div>
                                                    </div>
                                                </td>
                                                <td class="text-center" colspan="2">35%</td>
                                                <td class="text-center"><span class="label label-success">Terpenuhi</span></td>
                                            </tr>
                                            <tr>
                                                <td class="text-right">7</td>
                                                <td class="text-left"   colspan="6">&nbsp;&nbsp;&nbsp;Tema Penelitian: {{$proposal->tema->tema}}</td>
                                                <td class="text-center" colspan="2">
                                                    <div class="progress progress-xs">
                                                        <div class="progress-bar progress-bar-success" style="width: 35%"></div>
                                                    </div>
                                                </td>
                                                <td class="text-center" colspan="2">35%</td>
                                                <td class="text-center"><span class="label label-success">Terpenuhi</span></td>
                                            </tr>
                                            <tr>
                                                <td class="text-right">8</td>
                                                <td class="text-left"   colspan="6">&nbsp;&nbsp;&nbsp;Topik Penelitian: {{$proposal->topik->topik}}</td>
                                                <td class="text-center" colspan="2">
                                                    <div class="progress progress-xs">
                                                        <div class="progress-bar progress-bar-success" style="width: 35%"></div>
                                                    </div>
                                                </td>
                                                <td class="text-center" colspan="2">35%</td>
                                                <td class="text-center"><span class="label label-success">Terpenuhi</span></td>
                                            </tr>
                                            <tr>
                                                <td colspan="12"></td>
                                            </tr>
                                        </tbody>
                                       </td>
                                    </tr>
                                    <tr>
                                        <td colspan="12"></td>
                                    </tr>
                               
                                    <tr>
                                        <td class="text-center">B</td>
                                        <td class="text-left" colspan="6">USULAN ANGGOTA</td>
                                        @if($err2 == 0)
                                        <td class="text-center" colspan="2"><span class="label label-success">Lengkap</span></td>
                                        <td class="text-center" colspan="2">
                                        <a onclick="editAnggota({{mt_rand(10,99).($proposal->id*2)}})" class="btn btn-sm btn-default btn-flat center"><i class="fa fa-edit"></i> Perbaharui</a>
                                        </td>
                                        @elseif($err2 < 99)
                                        <td class="text-center" colspan="2"><span class="label label-warning">Belum Lengkap</span></td>
                                        <td class="text-center" colspan="2">
                                        <a onclick="editAnggota({{mt_rand(10,99).($proposal->id*2)}})" class="btn btn-sm btn-default btn-flat center"><i class="fa fa-edit"></i> Perbaharui</a>
                                        </td>
                                        @else
                                        <td class="text-center" colspan="2"><span class="label label-danger">Belum Mengerjakan</span></td>
                                        <td class="text-center" colspan="2">
                                        <a href="{{route('perbaikanpenelitianng.anggota.index', base64_encode($proposal->id.'/'.mt_rand(10,99).(9 + $proposal->idskema)))}}" class="btn btn-sm btn-default btn-flat center"><i class="fa fa-pencil"></i> Lengkapi</a>
                                        </td>
                                        @endif

                                        <td data-toggle="collapse" data-target="#accordionanggota" class="clickable text-center">
                                        <a onclick="#" class="btn btn-sm btn-info btn-flat center"><i class="fa  fa-folder-open-o"></i> Rincikan</a>  
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="12">
                                        <tbody id="accordionanggota" class="collapse table-bordered">
                                            <tr>
                                                <td class="text-right">1</td>
                                                <td class="text-left"   colspan="6">&nbsp;&nbsp;&nbsp;Jumlah Anggota: {{count($tim)}}</td>

                                                @if((count($tim) - $ttim) >= $skema->minpeserta)
                                                <td class="text-center" colspan="2">
                                                    <div class="progress progress-xs">
                                                        <div class="progress-bar progress-bar-success" style="width: 100%"></div>
                                                    </div>
                                                </td>
                                                <td class="text-center" colspan="2">100%</td>
                                                <td class="text-center"><span class="label label-success">Terpenuhi</span></td>
                                                @else
                                                <td class="text-center" colspan="2">
                                                    <div class="progress progress-xs">
                                                        <div class="progress-bar progress-bar-danger" style="width: {{round((count($tim) - $ttim) / $skema->minpeserta * 100)}}%"></div>
                                                    </div>
                                                </td>
                                                <td class="text-center" colspan="2">{{round((count($tim) - $ttim) / $skema->minpeserta * 100)}}%</td>
                                                <td class="text-center"><span class="label label-danger">Tidak Terpenuhi</span></td>
                                                @endif
                                            </tr {{$no=1}}>
                                            @foreach($tim as $list)
                                            <tr>
                                                <td class="text-right">{{++$no}}</td>
                                                <td class="text-left"  colspan="6">&nbsp;&nbsp;&nbsp;{{$list->nama}}</td>
                                                @if($list->setuju == 0)
                                                <td class="text-center" colspan="2">
                                                    <div class="progress progress-xs">
                                                        <div class="progress-bar progress-bar-danger" style="width: 50%"></div>
                                                    </div>
                                                </td>
                                                <td class="text-center" colspan="2">50%</td>
                                                <td class="text-center"><span class="label label-danger">Belum Setuju</span></td>
                                                @elseif($list->setuju == 1)
                                                <td class="text-center" colspan="2">
                                                    <div class="progress progress-xs">
                                                        <div class="progress-bar progress-bar-success" style="width: 100%"></div>
                                                    </div>
                                                </td>
                                                <td class="text-center" colspan="2">100%</td>
                                                <td class="text-center"><span class="label label-success">Setuju</span></td>
                                                @else
                                                <td class="text-center" colspan="2">
                                                    <div class="progress progress-xs">
                                                        <div class="progress-bar progress-bar-danger" style="width: 0%"></div>
                                                    </div>
                                                </td>
                                                <td class="text-center" colspan="2">0%</td>
                                                <td class="text-center"><span class="label label-danger">Tidak Setuju</span></td>
                                                @endif
                                            </tr>
                                            @endforeach
            
                                            <tr>
                                                <td colspan="12"></td>
                                            </tr>
                                        </tbody>
                                       </td>
                                    </tr>
                                    <tr>
                                        <td colspan="12"></td>
                                    </tr>

                                    <tr>
                                        <td class="text-center">C</td>
                                        <td class="text-left" colspan="6">SUBSTANSI USULAN</td>
                                        @if($err3 == 0)
                                        <td class="text-center" colspan="2"><span class="label label-success">Lengkap</span></td>
                                        <td class="text-center" colspan="2">
                                        <a onclick="editSubtansi({{$proposal->id+127}})" class="btn btn-sm btn-default btn-flat center"><i class="fa fa-edit"></i> Perbaharui</a>
                                        </td>
                                        @elseif($err3 < 99)
                                        <td class="text-center" colspan="2"><span class="label label-warning">Belum Lengkap</span></td>
                                        <td class="text-center" colspan="2">
                                        <a onclick="editSubtansi({{$proposal->id+127}})" class="btn btn-sm btn-default btn-flat center"><i class="fa fa-edit"></i> Perbaharui</a>
                                        </td>
                                        @else
                                        <td class="text-center" colspan="2"><span class="label label-danger">Belum Mengerjakan</span></td>
                                        <td class="text-center" colspan="2">
                                        <a onclick="bukaSubtansi({{$proposal->id+127}})" class="btn btn-sm btn-default btn-flat center"><i class="fa fa-pencil"></i> Lengkapi</a>
                                        </td>
                                        @endif
                                        <td data-toggle="collapse" data-target="#accordionsubtansi" class="clickable text-center">
                                        <a onclick="#" class="btn btn-sm btn-info btn-flat center"><i class="fa  fa-folder-open-o"></i> Rincikan</a>  
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="12">
                                        <tbody id="accordionsubtansi" class="collapse table-bordered">
                                            <tr>
                                                <td class="text-right">1</td>
                                                <td class="text-left"   colspan="6">&nbsp;&nbsp;&nbsp;Ringkasan</td>
                                                <td class="text-center" colspan="2">
                                                    <div class="progress progress-xs">
                                                        <div class="progress-bar progress-bar-success" style="width: 45%"></div>
                                                    </div>
                                                </td>
                                                <td class="text-center" colspan="2">45%</td>
                                                <td class="text-center"><span class="label label-success">Terpenuhi</span></td>
                                            </tr>
                                            <tr>
                                                <td class="text-right">2</td>
                                                <td class="text-left"   colspan="6">&nbsp;&nbsp;&nbsp;Kata Kunci</td>
                                                <td class="text-center" colspan="2">
                                                    <div class="progress progress-xs">
                                                        <div class="progress-bar progress-bar-success" style="width: 50%"></div>
                                                    </div>
                                                </td>
                                                <td class="text-center" colspan="2">40%</td>
                                                <td class="text-center"><span class="label label-success">Terpenuhi</span></td>
                                            </tr>
                                            <tr>
                                                <td class="text-right">3</td>
                                                <td class="text-left"   colspan="6">&nbsp;&nbsp;&nbsp;Latar Belakang</td>
                                                <td class="text-center" colspan="2">
                                                    <div class="progress progress-xs">
                                                        <div class="progress-bar progress-bar-success" style="width: 85%"></div>
                                                    </div>
                                                </td>
                                                <td class="text-center" colspan="2">85%</td>
                                                <td class="text-center"><span class="label label-success">Terpenuhi</span></td>
                                            </tr>
                                            <tr>
                                                <td class="text-right">4</td>
                                                <td class="text-left"   colspan="6">&nbsp;&nbsp;&nbsp;Tinjauan Pustaka</td>
                                                <td class="text-center" colspan="2">
                                                    <div class="progress progress-xs">
                                                        <div class="progress-bar progress-bar-success" style="width: 90%"></div>
                                                    </div>
                                                </td>
                                                <td class="text-center" colspan="2">90%</td>
                                                <td class="text-center"><span class="label label-success">Terpenuhi</span></td>
                                            </tr>
                                            <tr>
                                                <td class="text-right">5</td>
                                                <td class="text-left"   colspan="6">&nbsp;&nbsp;&nbsp;Metode</td>
                                                <td class="text-center" colspan="2">
                                                    <div class="progress progress-xs">
                                                        <div class="progress-bar progress-bar-success" style="width: 82%"></div>
                                                    </div>
                                                </td>
                                                <td class="text-center" colspan="2">82%</td>
                                                <td class="text-center"><span class="label label-success">Terpenuhi</span></td>
                                            </tr>
                                            <tr>
                                                <td class="text-right">6</td>
                                                <td class="text-left"   colspan="6">&nbsp;&nbsp;&nbsp;Daftar Pustaka</td>
                                                <td class="text-center" colspan="2">
                                                    <div class="progress progress-xs">
                                                        <div class="progress-bar progress-bar-success" style="width: 100%"></div>
                                                    </div>
                                                </td>
                                                <td class="text-center" colspan="2">100%</td>
                                                <td class="text-center"><span class="label label-success">Terpenuhi</span></td>
                                            </tr>
                                    
                                            <tr>
                                                <td colspan="12"></td>
                                            </tr>
                                        </tbody>
                                       </td>
                                    </tr>
                                    <tr>
                                        <td colspan="12"></td>
                                    </tr>

                                    <tr>
                                        <td class="text-center">D</td>
                                        <td class="text-left" colspan="6">USULAN LUARAN</td>
                                        @if($err4 == 0)
                                        <td class="text-center" colspan="2"><span class="label label-success">Lengkap</span></td>
                                        <td class="text-center" colspan="2">
                                        <a onclick="editLuaran({{mt_rand(10,99).($proposal->id*2)}})" class="btn btn-sm btn-default btn-flat center"><i class="fa fa-edit"></i> Perbaharui</a>
                                        </td>
                                        @elseif($err4 < 99)
                                        <td class="text-center" colspan="2"><span class="label label-warning">Belum Lengkap</span></td>
                                        <td class="text-center" colspan="2">
                                        <a onclick="editLuaran({{mt_rand(10,99).($proposal->id*2)}})" class="btn btn-sm btn-default btn-flat center"><i class="fa fa-edit"></i> Perbaharui</a>
                                        </td>
                                        @else
                                        <td class="text-center" colspan="2"><span class="label label-danger">Belum Mengerjakan</span></td>
                                        <td class="text-center" colspan="2">
                                        <a href="{{route('perbaikanpenelitianng.luaran.index', base64_encode(mt_rand(1,9).($proposal->id +$dsn->id)))}}" class="btn btn-sm btn-default btn-flat center"><i class="fa fa-pencil"></i> Lengkapi</a>
                                        </td>
                                        @endif
                                        <td data-toggle="collapse" data-target="#accordionluaran" class="clickable text-center">
                                        <a onclick="#" class="btn btn-sm btn-info btn-flat center"><i class="fa  fa-folder-open-o"></i> Rincikan</a>  
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="12">
                                        <tbody id="accordionluaran" class="collapse table-bordered">
                                            <tr>
                                                <td class="text-right">1</td>
                                                <td class="text-left"   colspan="6">&nbsp;&nbsp;&nbsp;Luaran: {{count($luar)}}</td>
                                                @if($wajib < count($data))
                                                <td class="text-center" colspan="2">
                                                    <div class="progress progress-xs">
                                                        <div class="progress-bar progress-bar-danger" style="width: {{round($wajib/count($data)*100)}}%"></div>
                                                    </div>
                                                </td>
                                                <td class="text-center" colspan="2">{{round($wajib/count($data)*100)}}%</td>
                                                <td class="text-center"><span class="label label-danger">Tidak Terpenuhi</span></td>
                                                @else
                                                <td class="text-center" colspan="2">
                                                    <div class="progress progress-xs">
                                                        <div class="progress-bar progress-bar-success" style="width: 100%"></div>
                                                    </div>
                                                </td>
                                                <td class="text-center" colspan="2">100%</td>
                                                <td class="text-center"><span class="label label-success">Terpenuhi</span></td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <td class="text-right">2</td>
                                                <td class="text-left"   colspan="6">&nbsp;&nbsp;&nbsp;Luaran Wajib: {{$wajib}}</td>
                                                @if($wajib < count($data))
                                                <td class="text-center" colspan="2">
                                                    <div class="progress progress-xs">
                                                        <div class="progress-bar progress-bar-danger" style="width: {{round($wajib/count($data)*100)}}%"></div>
                                                    </div>
                                                </td>
                                                <td class="text-center" colspan="2">{{round($wajib/count($data)*100)}}%</td>
                                                <td class="text-center"><span class="label label-danger">Tidak Terpenuhi</span></td>
                                                @else
                                                <td class="text-center" colspan="2">
                                                    <div class="progress progress-xs">
                                                        <div class="progress-bar progress-bar-success" style="width: 100%"></div>
                                                    </div>
                                                </td>
                                                <td class="text-center" colspan="2">100%</td>
                                                <td class="text-center"><span class="label label-success">Terpenuhi</span></td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <td class="text-right">3</td>
                                                <td class="text-left"   colspan="6">&nbsp;&nbsp;&nbsp;Luaran Tambahan: {{count($luar) - $wajib}}</td>
                                                <td class="text-center" colspan="2">
                                                    <div class="progress progress-xs">
                                                        <div class="progress-bar progress-bar-success" style="width: {{round((count($luar) - $wajib)*100)}}%"></div>
                                                    </div>
                                                </td>
                                                <td class="text-center" colspan="2">{{round((count($luar) - $wajib)*100)}}%</td>
                                                <td class="text-center"><span class="label label-success">Terpenuhi</span></td>
                                            </tr>
      
                                            <tr>
                                                <td colspan="12"></td>
                                            </tr>
                                        </tbody>
                                       </td>
                                    </tr>
                                    <tr>
                                        <td colspan="12"></td>
                                    </tr>

                                    <tr>
                                        <td class="text-center">E</td>
                                        <td class="text-left" colspan="6">USULAN ANGGARAN</td>
                                        @if($err5 == 0)
                                        <td class="text-center" colspan="2"><span class="label label-success">Lengkap</span></td>
                                        <td class="text-center" colspan="2">
                                        <a onclick="editAnggaran({{mt_rand(10,99).($proposal->id*2)}})" class="btn btn-sm btn-default btn-flat center"><i class="fa fa-edit"></i> Perbaharui</a>
                                        </td>
                                        @elseif($err5 < 99)
                                        <td class="text-center" colspan="2"><span class="label label-warning">Belum Lengkap</span></td>
                                        <td class="text-center" colspan="2">
                                        <a onclick="editAnggaran({{mt_rand(10,99).($proposal->id*2)}})" class="btn btn-sm btn-default btn-flat center"><i class="fa fa-edit"></i> Perbaharui</a>
                                        </td>
                                        @else
                                        <td class="text-center" colspan="2"><span class="label label-danger">Belum Mengerjakan</span></td>
                                        <td class="text-center" colspan="2">
                                        <a href="{{route('perbaikanpenelitianng.anggaran.index', base64_encode($proposal->id+15))}}" class="btn btn-sm btn-default btn-flat center"><i class="fa fa-pencil"></i> Lengkapi</a>
                                        </td>
                                        @endif
                                        <td data-toggle="collapse" data-target="#accordionanggaran" class="clickable text-center">
                                        <a onclick="#" class="btn btn-sm btn-info btn-flat center"><i class="fa  fa-folder-open-o"></i> Rincikan</a>  
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="12">
                                        <tbody id="accordionanggaran" class="collapse table-bordered">
                                            @if($hnr || $bhn || $jln || $brg )
                                            <tr>
                                                <td class="text-right">1</td>
                                                <td class="text-left"   colspan="6">&nbsp;&nbsp;&nbsp;Total Anggaran: Rp {{format_uang($hnr+$bhn+$jln+$brg)}}</td>
                                                <td class="text-center" colspan="2">
                                                    <div class="progress progress-xs">
                                                        <div class="progress-bar progress-bar-success" style="width: {{round(($hnr+$bhn+$jln+$brg) / $skema->dana * 100)}}%"></div>
                                                    </div>
                                                </td>
                                                <td class="text-center" colspan="2">{{round(($hnr+$bhn+$jln+$brg) / $skema->dana * 100)}}%</td>
                                                <td class="text-center"><span class="label label-success">Terpenuhi</span></td>
                                            </tr>
                                            <tr>
                                                <td class="text-right">2</td>
                                                <td class="text-left"   colspan="6">&nbsp;&nbsp;&nbsp;Belanja Honor: Rp {{format_uang($hnr)}}</td>
                                                <td class="text-center" colspan="2">
                                                    <div class="progress progress-xs">
                                                        <div class="progress-bar progress-bar-success" style="width: {{round($hnr / ($pagu[0]->batas*$skema->dana/100)*100)}}%"></div>
                                                    </div>
                                                </td>
                                                <td class="text-center" colspan="2">{{round($hnr / ($pagu[0]->batas*$skema->dana/100)*100)}}%</td>
                                                <td class="text-center"><span class="label label-success">Terpenuhi</span></td>
                                            </tr>
                                            <tr>
                                                <td class="text-right">3</td>
                                                <td class="text-left"   colspan="6">&nbsp;&nbsp;&nbsp;Belanja Bahan: Rp {{format_uang($bhn)}}</td>
                                                <td class="text-center" colspan="2">
                                                    <div class="progress progress-xs">
                                                        <div class="progress-bar progress-bar-success" style="width: {{round($bhn / ($pagu[1]->batas*$skema->dana/100)*100)}}%"></div>
                                                    </div>
                                                </td>
                                                <td class="text-center" colspan="2">{{round($bhn / ($pagu[1]->batas*$skema->dana/100)*100)}}%</td>
                                                <td class="text-center"><span class="label label-success">Terpenuhi</span></td>
                                            </tr>
                                            <tr>
                                                <td class="text-right">4</td>
                                                <td class="text-left"   colspan="6">&nbsp;&nbsp;&nbsp;Belanja Perjalanan: Rp {{format_uang($jln)}}</td>
                                                <td class="text-center" colspan="2">
                                                    <div class="progress progress-xs">
                                                        <div class="progress-bar progress-bar-success" style="width: {{round($jln / ($pagu[2]->batas*$skema->dana/100)*100)}}%"></div>
                                                    </div>
                                                </td>
                                                <td class="text-center" colspan="2">{{round($jln / ($pagu[2]->batas*$skema->dana/100)*100)}}%</td>
                                                <td class="text-center"><span class="label label-success">Terpenuhi</span></td>
                                            </tr>
                                            <tr>
                                                <td class="text-right">5</td>
                                                <td class="text-left"   colspan="6">&nbsp;&nbsp;&nbsp;Belanja Barang Non-Operasional: Rp {{format_uang($brg)}}</td>
                                                <td class="text-center" colspan="2">
                                                    <div class="progress progress-xs">
                                                        <div class="progress-bar progress-bar-success" style="width: {{round($brg / ($pagu[3]->batas*$skema->dana/100)*100)}}%"></div>
                                                    </div>
                                                </td>
                                                <td class="text-center" colspan="2">{{round($brg / ($pagu[3]->batas*$skema->dana/100)*100)}}%</td>
                                                <td class="text-center"><span class="label label-success">Terpenuhi</span></td>
                                            </tr>
      
                                            <tr>
                                                <td colspan="12"></td>
                                            </tr>
                                            @endif
                                        </tbody>
                                       </td>
                                    </tr>
                                    <tr>
                                        <td colspan="12"></td>
                                    </tr>

                                   <!--  <tr>
                                        <td class="text-center">F</td>
                                        <td class="text-left" colspan="6">SUBMIT USULAN</td>

                                        @if($proposal->aktif)
                                        <td class="text-center" colspan="2"><span class="label label-success">Telah Submit</span></td>
                                        <td class="text-center" colspan="2">
                                        -
                                        </td>
                                        @elseif((!$proposal->aktif) && (!($err2 != 99) || !($err3 != 99) || !($err4 != 99) || !($err5 != 99)))
                                        <td class="text-center" colspan="2"><span class="label label-danger">Belum Submit</span></td>
                                        <td class="text-center" colspan="2">
                                        -
                                        </td>
                                        @else
                                        <td class="text-center" colspan="2"><span class="label label-danger">Belum Submit</span></td>
                                        <td class="text-center" colspan="2">
                                        <a href="{{ route('perbaikanpenelitianng.resume', base64_encode('1'.mt_rand(1,9).($proposal->id*2))) }}" class="btn btn-sm btn-default btn-flat center"><i class="fa fa-pencil"></i> Lengkapi</a>
                                        </td>
                                        @endif
                                        <td class="text-center"> 
                                        -
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="12">
                                        <tbody class="collapse table-bordered">  
                                            <tr>
                                                <td colspan="12"></td>
                                            </tr>
                                        </tbody>
                                       </td>
                                    </tr>
                                    <tr>
                                        <td colspan="12"></td>
                                    </tr>
                                -->
                                    <tr>
                                        <td class="text-center">F</td>
                                        <td class="text-left" colspan="6">UNGGAH DOKUMENTASI</td>

                                        @if($err6 == 0)
                                        <td class="text-center" colspan="2"><span class="label label-success">Lengkap</span></td>
                                        <td class="text-center" colspan="2">
                                         <a href="{{ route('validasiperbaikanpenelitian.edit',base64_encode(mt_rand(10,99).$proposal->id) )}}"  class="btn btn-sm btn-default btn-flat center"><i class="fa fa-edit"></i> Perbaharui</a>
                                        </td>
                                        @elseif($err6 < 99)
                                        <td class="text-center" colspan="2"><span class="label label-warning">Belum Lengkap</span></td>
                                        <td class="text-center" colspan="2">
                                        <a href="{{ route('validasiperbaikanpenelitian.edit',base64_encode(mt_rand(10,99).$proposal->id) )}}" class="btn btn-sm btn-default btn-flat center"><i class="fa fa-edit"></i> Perbaharui</a>
                                        </td>
                                        @else
                                        <td class="text-center" colspan="2"><span class="label label-danger">Belum Mengerjakan</span></td>
                                        <td class="text-center" colspan="2">
                                        <a href="{{ route('validasiperbaikanpenelitian.edit',base64_encode(mt_rand(10,99).$proposal->id) )}}" class="btn btn-sm btn-default btn-flat center"><i class="fa fa-pencil"></i> Lengkapi</a>
                                        </td>
                                        @endif
                                        <td data-toggle="collapse" data-target="#accordionunggah" class="clickable text-center">
                                        <a onclick="#" class="btn btn-sm btn-info btn-flat center"><i class="fa  fa-folder-open-o"></i> Rincikan</a>  
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="12">
                                        <tbody id="accordionunggah" class="collapse table-bordered">  
                                            <tr>
                                                <td class="text-right">1</td>
                                                <td class="text-left"   colspan="6">&nbsp;&nbsp;&nbsp;Lembar Pengesahan</td>
                                                @if($proposal->pengesahan)
                                                <td class="text-center" colspan="2">
                                                    <div class="progress progress-xs">
                                                        <div class="progress-bar progress-bar-success" style="width: 100%"></div>
                                                    </div>
                                                </td>
                                                <td class="text-center" colspan="2">100%</td>
                                                <td class="text-center"><span class="label label-success">Terpenuhi</span></td>
                                                @else
                                                <td class="text-center" colspan="2">
                                                    <div class="progress progress-xs">
                                                        <div class="progress-bar progress-bar-danger" style="width: 0%"></div>
                                                    </div>
                                                </td>
                                                <td class="text-center" colspan="2">0%</td>
                                                <td class="text-center"><span class="label label-danger">Belum</span></td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <td class="text-right">2</td>
                                                <td class="text-left"   colspan="6">&nbsp;&nbsp;&nbsp;Proposal Lengkap</td>
                                                @if($proposal->usulan)
                                                <td class="text-center" colspan="2">
                                                    <div class="progress progress-xs">
                                                        <div class="progress-bar progress-bar-success" style="width: 100%"></div>
                                                    </div>
                                                </td>
                                                <td class="text-center" colspan="2">100%</td>
                                                <td class="text-center"><span class="label label-success">Terpenuhi</span></td>
                                                @else
                                                 <td class="text-center" colspan="2">
                                                    <div class="progress progress-xs">
                                                        <div class="progress-bar progress-bar-danger" style="width: 0%"></div>
                                                    </div>
                                                </td>
                                                <td class="text-center" colspan="2">0%</td>
                                                <td class="text-center"><span class="label label-danger">Belum</span></td>
                                                @endif
                                            </tr>
      
                                            <tr>
                                                <td colspan="12"></td>
                                            </tr>
                                        </tbody>
                                       </td>
                                    </tr>
     
                                    <tr>
                                        <td class="text-center" width="4%"></td>
                                        <td class="text-center" width="8%"></td>
                                        <td class="text-center" width="8%"></td>
                                        <td class="text-center" width="8%"></td>
                                        <td class="text-center" width="8%"></td>
                                        <td class="text-center" width="8%"></td>
                                        <td class="text-center" width="8%"></td>
                                        <td class="text-center" width="8%"></td>
                                        <td class="text-center" width="8%"></td>
                                        <td class="text-center" width="8%"></td>
                                        <td class="text-center" width="8%"></td>
                                        <td class="text-center" width="16%"></td>
                                    </tr> 
                                </tbody>
                            </table>
                        </div>
                        @if($penelitian->status == 4)
                        Silahkan perbaiki dan lengkapi proposal anda yang belum lengkap / bermasalah 
                        @else
                        Setelah melakukan validasi, maka usulan akan diverifikasi oleh Admin untuk tahapan selanjutnya. Jangan lakukan validasi jika masih terdapat beberap item pemeriksaan yang belum diperbaiki atau dilengkapi, karena setelah melakukan validasi usulan maka sistem akan mematikan fitur modifikasi dan pengelolaan dan usulan akan diteruskan oleh admin pada tahap selanjutnya dengan segala kekurangannya. 
                        @endif
                    </div>
                </div>  
                
                @if($penelitian->status == 4)
                @else
                @if(!$err2 && !$err3 && !$err4 && !$err5 && !$err6)
                <form class="form-horizontal" method="POST" action="{{route('validasiperbaikanpenelitian.destroy', $proposal->id)}}">
                {{ csrf_field() }} {{method_field('DELETE')}}
                
                <div class="form-group row">
                    <div class="col-md-12 ">
                        <a href="{{route('perbaikanpenelitianng.index')}}" class="btn btn-default pull-left" name="awal" id="awal"><span class="fa fa-reply fa-fw"></span> Kembali</a>
                        <button type="submit" class="btn btn-primary pull-right">
                          <span class="ion ion-android-checkbox-outline"></span>
                            VALIDASI
                        </button>
                    </div>

                </div>
                </form>
                @else
                <div class="form-group row">
                    <div class="col-md-12 ">
                        <a href="{{route('perbaikanpenelitianng.index')}}" class="btn btn-default pull-left" name="awal" id="awal"><span class="fa fa-reply fa-fw"></span> Kembali</a>
                        <button type="button" class="btn btn-primary pull-right" disabled>
                          <span class="ion ion-android-checkbox-outline"></span>
                            VALIDASI
                        </button>
                    </div>

                </div>
                @endif
                @endif
            </div>
        </div>

    </div>
</div>

@endsection

@section('script')
<script type="text/javascript">

    function editProposal(id) {
        window.location = "{{route('perbaikanpenelitianng.proposal.show', [base64_encode(mt_rand(10,999)),''])}}/"+btoa(id);
    }

    function bukaProposal(id) {
        window.location = "{{route('perbaikanpenelitianng.proposal.show', [base64_encode(mt_rand(10,999)),''])}}/"+btoa(id);
    }

    function editAnggota(id) {
        window.location = "{{route('perbaikanpenelitianng.anggota.show', [base64_encode(mt_rand(10,999)),''])}}/"+btoa(id);
    }


    function editSubtansi(id) {
        window.location = "{{route('perbaikanpenelitianng.subtansi.index', base64_encode($proposal->id+127))}}";
    }

    function bukaSubtansi(id) {
        window.location = "{{route('perbaikanpenelitianng.subtansi.index', base64_encode($proposal->id+127))}}";
    }

    function editLuaran(id) {
        window.location = "{{route('perbaikanpenelitianng.luaran.show', [base64_encode(mt_rand(10,999)),''])}}/"+btoa(id);
    }


    function editAnggaran(id) {
        window.location = "{{route('perbaikanpenelitianng.anggaran.show', [base64_encode(mt_rand(10,999)),''])}}/"+btoa(id);
    }





    
</script>
@endsection