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
                      <label for="inputEmail3" class="col-sm-3 control-label">Kategori Barang</label>

                      <div class="col-sm-9">
                        <input type="text" name="Nama_Divisi" class="form-control input-sm" readonly value="{{$data->Nama_Divisi}}" placeholder="Ketik...">
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
        <div class="box-body">
          <form class="form-horizontal" id="mydata" method="post" action="{{ url('barang/upload') }}" enctype="multipart/form-data" >
            @csrf
            <input type="hidden" name="KD_Barang" value="{{$data->KD_Barang}}">
            <!-- <input type="submit"> -->
            <div class="row">
            
              <div class="col-md-12" style="background: #efeff1;">
                <div class="box-body">
                  <div class="form-group">
                    <label for="inputEmail3" class="col-sm-1 control-label">Foto</label>

                    <div class="col-sm-5">
                      <input type="file" name="foto"  class="form-control input-sm">
                    </div>
                    <div class="col-sm-1">
                      <span  class="btn btn-sm btn-info pull-left" onclick="simpan_data()">Upload</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </form>
          <div id="tampil-foto" style="padding: 2%;" ></div>    
        </div>
        <div class="box-footer">
        
                <button type="submit" class="btn btn-default" onclick="location.assign(`{{url('barang')}}`)">Kembali</button>
                 
        </div>
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
@endsection

@push('ajax')
    <script> 
        $('#tampil-foto').load("{{url('barang/modal_foto')}}?KD_Barang={{$data->KD_Barang}}");

        function hapus_foto(id){
           
            swal({
                title: "Yakin menghapus foto ini ?",
                text: "data akan hilang dari foto produk ini",
                type: "warning",
                icon: "error",
                showCancelButton: true,
                align:"center",
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: false
            }).then((willDelete) => {
                if (willDelete) {
                        $.ajax({
                            type: 'GET',
                            url: "{{url('barang/hapus_foto')}}",
                            data: "id="+id,
                            success: function(msg){
                                swal("Success! berhasil terhapus!", {
                                    icon: "success",
                                });
                                $('#tampil-foto').load("{{url('barang/modal_foto')}}?KD_Barang={{$data->KD_Barang}}");
                            }
                        });
                    
                    
                } else {
                    
                }
            });
            
        } 
        function aktif_foto(id){
           
            swal({
                title: "Yakin foto ini sebagai foto utama?",
                text: "data akan tampil sebagai foto utama",
                type: "warning",
                icon: "info",
                showCancelButton: true,
                align:"center",
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: false
            }).then((willDelete) => {
                if (willDelete) {
                        $.ajax({
                            type: 'GET',
                            url: "{{url('barang/aktif_foto')}}",
                            data: "id="+id,
                            success: function(msg){
                                swal("Success! berhasil diproses!", {
                                    icon: "success",
                                });
                                $('#tampil-foto').load("{{url('barang/modal_foto')}}?KD_Barang={{$data->KD_Barang}}");
                            }
                        });
                    
                    
                } else {
                    
                }
            });
            
        } 
        function simpan_data(){
            
            var form=document.getElementById('mydata');
            
                
                $.ajax({
                    type: 'POST',
                    url: "{{ url('barang/upload') }}",
                    data: new FormData(form),
                    contentType: false,
                    cache: false,
                    processData:false,
                    beforeSend: function() {
                        document.getElementById("loadnya").style.width = "100%";
                    },
                    success: function(msg){
                        var bat=msg.split('@');
                        if(bat[1]=='ok'){
                            document.getElementById("loadnya").style.width = "0px";
                            swal({
                              title: "Success! berhasil upload!",
                              icon: "success",
                            });
                            $('#tampil-foto').load("{{url('barang/modal_foto')}}?KD_Barang={{$data->KD_Barang}}");
                        }else{
                            document.getElementById("loadnya").style.width = "0px";
                            swal({
                                title: 'Notifikasi',
                               
                                html:true,
                                text:'ss',
                                icon: 'error',
                                buttons: {
                                    cancel: {
                                        text: 'Tutup',
                                        value: null,
                                        visible: true,
                                        className: 'btn btn-dangers',
                                        closeModal: true,
                                    },
                                    
                                }
                            });
                            $('.swal-text').html('<div style="width:100%;background:#f2f2f5;padding:1%;text-align:left;font-size:13px">'+msg+'</div>')
                        }
                        
                        
                    }
                });
        };
    </script> 
@endpush
