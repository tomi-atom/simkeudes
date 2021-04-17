@extends('layouts.app')

@section('title')
    Usulan
@endsection

@section('breadcrumb')
    @parent
    <li><a href="{{ route('usulan.index') }}">Master</a></li>
    <li>Usulan</li>
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
                            <li class="active"><a href="#revenue-chart" data-toggle="tab">Periode Terbaru</a></li>
                            <li><a href="#sales-chart" data-toggle="tab">Periode Lama</a></li>
                        </ul>
                        <div class="tab-content no-padding">
                            <!-- Morris chart - Sales -->
                            <div class="chart tab-pane active" id="revenue-chart" style="position: relative; height: 400px;">
                                <!-- /.col (LEFT) -->
                                <div class="col-md-6">
                                    <!-- DONUT CHART -->
                                    <div class="box box-primary">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">Penelitian {{$periodeterbaru1->tahun}} sesi {{$periodeterbaru1->sesi}}</h3>

                                            <div class="box-tools pull-right">
                                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                                </button>
                                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                                            </div>
                                        </div>
                                        <div class="box-body">
                                            <canvas id="pieChart" style="height:250px"></canvas>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-8 col-md-offset-4">
                                                @if($periodeterbaru1->tahun)
                                                <a class="btn btn-success pull-right"  href="{{ route('penelitianbaru.index') }}">
                                                    <span class="ion ion-android-exit"></span> DETAIL
                                                </a>
                                                @else
                                                <small class="label label-warning">Penelitian Terbaru Tidak Aktif</small>
                                                @endif

                                            </div>
                                        </div>
                                        <!-- /.box-body -->
                                    </div>
                                    <!-- /.box -->

                                </div>
                                <div class="col-md-6">
                                    <!-- DONUT CHART -->
                                    <div class="box box-primary">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">Pengabdian {{$periodeterbaru2->tahun}} sesi {{$periodeterbaru2->sesi}}</h3>

                                            <div class="box-tools pull-right">
                                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                                </button>
                                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                                            </div>
                                        </div>
                                        <div class="box-body">
                                            <canvas id="pieChart2" style="height:250px"></canvas>

                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-8 col-md-offset-4">
                                                @if($periodeterbaru2->tahun)
                                                <a class="btn btn-success pull-right"  href="{{ route('pengabdianbaru.index') }}">
                                                    <span class="ion ion-android-exit"></span> DETAIL
                                                </a>
                                                @else
                                                <small class="label label-warning">Pengabdian Terbaru Tidak Aktif</small>
                                                @endif
                                            </div>
                                        </div>
                                        <!-- /.box-body -->
                                    </div>
                                    <!-- /.box -->

                                </div>

                            </div>
                            <div class="chart tab-pane" id="sales-chart" style="position: relative; ">
                                <div class="panel panel-default">

                                    <div class="panel-heading"><strong>Daftar Usulan  </strong><div class="pull-right"><strong></strong></div></div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <br>
                                            <div class="col-md-10">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="periode">Periode</label>
                                            <select name="filter_thn" id="filter_thn" class="form-control" required>
                                                <option value="">Pilih Tahun</option>
                                                @foreach($periode as $listperiode)
                                                    @if($listperiode->tanggal_mulai == null && $listperiode->tanggal_akhir== null)
                                                        <option value="{{ $listperiode->id }}">{{ $listperiode->tahun }} sesi {{ $listperiode->sesi }} {{$listperiode->idprogram->program}} -  @if($listperiode->jenis==1)<span>Penelitian</span> @else <span>Pengabdian </span> @endif - <a class="btn-danger btn-sm center-block">Waktu Belum di set -</a> @if($listperiode->aktif ==1) Aktif  @else Tidak Aktif @endif </option>
                                                    @else
                                                        <option value="{{ $listperiode->id }}">{{ $listperiode->tahun }} sesi {{ $listperiode->sesi }}  {{$listperiode->idprogram->program}} -  @if($listperiode->jenis==1)<span>Penelitian</span> @else <span>Pengabdian </span> @endif - <span class="text text-green">Mulai : {{ $listperiode->tanggal_mulai }} </span><span class="text text-green">- Akhir : {{ $listperiode->tanggal_akhir }} -</span>@if($listperiode->aktif == 1) Aktif @else Tidak Aktif @endif </option>

                                                    @endif

                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-">
                                        <br>
                                        <div class="form-group" align="center">
                                            <button type="button" name="filter" id="filter" class="btn btn-info">Tampilkan</button>

                                            <button type="button" name="reset" id="reset" class="btn btn-default">Reset</button>
                                        </div>

                                    </div>

                                </div>
                                        </div>
                                        <div class="table-responsive" >
                                            <table id="mytable" class="table" hidden>
                                                <thead class="thead-light">
                                                <tr>
                                                    <th scope="col" class="text-left" width="4%">No.</th>
                                                    <th scope="col" class="text-center" width="10%">NIDN</th>
                                                    <th scope="col" class="text-center" width="10%">Nama</th>
                                                    <th scope="col" class="text-center" width="10%">Skema</th>
                                                    <th scope="col" class="text-center" width="5%">TKT</th>
                                                
                                                    <th scope="col" class="text-left" width="30%">Judul</th>
                                                  
                                                    <th scope="col" class="text-left" width="10%">Dana di Usulkan</th>
                                                    <th scope="col" class="text-left" width="5%">Status</th>
            
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

    @include('admin.usulan.formdetail')
