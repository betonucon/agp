<div class="row">
    <div class="col-md-12" style="padding: 5px;">
        <div class="box-header ui-sortable-handle" style="cursor: move;border-bottom: solid 2px #dbdbdb;">
            <i class="fa fa-bars"></i>

            <h3 class="box-title">Foto Barang</h3>

            <div class="box-tools pull-right" data-toggle="tooltip" title="" data-original-title="Status">
            <div class="btn-group" data-toggle="btn-toggle">
                
            </div>
            </div>
        </div>
    </div>
     @foreach($data as $o)       
    <div class="col-md-2" style="padding: 5px;">
        <img src="{{url_plug()}}/_file_foto/{{$o->foto}}" width="100%">
        <div class="btn-group" style="position: absolute; right: 3%;">
        @if($o->sts==1)

        @else
        <span class="btn btn-sm btn-info"  onclick="aktif_foto({{$o->id}})"><i class="fa fa-check-square-o"></i></span>
        @endif
        
        <span class="btn btn-sm btn-danger"  onclick="hapus_foto({{$o->id}})"><i class="fa fa-remove"></i></span>
        </div>
        
    </div>
    @endforeach
</div>  