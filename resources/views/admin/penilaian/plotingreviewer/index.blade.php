@extends('layouts.app')

@section('title')
    Ploting Reviewer
@endsection

@section('breadcrumb')
    @parent

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
                            <li class="active"><a href="#revenue-chart" data-toggle="tab">Daftar Proposal Dalam Pengajuan</a></li>
                            <li><a href="#sales-chart" data-toggle="tab">Daftar Proposal Disetujui</a></li>
                        </ul>
                        <div class="tab-content no-padding">
                            
                            <!-- Morris chart - Sales -->
                            <div class="chart tab-pane active" id="revenue-chart" style="position: relative; ">
                                
                                <br>
                                <div class="panel panel-default">

                                    <div class="panel-heading"><strong>Daftar Proposal Dalam Pengajuan  </strong><div class="pull-right"><strong></strong></div></div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <br>
                                            <div class="col-md-10">
                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <label for="periode">Periode</label>
                                                        <select name="filter_thn" id="filter_thn" class="form-control" required>
                                                            <option value="">Pilih Tahun</option>
                                                            @foreach($periode as $listperiode)
                                                            <option value="{{ $listperiode->id }}">{{ $listperiode->tahun }} sesi {{ $listperiode->sesi }} - @if($listperiode->jenis==1)<span>Penelitian</span> @else <span>Pengabdian </span> @endif - <a class="btn-danger btn-sm center-block"></a> @if($listperiode->aktif ==1) Aktif  @else Tidak Aktif @endif </option>

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
                                        <br>
                                        <div class="table-responsive">
                                            <table id="tablepenelitian" class="table">
                                                <thead class="thead-light">
                                                <tr>
                                                    <th scope="col" class="text-left" width="4%">No.</th>
                                                    <th scope="col" class="text-center" width="10%">NIDN</th>
                                                    <th scope="col" class="text-center" width="10%">Nama</th>
                                                    <th scope="col" class="text-center" width="10%">Skema</th>
                                                
                                                    <th scope="col" class="text-left" width="30%">Judul</th>
                                                    <th scope="col" class="text-left" width="20%">Reviewer</th>

                                                    <th scope="col" class="text-left" width="2%">Status</th>
                                                    <th scope="col" class="text-left" width="2%">Aksi</th>
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

                                    <div class="panel-heading"><strong>Daftar Proposal Disetujui </strong><div class="pull-right"><strong></strong></div></div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <br>
                                            <div class="col-md-10">
                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <label for="periode">Periode</label>
                                                        <select name="filter_thn2" id="filter_thn2" class="form-control" required>
                                                            <option value="">Pilih Tahun</option>
                                                            @foreach($periode as $listperiode)
                                                            <option value="{{ $listperiode->id }}">{{ $listperiode->tahun }} sesi {{ $listperiode->sesi }} - @if($listperiode->jenis==1)<span>Penelitian</span> @else <span>Pengabdian </span> @endif - <a class="btn-danger btn-sm center-block"></a> @if($listperiode->aktif ==1) Aktif  @else Tidak Aktif @endif </option>

                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                              
                                                <div class="col-md-3">
                                                    <br>
                                                    <div class="form-group" align="center">
                                                        <button type="button" name="filter2" id="filter2" class="btn btn-info">Tampilkan</button>

                                                        <button type="button" name="reset2" id="reset2" class="btn btn-default">Reset</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="table-responsive">
                                            <table id="tablepengabdian" class="table">
                                                <thead class="thead-light">
                                                <tr>
                                                    <th scope="col" class="text-left" width="4%">No.</th>
                                                    <th scope="col" class="text-center" width="10%">NIDN</th>
                                                    <th scope="col" class="text-center" width="10%">Nama</th>
                                                    <th scope="col" class="text-center" width="10%">Skema</th>
                                                
                                                    <th scope="col" class="text-left" width="30%">Judul</th>
                                                    <th scope="col" class="text-left" width="20%">Reviewer</th>

                                                    <th scope="col" class="text-left" width="2%">Status</th>
                                                    <th scope="col" class="text-left" width="2%">Aksi</th>
                                                </tr>
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
    {{-- modal for add --}}
    <div id="modalAdd" class="modal fade" role="dialog" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-lg ">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title text-bold">Modal Header</h4>
                </div>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <br>
                        <div class="table-responsive">
                            <table id="aatablereviewer" class="table">
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
                        <div class="modal-footer">
                            <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fa fa-arrow-circle-left"></i> Kembali </button>
                        </div>

                    </div>

                </div>


            </div>

        </div>
    </div>
    {{-- modal for edit reviewer --}}
    <div id="modalReviwerPenelitian" class="modal fade hold-transition" role="dialog">
        <div class="modal-dialog modal-lg ">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Modal Header</h4>
                </div>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <input type="hidden" name="prosalid" class="prosalid" id="prosalid">
                        <div class="box-header">
                        </div>
                        <br>

                        <div class="table-responsive">
                            <table id="tablereviewerpenelitian" class="table">
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
                        <div class="modal-footer">
                            <button type="button"   class="btn btn-warning" data-dismiss="modal"><i class="fa fa-arrow-circle-left"></i> Kembali </button>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
    {{-- modal for edit reviewer --}}
    <div id="modalReviwerPengabdian" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Modal Header</h4>
                </div>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <input type="hidden" name="prosalid" class="prosalid" id="prosalid">
                        <div class="box-header">
                        </div>
                        <br>

                        <div class="table-responsive">
                            <table id="tablereviewerpengabdian" class="table">
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
                        <div class="modal-footer">
                            <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fa fa-arrow-circle-left"></i> Kembali </button>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>



