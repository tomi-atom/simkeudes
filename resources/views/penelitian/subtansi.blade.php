@extends('layouts.app')

@section('addonhref')
<link rel="stylesheet" href="{{ asset('public/adminLTE/plugins/responsive-editor/editor.css') }}">
@endsection

@section('title')
	Proposal Usulan
@endsection

@section('breadcrumb')
	@parent
    <li><a href="{{ route('penelitian.index') }}">Penelitian</a></li>
    <li>Pengusul</li>
    <li>Subtansi Usulan</li>
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading"><strong></strong> <div class="pull-right"><strong></strong></div>
            </div>
            
            <div class="panel-body">
                
                <div class="panel panel-default">
                    <div class="panel-heading"><strong>Subtansi Usulan - Proposal Penelitian </strong></div>
            
                    <div class="panel-body">
                    <form role="form" method="POST">
                    {{ csrf_field() }}
                        <input type="hidden" name="dosenid" id="dosenid" value="{{ $proposalid }}" readonly>

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
                               <input type="text" id="katakunci" name="katakunci" class="col-sm-12">
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

                        <br>
                        <div class="row">
                            <div class="col-md-12">
                                <button onclick="lanjutSubtansi()" type="button" class="btn btn-success pull-right" name="simpan" id="simpan"><span class="fa fa-angle-double-right fa-fw"></span>LANJUTKAN
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
    $(document).ready(function() {
        $("#ringkas").Editor();
        $("#latar").Editor();
        $("#literatur").Editor({"insert_img":true});
        $("#metode").Editor({"insert_img":true});
        $("#jadwal").Editor({"insert_img":true});
        $("#pustaka").Editor();
    });

    function lanjutSubtansi() {
        var propid     = $("#dosenid").val();
        var ringkasan  = $('#ringkas').Editor('getText');
        var katakunci  = $('#katakunci').val();
        var lbelakang  = $('#latar').Editor('getText');
        var literatur  = $('#literatur').Editor('getText');
        var metode     = $('#metode').Editor('getText');
        var jadwal     = $('#jadwal').Editor('getText');
        var pustaka    = $('#pustaka').Editor('getText');
        var _token     = $('input[name = "_token"]').val();

        $.ajax({
            url: "{{ route('penelitian.unggah') }}",
            method: "POST",
            data: {propid: propid, ringkasan: ringkasan, katakunci: katakunci, lbelakang: lbelakang, literatur: literatur , metode: metode, jadwal: jadwal, pustaka: pustaka, _token: _token},
            success: function(result)
            {
                window.location = "{{ route('penelitian.luaran',base64_encode($proposalid+2)) }}";
            },
            error : function() {
                alert("Tidak dapat menyimpan data");
            }
        });
    }
</script>
@endsection
