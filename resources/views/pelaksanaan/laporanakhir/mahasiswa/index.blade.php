@extends('layouts.app')

@section('title')
    Identitas Pengusul
@endsection

@section('breadcrumb')
    @parent
    <li><a >Pengabdian</a></li>
    <li>Pengusul</li>
    <li>Mahasiswa</li>
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
                <div class="row">
                    <div class="col-md-12">
                      <input type="button"  onclick="showLuaran()"  class="btn btn-success pull-right" id="tambah" name="tambah" value="Tambah"/>
                    </div>
                </div>

                 <p></p>
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
                
                <div class="panel panel-default" id="personel" style="display: none;">
                    <div class="panel-body"><strong>Identitas Pengusul - Mahasiswa Pelaksana Pengabdian Baru</strong></div>
            
                    <div class="panel-footer">
                    <form class="form form-horizontal form-anggota" method="POST" >
                        {{ csrf_field() }}
                        <input type="hidden" name="dosenid" id="dosenid" value="{{ $proposalid }}" readonly>
                        <input type="hidden" name="propsid" id="propsid" value="{{ $idskemapro }}" readonly>

                        <div class="row">
                            <div class="col-sm-2">
                                <label class="control-label col-sm-offset-1">NIM</label>
                            </div>
                            <div class="col-sm-6">
                                <div  class=" col-sm-6 input-group input-group-sm">
                                    <input type="text" class="form-control" name="nim" id="nim"required>

                                </div>
                            </div>
                        </div>
                        <p></p>
                        <div class="row">
                            <div class="col-sm-2">
                                <label class="control-label col-sm-offset-1">Nama</label>
                            </div>
                            <div class="col-sm-6">
                                <div class="col-sm-6 input-group input-group-sm">
                                    <input type="text" class="form-control" name="nama" id="nama"required>

                                </div>
                            </div>
                        </div>
                        <p></p>

                        <div class="row">
                            <div class="col-sm-2">
                                <label class="control-label col-sm-offset-1 ">Fakultas</label>
                            </div>
                            <div class="col-sm-4">
                                <div class="col-sm-12 input-group input-group-sm">
                                    <select id="fk" class="form-control" name="fk" required>
                                        <option value=""> -- Pilih Fakultas --</option>
                                        @foreach($fk as $list)
                                            <option value="{{$list->id}}" {{$dosen->idfakultas == $list->id ? 'selected' : ''}}> {{$list->fakultas}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                        </div> 
                        <p></p>
                        <div class="row">
                            <div class="col-sm-2">
                                <label class="control-label col-sm-offset-1 ">Jenis KelamingFakultas</label>
                            </div>
                            <div class="col-sm-4">
                                <div class="col-sm-12 input-group input-group-sm">
                                    <select id="fk" class="form-control" name="fk" required>
                                        <option value=""> -- Pilih Jenis Kelamin --</option>
                                        <option value="1">Laki-Laki</option>
                                        <option value="2">Perempuan</option>

                                    </select>
                                </div>
                            </div>


                        </div>
                    </form> 
                    <br>
                        <div class="row">
                            <div class="modal-footer">
                                <button onclick="simpan()" type="submit" class=" btn btn-success pull-right" name="simpan" id="simpan"><span class="ion ion-android-exit" ></span> Simpan
                            </div>
                            <div class="col-md-1">
                                <button type="button" class="btn btn-warning pull-right" id="batal"><i class="fa fa-arrow-circle-left"></i> Batal </button>

                            </div>
                        </div>
                        
                    </div>
                </div>  

                <div class="panel panel-default" id="senarai">
                    <div class="panel-heading"><strong>Identitas Pengusul - Mahasiswa Kukerta </strong><font size="1"><span class="label label-danger"></span></font></div>
            
                    <div class="panel-body">
                        <table class="table table-condensed tabel-depan" id="tbdepan">
                                                   
                        </table> 
                    </div>
                </div>
                

            </div>
        </div>

        
    </div>
</div>

@include ('pelaksanaan.laporanakhir.mahasiswa.formmahasiswa')
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
                "url" : "{{ route('validasilaporanakhir.mahasiswa.list',$idx)}}",
                "type" : "POST",
                "data" : {"_token" : _token},

            }
        });

    }
    function showLuaran() {

        $('#modal-mahasiswa').find('.modal-title').text('Tambah Mahasiswa..');
        $('#modal-mahasiswa').modal('show');
    }

    function tampildata() {
        var select = $("#dosenid").val();
           
        var _token = $('input[name = "_token"]').val();
            
        $.ajax({
            url: "{{ route('validasilaporanakhir.mahasiswa.data') }}",
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
            $('#modal-mahasiswa').find('.modal-title').text('Tambah Mahasiswa..');
            $('#modal-mahasiswa').modal('show');
        });

        $("#lanjut").click(function() {
            var propos = $("#propsid").val();
            var select = $("#dosenid").val();
            var oRows  = document.getElementById('tbdepan').getElementsByTagName('tr');
            var iRowCount = oRows.length;

            var max=35;

            if (iRowCount > max+1) {
                swal(
                    'Mahasiswa pengabdian !',
                    'telah melebihi batas kuota maksimum!',
                    'error'
                );
                $("#tambah").attr('disabled', true);
            }
            else
                swal({
                    title: 'Selamat!',
                    text: "Data Berhasil Diperbaharui",
                    type: 'success',
                    confirmButtonText: 'OK',
                }).then(function(isConfirm) {
                        if (isConfirm) {
                            window.location = "{{ route('validasilaporanakhir.mahasiswa.index', base64_encode($proposalid+127)) }}";

                        }
                    }
                );

        });
    });

    $('.form-anggota').on('submit',function() {
        return false;
    });

    $("#jk").change(function() {
        if (($("#nim").val()) && ($('#nama').val()))
            $("#simpan").attr('disabled', false);
        else
            $("#simpan").attr('disabled', true);
    });

    $("#fakultas").keyup(function() {
        if (($("#nim").val()) && ($('#nama').val()))
            $("#simpan").attr('disabled', false);
        else
            $("#simpan").attr('disabled', true);
    });

    function showMahasiswa() {
        $('#modal-anggota').modal('show');
    }


    $("#modal-mahasiswa form").validator().on('submit', function(e) {
        if (!e.isDefaultPrevented()) {
            var id = $('#id').val();


            $.ajax ({
                url : "{{ route('validasilaporanakhir.mahasiswa.store', $idskemapro) }}",
                type : "POST",
                data : $('#modal-mahasiswa form').serialize(),
                success : function(data) {
                    swal(
                        'Selamat!',
                        'Data Berhasil Disimpan',
                        'success'
                    );
                    $('#modal-mahasiswa form').hide()
                },
                error : function() {
                    swal(
                        'Terjadi Kesalahan!',
                        'Gagal Menyimpan Data',
                        'error'
                    );
                }
            });
            return false;
        }
    });

    function saveMahasiswa2($id) {

        var propid = $id;

        var _token = $('input[name = "_token"]').val();
        var nim  = $("#nim").val();
        var nama  = $("#nama").val();
        var fakultas  = $("#fakultas").val();
        var jk  = $("#jk").val();
        $.ajax({
            url: "{{ route('validasilaporanakhir.mahasiswa.store',".id.") }}",
            method: "POST",
            data: {propid: propid, select: select, _token: _token, nim: nim, nama: nama, fakultas : fakultas,jk:jk },

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
                    'Data Gagal Disimpan',
                    'error'
                );
            }
        });
    }

    function deleteData($id) {
        swal({
            title: 'Anda Yakin?',
            text: "Apakah yakin keanggotaan peserta pengabdian akan dihapus?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#5bc0de',
            cancelButtonColor: '#f0ad4e',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then(function(isConfirm) {
                if (isConfirm) {

                    $.ajax({
                        url  : "{{route('validasilaporanakhir.mahasiswa.destroy',[59,''])}}/"+$id,
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