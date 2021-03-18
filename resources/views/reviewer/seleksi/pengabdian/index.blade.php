@extends('layouts.app')

@section('title')
   Tahap Seleksi
@endsection

@section('breadcrumb')
    @parent
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
                    <br>
                    <div class="nav-tabs-custom">
                        <!-- Tabs within a box -->
                        <ul class="nav nav-tabs pull-left">
                            <li class="active"><a href="#revenue-chart" data-toggle="tab">Pengabdian {{$periodeterbaru->tahun}} sesi {{$periodeterbaru->sesi}}</a></li>
                            <li><a href="#sales-chart" data-toggle="tab">Periode Sebelumnya</a></li>
                        </ul>
                        <div class="tab-content no-padding">
                            <!-- Morris chart - Sales -->
                            <div class="chart tab-pane active" id="revenue-chart" style="position: relative; ">
                                <br>
                                <div class="panel panel-default">

                                    <div class="panel-heading"><strong>Daftar Usulan Pengabdian Tahun <span class="label label-primary">Tahun {{$periodeterbaru->tahun}} sesi {{$periodeterbaru->sesi}}</span>  </strong><div class="pull-right"><strong></strong></div></div>
                                    <div class="panel-body">

                                        <br>
                                        <div class="table-responsive">
                                            <table id="table" class="table">
                                                <thead class="thead-light">
                                                <tr>
                                                    
                                                    <th scope="col" class="text-left" width="4%">No.</th>
                                                    <th scope="col" class="text-center" width="10%">NIDN</th>
                                                    <th scope="col" class="text-center" width="10%">Ketua</th>
                                                    <th scope="col" class="text-center" width="10%">Skema</th>
                                                    <th scope="col" class="text-left" width="30%">Judul</th>
                                                    

                                                    <th scope="col" class="text-left" width="10%">Status</th>
                                                    <th scope="col" class="text-left" width="10%">Aksi</th>
                                                </tr>
                                                </thead>

                                            </table>
                                        </div>

                                    </div>

                                </div>

                            </div>
                            <div class="chart tab-pane" id="sales-chart" style="position: relative; ">
                                <br>
                                <div class="panel panel-default">

                                    <div class="panel-heading"><strong>Daftar Usulan Sebelumnya </strong><div class="pull-right"><strong></strong></div></div>
                                    <div class="panel-body">

                                        <br>
                                        <div class="table-responsive">
                                            <table id="tablelama" class="table">
                                                <thead class="thead-light">
                                                <tr>
                                                    <th scope="col" class="text-left" width="4%">No.</th>
                                                    <th scope="col" class="text-center" width="10%">NIDN</th>
                                                    <th scope="col" class="text-center" width="10%">Ketua</th>
                                                    <th scope="col" class="text-center" width="10%">Skema</th>
                                                    <th scope="col" class="text-left" width="30%">Judul</th>                                                   

                                                    <th scope="col" class="text-left" width="10%">Status</th>
                                                    <th scope="col" class="text-left" width="10%">Aksi</th>                                                </tr>
                                                </thead>

                                            </table>
                                        </div>

                                    </div>

                                </div>


                            </div>
                        </div>
                    </div>

                    <br><br>

                </div>
            </div>
        </div>
    </div>




@endsection

