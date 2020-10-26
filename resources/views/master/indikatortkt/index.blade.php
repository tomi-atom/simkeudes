@extends('layouts.app')

@section('title')
   Indikator TKT
@endsection

@section('breadcrumb')
    @parent
    <li><a href="{{ route('indikatortkt.index') }}">Master</a></li>
    <li>Indikator TKT</li>
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
                        <div class="panel-heading"><strong>Daftar Bidang TKT  </strong><div class="pull-right"><strong></strong></div></div>
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
                                        <th scope="col" class="text-center" width="10%">Bidang</th>
                                        <th scope="col" class="text-center" width="10%">Level TKT</th>
                                        <th scope="col" class="text-center" width="10%">No Urut</th>
                                        <th scope="col" class="text-center" width="30%">Indikator</th>
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
                            <label for="idbidang">Bidang</label>
                            <select name="idbidang" id="idbidang" class="form-control" required>
                                <option value="">Pilih Bidang</option>
                                @foreach($bidang as $list)

                                    <option value="{{ $list->id }}">{{ $list->bidang }}</option>

                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="leveltkt">Level TKT</label>
                            <input type="text" class="form-control leveltkt" name="leveltkt" placeholder="Level TKT" required>
                        </div>
                        <div class="form-group">
                            <label for="nourut">NO Urut</label>
                            <input type="text" class="form-control nourut" name="nourut" placeholder="No Urut" required>
                        </div>
                        <div class="form-group">
                            <label for="indikator">Indikator</label>
                            <input type="text" class="form-control indikator" name="indikator" placeholder="Indikator" required>
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
                            <label for="idbidang">Bidang</label>
                            <select name="idbidang" id="idbidang" class="form-control" required>
                                <option value="">Pilih Bidang</option>
                                @foreach($bidang as $list)

                                    <option value="{{ $list->id }} " name="idbidang"class="idbidang">{{ $list->bidang }}</option>

                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="leveltkt">Level TKT</label>
                            <input type="text" class="form-control leveltkt" name="leveltkt" placeholder="Level TKT" required>
                        </div>
                        <div class="form-group">
                            <label for="nourut">NO Urut</label>
                            <input type="text" class="form-control nourut" name="nourut" placeholder="No Urut" required>
                        </div>
                        <div class="form-group">
                            <label for="indikator">Indikator</label>
                            <input type="text" class="form-control indikator" name="indikator" placeholder="Indikator" required>
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
                ajax: 'indikatortkt/get_data',
                columns: [{
                    data: 'rownum',
                    orderable: false,
                    searchable: false
                     },
                    {
                        data: 'bidang',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'leveltkt'
                    },
                    {
                        data: 'nourut'
                    },
                    {
                        data: 'indikator'
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
                $('.idbidang').val('');
                $('.leveltkt').val('');
                $('.nourut').val('');
                $('.indikator').val('');
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
                    url: 'indikatortkt/' + id + '/edit',
                    method: 'get',
                    success: function (result) {

                        if (result.success) {
                            let json = jQuery.parseJSON(result.data);

                            $('.id').val(json.id);
                            $('.idbidang').val(json.idbidang);
                            $('.leveltkt').val(json.leveltkt);
                            $('.nourut').val(json.nourut);
                            $('.indikator').val(json.indikator);
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
                    idbidang: formData[0].value,
                    leveltkt: formData[1].value,
                    nourut: formData[2].value,
                    indikator: formData[3].value,
                    aktif: formData[4].value,
                };

                $.ajax({
                    url: "indikatortkt",
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
                    idbidang: formData[1].value,
                    leveltkt: formData[2].value,
                    nourut: formData[3].value,
                    indikator: formData[4].value,
                    aktif: formData[5].value,
                };

                $.ajax({
                    url: "indikatortkt/" + id,
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
                                url: 'indikatortkt/' + id,
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