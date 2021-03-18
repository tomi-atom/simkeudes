@extends('layouts.app')

@section('title')
    Identitas Pengusul
@endsection

@section('breadcrumb')
    @parent
    <li><a href="{{ route('penelitianng.index') }}">Penelitian</a></li>
    <li>Pengusul</li>
    <li>Anggota</li>
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
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                      <input type="button" class="btn btn-success pull-right" id="tambah" name="tambah" value="Tambah"/>
                    </div>
                </div>

                 <p></p>
                
                <div class="panel panel-default" id="personel" style="display: none;">
                    <div class="panel-body"><strong>Identitas Pengusul - Anggota Pelaksana Penelitian Baru </strong></div>
            
                    <div class="panel-footer">
                    <form class="form form-horizontal form-anggota" method="POST" >
                        {{ csrf_field() }}
                        <input type="hidden" name="dosenid" id="dosenid" value="{{ $proposalid }}" readonly>
                        <input type="hidden" name="propsid" id="propsid" value="{{ $idskemapro }}" readonly>

                        <div class="row">
                            <div class="col-sm-2">
                                <label class="control-label col-sm-offset-1">NIDN</label>
                            </div>
                            <div class="col-sm-2">
                                <div class="input-group input-group-sm">
                                    <input type="text" class="form-control" name="nidn" id="nidn" readonly required>
                                    <span class="input-group-btn">
                                        <button onclick="showAnggota()" type="button" class="btn btn-warning btn-flat"><span class="fa fa-search fa-fw"></span></button>
                                    </span>
                                </div>
                            </div>
                        </div> 
                        <input type="hidden" name="hid" id="hid" readonly>
                        
                        <br>
                        <div class="form-group row" id="detaildosen">
                        </div>
                        <p></p>

                        <div class="row">
                            <div class="col-sm-2">
                                <label class="control-label col-sm-offset-1 pull-right">Peran</label>
                            </div>
                            <div class="col-sm-4">
                                <div class="col-sm-12 input-group input-group-sm">
                                    <select id="peran" class="form-control" name="peran" required>
                                        <option value=""> -- Pilih Peran --</option>
                                        <option value="1"> Anggota Pengusul 1</option>
                                        <option value="2"> Anggota Pengusul 2</option>

                                        <option value="3"> Anggota Pengusul 3</option>
                                        <option value="4"> Anggota Pengusul 4</option>
                                     
                                    </select>
                                </div>
                            </div>
                        </div> 
                        <p></p>
                        <div class="row">
                            <div class="col-sm-2">
                                <label class="control-label col-sm-offset-1">Tugas Dalam Kegiatan</label>
                            </div>
                            <div class="col-sm-10">
                                
                                    <textarea class="form-control" rows="2" placeholder="Deskripsi tugas dalam penelitian ..." name="judul" id="judul" required></textarea>
                               
                            </div>
                        </div>
                    </form> 
                    <br>
                        <div class="row">
                            <div class="col-md-11">
                                
                                <button onclick="saveAnggota('{{ $proposalid }}')" type="button" class="btn btn-success pull-right" name="simpan" id="simpan"><span class="fa fa-floppy-o fa-fw"></span>Simpan
                                </button>
                            </div>
                            <div class="col-md-1">
                                <button type="button" class="btn btn-warning pull-right" id="batal"><i class="fa fa-arrow-circle-left"></i> Batal </button>

                            </div>
                        </div>
                        
                    </div>
                </div>  

                <div class="panel panel-default" id="senarai">
                    <div class="panel-heading"><strong>Identitas Pengusul - Anggota Pelaksana Penelitian </strong><font size="1"><span class="label label-danger"></span></font></div>
            
                    <div class="panel-body">
                        <table class="table table-condensed tabel-depan" id="tbdepan">
                                                   
                        </table> 
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12">
                        <a href="{{route('validasipenelitian.show', base64_encode(mt_rand(10,99).($proposalid*2+29)))}}" class="btn btn-default pull-left" name="awal" id="awal"><span class="fa fa-reply fa-fw"></span> Kembali</a> 
                        <a href="#" class="btn btn-primary pull-right" name="lanjut" id="lanjut"><span class="ion ion-android-exit"></span> PERBAHARUI</a> 
                    </div>
                </div>

            </div>
        </div>

        
    </div>
</div>

@include ('penelitianng.anggota.formanggota')
@endsection

