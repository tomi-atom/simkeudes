@extends('layouts.app')

@section('title')
    Daftar Usulan Baru
@endsection

@section('breadcrumb')
    @parent
    <li>Penelitian</li>
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading"><strong>H-INDEX: {{ $peneliti->hindex }}</strong> <div class="pull-right"><strong>USULAN BARU: {{ $total }}</strong></div></div>
            
            <div class="panel-body">
                @if(($peneliti->sinta != '') && ($peneliti->status == 1) && ($peneliti->tanggungan == 0) &&  ($ketua < 1) && ($member < 2))
                <form class="form-horizontal" method="POST" action="{{ route('penelitian.create') }}">
                {{ csrf_field() }} {{method_field('GET')}}
                @endif

                <div class="panel panel-default">
                    <div class="panel-heading"><strong>Persyaratan Umum: </strong></div>
            
                    <div class="panel-body">
                        <div class="">
                            <div class="box-header">
                                <i class="ion ion-clipboard"></i>
                                <h4 class="box-title">Periode: 2019 | Batch 1</h4>
                            </div>
            
                            <div class="box-body">
                                <ul class="todo-list">
                                <li>
                                    <span class="handle">
                                        <i class="fa fa-ellipsis-v"></i> <i class="fa fa-ellipsis-v"></i>
                                    </span>
                                    @if($peneliti->sinta != '')
                                    <i class="glyphicon glyphicon-ok-circle text-green"></i><span class="text text-blue"> Terdaftar Dalam Sinta : <b class="text-black">{{ $peneliti->sinta }}</b></span>
                                    @else
                                    <i class="glyphicon glyphicon-remove-circle text-red"></i><span class="text text-blue"> Terdaftar Dalam Sinta : <b class="text-black">Belum Terdaftar</b></span>
                                    <small class="label label-danger"><i class="ion ion-android-person"></i> Silakan hubungi Administrator LPPM</small> 
                                    @endif
                                </li>
                                <li>
                                    <span class="handle">
                                        <i class="fa fa-ellipsis-v"></i> <i class="fa fa-ellipsis-v"></i>
                                    </span>
                                    @if($peneliti->status == 1)
                                    <i class="glyphicon glyphicon-ok-circle text-green"></i><span class="text text-blue"> Status Pegawai : <b class="text-black">Aktif Mengajar</b></span>
                                    @else
                                    <i class="glyphicon glyphicon-remove-circle text-red"></i><span class="text text-blue"> Status Pegawai : <b class="text-black">Tidak Aktif</span>
                                    <small class="label label-danger"><i class="ion ion-android-person"></i> Silakan hubungi Administrator LPPM</small> 
                                    @endif
                                </li>
                                <li>
                                    <span class="handle">
                                        <i class="fa fa-ellipsis-v"></i> <i class="fa fa-ellipsis-v"></i>
                                    </span>
                                    @if($peneliti->tanggungan == 0)
                                    <i class="glyphicon glyphicon-ok-circle text-green"></i><span class="text text-blue"> Tanggungan Kegiatan : <b class="text-black">Tidak Ada</b></span> 
                                    @else
                                    <i class="glyphicon glyphicon-remove-circle text-red"></i><span class="text text-blue"> Tanggungan Kegiatan : <b class="text-black">Ada Tangunggan</b></span>
                                    <small class="label label-danger"><i class="ion ion-android-person"></i> Silakan hubungi Administrator LPPM</small> 
                                    @endif
                                </li>
                                <li>
                                    <span class="handle">
                                        <i class="fa fa-ellipsis-v"></i> <i class="fa fa-ellipsis-v"></i>
                                    </span>
                                    @if(($ketua < 1) && ($member < 2)) 
                                    <i class="glyphicon glyphicon-ok-circle text-green"></i><span class="text text-blue"> Kuota Usulan : <b class="text-black">Kuota Usulan Sebagai Ketua Tersedia</b></span> 
                                    @elseif($member >= 2)
                                    <i class="glyphicon glyphicon-remove-circle text-red"></i><span class="text text-blue"> Kuota Usulan : <b class="text-black">Kuota Usulan Sebagai Anggota Telah Terpenuhi</b></span><small class="label label-danger"><i class="ion ion-ios-pricetags-outline"></i> {{ $total}} Proposal</small> 
                                    @else
                                    <i class="glyphicon glyphicon-remove-circle text-red"></i><span class="text text-blue"> Kuota Usulan : <b class="text-black">Kuota Usulan Sebagai Ketua Telah Terpenuhi</b></span><small class="label label-danger"><i class="ion ion-ios-pricetags-outline"></i> {{ $ketua}} Proposal</small> 
                                    @endif
                                </li>

                                </ul>
                            </div>
                        </div>

                    </div>
                </div>  

                <div class="row">
                    <div class="col-sm-3">
                        <label class="control-label col-sm-9">Periode Pengusulan</label>
                    </div>
                    <div class="col-sm-2 input-group input-group-sm">
                        <select id="idxtahun" class="form-control" name="idxtahun" required>
                            <option value="">--Pilih periode--</option>
                            @foreach($periode as $list)
                                <option value="{{ $list->id }}"> {{ $list->tahun }} | Batch {{ $list->sesi }} </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                @if(($peneliti->sinta != '') && ($peneliti->status == 1) && ($peneliti->tanggungan == 0) && ($ketua < 1)  && ($member < 2))
                <div class="form-group row">
                    <div class="col-md-8 col-md-offset-4">
                        <button type="submit" class="btn btn-success pull-right">
                          <span class="fa fa-angle-double-right fa-fw"></span>
                            LANJUTKAN
                        </button>
                    </div>
                </div>
                </form>
                @endif
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-body">
                <div class="panel panel-default">
                    <div class="panel-heading"><strong>Daftar Usul Penelitian Baru</strong> <small class="label label-success">{{$total}}</small></div>
            
                     <div class="panel-body">
                     @if($total == 0)
                     <div>Belum Ada Usulan Baru..</div>
                     @else
                     <div class="box-header">
                                <i class="ion ion-paper-airplane"></i>
                                <h4 class="box-title">Periode: 2019 - Batch 1:</h4>
                            </div>
            
                            <div class="box-body">
                                <ul class="todo-list">
                                @foreach ($proposal as $detail)
                                <li>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <span class="text text-blue">{{ $detail->judul }}</span>
                                            <br>
                                            <br>
                                            &nbsp;&nbsp;<span class="text text-green">{{$detail->program->program}} - {{$detail->skema->skema}}</span>
                                            <br>
                                            &nbsp;&nbsp;<span class="text text-red">Periode Usulan Tahun {{ $detail->periode->tahun}} Batch {{ $detail->periode->sesi}} | Tahun Pelaksanaan {{ $detail->thnkerja }} </span>
                                            <br>
                                            &nbsp;&nbsp;<span class="text text-dark">Bidang Fokus : </span> {{$detail->fokus->fokus}}&nbsp; &nbsp;- <small class="label label-primary">Ketua Pengusul</small>
                                            <br>
                                            &nbsp;&nbsp;<span class="text bg-green text-dark">&nbsp; {{$status[$detail->status]->jenis}} &nbsp;</span> 
                                            @if ($minat)
                                            <span class="text bg-red text-dark">&nbsp; {{$minat}} Anggota Belum Menyetujui &nbsp;</span>
                                            @endif
                                            <br>
                                            <span class="text text-gray"></span>
                                            
                                        </div>
                                        
                                        <div class="tools col-sm-6 pull-left">
                                            @if($detail->aktif == 1)
                                            <a onclick="bacaProposalRinci({{$detail->prosalid}})" class="btn btn-app btn-sm" id="baca"><i class="ion ion-ios-book-outline text-blue"></i> Baca </a>
                                            <a onclick="unduhProposal({{$detail->prosalid}})" class="btn btn-app btn-sm" id="down"><i class="ion ion-ios-cloud-download-outline text-blue"></i> Unduh </a>
                                            @endif
                                            @if ($detail->status > 0 && $detail->status < 3)
                                            <a onclick="editProposal({{$detail->prosalid}})" class="btn btn-app btn-xs" id="edit"><i class="ion ion-compose text-red"></i> Edit </a>
                                            <a onclick="hapusProposal({{$detail->prosalid}})" class="btn btn-app btn-sm" id="hapus"><i class="ion ion-ios-trash text-red"></i> Hapus </a>
                                            @endif
                                            
                                            
                                        </div>
                                    </div>                
                                </li>
                                @endforeach
                                <br>
                                @foreach ($peserta as $detail)
                                <li>
                                    <div class="row">
                                        <div class="col-sm-11">
                                            <span class="text text-blue">{{ $detail->judul }}</span>
                                            <br>
                                            <br>
                                            &nbsp;&nbsp;<span class="text text-green">{{$detail->program->program}} - {{$detail->skema->skema}}</span>
                                            <br>
                                            &nbsp;&nbsp;<span class="text text-red">Periode Usulan Tahun {{ $detail->periode->tahun}} Batch {{ $detail->periode->sesi}} | Tahun Pelaksanaan {{ $detail->thnkerja }} </span>
                                            <br>
                                            &nbsp;&nbsp;<span class="text text-dark">Bidang Fokus : </span> {{$detail->fokus->fokus}} &nbsp; &nbsp;- <small class="label label-primary">Anggota Pengusul {{$detail->peran}}</small> 
                                            @if($detail->setuju)
                                            <small class="label label-success">Disetujui</small>
                                            @else
                                            <small class="label label-warning">Belum Disetujui</small>
                                            @endif
                                            <br>
                                            &nbsp;&nbsp;<span class="text bg-green text-dark">&nbsp; {{$status[$detail->status]->jenis}} &nbsp;</span>
                                            <br>
                                            <span class="text text-gray"></span>
                                        </div>
                                        
                                        <div class="tools col-sm-6 pull-left">
                                            @if(!$detail->setuju)
                                            <a onclick="setujuiProposal({{mt_rand(1,9).($detail->prosalid+$peneliti->id*3)}})" class="btn btn-app btn-sm" id="baca"><i class="ion ion-ios-checkmark-outline text-blue"></i> Approve </a>
                                            @endif
                                            <a onclick="bacaProposal({{$detail->prosalid}})" class="btn btn-app btn-sm" id="baca"><i class="ion ion-ios-book-outline text-blue"></i> Baca </a>
                                            @if($detail->setuju)
                                            <a onclick="unduhProposal({{$detail->prosalid}})" class="btn btn-app btn-sm" id="down"><i class="ion ion-ios-cloud-download-outline text-blue"></i> Unduh </a>
                                            @endif
                                        </div>
                                    </div>                
                                </li>
                                @endforeach
                                <li></li>
                                </ul>
                            </div>
                     @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script type="text/javascript">
    function bacaProposal(id) {
        //window.location = "{{ route('penelitian.baca', '+id+')}}";
        window.location = "penelitian/ringkasan/"+btoa(id)+"/baca";
    }

    function bacaProposalRinci(id) {
        //window.location = "{{ route('penelitian.baca', '+id+')}}";
        window.location = "{{route('penelitian.resume', '')}}/"+btoa('2'+id);
    }

    function setujuiProposal(id) {
        window.location = "{{route('penelitian.setuju','')}}/"+btoa(id);
    }

    function editProposal(id) {
        window.location = "{{route('penelitian.rangkuman','')}}/"+btoa('2'+id);
    }

    function hapusProposal(id) {
        if (confirm("Apakah yakin proposal dari kegiatan ini akan dihapus?")) {
            window.location = "{{route('penelitian.hapusproposal','')}}/"+id;
        }
    }
</script>
@endsection