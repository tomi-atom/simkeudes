@extends('layouts.app')

@section('title')
    Rincian Anggaran
@endsection

@section('breadcrumb')
    @parent
    <li><a href="{{ route('penelitian.index') }}">Penelitian</a></li>
    <li>Pengusul</li>
    <li>RAB</li>
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
                <a href="{{ route('penelitian.resume', base64_encode('1'.$idprop)) }}" class="btn btn-success pull-right" name="lanjut" id="lanjut"><span class="fa fa-angle-double-right fa-fw"></span>LANJUTKAN</a>
                                
            </div>
        </div>

        
    </div>
</div>
@include('penelitian.formbiaya')
@endsection

@section('script')
<script type="text/javascript">
    function tampilTotal() {
        var select = $("#id").val();
        var _token = $('input[name = "_token"]').val();

        $.ajax({
            url: "{{ route('penelitian.tampiltotal') }}",
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
            url: "{{ route('penelitian.tampilhonor') }}",
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
            url: "{{ route('penelitian.tampilbahan') }}",
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
            url: "{{ route('penelitian.tampiljalan') }}",
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
            url: "{{ route('penelitian.tampilbarang') }}",
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
        $('#item').val("");
        $('#satuan').val("");
        $('#volume').val("");
        $('#biaya').val("");
        $('#total').val("0");

        $('#modal-biaya').modal('show');
    }

    function editAnggaran($id, $kode) {

    }

    function hapusAnggaran($id, $kode) {
        if (confirm("Apakah yakin mata anggaran dari kegiatan ini akan dihapus?")) {
            $.ajax({
                url  : "{{ route('penelitian.hapusanggaran','') }}/"+$id,
                type : "POST",
                data : {'_method' : 'DELETE', '_token' : $('input[name = "_token"]').val()},
                success : function(data) {
                    
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
                    alert("Tidak dapat menghapus data");
                }

            });
        }
    }

    $("#modal-biaya form").validator().on('submit', function(e) {
        if (!e.isDefaultPrevented()) {
            var id = $('#id').val();
            var jenis = $('#belanja').val();
            $.ajax ({
                url : "{{ route('penelitian.simpanrab') }}",
                type : "POST",
                data : $('#modal-biaya form').serialize(),
                success : function(data) {
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
                    alert("Tidak dapat menyimpan data!..")
                }
            });
            return false;
        }
    });

</script>
@endsection