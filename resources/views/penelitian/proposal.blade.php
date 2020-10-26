@extends('layouts.app')

@section('title')
	Identitas Usulan Penelitian
@endsection

@section('breadcrumb')
	@parent
    <li><a href="{{ route('penelitian.index') }}">Penelitian</a></li>
    <li>Pengusul</li>
    <li>Proposal</li>
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        <form role="form" method="POST" action="{{ route('penelitian.store') }}">
        {{ csrf_field() }}

        <div class="panel panel-primary">
            <div class="panel-heading"><strong></strong> <div class="pull-right"><strong></strong></div>
            </div>
            
            <div class="panel-body">
                
                <div class="panel panel-default">
                    <div class="panel-body"><strong>Identitas Pengusul - Proposal Penelitian {{$total+1}}</strong></div>
            
                    <div class="panel-footer">

                        <input type="hidden" name="tahun" id="tahun" value="{{ $thn }}" readonly>
                        <input type="hidden" name="program" id="program" value="{{ $idprog }}" readonly>
                        <input type="hidden" name="tktid" id="tktid" readonly>
                      
                    	<div class="row">
                    		<div class="col-sm-2">
                    			<label class="control-label col-sm-offset-2"> Judul</label>
                    		</div>
                    		<div class="col-sm-10">
                    			<textarea class="form-control" rows="3" placeholder="Judul penelitian ..." name="judul" id="judul" required autofocus></textarea>
                			</div>
                		</div>
                		<p></p>
                		<div class="row">
                			<div class="col-sm-2">
                    			<label class="control-label col-sm-offset-2">TKT Saat Ini</label>
                    		</div>
                    		<div class="col-sm-3">
                    			<div class="input-group input-group-sm">
                					<input type="text" class="form-control" name="tkt1" id="tkt1" required readonly>
                                    <span class="input-group-btn">
                                        <button onclick="showTKT()" id="awaltkt" type="button" class="btn btn-warning btn-flat" name="awaltkt">Ukur!</button>
                                    </span>
              					</div>
              				</div>
              				<div class="col-sm-4">
                    			<label class="control-label col-sm-offset-7">Target Akhir TKT</label>
                    		</div>
                    		<div class="col-sm-3">
                    			<div class="col-sm-10 input-group input-group-sm pull-right">
                        			<select id="tkt2" class="form-control" name="tkt2">
                            			<option value=""> -- Pilih TKT --</option>
                        			</select>
                    			</div>
                			</div>
                		</div> 
                		<p>. </p>
                		<div class="row">
                    		<div class="col-md-12">
                               
                                <input type="button" class="btn btn-primary pull-right" id="simpan" name="simpan" value="Simpan" />
                   			</div>
                		</div>

                   
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
                        	<select id="skema" class="form-control" name="skema" required disabled>
                                @if($ttl != 0)
                            	<option value=""> -- Pilih Skema --</option>
                            	@foreach($skema as $list)
                                    @if($list->id)
                            		<option value="{{ $list->id }}"> {{ $list->skema }}</option>
                                    @endif
                            	@endforeach
                                @else
                                <option value=""> -- Dosen Muda | Batas Kuota Telah Tepenuhi --</option>
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
                        	<select id="ilmu1" class="form-control dynamic" name="ilmu1" data-dependent="ilmu2" required disabled>
                            	<option value=""> -- Pilih Rumpun Ilmu Level 1 --</option>
                            	@foreach($rumpun as $list)
                            		<option value="{{ $list->ilmu1 }}"> {{ $list->ilmu1 }}</option>
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
                        	<select id="ilmu2" class="form-control dynamic" name="ilmu2" data-dependent="ilmu3" required disabled>
                            	<option value=""> -- Pilih Rumpun Ilmu Level 2 --</option>
                            	
                        	</select>
                    	</div>
                    </div>
                </div>
                <p></p>
                <div class="form-group row">
                    <div class="col-sm-3"></div>
                    <div class="col-sm-9">
                    	<div class="col-sm-12 input-group input-group-sm">
                        	<select id="ilmu3" class="form-control" name="ilmu3" required disabled>
                            	<option value=""> -- Pilih Rumpun Ilmu Level 3 -- </option>
                            	
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
                        	<select id="sbk" class="form-control" name="sbk" required disabled>
                            	<option value=""> -- Pilih SBK --</option>
                                <option value="1">SBK Riset Dasar</option>
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
                        	<select id="bidang" class="form-control" name="bidang" required disabled>
                            	<option value=""> -- Pilih Bidang Fokus --</option>
                                @foreach($fokus as $list)
                                    <option value="{{ $list->id }}"> {{ $list->fokus }}</option>
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
                        	<select id="tema" class="form-control" name="tema" required disabled>
                            	<option value=""> -- Pilih Tema Penelitian --</option>
                            
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
                        	<select id="topik" class="form-control" name="topik" required disabled>
                            	<option value=""> -- Pilih Topik Penelitian --</option>
                            	
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
                            	<option value="2019" selected>2019</option>
                            	<option value="2020">2020</option>
                            	<option value="2021">2021</option>
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
                            	<option value="1" selected>1 Tahun</option>
                            	<option value="2">2 Tahun</option>
                            	<option value="3">3 Tahun</option>
                        	</select>
                    	</div>
                	</div>
                </div> 
                <p>. </p>
                <div class="row">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-success pull-right" name="submit" id="submit" disabled>
                        <span class="fa fa-angle-double-right fa-fw"></span>LANJUTKAN
                        </button>
                    </div>
                </div>
            </div> 
        </div>
        </form>
    </div>
