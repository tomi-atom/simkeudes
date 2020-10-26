<div class="modal" id="modal-anggaran" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

        <form class="form-horizontal" data-toggle="validator" method="POST">
        {{ csrf_field() }} {{ method_field('POST') }}
            <input type="hidden" name="id" id="id" value="id" readonly>
     
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"> &times; </span> </button>
                <h3 class="modal-title">Tambah Mata Anggaran ..</h3>
            </div>
            <br>

            <div class="row">
                <div class="col-sm-3">
                    <label class="control-label col-sm-offset-2"> Jenis</label>
                </div>
                <div class="col-sm-9">
                    <div class="col-sm-11 input-group input-group-sm">
                        <input type="text" class="form-control" name="jenis" id="jenis" required>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-sm-3">
                    <label class="control-label col-sm-offset-2"> Batas </label>
                </div>
                <div class="col-sm-3">
                    <div class="col-sm-11 input-group input-group-sm">
                        <input type="number" class="form-control " name="batas" id="batas" required>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-sm-3">
                    <label class="control-label col-sm-offset-2"> Aktif</label>
                </div>
                <div class="col-sm-2">
                    <div class="col-sm-12 input-group input-group-sm">
                        <select class="form-control" id="aktif" name="aktif" required>
                            <option value="1"> Aktif</option>
                            <option value="2"> Tidak Aktif </option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary btn-save"><i class="fa fa-floppy-o"></i> Simpan </button>
                <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fa fa-arrow-circle-left"></i> Batal </button>
            </div>
        </form>

        </div>
    </div>
</div>