@endsection

@section('script')
    <script type="text/javascript">

        "use strict";
        function bacaProposalRinci(id) {
            window.location = "{{route('usulan.resume', '')}}/"+btoa(id);
        }

        $(function () {
            //-------------
            //- PIE CHART -
            //-------------
            // Get context with jQuery - using jQuery's .get() method.
            var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
            var pieChartCanvas2 = $('#pieChart2').get(0).getContext('2d')
            var pieChart       = new Chart(pieChartCanvas)
            var pieChart2       = new Chart(pieChartCanvas2)
            var PieData        = [
                {
                    value    : 150,
                    color    : '#f56954',
                    highlight: '#f56954',
                    label    : 'Unggulan Universitas Riau'
                },
                {
                    value    :80,
                    color    : '#00a65a',
                    highlight: '#00a65a',
                    label    : 'Percepatan Inovasi'
                },
                {
                    value    : 40,
                    color    : '#f39c12',
                    highlight: '#f39c12',
                    label    : 'Bidang Ilmu'
                },
                {
                    value    : 60,
                    color    : '#00c0ef',
                    highlight: '#00c0ef',
                    label    : 'Guru Besar'
                },
                {
                    value    : 30,
                    color    : '#3c8dbc',
                    highlight: '#3c8dbc',
                    label    : 'Dosen Muda'
                },

            ]
            var PieData2        = [
                {
                    value    : 130,
                    color    : '#f56954',
                    highlight: '#f56954',
                    label    : 'Pengabdian Kepada Masyarakat'
                },
                {
                    value    :70,
                    color    : '#00a65a',
                    highlight: '#00a65a',
                    label    : 'Desa Binaan'
                },


            ]
            var pieOptions     = {
                //Boolean - Whether we should show a stroke on each segment
                segmentShowStroke    : true,
                //String - The colour of each segment stroke
                segmentStrokeColor   : '#fff',
                //Number - The width of each segment stroke
                segmentStrokeWidth   : 2,
                //Number - The percentage of the chart that we cut out of the middle
                percentageInnerCutout: 0, // This is 0 for Pie charts
                //Number - Amount of animation steps
                animationSteps       : 100,
                //String - Animation easing effect
                animationEasing      : 'easeOutBounce',
                //Boolean - Whether we animate the rotation of the Doughnut
                animateRotate        : true,
                //Boolean - Whether we animate scaling the Doughnut from the centre
                animateScale         : false,
                //Boolean - whether to make the chart responsive to window resizing
                responsive           : true,
                // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
                maintainAspectRatio  : true,
                //String - A legend template
            }

            pieChart.Doughnut(PieData, pieOptions)
            pieChart2.Doughnut(PieData2, pieOptions)

           // fill_datatable();

             function fill_datatable(filter_thn)
            {
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
                                {extend: 'pdf', title:'SIMPPM UNIVERSITAS RIAU '},
                                {extend: 'excel', title: 'SIMPPM UNIVERSITAS RIAU'},
                                {extend:'print',title: 'SIMPPM UNIVERSITAS RIAU '},
                    ],
                    ajax: {
                        url: 'usulan/get_data',
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
                        name:'tb_proposal.idskema'

                    },
                    {
                        data: 'idtkt',
                        searchable: false

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
                var filter_thn = $('#filter_thn').val();

                if(filter_thn != '' )
                {
                    $('#mytable').DataTable().destroy();
                    $('#mytable').show();
                    fill_datatable(filter_thn);
                }
                else
                {
                    alert('Pilih Periode, Jenis dan Skema Untuk Mendapilkan Data');
                }
            });

            $('#reset').click(function(){
                $('#filter_thn').val('');

                $('#mytable').DataTable().destroy();
                $('#mytable').hide();
                //fill_datatable();
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
            $(document).on('click', '.edit', function (e) {
                e.preventDefault();
                var id = $(this).attr('id');

                token();
                var infoModal = $('#modalEdit');
                $.ajax({
                    url: 'usulan/' + id + '/edit',
                    method: 'get',
                    success: function (result) {

                        if (result.success) {
                            let data = jQuery.parseJSON(result.data);



                            let ketua = ' <i class="ion ion-clipboard"></i><h4 class="box-title">Pengusul: '+data.idketua+'</h4>';
                            let htmlData = '<ul><li>'+data.judul+'</li><</ul>';
                            infoModal.find('.modal-title').text('Detail Usulan');
                            infoModal.find('.box-header').html(ketua);
                            //infoModal.find('.panel-body').html(htmlData);
                            infoModal.modal('show');



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
                    url: "usulan/" + id,
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
                                url: 'usulan/' + id,
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
                                url: 'usulan/' + id,
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