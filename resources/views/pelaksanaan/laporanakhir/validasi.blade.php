@extends('layouts.app')

@section('title')
  
    Validasi Laporan Akhir 
    
@endsection

@section('breadcrumb')
    @parent
    <li><a href="{{ route('laporanakhir.index') }}">Laporan Akhir</a></li>
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
                    <div class="panel-heading"><strong>Periode: {{$periode->tahun}}</strong></div>
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
                    @elseif($errors->first('errornf'))
                    <script type="text/javascript">

                        "use strict";
                        swal(
                            'Terjadi Kesalahan!',
                            'Data Tidak ditemukan',
                            'error'
                        );
                    </script>
                        
                    @else
                    @endif
                    <div class="panel-body">
                        <div class="">
                            <div class="box-header">
                                <i class="ion ion-clipboard"></i>
                                <h4 class="box-title">Pengusul: {{$dsn->nama}}</h4><br>
                                <i class="ion ion-clipboard"></i>
                                <h4 class="box-title">Judul: {{$proposal->judul}}</h4>
                            </div>
                            Halaman ini merupakan lembaran untuk Input data Laporan Akhir. Status harus lengkap, Data  di input secara berurutan dari A - B - C - D - E
                            <div class="form-group row">
                                <div class="col-md-12 ">
                                    <br>
                                    <button type="button" onclick="goLoad()"" class="btn btn-default pull-left" ><i class="fa  fa-refresh fa-fw"></i> Refresh</button>
                                      Refresh Halaman jika belum ada perubahan pada status setelah input data laporan
                                </div>
            
                            </div>
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
                                        <td class="text-left" colspan="6">LUARAN LAINNYA</td>
                                        @if($err > 0)
                                        <td class="text-center" colspan="2"><span class="label label-success">Lengkap</span></td>
                                        <td class="text-center" colspan="2">
                                        <a onclick="editLuaranLainnya({{mt_rand(10,99).($proposal->id)}})" class="btn btn-sm btn-default btn-flat center"><i class="fa fa-edit"></i> Perbaharui</a>

                                        </td>
                                       
                                        @else
                                        <td class="text-center" colspan="2"><span class="label label-danger">Belum Mengerjakan</span></td>
                                        <td class="text-center" colspan="2">
                                        <a onclick="editLuaranLainnya({{mt_rand(10,99).($proposal->id)}})" class="btn btn-sm btn-default btn-flat center"><i class="fa fa-edit"></i> Lengkapi</a>
                                    
                                        </td>
                                        @endif
                                        <td data-toggle="collapse" data-target="#accordionproposal" class="clickable text-center">
                                        <a onclick="#" class="btn btn-sm btn-info btn-flat center"><i class="fa  fa-folder-open-o"></i> Rincikan</a>  
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="12">
                                        <tbody id="accordionproposal" class="collapse table-bordered">
                                            @foreach($luaranlainnya as $list)
                                            <tr>
                                                <td class="text-right">{{++$no}}</td>
                                                <td class="text-left"  colspan="5">&nbsp;&nbsp;&nbsp;{{$list->judul}}</td>
                                                <td class="text-left"  colspan="5">&nbsp;&nbsp;&nbsp;{{$list->publish}}</td>
                                               
                                                <td class="text-center"><span class="label label-success">{{$list->judul}}</span></td>
                                               
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
                                        <td class="text-center">B</td>
                                        <td class="text-left" colspan="6">LUARAN WAJIB</td>
                                        @if($err2 > 0)
                                        <td class="text-center" colspan="2"><span class="label label-success">Lengkap</span></td>
                                        <td class="text-center" colspan="2">
                                        <a onclick="editLuaranWajib({{mt_rand(10,99).($proposal->id)}})" class="btn btn-sm btn-default btn-flat center"><i class="fa fa-edit"></i> Perbaharui</a>
                                        </td>
                                       
                                        @else
                                        <td class="text-center" colspan="2"><span class="label label-danger">Belum Mengerjakan</span></td>
                                        <td class="text-center" colspan="2">
                                            @if($err > 0)
                                            <a onclick="editLuaranWajib({{mt_rand(10,99).($proposal->id)}})" class="btn btn-sm btn-default btn-flat center"><i class="fa fa-edit"></i> Lengkapi</a>
                                            @else 
                                            <a onclick="editLuaranWajib({{mt_rand(10,99).($proposal->id)}})" class="btn btn-sm btn-default btn-flat center disabled"><i class="fa fa-edit"></i> Lengkapi</a>

                                            @endif  
                                            
                                        </td>
                                        @endif

                                        <td data-toggle="collapse" data-target="#accordionanggota" class="clickable text-center">
                                        <a onclick="#" class="btn btn-sm btn-info btn-flat center"><i class="fa  fa-folder-open-o"></i> Rincikan</a>  
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="12">
                                        <tbody id="accordionanggota" class="collapse table-bordered">
                                            @foreach($luaranwajib as $list)
                                            <tr>
                                                <td class="text-right">{{++$no1}}</td>
                                                <td class="text-left"  colspan="5">&nbsp;&nbsp;&nbsp;{{$list->judul}}</td>
                                                <td class="text-left"  colspan="5">&nbsp;&nbsp;&nbsp;{{$list->publish}}</td>
                                               
                                                <td class="text-center"><span class="label label-success">{{$list->judul}}</span></td>
                                               
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
                                        <td class="text-left" colspan="6">LUARAN TAMBAHAN</td>
                                        @if($err3 > 0)
                                        <td class="text-center" colspan="2"><span class="label label-success">Lengkap</span></td>
                                        <td class="text-center" colspan="2">
                                        <a onclick="editLuaranTambahan({{mt_rand(10,99).($proposal->id)}})" class="btn btn-sm btn-default btn-flat center"><i class="fa fa-edit"></i> Perbaharui</a>
                                        </td>
                                       
                                        @else
                                        <td class="text-center" colspan="2"><span class="label label-danger">Belum Mengerjakan</span></td>
                                        <td class="text-center" colspan="2">
                                            @if($err2 > 0)
                                            <a onclick="editLuaranTambahan({{mt_rand(10,99).($proposal->id)}})" class="btn btn-sm btn-default btn-flat center"><i class="fa fa-pencil"></i> Lengkapi</a>
                                            @else 
                                            <a onclick="editLuaranTambahan({{mt_rand(10,99).($proposal->id)}})" class="btn btn-sm btn-default btn-flat center disabled"><i class="fa fa-pencil"></i> Lengkapi</a>

                                            @endif  
                                        </td>
                                        @endif
                                        <td data-toggle="collapse" data-target="#accordionsubtansi" class="clickable text-center">
                                        <a onclick="#" class="btn btn-sm btn-info btn-flat center"><i class="fa  fa-folder-open-o"></i> Rincikan</a>  
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="12">
                                        <tbody id="accordionsubtansi" class="collapse table-bordered">
                                            @foreach($luarantambahan as $list)
                                            <tr>
                                                <td class="text-right">{{++$no2}}</td>
                                                <td class="text-left"  colspan="5">&nbsp;&nbsp;&nbsp;{{$list->judul}}</td>
                                                <td class="text-left"  colspan="5">&nbsp;&nbsp;&nbsp;{{$list->publish}}</td>
                                               
                                                <td class="text-center"><span class="label label-success">{{$list->judul}}</span></td>
                                               
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
                                        <td class="text-center">D</td>
                                    <td class="text-left" colspan="6">LAPORAN AKHIR</td>
                                        @if($err4 > 0)
                                        <td class="text-center" colspan="2"><span class="label label-success">Lengkap</span></td>
                                        <td class="text-center" colspan="2">
                                            <a  href="{{ route('validasilaporanakhir.bacalaporan',base64_encode(mt_rand(10,99).$laporanakhir->id) )}}" class="btn btn-sm btn-default btn-flat center" id="Unduh"><i class="ion ion-ios-book-outline text-blue"></i> Baca </a><br><br>
                                            <a onclick="hapusLaporan({{mt_rand(10,99).($proposal->id*3)}} )"  class="btn btn-sm btn-default btn-flat center" id="hapus"><i class="ion ion-ios-trash text-red"></i> Hapus </a>

                                        </td>
                                       
                                        @else
                                        <td class="text-center" colspan="2"><span class="label label-danger">Belum Mengerjakan</span></td>
                                        <td class="text-center" colspan="2">
                                            @if($err3 > 0)
                                            <a href="{{ route('laporanakhir.edit',base64_encode(mt_rand(10,99).$proposal->id) )}}"  class="btn btn-sm btn-default btn-flat center"><i class="fa fa-pencil"></i> Lengkapi</a>
                                            @else 
                                            <a href="{{ route('laporanakhir.edit',base64_encode(mt_rand(10,99).$proposal->id) )}}"  class="btn btn-sm btn-default btn-flat center disabled"><i class="fa fa-pencil"></i> Lengkapi</a>

                                            @endif  
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
                                    <td class="text-left" colspan="6">PENGGUNAAN ANGGARAN</td>
                                        @if($err5 > 0)
                                        <td class="text-center" colspan="2"><span class="label label-success">Lengkap</span></td>
                                        <td class="text-center" colspan="2">
                                         <a  href="{{ route('validasilaporanakhir.bacaanggaran',base64_encode(mt_rand(10,99).$anggaranakhir->id) )}}" class="btn btn-sm btn-default btn-flat center" id="Unduh"><i class="ion ion-ios-book-outline text-blue"></i> Baca </a><br><br>

                                        <a onclick="hapusAnggaran({{mt_rand(10,99).($proposal->id*3)}} )" class="btn btn-sm btn-default btn-flat center" id="hapus"><i class="ion ion-ios-trash text-red"></i> Hapus </a>

                                        </td>
                                      
                                        @else
                                        <td class="text-center" colspan="2"><span class="label label-danger">Belum Mengerjakan</span></td>
                                        <td class="text-center" colspan="2">
                                            @if($err4 > 0)
                                            <a href="{{ route('penggunaananggaranakhir.edit',base64_encode(mt_rand(10,99).$proposal->id) )}}"  class="btn btn-sm btn-default btn-flat center"><i class="fa fa-edit"></i> Lengkapi</a>
                                            @else 
                                            <a href="{{ route('penggunaananggaranakhir.edit',base64_encode(mt_rand(10,99).$proposal->id) )}}"  class="btn btn-sm btn-default btn-flat center disabled"><i class="fa fa-edit"></i> Lengkapi</a>

                                            @endif  
                                        </td>
                                        @endif
                                        <td data-toggle="collapse" data-target="#accordionanggaran" class="clickable text-center">
                                        <a onclick="#" class="btn btn-sm btn-info btn-flat center"><i class="fa  fa-folder-open-o"></i> Rincikan</a>  
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="12">
                                        <tbody id="accordionanggaran" class="collapse table-bordered">
                                           
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
                                        <a href="{{ route('penelitianng.resume', base64_encode('1'.mt_rand(1,9).($proposal->id*2))) }}" class="btn btn-sm btn-default btn-flat center"><i class="fa fa-pencil"></i> Lengkapi</a>
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
                                   
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>  
                
               
                @if(!$err2 && !$err3 && !$err4 && !$err5 && !$err6)
                <form class="form-horizontal" method="POST" action="{{route('validasipenelitian.destroy', $proposal->id)}}">
                {{ csrf_field() }} {{method_field('DELETE')}}
                
                <div class="form-group row">
                    <div class="col-md-12 ">
                        <button type="button" onclick="goBack()"" class="btn btn-default pull-left" ><i class="fa  fa-reply fa-fw"></i> Kembali</button>

                    </div>

                </div>
                </form>
                @else
                <div class="form-group row">
                    <div class="col-md-12 ">
                        <button type="button" onclick="goBack()"" class="btn btn-default pull-left" ><i class="fa  fa-reply fa-fw"></i> Kembali</button>

                    </div>

                </div>
                @endif
                
            </div>
        </div>

    </div>
