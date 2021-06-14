<div class="modal" id="modal-mahasiswa" tabindex="-1" role="dialog" aria-hidden="true"  >
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
                <input type="hidden" name="dosenid" id="dosenid" value="{{ $proposalid }}" readonly>
                <input type="hidden" name="propsid" id="propsid" value="{{ $idskemapro }}" readonly>

                <div class="row">
                    <div class="col-sm-2">
                        <label class="control-label col-sm-offset-1">NIM</label>
                    </div>
                    <div class="col-sm-6">
                        <div  class=" col-sm-6 input-group input-group-sm">
                            <input type="text" class="form-control" name="nim" id="nim"required>

                        </div>
                    </div>
                </div>
                <p></p>
                <div class="row">
                    <div class="col-sm-2">
                        <label class="control-label col-sm-offset-1">Nama</label>
                    </div>
                    <div class="col-sm-6">
                        <div class="col-sm-6 input-group input-group-sm">
                            <input type="text" class="form-control" name="nama" id="nama"required>

                        </div>
                    </div>
                </div>
                <p></p>

                <div class="row">
                    <div class="col-sm-2">
                        <label class="control-label col-sm-offset-1 ">Fakultas</label>
                    </div>
                    <div class="col-sm-4">
                        <div class="col-sm-12 input-group input-group-sm">
                            <select id="fk" class="form-control" name="fk" required>
                                <option value=""> -- Pilih Fakultas --</option>
                                @foreach($fk as $list)
                                    <option value="{{$list->id}}" {{$dosen->idfakultas == $list->id ? 'selected' : ''}}> {{$list->fakultas}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>


                </div>
                <p></p>
                <div class="row">
                    <div class="col-sm-2">
                        <label class="control-label col-sm-offset-1 ">Jenis Kelamin</label>
                    </div>
                    <div class="col-sm-4">
                        <div class="col-sm-12 input-group input-group-sm">
                            <select id="jk" class="form-control" name="jk" required>
                                <option value=""> -- Pilih Jenis Kelamin --</option>
                                <option value="1">Laki-Laki</option>
                                <option value="2">Perempuan</option>

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