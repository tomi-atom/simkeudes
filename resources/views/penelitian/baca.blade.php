@extends('layouts.app')

@section('title')
    Ringkasan Penelitian
@endsection

@section('breadcrumb')
    @parent
    <li><a href="{{ route('penelitian.index') }}">Penelitian</a></li>
    <li>Ringkasan</li>
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading"><strong></strong> <div class="pull-right"><strong></strong></div></div>
            
            <div class="panel-body">
                
                <div class="panel panel-default">
                    <div class="panel-heading"><strong>Periode: 2019 | Batch 1</strong></div>
            
                    <div class="panel-body">
                        <div class="">
                            <div class="box-header">
                                <i class="ion ion-clipboard"></i>
                                <h4 class="box-title">Pengusul: {{$ketua->nama}}</h4> <br>
                            </div>
                            <br>
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
                                        <td class="text-center" colspan="2">Bidang Fokus RIRN / Bidang Unggulan Perguruan Tinggi</td>
                                        <td class="text-center" colspan="2">Tema</td>
                                        <td class="text-center" colspan="2">Topik (jika ada)</td>
                                        <td class="text-center" colspan="2">Rumpun Bidang Ilmu</td>
                                    </tr> 
                                    <tr>
                                        <td class="text-center" colspan="2">{{$prop->fokus->fokus}}</td>
                                        <td class="text-center" colspan="2">{{$prop->tema->tema}}</td>
                                        <td class="text-center" colspan="2">{{$prop->topik->topik}}</td>
                                        <td class="text-center" colspan="2">{{$prop->rumpun->ilmu3}}</td>
                                    </tr> 
                                    <tr>
                                        <td colspan="8"></td> 
                                    </tr> 
                                    <tr>
                                        <td class="text-center" colspan="2">Kategori</td>
                                        <td class="text-center" colspan="2">Skema Penelitian</td>
                                        <td class="text-center" colspan="2">Strata (Dasar/Terapan/Pengembangan)</td>
                                        <td class="text-center">Target Akhir TKT</td>
                                        <td class="text-center">Lama Penelitian (Tahun)</td>
                                    </tr> 
                                    <tr>
                                        <td class="text-center" colspan="2">{{$prop->program->program}}</td>
                                        <td class="text-center" colspan="2">{{$prop->skema->skema}}</td>
                                        <td class="text-center" colspan="2">SBK Riset Dasar</td>
                                        <td class="text-center">{{$prop->tktakhir}}</td>
                                        <td class="text-center">{{$prop->lama}}</td>
                                    </tr> 
                                    <tr>
                                        <td colspan="8"><br></td> 
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
                                    @foreach($peserta as $anggota)
                                    <tr>
                                        <td class="text-center" colspan="2">{{$anggota->nama}} <br><small class="label label-warning">Anggota Pengusul {{$anggota->peran}}</small></td>
                                        <td class="text-center">{{$anggota->fakultas->sinonim}}  <br>{{$anggota->universitas->pt}}</td>
                                        <td class="text-center">{{$anggota->prodi->prodi}}</td>
                                        <td class="text-center" colspan="2">{{$anggota->tugas}}</td>
                                        <td class="text-center">{{$anggota->sinta}}</td>
                                        <td class="text-center">{{$anggota->hindex}}</td>
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="8"><br></td> 
                                    </tr>   

                                    <tr>
                                        <td colspan="8"><b>3. LUARAN DAN TARGET CAPAIAN</b><br>Luaran Wajib : <small class="label label-success">Tahun ke-{{$thn}}</small> dari {{$prop->lama}} tahun</td> 
                                    </tr> 
                                    <tr>
                                        <td colspan="8"></td> 
                                    </tr> 
                                    <tr>
                                        <td class="text-center" colspan="2">Jenis Luaran</td>
                                        <td class="text-center" colspan="3">Status target capaian (<i>accepted, published, terdaftar atau granted, atau status lainnya</i>)</td>
                                        <td class="text-center" colspan="3">Keterangan (<i>url dan nama jurnal, penerbit, url paten, keterangan sejenis lainnya</i>)</td>
                                    </tr>
                                    @foreach($luarw as $list) 
                                    <tr>
                                        <td class="text-center" colspan="2">{{$list->keluaran->jenis}}</td>
                                        <td class="text-center" colspan="3">{{$list->keluaran->target}}</td>
                                        <td class="text-left" colspan="3">{{$list->publish}} <br> {{$list->urllink}}</td>
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="8"></td> 
                                    </tr> 

                                    <tr>
                                        <td colspan="8">Luaran Tambahan : <small class="label label-success">Tahun ke-{{$thn}}</small> dari {{$prop->lama}} tahun</td> 
                                    </tr> 
                                    <tr>
                                        <td class="text-center" colspan="2">Jenis Luaran</td>
                                        <td class="text-center" colspan="3">Status target capaian (<i>accepted, published, terdaftar atau granted, atau status lainnya</i>)</td>
                                        <td class="text-center" colspan="3">Keterangan (<i>url dan nama jurnal, penerbit, url paten, keterangan sejenis lainnya</i>)</td>
                                    </tr>
                                    @foreach($luart as $list)  
                                    <tr>
                                        <td class="text-center" colspan="2">{{$list->keluaran->jenis}}</td>
                                        <td class="text-center" colspan="3">{{$list->keluaran->target}}</td>
                                        <td class="text-left" colspan="3">{{$list->publish}} <br> {{$list->urllink}}</td>
                                    </tr>
                                     @endforeach
                                    <tr>
                                        <td colspan="8"><br></td>  
                                    </tr> 

                                    <tr>
                                        <td colspan="8"><b>4. ANGGARAN</b><br>
                                        Rencana anggaran biaya PPM mengacu pada PMK yang berlaku dengan besaran minimum dan maksimum sebagaimana diatur pada buku Panduan Penelitian dan Pengabdian kepada Masyarakat Edisi 12.<br>
                                        <b>Total Anggaran Tahun 1 - Rp {{format_uang($thnr + $tbhn + $tjln + $tbrg)}},-</b> dari Rp {{format_uang($prop->skema->dana)}},- pagu maksimum
                                    </tr>
                                    <td colspan="8"></td>  
                                    <tr>
                                        <td class="text-center" colspan="4">Jenis Pembelanjaan</td>
                                        <td class="text-center" colspan="2">Sub-Total Biaya</td>
                                        <td class="text-center">Pagu Maksimum</td>
                                        <td class="text-center">Persentase (%)</td>
                                    </tr> 
                                    <tr>
                                        <td class="text-left" colspan="4">1. HONOR</td>
                                        <td class="text-center" colspan="2">Rp {{format_uang($thnr)}},-</td>
                                        <td class="text-center">Rp {{format_uang($prop->skema->dana * $mata[0]->batas / 100)}},-</td>
                                        <td class="text-center">{{round($thnr / ($prop->skema->dana * $mata[0]->batas / 100) * 100, 2)}}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-left" colspan="4">2. BELANJA BAHAN</td>
                                        <td class="text-center" colspan="2">Rp {{format_uang($tbhn)}},-</td>
                                        <td class="text-center">Rp {{format_uang($prop->skema->dana * $mata[1]->batas / 100)}},-</td>
                                        <td class="text-center">{{round($tbhn / ($prop->skema->dana * $mata[1]->batas / 100) * 100, 2)}}</td>
                                    </tr> 
                                    <tr>
                                        <td class="text-left" colspan="4">3. BELANJA PERJALANAN</td>
                                        <td class="text-center" colspan="2">Rp {{format_uang($tjln)}},-</td>
                                        <td class="text-center">Rp {{format_uang($prop->skema->dana * $mata[2]->batas / 100)}},-</td>
                                        <td class="text-center">{{round($tjln / ($prop->skema->dana * $mata[2]->batas / 100) * 100, 2)}}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-left" colspan="4">4. BELANJA BARANG NON-OPERATIONAL</td>
                                        <td class="text-center" colspan="2">Rp {{format_uang($tbrg)}},-</td>
                                        <td class="text-center">Rp {{format_uang($prop->skema->dana * $mata[3]->batas / 100)}},-</td>
                                        <td class="text-center">{{round($tbrg / ($prop->skema->dana * $mata[3]->batas / 100) * 100, 2)}}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="8">
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

                    </div>
                </div>  
                
                <form class="form-horizontal" method="POST" action="{{ route('penelitian.index') }}">
                {{ csrf_field() }} {{ method_field('GET') }}
                <input type="hidden" name="id" id="id" value="{{ $idprop }}" readonly>

                <div class="form-group row">
                    <div class="col-md-8 ">
                        <button type="submit" class="btn btn-default pull-left">
                          <span class="fa fa-reply fa-fw"></span>
                            Kembali
                        </button>
                    </div>
                </div>
                </form>
              
            </div>
        </div>

    </div>
</div>

@endsection