@section('script')
<script type="text/javascript">
    var tabel;

    function loadanggota() {
        var _token = $('input[name = "_token"]').val();
        table = $('.tabel-anggota').DataTable({
            "processing" : true,
            "serverside" : true,
            "ajax" : {
                "url" : "{{ route('penelitianng.list',$idx)}}",
                "type" : "POST",
                "data" : {"_token" : _token},

            }
        });

    }

    function tampildata() {
        var select = $("#dosenid").val();
           
        var _token = $('input[name = "_token"]').val();
            
        $.ajax({
            url: "{{ route('penelitianng.data') }}",
            method: "POST",
            data: {select: select, _token: _token},
            success: function(result)
            {
                $('#tbdepan').html(result);
            }
        });
    }

    $(document).ready(function() {
        tampildata();
        loadanggota(); 

        $("#batal").click(function() {
            $('#tambah').show();
            $('#lanjut').show();
            $('#senarai').show();
            $('#personel').hide();
        });
         
        $("#tambah").click(function() {
            var x = document.getElementById('personel');
            var propos = $("#propsid").val();


            var oRows = document.getElementById('tbdepan').getElementsByTagName('tr');
            var iRowCount = oRows.length;

            var max=5;
            if (propos > 3)
                max = 5;

            if (iRowCount > max) {
                swal(
                    'Anggota penelitian !',
                    'telah melebihi batas kuota maksimum!',
                    'error'
                );
                $("#tambah").attr('disabled', true);
            }
            else {   
            if (x.style.display === "none") {
                x.style.display = "block";
                $('#tambah').hide();
                $('#senarai').hide();
                $('#lanjut').hide();

                $('#peran').prop('selectedIndex',0);
                $('#judul').val('');

                $("#simpan").attr('disabled', false);
            } else {
                x.style.display = "none";
                $('#tambah').show();
                $('#senarai').show();
                $('#lanjut').show();

            } 
            }
          
            selectAnggota(0).load(); 
        });

        $("#lanjut").click(function() {
            var propos = $("#propsid").val();
            var select = $("#dosenid").val();
            var oRows  = document.getElementById('tbdepan').getElementsByTagName('tr');
            var iRowCount = oRows.length;

            var max=5;
            if (propos > 3)
                max = 5;

            if (iRowCount > max+1) {
                swal(
                    'Anggota penelitian !',
                    'telah melebihi batas kuota maksimum!',
                    'error'
                );
                $("#tambah").attr('disabled', true);
            }
            else{
                swal({
                    title: 'Selamat!',
                    text: "Data Berhasil Diperbaharui",
                    type: 'success',
                    confirmButtonText: 'OK',
                }).then(function(isConfirm) {
                        if (isConfirm) {
                            window.location = "{{ route('validasipenelitian.show', base64_encode(mt_rand(10,99).($proposalid*2+29))) }}";

                        }
                    }
                );
            }

        });
    });

    $('.form-anggota').on('submit',function() {
        return false;
    });

    $("#peran").change(function() {
        if (($("#peran").val()) && ($('#judul').val()))
            $("#simpan").attr('disabled', false);
        else
            $("#simpan").attr('disabled', true);
    });

    $("#judul").keyup(function() {
        if (($("#peran").val()) && ($('#judul').val()))
            $("#simpan").attr('disabled', false);
        else
            $("#simpan").attr('disabled', true);
    });

    function showAnggota() {
        $('#modal-anggota').modal('show');
    }

    function selectAnggota(id, kode) {
        $('#hid').val(id);
        $('#nidn').val(kode);

        var idx = id;
        var _token = $('input[name = "_token"]').val();
        $.ajax({
            url: "{{ route('penelitianng.detail') }}",
            method: "POST",
            data: {idx: idx, _token: _token},
            success: function(result)
            {
                $('#detaildosen').html(result);
                if (result != '') {
                    $("#peran").attr('disabled', false);    
                    $("#judul").attr('disabled', false); 
                }
            },
            error : function() {
                swal(
                    'Terjadi Kesalahan!',
                    'Data Gagal Disimpan',
                    'error'
                );
            }
        });

        $('#modal-anggota').modal('hide');
        $("#peran").attr('disabled', true);    
        $("#judul").attr('disabled', true);    
        $("#simpan").attr('disabled', true);       
    }

    function saveAnggota($id) {
        var x = document.getElementById('senarai');
        if (x.style.display === "none") {
            x.style.display = "block";
            $('#tambah').show();
            $('#lanjut').show();
            $('#personel').hide();
        } else {
            x.style.display = "none";
            $('#tambah').hide();
            $('#lanjut').hide();
            $('#personel').show();
                
        }   
        
        var propid = $id;
        var select = $("#hid").val();
        var _token = $('input[name = "_token"]').val();
        var peran  = $("#peran").val();
        var tugas  = $("#judul").val();
        $.ajax({
            url: "{{ route('penelitianng.anggota.store',".id.") }}",
            method: "POST",
            data: {propid: propid, select: select, _token: _token, peran: peran, tugas: tugas},
            success: function(result)
            {
                swal(
                    'Selamat!',
                    'Data Berhasil Disimpan',
                    'success'
                );
                tampildata().load();

            },
            error : function() {
                swal(
                    'Terjadi Kesalahan!',
                    'Gagal Menyimpan Data',
                    'error'
                );
            }
        });
    }

    function deleteData($id) {
        swal({
            title: 'Anda Yakin?',
            text: "Apakah yakin keanggotaan peserta penelitian akan dihapus?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#5bc0de',
            cancelButtonColor: '#f0ad4e',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then(function(isConfirm) {
                if (isConfirm) {

                    $.ajax({
                        url  : "{{route('penelitianng.anggota.destroy',[59,''])}}/"+$id,
                        type : "POST",
                        data : {'_method' : 'DELETE', '_token' : $('input[name = "_token"]').val()},
                        success : function(data) {
                            swal(
                                'Selamat!',
                                'Data Berhasil Dihapus',
                                'success'
                            );
                            tampildata().load();
                        },
                        error : function() {
                            swal(
                                'Terjadi Kesalahan!',
                                'Data Gagal Dihapus',
                                'error'
                            );
                        }

                    });
                }
            }
        );

    }
</script>
@endsection