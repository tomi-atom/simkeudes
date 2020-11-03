@extends('layouts.app')

@section('title')
Pertanyaan yang Wajib diisi Reviewer
@endsection

@section('breadcrumb')
    @parent
    <li><a href="{{ route('rn_laporanakhir.index') }}">Monev Hasil</a></li>
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
                                            <h3 class="modal-title"><a  href=" {{route('rn_laporanakhir.resumeberkas',base64_encode(mt_rand(10,99). $prop->id))}}" class="btn btn-primary " title="Proposal"><i class="glyphicon glyphicon-file"></i>Lihat Laporan Kemajuan </a>                       
                                            </h3>
                                        </div>
                                        <br>
                                        <br>
                                        <div class="row">
                                            <div class="col-sm-1">
                                            </div>
                                            <div class="col-sm-6">
                                                <label class="control-label "> Pertanyaan yang Wajib diisi Reviewer</label>
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="control-label col-sm-offset-2"> Komentar</label>
                                            </div>
                                           
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-sm-1">
                                                <label class="control-label col-sm-offset-2">1 </label>
                                            </div>
                                            <div class="col-sm-6">
                                                <label> Apakah ada penelitian yang sudah dilakukan tim dan relevan dengan pengabdian yang dilaksanakan?
                                                </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <textarea class="form-control" rows="2" placeholder="Komentar..." name="kriteria1" id="kriteria1"   cols="50" required></textarea>

                                            </div>
                                           
                                        </div>
                                    
                                        <br>
                                        <div class="row">
                                            <div class="col-sm-1">
                                                <label class="control-label col-sm-offset-2">2 </label>
                                            </div>
                                            <div class="col-sm-6">
                                                <label>Apakah ada kekayaan intelektual atas nama tim yang diterapkan dalam pengabdian ini?
                                                </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <textarea class="form-control" rows="2" placeholder="Komentar..." name="kriteria2" id="kriteria2"   cols="50" required></textarea>

                                            </div>
                                           
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-sm-1">
                                                <label class="control-label col-sm-offset-2">3 </label>
                                            </div>
                                            <div class="col-sm-6">
                                                <label>Termasuk kategori apa mitra dalam pengabdian ini?
                                                </label>
                                            </div>
                                           
                                            <div class="col-sm-4">
                                                <div class="col-sm-12 input-group input-group-sm">
                                                    <select class="form-control" id="kriteria3" name="kriteria3" required>
                                                        <option value=""> -  </option>
                                                        <option value="1"> Mitra non produktif </option>
                                                        <option value="2"> Mitra yang produktif (IRT/ UMKM)  </option>
                                                        <option value="3"> Mitra CSR/ Pemda/ Industri  </option>
                                                        <option value="4"> Mitra Produksinya meningkat </option>
                                                        <option value="5"> Mitra yang kualitas produknya meningkat </option>
                                                        <option value="6"> Mitra yang berhasil melakukan ekspor atau pemasaran antar pulau</option>
                                                        <option value="7"> Mitra yang menghasilkan usahawan muda</option>
                                                        <option value="8"> Mitra yang omsetnya meningkat</option>
                                                        <option value="9"> Mitra yang tenaga kerjanya meningkat</option>
                                                        <option value="10"> Mitra yang kemampuan manajemennya meningkat</option>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-sm-1">
                                                <label class="control-label col-sm-offset-2">4 </label>
                                            </div>
                                            <div class="col-sm-6">
                                                <label>Apakah  luaran Iptek lain yang diterapkan atau dihasilkan dari pengabdian ini? 
                                                </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="col-sm-12 input-group input-group-sm">
                                                    <select class="form-control" id="kriteria4" name="kriteria4" required>
                                                        <option value=""> -  </option>
                                                        <option value="1"> TTG </option>
                                                        <option value="2"> Model  </option>
                                                        <option value="3"> Prototipe  </option>
                                                        <option value="4"> Karya Desain </option>
                                                        <option value="5"> Seni Kriya, Bangunan dan Arsitektur </option>
                                                    </select>
                                                </div>
                                            </div>
                                           
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-sm-1">
                                                <label class="control-label col-sm-offset-2">5 </label>
                                            </div>
                                            <div class="col-sm-6">
                                                <label>Apakah ada produk tersertifikasi dan/ atau terstandarisasi yang dihasilkan dalam pengabdian ini?
                                                </label>
                                            </div>
                                          
                                            <div class="col-sm-4">
                                                <textarea class="form-control" rows="2" placeholder="Komentar..." name="kriteria5" id="kriteria5"   cols="50" required></textarea>

                                            </div>
                                           
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-sm-1">
                                                <label class="control-label col-sm-offset-2">6 </label>
                                            </div>
                                            <div class="col-sm-6">
                                                <label>Apakah pengabdian ini menghasilkan wirausaha baru dari unsur alumni yang unit bisnisnya di bawah naungan Universitas Riau?
                                                </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <textarea class="form-control" rows="2" placeholder="Komentar..." name="kriteria6" id="kriteria6"   cols="50" required></textarea>

                                            </div>
                                           
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-sm-1">
                                                <label class="control-label col-sm-offset-2">7 </label>
                                            </div>
                                            <div class="col-sm-6">
                                                <label>Apakah ada kekayaan intelektual yang menimbulkan penghasilan dalam pengabdian ini?
                                                </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <textarea class="form-control" rows="2" placeholder="Komentar..." name="kriteria7" id="kriteria7"   cols="50" required></textarea>

                                            </div>
                                           
                                        </div>
                                        <br>
                                     
                                       <!-- <br>
                                        <br>
                                        <div class="row">
                                            <div class="col-sm-2">
                                                <label class="control-label col-sm-offset-1 pull-left">Jumlah Anggaran yang  direkomendasikan(Rp)</label>
                                            </div>
                                            <div class="col-sm-9 input-group">
                                                <span class="input-group-addon"><b>Rp.</b></span>
                                                <input type="number"  class="form-control "  name="rekomdana" id="rekomdana" required>
                                                <span class="input-group-addon">,00</span>

                                            </div>
                                          
                                        </div>-->
                                        
                                        
                                        <div class="modal-footer">
                                         <button onclick="lanjutSubtansi()" type="submit" class=" btn btn-success pull-right" name="simpan" id="simpan"><span class="ion ion-android-exit" ></span> Simpan
                                        </div>
                                    </form>
                            </div>
                           
                        </div>

                    </div>
                </div>  
                
                <br>
    

                <form class="form-horizontal" method="POST" action="{{ route('rn_laporanakhir.index') }}">
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
        window.location = "{{route('rn_laporanakhir.resume', '')}}/"+id;
    }
    function getLatar() {
        var _token     = $('input[name = "_token"]').val();
         $.ajax({
            url: "{{ route('rn2_laporankemajuan.nilai', $prop->id) }}",
            method: "POST",
            dataType: "json",
            data: {_token: _token},
            success: function(result)
            {
                if (result) {
                    $('#kriteria1').val(result[0]);
                    $('#kriteria2').val(result[1]);
                    $('#kriteria3').val(result[2]);
                    $('#kriteria4').val(result[3]);
                    $('#kriteria5').val(result[4]);
                    $('#kriteria6').val(result[5]);
                    $('#kriteria7').val(result[6]);
                  
                  

                    
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
       
      
        var _token     = $('input[name = "_token"]').val();

        $.ajax({
            url: "{{ route('rn2_laporankemajuan.store') }}",
            method: "POST",
            data: {prosalid: prosalid,kriteria1: kriteria1,kriteria2: kriteria2,kriteria3: kriteria3,kriteria4: kriteria4,kriteria5: kriteria5,kriteria6: kriteria6,kriteria7: kriteria7,  _token: _token},
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
                            window.location = "{{ route('rn_laporanakhir.index') }}";

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

        });

    </script>
@endsection