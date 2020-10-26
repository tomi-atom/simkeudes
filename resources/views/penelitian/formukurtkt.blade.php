<div class="modal" id="modal-ukurtkt" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

        <form class="form-horizontal" data-toggle="validator" method="POST" >
        {{ csrf_field() }} {{method_field('POST')}}
        <input type="hidden" name="idtkt" id="idtkt" readonly>
        <input type="hidden" name="indextkt" id="indextkt" readonly>
     
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"> &times; </span> </button>
                <h3 class="modal-title">Perhitungan TKT</h3>
            </div>
            <br>

            <div class="col col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading bg-purple"><strong>Capaian Indikator TKT</strong> 
                    </div>
            
                    <div class="panel-body">
                        <div class="panel panel-primary">
                            <div class="panel-heading"><strong>Kategori: </strong> 
                            </div>
                            <div class="panel-body">
                                <div class="col-xs-10"></div>
                                <div class="col-xs-2" style="text-align: center;">
                                    <p class="text-muted well well-sm no-shadow">
                                    LEVEL TKT <span class="label label-success" id="idspan">0</span>
                                    </p>
                                </div>
                            
                                <table class="table table-bordered tabel-tkt" id="tbtkt">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="text-center" width="4%">No.</th>
                                            <th scope="col" class="text-center" width="80%">Indikator</th>
                                            <th scope="col" class="text-center" width="16%">Penilaian</th>
                                        </tr>
                                    </thead>
                                </table>

                                <div class="col col-sm-12" style="text-align: right;" id="olahtkt">
                                    <button onclick="progresTKT()" type="button" class="btn btn-success btn-save" id="btolahtkt"><i class="fa fa-calculator fa-ca"></i> Hitung </button>
                                </div>
                           
                                
                            </div>
                            
                        </div>
                        <div id="divbar">
                      
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <div class="col col-sm-12" style="text-align: right;" id="simpantkt" hidden>
                <button onclick="finalTKT()" type="button" class="btn btn-primary btn-save" id="btsimpantkt"><i class="fa fa-floppy-o"></i> Simpan </button>
                </div>
                <div class="col col-sm-12" style="text-align: right;" id="lanjuttkt" hidden>
                <button onclick="finalTKT()" type="button" class="btn btn-primary btn-save" id="btlanjuttkt"><i class="fa fa-angle-double-right fa-fw"></i> Lanjut </button>
                </div>
            </div>
        </form>

        </div>
    </div>
</div>