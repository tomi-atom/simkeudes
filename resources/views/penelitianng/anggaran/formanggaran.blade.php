<div class="modal" id="modal-biaya" tabindex="-1" role="dialog" aria-hidden="true"  >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

        <form class="form-horizontal" data-toggle="validator" method="POST">
        {{ csrf_field() }} {{ method_field('POST') }}
            <input type="hidden"  name="id" id="id" value="{{ $idprop }}" readonly>
            <input type="hidden" name="idanggaran" id="idanggaran" value="" readonly>

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"> &times; </span> </button>
                <h3 class="modal-title">Tambah Anggaran Biaya..</h3>
            </div>
            <br>
            <br>
            <div class="row">
                <div class="col-sm-3">
                    <label class="control-label col-sm-offset-2"> Tahun ke-</label>
                </div>
                <div class="col-sm-2">
                    <div class="col-sm-12 input-group input-group-sm">
                        <select class="form-control" id="tahun" name="tahun" required>
                            <option value="1"> 1</option>
                            <option value="2" disabled="disabled"> 2 (Disabled) </option>
                            <option value="3" disabled="disabled"> 3 (Disabled)</option>
                        </select>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-sm-3">
                    <label class="control-label col-sm-offset-2"> Jenis Pembelanjaan</label>
                </div>
                <div class="col-sm-4">
                    <div class="col-sm-12 input-group input-group-sm">
                        <select id="belanja" class="form-control" name="belanja" required readonly>
                            <option value=""> -- Pilih Jenis Pembelanjaan  --</option>
                            @foreach ($biaya as $data)
                            <option value="{{$data->id}}"> {{$data->jenis}} </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-sm-3">
                    <label class="control-label col-sm-offset-2"> Item Kegiatan</label>
                </div>
                <div class="col-sm-9">
                    <div class="col-sm-11 input-group input-group-sm">
                        <input type="text" class="form-control" name="item" id="item" required>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-sm-3">
                    <label class="control-label col-sm-offset-2"> Satuan </label>
                </div>
                <div class="col-sm-9">
                    <div class="col-sm-11 input-group input-group-sm">
                        <input type="text" class="form-control" name="satuan" id="satuan" required>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-sm-3">
                    <label class="control-label col-sm-offset-2"> Volume </label>
                </div>
                <div class="col-sm-2">
                    <div class="col-sm-12 input-group input-group-sm">
                        <input type="text" class="form-control" name="volume" id="volume" required>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-sm-3">
                    <label class="control-label col-sm-offset-2" id="ljurnal"> Biaya Satuan </label>
                </div>
                <div class="col-sm-3">
                    <div class="col-sm-11 input-group input-group-sm">
                        <span class="input-group-addon"><b>Rp.</b></span>
                        <input type="text" class="form-control" name="biaya" id="biaya" placeholder="0" required>
                        <span class="input-group-addon">,00</span>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-sm-3">
                    <label class="control-label col-sm-offset-2"> Total </label>
                </div>
                <div class="col-sm-3">
                    <div class="col-sm-11 input-group input-group-sm">
                        <span class="input-group-addon"><b>Rp.</b></span>
                        <input type="text" class="form-control" name="total" id="total" readonly>
                        <span class="input-group-addon">,00</span>
                    </div>
                </div>
            </div>
            <br>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary btn-save"><i class="fa fa-floppy-o"></i> Simpan </button>
                <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fa fa-arrow-circle-left"></i> Batal </button>
            </div>
        </form>

        </div>
    </div>
</div>