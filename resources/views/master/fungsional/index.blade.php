@extends('layouts.app')

@section('title')
    Mata Anggaran
@endsection

@section('breadcrumb')
    @parent
    <li><a href="{{ route('fungsional.index') }}">Master</a></li>
    <li>Mata Angaran</li>
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading"> <div class="pull-right"><strong></strong></div></div>
            
            <div class="panel-body">
                <br>
                
                <div class="panel panel-default">
                    <div class="panel-heading"><strong>Daftar Mata Anggaran  </strong><div class="pull-right"><strong></strong></div></div>
                    <div class="panel-body">
                        <div class="box-header with-border">
                            <button type="button" onclick="showLuaran(1)" class="btn btn-primary pull-right" name="tambah" id="tambah"><i class="fa fa-plus-square-o"></i> Tambah</button>
                        </div>
                        <br> 
                        <table class="table table-bordered tabel-fungsional" id="tbfungsional">
                                                   
                        </table>        
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@include('master.fungsional.formfungsional')
@endsection

@section('script')
<script type="text/javascript">




    $(document).ready(function() {

        tampil()

    });
    function tampil() {
        var select = $("#id").val();
        var _token = $('input[name = "_token"]').val();


        $.ajax({
            url: "{{ route('showfungsional') }}",
            method: "POST",
            data: {select: select, _token: _token},

            success: function(result)
            {
                $('#tbfungsional').html(result);
            }

        });
    }

    function showLuaran(id) {
        $('#jenis').val("");
        $('#batas').val("");
        $('#aktif').val("");

        $('#modal-fungsional').modal('show');
    }

    function editMataAnggaran($id) {
        $.ajax({
            url : "{{ route('edit') }}/"+$id,
            type: "GET",

            dataType: "JSON",
            success: function(data)
            {

                $('[name="id"]').val(data.id);
                $('[name="jenis"]').val(data.jenis);
                $('[name="batas"]').val(data.batas);
                $('[name="aktif"]').val(data.aktif);

                //$('[name="klasifikasi"]').val(data.klasifikasi);

                // $('[name="unggah"]').val(data.unggah);

                showLuaran($id)

            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });

    }

    function hapusMataAnggaran($id) {
        if (confirm("Apakah yakin mata fungsional dari kegiatan ini akan dihapus?")) {
            $.ajax({
                url  : "{{ route('destroy') }}/"+$id,
                type : "POST",
                data : {'_method' : 'DELETE', '_token' : $('input[name = "_token"]').val()},
                success : function(data) {
                    tampil().load();

                },
                error : function() {
                    alert("Tidak dapat menghapus data");
                }

            });
        }
    }

    $("#modal-fungsional").validator().on('submit', function(e) {
        if (!e.isDefaultPrevented()) {

            $.ajax ({
                url : "{{ route('fungsional.store') }}",
                type : "POST",
                data : $('#modal-fungsional form').serialize(),
                success : function(data) {
                    $('#modal-fungsional').modal('hide');

                    tampil().load();

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