@extends('layouts.app')

@section('title')
    Skema
@endsection

@section('breadcrumb')
    @parent
    <li><a href="{{ route('skema.index') }}">Master</a></li>
    <li>Skema</li>
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
                        <div class="panel-heading"><strong>Daftar Skema  </strong><div class="pull-right"><strong></strong></div></div>
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
                                        <th scope="col" class="text-center" width="10%">Program</th>
                                        <th scope="col" class="text-center" width="10%">Skema</th>
                                        <th scope="col" class="text-center" width="10%">Min Peserta</th>
                                        <th scope="col" class="text-center" width="10%">Max Peserta</th>
                                        <th scope="col" class="text-center" width="10%">Min Didik 1</th>
                                        <th scope="col" class="text-center" width="10%">Min Jabat 1</th>
                                        <th scope="col" class="text-center" width="10%">Min Didik 2</th>
                                        <th scope="col" class="text-center" width="10%">Min Jabat 2</th>
                                        <th scope="col" class="text-center" width="10%">Max Jabat</th>
                                        <th scope="col" class="text-center" width="10%">Dana</th>
                                        <th scope="col" class="text-center" width="10%">Min TKT</th>
                                        <th scope="col" class="text-center" width="10%">Min Luaran</th>
                                        <th scope="col" class="text-center" width="10%">Kuota</th>
                                        <th scope="col" class="text-left" width="10%">Aktif</th>

                                        <th scope="col" class="text-left" width="10%">Aksi</th>
                                    </tr>
                                    </thead>

                                </table>
                            </div>


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
                            <label for="idprogram">Program</label>
                            <select name="idprogram" id="idprogram" class="form-control" required>
                                <option value="">Pilih Program</option>
                                @foreach($program as $listprogram)
                                    <option value="{{ $listprogram->id }}">{{ $listprogram->program}}</option>

                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="skema">Skema</label>
                            <input type="text" class="form-control skema" name="skema" placeholder="Skema" required>

                        </div>
                        <div class="form-group">
                            <label for="minpeserta">Min Peserta</label>
                            <input type="text" class="form-control minpeserta" name="minpeserta" placeholder="Min Peserta" required>
                        </div>
                        <div class="form-group">
                            <label for="maxpeserta">Max Peserta</label>
                            <input type="text" class="form-control maxpeserta" name="maxpeserta" placeholder="Max Peserta" required>
                        </div>
                        <div class="form-group">
                            <label for="mindidik1">Min Didik 1</label>
                            <input type="text" class="form-control mindidik1" name="mindidik1" placeholder="Min Didik 1" required>
                        </div>

                        <div class="form-group">
                            <label for="minjabat2">Min Jabat 2</label>
                            <input type="text" class="form-control minjabat2" name="minjabat2" placeholder="Min Jabat 2" required>
                        </div>
                        <div class="form-group">
                            <label for="mindidik1">Min Didik 2</label>
                            <input type="text" class="form-control mindidik2" name="mindidik2" placeholder="Min Didik 2" required>
                        </div>

                        <div class="form-group">
                            <label for="minjabat2">Min Jabat 2</label>
                            <input type="text" class="form-control minjabat2" name="minjabat2" placeholder="Min Jabat 2" required>
                        </div>
                        <div class="form-group">
                            <label for="maxjabat">Max Jabat</label>
                            <input type="text" class="form-control maxjabat" name="maxjabat" placeholder="Max Jabat" required>
                        </div>
                        <div class="form-group">
                            <label for="dana">Dana</label>
                            <input type="number" class="form-control dana" name="dana" placeholder="Dana" required>
                        </div>
                        <div class="form-group">
                            <label for="mintkt">Min TKT</label>
                            <input type="text" class="form-control mintkt" name="mintkt" placeholder="Min TKT" required>
                        </div>
                        <div class="form-group">
                            <label for="minluaran">Min Luaran</label>
                            <input type="text" class="form-control minluaran" name="minluaran" placeholder="Min Luaran" required>
                        </div>
                        <div class="form-group">
                            <label for="kuota">Kuota</label>
                            <input type="text" class="form-control kuota" name="kuota" placeholder="Kuota" required>
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
                            <label for="idprogram">Program</label>
                            <select name="idprogram" id="idprogram" class="form-control" required>
                                <option value="">Pilih Program</option>
                                @foreach($program as $listprogram)
                                    <option value="{{ $listprogram->id }}">{{ $listprogram->program}}</option>

                                @endforeach
                            </select>   </div>
                        <div class="form-group">
                            <label for="skema">Skema</label>
                            <input type="text" class="form-control skema" name="skema" placeholder="Skema" required>
                        </div>
                        <div class="form-group">
                            <label for="minpeserta">Min Peserta</label>
                            <input type="text" class="form-control minpeserta" name="minpeserta" placeholder="Min Peserta" required>
                        </div>
                        <div class="form-group">
                            <label for="maxpeserta">Max Peserta</label>
                            <input type="text" class="form-control maxpeserta" name="maxpeserta" placeholder="Max Peserta" required>
                        </div>
                        <div class="form-group">
                            <label for="mindidik1">Min Didik 1</label>
                            <input type="text" class="form-control mindidik1" name="mindidik1" placeholder="Min Didik 1" required>
                        </div>

                        <div class="form-group">
                            <label for="minjabat1">Min Jabat 2</label>
                            <input type="text" class="form-control minjabat1" name="minjabat1" placeholder="Min Jabat 1" required>
                        </div>
                        <div class="form-group">
                            <label for="mindidik1">Min Didik 2</label>
                            <input type="text" class="form-control mindidik2" name="mindidik2" placeholder="Min Didik 2" required>
                        </div>

                        <div class="form-group">
                            <label for="minjabat2">Min Jabat 2</label>
                            <input type="text" class="form-control minjabat2" name="minjabat2" placeholder="Min Jabat 2" required>
                        </div>
                        <div class="form-group">
                            <label for="maxjabat">Max Jabat</label>
                            <input type="text" class="form-control maxjabat" name="maxjabat" placeholder="Max Jabat" required>
                        </div>
                        <div class="form-group">
                            <label for="dana">Dana</label>
                            <input type="number" class="form-control dana" name="dana" placeholder="Dana" required>
                        </div>
                        <div class="form-group">
                            <label for="mintkt">Min TKT</label>
                            <input type="text" class="form-control mintkt" name="mintkt" placeholder="Min TKT" required>
                        </div>
                        <div class="form-group">
                            <label for="minluaran">Min Luaran</label>
                            <input type="text" class="form-control minluaran" name="minluaran" placeholder="Min Luaran" required>
                        </div>
                        <div class="form-group">
                            <label for="kuota">Kuota</label>
                            <input type="text" class="form-control kuota" name="kuota" placeholder="Kuota" required>
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
                dom: '<"html5buttons">Blfrtip',
                language: {
                    buttons: {
                        colvis : 'show / hide', // label button show / hide
                        colvisRestore: "Reset Kolom" //lael untuk reset kolom ke default
                    }
                },

                buttons : [
                    {extend: 'colvis', postfixButtons: [ 'colvisRestore' ] },
                    {extend:'csv'},
                    {extend: 'pdf', title:'SIMPPM UNIVERSITAS RIAU'},
                    {extend: 'excel', title: 'SIMPPM UNIVERSITAS RIAU'},
                    {extend:'print',title: 'SIMPPM UNIVERSITAS RIAU'},
                ],
                ajax: 'skema/get_data',
                columns: [{
                    data: 'rownum',
                    orderable: false,
                    searchable: false
                },
                    {
                        data: 'program'
                    },
                    {
                        data: 'skema'
                    },
                    {
                        data: 'minpeserta'
                    },
                    {
                        data: 'maxpeserta'
                    },
                    {
                        data: 'mindidik1'
                    },
                    {
                        data: 'minjabat1'
                    },
                    {
                        data: 'mindidik2'
                    },
                    {
                        data: 'minjabat2'
                    },
                    {
                        data: 'maxjabat'
                    },
                    {
                        data: 'dana'
                    },
                    {
                        data: 'mintkt'
                    },
                    {
                        data: 'minluaran'
                    },
                    {
                        data: 'kuota'
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
                $('.idprogram').val('');
                $('.skema').val('');
                $('.minpeserta').val('');
                $('.maxpeserta').val('');
                $('.mindidik1').val('');
                $('.minjabat1').val('');
                $('.mindidik2').val('');
                $('.minjabat2').val('');
                $('.maxjabat').val('');
                $('.dana').val('');
                $('.mintkt').val('');
                $('.minluaran').val('');
                $('.kuota').val('');
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
            //edit
            $(document).on('click', '.edit', function (e) {
                e.preventDefault();
                var id = $(this).attr('id');

                token();

                $.ajax({
                    url: 'skema/' + id + '/edit',
                    method: 'get',
                    success: function (result) {

                        if (result.success) {
                            let json = jQuery.parseJSON(result.data);

                            $('.id').val(json.id);
                            $('.idprogram').val(json.idprogram);
                            $('.skema').val(json.skema);
                            $('.minpeserta').val(json.minpeserta);
                            $('.maxpeserta').val(json.maxpeserta);
                            $('.mindidik1').val(json.mindidik1);
                            $('.minjabat1').val(json.minjabat1);
                            $('.mindidik2').val(json.mindidik2);
                            $('.minjabat2').val(json.minjabat2);
                            $('.maxjabat').val(json.maxjabat);
                            $('.dana').val(json.dana);
                            $('.mintkt').val(json.mintkt);
                            $('.minluaran').val(json.minluaran);
                            $('.kuota').val(json.kuota);
                            $('.aktif').val(json.aktif);


                            $('#modalEdit').modal('show');
                            $('.modal-title').text('Update Data');
                        }
                    }
                });


            });

            $(document).on('click', '.edit2', function (e) {
                e.preventDefault();
                var id = $(this).attr('id');

                token();

                $.ajax({

                    url: 'skema/' + id + '/edit',
                    method: 'get',
                    success: function (result) {



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
                    idprogram: formData[0].value,
                    skema: formData[1].value,
                    minpeserta: formData[2].value,
                    maxpeserta: formData[3].value,
                    mindidik1: formData[4].value,
                    minjabat1: formData[5].value,
                    mindidik2: formData[6].value,
                    minjabat2: formData[7].value,
                    maxjabat: formData[8].value,
                    dana: formData[9].value,
                    mintkt: formData[10].value,
                    minluaran: formData[11].value,
                    kuota: formData[12].value,
                    aktif: formData[13].value,
                };

                $.ajax({
                    url: "skema",
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
                    idprogram: formData[1].value,
                    skema: formData[2].value,
                    minpeserta: formData[3].value,
                    maxpeserta: formData[4].value,
                    mindidik1: formData[5].value,
                    minjabat1: formData[6].value,
                    mindidik2: formData[7].value,
                    minjabat2: formData[8].value,
                    maxjabat: formData[9].value,
                    dana: formData[10].value,
                    mintkt: formData[11].value,
                    minluaran: formData[12].value,
                    kuota: formData[13].value,
                    aktif: formData[14].value,
                };

                $.ajax({
                    url: "skema/" + id,
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
                                url: 'skema/' + id,
                                type : "POST",
                                data : {'_method' : 'DELETE', '_token' : $('input[name = "_token"]').val()},
                                success : function(data) {
                                    swal(
                                        'Selamat!',
                                        'Data Berhasil Dihapus',
                                        'success'
                                    );
                                    window.location = "{{route('skema.index')}}";
                                },
                                error : function() {
                                    swal(
                                        'Terjadi Kesalahan!',
                                        'Data Gagal Dihapus',
                                        'error'
                                    );
                                }

                            });

                        }
                    }
                );

            });
        });
    </script>
@endsection