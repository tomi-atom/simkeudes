@extends('layouts.app')

@section('addonhref')
<link rel="stylesheet" href="{{ asset('public/adminLTE/plugins/responsive-editor/editor.css') }}">
@endsection

@section('title')
	Proposal Usulan
@endsection

@section('breadcrumb')
	@parent
    <li><a href="{{ route('perbaikanpengabdianng.index') }}">Pengabdian</a></li>
    <li>Pengusul</li>
    <li>Subtansi Usulan</li>
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
                    <div class="panel-heading"><strong>Subtansi Usulan - Proposal Pengabdian </strong></div>
            
                    <div class="panel-body">
                    <form role="form" method="POST">
                    {{ csrf_field() }}
                        
                        <div class="row">
                            <p class="margin" align="justify"><b>RINGKASAN</b> <br><code>Ringkasan usulan maksimal <kbd>500 kata</kbd> yang memuat permasalahan, solusi dan target luaran yang akan dicapai sesuai dengan masing-masing skema pengabdian kepada masyarakat. Ringkasan juga memuat uraian secara cermat dan singkat rencana kegiatan yang diusulkan.</code></p>
                            
                            <div class="col-sm-12">
                                <textarea id="ringkas" name="ringkas" class="textarea form-control" rows="15"></textarea>
                            </div>
                        </div>
                        <hr> 
                        <div class="row">
                            <p class="margin" align="justify"><b>KATA KUNCI</b> <br><code>Kata kunci maksimal <kbd>5 kata</kbd>, akhiri setiap kata kunci dengan ";"</code></p>
                            
                            <div class="col-sm-12">
                               <input type="text" id="katakunci" name="katakunci" class="col-sm-12">
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <p class="margin" align="justify"><b>PENDAHULUAN</b> <br><code>Bagian pendahuluan maksimum <kbd>2.000 kata</kbd> kata yang berisi uraian analisis situasi dan permasalahan mitra, bagan dan <i>road map</i> dibuat dalam bentuk JPG/PNG dengan ukuran tidak melebihi aturan <abbr title="Ukuran maksimal setiap gambar tidak melebihi 50 Kilo Byte"><kbd>(maks. 50KB)</kbd></abbr> yang kemudian disisipkan dalam isian ini. Deskripsi lengkap bagian pendahuluan memuat hal-hal berikut:<br><b>1. ANALISIS SITUASI</b><br>Pada bagian ini diuraikan analisis situasi fokus kepada kondisi terkini mitra yang mencakup hal-hal berikut.<br>
                            <b>a. Untuk Mitra yang bergerak di bidang ekonomi produktif</b>
                            <br>&nbsp;&nbsp;&nbsp;- Tampilkan profil mitra yang dilengkapi dengan data dan gambar/foto situasi mitra.
                            <br>&nbsp;&nbsp;&nbsp;- Uraikan segi produksi dan manajemen usaha mitra.
                            <br>&nbsp;&nbsp;&nbsp;- Ungkapkan selengkap mungkin persoalan yang dihadapi mitra.<br>
                            <b>b. Untuk Mitra yang mengarah ke ekonomi produktif</b>
                            <br>&nbsp;&nbsp;&nbsp;- Tampilkan profil mitra yang dilengkapi dengan data dan gambar/foto situasi mitra.
                            <br>&nbsp;&nbsp;&nbsp;- Jelaskan potensi dan peluang usaha mitra.
                            <br>&nbsp;&nbsp;&nbsp;- Uraiankan dan kelompokkan dari segi produksi dan manajemen usaha.
                            <br>&nbsp;&nbsp;&nbsp;- Ungkapkan seluruh persoalan kondisi sumber daya yang dihadapi mitra.<br>
                            <b>c. Untuk Mitra yang tidak  produktif secara ekonomi / sosial</b>
                            <br>&nbsp;&nbsp;&nbsp;- Uraiakan lokasi mitra dan kasus yang terjadi/pernah terjadi dan didukung dengan data dan gambar/foto.
                            <br>&nbsp;&nbsp;&nbsp;- Ungkapkan seluruh persoalan yang dihadapi saat ini misal terkait dengan layanan kesehatan, pendidikan, keamanan, konflik sosial, kepemilikan
                            <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;lahan, kebutuhan air bersih, premanisme, buta aksara dan lain-lain.<br>
                            <b>2. PERMASALAHAN MITRA</b><br>
                            Mengacu kepada butir Analisis Situasi, uraikan permasalahan prioritas mitra yang mencakup hal-hal berikut ini.<br>
                            a. Untuk Mitra yang bergerak di bidang ekonomi produktif: penentuan permasalahan prioritas mitra baik produksi maupun manajemen yang telah disepakati bersama mitra.<br>
                            b. Untuk Mitra yang mengarah ke ekonomi produktif: penentuan permasalahan prioritas mitra baik produksi maupun manajemen untuk berwirausaha yang disepakati bersama.<br>
                            c. Untuk Mitra yang tidak  produktif secara ekonomi / sosial: nyatakan persoalan prioritas mitra dalam layanan kesehatan, pendidikan, keamanan, konflik sosial, kepemilikan lahan, kebutuhan air bersih, premanisme, buta aksara dan lain-lain.<br>
                            d. Tuliskan secara jelas justifikasi pengusul bersama mitra dalam menentukan persoalan prioritas yang disepakati untuk diselesaikan selama pelaksanaan program PKM.</code></p>
                            
                            <div class="col-sm-12">
                                <textarea id="latar" name="latar" class="textarea form-control" rows="30" placeholder="Latar Belakang ..."></textarea>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <p class="margin" align="justify"><b>SOLUSI PERMASALAHAN</b> <br><code>Solusi permasalahan maksimum terdiri atas  <kbd>1.500 kata</kbd> yang berisi uraian semua solusi yang ditawarkan untuk menyelesaikan permasalahan yang dihadapi, bagan dan <i>road map</i> dibuat dalam bentuk JPG/PNG dengan ukuran tidak melebihi aturan <abbr title="Ukuran maksimal setiap gambar tidak melebihi 50 Kilo Byte"><kbd>(maks. 50KB)</kbd></abbr> yang kemudian disisipkan dalam isian ini. Deskripsi lengkap bagian solusi permasalahan memuat hal-hal berikut.<br>
                            a. Tuliskan semua solusi yang ditawarkan untuk menyelesaikan permasalahan yang dihadapi mitra secara sistematis sesuai dengan prioritas permasalahan. Solusi harus terkait betul dengan permasalahan prioritas mitra.<br>
                            b. Tuliskan jenis luaran yang akan dihasilkan dari masing-masing solusi tersebut baik dalam segi produksi maupun manajemen usaha (untuk mitra ekonomi produktif / mengarah ke ekonomi produktif) atau sesuai dengan solusi spesifik atas permasalahan yang dihadapi mitra dari kelompok masyarakat yang tidak produktif secara ekonomi / sosial.<br>
                            c. Setiap solusi mempunyai luaran tersendiri dan sedapat mungkin terukur atau dapat dikuantitatifkan.<br>
                            d. Uraikan hasil riset tim pengusul yang berkaitan dengan kegiatan yang akan dilaksanakan
                            </code></p>
                            
                            <div class="col-sm-12">
                                <textarea id="literatur" name="literatur" class="textarea form-control" rows="30" placeholder="Tinjauan Pustaka ..."></textarea>
                            </div>
                        </div>
                        <hr> 
                        <div class="row">
                            <p class="margin" align="justify"><b>METODE PELAKSANAAN</b> <br><code>Metode pelaksanaan maksimal terdiri atas <kbd>2.000 kata</kbd>. yang menjelaskan tahapan atau langkah-langkah dalam melaksanakan solusi yang ditawarkan untuk mengatasi permasalahan mitra. Format diagram alir dapat berupa file JPG/PNG dengan ukuran tidak melebihi aturan <abbr title="Ukuran maksimal setiap gambar tidak melebihi 50 Kilo Byte"><kbd>(maks. 50KB)</kbd></abbr>. yang menjelaskan tahapan atau langkah-langkah dalam melaksanakan solusi yang ditawarkan untuk mengatasi permasalahan mitra. Deskripsi lengkap bagian metode pelaksanaan untuk mengatasi permasalahan sesuai tahapan berikut.<br>
                            1. Untuk Mitra yang bergerak di bidang ekonomi produktif dan mengarah ke ekonomi produktif, maka metode pelaksanaan kegiatan terkait dengan tahapan pada minimal 2 (dua) bidang permasalahan yang berbeda yang ditangani pada mitra, seperti: <br>
                            &nbsp;&nbsp;a. Permasalahan dalam bidang produksi. <br>
                            &nbsp;&nbsp;b. Permasalahan dalam bidang manajemen. <br>
                            &nbsp;&nbsp;c. Permasalahan dalam bidang pemasaran, dan lain-lain.<br>
                            2.  Untuk Mitra yang tidak produktif secara ekonomi / sosial, nyatakan tahapan atau langkah-langkah yang ditempuh guna melaksanakan solusi atas permasalahan spesifik yang dihadapi oleh mitra. Pelaksanaan solusi tersebut dibuat secara sistematis yang meliputi layanan kesehatan, pendidikan, keamanan, konflik sosial, kepemilikan lahan, kebutuhan air bersih, premanisme, buta aksara dan lain-lain.<br>
                            3. Uraikan bagaimana partisipasi mitra dalam pelaksanaan program.<br>
                            4. Uraikan bagaimana evaluasi pelaksanaan program dan keberlanjutan program di lapangan setelah kegiatan PKM selesai dilaksanakan.
                            </code></p>
                            
                            <div class="col-sm-12">
                                <textarea id="metode" name="metode" class="textarea form-control" rows="30" placeholder="Metode pelaksanaan ..."></textarea>
                            </div>
                        </div>
                        <hr> 
                        <div class="row">
                            <p class="margin" align="justify"><b>JADWAL</b> <br><code>Bagan jadwal pelaksanaan PKM  dibuat dalam bentuk gambar dalam bentuk JPG/PNG dengan ukuran tidak melebihi aturan <abbr title="Ukuran maksimal gambar tidak melebihi 200 Kilo Byte"><kbd>(maks. 200KB)</kbd></abbr> yang kemudian disisipkan dalam isian bagian ini. </code></p>
                            
                            <div class="col-sm-12">
                                <textarea id="jadwal" name="jadwal" class="textarea form-control" rows="10" placeholder="Metode pengabdian ..."></textarea>
                            </div>
                        </div>
                        <hr> 
                        <div class="row">
                            <p class="margin" align="justify"><b>DAFTAR PUSTAKA</b> <br><code>Daftar pustaka disusun dan ditulis berdasarkan sistem nomor sesuai dengan urutan pengutipan. Hanya pustaka yang disitasi pada usulan yang dicantumkan dalam Daftar Pustaka.</code></p>
                            
                            <div class="col-sm-12">
                                <textarea id="pustaka" name="pustaka" class="textarea form-control" rows="10" placeholder="Metode pengabdian ..."></textarea>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <p class="margin" align="justify"><b>GAMBARAN IPTEK</b> <br><code>Gambaran iptek berisi uraian maksimal <kbd>500 kata</kbd> menjelaskan gambaran iptek yang akan diimplentasikan di mitra sasaran.</code></p>
                            
                            <div class="col-sm-12">
                                <textarea id="iptek" name="iptek" class="textarea form-control" rows="10" placeholder="Metode pengabdian ..."></textarea>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <p class="margin" align="justify"><b>PETA LOKASI MITRA SASARAN</b> <br><code>Peta lokasi mitra sasaran berisikan gambar peta lokasi mitra yang dilengkapi dengan penjelasan jarak mitra sasaran dengan PT pengusul. Format peta dan bagan lokasi dapat berupa file JPG/PNG dengan ukuran tidak melebihi aturan <abbr title="Ukuran maksimal keseluruhan peta dan bagan tidak melebihi 1.024 Kilo Byte"><kbd>(maks. 1 MB)</kbd></abbr>.</code></p>
                            
                            <div class="col-sm-12">
                                <textarea id="peta" name="peta" class="textarea form-control" rows="10" placeholder="Metode pengabdian ..."></textarea>
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
                            <a href="{{route('validasiperbaikanpengabdian.show', base64_encode(mt_rand(10,99).(($idtemp - 135)*2+29)))}}" class="btn btn-default pull-left" name="awal" id="awal"><span class="fa fa-reply fa-fw"></span> Kembali</a>
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
    function getLatar() {
        var _token     = $('input[name = "_token"]').val();
         $.ajax({
            url: "{{ route('perbaikanpengabdianng.usulan', $proposalid) }}",
            method: "POST",
            dataType: "json",
            data: {_token: _token},
            success: function(result)
            {
                if (result) {
                    $("#ringkas").Editor("setText", result[0]);
                    $('#katakunci').val(result[1]);
                    $('#latar').Editor("setText", result[2]);
                    $('#literatur').Editor("setText", result[3]);
                    $('#metode').Editor("setText", result[4]);
                    $('#jadwal').Editor("setText", result[5]);
                    $('#pustaka').Editor("setText", result[6]);
                    $('#iptek').Editor("setText", result[7]);
                    $('#peta').Editor("setText", result[8]);

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
        $("#ringkas").Editor();
        $("#latar").Editor();
        $("#literatur").Editor({"insert_img":true});
        $("#metode").Editor({"insert_img":true});
        $("#jadwal").Editor({"insert_img":true});
        $("#pustaka").Editor();
        $("#iptek").Editor();
        $("#peta").Editor({"insert_img":true});

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
        var pustaka    = $('#pustaka').Editor('getText');
        var iptek      = $('#iptek').Editor('getText');
        var peta       = $('#peta').Editor('getText');
        var _token     = $('input[name = "_token"]').val();

        $.ajax({
            url: "{{ route('perbaikanpengabdianng.subtansi.store', $proposalid) }}",
            method: "POST",
            data: {ringkasan: ringkasan, katakunci: katakunci, lbelakang: lbelakang, literatur: literatur , metode: metode, jadwal: jadwal, pustaka: pustaka, iptek: iptek, peta:peta, _token: _token},
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
                            window.location = "{{ route('perbaikanpengabdianng.luaran.index', $proposalid) }}";

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

    function rubahSubtansi(id) {
        var ringkasan  = $('#ringkas').Editor('getText');
        var katakunci  = $('#katakunci').val();
        var lbelakang  = $('#latar').Editor('getText');
        var literatur  = $('#literatur').Editor('getText');
        var metode     = $('#metode').Editor('getText');
        var jadwal     = $('#jadwal').Editor('getText');
        var pustaka    = $('#pustaka').Editor('getText');
        var _token     = $('input[name = "_token"]').val();
        var iptek      = $('#iptek').Editor('getText');
        var peta       = $('#peta').Editor('getText');

        $.ajax({
            url: "{{ route('perbaikanpengabdianng.ganti', $proposalid) }}",
            method: "POST",
            data: {ringkasan: ringkasan, katakunci: katakunci, lbelakang: lbelakang, literatur: literatur , metode: metode, jadwal: jadwal, pustaka: pustaka, iptek: iptek, peta:peta, _token: _token},
            success: function(result)
            {
                swal({
                    title: 'Selamat!',
                    text: "Data Berhasil Diperbaharui",
                    type: 'success',
                    confirmButtonText: 'OK!',
                }).then(function(isConfirm) {
                        if (isConfirm) {
                            window.location = "{{ route('validasiperbaikanpengabdian.show', '') }}/"+btoa(id);

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
