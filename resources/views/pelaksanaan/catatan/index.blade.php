@extends('layouts.app')

@section('title')
    Catatan Harian
@endsection

@section('breadcrumb')
    @parent
    <li><a href="">Catatan Harian</a></li>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/sweetalert2/1.3.3/sweetalert2.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/sweetalert2/0.4.5/sweetalert2.css">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/sweetalert2/1.3.3/sweetalert2.min.js"></script>

@endsection

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading"> <div class="pull-right"><strong></strong></div></div>

                <div class="panel-body">
                    <br>
                    @if($errors->first('success'))
                        <script type="text/javascript">
                            "use strict";
                            swal(
                                'Selamat!',
                                'Data Berhasil Dihapus',
                                'success'
                            );
                        </script>
                    @elseif($errors->first('error'))
                        <script type="text/javascript">

                            "use strict";
                            swal(
                                'Terjadi Kesalahan!',
                                'Data Gagal Dihapus',
                                'error'
                            );

                        </script>
                    @else
                    @endif
                    <div class="panel panel-default">
                        <div class="panel-heading"><strong>Daftar Catatan Harian </strong><div class="pull-right"><strong></strong></div></div>
                        <div class="panel-body">
                            <div class="box-header with-border">
                                <button class="btn btn-primary pull-right" onclick="tambah()" ><i class="glyphicon glyphicon-plus"></i> Tambah</button>
                            </div>
                            <br>
                            <input type="hidden" name="prosalid" value="{{$idtemp}}" class="id">
                            <div class="table-responsive">
                                <table id="mytable" class="table">
                                    <thead class="thead-light">
                                    <tr>
                                        <th scope="col" class="text-left" width="4%">No.</th>
                                        <th scope="col" class="text-center" width="20%">Tanggal</th>
                                        <th scope="col" class="text-center" width="40%">Keterangan</th>

                                        <th scope="col" class="text-left" width="10%">Aksi</th>
                                    </tr>
                                    </thead>

                                </table>
                            </div>

                            </table>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
    {{-- modal for add --}}
    <div id="modalAdd" class="modal fade" role="dialog" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog ">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Modal Header</h4>
                </div>
                <form id="store" data-toggle="validator" method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="bidang">Bidang</label>
                            <input type="text" class="form-control bidang" name="bidang" placeholder="Bidang" required>
                        </div>
                        <div class="form-group">
                            <label for="aktif">Aktif</label>
                            <select class="form-control" id="aktif" name="aktif" required>
                                <option value="1"> Aktif</option>
                                <option value="0"> Tidak Aktif </option>
                            </select>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-save"><i class="fa fa-floppy-o"></i> Simpan </button>
                        <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fa fa-arrow-circle-left"></i> Batal </button>
                    </div>

                </form>
            </div>

        </div>
    </div>

    {{-- modal for edit --}}
    <div id="modalEdit" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Modal Header</h4>
                </div>
                <form id="update">
                    <div class="modal-body">
                        <input type="hidden" name="id" class="id">
                        <div class="form-group">
                            <label for="bidang">Bidang</label>
                            <input type="text" class="form-control bidang" name="bidang" placeholder="Bidang" required>
                        </div>
                        <div class="form-group">
                            <label for="aktif">Aktif</label>
                            <select class="form-control" id="aktif" name="aktif" required>
                                <option value="1"> Aktif</option>
                                <option value="0"> Tidak Aktif </option>
                            </select>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-save"><i class="fa fa-floppy-o"></i> Update </button>
                        <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fa fa-arrow-circle-left"></i> Batal </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@include('pelaksanaan.catatan.formcatatan')

@endsection

