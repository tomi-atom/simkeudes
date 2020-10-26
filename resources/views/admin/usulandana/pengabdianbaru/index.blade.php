@extends('layouts.app')

@section('title')
    Pengabdian {{$periodeterbaru->tahun}} sesi {{$periodeterbaru->sesi}} Didanai
@endsection

@section('breadcrumb')
    @parent
    <li><a href="{{ route('usulandana.index') }}">Master</a></li>
    <li>Usulan</li>
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

                    <br><br>
                    <div class="panel panel-default">
                        <div class="panel-heading"><strong>Daftar Usulan Pengabdian {{$periodeterbaru->tahun}} sesi {{$periodeterbaru->sesi}}  </strong><div class="pull-right"><strong></strong></div></div>
                        <div class="panel-body">
                            <div class="row">
                                <br>
                                <div class="col-md-10">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="skema">Skema</label>
                                            <select name="filter_skema" id="filter_skema" class="form-control" required>
                                                <option value="">Pilih Skema</option>
                                                @foreach($skema as $listskema)

                                                    <option value="{{ $listskema->id }}">{{ $listskema->skema }}</option>

                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <br>
                                        <div class="form-group" align="center">
                                            <button type="button" name="filter" id="filter" class="btn btn-info">Tampilkan</button>

                                            <button type="button" name="reset" id="reset" class="btn btn-default">Reset</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table id="mytable" class="table" hidden>
                                    <thead class="thead-light">
                                    <tr>
                                        <th scope="col" class="text-left" width="4%">No.</th>
                                        <th scope="col" class="text-center" width="10%">NIDN</th>
                                        <th scope="col" class="text-center" width="10%">Ketua</th>
                                        <th scope="col" class="text-center" width="30%">Judul</th>
                                        <th scope="col" class="text-left" width="10%">Dana disetujui</th>
                                        <th scope="col" class="text-left" width="10%">Status</th>
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
                        <input type="hidden"  name="id" class="id">
                        <div class="form-group">
                            <label for="bidang">Dana Disetujui</label>
                            <div class="col-sm-12 input-group ">
                                <span class="input-group-addon"><b>Rp.</b></span>
                                <input type="text" class="form-control dana" name="dana" placeholder="Dana disetujui" required>
                                <span class="input-group-addon">,00</span>
                            </div>
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
@endsection

@section('script')
    <script type="text/javascript">

        "use strict";

        $(function () {
            //fill_datatable();

            function fill_datatable(filter_skema = '')
            {
                $('#mytable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: 'pengabdianbarudana/get_data',
                        data:{filter_skema:filter_skema}
                    },
                    columns: [{
                        data: 'rownum',
                        orderable: false,
                        searchable: false
                    },
                        {
                            data: 'nidn',

                        },
                        {
                            data: 'nama'
                        },
                        {
                            data: 'judul',
                        },
                        {
                            data: 'dana',
                        },
                        {
                            data: 'status',
                        },

                        {
                            data: 'action',
                            orderable: false,
                            searchable: false
                        }
                    ]
                });
            }


            $('#filter').click(function(){
                var filter_skema = $('#filter_skema').val();
                //var filter_country = $('#filter_country').val();

                if(filter_skema != '' &&  filter_skema != '')
                {
                    $('#mytable').DataTable().destroy();
                    $('#mytable').show();
                    fill_datatable(filter_skema);
                }
                else
                {
                    alert('Pilih Skema Untuk Mendapilkan Data');
                }
            });
            $('#reset').click(function(){

                $('#mytable').DataTable().destroy();
                $('#mytable').hide();
                //fill_datatablel/.();
            });
            function refresh() {
                var table = $('#mytable').DataTable();
                table.ajax.reload(null, false);
            }

            function cleaner() {
                $('.id').val('');
                $('.dana').val('');
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
                    url: 'pengabdianbarudana/' + id + '/edit',
                    method: 'get',
                    success: function (result) {

                        if (result.success) {
                            let json = jQuery.parseJSON(result.data);

                            $('.id').val(json.id);
                            $('.dana').val(json.dana);


                            $('#modalEdit').modal('show');
                            $('.modal-title').text('Masukan Dana');
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
                    dana: formData[1].value,
                };

                $.ajax({
                    url: "pengabdianbarudana/" + id,
                    method: 'PUT',
                    data: data,
                    success: function (result) {
                        if (result.success) {
                            refresh();
                            cleaner();
                            $('#modalEdit').modal('hide');
                            swal(
                                'Selamat!',
                                'Data Berhasil Ditambahkan',
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
            $(document).on('click', '.setuju', function (e) {
                e.preventDefault();
                var id = $(this).attr('id');

                swal({
                    title: 'Anda Yakin?',
                    text: "Anda Yakin Setujui Proposal ini?",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#5bc0de',
                    cancelButtonColor: '#f0ad4e',
                    confirmButtonText: 'Ya, Setuju!',
                    cancelButtonText: 'Batal'
                }).then(function(isConfirm) {
                        if (isConfirm) {

                            token();

                            $.ajax({
                                url: "{{route('pengabdianbarudana.setuju', '')}}/"+id,
                                method: 'GET',
                                dataType: 'json',
                                data: {id:id,"_token": "{{ csrf_token() }}"},

                                success: function (result) {
                                    if (result.success) {
                                        refresh();
                                        cleaner();
                                        swal(
                                            'Disetujui!',
                                            'Data berhasil disetujui.',
                                            'success'
                                        );
                                    }
                                }
                            });
                        }
                    }
                );

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
                                url: 'pengabdianbarudana/' + id,
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
                                url: 'pengabdianbarudana/' + id,
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