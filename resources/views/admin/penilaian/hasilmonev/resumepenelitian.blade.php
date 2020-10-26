@extends('layouts.app')

@section('title')
Pertanyaan yang Wajib diisi Reviewer
@endsection

@section('breadcrumb')
    @parent
    <li><a href="{{ route('rn_laporankemajuan.index') }}">Penelitian</a></li>
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
                                                <label> Apakah ada potensi paten/varietas/DTLs yang belum diurus dan bisa di komersialkan?
                                                </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <textarea class="form-control" rows="2" placeholder="Komentar..." name="kriteria1" id="kriteria1"   cols="50" readonly></textarea>

                                            </div>
                                           
                                        </div>
                                    
                                        <br>
                                        <div class="row">
                                            <div class="col-sm-1">
                                                <label class="control-label col-sm-offset-2">2 </label>
                                            </div>
                                            <div class="col-sm-6">
                                                <label>Luaran lain yang sudah dibuat apakah sesuai dengan  jenis dan naskah yang disusun?
                                                </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <textarea class="form-control" rows="2" placeholder="Komentar..." name="kriteria2" id="kriteria2"   cols="50" readonly></textarea>

                                            </div>
                                           
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-sm-1">
                                                <label class="control-label col-sm-offset-2">3 </label>
                                            </div>
                                            <div class="col-sm-6">
                                                <label>Apakah masih ada potensi luaran lain yang belum di buat, seperti?
                                                </label>
                                            </div>
                                           
                                            <div class="col-sm-4">
                                                <div class="col-sm-12 input-group input-group-sm">
                                                    <select class="form-control" disabled="disabled" id="kriteria3" name="kriteria3" readonly>
                                                        <option value=""> -  </option>
                                                        <option value="1"> Model  </option>
                                                        <option value="2"> Teknologi Tepat Guna  </option>
                                                        <option value="3"> Desain  </option>
                                                        <option value="4"> Prototype </option>
                                                        <option value="5"> Kebijakan </option>
                                                        <option value="6"> Karya Seni</option>
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
                                                <label>Apakah penelitian tersebut layak dilanjutkan sesuai dengan  roadmap yang di buat difokuskan pada?
                                                </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <textarea class="form-control" rows="2" placeholder="Komentar..." name="kriteria4" id="kriteria4"   cols="50" readonly></textarea>

                                            </div>
                                           
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-sm-1">
                                                <label class="control-label col-sm-offset-2">5 </label>
                                            </div>
                                            <div class="col-sm-6">
                                                <label>Apakah hasil penelitian sudah masuk dalam kategori?
                                                </label>
                                            </div>
                                          
                                            <div class="col-sm-4">
                                                <div class="col-sm-12 input-group input-group-sm">
                                                    <select class="form-control" disabled="disabled" id="kriteria5" name="kriteria5" readonly>
                                                        <option value=""> -  </option>
                                                        <option value="1"> Prototype R&D  </option>
                                                        <option value="2"> Prototype Industri  </option>
                                                        <option value="3"> Inovasi  </option>
                                                     
                                                    </select>
                                                </div>
                                            </div>
                                           
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-sm-1">
                                                <label class="control-label col-sm-offset-2">6 </label>
                                            </div>
                                            <div class="col-sm-6">
                                                <label>Apakah Penelitian tersebut sudah bisa/layak untuk  dijadikan pengabdian?
                                                </label>
                                            </div>
                                            <div class="col-sm-4">
                                                <textarea class="form-control" rows="2" placeholder="Komentar..." name="kriteria6" id="kriteria6"   cols="50" readonly></textarea>

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
                                                <input type="number"  class="form-control "  name="rekomdana" id="rekomdana" readonly>
                                                <span class="input-group-addon">,00</span>

                                            </div>
                                          
                                        </div>-->
                                       
                                    </form>
                            </div>
                           
                        </div>

                    </div>
                </div>  
                
                <br>
    

                <form class="form-horizontal" method="POST" action="{{ route('rn_laporankemajuan.index') }}">
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
        window.location = "{{route('rn_laporankemajuan.resume', '')}}/"+id;
    }
    function getLatar() {
        var _token     = $('input[name = "_token"]').val();
         $.ajax({
            url: "{{ route('hasilmonev2.nilai', $nilai->id) }}",
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

   
    $(document).ready(function() {
            getLatar();

        });


       

    </script>
@endsection