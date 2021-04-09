@extends('layouts.app')

@section('title')
    Edit Periode
@endsection

@section('breadcrumb')
    @parent

    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/sweetalert2/1.3.3/sweetalert2.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/sweetalert2/0.4.5/sweetalert2.css">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/sweetalert2/1.3.3/sweetalert2.min.js"></script>
@endsection

@section('content')

    <div class="row">
        <div class="col-md-12">

            <form role="form" method="POST" action="{{route('periode.update',$periode->id)}}" name="formedit">
                {{ csrf_field() }} {{ method_field('PATCH') }}



                <div class="panel panel-default">
                    <div class="panel-heading"><strong>Edit Periode  </strong></div>

                    <div class="panel-body">


                        <div class="form-group row">
                            <div class="col-sm-3">
                                <label class="control-label col-sm-offset-2">Tahun</label>
                            </div>
                            <div class="col-sm-8">
                                <div class="col-sm-6 input-group input-group-sm">
                                    <input type="text" class="form-control tahun" name="tahun" value="{{$periode->tahun}}" required>
                                </div>
                            </div>
                        </div>
                        <p></p>
                        <div class="form-group row">
                            <div class="col-sm-3">
                                <label class="control-label col-sm-offset-2">Sesi</label>
                            </div>
                            <div class="col-sm-8">
                                <div class="col-sm-6 input-group input-group-sm">
                                    <input type="text" class="form-control sesi" name="sesi" value="{{$periode->sesi}}" required>
                                </div>
                            </div>
                        </div>

                        <p></p>
                        <div class="form-group row">
                            <div class="col-sm-3">
                                <label class="control-label col-sm-offset-2">Jenis</label>
                            </div>
                            <div class="col-sm-8">
                                <div class="col-sm-6 input-group input-group-sm">
                                    <select name="jenis" id="jenis" class="form-control"  required>
                                        <option value="">-- Pilih Jenis --</option>
                                        <option value="1"{{ $periode->jenis == 1 ? 'selected' : '' }}>Penelitian</option>
                                        <option value="2"{{ $periode->jenis == 2 ? 'selected' : '' }}>Pengabdian</option>

                                    </select>
                                </div>
                            </div>
                        </div>
                        <p></p>
                        <div class="form-group row">
                            <div class="col-sm-3">
                                <label class="control-label col-sm-offset-2"> Program</label>
                            </div>
                            <div class="col-sm-8">
                                <div class="col-sm-6 input-group input-group-sm">
                                    <select id="program" class="form-control" name="program" required >
                                        <option value=""> -- Pilih Program --</option>

                                        @foreach($program as $list)
                                            <option value="{{$list->id}}" {{$periode->program == $list->id ? 'selected' : ''}}> {{$list->program}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <p></p>
                        <div class="form-group row">
                            <div class="col-sm-3">
                                <label class="control-label col-sm-offset-2">Tanggal Mulai Input Proposal</label>
                            </div>
                            <div class="col-sm-8">
                                <div class="col-sm-6 input-group input-group-sm">
                                    <input type="text" class="form-control tanggal_mulai" name="tanggal_mulai" value="{{ Carbon\Carbon::parse($periode->tanggal_mulai)->format('Y/m/d h:i:s')}}"  required>

                                </div>
                            </div>
                        </div>
                        <p></p>
                        <div class="form-group row">
                            <div class="col-sm-3">
                                <label class="control-label col-sm-offset-2">Tanggal Akhir Input Proposal</label>
                            </div>
                            <div class="col-sm-8">
                                <div class="col-sm-6 input-group input-group-sm">
                                    <input type="text" class="form-control tanggal_akhir" name="tanggal_akhir" value="{{ Carbon\Carbon::parse($periode->tanggal_akhir)->format('Y/m/d h:i:s')}}" required>
                                </div>
                            </div>
                        </div>
                        <p></p>

                        <div class="form-group row">
                            <div class="col-sm-3">
                                <label class="control-label col-sm-offset-2">Tanggal Mulai Perbaikan Proposal</label>
                            </div>
                            <div class="col-sm-8">
                                <div class="col-sm-6 input-group input-group-sm">
                                    <input type="text" class="form-control tm_perbaikan" name="tm_perbaikan" value="{{ Carbon\Carbon::parse($periode->tm_perbaikan)->format('Y/m/d h:i:s')}}" required>
                                </div>
                            </div>
                        </div>
                        <p></p>
                        <div class="form-group row">
                            <div class="col-sm-3">
                                <label class="control-label col-sm-offset-2">Tanggal Akhir Perbaikan Proposal</label>
                            </div>
                            <div class="col-sm-8">
                                <div class="col-sm-6 input-group input-group-sm">
                                    <input type="text" class="form-control ta_perbaikan" name="ta_perbaikan" value="{{ Carbon\Carbon::parse($periode->ta_perbaikan)->format('Y/m/d h:i:s')}}" required>
                                </div>
                            </div>
                        </div>
                        <p></p>


                        <div class="form-group row">
                            <div class="col-sm-3">
                                <label class="control-label col-sm-offset-2">Tanggal Mulai Monev Kemajuan</label>
                            </div>
                            <div class="col-sm-8">
                                <div class="col-sm-6 input-group input-group-sm">
                                    <input type="text" class="form-control tm_laporankemajuan" name="tm_laporankemajuan" value="{{ Carbon\Carbon::parse($periode->tm_laporankemajuan)->format('Y/m/d h:i:s')}}" required>
                                </div>
                            </div>
                        </div>
                        <p></p>
                        <div class="form-group row">
                            <div class="col-sm-3">
                                <label class="control-label col-sm-offset-2">Tanggal Akhir Monev Kemajuan</label>
                            </div>
                            <div class="col-sm-8">
                                <div class="col-sm-6 input-group input-group-sm">
                                    <input type="text" class="form-control ta_laporankemajuan" name="ta_laporankemajuan" value="{{ Carbon\Carbon::parse($periode->ta_laporankemajuan)->format('Y/m/d h:i:s' )}}" required>
                                </div>
                            </div>
                        </div>
                        <p></p>

                        <div class="form-group row">
                            <div class="col-sm-3">
                                <label class="control-label col-sm-offset-2">Tanggal Mulai Monev Hasil</label>
                            </div>
                            <div class="col-sm-8">
                                <div class="col-sm-6 input-group input-group-sm">
                                    <input type="text" class="form-control tm_laporanakhir" name="tm_laporanakhir" value="{{ Carbon\Carbon::parse($periode->tm_laporanakhir)->format('Y/m/d h:i:s')}}" required>
                                </div>
                            </div>
                        </div>
                        <p></p>
                        <div class="form-group row">
                            <div class="col-sm-3">
                                <label class="control-label col-sm-offset-2">Tanggal Akhir Monev Hasil</label>
                            </div>
                            <div class="col-sm-8">
                                <div class="col-sm-6 input-group input-group-sm">
                                    <input type="text" class="form-control ta_laporanakhir" name="ta_laporanakhir" value="{{ Carbon\Carbon::parse($periode->ta_laporanakhir)->format('Y/m/d h:i:s')}}" required>
                                </div>
                            </div>
                        </div>
                        <p></p>





                        <p></p>
                        <div class="form-group row">
                            <div class="col-sm-3">
                                <label class="control-label col-sm-offset-2">Aktif</label>
                            </div>
                            <div class="col-sm-8">
                                <div class="col-sm-6 input-group input-group-sm">
                                    <select class="form-control" id="aktif" name="aktif" required>
                                        <option value="1"{{ $periode->aktif == 1 ? 'selected' : '' }}> Aktif</option>
                                        <option value="0"{{ $periode->aktif == 0 ? 'selected' : '' }}> Tidak Aktif </option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <p>. </p>
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-success pull-right" name="submit" id="submit" >
                                    <span class="ion ion-android-exit"></span> Update
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('script')

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/momentjs/2.14.1/moment.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>

    <script type="text/javascript">
        $(function () {
            $('#tanggal_mulai').datetimepicker({
                showOn: "button",
                showSecond: true,
                dateFormat: "yy-mm-dd",
                timeFormat: "HH:mm:ss"
            });
            $('.tanggal_akhir').datetimepicker(
                showOn: "button",
                showSecond: true,
                dateFormat: "yy-mm-dd",
                timeFormat: "HH:mm:ss"
        });
            $('.tm_perbaikan').datetimepicker();
            $('.ta_perbaikan').datetimepicker();
            $('.tm_laporankemajuan').datetimepicker();
            $('.ta_laporankemajuan').datetimepicker();
            $('.tm_laporanakhir').datetimepicker();
            $('.ta_laporanakhir').datetimepicker();
        });
    </script>
@endsection