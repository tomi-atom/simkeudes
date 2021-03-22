<div class="modal" id="modal-luaran" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

        <form class="form-horizontal" data-toggle="validator" method="POST">
        {{ csrf_field() }} {{ method_field('POST') }}
            <input type="hidden" name="id" id="id" value="{{ $idprop }}" readonly>
     
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"> &times; </span> </button>
                <h3 class="modal-title">Tambah Data Luaran..</h3>
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
                            <option value="2" > 2 </option>
                            <option value="3" > 3 </option>
                        </select>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-sm-3">
                    <label class="control-label col-sm-offset-2"> Kategori Luaran</label>
                </div>
                <div class="col-sm-4">
                    <div class="col-sm-12 input-group input-group-sm">
                        <select id="kategori" class="form-control" name="kategori" required>
                            <option value=""> -- Pilih Kategori Luaran --</option>
                            <option value="1"> Luaran Wajib </option>
                            <option value="2"> Luaran Tambahan </option>
                        </select>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-sm-3">
                    <label class="control-label col-sm-offset-2"> Jenis Luaran </label>
                </div>
                <div class="col-sm-6">
                    <div class="col-sm-12 input-group input-group-sm">
                        <select id="jenis" class="form-control" name="jenis" required>
                            <option value=""> -- Pilih Jenis Luaran --</option>
                            @foreach ($jenis as $data)
                                <option value="{{ $data->id }}"> {{ $data->jenis }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-sm-3">
                    <label class="control-label col-sm-offset-2"> Target </label>
                </div>
                <div class="col-sm-6">
                    <div class="col-sm-12 input-group input-group-sm">
                        <select id="target" class="form-control" name="target" required>
                            <option value=""> -- Pilih Target --</option>
                        </select>
                    </div>
                </div>
            </div>
            <br>
            <div class="row" id="hjurnal" hidden>
                <div class="col-sm-3">
                    <label class="control-label col-sm-offset-2" id="ljurnal"> Nama Jurnal </label>
                </div>
                <div class="col-sm-9">
                    <div class="col-sm-11 input-group">
                        <textarea class="form-control" rows="2" placeholder="Nama Jurnal / Konferensi" name="jurnal" id="jurnal"></textarea>
                    </div>
                </div>
            </div>
            <br>
            <div class="row" id="hlinkurl" hidden>
                <div class="col-sm-3">
                    <label class="control-label col-sm-offset-2"> URL Jurnal (Jika ada) </label>
                </div>
                <div class="col-sm-9">
                    <div class="col-sm-11 input-group input-group-sm">
                        <span class="input-group-addon"><b>http://</b></span>
                        <input type="text" class="form-control" name="linkurl" id="linkurl" placeholder="url address">
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