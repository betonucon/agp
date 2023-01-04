@extends('layouts.app')

@push('style')
  <style>
    label {
        display: inline-block;
        max-width: 100%;
        margin-bottom: 5px;
        font-weight: normal;
    }
  </style>
@endpush

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Form Barang
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Barang</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- SELECT2 EXAMPLE -->
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title"></h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
          </div>
        </div>
        
        <div class="box-body">
          <form class="form-horizontal">
            <div class="row">
            
              <div class="col-md-6">
                
                  <div class="box-body">
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-3 control-label">KD Barang</label>

                      <div class="col-sm-5">
                        <input type="text" name="KD_Barang" class="form-control input-sm" readonly value="{{$data->KD_Barang}}" placeholder="Ketik...">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-3 control-label">Nama Barang</label>

                      <div class="col-sm-9">
                        <input type="text" name="Nama_Barang" class="form-control input-sm" readonly value="{{$data->Nama_Barang}}" placeholder="Ketik...">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-3 control-label">KD Barang</label>

                      <div class="col-sm-9">
                        <input type="text" name="KD_Barang" class="form-control input-sm" readonly value="{{$data->KD_Barang}}" placeholder="Ketik...">
                      </div>
                    </div>
                    
                  </div>
                  <!-- /.box-body -->
                  
                  <!-- /.box-footer -->
                
              </div>
              <div class="col-md-6">
                
                  <div class="box-body">
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-3 control-label">Harga Spec</label>

                      <div class="col-sm-3">
                        <input type="text" name="Spec" class="form-control input-sm" readonly value="{{$data->Spec}}" placeholder="Ketik...">
                      </div>
                      <div class="col-sm-5">
                        <input type="text" name="Harga_Beli" class="form-control input-sm" readonly value="{{uang($data->Harga_Beli)}}" placeholder="Ketik...">
                      </div>
                    </div>
                    @if($data->Satuan2!="")
                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Harga {{$data->Satuan2}}</label>

                        <div class="col-sm-3">
                          <input type="text" name="Isi2" class="form-control input-sm" readonly value="{{$data->Isi2}} @if($data->Satuan3!='') X {{$data->Isi3}} @endif " placeholder="Ketik...">
                        </div>
                        <div class="col-sm-5">
                          <input type="text" name="Harga_Beli" class="form-control input-sm" readonly value="{{uang($data->Harga_Beli)}}" placeholder="Ketik...">
                        </div>
                      </div>
                    @endif
                    @if($data->Satuan3!="")
                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Harga {{$data->Satuan3}}</label>

                        <div class="col-sm-3">
                          <input type="text" name="Isi3" class="form-control input-sm" readonly value="{{$data->Isi3}}" placeholder="Ketik...">
                        </div>
                        <div class="col-sm-5">
                          <input type="text" name="Harga_Beli" class="form-control input-sm" readonly value="{{uang($data->Harga_Beli/$data->Isi3)}}" placeholder="Ketik...">
                        </div>
                      </div>
                    @endif
                    
                  </div>
                  <!-- /.box-body -->
                  
                  <!-- /.box-footer -->
                
              </div>
              
            </div>
          </form>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
        
                <button type="submit" class="btn btn-default">Cancel</button>
                <button type="submit" class="btn btn-info pull-right">Sign in</button>
                 
        </div>
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
@endsection

@push('ajax')
       
@endpush
