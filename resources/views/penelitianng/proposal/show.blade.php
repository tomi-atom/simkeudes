@extends('layouts.app')

@section('title')
    Identitas Usulan Penelitian
@endsection

@section('breadcrumb')
    @parent
    <li><a href="{{ route('penelitianng.index') }}">Penelitian</a></li>
    <li>Pengusul</li>
    <li>Proposal</li>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/sweetalert2/1.3.3/sweetalert2.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/sweetalert2/0.4.5/sweetalert2.css">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/sweetalert2/1.3.3/sweetalert2.min.js"></script>

@endsection

@section('content')

<div class="row">
    <div class="col-md-12">

        <form role="form" method="POST" action="{{route('penelitianng.proposal.update',[base64_encode(mt_rand(10,999)), base64_encode($proposal->id+81)])}}" name="formedit">
        {{ csrf_field() }} {{ method_field('PATCH') }}

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
                    <div class="panel-body"><strong>Identitas Pengusul - Proposal Penelitian</strong></div>
            
                    <div class="panel-footer">

                        <input type="hidden" name="tahun" id="tahun" value="" readonly>
                        <input type="hidden" name="program" id="program" value="" readonly>
                        <input type="hidden" name="tktid" id="tktid" readonly>
                       
                        <div class="row">
                            <div class="col-sm-2">
                                <label class="control-label col-sm-offset-2"> Judul</label>
                            </div>
                            <div class="col-sm-10">
                                <textarea class="form-control" rows="3" placeholder="Judul penelitian ..." name="judul" id="judul" required>{{$proposal->judul}}</textarea>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-2">
                                <label class="control-label col-sm-offset-2">TKT Saat Ini</label>
                            </div>
                            <div class="col-sm-3">
                                <div class="col-sm-7 input-group input-group-sm pull-left">
                                    <select id="tkt1" class="form-control" name="tkt1" required>
                                        <option value=""> -- Pilih TKT --</option>
                                        <option value="1" {{$proposal->tktawal == 1 ? 'selected' : ''}}> 1 </option>
                                        <option value="2" {{$proposal->tktawal == 2 ? 'selected' : ''}}> 2 </option>
                                        <option value="3" {{$proposal->tktawal == 3 ? 'selected' : ''}}> 3 </option>
                                        <option value="4" {{$proposal->tktawal == 4 ? 'selected' : ''}}> 4 </option>
                                        <option value="5" {{$proposal->tktawal == 5 ? 'selected' : ''}}> 5 </option>
                                        <option value="6" {{$proposal->tktawal == 6 ? 'selected' : ''}}> 6 </option>
                                        <option value="7" {{$proposal->tktawal == 7 ? 'selected' : ''}}> 7 </option>
                                        <option value="8" {{$proposal->tktawal == 8 ? 'selected' : ''}}> 8 </option>
                                        <option value="9" {{$proposal->tktawal == 9 ? 'selected' : ''}}> 9 </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <p></p>
                        <div class="row">
                            <div class="col-sm-2">
                                <label class="control-label col-sm-offset-2">Target Akhir TKT</label>
                            </div>
                            <div class="col-sm-3">
                                <div class="col-sm-10 input-group input-group-sm pull-left">
                                    <select id="tkt2" class="form-control" name="tkt2" required>
                                        <option value=""> -- Pilih TKT --</option>
                                        @if($proposal->tktawal <= 3)
                                            @for($i = $proposal->tktawal; $i<=3; $i++)
                                            <option value="{{$i}}" {{$proposal->tktakhir == $i ? 'selected' : ''}}> TKT {{$i}}</option>
                                            @endfor
                                        @elseif ($proposal->tktawal <= 6)
                                            @for($i = $proposal->tktawal; $i<=6; $i++)
                                            <option value="{{$i}}" {{$proposal->tktakhir == $i ? 'selected' : ''}}> TKT {{$i}}</option>
                                            @endfor
                                        @else
                                            @for($i = $proposal->tktawal; $i<=9; $i++)
                                            <option value="{{$i}}" {{$proposal->tktakhir == $i ? 'selected' : ''}}> TKT {{$i}}</option>
                                            @endfor
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                        <br> 
                    </div>
                </div>  
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading"><strong>Pemilihan Skema Penelitian: </strong>{{ $program->program }}</div>
            
            <div class="panel-body">

                <div class="form-group row">
                    <div class="col-sm-3">
                        <label class="control-label col-sm-offset-2"> Skema Penelitian</label>
                    </div>
                    <div class="col-sm-8">
                        <div class="col-sm-6 input-group input-group-sm">
                            <select id="skema" class="form-control" name="skema" required>
                                @if($ttl != 0)
                                <option value=""> -- Pilih Skema --</option>
                                @foreach($skema as $list)
                                    @if($list->id)
                                    <option value="{{ $list->id }}" {{$proposal->idskema == $list->id ? 'selected' : '' }}> {{ $list->skema }}</option>
                                    @endif
                                @endforeach
                                @else
                                <option value=""> -- Skema Penelitian Tidak Tersedia --</option>
                                @endif
                            </select>
                        </div>
                    </div>
                </div>
                <p></p>
                <div class="row">
                    <div class="col-sm-3">
                        <label class="control-label col-sm-offset-2"> Rumpun Ilmu</label>
                    </div>
                    <div class="col-sm-9">
                        <div class="col-sm-12 input-group input-group-sm">
                            <select id="ilmu1" class="form-control dynamic" name="ilmu1" data-dependent="ilmu2" required>
                                <option value=""> -- Pilih Rumpun Ilmu Level 1 --</option>
                                @foreach($rumpun as $list)
                                    <option value="{{ $list->ilmu1 }}" {{$proposal->rumpun->ilmu1 == $list->ilmu1 ? 'selected' : ''}}> {{ $list->ilmu1 }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <p></p>
                <div class="row">
                    <div class="col-sm-3"></div>
                    <div class="col-sm-9">
                        <div class="col-sm-12 input-group input-group-sm">
                            <select id="ilmu2" class="form-control dynamic" name="ilmu2" data-dependent="ilmu3" required>
                                <option value=""> -- Pilih Rumpun Ilmu Level 2 --</option>
                                @foreach($ilmu2 as $list)
                                    <option value="{{ $list->ilmu2 }}" {{$proposal->rumpun->ilmu2 == $list->ilmu2 ? 'selected' : ''}}> {{ $list->ilmu2 }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <p></p>
                <div class="form-group row">
                    <div class="col-sm-3"></div>
                    <div class="col-sm-9">
                        <div class="col-sm-12 input-group input-group-sm">
                            <select id="ilmu3" class="form-control" name="ilmu3" required>
                                <option value=""> -- Pilih Rumpun Ilmu Level 3 -- </option>
                                @foreach($ilmu3 as $list)
                                    <option value="{{ $list->id }}" {{$proposal->rumpun->ilmu3 == $list->ilmu3 ? 'selected' : ''}}> {{ $list->ilmu3 }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <p></p>
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label class="control-label col-sm-offset-2"> Satuan Biaya Khusus (SBK)</label>
                    </div>
                    <div class="col-sm-9">
                        <div class="col-sm-12 input-group input-group-sm">
                            <select id="sbk" class="form-control" name="sbk" required>
                                <option value=""> -- Pilih SBK --</option>
                                <option value="1" {{$proposal->idsbk == 1 ? 'selected' : ''}}>SBK Riset Dasar</option>
                            </select>
                        </div>
                    </div>
                </div>
                <p></p>
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label class="control-label col-sm-offset-2"> Bidang Fokus Penelitian</label>
                    </div>
                    <div class="col-sm-9">
                        <div class="col-sm-12 input-group input-group-sm">
                            <select id="bidang" class="form-control" name="bidang" required>
                                <option value=""> -- Pilih Bidang Fokus --</option>
                                @foreach($fokus as $list)
                                    <option value="{{ $list->id }}" {{$proposal->idfokus == $list->id ? 'selected' : '' }}> {{ $list->fokus }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <p></p>
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label class="control-label col-sm-offset-2"> Tema Penelitian</label>
                    </div>
                    <div class="col-sm-9">
                        <div class="col-sm-12 input-group input-group-sm">
                            <select id="tema" class="form-control" name="tema" required>
                                <option value=""> -- Pilih Tema Penelitian --</option>
                                @foreach($tema as $list)
                                    <option value="{{ $list->id }}" {{$proposal->idtema == $list->id ? 'selected' : '' }}> {{ $list->tema }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <p></p>
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label class="control-label col-sm-offset-2"> Topik Penelitian</label>
                    </div>
                    <div class="col-sm-9">
                        <div class="col-sm-12 input-group input-group-sm">
                            <select id="topik" class="form-control" name="topik" required>
                                <option value=""> -- Pilih Topik Penelitian --</option>
                                @foreach($topik as $list)
                                    <option value="{{ $list->id }}" {{$proposal->idtopik == $list->id ? 'selected' : '' }}> {{ $list->topik }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <p></p>
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label class="control-label col-sm-offset-2">Tahun Pelaksanaan</label>
                    </div>
                    <div class="col-sm-3">
                        <div class="col-sm-8 input-group input-group-sm">
                            <select id="thnkerja" class="form-control" name="thnkerja" required>
                                <option value=""> --</option>
                                <option value="2019" {{$tahun->thnkerja == 2019 ? 'selected' : ''}}>2019</option>
                                <option value="2020" {{$tahun->thnkerja == 2020 ? 'selected' : ''}}>2020</option>
                                <option value="2021" {{$tahun->thnkerja == 2021 ? 'selected' : ''}}>2021</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <label class="control-label col-sm-offset-2">Lama Kegiatan</label>
                    </div>
                    <div class="col-sm-3">
                        <div class="col-sm-5 input-group input-group-sm">
                            <select id="lama" class="form-control" name="lama" required>
                                <option value=""> --</option>
                                <option value="1" {{$proposal->lama == 1 ? 'selected' : '' }}>1 Tahun</option>
                                <option value="2" {{$proposal->lama == 2 ? 'selected' : '' }}>2 Tahun</option>
                                <option value="3" {{$proposal->lama == 3 ? 'selected' : '' }}>3 Tahun</option>
                            </select>
                        </div>
                    </div>
                </div>


                <p></p>
                <div class="form-group row">
                    <div class="col-sm-3">
                        <label class="control-label col-sm-offset-2"> Pusat Studi</label><br>

                    </div>
                    <div class="col-sm-9">
                        <code>Pilih Minimal 2 Pusat Studi dan Maksimal 5 Pusat Studi</code>
                        <div class="col-sm-12 input-group input-group-sm">
                            @foreach($pusatstudi as $list)

                                <li><input type="checkbox" name="pusatstudi[]" id="pusatstudi" value="{{$list->id}}"    @if($idpusatstudi->contains($list->id)) checked=checked @endif  > <small>{{$list->pusatstudi}}</small></li>


                            @endforeach
                        </div>
                    </div>
                </div>

                <p>. </p>
                <div class="row">
                    <div class="col-md-12">
                        <a href="{{route('validasipenelitian.show', base64_encode(mt_rand(10,99).($proposal->id*2+29)))}}" class="btn btn-default pull-left" name="awal" id="awal"><span class="fa fa-reply fa-fw"></span> Kembali</a>  
                        <button type="submit" class="btn btn-primary pull-right" name="submit" id="submit">
                        <span class="fa fa-floppy-o fa-fw" ></span> PERBAHARUI
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

        if (!$("#skema").val()) {

            $("#ilmu1").attr('disabled', true);
            $("#ilmu2").attr('disabled', true);
            $("#ilmu3").attr('disabled', true);
            $("#sbk").attr('disabled', true);
            $("#bidang").attr('disabled', true);
            $("#tema").attr('disabled', true);
            $("#topik").attr('disabled', true);
           $("#submit").attr('disabled', true);
        }
    });

    function reloadTKT() {
        var indikator = $('#tkt1').val();
        var _token    = $('input[name = "_token"]').val();

        $.ajax({
            url: "{{ route('penelitianng.reloadtkt') }}",
            method: "POST",
            data: {indikator: indikator, _token: _token},
            success: function(result)
            {
               $('#tkt2').html(result);
               //$('#tkt2').prop('selectedIndex',indikator);
            },
            error : function() 
            {
            }
        });
    }

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

    function reloadTopik() {
        var idtema = $("#tema").val();
        var _token  = $('input[name = "_token"]').val();
        $.ajax({
            url: "{{ route('penelitianng.reloadtpk') }}",
            method: "POST",
            data: {idtema: idtema, _token: _token},
            success: function(result)
            {
                $("#topik").html(result);
            }
        });
    }

    $("#tema").change(function() {
        reloadTopik();
    });

    $("#skema").change(function() {
        if (!$("#skema").val()) {

            $("#ilmu1").attr('disabled', true);
            $("#ilmu2").attr('disabled', true);
            $("#ilmu3").attr('disabled', true);
            $("#sbk").attr('disabled', true);
            $("#bidang").attr('disabled', true);
            $("#tema").attr('disabled', true);
            $("#topik").attr('disabled', true);
            
            $("#submit").attr('disabled', true);
        } else {
            $("#ilmu1").attr('disabled', false);
            $("#ilmu2").attr('disabled', false);
            $("#ilmu3").attr('disabled', false);
            $("#sbk").attr('disabled', false);
            $("#bidang").attr('disabled', false);
            $("#tema").attr('disabled', false);
            $("#topik").attr('disabled', false);   
        
            $("#submit").attr('disabled', false);
        }

        var idskema = $("#skema").val();
        var _token  = $('input[name = "_token"]').val();
        $.ajax({
            url: "{{ route('penelitianng.reloadbdg') }}",
            method: "POST",
            data: {idskema: idskema, _token: _token},
            success: function(result)
            {
                $("#tema").html(result);
                reloadTopik().load();
            }
        })
    });

</script>
@endsection