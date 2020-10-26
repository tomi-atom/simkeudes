@extends('layouts.app')

@section('title')
    Rumpun
@endsection

@section('breadcrumb')
    @parent
    <li><a href="{{ route('rumpun.index') }}">Master</a></li>
    <li>Rumpun</li>
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
                        <div class="panel-heading"><strong>Daftar Rumpun Ilmu  </strong><div class="pull-right"><strong></strong></div></div>
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
                                        <th scope="col" class="text-center" width="30%">Ilmu 1</th>
                                        <th scope="col" class="text-center" width="30%">Ilmu 2</th>
                                        <th scope="col" class="text-center" width="30%">Ilmu 3</th>
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
                            <label for="ilmu1">Ilmu 1</label>
                            <input type="text" class="form-control ilmu1" name="ilmu1" placeholder="Ilmu 1" required>
                        </div>
                        <div class="form-group">
                            <label for="ilmu2">Ilmu 2</label>
                            <input type="text" class="form-control ilmu2" name="ilmu2" placeholder="Ilmu 2" required>
                        </div>
                        <div class="form-group">
                            <label for="ilmu3">Ilmu 3</label>
                            <input type="text" class="form-control ilmu3" name="ilmu3" placeholder="Ilmu 3" required>
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
                            <label for="ilmu1">Ilmu 1</label>
                            <input type="text" class="form-control ilmu1" name="ilmu1" placeholder="Ilmu 1" required>
                        </div>
                        <div class="form-group">
                            <label for="ilmu2">Ilmu 2</label>
                            <input type="text" class="form-control ilmu2" name="ilmu2" placeholder="Ilmu 2" required>
                        </div>
                        <div class="form-group">
                            <label for="ilmu3">Ilmu 3</label>
                            <input type="text" class="form-control ilmu3" name="ilmu3" placeholder="Ilmu 3" required>
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
                ajax: 'rumpun/get_data',
                columns: [{
                    data: 'rownum',
                    orderable: false,
                    searchable: false
                    },
                    {
                        data: 'ilmu1'
                    },
                    {
                        data: 'ilmu2'
                    },
                    {
                        data: 'ilmu3'
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
                $('.ilmu1').val('');
                $('.ilmu2').val('');
                $('.ilmu3').val('');
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
                    url: 'rumpun/' + id + '/edit',
                    method: 'get',
                    success: function (result) {

                        if (result.success) {
                            let json = jQuery.parseJSON(result.data);

                            $('.id').val(json.id);
                            $('.ilmu1').val(json.ilmu1);
                            $('.ilmu2').val(json.ilmu2);
                            $('.ilmu3').val(json.ilmu3);
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
                    ilmu1: formData[0].value,
                    ilmu2: formData[1].value,
                    ilmu3: formData[2].value,
                    aktif: formData[3].value,
                };

                $.ajax({
                    url: "rumpun",
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
                    ilmu1: formData[1].value,
                    ilmu2: formData[2].value,
                    ilmu3: formData[3].value,
                    aktif: formData[4].value,
                };

                $.ajax({
                    url: "rumpun/" + id,
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
                                url: 'rumpun/' + id,
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