@section('script')
    <script type="text/javascript">

        "use strict";

        $(function () {

            $('#table').DataTable({
                processing: true,
                serverSide: true,
                ajax: 'pengabdianr/get_data',
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
                        data: 'skema',
                        searchable: false

                    },
                    {
                        data: 'judul',

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
            $('#tablelama').DataTable({
                processing: true,
                serverSide: true,
                ajax: 'pengabdianrlama/get_data',
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
                        data: 'skema',
                        searchable: false

                    },
                    {
                        data: 'judul',

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

            function refresh() {
                var table = $('#table').DataTable();
                var tablelama = $('#tablelama').DataTable();

                table.ajax.reload(null, false);
                tablelama.ajax.reload(null, false);

            }

            function cleaner() {
                $('.id').val('');
                $('.jenis').val('');
                $('.batas').val('');
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
                $('.modal-title').text('Tambah Data Reviewer');
            });

            //edit
            $(document).on('click', '.editreviewerpenelitian', function (e) {
                e.preventDefault();
                var id = $(this).attr('id');

                token();

                var infoModal = $('#modalReviwerPenelitian');
                $.ajax({
                    url: 'plotingreviewer/' + id + '/edit',
                    method: 'get',
                    success: function (result) {

                        if (result.success) {
                            let data = jQuery.parseJSON(result.data);
                            $('.prosalid').val(data.id);
                            let ketua = ' <strong><h4>Pengusul: '+data.nama+'</h4></strong><br>' +
                                '<h5>Judul: '+data.judul+'</h5>';
                            let htmlData = '<ul><li>'+data.judul+'</li><</ul>';
                            infoModal.find('.modal-title').text('Ploting Reviewer Penelitian');
                            infoModal.find('.box-header').html(ketua);
                            infoModal.modal('show');



                        }

                    }
                });


            });
            //edit
            $(document).on('click', '.editreviewerpengabdian', function (e) {
                e.preventDefault();
                var id = $(this).attr('id');

                token();

                var infoModal = $('#modalReviwerPengabdian');
                $.ajax({
                    url: 'plotingreviewer/' + id + '/edit',
                    method: 'get',
                    success: function (result) {

                        if (result.success) {
                            let data = jQuery.parseJSON(result.data);
                            $('.prosalid').val(data.id);
                            let ketua = ' <strong><h4>Pengusul: '+data.nama+'</h4></strong><br>' +
                                '<h5>Judul: '+data.judul+'</h5>';
                            let htmlData = '<ul><li>'+data.judul+'</li><</ul>';
                            infoModal.find('.modal-title').text('Ploting Reviewer Penelitian');
                            infoModal.find('.box-header').html(ketua);
                            infoModal.modal('show');



                        }

                    }
                });


            });
            //store
            $(document).on('click', '.tambahreviewerpenelitian', function (e) {
                e.preventDefault();

                var id = $(this).attr('id');
                var prosalid =  $('.prosalid').val();

                token();

                var data = {
                    '_token': $('input[name=_token]').val(),
                    iddosen: id,
                    prosalid: prosalid,
                };
                $.ajax({
                    url: "{{ route('plotingreviewer.store') }}",
                    method: "POST",
                    data: data,
                    success: function (result) {
                        if (result.success) {
                            refresh();
                            // $('#modalAdd').modal('hide');
                            swal(
                                'Selamat!',
                                'Data Berhasil Disimpan',
                                'success'
                            );
                        }
                    }
                });

                $.ajax({
                    url: "plotingreviewer",
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
            $(document).on('submit', '#modalEditReviewer', function (e) {
                e.preventDefault();

                var formData = $("form#update").serializeArray();

                token();

                var id = formData[0].value
                var data = {
                    '_token': $('input[name=_token]').val(),
                    jenis: formData[1].value,
                    batas: formData[2].value,
                    aktif: formData[3].value,
                };

                $.ajax({
                    url: "mataanggaran/" + id,
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
            $(document).on('click', '.tambahreviewer', function (e) {
                e.preventDefault();
                var id = $(this).attr('id');
                var prosalid = $("#prosalid").val();

                token();

                $.ajax({
                    url: 'plotingreviewer/' + id,
                    method: 'DELETE',
                    dataType: 'json',
                    data: {id:id,prosalid:prosalid,"_token": "{{ csrf_token() }}"},

                    success: function (result) {
                        if (result.success) {
                            refresh();
                            cleaner();
                            swal(
                                'Ditambahkan!',
                                'Reviewer berhasil ditambahkan.',
                                'success'
                            );
                        }
                    }
                });

            });

        });
    </script>


@endsection