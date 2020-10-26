@extends('layouts.app')

@section('addonhref')
    <link rel="stylesheet" href="{{ asset('public/adminLTE/plugins/responsive-editor/editor.css') }}">
@endsection

@section('title')
   Catatan Harian
@endsection

@section('breadcrumb')
    @parent

    <li>Catatan Harian</li>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/sweetalert2/1.3.3/sweetalert2.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/sweetalert2/0.4.5/sweetalert2.css">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/sweetalert2/1.3.3/sweetalert2.min.js"></script>
@endsection

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading"><strong></strong> <div class="pull-right"><strong></strong></div>
                </div>
                @if($errors->first('success'))
                    <script type="text/javascript">
                        "use strict";
                        swal(
                            'Selamat!',
                            'Data Berhasil Diperbaharui',
                            'success'
                        );
                    </script>
                @elseif($errors->first('error'))
                    <script type="text/javascript">

                        "use strict";
                        swal(
                            'Terjadi Kesalahan!',
                            'Data Gagal Diperbaharui',
                            'error'
                        );

                    </script>
                @endif
                <div class="panel-body">

                    <div class="panel panel-default">
                        <div class="panel-heading"><strong>Catatan Harian   </strong></div>

                        <div class="panel-body">
                            <form role="form" method="POST">
                                {{ csrf_field() }}

                                <div class="row">

                                    <div class="col-sm-12">
                                        <textarea id="ringkas" name="ringkas" class="textarea form-control" rows="15"></textarea>
                                    </div>
                                </div>


                                <div class="row" id="tsimpan">
                                    <div class="col-md-12">
                                        <button onclick="lanjutSubtansi()" type="button" class="btn btn-success pull-right" name="simpan" id="simpan"><span class="ion ion-android-exit" ></span> LANJUTKAN
                                        </button>
                                    </div>
                                </div>
                            </form>

                            <div class="row" id="trobah">
                                <div class="col-md-12">
                                   <!-- <a href="{{route('validasipenelitian.show', base64_encode(mt_rand(10,99).(($idtemp - 135)*2+29)))}}" class="btn btn-default pull-left" name="awal" id="awal"><span class="fa fa-reply fa-fw"></span> Kembali</a>-->
                                    <button onclick="rubahSubtansi()" type="button" class="btn btn-primary pull-right" ><span class="fa fa-floppy-o fa-fw" ></span> PERBAHARUI
                                    </button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>

@endsection

@section('script')
    <script src="{{ asset('public/adminLTE/plugins/responsive-editor/editor.js') }}"></script>

    <script>
        function update(id) {
            window.location = " {{ route('catatanharian.ganti','' )}}/"+id;
        }
        function getLatar() {
            var _token     = $('input[name = "_token"]').val();

            $.ajax({
                url: "{{ route('catatanharian.usulan',base64_encode($idtemp) ) }}",
                method: "POST",
                dataType: "json",
                data: {_token: _token},
                success: function(result)
                {
                    if (result) {
                        $("#ringkas").Editor("setText", result[0]);


                        $("#simpan").attr('disabled', true);
                        $('#tsimpan').hide();
                        $('#trobah').show();
                        $("#robah").attr('disabled', false);
                    }
                    else {
                        $("#robah").attr('disabled', true);
                        $('#trobah').hide();
                        $('#tsimpan').show();
                        $("#simpan").attr('disabled', false);
                    }

                },
                error : function() {
                    swal(
                        'Terjadi Kesalahan!',
                        'Gagal mengunduh data',
                        'error'
                    );
                }
            });
        }

        $(document).ready(function() {
            $("#ringkas").Editor({"insert_img":true});

            getLatar();
        });

        function lanjutSubtansi() {
            var ringkasan  = $('#ringkas').Editor('getText');
            var _token     = $('input[name = "_token"]').val();

            $.ajax({
                url: "{{ route('catatanharian.subtansi.store', $idtemp) }}",
                method: "POST",
                data: {ringkasan: ringkasan, _token: _token},
                success: function(result)
                {
                    swal({
                        title: 'Selamat!',
                        text: "Data Berhasil Disimpan",
                        type: 'success',
                        confirmButtonColor: '#5bc0de',
                        cancelButtonColor: '#f0ad4e',
                        confirmButtonText: 'Lanjutkan!',
                    }).then(function(isConfirm) {
                            if (isConfirm) {
                                window.location = "{{route('catatanharian.catatan.index', base64_encode($idtemp+127) )}}";

                            }
                        }
                    );
                },
                error : function() {
                    swal(
                        'Terjadi Kesalahan!',
                        'Tidak dapat menyimpan data',
                        'error'
                    );

                }
            });
        }

        function rubahSubtansi(id) {
            var ringkasan  = $('#ringkas').Editor('getText');

            var _token     = $('input[name = "_token"]').val();

            $.ajax({
                url: "{{ route('catatanharian.ganti', $idtemp) }}",
                method: "POST",
                data: {ringkasan: ringkasan, _token: _token},
                success: function(result)
                {
                    swal({
                        title: 'Selamat!',
                        text: "Data Berhasil Diperbaharui",
                        type: 'success',
                        confirmButtonText: 'OK!',
                    }).then(function(isConfirm) {
                            if (isConfirm) {
                                window.location = "{{route('catatanharian.catatan.index', base64_encode($prosalid->prosalid+127) )}}";

                            }
                        }
                    );
                },
                error : function() {
                    swal(
                        'Terjadi Kesalahan!',
                        'Tidak dapat menyimpan data, lengkapi seluruh usulan',
                        'error'
                    );
                }
            });

        }

    </script>
@endsection
