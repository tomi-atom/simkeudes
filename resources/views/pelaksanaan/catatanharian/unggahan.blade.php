@extends('layouts.app')

@section('title')
    Dokumen Pelaksanaan Kegiatan
@endsection

@section('breadcrumb')
    @parent
    <li>Catatan Harian</li>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
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

                <div class="panel-body">

                    <div class="panel panel-default">
                        <div class="panel-heading"><strong>Subtansi Usulan - Proposal Penelitian{{$proposal->prosalid}} </strong></div>

                        <div class="panel-body">
                            <form role="form" method="POST">
                                {{ csrf_field() }}

                                <div class="row">
                                    <p class="margin" align="justify"><b>RINGKASAN</b> <br><code>Ringkasan penelitian tidak lebih dari <kbd>500 kata</kbd> yang berisi latar belakang penelitian, tujuan dan tahapan metode penelitian, luaran yang ditargetkan, serta uraian TKT penelitian yang diusulkan.</code></p>

                                    <div class="col-sm-12">
                                        <textarea id="ringkas" name="ringkas" class="textarea form-control" rows="15"></textarea>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <p class="margin" align="justify"><b>KATA KUNCI</b> <br><code>Kata kunci maksimal <kbd>5 kata</kbd>, akhiri setiap kata kunci dengan ";"</code></p>

                                    <div class="col-sm-12">
                                        <input type="text" id="katakunci" name="katakunci" class="col-sm-12" required>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <p class="margin" align="justify"><b>LATAR BELAKANG</b> <br><code>Latar belakang penelitian tidak lebih dari <kbd>500 kata</kbd> yang berisi latar belakang dan permasalahan yang akan diteliti, tujuan khusus, dan urgensi penelitian. Pada bagian ini perlu dijelaskan uraian tentang spesifikasi khusus terkait dengan skema.</code></p>

                                    <div class="col-sm-12">
                                        <textarea id="latar" name="latar" class="textarea form-control" rows="30" placeholder="Latar Belakang ..."></textarea>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <p class="margin" align="justify"><b>TINJAUAN PUSTAKA</b> <br><code>Tinjauan pustaka tidak lebih dari <kbd>1.000 kata</kbd> dengan mengemukakan <i>state of the art</i> dan peta jalan (road map) dalam bidang yang diteliti. Bagan dan <i>road map</i> dibuat dalam bentuk JPG/PNG dengan ukuran tidak melebihi aturan <abbr title="Ukuran maksimal setiap gambar tidak melebihi 50 Kilo Byte"><kbd>(maks. 50KB)</kbd></abbr> yang kemudian disisipkan dalam isian ini. Sumber pustaka/referensi <i>primer</i> yang relevan dan dengan mengutamakan hasil penelitian pada jurnal ilmiah dan/atau paten yang terkini. Disarankan penggunaan sumber pustaka 10 tahun terakhir.</code></p>

                                    <div class="col-sm-12">
                                        <textarea id="literatur" name="literatur" class="textarea form-control" rows="30" placeholder="Tinjauan Pustaka ..."></textarea>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <p class="margin" align="justify"><b>METODE</b> <br><code>Metode atau cara untuk mencapai tujuan yang telah ditetapkan ditulis tidak melebihi <kbd>600 kata</kbd>. Bagian ini dilengkapi dengan diagram alir penelitian yang menggambarkan apa yang sudah dilaksanakan dan yang akan dikerjakan selama waktu yang diusulkan. Format diagram alir dapat berupa file JPG/PNG dengan ukuran tidak melebihi aturan <abbr title="Ukuran maksimal setiap gambar tidak melebihi 50 Kilo Byte"><kbd>(maks. 50KB)</kbd></abbr>. Bagan penelitian harus dibuat secara utuh dengan penahapan yang jelas, mulai dari awal bagaimana proses dan luarannya, dan indikator capaian yang ditargetkan. Di bagian ini harus juga mengisi tugas masing-masing anggota pengusul sesuai tahapan penelitian yang diusulkan.</code></p>

                                    <div class="col-sm-12">
                                        <textarea id="metode" name="metode" class="textarea form-control" rows="30" placeholder="Metode penelitian ..."></textarea>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <p class="margin" align="justify"><b>JADWAL</b> <br><code>Bagan jadwal penelitian dibuat dalam bentuk gambar dalam bentuk JPG/PNG dengan ukuran tidak melebihi aturan <abbr title="Ukuran maksimal gambar tidak melebihi 200 Kilo Byte"><kbd>(maks. 200KB)</kbd></abbr> </code></p>

                                    <div class="col-sm-12">
                                        <textarea id="jadwal" name="jadwal" class="textarea form-control" rows="10" placeholder="Metode penelitian ..."></textarea>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <p class="margin" align="justify"><b>DAFTAR PUSTAKA</b> <br><code>Daftar pustaka disusun dan ditulis berdasarkan sistem nomor sesuai dengan urutan pengutipan. Hanya pustaka yang disitasi pada usulan penelitian yang dicantumkan dalam Daftar Pustaka.</code></p>

                                    <div class="col-sm-12">
                                        <textarea id="pustaka" name="pustaka" class="textarea form-control" rows="10" placeholder="Metode penelitian ..."></textarea>
                                    </div>
                                </div>

                                <br>

                                <div class="row" id="tsimpan">
                                    <div class="col-md-12">
                                        <button onclick="lanjutSubtansi()" type="button" class="btn btn-success pull-right" name="simpan" id="simpan"><span class="ion ion-android-exit" ></span> LANJUTKAN
                                        </button>
                                    </div>
                                </div>
                            </form>

                            <div class="row" id="trobah">
                                <div class="col-md-12">
                                    <a href="{{route('validasipenelitian.show', base64_encode(mt_rand(10,99).(($idtemp - 135)*2+29)))}}" class="btn btn-default pull-left" name="awal" id="awal"><span class="fa fa-reply fa-fw"></span> Kembali</a>
                                    <button onclick="rubahSubtansi({{mt_rand(10,99).(($idtemp - 135)*2+29)}})" type="button" class="btn btn-primary pull-right" name="robah" id="robah"><span class="fa fa-floppy-o fa-fw" ></span> PERBAHARUI
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

        $(document).ready(function() {
            $("#ringkas").Editor();
            $("#latar").Editor();
            $("#literatur").Editor({"insert_img":true});
            $("#metode").Editor({"insert_img":true});
            $("#jadwal").Editor({"insert_img":true});

            $('#katakunci').val('');
            getLatar();
        });

        function lanjutSubtansi() {
            var ringkasan  = $('#ringkas').Editor('getText');
            var katakunci  = $('#katakunci').val();
            var lbelakang  = $('#latar').Editor('getText');
            var literatur  = $('#literatur').Editor('getText');
            var metode     = $('#metode').Editor('getText');
            var jadwal     = $('#jadwal').Editor('getText');
            var _token     = $('input[name = "_token"]').val();

            $.ajax({
                url: "{{ route('catatanharian.store', $proposalid) }}",
                method: "POST",
                data: {ringkasan: ringkasan, katakunci: katakunci, lbelakang: lbelakang, literatur: literatur , metode: metode, jadwal: jadwal, _token: _token},
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
                                window.location = "{{ route('catatanharian.index', $proposalid) }}";

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

