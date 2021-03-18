@extends('layouts.app')

@section('addonhref')
<link rel="stylesheet" href="{{ asset('public/adminLTE/plugins/responsive-editor/editor.css') }}">
@endsection

@section('title')
	Proposal Usulan
@endsection

@section('breadcrumb')
	@parent
    <li><a href="{{ route('pengabdianng.index') }}">Pengabdian</a></li>
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
                    <div class="panel-heading"><strong>Subtansi Usulann - Proposal Pengabdian - <code>Tekan tombol CTRL dan diikuti dgn V di keyboard untuk Paste data</code> </strong></div>
            
                    <div class="panel-body">
                    <form role="form" method="POST">
                    {{ csrf_field() }}
                        
                        <div class="row">
                            <p class="margin" align="justify"><b>ANALISIS SITUASI</b> <br><code>Analisis Situasi usulan maksimal <kbd>800 kata</kbd> Gambarkan secara kuantitatif potret, profil dan kondisi khalayak sasaran yang akan
							dilibatkan dalam kegiatan pengabdian kepada masyarakat. Gambarkan pula kondisi dan
							potensi wilayah dari segi fisik, sosial, ekonomi maupun lingkungan yang relevan dengan
							kegiatan yang akan dilakukan. Pengabdian yang dilakukan harus berbasis penenelitian
							(baik penelitian sendiri maupun hasil riset orang lain).</code></p>
                            
                            <div class="col-sm-12">
                                <textarea id="ringkas" name="ringkas" class="textarea form-control" rows="15"></textarea>
                            </div>
                        </div>
                        <hr> 
                        <div class="row">
                            <p class="margin" align="justify"><b>IDENTIFIKASI DAN PERUMUSAN MASALAH</b> <br><code>Identifikasi dan Perumusan Masalah <kbd>200 kata</kbd>, Identifikasi permasalahan dan potensi sumberdaya yang ada di daerah sasaran untuk
							dijadikan sebagai sumber ide kegiatan pengabdian. Berikan informasi potensi yang dapat
							dijadikan sebagai bahan kegiatan pengabdian kepada masyarakat. Rumuskan masalah
							secara konkrit dan jelas. Perumusan masalah menjelaskan pula definisi, asumsi dan
							lingkup yang menjadi batasan kegiatan pengabdian kepada masyarakat.</code></p>
                            
                            <div class="col-sm-12">
                               <textarea  id="katakunci" name="katakunci" class="textarea form-control" rows="8"></textarea>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <p class="margin" align="justify"><b>TINJAUAN PUSTAKA</b> <br><code>Bagian Tinjauan Pustaka maksimum <kbd>2.000 kata</kbd> Uraikan dengan jelas kajian pustaka yang menimbulkan gagasan yang mendasari
							kegiatan pengabdian kepada masyarakat yang akan dilakukan, terutama dari hasil-hasil
							riset sebelumnya. Tinjauan Pustaka menguraikan teori, temuan dan bahan kegiatan
							pengabdian kepada masyarakat yang diperoleh dari pustaka/sumber literature. Sumber
							literature berfungsi sebagai landasan untuk melakukan kegiatan pengabdian kepada
							masyarakat yang diusulkan. Uraian dalam tinjauan pustaka untuk menyusun kerangka
							atau konsep yang akan digunakan dalam kegiatan pengabdian kepada masyarakat.
							Tinjauan pustaka mengacu pada daftar pustaka.</code></p>
														
                            <div class="col-sm-12">
                                <textarea id="latar" name="latar" class="textarea form-control" rows="30" placeholder="Latar Belakang ..."></textarea>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <p class="margin" align="justify"><b>TUJUAN KEGIATAN</b> <br><code>Tujuan Kegiatan maksimum terdiri atas  <kbd>200 kata</kbd> yang berisi Kemukakan tujuan yang akan dicapai secara spesifik yang merupakan kondisi baru yang
							diharapkan terwujud setelah kegiatan pengabdian kepada masyarakat selesai (tujuan
							harus konsisten dengan judul pengabdian). Rumusan tujuan hendaknya jelas dan dapat
							di ukur. Untuk mencapai tujuan perlu dijelaskan langkah-langkah apa yang harus
							diketahui, informasi apa yang diperlukan, bentuk kegiatan/perlakuan yang harus
							dikerjakan oleh tim.
                            </code></p>
                            
                            <div class="col-sm-12">
                                <textarea id="literatur" name="literatur" class="textarea form-control" rows="30" placeholder="Tinjauan Pustaka ..."></textarea>
                            </div>
                        </div>
                        <hr> 
                        <div class="row">
                            <p class="margin" align="justify"><b>MANFAAT KEGIATAN</b> <br><code>Manfaat Kegiatan maksimal terdiri atas <kbd>500 kata</kbd>. yang menjelaskan Uraikan manfaat bagi khalayak sasaran, dari sisi ekonomi maupun pengembangan ilmu
							pengetahuan. Jika dalam bentuk penerapan teknologi tepat guna (TTG) perlu dijelaskan
							kegunaannya dan nilai tambah yang diharapkan. Apabila dalam bentuk kebijakan perlu
							dijelaskan perubahan yang diharapkan setelah kegiatan tersebut. Pengabdian kepada
							masyarakat merupakan penyebaran ilmu pengetahuan, teknologi dan seni yang dapat
							dimanfaatkan secara langsung oleh masyarakat.</code></p>
														
                            <div class="col-sm-12">
                                <textarea id="metode" name="metode" class="textarea form-control" rows="30" placeholder="Metode pelaksanaan ..."></textarea>
                            </div>
                        </div>
                        <hr> 
                        <div class="row">
                            <p class="margin" align="justify"><b>MASYARAKAT SASARAN</b> <br><code>Jelaskan secara rinci siapa (individu/kelompok) anggota khalayak sasaran yang dianggap
							strategis (mampu dan mau) untuk dilibatkan dalam kegiatan pengabdian kepada
							masyarakat. Ungkapkan juga potensi pembiasan manfaat kegiatan kepada kelompok
							lain.</code></p>
                            
                            <div class="col-sm-12">
                                <textarea id="pustaka" name="pustaka" class="textarea form-control" rows="10" placeholder="Metode pengabdian ..."></textarea>
                            </div>
                        </div>
                        <hr>
						<div class="row">
                            <p class="margin" align="justify"><b>METODE PENERAPAN</b> <br><code>Metode Penerapan berisi uraian maksimal <kbd>500 kata</kbd> Uraikan dengan jelas metode yang digunakan untuk mencapai tujuan yang telah
							dicanangkan dalam kegiatan pengabdian. Langkah-langkah kerja tim dan tanggung
							jawab masing-masing anggota maupun narasumber harus rinci. Jika hasil pengabdian itu
							harus dapat diukur, jelaskan alat ukur yang dipakai (baik secara deskriptif maupun
							kualitatif). Pengabdian harus terintegrasi dengan kuliah kerja nyata (Kukerta) Universitas
							Riau. Jelaskan tahap kegiatan yang melibatkan mahasiswa Kukerta. Kegiatan harus
							dirancang minimum untuk 14 kunjungan/pertemuan. Bagi kegiatan pengabdian
							multitahun, harus dapat menjelaskan kegiatan dan target setiap tahun..</code></p>
														
                            <div class="col-sm-12">
                                <textarea id="iptek" name="iptek" class="textarea form-control" rows="10" placeholder="Metode pengabdian ..."></textarea>
                            </div>
                        </div>
						<hr>
						
						<div class="row">
                            <p class="margin" align="justify"><b>JADWAL PELAKSANAAN</b> <br><code>Bagan jadwal pelaksanaan PKM  dibuat dalam bentuk gambar dalam bentuk JPG/PNG dengan ukuran tidak melebihi aturan <abbr title="Ukuran maksimal gambar tidak melebihi 200 Kilo Byte"><kbd>(maks. 200KB)</kbd></abbr> Gambarkan tahap–tahap kegiatan dan jadwal secara spesifik dan jelas dalam suatu
							satuan waktu (minimal satuan minggu). Jelaskan pula apa yang akan dikerjakan, kapan
							dan dimana. Sebaiknya diungkapkan dalam bentuk diagram/tabel. Kegiatan pengabdian
							dilakukan dalam rentang waktu 4-8 bulan. </code></p>
                            
                            <div class="col-sm-12">
                                <textarea id="jadwal" name="jadwal" class="textarea form-control" rows="10" placeholder="Metode pengabdian ..."></textarea>
                            </div>
                        </div>
                        <hr> 
                        
                        
                        <hr>
                        <div class="row">
                            <p class="margin" align="justify"><b>HASIL DAN KETERCAPAIAN SASARAN</b> <br><code>Uraikan bagaimana dan kapan evaluasi akan dilakukan. Apa saja kriteria, indikator
							pencapaian tujuan dan tolak ukur yang digunakan untuk menyatakan keberhasilan dari
							kegiatan pengabdian yang dilakukan. Pengabdian kepada masyarakat adalah usaha
							untuk menyebarluaskan ilmu pengetahuan, teknologi dan seni kepada masyarakat.
							Kegiatan tersebut harus mampu memberikan suatu nilai tambah bagi masyarakat, baik
							dalam kegiatan ekonomi, kebijakan, perubahan perilaku (sosial). Uraikan bahwa kegiatan
							pengabdian harus mampu memberi perubahan bagi individu/masyarakat maupun institusi
							baik jangka pendek maupun jangka panjang.
							Program Desa Binaan: Kegiatan program desa binaan (PDB) bersifat multitahun.
							Jelaskan langkah dan bentuk kegiatan pertahunnya. Jelaskan roadmap pengabdian
							untuk beberapa tahun ke depan. Pada akhir tahun ungkapkan tingkat ketercapaian
							program. Uraikan bentuk program yang akan dilakukan pada tahun berikutnya.</code></p>
                            
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
                            <a href="{{route('validasipengabdian.show', base64_encode(mt_rand(10,99).(($idtemp - 135)*2+29)))}}" class="btn btn-default pull-left" name="awal" id="awal"><span class="fa fa-reply fa-fw"></span> Kembali</a> 
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
            url: "{{ route('pengabdianng.usulan', $proposalid) }}",
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
            url: "{{ route('pengabdianng.subtansi.store', $proposalid) }}",
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
                            window.location = "{{ route('pengabdianng.luaran.index', $proposalid) }}";

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
            url: "{{ route('pengabdianng.ganti', $proposalid) }}",
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
                            window.location = "{{ route('validasipengabdian.show', '') }}/"+btoa(id);

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
