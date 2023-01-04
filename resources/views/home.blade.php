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
                    fixedHeader: {
                        header: true,
                        headerOffset: $('#header').height()
                    },
                    responsive: true,
                    ajax:"{{ url('barang/getdata')}}",
                      columns: [
                        { data: 'KD_Barang', render: function (data, type, row, meta) 
                            {
                              return meta.row + meta.settings._iDisplayStart + 1;
                            } 
                        },
                        
                        { data: 'action' },
                        { data: 'KD_Barang' },
                        { data: 'Kd_JenisBarang' },
                        { data: 'Nama_Barang' },
                        { data: 'uang_Harga_Beli' },
                        
                      ],
                      
                });
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

        $(document).ready(function() {
			TableManageFixedHeader.init();
            
		});

        
    </script>
@endpush
@section('content')
<div class="content-wrapper" style="min-height: 926.281px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        <small>Control Transaksi</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    
    <section class="content">
      
    <div class="row">
        @foreach(get_statusapprove() as $no=>$kd)
            
            <div class="col-lg-3 col-xs-6">
            
                <div class="small-box bg-{{$kd->color}}">
                    <div class="inner">
                        <h3>44<sup style="font-size: 20px">Pr</sup></h3>

                        <p>{{$kd->status_approve}}</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="{{url('barang')}}" class="small-box-footer">Lihat Data <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        @endforeach
         
    </div>
        
        
      
      <div class="row">
        <div class="col-md-9">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Grafik Product Request</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="chart">
                        <canvas id="barChart" style="height: 230px; width: 510px;" height="230" width="510"></canvas>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
        <div class="col-md-3">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Product Request</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    @foreach(get_kdjenis() as $no=>$kd)
                        <?php
                            if($no==0){
                                $color="blue";
                            }
                            if($no==1){
                                $color="aqua";
                            }
                            if($no==2){
                                $color="green";
                            }
                            if($no==3){
                                $color="red";
                            }
                            
                        ?>
                        <div class="progress-group">
                            <span class="progress-text">{{$kd->Kd_JenisBarang}}</span>
                            <span class="progress-number"><b>{{persen_barang_even($kd->Kd_JenisBarang)}}</b></span>

                            <div class="progress sm">
                                <div class="progress-bar progress-bar-{{$color}}" style="width: {{persen_barang_even($kd->Kd_JenisBarang)}}%"></div>
                            </div>
                        </div>
                    @endforeach
                        <div class="progress-group">
                            <span class="progress-text">Total</span>
                            <span class="progress-number"><b>100</b></span>

                            <div class="progress sm">
                                <div class="progress-bar progress-bar-yellow" style="width: 100%"></div>
                            </div>
                        </div>
                </div>
                  
            </div>
                 
                
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Grafik Sales Order</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="chart">
                        <canvas id="barChartcustomer" style="height: 230px; width: 510px;" height="230" width="510"></canvas>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
        <div class="col-md-6">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Customer Registrasi</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    @foreach(get_kdjenis() as $no=>$kd)
                        <?php
                            if($no==0){
                                $color="blue";
                            }
                            if($no==1){
                                $color="aqua";
                            }
                            if($no==2){
                                $color="green";
                            }
                            if($no==3){
                                $color="red";
                            }
                            
                        ?>
                        <div class="progress-group">
                            <span class="progress-text">{{$kd->Kd_JenisBarang}}</span>
                            <span class="progress-number"><b>{{persen_barang_even($kd->Kd_JenisBarang)}}</b></span>

                            <div class="progress sm">
                                <div class="progress-bar progress-bar-{{$color}}" style="width: {{persen_barang_even($kd->Kd_JenisBarang)}}%"></div>
                            </div>
                        </div>
                    @endforeach
                        <div class="progress-group">
                            <span class="progress-text">Total</span>
                            <span class="progress-number"><b>100</b></span>

                            <div class="progress sm">
                                <div class="progress-bar progress-bar-yellow" style="width: 100%"></div>
                            </div>
                        </div>
                </div>
                  
            </div>
                 
                
        </div>
      </div>
      

    </section>
  </div>
