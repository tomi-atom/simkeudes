@extends('layouts.app')

@section('addonhref')
    <link rel="stylesheet" href="{{ asset('public/adminLTE/plugins/responsive-editor/editor.css') }}">
@endsection

@section('title')
    Catatan Harian
@endsection

@section('breadcrumb')
    @parent
    <li><a href="{{ route('r_catatanharian.index') }}">Catatan Harian</a></li>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/sweetalert2/1.3.3/sweetalert2.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/sweetalert2/0.4.5/sweetalert2.css">
    <script type="text/javascript" src="https:subtansi//cdn.jsdelivr.net/sweetalert2/1.3.3/sweetalert2.min.js"></script>
@endsection

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading"><strong></strong> <div class="pull-right"><strong></strong></div>
                </div>

                <div class="panel-body">

                    <div class="panel panel-default">
                        <div class="panel-heading"><strong>Tambakan Catatan Harian</strong></div>

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
                                        <button onclick="lanjutSubtansi()" type="button" class="btn btn-success pull-right" name="simpan" id="simpan"><span class="ion ion-android-exit" ></span> SIMPAN
                                        </button>
                                    </div>
                                </div>
                            </form>


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
        function getLatar() {
            var _token     = $('input[name = "_token"]').val();

            $.ajax({
                url: "{{ route('r_catatanharian.usulan',base64_encode($idtemp) ) }}",
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

           // getLatar();
        });

        function lanjutSubtansi() {
            var ringkasan  = $('#ringkas').Editor('getText');
            var _token     = $('input[name = "_token"]').val();

            $.ajax({
                url: "{{ route('r_catatanharian.subtansi.store', $idtemp) }}",
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
                        confirmButtonText: 'OK!',
                    }).then(function(isConfirm) {
                            if (isConfirm) {
                                window.location = "{{route('r_catatanharian.r_catatan.index', base64_encode($idtemp+127) )}}";

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
                url: "{{ route('penelitianng.ganti', $proposalid) }}",
                method: "POST",
                data: {ringkasan: ringkasan, katakunci: katakunci, lbelakang: lbelakang, literatur: literatur , metode: metode, jadwal: jadwal, pustaka: pustaka, _token: _token},
                success: function(result)
                {
                    swal({
                        title: 'Selamat!',
                        text: "Data Berhasil Diperbaharui",
                        type: 'success',
                        confirmButtonText: 'OK!',
                    }).then(function(isConfirm) {
                            if (isConfirm) {
                                window.location = "{{ route('validasipenelitian.show', '') }}/"+btoa(id);

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
