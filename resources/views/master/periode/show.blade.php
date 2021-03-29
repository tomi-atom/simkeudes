@extends('layouts.app')

@section('title')
    Identitas Usulan Penelitian
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

            <form role="form" method="POST" action="{{route('periode.update',[ base64_encode($proposal->id)])}}" name="formedit">
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
                                    <input type="datetime-local" class="form-control tanggal_mulai" name="tanggal_mulai" value="{{old($tanggal_mulai)}}"  required>
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
                                    <input type="datetime-local" class="form-control tanggal_akhir" name="tanggal_akhir" value="{{$periode->tanggal_akhir}}" required>
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
                                    <input type="datetime-local" class="form-control tm_perbaikan" name="tm_perbaikan"  required>
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
                                    <input type="datetime-local" class="form-control ta_perbaikan" name="ta_perbaikan" required>
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
                                    <input type="datetime-local" class="form-control tm_laporankemajuan" name="tm_laporankemajuan" placeholder="Tanggal Mulai Perbaikan Proposal" required>
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
                                    <input type="datetime-local" class="form-control ta_laporankemajuan" name="ta_laporankemajuan" placeholder="Tanggal Akhir Perbaikan Proposal" required>
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
                                    <input type="datetime-local" class="form-control tm_laporanakhir" name="tm_laporanakhir" placeholder="Tanggal Mulai Perbaikan Proposal" required>
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
                                    <input type="datetime-local" class="form-control ta_laporanakhir" name="ta_laporanakhir" placeholder="Tanggal Akhir Perbaikan Proposal" required>
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
                                        <option value="1"> Aktif</option>
                                        <option value="0"> Tidak Aktif </option>
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
    <script type="text/javascript">

        $(document).ready(function() {
            if (!$("#jenis").val()) {

                // $("#program").attr('disabled', true);
            }
        });
        /*
            function reloadProgram() {
                var indikator = $('#jenis').val();
                var _token    = $('input[name = "_token"]').val();

            }
        */
        $("#tkt1").change(function() {
            reloadTKT();
        });

        function reloadIlmu() {
            var select = 'ilmu2';
            var value  = $('#ilmu2').val();
            var dependent = 'ilmu3';
            var _token = $('input[name = "_token"]').val();

            $.ajax({
                url: "{{ route('penelitianng.fetch') }}",
                method: "POST",
                data: {select: select, value: value, _token: _token, dependent: dependent},
                success: function(result)
                {
                    $('#ilmu3').html(result);
                }
            });
        }

        $(".dynamic").change(function() {
            if($(this).val() != '') {
                var select = $(this).attr("id");
                var value  = $(this).val();
                var dependent = $(this).data('dependent');
                var _token = $('input[name = "_token"]').val();

                $.ajax({
                    url: "{{ route('penelitianng.fetch') }}",
                    method: "POST",
                    data: {select: select, value: value, _token: _token, dependent: dependent},
                    success: function(result)
                    {
                        $('#'+dependent).html(result);
                        reloadIlmu().load();
                    }
                })
            }
        });

    </script>
@endsection