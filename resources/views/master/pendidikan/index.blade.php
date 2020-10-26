@extends('layouts.app')

@section('title')
    Pendidikan
@endsection

@section('breadcrumb')
    @parent
    <li><a href="{{ route('pendidikan.index') }}">Master</a></li>
    <li>Pendidikan</li>
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

                    <div class="panel panel-default">
                        <div class="panel-heading"><strong>Daftar Pendidikan  </strong><div class="pull-right"><strong></strong></div></div>
                        <div class="panel-body">
                            <div class="box-header with-border">
                                <button class="btn btn-primary pull-right create"><i class="glyphicon glyphicon-plus"></i> Tambah</button>
                            </div>
                            <br>
                            <div class="table-responsive">
                                <table id="mytable" class="table">
                                    <thead class="thead-light">
                                    <tr>
                                        <th scope="col" class="text-left" width="4%">No.</th>
                                        <th scope="col" class="text-center" width="30%">Pendidikan</th>
                                        <th scope="col" class="text-left" width="10%">Aktif</th>

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
                            <label for="pendidikan">Pendidikan</label>
                            <input type="text" class="form-control pendidikan" name="pendidikan" placeholder="Bidang" required>
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
                            <label for="pendidikan">Bidang</label>
                            <input type="text" class="form-control pendidikan" name="pendidikan" placeholder="Bidang" required>
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
@endsection

@section('script')
    <script type="text/javascript">

        "use strict";

        $(function () {
            $('#mytable').DataTable({
                processing: true,
                serverSide: true,
                ajax: 'pendidikan/get_data',
                columns: [{
                    data: 'rownum',
                    orderable: false,
                    searchable: false
                },
                    {
                        data: 'pendidikan'
                    },
                    {
                        data: 'aktif'
                    },
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            function refresh() {
                var table = $('#mytable').DataTable();
                table.ajax.reload(null, false);
            }

            function cleaner() {
                $('.id').val('');
                $('.pendidikan').val('');
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
                    url: 'pendidikan/' + id + '/edit',
                    method: 'get',
                    success: function (result) {

                        if (result.success) {
                            let json = jQuery.parseJSON(result.data);

                            $('.id').val(json.id);
                            $('.pendidikan').val(json.pendidikan);
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
                    pendidikan: formData[0].value,
                    aktif: formData[1].value,
                };

                $.ajax({
                    url: "pendidikan",
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
                    pendidikan: formData[1].value,
                    aktif: formData[2].value,
                };

                $.ajax({
                    url: "pendidikan/" + id,
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
            $(document).on('click', '.delete', function (e) {
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
                                url: 'pendidikan/' + id,
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