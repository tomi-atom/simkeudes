<div class="modal" id="modal-edit" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

        <form class="form-horizontal" data-toggle="validator" enctype="multipart/form-data"  method="POST">
        {{ csrf_field() }} {{ method_field('POST') }}
            <input  name="id" id="id" value="" readonly>
     
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"> &times; </span> </button>
                <h3 class="modal-title">Tambah Data Catatan Harian..</h3>
            </div>
            <br>
            
            <div class="row" >
                <div class="col-sm-3">
                    <label class="control-label col-sm-offset-2"> Tanggal  * </label>
                </div>
                <div class="col-sm-9">
                    <div class="col-sm-11 input-group input-group-sm">
                        <input type="date" class="form-control" name="tanggal" id="tanggal" placeholder="Tanggal" required>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-sm-3">
                    <label class="control-label col-sm-offset-2" id="lketerangan"> Kegiatan * </label>
                </div>
                <div class="col-sm-9">
                    <div class="col-sm-11 input-group">
                        <textarea class="form-control" rows="2" placeholder="Keterangan.." name="keterangan" id="keterangan" required></textarea>
                    </div>
                </div>
            </div>
           
            <br>
            <div class="row" id="file" >
                <div class="col-sm-3">
                    <label class="control-label col-sm-offset-2"> Bukti Pendukung (PDF)  </label>
                   
                </div>
                <div class="col-sm-9">
                    <div class="col-sm-11 input-group input-group-sm">
                        <input type="file" accept="application/pdf" name="upload" id="upload" class="form-control" >
                        <b>Max. 5 MB </b> 
                        <code>Dokumen berupa file  berbentuk PDF dengan ukuran (maks: 5 MB) sesuai panduan.</code>
                
                        <br> 
                        <br>
                       
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