</div>

@endsection

@section('script')
<script type="text/javascript">

    function hapusAnggaran(id) {
            if (confirm("Apakah yakin data dari kegiatan ini akan dihapus?")) {
                $.ajax({
                    url  : "{{route('penggunaananggaranakhir.destroy','')}}/"+id,
                    type : "POST",
                    data : {'_method' : 'DELETE', '_token' : $('input[name = "_token"]').val()},
                    success : function(data) {
                        swal(
                                            'Dihapus!',
                                            'Data berhasil dihapus.',
                                            'success'
                                        );
                        location.reload(true);
                    },
                    error : function() {
                        alert("Tidak dapat menghapus data");
                    }

                });
            }
        }
        function hapusLaporan(id) {
            if (confirm("Apakah yakin data laporan ini akan dihapus?")) {
                $.ajax({
                    url  : "{{route('laporanakhir.destroy','')}}/"+id,
                    type : "POST",
                    data : {'_method' : 'DELETE', '_token' : $('input[name = "_token"]').val()},
                    success : function(data) {
                        swal(
                                            'Dihapus!',
                                            'Data berhasil dihapus.',
                                            'success'
                                        );
                        location.reload(true);
                    },
                    error : function() {
                        alert("Tidak dapat menghapus data");
                    }

                });
            }
        }


    function goBack() 
    {
    window.history.back()
    }
    function goLoad() 
    {
        location.reload()
    }
    function editLuaranLainnya(id) {
        window.location = "{{route('luaranakhir.showlainnya', '')}}/"+btoa(id) ;
    }
    function editLuaranTambahan(id) {
        window.location = "{{route('luaranakhir.showtambahan', '')}}/"+btoa(id) ;
    }
    function editLuaranWajib(id) {
        window.location = "{{route('luaranakhir.showwajib','')}}/"+btoa(id) ;
    }


    function editProposal(id) {
        window.location = "{{route('penelitianng.proposal.show', [base64_encode(mt_rand(10,999)),''])}}/"+btoa(id);
    }

    function bukaProposal(id) {
        window.location = "{{route('penelitianng.proposal.show', [base64_encode(mt_rand(10,999)),''])}}/"+btoa(id);
    }

    function editAnggota(id) {
        window.location = "{{route('penelitianng.anggota.show', [base64_encode(mt_rand(10,999)),''])}}/"+btoa(id);
    }


    function editSubtansi(id) {
        window.location = "{{route('penelitianng.subtansi.index', base64_encode($proposal->id+127))}}";
    }

    function bukaSubtansi(id) {
        window.location = "{{route('penelitianng.subtansi.index', base64_encode($proposal->id+127))}}";
    }

    
    function editAnggaran(id) {
        window.location = "{{route('penelitianng.anggaran.show', [base64_encode(mt_rand(10,999)),''])}}/"+btoa(id);
    }





    
</script>
@endsection