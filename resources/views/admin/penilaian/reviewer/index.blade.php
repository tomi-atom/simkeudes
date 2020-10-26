@extends('layouts.app')

@section('title')
    Daftar Reviewer
@endsection

@section('breadcrumb')
    @parent
    <li><a href="{{ route('p_reviewer.index') }}">Master</a></li>
    <li>Daftar Reviewer</li>
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
                    @if($errors->first('kesalahan'))
                        <br>
                        <div class="row">
                            <div class="col col-sm-2">.</div>
                            <div class="alert alert-info col-sm-8"><b>{{{ $errors->first('kesalahan') }}}</b></div>
                        </div>
                    @endif
                    <br>
                        <br>
                        <div class="nav-tabs-custom">
                            <!-- Tabs within a box -->
                            <ul class="nav nav-tabs pull-left">
                                <li class="active"><a href="#revenue-chart" data-toggle="tab">Periode Aktif</a></li>
                                <li><a href="#sales-chart" data-toggle="tab">History</a></li>
                            </ul>
                            <div class="tab-content no-padding">
                                <!-- Morris chart - Sales -->
                                <div class="chart tab-pane active" id="revenue-chart" style="position: relative; ">
                                    <div class="panel panel-default">
                                        <div class="panel-heading"><strong>Daftar Reviewer  </strong><div class="pull-right"><strong></strong></div></div>
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
                                                        <th scope="col" class="text-center" width="10%">NIDN</th>
                                                        <th scope="col" class="text-center" width="20%">Nama</th>
                                                        <th scope="col" class="text-left" width="10%">Periode</th>
                                                        <th scope="col" class="text-left" width="10%">Jenis</th>
                                                        <th scope="col" class="text-left" width="10%">Aksi</th>
                                                    </tr>
                                                    </thead>

                                                </table>
                                            </div>

                                            </table>
                                        </div>

                                    </div>


                                </div>
                                <div class="chart tab-pane" id="sales-chart" style="position: relative; ">
                                    <div class="panel panel-default">
                                        <div class="panel-heading"><strong>Daftar Reviewer  </strong><div class="pull-right"><strong></strong></div></div>
                                        <div class="panel-body">
                                            <div class="table-responsive">
                                                <table id="mytable1" class="table">
                                                    <thead class="thead-light">
                                                    <tr>
                                                        <th scope="col" class="text-left" width="4%">No.</th>
                                                        <th scope="col" class="text-center" width="10%">NIDN</th>
                                                        <th scope="col" class="text-center" width="20%">Nama</th>
                                                        <th scope="col" class="text-left" width="10%">Periode</th>
                                                        <th scope="col" class="text-left" width="10%">Jenis</th>
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
            </div>
        </div>
    </div>
    {{-- modal for add --}}
    <div id="modalAdd" class="modal fade" role="dialog" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-lg ">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title text-bold" >Modal Header</h4>
                </div>

                <div class="panel panel-default">
                    <div class="panel-body">
                        <br>
                        <div class="table-responsive">
                            <table id="mytable2" class="table">
                                <thead class="thead-light">
                                <tr>
                                    <th scope="col" class="text-left" width="4%">No.</th>
                                    <th scope="col" class="text-center" width="10%">NIDN</th>
                                    <th scope="col" class="text-center" width="10%">NIP</th>
                                    <th scope="col" class="text-left" width="30%">Nama</th>
                                    <th scope="col" class="text-left" width="30%">Email</th>
                                    <th scope="col" class="text-left" width="10%">Level</th>
                                    <th scope="col" class="text-left" width="10%">Aksi</th>
                                </tr>
                                </thead>

                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary btn-save" data-dismiss="modal"><i class="fa fa-floppy-o"></i> Selesai </button>
                        </div>

                    </div>

                </div>
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
@endsection