@endsection

@push('ajax')
<script src="{{url_plug()}}/bower_components/chart.js/Chart.js"></script>
<!-- FastClick -->
<!-- page script -->
<script>
  $(function () {
    /* ChartJS
     * -------
     * Here we will create a few charts using ChartJS
     */

    

    var areaChartData = {
      labels  : [
        @for($x=1;$x<13;$x++)
            '{{bulan(ubah_bulan($x))}}',
        @endfor
      ],
      datasets: [
        {
          label               : 'Electronics',
          fillColor           : 'rgba(210, 214, 222, 1)',
          strokeColor         : 'rgba(210, 214, 222, 1)',
          pointColor          : 'rgba(210, 214, 222, 1)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data                : [
            @for($x=1;$x<13;$x++)
                {{$x*10}},
            @endfor
          ]
        },
        {
          label               : 'Digital Goods',
          fillColor           : 'rgba(60,141,188,0.9)',
          strokeColor         : 'rgba(60,141,188,0.8)',
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
          data                : [
            @for($x=1;$x<13;$x++)
                {{$x*12}},
            @endfor
          ]
        }
      ]
    }
    // get_CustomerYear
    var areaChartDatacustomer = {
      labels  : [
        @foreach(get_sales() as $getcu)
            '{{$getcu->Nama}}',
        @endforeach
      ],
      datasets: [
        {
          label               : 'Electronics',
          fillColor           : 'rgba(210, 214, 222, 1)',
          strokeColor         : 'rgba(210, 214, 222, 1)',
          pointColor          : 'rgba(210, 214, 222, 1)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data                : [
            @foreach(get_sales() as $getcu)
                {{$getcu->id}},
            @endforeach
          ]
        }
      ]
    }

   
   
    var barChartCanvas                   = $('#barChart').get(0).getContext('2d')
    var barChart                         = new Chart(barChartCanvas)
    var barChartData                     = areaChartData
    barChartData.datasets[1].fillColor   = '#00a65a'
    barChartData.datasets[1].strokeColor = '#00a65a'
    barChartData.datasets[1].pointColor  = '#00a65a'
   
   
    var barChartCanvascustomer                   = $('#barChartcustomer').get(0).getContext('2d')
    var barChartcustomer                         = new Chart(barChartCanvascustomer)
    var barChartDatacustomer                     = areaChartDatacustomer
    barChartDatacustomer.datasets[0].fillColor   = 'blue'
    barChartDatacustomer.datasets[0].strokeColor = 'blue'
    barChartDatacustomer.datasets[0].pointColor  = 'blue'



    var barChartOptions                  = {
      //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
      scaleBeginAtZero        : true,
      //Boolean - Whether grid lines are shown across the chart
      scaleShowGridLines      : true,
      //String - Colour of the grid lines
      scaleGridLineColor      : 'rgba(0,0,0,.05)',
      //Number - Width of the grid lines
      scaleGridLineWidth      : 1,
      //Boolean - Whether to show horizontal lines (except X axis)
      scaleShowHorizontalLines: true,
      //Boolean - Whether to show vertical lines (except Y axis)
      scaleShowVerticalLines  : true,
      //Boolean - If there is a stroke on each bar
      barShowStroke           : true,
      //Number - Pixel width of the bar stroke
      barStrokeWidth          : 2,
      //Number - Spacing between each of the X value sets
      barValueSpacing         : 5,
      //Number - Spacing between data sets within X values
      barDatasetSpacing       : 1,
      //String - A legend template
      legendTemplate          : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].fillColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
      //Boolean - whether to make the chart responsive
      responsive              : true,
      maintainAspectRatio     : true
    }

    barChartOptions.datasetFill = false
    barChart.Bar(barChartData, barChartOptions)
    barChartcustomer.Bar(barChartDatacustomer, barChartOptions)
  })
</script>      
@endpush
