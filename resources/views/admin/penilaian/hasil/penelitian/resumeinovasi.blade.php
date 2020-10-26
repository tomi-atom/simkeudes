@extends('layouts.app')

@section('title')
    Ringkasan Usulan Penelitian
@endsection

@section('breadcrumb')
    @parent
    <li><a href="{{ route('hasilreviewer.index') }}">Penelitian</a></li>
    <li>Pengusul</li>
    <li>Ringkasan</li>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/sweetalert2/1.3.3/sweetalert2.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/sweetalert2/0.4.5/sweetalert2.css">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/sweetalert2/1.3.3/sweetalert2.min.js"></script>
@endsection

@section('content')
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
                @endif
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading"><strong></strong> <div class="pull-right"><strong></strong></div></div>
            
            <div class="panel-body">
                
                <div class="panel panel-default">
                    <div class="panel-heading"><strong>Periode: 2020 | Batch 1</strong></div>
            
                    <div class="panel-body">
                        <div class="">
                            <div class="box-header">
                                <i class="ion ion-clipboard"></i>
                                <h4 class="box-title">Pengusul: {{$ketua->nama}}</h4><br>
                                <i class="ion ion-clipboard"></i>
                                <h4 class="box-title">Skema: {{$prop->skema->skema}}</h4>
                            </div>
                            <div>
                                <table class="table table-bordered">
                                    <thead>
                                        
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td colspan="8"><b>1. JUDUL</b><br>{{$prop->judul}}</td>
                                        </tr> 
                                        <tr>
                                            <td colspan="8"></td> 
                                        </tr> 
                                       
                                        <tr>
                                            <td colspan="8"><b>2. IDENTITAS PENGUSUL</b><br>.</td> 
                                        </tr>
                                        <tr>
                                            <td colspan="8"></td> 
                                        </tr>  
                                        <tr>
                                            <td class="text-center" colspan="2">Nama, Peran</td>
                                            <td class="text-center">Fakultas / Institusi</td>
                                            <td class="text-center">Program Studi/Bagian</td>
                                            <td class="text-center" colspan="2">Bidang Tugas</td>
                                            <td class="text-center">ID Sinta</td>
                                            <td class="text-center">H-Index</td>
                                        </tr> 
                                        <tr>
                                            <td class="text-center" colspan="2">{{$ketua->nama}} <br><small class="label label-primary">Ketua Pengusul</small></td>
                                            <td class="text-center">{{$ketua->fakultas->sinonim}}  <br>{{$ketua->universitas->pt}}</td>
                                            <td class="text-center">{{$ketua->prodi->prodi}}</td>
                                            <td class="text-center" colspan="2">-</td>
                                            <td class="text-center">{{$ketua->sinta}}</td>
                                            <td class="text-center">{{$ketua->hindex}}</td>
                                        </tr> 
                                                                          <tr>
                                            <td colspan="8"><br></td>  
                                        </tr> 
    
                                        <tr>
                                            <td colspan="8"><b>3. Biaya Penelitian</b>
                                        </tr>
                                        <td colspan="8"></td>  
                                        <tr>
                                            <td class="text-center" colspan="4">Jenis Pembelanjaan</td>
                                            <td class="text-center" colspan="2">Sub-Total Biaya</td>
                                            <td class="text-center">Pagu Maksimum</td>
                                            <td class="text-center">Aksi</td>
                                        </tr> 
                                        <tr>
                                            <td class="text-left" colspan="4">1. HONOR</td>
                                            <td class="text-center" colspan="2">Rp {{format_uang($thnr)}},-</td>
                                            <td class="text-center">Rp {{format_uang($prop->skema->dana * $mata[0]->batas / 100)}},-</td>
                                            <td data-toggle="collapse" data-target="#accordionhonor" class="clickable text-center"><span class="label label-primary">Rincikan</span></td>
                                        </tr>
                                        <tr>
                                            <td colspan="8">
                                            <tbody id="accordionhonor" class="collapse table-bordered">
                                                <tr>
                                                    <td class="text-center" colspan="4"><b>Item Kegiatan</b></td>
                                                    <td class="text-center"><b>Satuan</b></td>
                                                    <td class="text-center"><b>Volume</b></td>
                                                    <td class="text-center"><b>Biaya Satuan</b></td>
                                                    <td class="text-center"><b>Total</b></td>
                                                </tr {{$no = 0}} {{$total = 0}}>
                                                @foreach ($biaya as $list) 
                                                    @if($list->anggaranid == 1)
                                                    <tr {{$total += $list->volume * $list->biaya}}>
                                                        <td class="text-left" colspan="4">&nbsp;&nbsp;&nbsp;&nbsp;{{++$no}}. {{$list->item}}</td>
                                                        <td class="text-center">{{$list->satuan}}</td>
                                                        <td class="text-center">{{$list->volume}}</td>
                                                        <td class="text-center">{{format_uang($list->biaya)}}</td>
                                                        <td class="text-right">Rp {{format_uang($list->volume * $list->biaya)}},-</td>
                                                    </tr>
                                                    @endif
                                                @endforeach  
                                                <tr>
                                                    <td class="text-right" colspan="6"></td>
                                                    <td class="text-center"><b>Sub-Total</b></td>
                                                    <td class="text-right">Rp {{format_uang($total)}},-</td>
                                                </tr> 
                                                <tr>
                                                    <td colspan="8"></td>
                                                </tr>
                                            </tbody>
                                           </td>
                                        </tr>
                                        <tr>
                                            <td colspan="8"></td>
                                        </tr>
                                        <tr>
                                            <td class="text-left" colspan="4">2. BELANJA BAHAN</td>
                                            <td class="text-center" colspan="2">Rp {{format_uang($tbhn)}},-</td>
                                            <td class="text-center">Rp {{format_uang($prop->skema->dana * $mata[1]->batas / 100)}},-</td>
                                            <td data-toggle="collapse" data-target="#accordionbahan" class="clickable text-center"><span class="label label-primary">Rincikan</span></td>
                                        </tr> 
                                        <tr>
                                            <td colspan="8">
                                            <tbody id="accordionbahan" class="collapse table-bordered">
                                                <tr>
                                                    <td class="text-center" colspan="4"><b>Item Kegiatan</b></td>
                                                    <td class="text-center"><b>Satuan</b></td>
                                                    <td class="text-center"><b>Volume</b></td>
                                                    <td class="text-center"><b>Biaya Satuan</b></td>
                                                    <td class="text-center"><b>Total</b></td>
                                                </tr {{$no = 0}} {{$total = 0}}>
                                                @foreach ($biaya as $list)
                                                    @if($list->anggaranid == 2)
                                                    <tr {{$total += $list->volume * $list->biaya}}>
                                                        <td class="text-left" colspan="4">&nbsp;&nbsp;&nbsp;&nbsp;{{++$no}}. {{$list->item}}</td>
                                                        <td class="text-center">{{$list->satuan}}</td>
                                                        <td class="text-center">{{$list->volume}}</td>
                                                        <td class="text-center">{{format_uang($list->biaya)}}</td>
                                                        <td class="text-right">Rp {{format_uang($list->volume * $list->biaya)}},-</td>
                                                    </tr>
                                                    @endif
                                                @endforeach  
                                                <tr>
                                                    <td class="text-right" colspan="6"></td>
                                                    <td class="text-center"><b>Sub-Total</b></td>
                                                    <td class="text-right">Rp {{format_uang($total)}},-</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="8"></td>
                                                </tr>
                                            </tbody>
                                           </td>
                                        </tr>
                                        <tr>
                                            <td colspan="8"></td>
                                        </tr>
                                        <tr>
                                            <td class="text-left" colspan="4">3. BELANJA PERJALANAN</td>
                                            <td class="text-center" colspan="2">Rp {{format_uang($tjln)}},-</td>
                                            <td class="text-center">Rp {{format_uang($prop->skema->dana * $mata[2]->batas / 100)}},-</td>
                                            <td data-toggle="collapse" data-target="#accordionjalan" class="clickable text-center"><span class="label label-primary">Rincikan</span></td>
                                        </tr>
                                        <tr>
                                            <td colspan="8">
                                            <tbody id="accordionjalan" class="collapse table-bordered">
                                                <tr>
                                                    <td class="text-center" colspan="4"><b>Item Kegiatan</b></td>
                                                    <td class="text-center"><b>Satuan</b></td>
                                                    <td class="text-center"><b>Volume</b></td>
                                                    <td class="text-center"><b>Biaya Satuan</b></td>
                                                    <td class="text-center"><b>Total</b></td>
                                                </tr {{$no = 0}} {{$total = 0}}>
                                                @foreach ($biaya as $list)
                                                    @if($list->anggaranid == 3)
                                                    <tr {{$total += $list->volume * $list->biaya}}>
                                                        <td class="text-left" colspan="4">&nbsp;&nbsp;&nbsp;&nbsp;{{++$no}}. {{$list->item}}</td>
                                                        <td class="text-center">{{$list->satuan}}</td>
                                                        <td class="text-center">{{$list->volume}}</td>
                                                        <td class="text-center">{{format_uang($list->biaya)}}</td>
                                                        <td class="text-right">Rp {{format_uang($list->volume * $list->biaya)}},-</td>
                                                    </tr>
                                                    @endif
                                                @endforeach  
                                                <tr>
                                                    <td class="text-right" colspan="6"></td>
                                                    <td class="text-center"><b>Sub-Total</b></td>
                                                    <td class="text-right">Rp {{format_uang($total)}},-</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="8"></td>
                                                </tr>
                                            </tbody>
                                           </td>
                                        </tr>
                                        <tr>
                                            <td colspan="8"></td>
                                        </tr>
                                        <tr>
                                            <td class="text-left" colspan="4">4. BELANJA BARANG NON-OPERATIONAL</td>
                                            <td class="text-center" colspan="2">Rp {{format_uang($tbrg)}},-</td>
                                            <td class="text-center">Rp {{format_uang($prop->skema->dana * $mata[3]->batas / 100)}},-</td>
                                            <td data-toggle="collapse" data-target="#accordionbarang" class="clickable text-center"><span class="label label-primary">Rincikan</span></td>
                                        </tr>
                                        <tr>
                                            <td colspan="8">
                                            <tbody id="accordionbarang" class="collapse table-bordered">
                                                <tr>
                                                    <td class="text-center" colspan="4"><b>Item Kegiatan</b></td>
                                                    <td class="text-center"><b>Satuan</b></td>
                                                    <td class="text-center"><b>Volume</b></td>
                                                    <td class="text-center"><b>Biaya Satuan</b></td>
                                                    <td class="text-center"><b>Total</b></td>
                                                </tr {{$no = 0}} {{$total = 0}}>
                                                @foreach ($biaya as $list)
                                                    @if($list->anggaranid == 4) 
                                                    <tr {{$total += $list->volume * $list->biaya}}>
                                                        <td class="text-left" colspan="4">&nbsp;&nbsp;&nbsp;&nbsp;{{++$no}}. {{$list->item}}</td>
                                                        <td class="text-center">{{$list->satuan}}</td>
                                                        <td class="text-center">{{$list->volume}}</td>
                                                        <td class="text-center">{{format_uang($list->biaya)}}</td>
                                                        <td class="text-right">Rp {{format_uang($list->volume * $list->biaya)}},-</td>
                                                    </tr>
                                                    @endif
                                                @endforeach  
                                                <tr>
                                                    <td class="text-right" colspan="6"></td>
                                                    <td class="text-center"><b>Sub-Total</b></td>
                                                    <td class="text-right">Rp {{format_uang($total)}},-</td>
                                                </tr> 
                                                <tr>
                                                    <td colspan="8"></td>
                                                </tr> 
                                            </tbody>
                                           </td>
                                        </tr>
                                        <tr>
                                            <td class="text-center" width="12.5%"></td>
                                            <td class="text-center" width="12.5%"></td>
                                            <td class="text-center" width="12.5%"></td>
                                            <td class="text-center" width="12.5%"></td>
                                            <td class="text-center" width="12.5%"></td>
                                            <td class="text-center" width="12.5%"></td>
                                            <td class="text-center" width="12.5%"></td>
                                            <td class="text-center" width="12.5%"></td>
                                        </tr> 
                                    </tbody>
                                </table>
                            </div>
                            @if($errors->first('kesalahan'))
                            <script type="text/javascript">

                                "use strict";
                                swal(
                                    'Terjadi Kesalahan!',
                                    'Data Tidak Ditemukan',
                                    'error'
                                );
                            </script>
                            @endif
                            <div >
                                <form class="form-horizontal" data-toggle="validator" method="PUT">
                                    {{ csrf_field() }} {{ method_field('PUT') }}
                                        <input type="hidden" name="id" id="id" value="{{ $prop->id }}" readonly>
                            
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"> &times; </span> </button>
                                            <h3 class="modal-title"><a  href=" {{route('hasilreviewer.resumeberkas',base64_encode(mt_rand(10,99). $prop->id))}}" class="btn btn-primary " title="Proposl"><i class="glyphicon glyphicon-file"></i>Lihat Proposal </a>                       
                                            </h3>
                                        </div>
                                        <br>
                                        <br>
                                        <div class="row">
                                            <div class="col-sm-1">
                                            </div>
                                            <div class="col-sm-6">
                                                <label class="control-label "> Kriteria Penilaian</label>
                                            </div>
                                            <div class="col-sm-1">
                                                <label class="control-label col-sm-offset-2"> BOBOT(%)</label>
                                            </div>
                                            <div class="col-sm-1">
                                                <label class="control-label col-sm-offset-2"> SKOR</label>
                                            </div>
                                            <div class="col-sm-1">
                                                <label class="control-label col-sm-offset-2"> Nilai</label>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-sm-1">
                                                <label class="control-label col-sm-offset-2">1 </label>
                                            </div>
                                            <div class="col-sm-6">
                                                <label> Keterkaitan antara proposal penelitian dengan Renstra Penelitian Perguruan Tinggi</label>
                                            </div>
                                            <div class="col-sm-1">
                                                <label class="control-label col-sm-offset-2"> 10</label>
                                            </div>
                                            <div class="col-sm-1">
                                                <div class="col-sm-12 input-group input-group-sm">
                                                    <input type="text" class="form-control" name="kriteria1" id="kriteria1" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-1">
                                                <div class="col-sm-12 input-group input-group-sm">
                                                    <input type="text" class="form-control" name="nilai1" id="nilai1" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-1">
                                                <label class="control-label col-sm-offset-2">2 </label>
                                            </div>
                                            <div class="col-sm-6">
                                                <label>Ketajaman Latar Belakang, Masalah, Metodologi, Kejelasan Peta Jalan (Roadmap)</label>
                                            </div>
                                            <div class="col-sm-1">
                                                <label class="control-label col-sm-offset-2"> 15</label>
                                            </div>
                                            <div class="col-sm-1">
                                                <div class="col-sm-12 input-group input-group-sm">
                                                    <input type="text" class="form-control" name="kriteria2" id="kriteria2" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-1">
                                                <div class="col-sm-12 input-group input-group-sm">
                                                    <input type="text" class="form-control" name="nilai2" id="nilai2" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-sm-1">
                                                <label class="control-label col-sm-offset-2">3 </label>
                                            </div>
                                            <div class="col-sm-6">
                                                <label> Proyeksi/Potensi luaran tambahan penelitian: Teknologi Tepat Guna/kebijakan/model/rekayasa</label>
                                            </div>
                                            <div class="col-sm-1">
                                                <label class="control-label col-sm-offset-2"> 10</label>
                                            </div>
                                            <div class="col-sm-1">
                                                <div class="col-sm-12 input-group input-group-sm">
                                                    <input type="text" class="form-control" name="kriteria3" id="kriteria3" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-1">
                                                <div class="col-sm-12 input-group input-group-sm">
                                                    <input type="text" class="form-control" name="nilai3" id="nilai3" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-sm-1">
                                                <label class="control-label col-sm-offset-2">4 </label>
                                            </div>
                                            <div class="col-sm-6">
                                                <label>Rekam jejak peneliti </label>
                                            </div>
                                            <div class="col-sm-1">
                                                <label class="control-label col-sm-offset-2"> 10</label>
                                            </div>
                                            <div class="col-sm-1">
                                                <div class="col-sm-12 input-group input-group-sm">
                                                    <input type="text" class="form-control" name="kriteria4" id="kriteria4" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-1">
                                                <div class="col-sm-12 input-group input-group-sm">
                                                    <input type="text" class="form-control" name="nilai4" id="nilai4" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-sm-1">
                                                <label class="control-label col-sm-offset-2">5 </label>
                                            </div>
                                            <div class="col-sm-6">
                                                <label>Proyeksi/Potensi Publikasi Ilmiah Jurnal Internasional Scopus</label>
                                            </div>
                                            <div class="col-sm-1">
                                                <label class="control-label col-sm-offset-2"> 10</label>
                                            </div>
                                            <div class="col-sm-1">
                                                <div class="col-sm-12 input-group input-group-sm">
                                                    <input type="text" class="form-control" name="kriteria5" id="kriteria5" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-1">
                                                <div class="col-sm-12 input-group input-group-sm">
                                                    <input type="text" class="form-control" name="nilai5" id="nilai5" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-sm-1">
                                                <label class="control-label col-sm-offset-2">6 </label>
                                            </div>
                                            <div class="col-sm-6">
                                                <label> Proyeksi/Potensi luaran penelitian: Paten/Paten Sederhana minimal terdaftar</label>
                                            </div>
                                            <div class="col-sm-1">
                                                <label class="control-label col-sm-offset-2"> 15</label>
                                            </div>
                                            <div class="col-sm-1">
                                                <div class="col-sm-12 input-group input-group-sm">
                                                    <input type="text" class="form-control" name="kriteria6" id="kriteria6" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-1">
                                                <div class="col-sm-12 input-group input-group-sm">
                                                    <input type="text" class="form-control" name="nilai6" id="nilai6" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-sm-1">
                                                <label class="control-label col-sm-offset-2">7 </label>
                                            </div>
                                            <div class="col-sm-6">
                                                <label>Proyeksi/Potensi Ketercapaian Prototipe (P1,P2,P3)</label>
                                            </div>
                                            <div class="col-sm-1">
                                                <label class="control-label col-sm-offset-2"> 15</label>
                                            </div>
                                            <div class="col-sm-1">
                                                <div class="col-sm-12 input-group input-group-sm">
                                                    <input type="text" class="form-control" name="kriteria7" id="kriteria7" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-1">
                                                <div class="col-sm-12 input-group input-group-sm">
                                                    <input type="text" class="form-control" name="nilai7" id="nilai7" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-sm-1">
                                                <label class="control-label col-sm-offset-2">8 </label>
                                            </div>
                                            <div class="col-sm-6">
                                                <label> Surat keterangan mitra</label>
                                            </div>
                                            <div class="col-sm-1">
                                                <label class="control-label col-sm-offset-2"> 5</label>
                                            </div>
                                            <div class="col-sm-1">
                                                <div class="col-sm-12 input-group input-group-sm">
                                                    <input type="text" class="form-control" name="kriteria8" id="kriteria8" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-1">
                                                <div class="col-sm-12 input-group input-group-sm">
                                                    <input type="text" class="form-control" name="nilai8" id="nilai8" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-sm-1">
                                                <label class="control-label col-sm-offset-2">9 </label>
                                            </div>
                                            <div class="col-sm-6">
                                                <label>Kemutakhiran literatur (kekinian dan pustaka primer)</label>
                                            </div>
                                            <div class="col-sm-1">
                                                <label class="control-label col-sm-offset-2"> 5</label>
                                            </div>
                                            <div class="col-sm-1">
                                                <div class="col-sm-12 input-group input-group-sm">
                                                    <input type="text" class="form-control" name="kriteria9" id="kriteria9" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-1">
                                                <div class="col-sm-12 input-group input-group-sm">
                                                    <input type="text" class="form-control" name="nilai9" id="nilai9" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-sm-1">
                                                <label class="control-label col-sm-offset-2">10 </label>
                                            </div>
                                            <div class="col-sm-6">
                                                <label>Keterlibatan Mahasiswa</label>
                                            </div>
                                            <div class="col-sm-1">
                                                <label class="control-label col-sm-offset-2"> 5</label>
                                            </div>
                                            <div class="col-sm-1">
                                                <div class="col-sm-12 input-group input-group-sm">
                                                    <input type="text" class="form-control" name="kriteria10" id="kriteria10" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-1">
                                                <div class="col-sm-12 input-group input-group-sm">
                                                    <input type="text" class="form-control" name="nilai10" id="nilai10" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-sm-1">
                                                <label class="control-label col-sm-offset-2">11 </label>
                                            </div>
                                            <div class="col-sm-6">
                                                <label>Target TKT (1-9)</label>
                                            </div>
                                            <div class="col-sm-1">
                                                <label class="control-label col-sm-offset-2"> 5</label>
                                            </div>
                                            <div class="col-sm-1">
                                                <div class="col-sm-12 input-group input-group-sm">
                                                    <input type="text" class="form-control" name="kriteria11" id="kriteria11" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-1">
                                                <div class="col-sm-12 input-group input-group-sm">
                                                    <input type="text" class="form-control" name="nilai11" id="nilai11" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-sm-1">
                                                <label class="control-label col-sm-offset-2"></label>
                                            </div>
                                            <div class="col-sm-6">
                                                <label>Jumlah</label>
                                            </div>
                                            <div class="col-sm-1">
                                                <label class="control-label col-sm-offset-2"> 100</label>
                                            </div>
                                            <div class="col-sm-1">
                                                
                                            </div>
                                            <div class="col-sm-1">
                                               
                                            </div>
                                            
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-sm-2">
                                                <label class="control-label col-sm-offset-1 pull-right">Komentar</label>
                                            </div>
                                            <div class="col-sm-8">

                                                <textarea class="form-control" rows="2" placeholder="Komentar..." name="komentar" id="komentar"   cols="50" required></textarea>

                                            </div>
                                        </div>
                                        <br>
                            
                                        
                                        <div class="modal-footer">
                                         <button onclick="lanjutSubtansi()" type="button" class="btn btn-success pull-right" name="simpan" id="simpan"><span class="ion ion-android-exit" ></span> Simpan
                                        </div>
                                    </form>
                            </div>
                           
                        </div>

                    </div>
                </div>  
                <div class="row">
                    <div class="col-sm-12">
                        <label class="control-label pull-left"> Keterangan: </label><br>
                        <h6>
                        <br>- Nilai = Bobot x Skor
                        <br>- Nomor 1-6 berlaku skor: 1, 2, 3, 5, 6, 7 (1 = Buruk; 2 = Sangat kurang; 3 = Kurang; 5 = Cukup; 6 = Baik; 7 = Sangat baik)
                        <br>- Nomor 7 berlaku skor: 1,5,6,7 Protipe (1 = tidak ada; 5 = P1 ; 6 = P2; 7 = P3)
                        <br>- Nomor 8 berlaku skor: 1,5,7 (1 = tidak ada; 5 = ada mitra, tapi bukan mitra produktif; 7 = ada mitra produktif)
                        <br>- Nomor 9 berlaku skor: Kemutakhiran literatur (5 tahun terakhir): Tidak ada pustaka primer (1 = Buruk); Pustaka tergolong primer dan mutakhir <50% (3 = Kurang); Pustaka tergolong primer dan mutakhir sejumlah 51-80% (5 = Cukup); Pustaka tergolong primer dan mutakhir >80% (7 = Sangat baik)
                        <br>- Nomor 10 berlaku skor: 1,5,7 Keterlibatan Mahasiswa (1= tidak  ada mhs; 5 = 1 mhs; dan 7= ≥ 2 mhs)
                        <br>- Nomor 11 berlaku skor: 1,5,7 untuk TKT (1 = TKT tidak ada, 5 = TKT ada tetapi tidak sesuai, 7 = TKT ada dan sesuai)
                        <br>- Tema Riset : Mohon dilingkari : 1. Kemandirian Pangan dan Sumberdaya Alam 2. Energi Baru, Terbarukan, Material Maju, Teknologi Informasi dan Komunikasi, 3.  Pengembangan Teknologi Kesehatan dan Obat, 4. Kemaritiman dan Pengembangan Wilayah Pesisir Dan Perikanan, 5. Pengelolaan Lahan Gambut, 6. Manajemen Pencegahan dan Penanggulangan Bencanaan 7. Sosial Humaniora Seni Budaya, Pendidikan dan Hukum.
                        <br>- P1: prototipe laboratorium; P2: prototipe yang telah memenuhi konsep sebagai produk atau teknologi; P3: prototipe yang telah memenuhi konsep sebagai produk atau teknologi yang terstandarisasi</h6>
                    </div>
                </div>
                <br>
    

                <form class="form-horizontal" method="POST" action="{{ route('hasilreviewer.index') }}">
                {{ csrf_field() }} {{ method_field('GET') }}
                
                <div class="form-group row">
                    <div class="col-md-8 ">
                        <button type="submit" class="btn btn-default pull-left">
                          <span class="fa fa-reply fa-fw"></span>
                            Kembali
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection

