@extends('layouts.app')

@section('title')
	Identitas Usulan Pengabdian Kepada Masyarakat
@endsection

@section('breadcrumb')
	@parent
    <li><a href="{{ route('pengabdian.index') }}">Pengabdian</a></li>
    <li>Pengusul</li>
    <li>Proposal</li>
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        <form role="form" method="POST" action="{{ route('pengabdian.store') }}">
        {{ csrf_field() }}

        <div class="panel panel-primary">
            <div class="panel-heading"><strong></strong> <div class="pull-right"><strong></strong></div>
            </div>
            
            <div class="panel-body">
                
                <div class="panel panel-default">
                    <div class="panel-body"><strong>Identitas Pengusul - Proposal Pengabdian Kepada Masyarakat {{$total+1}}</strong></div>
            
                    <div class="panel-footer">

                        <input type="hidden" name="tahun" id="tahun" value="{{ $thn }}" readonly>
                        <input type="hidden" name="program" id="program" value="{{ $idprog }}" readonly>
                      
                    	<div class="row">
                    		<div class="col-sm-2">
                    			<label class="control-label col-sm-offset-2"> Judul</label>
                    		</div>
                    		<div class="col-sm-10">
                    			<textarea class="form-control" rows="3" placeholder="Judul pengabdian kepada masyarakat ..." name="judul" id="judul" required autofocus></textarea>
                			</div>
                		</div>
                		<p></p>
                   
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
                            		<option value="{{ $list->id }}"> {{ $list->skema }}</option>
                                    @endif
                            	@endforeach
                                @else
                                <option value=""> -- Syarat Fungsional/Pendidikan Tidak Terpenuhi --</option>
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
                        	<select id="ilmu2" class="form-control dynamic" name="ilmu2" data-dependent="ilmu3" required>
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
                        	<select id="ilmu3" class="form-control" name="ilmu3" required>
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
                        	<select id="sbk" class="form-control" name="sbk" required>
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
                        	<select id="bidang" class="form-control" name="bidang" required>
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
                        	<select id="tema" class="form-control" name="tema">
                            	<option value=""> -- Pilih Tema Pengabdian Kepada Masyarakat --</option>
                            
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
                        	<select id="topik" class="form-control" name="topik">
                            	<option value=""> -- Pilih Topik Pengabdian Kepada Masyarakat --</option>
                            	
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

@endsection

@section('script')
<script type="text/javascript">
    $(document).ready(function() { 

    });

    function tampilIlmu() {
        var select = 'ilmu2';
        var value  = $('#ilmu2').val();
        var dependent = 'ilmu3';
        var _token = $('input[name = "_token"]').val();

        $.ajax({
            url: "{{ route('pengabdian.fetch') }}",
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
                url: "{{ route('pengabdian.fetch') }}",
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

    function tampilTema() {
        var idtema = $("#tema").val();
        var _token  = $('input[name = "_token"]').val();
        $.ajax({
            url: "{{ route('pengabdian.fetchtopik') }}",
            method: "POST",
            data: {idtema: idtema, _token: _token},
            success: function(result)
            {
                $("#topik").html(result);
            }
        });
    }

    $("#tema").change(function() {
        tampilTema();
    });

    $("#skema").change(function() {
        $("#submit").attr('disabled', false);

        var idskema = $("#skema").val();
        var _token  = $('input[name = "_token"]').val();
        $.ajax({
            url: "{{ route('pengabdian.fetchbidang') }}",
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