@endsection

@section('script')
    <script type="text/javascript">

        "use strict";

        function destroytablepenelitian() {
            var tablereviewerpenelitian = $('#tablereviewerpenelitian').DataTable();
            tablereviewerpenelitian.destroy()
        }
        function destroytablepengabdian() {
            var tablereviewerpengabdian = $('#tablereviewerpengabdian').DataTable();
            tablereviewerpengabdian.destroy()
        }
        $(function () {
            function fill_datatable(filter_thn)
            {
            $('#tablepenelitian').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                        url: 'plotingpenelitian/get_data',
                        data:{filter_thn:filter_thn}
                    },
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
                        name:'tb_peneliti.nama'

                    },
                    {
                        data: 'skema',
                        searchable: false

                    },
                    {
                        data: 'judul',

                    },
                    {
                        data: 'reviewer',

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

            function fill_datatable2(filter_thn2)
            {
            $('#tablepengabdian').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                        url: 'plotingpengabdian/get_data',
                        data:{filter_thn:filter_thn2}
                    },
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
                        name:'tb_peneliti.nama'

                    },
                    {
                        data: 'skema',
                        searchable: false

                    },
                    {
                        data: 'judul',

                    },
                    {
                        data: 'reviewer',

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
                var filter_thn = $('#filter_thn').val();

                if(filter_thn != '' )
                {
                    $('#tablepenelitian').DataTable().destroy();
                    $('#tablepenelitian').show();
                    fill_datatable(filter_thn);
                }
                else
                {
                    alert('Pilih Periode, Jenis dan Skema Untuk Mendapilkan Data');
                }
            });


            $('#reset').click(function(){
                $('#filter_thn').val('');

                $('#tablepenelitian').DataTable().destroy();
                $('#tablepenelitian').hide();
                //fill_datatable();
            });

            $('#filter2').click(function(){
                var filter_thn2 = $('#filter_thn2').val();

                if(filter_thn2 != '' )
                {
                    $('#tablepengabdian').DataTable().destroy();
                    $('#tablepengabdian').show();
                    fill_datatable2(filter_thn2);
                }
                else
                {
                    alert('Pilih Periode, Jenis dan Skema Untuk Mendapilkan Data');
                }
            });


            $('#reset2').click(function(){
                $('#filter_thn2').val('');

                $('#tablepengabdian').DataTable().destroy();
                $('#tablepengabdian').hide();
                //fill_datatable();
            });
            function refresh() {
                var tablepenelitian = $('#tablepenelitian').DataTable();
                var tablepengabdian = $('#tablepengabdian').DataTable();
                tablepenelitian.ajax.reload(null, false);
                tablepengabdian.ajax.reload(null, false);
            }
            function refresh1() {
                var tablepenelitian = $('#tablepenelitian').DataTable();
                tablepenelitian.ajax.reload(null, false);
            }
            function refresh2() {
                var tablepengabdian = $('#tablepengabdian').DataTable();
                tablepengabdian.ajax.reload(null, false);
            }

            function refreshpenelitian() {
                var tablepenelitian = $('#tablepenelitian').DataTable();
                var tablereviewerpenelitian = $('#tablereviewerpenelitian').DataTable();
                tablepenelitian.ajax.reload(null, false);
                tablereviewerpenelitian.ajax.reload(null, false);
            }
            function refreshpengabdian() {
                var tablepengabdian = $('#tablepengabdian').DataTable();
                var tablereviewerpengabdian = $('#tablereviewerpengabdian').DataTable();
                tablepengabdian.ajax.reload(null, false);
                tablereviewerpengabdian.ajax.reload(null, false);
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
                                '<h5>Judul: '+data.judul+'</h5> '
                                ;
                            let htmlData = '<ul><li>'+data.id+'</li><</ul>';
                            infoModal.find('.modal-title').text('Plotting Reviewer ');
                            infoModal.find('.box-header').html(ketua);
                            infoModal.modal('show');

                            destroytablepenelitian()

                            var idprosal = data.id;

                            $('#tablereviewerpenelitian').DataTable({
                                processing: true,
                                serverSide: true,
                                backdrop: false,
                                ajax: 'reviewerpenelitian/get_data?id='+idprosal,

                                columns: [{
                                    data: 'rownum',
                                    orderable: false,
                                    searchable: false
                                },
                                    {

                                        data: 'nidn',searchable: false
                                    },
                                    {
                                        data: 'nama',
                                         name:'tb_peneliti.nama'
                                    },
                                    {
                                        data: 'periode',searchable: false
                                    },
                                    {
                                        data: 'jenis',searchable: false
                                    },
                                    {
                                        data: 'action',
                                        orderable: false,
                                        searchable: false
                                    }
                                ]
                            });




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
                            infoModal.find('.modal-title').text('Plotting Reviewer');
                            infoModal.find('.box-header').html(ketua);
                            infoModal.modal('show');
                            destroytablepengabdian();
                            var idprosal = data.id;
                            $('#tablereviewerpengabdian').DataTable({
                                processing: true,
                                serverSide: true,
                                ajax: 'reviewerpengabdian/get_data?id='+idprosal,
                                columns: [{
                                    data: 'rownum',
                                    orderable: false,
                                    searchable: false
                                },
                                    {
                                        data: 'nidn'
                                    },
                                    {
                                        data: 'nama',
                                         name:'tb_peneliti.nama'
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



                        }

                    }
                });


            });


            //delete data
            $(document).on('click', '.tambahreviewerpenelitian', function (e) {
                e.preventDefault();
                var id = $(this).attr('id');
                var name = $(this).attr('name');
                var prosalid = $("#prosalid").val();

                token();

                $.ajax({
                    url: 'plotingreviewer/' + id,
                    method: 'DELETE',
                    dataType: 'json',
                    data: {id:id,name:name,prosalid:prosalid,"_token": "{{ csrf_token() }}"},

                    success: function (result) {
                        if (result.success) {
                            refreshpenelitian();
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

            $(document).on('click', '.tambahreviewerpengabdian', function (e) {
                e.preventDefault();
                var id = $(this).attr('id');
                var name = $(this).attr('name');
                var prosalid = $("#prosalid").val();

                token();

                $.ajax({
                    url: 'plotingreviewer/' + id,
                    method: 'DELETE',
                    dataType: 'json',
                    data: {id:id,name:name,prosalid:prosalid,"_token": "{{ csrf_token() }}"},

                    success: function (result) {
                        if (result.success) {
                            refreshpengabdian();
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
                                url  : "{{route('plotingreviewer.destroyreviewer','')}}/"+id,
                                method: 'GET',
                                dataType: 'json',
                                data: {id:id,"_token": "{{ csrf_token() }}"},

                                success: function (result) {
                                    if (result.success) {
                                        refresh1();
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
             //delete data
             $(document).on('click', '.delete2', function (e) {
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
                                url  : "{{route('plotingreviewer.destroyreviewer','')}}/"+id,
                                method: 'GET',
                                dataType: 'json',
                                data: {id:id,"_token": "{{ csrf_token() }}"},

                                success: function (result) {
                                    if (result.success) {
                                        refresh2();
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