@extends('layouts.app')

@section('title')
   Penilaian Pengabdian
@endsection

@section('breadcrumb')
    @parent
  
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
                   <div class="panel-heading"><strong>Periode: {{$periode->tahun}} | Sesi {{$periode->sesi}}</strong></div>
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
                                            <td colspan="8"><b>3. Biaya Pengabdian</b>
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
                                        <td colspan="8"></td>
                                    </tr>
                                    <tr>
                                        <td class="text-left" colspan="4"><b>Total Anggaran</b> </td>
                                        <td class="text-center" colspan="2">  <b>Rp {{format_uang($thnr + $tbhn + $tjln + $tbrg)}},-</b> </td>
                                        <td class="text-center"> Rp {{format_uang($prop->skema->dana * $mata[3]->batas / 100)}},-</td>
                                      
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
                                            <h3 class="modal-title"><a  href=" {{route('pengabdianr.resumeberkas',base64_encode(mt_rand(10,99). $prop->id))}}" class="btn btn-primary " title="Proposal"><i class="glyphicon glyphicon-file"></i>Lihat Proposal </a>   
                                             <a  href=" {{route('pengabdianr.resumeluaran',base64_encode(mt_rand(10,99). $prop->idketua))}}" class="btn btn-success " title="Luaran Sebelumnya"><i class="glyphicon glyphicon-file"></i>Lihat Luaran Sebelumnya </a> 
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
                                            <div class="col-sm-2">
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
                                                <label> Analisis Situasi, identifikasi permasalahan, dan pengelompokan permasalahan  </label>
                                            </div>
                                            <div class="col-sm-1">
                                                <label class="control-label col-sm-offset-2"> 10</label>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="col-sm-12 input-group input-group-sm">
                                                    <select class="form-control" id="kriteria1" name="kriteria1" required>
                                                        <option value=""> -  </option>
                                                        <option value="1"> Buruk  </option>
                                                        <option value="2"> Sangat Kurang  </option>
                                                        <option value="3"> Kurang  </option>
                                                        <option value="5"> Cukup </option>
                                                        <option value="6"> Baik </option>
                                                        <option value="7"> Sangat Baik</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-1">
                                                <div class="col-sm-12 input-group input-group-sm">
                                                    <input type="text" class="form-control" value="0" name="nilai1" id="nilai1" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-sm-1">
                                                <label class="control-label col-sm-offset-2">2 </label>
                                            </div>
                                            <div class="col-sm-6">
                                                <label>Ketajaman latar belakang, analisis, kejelasan peta jalan (Roadmap) </label>
                                            </div>
                                            <div class="col-sm-1">
                                                <label class="control-label col-sm-offset-2"> 10</label>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="col-sm-12 input-group input-group-sm">
                                                    <select class="form-control" id="kriteria2" name="kriteria2" required>
                                                        <option value=""> -  </option>
                                                        <option value="1"> Buruk  </option>
                                                        <option value="2"> Sangat Kurang  </option>
                                                        <option value="3"> Kurang  </option>
                                                        <option value="5"> Cukup </option>
                                                        <option value="6"> Baik </option>
                                                        <option value="7"> Sangat Baik</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-1">
                                                <div class="col-sm-12 input-group input-group-sm">
                                                    <input type="text" class="form-control" value="0" name="nilai2" id="nilai2" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-sm-1">
                                                <label class="control-label col-sm-offset-2">3 </label>
                                            </div>
                                            <div class="col-sm-6">
                                                <label> Kemutakhiran Literatur </label>
                                            </div>
                                            <div class="col-sm-1">
                                                <label class="control-label col-sm-offset-2"> 5</label>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="col-sm-12 input-group input-group-sm">
                                                    <select class="form-control" id="kriteria3" name="kriteria3" required>
                                                        <option value=""> -  </option>
                                                        <option value="1"> Buruk  </option>
                                                        <option value="2"> Sangat Kurang  </option>
                                                        <option value="3"> Kurang  </option>
                                                        <option value="5"> Cukup </option>
                                                        <option value="6"> Baik </option>
                                                        <option value="7"> Sangat Baik</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-1">
                                                <div class="col-sm-12 input-group input-group-sm">
                                                    <input type="text" class="form-control" value="0"  name="nilai3" id="nilai3" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-sm-1">
                                                <label class="control-label col-sm-offset-2">4 </label>
                                            </div>
                                            <div class="col-sm-6">
                                                <label>Potensi terciptanya produk unggulan mitra </label>
                                            </div>
                                            <div class="col-sm-1">
                                                <label class="control-label col-sm-offset-2"> 20</label>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="col-sm-12 input-group input-group-sm">
                                                    <select class="form-control" id="kriteria4" name="kriteria4" required>
                                                        <option value=""> -  </option>
                                                        <option value="7"> Ada  </option>
                                                        <option value="1"> Tidak Ada</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-1">
                                                <div class="col-sm-12 input-group input-group-sm">
                                                    <input type="text" class="form-control" value="0"  name="nilai4" id="nilai4" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-sm-1">
                                                <label class="control-label col-sm-offset-2">5 </label>
                                            </div>
                                            <div class="col-sm-6">
                                                <label>Tersedianya calon wirausaha baru mandiri</label>
                                            </div>
                                            <div class="col-sm-1">
                                                <label class="control-label col-sm-offset-2"> 20</label>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="col-sm-12 input-group input-group-sm">
                                                    <select class="form-control"  id="kriteria5" name="kriteria5" required>
                                                        <option value=""> -  </option>
                                                        <option value="7"> Ada  </option>
                                                        <option value="1"> Tidak Ada</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-1">
                                                <div class="col-sm-12 input-group input-group-sm">
                                                    <input type="text" class="form-control" value="0"  name="nilai5" id="nilai5" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-sm-1">
                                                <label class="control-label col-sm-offset-2">6 </label>
                                            </div>
                                            <div class="col-sm-6">
                                                <label>Keterapan kekayaan intelektual (Paten, Hak Cipta, Merek, dan sebagainya)</label>
                                            </div>
                                            <div class="col-sm-1">
                                                <label class="control-label col-sm-offset-2"> 30</label>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="col-sm-12 input-group input-group-sm">
                                                    <select class="form-control" id="kriteria6" name="kriteria6" required>
                                                        <option value=""> -  </option>
                                                        <option value="7"> Ada  </option>
                                                        <option value="1"> Tidak Ada</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-1">
                                                <div class="col-sm-12 input-group input-group-sm">
                                                    <input type="text" class="form-control" value="0"  name="nilai6" id="nilai6" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-sm-1">
                                                <label class="control-label col-sm-offset-2">7 </label>
                                            </div>
                                            <div class="col-sm-6">
                                                <label>Kesesuai RAB dengan lokasi pengabdian</label>
                                            </div>
                                            <div class="col-sm-1">
                                                <label class="control-label col-sm-offset-2"> 5</label>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="col-sm-12 input-group input-group-sm">
                                                    <select class="form-control" id="kriteria7" name="kriteria7" required>
                                                        <option value=""> -  </option>
                                                        <option value="1"> Buruk  </option>
                                                        <option value="2"> Sangat Kurang  </option>
                                                        <option value="3"> Kurang  </option>
                                                        <option value="5"> Cukup </option>
                                                        <option value="6"> Baik </option>
                                                        <option value="7"> Sangat Baik</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-1">
                                                <div class="col-sm-12 input-group input-group-sm">
                                                    <input type="text" class="form-control" value="0"  name="nilai7" id="nilai7" readonly>
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
                                            <div class="col-sm-2">
                                                
                                            </div>
                                            <div class="col-sm-1">
                                                <input type="text" class="form-control" value="0" name="totalnilai" id="totalnilai" readonly>
                                            </div>
                                            
                                        </div>
                                        <br>
                                        <br>
                                          <div class="row">
                                            <div class="col-sm-1">
                                                <label class="control-label col-sm-offset-2"></label>
                                            </div>
                                            <div class="col-sm-6">
                                                <label>Kelayakan Proposal</label>
                                            </div>
                                            <div class="col-sm-1">
                                                <label class="control-label col-sm-offset-2"> </label>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="col-sm-12 input-group input-group-sm" >
                                                    <select class="form-control"  id="kelayakan" name="kelayakan" required  style="display: none" >
                                                    
                                                        <option value="1"> Layak  </option>
                                                        <option value="2"> Tidak Layak  </option>
                                                       
                                                    </select>
                                                </div>
                                               <h4> <span class="label label-success" id="layak" name="layak" >LAYAK</span> 
                                                <span class="label label-danger" id="tidaklayak" name="tidaklayak" hidden>TIDAK LAYAK</span> </h4>
                                                
                                            </div>

                                        </div>
                                         <br>
                                        <br>
                                        <div class="row" id="anggaran" name="anggaran">
                                             <div class="col-sm-1">
                                                <label class="control-label col-sm-offset-2"></label>
                                            </div>
                                             <div class="col-sm-6">
                                                <label>Jumlah Anggaran yang  direkomendasikan(Rp) <code> Pagu Maksimum  {{format_uang($prop->skema->dana * $mata[1]->batas / 100)}}</code></label>
                                            </div>
                                            <div class="col-sm-1">
                                                <label class="control-label col-sm-offset-2"> </label>
                                            </div>
                                            
                                            <div class="col-sm-3 input-group">
                                                <span class="input-group-addon"><b>Rp.</b></span>
                                                <input type="number"  class="form-control "  name="rekomdana" id="rekomdana" value=""><br>
                                                  
                                               

                                            </div>
                                          
                                        </div>
                                        <br>
                                        <br>
                                        <div class="row">
                                          
                                           <div class="col-sm-1">
                                                <label class="control-label col-sm-offset-2"></label>
                                            </div>
                                             <div class="col-sm-3">
                                                <label>Komentar</label>
                                            </div>
                                            <div class="col-sm-1">
                                                <label class="control-label col-sm-offset-2"> </label>
                                            </div>
                                            <div class="col-sm-6">

                                                <textarea class="form-control" rows="2" placeholder="Komentar..." name="komentar" id="komentar"   cols="50"></textarea>

                                            </div>
                                            
                                        </div>
                                        <br>
                            
                                        
                                        <div class="modal-footer">
                                         <button onclick="lanjutSubtansi()"  type="button" class=" btn btn-success pull-right" name="simpan" id="simpan"><span class="ion ion-android-exit" ></span> Simpan
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
                       <br>Nomor 1-7 berlaku skor : 1, 2, 3, 5, 6, 7 (1 = Buruk; 2 = Sangat kurang; 3 = Kurang; 5 = Cukup; 6 = Baik; 7 = Sangat baik); 
                       <br> Nomor 8 berlaku skor : 1,7 (1=tidak  ada, 7=ada);
                        <br>Nomor 9 berlaku skor : 1,5,6,7 Keterlibatan Mahasiswa (1= tidak  ada mhs; 5= <8 mhs; 6=8-10 mhs; dan 7= >10 mhs);
                        <br>Nilai = Bobot x Skor

 	                    <br>Tema pengabdian: Mohon dilingkari: 1. Pengembangan Wilayah Wetlands; 2. Pengembangan Perkebunan dan Peningkatan Ketahanan Pangan di Wilayah Wetlands; 3. Pengelolaan Sumberdaya Alam dan Lingkungan di Wilayah Wetlands,  4. Pengembangan Pariwisata dan Ekonomi Kreatif di Wilayah Wetlands

                        </h6>
                    </div>
                </div>
                <br>
    

                <form class="form-horizontal" method="POST" action="{{ route('pengabdianr.index') }}">
                {{ csrf_field() }} {{ method_field('GET') }}
                
                <div class="form-group row">
                    <div class="col-md-8 ">
                        <button type="submit" class=" btn btn-default pull-left">
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
        window.location = "{{route('penelitianng.resume', '')}}/"+id;
    }
    function getLatar() {
        var _token     = $('input[name = "_token"]').val();
         $.ajax({
            url: "{{ route('pengabdianr.nilai', $prop->id) }}",
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
                   
                    

                    $('#nilai1').val(result[12]);
                    $('#nilai2').val(result[13]);
                    $('#nilai3').val(result[14]);
                    $('#nilai4').val(result[15]);
                    $('#nilai5').val(result[16]);
                    $('#nilai6').val(result[17]);
                    $('#nilai7').val(result[18]);
                  
                    $('#rekomdana').val(result[23]);
                     $('#kelayakan').val(result[24]);
                     if(result[24] == 1){
                          $("#layak").show();
                          $("#tidaklayak").hide();
                          $("#anggaran").show();
                     }else{
                          $("#layak").hide();
                          $("#tidaklayak").show();
                          $("#anggaran").hide();
                     }


                    var totalnilai = result[12]+result[13]+result[14]+result[15]+result[16]+result[17]+result[18];
                    $('#totalnilai').val(totalnilai);

                    
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
       
       
        var nilai1  = $('#nilai1').val();
        var nilai2  = $('#nilai2').val();
        var nilai3  = $('#nilai3').val();
        var nilai4  = $('#nilai4').val();
        var nilai5  = $('#nilai5').val();
        var nilai6  = $('#nilai6').val();
        var nilai7  = $('#nilai7').val();
      
        var rekomdana  = $('#rekomdana').val();
        var komentar  = $('#komentar').val();
        var kelayakan  = $('#kelayakan').val();
        var _token     = $('input[name = "_token"]').val();

       if(kriteria1 != "" && kriteria2 != "" && kriteria3 != "" && kriteria4 != "" && kriteria5 != "" && kriteria6 != "" && kriteria7 != ""   ){
               
               if(kelayakan == "1")
               {
                   if(rekomdana == ""){
                      swal(
                        'Data Belum Lengkap!',
                        'Rekomendasi Dana Harus di isi',
                        'error'
                         ); 
                   }else if(rekomdana > {{$prop->skema->dana * $mata[1]->batas / 100}}){
                        swal(
                        'Rekomendasi Melebihi Pagu!',
                        'Rekomendasi Dana Tidak Boleh Melebihi Pagu Maksimum',
                        'error'
                         ); 
                   }
                   else{
                         
                           $.ajax({
                            url: "{{ route('pengabdianr.store') }}",
                            method: "POST",
                            data: {prosalid: prosalid,kriteria1: kriteria1,kriteria2: kriteria2,kriteria3: kriteria3,kriteria4: kriteria4,kriteria5: kriteria5,kriteria6: kriteria6,kriteria7: kriteria7,
                            nilai1: nilai1,nilai2: nilai2,nilai3: nilai3,nilai4: nilai4,nilai5: nilai5,nilai6: nilai6,nilai7: nilai7,rekomdana: rekomdana,komentar: komentar,kelayakan: kelayakan,  _token: _token},
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
                                            window.location = "{{ route('pengabdianr.index') }}";
                
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
               }else if(kelayakan == "2"){
                    if(komentar == ""){
                      swal(
                        'Data Belum Lengkap!',
                        'Komentar Harus di isi',
                        'error'
                         ); 
                   }else{
                         
                           $.ajax({
                            url: "{{ route('pengabdianr.store') }}",
                            method: "POST",
                            data: {prosalid: prosalid,kriteria1: kriteria1,kriteria2: kriteria2,kriteria3: kriteria3,kriteria4: kriteria4,kriteria5: kriteria5,kriteria6: kriteria6,kriteria7: kriteria7,
                            nilai1: nilai1,nilai2: nilai2,nilai3: nilai3,nilai4: nilai4,nilai5: nilai5,nilai6: nilai6,nilai7: nilai7,rekomdana: rekomdana,komentar: komentar,kelayakan: kelayakan,  _token: _token},
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
                                            window.location = "{{ route('pengabdianr.index') }}";
                
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
               }
               
                
        }else{
           swal(
                    'Data Belum Lengkap!',
                    'Semua data Harus di di isi',
                    'error'
                );
        }
    }

        $(document).ready(function() {
            getLatar();
            function hitung() {
                // var totalnilai = Number(nilai1+ nilai2+ nilai3+ nilai4+ nilai5+ nilai6+ nilai7+ nilai8+ nilai9+ nilai10);
                var totalnilai = Number (parseFloat($('#nilai1').val()) 
                + parseFloat($('#nilai2').val())
                + parseFloat($('#nilai3').val())
                + parseFloat($('#nilai4').val())
                + parseFloat($('#nilai5').val())
                + parseFloat($('#nilai6').val())
                + parseFloat($('#nilai7').val())
                
                 );
                
                 $("#totalnilai").val(totalnilai);
                 if(totalnilai >= 401){
                     $("#kelayakan").val(1);
                     $("#layak").show();
                     $("#tidaklayak").hide();
                      $("#anggaran").show();
                }else{
                      $("#kelayakan").val(2);
                      $("#layak").hide();
                    $("#tidaklayak").show();
                     $("#anggaran").hide();
                }
            }
            var total1
            var total2
            var total3
            var total4
            var total5
            var total6
            var total7
            var total8
            var total9
           
            $("#kriteria1").change(function() {
                total1 = $("#kriteria1").val()*10;
                $("#nilai1").val(total1);
                hitung();
            });
            $("#kriteria2").change(function() {
                total2 = $("#kriteria2").val()*10;
                $("#nilai2").val(total2);
                hitung();
            });
            $("#kriteria3").change(function() {
                total3 = $("#kriteria3").val()*5;
                $("#nilai3").val(total3);
                hitung();
            });
            $("#kriteria4").change(function() {
                total4 = $("#kriteria4").val()*20;
                $("#nilai4").val(total4);
                hitung();
            });
            $("#kriteria5").change(function() {
                total5 = $("#kriteria5").val()*20;
                $("#nilai5").val(total5);
                hitung();
            });
            $("#kriteria6").change(function() {
                total6 = $("#kriteria6").val()*30;
                $("#nilai6").val(total6);
                hitung();
            });
            $("#kriteria7").change(function() {
                total7 = $("#kriteria7").val()*5;
                $("#nilai7").val(total7);
                hitung();
            });
           
           

        });


    </script>
@endsection