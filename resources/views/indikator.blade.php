@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Penambahan Indikator Penilaian TKT</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('indikator.store') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Nama Bidang</label>

                            <div class="col-md-6">
                                <select id="bidang" class="form-control" name="bidang" required>
                                    <option value="">-- Pilih Bidang --</option>
                                    @foreach($bidang as $list)
                                    <option value="{{ $list->id }}"> {{ $list->bidang }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="leveltkt" class="col-md-4 control-label">Tingkat Kesiapterapan Teknologi</label>

                            <div class="col-md-6">
                                <select id="bidang" class="form-control" name="leveltkt" required>
                                    <option value="">-- Pilih TKT --</option>
                                    <option value="1">TKT Level 1</option>
                                    <option value="2">TKT Level 2</option>
                                    <option value="3">TKT Level 3</option>
                                    <option value="4">TKT Level 4</option>
                                    <option value="5">TKT Level 5</option>
                                    <option value="6">TKT Level 6</option>
                                    <option value="7">TKT Level 7</option>
                                    <option value="8">TKT Level 8</option>
                                    <option value="9">TKT Level 9</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="nourut" class="col-md-4 control-label">Nomor Indikator</label>

                            <div class="col-md-6">
                                <input id="nourut" type="text" class="form-control" name="nourut" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="indikator" class="col-md-4 control-label">Indikator</label>

                            <div class="col-md-6">
                                <input id="indikator" type="text" class="form-control" name="indikator" required>
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Simpan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
