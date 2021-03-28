@extends('layouts.app')

@section('title')
    Rincian Anggaran
@endsection

@section('breadcrumb')
    @parent
    <li><a href="{{ route('perbaikanpenelitianng.index') }}">Penelitian</a></li>
    <li>Pengusul</li>
    <li>RAB</li>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/sweetalert2/1.3.3/sweetalert2.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/sweetalert2/0.4.5/sweetalert2.css">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/sweetalert2/1.3.3/sweetalert2.min.js"></script>

@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading"><strong>RAB: Biaya Maksimum Rp. {{format_uang($skema->skema->dana)}}</strong> <div class="pull-right"><strong></strong></div></div>

            <div class="panel-body">
                <br>

                <div class="panel panel-default">
                    <div class="panel-heading"><strong>HONOR:  Maks. Rp. {{format_uang($biaya[0]->batas*$skema->skema->dana/100)}} ({{$biaya[0]->batas}}%) </strong><div class="pull-right"><strong></strong></div></div>
                    <div class="panel-body">
                        <div class="box-header with-border">
                            <button type="button" onclick="showLuaran(1)" class="btn btn-primary pull-right" name="tambah" id="tambah"><i class="fa fa-plus-square-o"></i> Tambah</button>
                        </div>
                        <br>
                        <table class="table table-bordered tabel-honor" id="tbhonor">

                        </table>
                    </div>
                </div>

            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-body">
                <div class="panel panel-default">
                    <div class="panel-heading"><strong>BELANJA BAHAN: Maks. Rp. {{format_uang($biaya[1]->batas*$skema->skema->dana/100)}} ({{$biaya[1]->batas}}%) </strong><div class="pull-right"><strong></strong></div></div>

                    <div class="panel-body">
                        <div class="box-header with-border">
                            <button type="button" onclick="showLuaran(2)" class="btn btn-primary pull-right" name="tambah" id="tambah"><i class="fa fa-plus-square-o"></i> Tambah</button>
                        </div>
                        <br>
                        <table class="table table-bordered tabel-bahan" id="tbbahan">

                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-body">
                <div class="panel panel-default">
                    <div class="panel-heading"><strong>BELANJA PERJALANAN: Maks. Rp. {{format_uang($biaya[2]->batas*$skema->skema->dana/100)}} ({{$biaya[2]->batas}}%) </strong><div class="pull-right"><strong></strong></div></div>

                    <div class="panel-body">
                        <div class="box-header with-border">
                            <button type="button" onclick="showLuaran(3)" class="btn btn-primary pull-right" name="tambah" id="tambah"><i class="fa fa-plus-square-o"></i> Tambah</button>
                        </div>
                        <br>
                        <table class="table table-bordered tabel-jalan" id="tbjalan">

                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-body">
                <div class="panel panel-default">
                    <div class="panel-heading"><strong>BELANJA BARANG NON-OPERATIONAL: Maks. Rp. {{format_uang($biaya[3]->batas*$skema->skema->dana/100)}} ({{$biaya[3]->batas}}%) </strong><div class="pull-right"><strong></strong></div></div>

                    <div class="panel-body">
                        <div class="box-header with-border">
                            <button type="button" onclick="showLuaran(4)" class="btn btn-primary pull-right" name="tambah" id="tambah"><i class="fa fa-plus-square-o"></i> Tambah</button>
                        </div>
                        <br>
                        <table class="table table-bordered tabel-barang" id="tbbarang">

                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel panel-primary">
            <div class="panel-body"><strong></strong> <div class="pull-right"><h3><strong id="itotal"></strong></h3></div></div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <a href="{{route('validasiperbaikanpenelitian.show', base64_encode(mt_rand(10,99).($idprop*2+29)))}}" class="btn btn-default pull-left" name="awal" id="awal"><span class="fa fa-reply fa-fw"></span> Kembali</a>
                <a href="{{ route('validasiperbaikanpenelitian.show', base64_encode(mt_rand(10,99).($idprop*2+29)))}}" class="btn btn-primary pull-right" name="lanjut" id="lanjut"><span class="ion ion-android-exit"></span> PERBAHARUI</a>
            </div>
        </div>


    </div>
</div>
@include('perbaikanpenelitianng.anggaran.formanggaran')
@endsection

