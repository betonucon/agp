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
@push('datatable')
<script type="text/javascript">
        /*
        Template Name: Color Admin - Responsive Admin Dashboard Template build with Twitter Bootstrap 4
        Version: 4.6.0
        Author: Sean Ngu
        Website: http://www.seantheme.com/color-admin/admin/
        */
        
        var handleDataTableFixedHeader = function() {
            "use strict";
            
            if ($('#data-table-fixed-header').length !== 0) {
                var table=$('#data-table-fixed-header').DataTable({
                    lengthMenu: [20,50,100],
                    searching:true,
                    lengthChange:false,
                    serverSide: true,
                    fixedHeader: {
                        header: true,
                        headerOffset: $('#header').height()
                    },
                    dom: 'lrtip',
                    responsive: true,
                    ajax:"{{ url('absen/getdata')}}",
                      columns: [
                        { data: 'id', render: function (data, type, row, meta) 
                            {
                              return meta.row + meta.settings._iDisplayStart + 1;
                            } 
                        },
                        
                        { data: 'action' },
                        { data: 'KD_Salesman' },
                        { data: 'nama_salesman' },
                        { data: 'Perusahaan' },
                        { data: 'tgl_register' },
                        { data: 'created_at' },
                        
                      ],
                      
                });
                $('#cari_datatable').keyup(function(){
                  table.search($(this).val()).draw() ;
                })

                
            }
        };

        var TableManageFixedHeader = function () {
            "use strict";
            return {
                //main function
                init: function () {
                    handleDataTableFixedHeader();
                }
            };
        }();

        function cari_tanggal(){
          var tanggal=$('#tanggal').val();
          var tables=$('#data-table-fixed-header').DataTable();
          tables.ajax.url("{{ url('absen/getdata')}}?tanggal="+tanggal).load();
          tables.on( 'draw', function () {
              var count=tables.data().count();
                $('#count_data').html('Total data :'+count)  
          } );
              
        }

        $(document).ready(function() {
          TableManageFixedHeader.init();
               
        });

        
    </script>
@endpush
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Absen
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Absen</li>
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
        <div class="box-header with-border">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                  <label>Total Data</label><br>
                  <p id="count_data">Total Data : {{count_barang()}}</p>
                  
              </div>
              
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label>Tanggal</label>
                <div class="input-group">
                  <input type="text" id="tanggal" class="form-control  input-sm">
                  <span class="input-group-addon" onclick="cari_tanggal()"><i class="fa fa-search"></i></span>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                  <label>Cari data</label>
                  <input type="text" id="cari_datatable" placeholder="Search....." class="form-control input-sm">
                  
              </div>
            </div>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
           
            <div class="col-md-12">
              <div class="table-responsive">
                <table id="data-table-fixed-header" class="display">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            
                            <th width="5%"></th>
                            <th width="13%">KD Salesman</th>
                            <th>Salesman</th>
                            <th width="18%">Lokasi / Customer</th>
                            <th width="18%">Rencana</th>
                            <th width="18%">Waktu Absen</th>
                        </tr>
                    </thead>
                    
                </table>
              </div>
            </div>
            
          </div>
          <!-- /.row -->
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          
        </div>
      </div>
      <!-- /.box -->

    </section>
    <div class="modal modal-primary fade" id="modal-foto">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span></button>
            <h4 class="modal-title"></h4>
          </div>
          <div class="modal-body" style="background-color: #bccdd7 !important;">
            <div class="row">
              <div class="col-md-8">
                <div id="map" style="width:100%;height:300px"></div>
              </div>
              <div class="col-md-4">
                <div id="foto" style="width: 100%;height: 200px;background: #fff;"></div>
                <div id="lokasi" style="text-align:center;padding:1%;color: #000;width: 100%;height: 100px;background: #fff;border-top:2px solid #bccdd7"></div>
              </div>
            </div>
            
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
  </div>
@endsection

@push('ajax')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
  <script>
      $('#tanggal').datepicker({
        format:'yyyy-mm-dd'
      });

      function lihat_data(id,lat,lon,kd_salesman,nama_salesman,perusahaan,foto,created_at){
          $('#modal-foto .modal-title').html(nama_salesman);
          $('#modal-foto').modal('show');
          $('#foto').html('<img src="{{url_plug()}}/_file_absen/'+foto+'" width="100%" height="200px">');
          $('#lokasi').html(perusahaan+'('+lat+','+lon+')<h4>'+nama_salesman+'</h4><h5>'+created_at+'</h5>');
          
          var map = L.map('map').setView([-6.01560072,105.98171146], 11.5);
    
          L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{
              
              maxZoom: 20,
              attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
          }).addTo(map);
          

          L.marker([lat, lon],
                {popupAnchor: [0, -5],
                className: 'marker'}).addTo(map)
          .bindPopup(perusahaan);
          setTimeout(function(){ map.invalidateSize()}, 400);
      }
  </script>
@endpush
