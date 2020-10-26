@extends('layouts.app')

@section('title')
    Hasil Penilaian
@endsection

@section('breadcrumb')
    @parent
    <li>Hasil Penilaian</li>
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

                        <div class="panel-heading"><strong>Daftar Hasil Penilaian  </strong><div class="pull-right"><strong></strong></div></div>
                        <div class="panel-body">
                            <div class="row">
                                @if($errors->first('kesalahan'))
                                    <br>
                                    <div class="row">
                                        <div class="col col-sm-2">.</div>
                                        <div class="alert alert-info col-sm-8"><b>{{{ $errors->first('kesalahan') }}}</b></div>
                                    </div>
                                @endif
                                <br>
                                <div class="col-md-10">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="periode">Periode</label>
                                            <select name="filter_thn" id="filter_thn" class="form-control" required>
                                                <option value="">Pilih Tahun</option>
                                                @foreach($periode as $listperiode)
                                                    @if($listperiode->tm_hasilpenilaian == null && $listperiode->ta_hasilpenilaian== null)
                                                        <option value="{{ $listperiode->id }}">{{ $listperiode->tahun }} sesi {{ $listperiode->sesi }} - <a class="btn-danger btn-sm center-block">Waktu Belum di set -</a> @if($listperiode->aktif ==1) Aktif  @else Tidak Aktif @endif </option>
                                                    @else
                                                        <option value="{{ $listperiode->id }}">{{ $listperiode->tahun }} sesi {{ $listperiode->sesi }} - <span class="text text-green">Mulai : {{ $listperiode->tm_hasilpenilaian }} </span><span class="text text-green">- Akhir : {{ $listperiode->ta_hasilpenilaian }} -</span>@if($listperiode->aktif == 1) Aktif @else Tidak Aktif @endif </option>

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

                                            <button type="button" name="setwaktu" id="setwaktu" class="btn btn-success">Set Waktu</button>
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
                                        <th scope="col" class="text-center" width="10%">Ketua</th>
                                        <th scope="col" class="text-center" width="30%">Judul</th>
                                        <th scope="col" class="text-left" width="10%">Jenis</th>
                                        <th scope="col" class="text-left" width="10%">Status</th>
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
                            <label for="tm_hasilpenilaian">Tanggal Mulai</label>
                            <input type="datetime-local" class="form-control tm_hasilpenilaian" name="tm_hasilpenilaian" placeholder="Tanggal Mulai" required>
                        </div>
                        <div class="form-group">
                            <label for="ta_hasilpenilaian">Tanggal Akhir</label>
                            <input type="datetime-local" class="form-control ta_hasilpenilaian" name="ta_hasilpenilaian" placeholder="Tanggal Akhir" required>
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
            window.location = "{{route('p_hasilpenilaian.resume', '')}}/"+btoa(id);
        }

        "use strict";

        $(function () {
            // fill_datatable();

            function fill_datatable(filter_thn)
            {
                $('#mytable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: 'p_hasilpenilaian/get_data',
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
                            searchable: false

                        },
                        {
                            data: 'judul',

                        },
                        {
                            data: 'jenis',
                        },
                        {
                            data: 'status',
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
            }

            $('#setwaktu').click(function(){
                var filter_thn = $('#filter_thn').val();

                if(filter_thn != '' )
                {
                    var id = filter_thn;

                    token();
                    var infoModal = $('#modalEdit');
                    $.ajax({
                        url: 'p_hasilpenilaian/' + id + '/edit',
                        method: 'get',
                        success: function (result) {

                            if (result.success) {
                                let json = jQuery.parseJSON(result.data);
                                let tahun = json.tahun;
                                let sesi = json.sesi;
                                $('.id').val(json.id);
                                $('.tm_hasilpenilaian').val(json.tm_hasilpenilaian);
                                $('.ta_hasilpenilaian').val(json.ta_hasilpenilaian);

                                let judul = '<a>Set Waktu Tahun </a><a>'+tahun+'</a><a> Sesi </a><a>'+sesi+'</a>';
                                infoModal.modal('show');
                                infoModal.find('.modal-title').html(judul);
                            }

                        }
                    });
                }
                else
                {
                    alert('Pilih Periode Untuk Set Waktu');
                }
            });
            //update
            $(document).on('submit', '#modalEdit', function (e) {
                e.preventDefault();

                var formData = $("form#update").serializeArray();

                token();

                var id = formData[0].value
                var data = {
                    '_token': $('input[name=_token]').val(),
                    tm_hasilpenilaian: formData[1].value,
                    ta_hasilpenilaian: formData[2].value,

                };

                $.ajax({
                    url: "p_hasilpenilaian/" + id,
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
            $(document).on('click', '.view', function (e) {
                e.preventDefault();
                var id = $(this).attr('id');

                token();

                window.location = "{{route('p_hasilpenilaian.resume', '')}}/"+btoa(id);



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
                                url: 'p_hasilpenilaian/' + id,
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