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
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="leveltkt" class="col-md-4 control-label">Tingkat Kesiapterapan Teknologi</label>

                            <div class="col-md-6">
                                <input id="leveltkt" type="text" class="form-control" name="leveltkt" required>
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