@section('script')
    <script type="text/javascript">

        "use strict";

        function tambahDosen() {
            window.location = "{{route('p_reviewer.create', '')}}";
        }

        $(function () {
            $('#mytable').DataTable({
                processing: true,
                serverSide: true,
                ajax: 'p_reviewer/get_data',
                columns: [{
                    data: 'rownum',
                    orderable: false,
                    searchable: false
                    },
                    {
                        data: 'nidn',
                         searchable: false
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'periode',
                         searchable: false
                    },
                    {
                        data: 'jenis',
                         searchable: false
                    },
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });
            $('#mytable1').DataTable({
                processing: true,
                serverSide: true,
                ajax: 'p_reviewer1/get_data',
                columns: [{
                    data: 'rownum',
                    orderable: false,
                    searchable: false
                },
                    {
                        data: 'nidn'
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'periode'
                    },
                    {
                        data: 'jenis'
                    },
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });
            $('#mytable2').DataTable({
                processing: true,
                serverSide: true,
                ajax: 'p_reviewer2/get_data',
                columns: [{
                    data: 'rownum',
                    orderable: false,
                    searchable: false
                },
                    {
                        data: 'nidn',
                         searchable: false
                    },
                    {
                        data: 'nip',
                         searchable: false
                    },
                    {
                        data: 'nama',
                    },
                    {
                        data: 'email',
                         searchable: false
                    },
                    {
                        data: 'level',
                         searchable: false
                    },

                    {
                        data: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            $('.toggle-class').change(function() {
                var level = $(this).prop('checked') == true ? 1 : 0;
                var user_id = $(this).data('id');

                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: 'changeStatus',
                    data: {'status': level, 'user_id': user_id},
                    success: function(data){
                        console.log(data.success)
                    }
                });
            })



            function refresh() {
                var table = $('#mytable').DataTable();
                var table2 = $('#mytable2').DataTable();
                table.ajax.reload(null, false);
                table2.ajax.reload(null, false);
            }


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

                ///cleaner();
                $('#modalAdd').modal('show');
                $('.modal-title').text('Tambah Data Reviewer');

            });

            //edit
            $(document).on('click', '.edit', function (e) {
                e.preventDefault();
                var id = $(this).attr('id');

                token();

                $.ajax({
                    url: 'p_reviewer/' + id + '/edit',
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

                refresh()
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
                    url: "p_reviewer/" + id,
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



            $(document).on('click', '.verifikasi', function (e) {
                e.preventDefault();
                var id = $(this).attr('id');

                $.ajax({
                    url: 'p_reviewer/' + id,
                    method: 'DELETE',
                    dataType: 'json',
                    data: {id:id,"_token": "{{ csrf_token() }}"},

                    success: function (result) {
                        if (result.success) {
                            refresh();
                            cleaner();

                        }
                    }
                });

            });
            $(document).on('click', '.add1', function (e) {
                e.preventDefault();
                var id = $(this).attr('id');
                var jenis = 1;
                $.ajax({
                    url: 'p_reviewer/' + id,
                    method: 'DELETE',
                    dataType: 'json',
                    data: {id:id,jenis:jenis,"_token": "{{ csrf_token() }}"},

                    success: function (result) {
                        if (result.success) {
                            swal(
                                'Selamat!',
                                'Reviewer Berhasil Ditambahkan',
                                'success'
                            );
                            refresh();
                            cleaner();

                        }
                    }
                });

            });
            //delete data
            $(document).on('click', '.add2', function (e) {
                e.preventDefault();
                var id = $(this).attr('id');
                var jenis = 2;
                $.ajax({
                    url: 'p_reviewer/' + id,
                    method: 'DELETE',
                    dataType: 'json',
                    data: {id:id,jenis:jenis,"_token": "{{ csrf_token() }}"},

                    success: function (result) {
                        if (result.success) {
                            swal(
                                'Selamat!',
                                'Reviewer Berhasil Ditambahkan',
                                'success'
                            );
                            refresh();
                            cleaner();


                        }
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
                                url  : "{{route('p_reviewer.destroyreviewer','')}}/"+id,
                                method: 'GET',
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