@section('script')
    <script type="text/javascript">
            function refresh() {
                var table = $('#mytable').DataTable();
                table.ajax.reload(null, false);
            }
        "use strict";
        function tambah(id) {
           
            $('#tanggal').val("");
            $('#keterangan').val("");
            
            $('#upload').val("");

            $('#modal-luaran').modal('show');
        }
        $("#modal-luaran form").validator().on('submit', function(e) {
        if (!e.isDefaultPrevented()) {
            var id = $('#id').val();
            var jenis = $('#kategori').val();
            
            $.ajax ({
                url: "{{ route('catatanharian.store', $idprop) }}",
                type : "POST",
                data:new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success : function(data) {
                    refresh()
                    swal(
                        'Selamat!',
                        'Data Berhasil Disimpan',
                        'success'
                    );
                    $('#modal-luaran').modal('hide');
                   

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
       

        function hapus(id) {
            swal({
                title: 'Anda Yakin?',
                text: "Anda Yakin Hapus Data ini?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#5bc0de',
                cancelButtonColor: '#f0ad4e',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then(function(isConfirm) {
                    if (isConfirm) {

                        window.location = " {{ route('catatanharian.destroy','' )}}/"+id;

                    }
                }
            );
        }
        function hapus2(id) {
            swal({
                title: 'Anda Yakin?',
                text: "Anda Yakin Hapus Data ini?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#5bc0de',
                cancelButtonColor: '#f0ad4e',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then(function(isConfirm) {
                    if (isConfirm) {

                        window.location = " {{ route('catatanharian.destroy','' )}}/"+id;

                    }
                }
            );
        }
        $(function () {
            var prosalid =  $('#prosalid').val();
            $('#mytable').DataTable({
                processing: true,
                serverSide: true,
                ajax: 'catatan/get_data',prosalid,
                columns: [{
                    data: 'rownum',
                    orderable: false,
                    searchable: false
                },
                    {
                        data: 'tanggal'
                    },
                    {
                        data: 'keterangan'
                    },

                    {
                        data: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            

            function cleaner() {
                $('.id').val('');
                $('.bidang').val('');
                $('.aktif').val('');
            }

            function token() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
            }

            //create
            $(document).on('click', '.create', function (e) {
                e.preventDefault();

                cleaner();
                $('#modalAdd').modal('show');
                $('.modal-title').text('Tambah Data');
            });

            //edit
            $(document).on('click', '.edit', function (e) {
                e.preventDefault();
                var id = $(this).attr('id');

                token();

                $.ajax({
                    url: 'catatan/' + id + '/edit',
                    method: 'get',
                    success: function (result) {

                        if (result.success) {
                            let json = jQuery.parseJSON(result.data);

                            $('.id').val(json.id);
                            $('.bidang').val(json.bidang);
                            $('.aktif').val(json.aktif);


                            $('#modalEdit').modal('show');
                            $('.modal-title').text('Update Data');
                        }

                    }
                });


            });

            //store
            $(document).on('submit', '#modalAdd', function (e) {
                e.preventDefault();

                var formData = $("form#store").serializeArray();

                token();

                var data = {
                    '_token': $('input[name=_token]').val(),
                    bidang: formData[0].value,
                    aktif: formData[1].value,
                };

                $.ajax({
                    url: "catatan",
                    method: 'post',
                    data: data,
                    success: function (result) {
                        if (result.success) {
                            refresh();
                            $('#modalAdd').modal('hide');
                            swal(
                                'Selamat!',
                                'Data Berhasil Disimpan',
                                'success'
                            );
                        }
                    }
                });
            });

            //update
            $(document).on('submit', '#modalEdit', function (e) {
                e.preventDefault();

                var formData = $("form#update").serializeArray();

                token();

                var id = formData[0].value
                var data = {
                    '_token': $('input[name=_token]').val(),
                    bidang: formData[1].value,
                    aktif: formData[2].value,
                };

                $.ajax({
                    url: "catatan/" + id,
                    method: 'PUT',
                    data: data,
                    success: function (result) {
                        if (result.success) {
                            refresh();
                            cleaner();
                            $('#modalEdit').modal('hide');
                            swal(
                                'Selamat!',
                                'Data Berhasil Diupdate',
                                'success'
                            );

                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        alert('Gagal Update Data');
                    }

                });
            });


            //delete data
            $(document).on('click', '.deledte', function (e) {
                e.preventDefault();
                var id = $(this).attr('id');

                swal({
                    title: 'Anda Yakin?',
                    text: "Anda Yakin Hapus Data ini?",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#5bc0de',
                    cancelButtonColor: '#f0ad4e',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then(function(isConfirm) {
                        if (isConfirm) {

                            token();

                            $.ajax({
                                url: 'catatan/' + id,
                                method: 'DELETE',
                                dataType: 'json',
                                data: {id:id,"_token": "{{ csrf_token() }}"},

                                success: function (result) {
                                    if (result.success) {
                                        refresh();
                                        cleaner();
                                        swal(
                                            'Dihapus!',
                                            'Data berhasil dihapus.',
                                            'success'
                                        );
                                    }
                                }
                            });
                        }
                    }
                );

            });
        });
    </script>
@endsection