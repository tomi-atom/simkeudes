@extends('layouts.app')

@section('title')
    Luaran Proposal Usulan
@endsection

@section('breadcrumb')
    @parent
    <li><a href="{{ route('perbaikanpenelitianng.index') }}">Penelitian</a></li>
    <li>Pengusul</li>
    <li>Luaran</li>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/sweetalert2/1.3.3/sweetalert2.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/sweetalert2/0.4.5/sweetalert2.css">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/sweetalert2/1.3.3/sweetalert2.min.js"></script>
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading"><strong>Luaran dan Target Capaian</strong> <div class="pull-right"><strong></strong></div></div>
            
            <div class="panel-body">
                <div class="box-header with-border">
                    <button type="button" onclick="showLuaran()"" class="btn btn-primary pull-right" id="artikel" name="tambah" id="tambah"><i class="fa fa-plus-square-o"></i> Tambah</button>
                </div>
                <br>
                
                <div class="panel panel-default">
                    <div class="panel-heading"><strong>Luaran Wajib: </strong></div>
                    <div class="panel-body">
                        <br>
                        <table class="table table-condensed tabel-atas" id="tbatas">                       
                        </table>    
                    </div>
                </div>

            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-body">
                <div class="panel panel-default">
                    <div class="panel-heading"><strong>Luaran Tambahan: </strong></div>
            
                    <div class="panel-body">
                        <br>
                        <table class="table table-condensed tabel-bawah" id="tbbawah">                       
                        </table>    
                    </div>
                </div>
            </div>
        </div>
      
        <div class="row">
            <div class="col-md-12">
                <a href="{{route('validasiperbaikanpenelitian.show', base64_encode(mt_rand(10,99).($idprop*2+29)))}}" class="btn btn-default pull-left" name="awal" id="awal"><span class="fa fa-reply fa-fw"></span> Kembali</a>
                <a href="#" class="btn btn-primary pull-right" name="lanjut" id="lanjut"><span class="ion ion-android-exit"></span> PERBAHARUI</a>             
            </div>
        </div>

        
    </div>
</div>
@include('perbaikanpenelitianng.luaran.formluaran')
@endsection

@section('script')
<script type="text/javascript">
    function tampilLuarWajib() {
        var select = $("#id").val();
        var _token = $('input[name = "_token"]').val();

        $.ajax({
             url: "{{ route('perbaikanpenelitianng.wajib') }}",
            method: "POST",
            data: {select: select, _token: _token},
            success: function(result)
            {
                $('#tbatas').html(result);
            }
        });
    }

    function tampilLuarTambah() {
        var select = $("#id").val();
        var _token = $('input[name = "_token"]').val();

        $.ajax({
            url: "{{ route('perbaikanpenelitianng.tambah') }}",
            method: "POST",
            data: {select: select, _token: _token},
            success: function(result)
            {
                $('#tbbawah').html(result);
            }
        });
    }

    $(document).ready(function() {
        tampilLuarWajib();
        tampilLuarTambah();

        $("#lanjut").click(function() {
            var oRows = document.getElementById('tbatas').getElementsByTagName('tr');
            var iRowCount = oRows.length;

            
            if (iRowCount < 3) {
                swal(
                    'Terjadi Kesalahan!',
                    'Luaran wajib kegiatan belum terpenuhi!',
                    'error'
                );
            }
            else {
                swal({
                    title: 'Selamat!',
                    text: "Data Berhasil Diperbaharui",
                    type: 'success',
                    confirmButtonColor: '#5bc0de',
                    confirmButtonText: 'OK!',
                }).then(function(isConfirm) {
                        if (isConfirm) {
                            window.location = "{{ route('validasiperbaikanpenelitian.show', base64_encode(mt_rand(10,99).($idprop*2+29))) }}";
                        }
                    }
                );

            }
        });
    });

    function tampilTarget() {
        var idtarget = $("#jenis").val();
        var _token   = $('input[name = "_token"]').val();
        $.ajax({
            url: "{{ route('perbaikanpenelitianng.target') }}",
            method: "POST",
            data: {idtarget: idtarget, _token: _token},
            success: function(result)
            {
                $("#target").html(result);
            }
        });
    }

    function showLuaran() {
        $('#kategori').prop('selectedIndex',0);
        $('#jenis').prop('selectedIndex',0);
        $('#target').prop('selectedIndex',0);
        $('#jurnal').val("");
        $('#linkurl').val("");

        $('#hjurnal').hide();
        $('#hlinkurl').hide(); 

        $('#modal-luaran').modal('show');
    }

    $("#jenis").change(function() {
        tampilTarget();

        if (($("#jenis").val() >= 1) && ($("#jenis").val() <= 3)) {
            $('#hjurnal').show();
            $('#hlinkurl').show();

            $('#ljurnal').text("Nama Jurnal");
            $('#jurnal').val("");
            $('#linkurl').val("");
        }
        else if (($("#jenis").val() >= 4) && ($("#jenis").val() <= 9)) {
            $('#hjurnal').show();
            $('#ljurnal').text("Nama Konferensi");

            $('#jurnal').val("");
            $('#linkurl').val("");
            $('#hlinkurl').hide();
        }
        else
        {
            $('#jurnal').val("");
            $('#linkurl').val("");

            $('#hjurnal').hide();
            $('#hlinkurl').hide();   
        }

    });

    $("#modal-luaran form").validator().on('submit', function(e) {
        if (!e.isDefaultPrevented()) {
            var id = $('#id').val();
            var jenis = $('#kategori').val();
            $.ajax ({
                url : "{{ route('perbaikanpenelitianng.luaran.store', $idprop) }}",
                type : "POST",
                data : $('#modal-luaran form').serialize(),
                success : function(data) {
                    swal(
                        'Selamat!',
                        'Data Berhasil Disimpan',
                        'success'
                    );
                    $('#modal-luaran').modal('hide');
                    if (jenis == 1) {
                        tampilLuarWajib().load();
                    }
                    else if (jenis == 2) {
                        tampilLuarTambah().load();
                    }

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

    function deleteData(id) {
        swal({
            title: 'Anda Yakin?',
            text: "Apakah yakin luaran dari kegiatan ini akan dihapus?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#5bc0de',
            cancelButtonColor: '#f0ad4e',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then(function(isConfirm) {
                if (isConfirm) {

                    $.ajax({
                        url  : "{{ route('perbaikanpenelitianng.luaran.destroy',[29,'']) }}/"+id,
                        type : "POST",
                        data : {'_method' : 'DELETE', '_token' : $('input[name = "_token"]').val()},
                        success : function(data) {
                            swal(
                                'Selamat!',
                                'Data Berhasil Dihapus',
                                'success'
                            );
                            tampilLuarWajib().load();
                            tampilLuarTambah().load();
                        },
                        error : function() {
                            swal(
                                'Terjadi Kesalahan!',
                                'Tidak dapat menghapus data',
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