</div>
@include('penelitian.formtkt')
@include('penelitian.formukurtkt')
@endsection

@section('script')
<script type="text/javascript">
    $(document).ready(function() {
        if ($("#tkt1").val() != '') {
            $("#awaltkt").attr('disabled',true);
            $("#simpan").attr('disabled', !$("#simpan").attr('disabled'));
            document.getElementById("judul").readOnly = true; 
            document.getElementById("tkt2").readOnly = true;
            changeTKT().load();
        }

        $("#simpan").click(function() {
            document.getElementById("judul").setAttribute("readonly", true);
            document.getElementById("tkt1").setAttribute("readonly", true);
            document.getElementById("tkt2").setAttribute("readonly", true);
            
            $("#simpan").attr('disabled', !$("#simpan").attr('disabled'));

            $("#skema").attr('disabled', !$("#skema").attr('disabled'));
            $("#ilmu1").attr('disabled', !$("#ilmu1").attr('disabled'));
            $("#ilmu2").attr('disabled', !$("#ilmu2").attr('disabled'));
            $("#ilmu3").attr('disabled', !$("#ilmu3").attr('disabled'));
            $("#sbk").attr('disabled', !$("#sbk").attr('disabled'));
            $("#bidang").attr('disabled', !$("#bidang").attr('disabled'));
            $("#tema").attr('disabled', !$("#tema").attr('disabled'));
            $("#topik").attr('disabled', !$("#topik").attr('disabled'));   
        });  

    });

    function changeTKT() {
        var indikator = $('#tkt1').val();
        var _token    = $('input[name = "_token"]').val();

        $.ajax({
            url: "{{ route('penelitian.loadtkt') }}",
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

    function prosesTKT(id) {
        var indikator = $('input[name = "optionsRadios"]:checked').val();
        var _token    = $('input[name = "_token"]').val();

        $.ajax({
            url: "{{ route('penelitian.prosestkt','') }}/"+id,
            method: "POST",
            data: {indikator: indikator, _token: _token},
            success: function(result)
            {   
                $('#tbtkt').html(result);
            },
            error : function() {
                alert("Tidak dapat menyimpan data");
            }
        });
    }

    function progresTKT() {
        $.ajax ({
            url : "{{ route('penelitian.calculatetkt') }}",
            type : "POST",
            data : $('#modal-ukurtkt form').serialize(),
            success : function(result) {
                $('#divbar').html(result);
                if (parseInt($('#kode').text()) >= 80 && parseInt($('#indextkt').val()) < 9) 
                {
                    $("#lanjuttkt").show();
                    $("#btlanjuttkt").attr('disabled', false);
                    $("#btsimpantkt").attr('disabled', true);
                    $("#simpantkt").hide();
                }
                else
                {
                    $("#simpantkt").show();
                    $("#btsimpantkt").attr('disabled', false);
                    $("#btlanjuttkt").attr('disabled', true);
                    $("#lanjuttkt").hide();
                }
            },
            error : function(){

            }
        });
    }

    function finalTKT() {
        var idtkt = $('#idtkt').val();
        var leveltkt = $('#grade').text();
        $.ajax ({
            url : "{{ route('penelitian.updatetkt','') }}/"+idtkt,
            type : "POST",
            data : $('#modal-ukurtkt form').serialize(),
            success : function(result) {
                if (parseInt($('#kode').text()) >= 80 && parseInt($('#indextkt').val()) < 9) {
                    $('#indextkt').val(result);
                    $('#idspan').html(result);
                    $("#btlanjuttkt").attr('disabled', true);
                    $("#lanjuttkt").hide();
                    $('#divbar').html('');
                    prosesTKT(result).load();   
                }
                else {
                    $('#modal-ukurtkt').modal('hide');
                    $('#tkt1').val(parseInt(leveltkt));
                    changeTKT().load();
                }
            },
            error : function(){
                alert("Tidak dapat memperbaharui data");
            }
        });
    }

    function showTKT() {
        document.getElementById("teknologi").value = '';
        document.getElementById("umum").checked = true;

        $('#modal-tkt').modal('show');
    }

    function hitungTKT() {
        $("#awaltkt").attr('disabled',true);
        $('#modal-tkt').modal('hide');

        $('#modal-ukurtkt').modal('show');
        $('#indextkt').val('1');
        $('#idspan').text('1');

        var teknologi = $("#teknologi").val();
        var indikator = $('input[name = "optionsRadios"]:checked').val();
        var _token    = $('input[name = "_token"]').val();
        $.ajax({
            url: "{{ route('penelitian.fetchtkt') }}",
            method: "POST",
            data: {teknologi: teknologi, indikator: indikator, _token: _token},
            success: function(result)
            {
                $('#tkt1').val(indikator);
                $('#idtkt').val(result);
                $('#tktid').val(result);
                prosesTKT('1').load();
            },
            error : function() {
                alert("Tidak dapat menyimpan data");
            }
        });
    }

    function tampilTema() {
        var idtema = $("#tema").val();
        var _token  = $('input[name = "_token"]').val();
        $.ajax({
            url: "{{ route('penelitian.fetchtopik') }}",
            method: "POST",
            data: {idtema: idtema, _token: _token},
            success: function(result)
            {
                $("#topik").html(result);
            }
        });
    }

    function tampilIlmu() {
        var select = 'ilmu2';
        var value  = $('#ilmu2').val();
        var dependent = 'ilmu3';
        var _token = $('input[name = "_token"]').val();

        $.ajax({
            url: "{{ route('penelitian.fetch') }}",
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
                url: "{{ route('penelitian.fetch') }}",
                method: "POST",
                data: {select: select, value: value, _token: _token, dependent: dependent},
                success: function(result)
                {
                    $('#'+dependent).html(result);
                    tampilIlmu().load();
                }
            })
        }
    });

    $("#tema").change(function() {
        tampilTema();
    });

    $("#skema").change(function() {
        $("#submit").attr('disabled', false);

        var idskema = $("#skema").val();
        var _token  = $('input[name = "_token"]').val();
        $.ajax({
            url: "{{ route('penelitian.fetchbidang') }}",
            method: "POST",
            data: {idskema: idskema, _token: _token},
            success: function(result)
            {
                $("#tema").html(result);
                tampilTema().load();
            }
        })
    });

    
</script>
@endsection