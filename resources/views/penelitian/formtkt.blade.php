<div class="modal" id="modal-tkt" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

        <form class="form-horizontal" data-toggle="validator" method="POST" >
        {{ csrf_field() }} {{ method_field('POST') }}
     
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"> &times; </span> </button>
                <h3 class="modal-title">Perhitungan TKT..</h3>
            </div>
            <br>

            <div class="col col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading bg-purple"><strong>Teknologi yang dikembangkan dalam riset yang akan diukur TKT-nya</strong> 
                    </div>
            
                    <div class="panel-body">
                        <textarea class="form-control" rows="2" placeholder="Tuliskan teknologi yang dikembangkan" name="teknologi" id="teknologi" required></textarea>
                    </div>
                </div>
            </div>

            <div class="col col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading bg-purple"><strong>Kategori Indikator TKT</strong> 
                    </div>
            
                    <div class="panel-body">
                        @foreach ($bidang as $pilihan)
                        <div class="radio">
                            <label>
                                @if($pilihan->id == 1)
                                <input type="radio" name="optionsRadios" value="{{$pilihan->id}}" checked>
                                {{$pilihan->bidang}}
                                @else
                                <input type="radio" name="optionsRadios" value="{{$pilihan->id}}">
                                {{$pilihan->bidang}}
                                @endif
                            </label>
                        </div>
                        @endforeach   
                        <div class="radio" >
                            <label>
                                <input type="radio" name="optionsRadios" id="umum" value="" disabled hidden>
                                
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <br>
  
            <div class="modal-footer">
                <div class="col col-sm-12" style="text-align: center;">
                <button onclick="hitungTKT()" type="button" class="btn btn-success btn-save"><i class="ion ion-ios-flask-outline"></i> Hitung TKT </button>
                </div>
            </div>
        </form>

        </div>
    </div>
</div>