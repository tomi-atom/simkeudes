@extends('layouts.app')

@section('title')
	Luaran Proposal Usulan
@endsection

@section('breadcrumb')
	@parent
    <li><a href="{{ route('pengabdian.index') }}">Pengabdian</a></li>
    <li>Pengusul</li>
    <li>Luaran</li>
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
                <a href="#" class="btn btn-success pull-right" name="lanjut" id="lanjut"><span class="fa fa-angle-double-right fa-fw"></span>LANJUTKAN</a>
                                
            </div>
        </div>

        
    </div>
</div>
@include('penelitian.formluaran')
@endsection

@section('script')
<script type="text/javascript">
    function tampilLuarWajib() {
        var select = $("#id").val();
        var _token = $('input[name = "_token"]').val();

        $.ajax({
             url: "{{ route('pengabdian.tampilluarwjb') }}",
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
            url: "{{ route('pengabdian.tampilluaradd') }}",
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
                alert("Luaran wajib kegiatan belum terpenuhi!");
            }
            else {
                window.location = "{{ route('pengabdian.rab', base64_encode($idprop+5)) }}";
            }
        });
    });

    function tampilTarget() {
        var idtarget = $("#jenis").val();
        var _token   = $('input[name = "_token"]').val();
        $.ajax({
            url: "{{ route('penelitian.target') }}",
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
                url : "{{ route('penelitian.simpanluaran') }}",
                type : "POST",
                data : $('#modal-luaran form').serialize(),
                success : function(data) {
                    $('#modal-luaran').modal('hide');
                    if (jenis == 1) {
                        tampilLuarWajib().load();
                    }
                    else if (jenis == 2) {
                        tampilLuarTambah().load();
                    }

                },
                error : function() {
                    alert("Tidak dapat menyimpan data!..")
                }
            });
            return false;
        }
    });

    function deleteData($id) {
        if (confirm("Apakah yakin luaran dari kegiatan ini akan dihapus?")) {
            $.ajax({
                url  : "{{ route('penelitian.hapusluar','') }}/"+$id,
                type : "POST",
                data : {'_method' : 'DELETE', '_token' : $('input[name = "_token"]').val()},
                success : function(data) {
                    
                    tampilLuarTambah().load();
                },
                error : function() {
                    alert("Tidak dapat menghapus data");
                }

            });
        }
    }

</script>
@endsection