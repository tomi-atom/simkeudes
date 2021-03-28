<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Simlitabmas-UNRI | Grafik</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <link rel="icon" type="image/png" href="{{ asset('public/favicon.png') }}">

    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('public/adminLTE/bootstrap/css/bootstrap.min.css') }}">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('public/font-awesome/css/font-awesome.min.css') }}">

    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('public/Ionicons/css/ionicons.min.css') }}">

    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('public/adminLTE/dist/css/AdminLTE.min.css') }}">

    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('public/adminLTE/plugins/iCheck/square/blue.css') }}">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

    <!-- </head> -->
</head>
<body class="hold-transition ">

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading"> <div class="pull-right"><strong></strong></div></div>

            <div class="panel-body">
                <br>
                <!-- /.col (LEFT) -->
                <div class="col-md-6">
                    <!-- DONUT CHART -->
                    <div class="box box-primary">
                        <div id="chartpenelitian">
                        </div>
                    </div>
                    <!-- /.box -->

                </div>
                <div class="col-md-6">
                    <div class="box box-primary">


                    </div>

                </div>
                <br><br>

            </div>
        </div>
    </div>
</div>
<!-- jQuery 3 -->
<script src="{{ asset('public/adminLTE/plugins/jQuery/jquery.min.js') }}"></script>

<!-- Bootstrap 3.3.7 -->
<script src="{{ asset('public/adminLTE/bootstrap/js/bootstrap.min.js') }}"></script>

<!-- iCheck -->
<script src="{{ asset('public/adminLTE/plugins/iCheck/icheck.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>

    var url = "{{url('grafik/chart')}}";
    var Years = new Array();
    var Labels = new Array();
    var Prices = new Array();

    $(document).ready(function(){
        $.get(url, function(response){
            response.forEach(function(data){
                Years.push(data.jenis);
                Labels.push(data.jenis);
                Prices.push(data.idprogram);
            });
            var options = {
                series: [{
                    name: 'FMIPA',
                    data: [{{$cmipa}}, {{$cmipa21}}]
                }, {
                    name: 'FT',
                    data: [{{$cft}}, {{$cft21}}]
                },
                    {
                        name: 'FEB',
                        data: [{{$cfeb}}, {{$cfeb21}}]
                    },
                    {
                        name: 'Fisipol',
                        data: [{{$cfisip}}, {{$cfisip21}}]
                    },
                    {
                        name: 'Faperika',
                        data: [{{$cfaperika}}, {{$cfaperika21}}]
                    },
                    {
                        name: 'FKIP',
                        data: [{{$cfkip}}, {{$cfkip21}}]
                    },
                    {
                        name: 'Faperta',
                        data: [{{$cfaperta}}, {{$cfaperta21}}]
                    },
                    {
                        name: 'Keperawatan',
                        data: [{{$ckeperawatan}}, {{$ckeperawatan21}}]
                    },
                    {
                        name: 'Lainnya',
                        data: [{{$cnone}}, {{$cnone21}}]
                    },
                ],
                chart: {
                    type: 'bar',
                    height: 350,
                    stacked: true,
                },
                plotOptions: {
                    bar: {
                        horizontal: true,
                    },
                },
                stroke: {
                    width: 1,
                    colors: ['#fff']
                },
                title: {
                    text: 'Statistik Proposal Dana PPM dan PNBP dalam 2 Tahun Terakhir'
                },
                xaxis: {
                    categories: [2020, 2021],
                    labels: {

                    }
                },
                yaxis: {
                    title: {
                        text: undefined
                    },
                },
                tooltip: {
                    y: {
                        formatter: function (val) {
                            return val
                        }
                    }
                },
                fill: {
                    opacity: 1
                },
                legend: {
                    position: 'top',
                    horizontalAlign: 'left',
                    offsetX: 40
                }
            };

            var chart = new ApexCharts(document.querySelector("#chartpenelitian"), options);
            chart.render();
        });
    });


</script>

<!-- </body></html> -->
</body>
</html>