@section('script')
    <script type="text/javascript">
     function resumeberkas(id) {
        window.location = "{{route('hasilreviewer.resume', '')}}/"+id;
    }
    function getLatar() {
        var _token     = $('input[name = "_token"]').val();
         $.ajax({
            url: "{{ route('hasilreviewer.nilai', $prop->id) }}",
            method: "POST",
            dataType: "json",
            data: {_token: _token},
            success: function(result)
            {
                if (result) {
                    $('#komentar').val(result[0]);
                    $('#kriteria1').val(result[1]);
                    $('#kriteria2').val(result[2]);
                    $('#kriteria3').val(result[3]);
                    $('#kriteria4').val(result[4]);
                    $('#kriteria5').val(result[5]);
                    $('#kriteria6').val(result[6]);
                    $('#kriteria7').val(result[7]);
                    $('#kriteria8').val(result[8]);
                    $('#kriteria9').val(result[9]);
                    $('#kriteria10').val(result[10]);
                    $('#kriteria11').val(result[11]);
                    $('#nilai1').val(result[12]);
                    $('#nilai2').val(result[13]);
                    $('#nilai3').val(result[14]);
                    $('#nilai4').val(result[15]);
                    $('#nilai5').val(result[16]);
                    $('#nilai6').val(result[17]);
                    $('#nilai7').val(result[18]);
                    $('#nilai8').val(result[19]);
                    $('#nilai9').val(result[20]);
                    $('#nilai10').val(result[21]);
                    $('#nilai11').val(result[22]);
                    
                }
                             
            },
            error : function() {
                swal(
                    'Terjadi Kesalahan!',
                    'Gagal mengunduh data',
                    'error'
                );
            }
        });
    }

    function lanjutSubtansi() {
        var prosalid  = $('#id').val();
        var kriteria1  = $('#kriteria1').val();
        var kriteria2  = $('#kriteria2').val();
        var kriteria3  = $('#kriteria3').val();
        var kriteria4  = $('#kriteria4').val();
        var kriteria5  = $('#kriteria5').val();
        var kriteria6  = $('#kriteria6').val();
        var kriteria7  = $('#kriteria7').val();
        var kriteria8  = $('#kriteria8').val();
        var kriteria9  = $('#kriteria9').val();
        var kriteria10  = $('#kriteria10').val();
        var kriteria11  = $('#kriteria11').val();
        var nilai1  = $('#nilai1').val();
        var nilai2  = $('#nilai2').val();
        var nilai3  = $('#nilai3').val();
        var nilai4  = $('#nilai4').val();
        var nilai5  = $('#nilai5').val();
        var nilai6  = $('#nilai6').val();
        var nilai7  = $('#nilai7').val();
        var nilai8  = $('#nilai8').val();
        var nilai9  = $('#nilai9').val();
        var nilai10  = $('#nilai10').val();
        var nilai11  = $('#nilai11').val();
        var komentar  = $('#komentar').val();
        var _token     = $('input[name = "_token"]').val();

        $.ajax({
            url: "{{ route('hasilreviewer.store') }}",
            method: "POST",
            data: {prosalid: prosalid,kriteria1: kriteria1,kriteria2: kriteria2,kriteria3: kriteria3,kriteria4: kriteria4,kriteria5: kriteria5,kriteria6: kriteria6,kriteria7: kriteria7,kriteria8: kriteria8,kriteria9: kriteria9,kriteria10: kriteria10,kriteria11: kriteria11,
            nilai1: nilai1,nilai2: nilai2,nilai3: nilai3,nilai4: nilai4,nilai5: nilai5,nilai6: nilai6,nilai7: nilai7,nilai8: nilai8,nilai9: nilai9,nilai10: nilai10,nilai11: nilai11,komentar: komentar,  _token: _token},
            success: function(result)
            {
                swal({
                    title: 'Selamat!',
                    text: "Data Berhasil Disimpan",
                    type: 'success',
                    confirmButtonColor: '#5bc0de',
                    cancelButtonColor: '#f0ad4e',
                    confirmButtonText: 'Ok!',
                }).then(function(isConfirm) {
                        if (isConfirm) {
                            window.location = "{{ route('hasilreviewer.index') }}";

                        }
                    }
                );
            },
            error : function() {
                swal(
                    'Terjadi Kesalahan!',
                    'Tidak dapat menyimpan data',
                    'error'
                );

            }
        });
    }

        $(document).ready(function() {
            getLatar();
            var total1
            var total2
            var total3
            var total4
            var total5
            var total6
            var total7
            var total8
            var total9
            var total10
            var total11
            $("#kriteria1").keyup(function() {
                total1 = $("#kriteria1").val()*10;
                $("#nilai1").val(total1);
            });
            $("#kriteria2").keyup(function() {
                total2 = $("#kriteria2").val()*15;
                $("#nilai2").val(total2);
            });
            $("#kriteria3").keyup(function() {
                total3 = $("#kriteria3").val()*10;
                $("#nilai3").val(total3);
            });
            $("#kriteria4").keyup(function() {
                total4 = $("#kriteria4").val()*10;
                $("#nilai4").val(total4);
            });
            $("#kriteria5").keyup(function() {
                total5 = $("#kriteria5").val()*10;
                $("#nilai5").val(total5);
            });
            $("#kriteria6").keyup(function() {
                total6 = $("#kriteria6").val()*15;
                $("#nilai6").val(total6);
            });
            $("#kriteria7").keyup(function() {
                total7 = $("#kriteria7").val()*15;
                $("#nilai7").val(total7);
            });
            $("#kriteria8").keyup(function() {
                total8 = $("#kriteria8").val()*5;
                $("#nilai8").val(total8);
            });
            $("#kriteria9").keyup(function() {
                total9 = $("#kriteria9").val()*5;
                $("#nilai9").val(total9);
            });
            $("#kriteria10").keyup(function() {
                total10 = $("#kriteria10").val()*5;
                $("#nilai10").val(total10);
            });
            $("#kriteria11").keyup(function() {
                total11 = $("#kriteria11").val()*5;
                $("#nilai11").val(total11);
            });


        });


    </script>
@endsection