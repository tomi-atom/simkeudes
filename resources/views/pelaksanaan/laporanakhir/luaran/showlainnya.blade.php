@extends('layouts.app')

@section('title')
    Luaran Lainnya
@endsection

@section('breadcrumb')
    @parent

    <li>Laporan Akhir</li>
    <li>Luaran Lainnya</li>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/sweetalert2/1.3.3/sweetalert2.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/sweetalert2/0.4.5/sweetalert2.css">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/sweetalert2/1.3.3/sweetalert2.min.js"></script>
@endsection

@section('content')
@if($errors->first('error'))
<br>
<div class="row">
    <div class="col col-sm-2">.</div>
    <div class="alert alert-info col-sm-8"><b>{{{ $errors->first('error') }}}</b></div>
</div>
@endif
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading"><strong>Luaran Lainnya dan Capaian</strong> <div class="pull-right"><strong></strong></div></div>
            
            <div class="panel-body">
                <div class="box-header with-border">
                    <button type="button" onclick="showLuaran()"" class="btn btn-primary pull-right" id="artikel" name="tambah" id="tambah"><i class="fa fa-plus-square-o"></i> Tambah</button>
                </div>
                <br>
                
                <div class="panel panel-default">
                    <div class="panel-heading"><strong>Luaran Lainnya: </strong></div>
                    <div class="panel-body">
                        <br>
                        <table class="table table-condensed tabel-atas" id="tbatas">                       
                        </table>    
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <button type="button" onclick="goBack()"" class="btn btn-default pull-left" ><i class="fa  fa-reply fa-fw"></i> Kembali</button>

                    </div>
                </div>
        

            </div>
        </div>

    </div>
</div>
@include('pelaksanaan.laporanakhir.luaran.formluaran')
@endsection

@section('script')
<script type="text/javascript">
    function tampilLuaran() {
        var select = $("#id").val();
        var _token = $('input[name = "_token"]').val();

        $.ajax({
             url: "{{ route('luaranakhir.datalainnya') }}",
            method: "POST",
            data: {select: select, _token: _token},
            success: function(result)
            {
                $('#tbatas').html(result);
            }
        });
    }
    function goBack() 
    {
    window.history.back()
    }

    $(document).ready(function() {
        tampilLuaran();

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
                            window.location = "{{ route('validasilaporanakhir.show', base64_encode(mt_rand(10,99).($idprop*2+29))) }}";
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
            url: "{{ route('luaranakhir.target') }}",
            method: "POST",
            data: {idtarget: idtarget, _token: _token},
            success: function(result)
            {
                $("#target").html(result);
            }
        });
    }

    function showLuaran() {
        $('#kategori').prop('selectedIndex',3);
        $('#jenis').prop('selectedIndex',0);
        $('#target').prop('selectedIndex',0);
        $('#status').prop('selectedIndex',0);
        $('#sinta').prop('selectedIndex',0);
        $('#judul').val("");
        $('#jurnal').val("");
        $('#issn').val("");
        $('#linkurl').val("");
        $('#upload').val("");

        $('#hjurnal').hide();
        $('#hlinkurl').hide(); 

        $('#modal-luaran').modal('show');
    }

    $("#jenis").change(function() {
        tampilTarget();

        if (($("#jenis").val() >= 1) && ($("#jenis").val() <= 3)) {
            $('#hjurnal').show();
            $('#hlinkurl').show();
            $('#hjudul').show();
            $('#hissn').show();
            $('#hsinta').show();
            $('#hstatus').show();

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
             $('#hjudul').show();
            $('#hissn').show();
            $('#hsinta').show();
            $('#hstatus').show();
        }
        else
        {
            $('#jurnal').val("");
            $('#linkurl').val("");
             $('#hjudul').show();
           
             $('#hissn').hide();
            $('#hsinta').hide();
            $('#hstatus').hide();

            $('#hjurnal').hide();
            $('#hlinkurl').hide();   
        }

    });
    function refresh() {
                var table = $('#mytable').DataTable();
                table.ajax.reload(null, false);
            }

    $("#modal-luaran form").validator().on('submit', function(e) {
        if (!e.isDefaultPrevented()) {
            var id = $('#id').val();
            var jenis = $('#kategori').val();
            
            $.ajax ({
                url : "{{ route('luaranakhir.store', $idprop) }}",
                type : "POST",
                data:new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success : function(data) {
                    swal(
                        'Selamat!',
                        'Data Berhasil Disimpan',
                        'success'
                    );
                    $('#modal-luaran').modal('hide');
                    tampilLuaran().load();


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
                        url  : "{{ route('luaranakhir.destroy','') }}/"+id,
                        type : "POST",
                        data : {'_method' : 'DELETE', '_token' : $('input[name = "_token"]').val()},
                        success : function(data) {
                           
                            swal(
                                'Selamat!',
                                'Data Berhasil Dihapus',
                                'success'
                            );
                          
                            tampilLuaran().load();
                           
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