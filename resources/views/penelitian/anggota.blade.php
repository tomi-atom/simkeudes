@extends('layouts.app')

@section('title')
    Identitas Pengusul
@endsection

@section('breadcrumb')
    @parent
    <li><a href="{{ route('penelitian.index') }}">Penelitian</a></li>
    <li>Pengusul</li>
    <li>Anggota</li>
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading"><strong></strong> <div class="pull-right"><strong></strong></div></div>
            
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <input type="button" class="btn btn-success pull-right" id="tambah" name="tambah" value="Tambah" />
                    </div>
                </div>

                 <p></p>
                
                <div class="panel panel-default" id="personel" style="display: none;">
                    <div class="panel-body"><strong>Identitas Pengusul - Anggota Pelaksana Penelitian Baru</strong></div>
            
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
                        <div class="form-group row">
                            <div class="col-sm-2">
                                <label class="control-label"><div class="pull-right image">
                                <img src="{{ asset('public/images/pengguna.jpg') }}" id="idimage" class="img-thumbnail" alt="User Image" style="width:98%"></div>
                                </label>
                            </div>
                            <div class="col-sm-8">
                                <div class="row">
                                    <div class="col-sm-2">
                                        Nama
                                    </div>
                                    <div class="col-sm-9">
                                        : <strong id="nama">-</strong> 
                                    </div>
                                </div>
                                <p></p>
                                <div class="row">
                                    <div class="col-sm-2">
                                        Institusi
                                    </div>
                                    <div class="col-sm-9">
                                        : <strong id="institusi">-</strong> 
                                    </div>
                                </div>
                                <p></p>
                                <div class="row">
                                    <div class="col-sm-2">
                                        Program Studi
                                    </div>
                                    <div class="col-sm-9">
                                        : <strong id="prodi">-</strong> 
                                    </div>
                                </div>
                                <p></p>
                                <div class="row">
                                    <div class="col-sm-2">
                                        Kualifikasi
                                    </div>
                                    <div class="col-sm-9">
                                        : <strong id="kualifikasi">-</strong> 
                                    </div>
                                </div>
                                <p></p>
                                <div class="row">
                                    <div class="col-sm-2">
                                        Alamat Surel
                                    </div>
                                    <div class="col-sm-9">
                                        : <strong><i id="mele"></i></strong> 
                                    </div>
                                </div>
                            </div>
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
                                        @if ($idskemapro < 7) 
                                        <option value="3"> Anggota Pengusul 3</option>
                                        <option value="4"> Anggota Pengusul 4</option>
                                        @endif
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
                            <div class="col-md-12">
                                <button onclick="saveAnggota('{{ $proposalid }}')" type="button" class="btn btn-success pull-right" name="simpan" id="simpan"><span class="fa fa-floppy-o fa-fw"></span>Simpan
                                </button>
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
                        <a href="#" class="btn btn-success pull-right" name="lanjut" id="lanjut"><span class="fa fa-angle-double-right fa-fw"></span>LANJUTKAN</a>
                                
                    </div>
                </div>

            </div>
        </div>

        
    </div>
</div>

@include('penelitian.formanggota')
@endsection

@section('script')
<script type="text/javascript">
    var tabel;

    function tampildata() {
        var select = $("#dosenid").val();
           
        var _token = $('input[name = "_token"]').val();
            
        $.ajax({
             url: "{{ route('penelitian.data') }}",
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
         
        $("#tambah").click(function() {
            var x = document.getElementById('personel');
            var propos = $("#propsid").val();


            var oRows = document.getElementById('tbdepan').getElementsByTagName('tr');
            var iRowCount = oRows.length;

            var max=4;
            if (propos > 3)
                max = 2;

            if (iRowCount > max) {
                alert("Anggota penelitian telah melebihi batas kuota maksimum!");
                $("#tambah").attr('disabled', true);
            }
            else {   
            if (x.style.display === "none") {
                x.style.display = "block";
                $('#tambah').hide();
                $('#senarai').hide();
                $('#lanjut').hide();
                $('#nidn').val('');
                $('#nama').text('');
                $('#institusi').text('');
                $('#prodi').text('');
                $('#kualifikasi').text('');
                $('#mele').text('');
                $('#peran').prop('selectedIndex',0);

                $('#judul').val('');
                $("#simpan").attr('disabled', !$("#simpan").attr('disabled'));

            } else {
                x.style.display = "none";
                $('#tambah').show();
                $('#senarai').show();
                $('#lanjut').show();

            } 
            } 
        });

        $("#lanjut").click(function() {
            var propos = $("#propsid").val();
            var select = $("#dosenid").val();
            var oRows  = document.getElementById('tbdepan').getElementsByTagName('tr');
            var iRowCount = oRows.length;

            var max=4;
            if (propos > 3)
                max = 2;

            if (iRowCount > max+1) {
                alert("Anggota penelitian telah melebihi batas kuota maksimum!");
                $("#tambah").attr('disabled', true);
            }
            else
                window.location = "{{ route('penelitian.subtansi', base64_encode($proposalid)) }}";
            
        });
    });

    $('.form-anggota').on('submit',function() {
        return false;
    });

    $(function(){
        tabel = $('.tabel-anggota').DataTable();
    });

    function showAnggota() {
        $('#modal-anggota').modal('show');
    }

    function selectAnggota($id, $kode, $nm, $ur, $ps, $pd, $em, $ft) {
        $('#hid').val($id);
        $('#nidn').val($kode);
        $('#nama').text($nm);
        $('#institusi').text($ur);
        $('#prodi').text($ps);
        $('#kualifikasi').text($pd);
        $('#mele').text($em);

        document.getElementById("idimage").src = "{{ asset('public/images') }}/"+$ft;
        $('#modal-anggota').modal('hide');

        $("#simpan").attr('disabled', !$("#simpan").attr('disabled'));       
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
            url: "{{ route('penelitian.tambah') }}",
            method: "POST",
            data: {propid: propid, select: select, _token: _token, peran: peran, tugas: tugas},
            success: function(result)
            {
                tampildata().load();
            },
            error : function() {
                alert("Tidak dapat menyimpan data");
            }
        });
    }

    function deleteData($id) {
        if (confirm("Apakah yakin keanggotaan peserta penelitian akan dihapus?")) {
            $.ajax({
                url  : "../"+$id,
                type : "POST",
                data : {'_method' : 'DELETE', '_token' : $('input[name = "_token"]').val()},
                success : function(data) {
                    tampildata().load();
                },
                error : function() {
                    alert("Tidak dapat menghapus data");
                }

            });
        }
    }
</script>
@endsection