@section('script')
<script type="text/javascript">
    function tampilTotal() {
        var select = $("#id").val();
        var _token = $('input[name = "_token"]').val();

        $.ajax({
            url: "{{ route('perbaikanpenelitianng.showtotal') }}",
            method: "POST",
            data: {select: select, _token: _token},
            success: function(result)
            {
                $('#itotal').html(result);
            }
        });
    }

    function tampilHonor() {
        var select = $("#id").val();
        var _token = $('input[name = "_token"]').val();

        $.ajax({
            url: "{{ route('perbaikanpenelitianng.showhonor') }}",
            method: "POST",
            data: {select: select, _token: _token},
            success: function(result)
            {
                $('#tbhonor').html(result);
            }
        });
        tampilTotal();
    }

    function tampilBahan() {
        var select = $("#id").val();
        var _token = $('input[name = "_token"]').val();

        $.ajax({
            url: "{{ route('perbaikanpenelitianng.showbahan') }}",
            method: "POST",
            data: {select: select, _token: _token},
            success: function(result)
            {
                $('#tbbahan').html(result);
            }
        });
        tampilTotal();
    }

    function tampilJalan() {
        var select = $("#id").val();
        var _token = $('input[name = "_token"]').val();

        $.ajax({
            url: "{{ route('perbaikanpenelitianng.showjalan') }}",
            method: "POST",
            data: {select: select, _token: _token},
            success: function(result)
            {
                $('#tbjalan').html(result);
            }
        });
        tampilTotal();
    }

    function tampilBarang() {
        var select = $("#id").val();
        var _token = $('input[name = "_token"]').val();

        $.ajax({
            url: "{{ route('perbaikanpenelitianng.showbarang') }}",
            method: "POST",
            data: {select: select, _token: _token},
            success: function(result)
            {
                $('#tbbarang').html(result);
            }
        });
        tampilTotal();
    }


    $(document).ready(function() {
        var total
        $("#volume").keyup(function() {
            if ($("#biaya").val() == '')
                total = 0;
            else
                total = $("#biaya").val()*$("#volume").val();

            $("#total").val(total);
        });

        $("#biaya").keyup(function() {
            if ($("#volume").val() == '')
                total = 0;
            else
                total = $("#volume").val()*$("#biaya").val();

            $("#total").val(total);
            //$("#total").val("{{format_uang("+350000")}}");
        });

        tampilHonor();
        tampilBahan();
        tampilJalan();
        tampilBarang();

    });

    function showLuaran(id) {
        $('#belanja').prop('selectedIndex',id);
        $('#idanggaran').val("");
        $('#item').val("");
        $('#satuan').val("");
        $('#volume').val("");
        $('#biaya').val("");
        $('#total').val("0");

        $('#modal-biaya').find('.modal-title').text('Tambah Anggaran Biaya..');
        $('#modal-biaya').modal('show');
    }

    function editAnggaran($id, $kode) {

        $.ajax({

            url  : "{{ route('penelitiananggaran.edit','') }}/"+$id,
            type : "POST",
            data : {'_method' : 'GET', '_token' : $('input[name = "_token"]').val()},

            success: function (result) {

                if (result.success) {
                    let json = jQuery.parseJSON(result.data);

                    $('#idanggaran').val(json.id);
                    $('#belanja').val(json.anggaranid);
                    $('#item').val(json.item);
                    $('#satuan').val(json.satuan);
                    $('#volume').val(json.volume);
                    $('#biaya').val(json.biaya);
                    var total = json.biaya*json.volume
                    $('#total').val(total);

                    $('#modal-biaya').find('.modal-title').text('Perbaharui Anggaran Biaya..');
                    $('#modal-biaya').modal('show');


                }

            },
            error : function() {
                swal(
                    'Terjadi Kesalahan!',
                    'Tidak dapat mengambil data',
                    'error'
                );
            }

        });

    }

    function hapusAnggaran($id, $kode) {
        swal({
            title: 'Anda Yakin?',
            text: "Apakah yakin mata anggaran dari kegiatan ini akan dihapus?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#5bc0de',
            cancelButtonColor: '#f0ad4e',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then(function(isConfirm) {
                if (isConfirm) {

                    $.ajax({
                        url  : "{{ route('perbaikanpenelitianng.anggaran.destroy',[95, '']) }}/"+$id,
                        type : "POST",
                        data : {'_method' : 'DELETE', '_token' : $('input[name = "_token"]').val()},
                        success : function(data) {
                            swal(
                                'Selamat!',
                                'Data Berhasil Dihapus',
                                'success'
                            );
                            if ($kode == 1) {
                                tampilHonor().load();
                            }
                            else if ($kode == 2) {
                                tampilBahan().load();
                            }
                            else if ($kode == 3) {
                                tampilJalan().load();
                            }
                            else {
                                tampilBarang().load();
                            }
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

    $("#modal-biaya form").validator().on('submit', function(e) {
        if (!e.isDefaultPrevented()) {
            var id = $('#id').val();
            var jenis = $('#belanja').val();
            $.ajax ({
                url : "{{ route('perbaikanpenelitianng.anggaran.store', $idprop) }}",
                type : "POST",
                data : $('#modal-biaya form').serialize(),
                success : function(data) {
                    swal(
                        'Selamat!',
                        'Data Berhasil Disimpan',
                        'success'
                    );
                    $('#modal-biaya').modal('hide');
                    if (jenis == 1) {
                        tampilHonor().load();
                    }
                    else if (jenis == 2) {
                        tampilBahan().load();
                    }
                    else if (jenis == 3) {
                        tampilJalan().load();
                    }
                    else {
                        tampilBarang().load();
                    }
                },
                error : function() {
                    swal(
                        'Terjadi Kesalahan!',
                        'Gagal Menyimpan Data, melebihi pagu anggaran',
                        'error'
                    );
                }
            });
            return false;
        }
    });

</script>
@endsection