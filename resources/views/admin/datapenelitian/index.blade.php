@extends('layouts.app')

@section('title')
    Data Penelitian dan Pengabdian
@endsection

@section('breadcrumb')
    @parent

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/sweetalert2/1.3.3/sweetalert2.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/sweetalert2/0.4.5/sweetalert2.css">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/sweetalert2/1.3.3/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="{{url('AdminLTE/plugins/datatables/dataTables.bootstrap.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css">


@endsection

@section('content')


    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading"> <div class="pull-right"><strong></strong></div></div>

                <div class="panel-body">
                    <div class="panel panel-default">

                        <div class="panel-heading"><strong>Data Penelitian dan Pengabdian  </strong><div class="pull-right"><strong></strong></div></div>
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
                                                    @if($listperiode->tm_anggaran == null && $listperiode->ta_anggaran== null)
                                                        <option value="{{ $listperiode->id }}">{{ $listperiode->tahun }} sesi {{ $listperiode->sesi }} -  @if($listperiode->jenis==1)<span>Penelitian</span> @else <span>Pengabdian </span> @endif - <a class="btn-danger btn-sm center-block">Waktu Belum di set -</a> @if($listperiode->aktif ==1) Aktif  @else Tidak Aktif @endif </option>
                                                    @else
                                                        <option value="{{ $listperiode->id }}">{{ $listperiode->tahun }} sesi {{ $listperiode->sesi }} -  @if($listperiode->jenis==1)<span>Penelitian</span> @else <span>Pengabdian </span> @endif - <span class="text text-green">Mulai : {{ $listperiode->tm_anggaran }} </span><span class="text text-green">- Akhir : {{ $listperiode->ta_anggaran }} -</span>@if($listperiode->aktif == 1) Aktif @else Tidak Aktif @endif </option>

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
                                            <a href="{{ route('dataproposal.index' )}}"  class="btn btn-primary pull-right create"><i class="glyphicon glyphicon-plus"></i> Tambah</a>
                                        
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
    <script src="{{url('public/adminLTE/plugins/datatables/jquery.dataTables.js') }}"></script>
    <script src="{{url('public/adminLTE/plugins/datatables/dataTables.bootstrap.js') }}"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"> </script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.colVis.min.js"> </script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"> </script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"> </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"> </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"> </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"> </script>

    <script type="text/javascript">

        "use strict";

     
        $(function () {

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
                                {extend: 'pdf', title:'SIMPPM UNIVERSITAS RIAU : Monev Hasil '},
                                {extend: 'excel', title: 'SIMPPM UNIVERSITAS RIAU : Monev Hasil'},
                                {extend:'print',title: 'SIMPPM UNIVERSITAS RIAU : Monev Hasil'},
                    ],
                    ajax: {
                        url: 'datapenelitian/get_data',
                        data:{filter_thn:filter_thn}
                    },
                    columns: [{
                        data: 'rownum',
                        orderable: false,
                        searchable: false
                    },
                        {
                            data: 'nidn',
                            name:'tb_peneliti.nidn'

                        },
                        {
                            data: 'nama',
                            name:'tb_peneliti.nama'
                        },
                        {
                            data: 'judul',
                            name:'tb_proposal.judul'
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
          

           


            function cleaner() {
                $('.id').val('');
                $('.jenis').val('');
                $('.batas').val('');
                $('.aktif').val('');
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
          

            


           
        });
    </script>


@endsection