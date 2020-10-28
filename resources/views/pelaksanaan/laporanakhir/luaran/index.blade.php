@extends('layouts.app')

@section('title')
    Catatan Harian
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
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <strong>Catatan Harian</strong> <small class="label label-success">{{$total}}</small>
                    </div>

                    <div class="panel-body">
                        @if($total == 0)
                            <div>Belum Ada Penelitian Yang Disetujui..</div>
                        @else
                            <div class="box-header">
                                <i class="ion ion-paper-airplane"></i>
                                <h4 class="box-title">Periode: 2019 - Batch 1:</h4>
                            </div>

                            <div class="box-body">
                                <ul class="todo-list" style="overflow-x: hidden">
                                    @foreach ($proposal as $detail)
                                        <li>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    @if ($detail->jenis==1)
                                                        <small class="label bg-blue label-primary">Penelitian </small>
                                                        <span class="text text-blue">{{ $detail->judul }}</span>
                                                    @else
                                                        <small class="label bg-warning label-warning">Pengabdian</small>
                                                        <span class="text text-blue">{{ $detail->judul }}</span>
                                                    @endif
                                                    <br>
                                                    &nbsp;&nbsp;<span class="text text-green">{{$detail->program->program}} - {{$detail->skema->skema}}</span>
                                                    <br>
                                                    &nbsp;&nbsp;<span class="text text-red">Periode Usulan Tahun {{ $detail->periode->tahun}} Batch {{ $detail->periode->sesi}} | Tahun Pelaksanaan {{ $detail->thnkerja }} </span>
                                                    <br>
                                                    &nbsp;&nbsp;<span class="text text-dark">Bidang Fokus : </span> {{$detail->fokus->fokus}}&nbsp; &nbsp;- <small class="label label-primary">Ketua Pengusul</small>
                                                    <br>
                                                
                                                    @if ($minat)
                                                        <span class="text bg-red text-dark">&nbsp; {{$minat}} Anggota Belum Menyetujui &nbsp;</span>
                                                    @endif
                                                    <br>
                                                    <br>
                                                </div>
                                                <div class="tools col-sm-12 pull-left">
                                                <a href="{{ route('luarankemajuan.show', base64_encode($detail->prosalid) )}}"  class="btn btn-app btn-sm" ><i class="ion ion-ios-plus text-blue"></i> Tambahkan </a>


                                                </div>


                                            </div>
                                        </li>
                                    @endforeach
                                    <br>

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

 function hapusProposal(id) {
        if (confirm("Apakah yakin data dari kegiatan ini akan dihapus?")) {
            $.ajax({
                url  : "{{route('catatanharian.destroy','')}}/"+id,
                type : "POST",
                data : {'_method' : 'DELETE', '_token' : $('input[name = "_token"]').val()},
                success : function(data) {
                    window.location = "{{route('catatanharian.index')}}";
                },
                error : function() {
                    alert("Tidak dapat menghapus data");
                }

            });
        }
    }



    function upload(id) {
        window.location = "{{route('catatanharian.edit', '')}}/"+btoa(id);
    }


</script>
@endsection