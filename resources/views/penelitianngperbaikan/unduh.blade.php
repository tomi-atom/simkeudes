<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading"><strong></strong> <div class="pull-right"><strong></strong></div></div>

            <div class="panel-body">

                <div class="panel panel-default">
                    <div class="panel-heading"><strong>Periode : {{$prop->periode->tahun}} | Batch {{$prop->periode->sesi}}</strong></div>

                    <div class="panel-body">
                        <div class="page-break">
                            <div class="box-header">
                                <i class="ion ion-clipboard"></i>
                                <h4 class="box-title">Pengusul: {{$ketua->nama}}</h4>
                                <b> JUDUL</b><br>{{$prop->judul}}
                                <br><b>RINGKASAN</b>{!! $usulan->ringkasan !!}
                                <br><b>KATA KUNCI : </b>{!! $usulan->katakunci !!}
                                <div class="page-break"></div>
                                <b>A. LATAR BELAKANG</b><br>{!! $usulan->lbelakang !!}
                                <br><br>
                                <b>B. TINJAUAN PUSTAKA</b><br>{!! $usulan->literatur !!}
                                <br><br>
                                <b>C. METODE</b><br>{!! $usulan->metode !!}
                                <br><br>
                                <b>D. JADWAL</b><br>{!! $usulan->jadwal !!}
                                <br><br>
                                <b>E. DAFTAR PUSTAKA</b><br>{!! $usulan->pustaka !!}
                            </div>

                        </div>

                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
<style>
    .page-break {
        page-break-after: always;
    }
</style>
