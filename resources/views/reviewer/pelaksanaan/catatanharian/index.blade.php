@extends('layouts.app')

@section('title')
    Catatan Harian
@endsection

@section('breadcrumb')
    @parent
    <li>Catatan Harian</li>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
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
                    <div class="panel panel-default">

                        <div class="panel-heading"><strong>Daftar Catatan Harian  </strong><div class="pull-right"><strong></strong></div></div>
                        <div class="panel-body">
                         
                            <div class="table-responsive" >
                                <table id="mytable" class="table">
                                    <thead class="thead-light">
                                    <tr>
                                        <th scope="col" class="text-left" width="4%">No.</th>
                                        <th scope="col" class="text-center" width="10%">NIDN</th>
                                        <th scope="col" class="text-center" width="10%">Ketua</th>
                                        <th scope="col" class="text-center" width="30%">Judul</th>
                                        <th scope="col" class="text-left" width="10%">Jenis</th>
                                        <th scope="col" class="text-left" width="10%">Upload</th>

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
                            <label for="tm_catatan">Tanggal Mulai</label>
                            <input type="datetime-local" class="form-control tm_catatan" name="tm_catatan" placeholder="Tanggal Mulai" required>
                        </div>
                        <div class="form-group">
                            <label for="ta_catatan">Tanggal Akhir</label>
                            <input type="datetime-local" class="form-control ta_catatan" name="ta_catatan" placeholder="Tanggal Akhir" required>
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


        function bacaProposalRinci(id) {
            window.location = "{{route('r_catatan.resume', '')}}/"+btoa(id);
        }

        "use strict";

        $(function () {
            // fill_datatable();

            $('#mytable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: 'r_catatan/get_data',
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
                            data: 'nama',
                            searchable: false

                        },
                        {
                            data: 'judul',

                        },
                        {
                            data: 'jenis',
                        },
                        
                        {
                            data: 'upload',
                        },

                        {
                            data: 'action',
                            orderable: false,
                            searchable: false
                        }
                    ]
                });

            //update
            $(document).on('submit', '#modalEdit', function (e) {
                e.preventDefault();

                var formData = $("form#update").serializeArray();

                token();

                var id = formData[0].value
                var data = {
                    '_token': $('input[name=_token]').val(),
                    tm_catatan: formData[1].value,
                    ta_catatan: formData[2].value,

                };

                $.ajax({
                    url: "r_catatan/" + id,
                    method: 'PUT',
                    data: data,
                    success: function (result) {
                        if (result.success) {
                            //  location.reload();
                            swal(
                                'Selamat!',
                                'Waktu Berhasil Diupdate',
                                'success'
                            ).then(function(isConfirm) {
                                    if (isConfirm) {
                                        location.reload();
                                    }
                                }
                            );

                            $('#modalEdit').modal('hide');


                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        alert('Gagal Update Data');
                    }

                });
            });



            function refresh() {
                var table = $('#mytable').DataTable();
                table.ajax.reload(null, false);
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

                cleaner();

                $('#modalAdd').modal('show');
                $('.modal-title').text('Tambah Data');
            });



            //edit
            $(document).on('click', '.view', function (e) {
                e.preventDefault();
                var id = $(this).attr('id');

                token();

                window.location = "{{route('r_catatan.resume', '')}}/"+btoa(id);



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
                    url: "usulan",
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




            //delete data
            $(document).on('click', '.verifikasi', function (e) {
                e.preventDefault();
                var id = $(this).attr('id');

                swal({
                    title: 'Anda Yakin?',
                    text: "Anda Yakin Verifikasi Data ini?",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#5bc0de',
                    cancelButtonColor: '#f0ad4e',
                    confirmButtonText: 'Ya, Verifikasi!',
                    cancelButtonText: 'Batal'
                }).then(function(isConfirm) {
                        if (isConfirm) {

                            token();

                            $.ajax({
                                url: 'r_catatan/' + id,
                                method: 'DELETE',
                                dataType: 'json',
                                data: {id:id,"_token": "{{ csrf_token() }}"},

                                success: function (result) {
                                    if (result.success) {
                                        refresh();
                                        cleaner();
                                        swal(
                                            'Diverifikasi!',
                                            'Data berhasil diverifikasi.',
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