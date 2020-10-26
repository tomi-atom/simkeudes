@extends('layouts.app')

@section('title')
    Ringkasan Usulan Penelitian
@endsection

@section('breadcrumb')
    @parent
    <li><a href="{{ route('penelitian.index') }}">Penelitian</a></li>
    <li>Pengusul</li>
    <li>Rangkuman</li>
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
                                <h4 class="box-title">Pengusul: {{$ketua->nama}}</h4>
                            </div>
                            
                            <div class="box-body">
                            <div class="box-header with-border">
              <h3 class="box-title">Bordered Table</h3>
            </div>
            <br>
              <div class="table-responsive">
                <table class="table table-bordered">
                  <thead>
                  <tr>
                    <th width="5%">No</th>
                    <th width="60%">Item Pemeriksaan</th>
                    <th width="20%">Status</th>
                    <th width="15%">Statistik</th>
                  </tr>
                  </thead>
                  <tbody>
                  <tr>
                    <td>1</a></td>
                    <td>Call of Duty IV</td>
                    <td><span class="label label-success">Shipped</span></td>
                    <td>
                      <div class="sparkbar" data-color="#00a65a" data-height="20">90,80,90,-70,61,-83,63</div>
                    </td>
                  </tr>
                  <tr>
                    <td>OR1848</a></td>
                    <td>Samsung Smart TV</td>
                    <td><span class="label label-warning">Pending</span></td>
                    <td>
                      <div class="sparkbar" data-color="#f39c12" data-height="20">90,80,-90,70,61,-83,68</div>
                    </td>
                  </tr>
                  <tr>
                    <td>OR7429</a></td>
                    <td>iPhone 6 Plus</td>
                    <td><span class="label label-danger">Delivered</span></td>
                    <td>
                      <div class="sparkbar" data-color="#f56954" data-height="20">90,-80,90,70,-61,83,63</div>
                    </td>
                  </tr>
                  <tr>
                    <td>OR7429</a></td>
                    <td>Samsung Smart TV</td>
                    <td><span class="label label-info">Processing</span></td>
                    <td>
                      <div class="sparkbar" data-color="#00c0ef" data-height="20">90,80,-90,70,-61,83,63</div>
                    </td>
                  </tr>
                  <tr>
                    <td>OR1848</a></td>
                    <td>Samsung Smart TV</td>
                    <td><span class="label label-warning">Pending</span></td>
                    <td>
                      <div class="sparkbar" data-color="#f39c12" data-height="20">90,80,-90,70,61,-83,68</div>
                    </td>
                  </tr>
                  <tr>
                    <td>OR7429</a></td>
                    <td>iPhone 6 Plus</td>
                    <td><span class="label label-danger">Delivered</span></td>
                    <td>
                      <div class="sparkbar" data-color="#f56954" data-height="20">90,-80,90,70,-61,83,63</div>
                    </td>
                  </tr>
                  <tr>
                    <td>OR9842</a></td>
                    <td>Call of Duty IV</td>
                    <td><span class="label label-success">Shipped</span></td>
                    <td>
                      <div class="sparkbar" data-color="#00a65a" data-height="20">90,80,90,-70,61,-83,63</div>
                    </td>
                  </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.table-responsive -->
            </div>
            <div class="box-footer clearfix">
              <a href="javascript:void(0)" class="btn btn-sm btn-info btn-flat pull-left">Place New Order</a>
              <a href="javascript:void(0)" class="btn btn-sm btn-default btn-flat pull-right">View All Orders</a>
            </div>
                            <hr>
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
                                        <b>Total Anggaran Tahun 1 - Rp {{format_uang($thnr + $tbhn + $tjln + $tbrg)}},-</b> dari Rp {{format_uang($prop->skema->dana)}},- pagu maksimum.
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
                                            @foreach ($hnr as $list) 
                                            <tr {{$total += $list->volume * $list->biaya}}>
                                                <td class="text-left" colspan="4">&nbsp;&nbsp;&nbsp;&nbsp;{{++$no}}. {{$list->item}}</td>
                                                <td class="text-center">{{$list->satuan}}</td>
                                                <td class="text-center">{{$list->volume}}</td>
                                                <td class="text-center">{{format_uang($list->biaya)}}</td>
                                                <td class="text-right">Rp {{format_uang($list->volume * $list->biaya)}},-</td>
                                            </tr>
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
                                            @foreach ($bhn as $list) 
                                            <tr {{$total += $list->volume * $list->biaya}}>
                                                <td class="text-left" colspan="4">&nbsp;&nbsp;&nbsp;&nbsp;{{++$no}}. {{$list->item}}</td>
                                                <td class="text-center">{{$list->satuan}}</td>
                                                <td class="text-center">{{$list->volume}}</td>
                                                <td class="text-center">{{format_uang($list->biaya)}}</td>
                                                <td class="text-right">Rp {{format_uang($list->volume * $list->biaya)}},-</td>
                                            </tr>
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
                                            @foreach ($jln as $list) 
                                            <tr {{$total += $list->volume * $list->biaya}}>
                                                <td class="text-left" colspan="4">&nbsp;&nbsp;&nbsp;&nbsp;{{++$no}}. {{$list->item}}</td>
                                                <td class="text-center">{{$list->satuan}}</td>
                                                <td class="text-center">{{$list->volume}}</td>
                                                <td class="text-center">{{format_uang($list->biaya)}}</td>
                                                <td class="text-right">Rp {{format_uang($list->volume * $list->biaya)}},-</td>
                                            </tr>
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
                                            @foreach ($brg as $list) 
                                            <tr {{$total += $list->volume * $list->biaya}}>
                                                <td class="text-left" colspan="4">&nbsp;&nbsp;&nbsp;&nbsp;{{++$no}}. {{$list->item}}</td>
                                                <td class="text-center">{{$list->satuan}}</td>
                                                <td class="text-center">{{$list->volume}}</td>
                                                <td class="text-center">{{format_uang($list->biaya)}}</td>
                                                <td class="text-right">Rp {{format_uang($list->volume * $list->biaya)}},-</td>
                                            </tr>
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

                    </div>
                </div>  
                @if ($stat == 1)
                <form class="form-horizontal" method="POST" action="{{ route('penelitian.update', base64_encode($idprop)) }}">
                {{ csrf_field() }} {{method_field('PATCH')}}
                
                <div class="form-group row">
                    <div class="col-md-8 col-md-offset-4">
                        <button type="submit" class="btn btn-success pull-right">
                          <span class="ion ion-paper-airplane"></span>
                            SUBMIT
                        </button>
                    </div>
                </div>
                </form>
                @else
                <form class="form-horizontal" method="POST" action="{{ route('penelitian.index') }}">
                {{ csrf_field() }} {{ method_field('GET') }}
                
                <div class="form-group row">
                    <div class="col-md-8 ">
                        <button type="submit" class="btn btn-default pull-left">
                          <span class="fa fa-reply fa-fw"></span>
                            Kembali
                        </button>
                    </div>
                </div>
                @endif
            </div>
        </div>

    </div>
</div>

@endsection