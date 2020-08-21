@extends('layouts.admin_master')
@section('title', 'Report by Offer Purchase')
@section('content')

    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <!-- BEGIN CONTENT BODY -->
        <div class="page-content">
            <!-- BEGIN PAGE HEADER-->
            <!-- BEGIN PAGE BAR -->
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <a href="{{url('admin')}}">Home</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <span>Report</span>
                    </li>
                </ul>
                <div class="page-toolbar">
                </div>
            </div>
            <!-- END PAGE BAR -->

            <!-- END PAGE HEADER-->

            <div class="row mt-3">
                <div class="col-md-12 col-sm-12">
                    <!-- BEGIN PORTLET-->
                    <!-- BEGIN PORTLET-->
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-share font-red-sunglo hide"></i>
                                <span class="caption-subject font-dark bold uppercase">Weekly Offer Purchase Report</span>
                                <span class="caption-helper font-dark bold uppercase">
                                    <a class="btn btn-xs btn-success " id="summary_table_excel_button" onclick="download_offer_purchase()"> <i class="fa fa-download"></i> Download Excel </a>
                                </span>
                            </div>
                            <div class="actions" id="action_buttons">
                                <form id="filter_form">
                                    <div class="form-group">
                                        <select class="form-control placeholder-no-fix" placeholder="Select year" name="year" id="year" value=""  autocomplete="off">
                                            <?php for($y = date('Y'); $y >= '1970'; $y--){ ?>
                                            <option value="{{$y}}" @if($y==$year) selected @endif>{{$y}}</option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="portlet-body p-relative">
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div id="chart_div" style="width: 100%; height: 500px;"></div>        
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <hr>
                                    <table id="report_table" class="table table-striped table-bordered table-hover data-table focus-table">
                                        <thead>
                                        <tr>
                                            <th class="text-center">Week</th>
                                            <th class="text-center">Green Offer Purchase</th>
                                            <th class="text-center">Red Offer Purchase</th>
                                            <th class="text-center">Total Purchase</th>
                                            <th class="text-center">Missed Target</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            $target = $settings->weekly_target;
                                            $total_purchase = 0;
                                            $grant_total_purchase = 0;
                                            foreach($week_array as $key=>$week){
                                                $total_purchase = $week['offer_1_purchases']+$week['offer_2_purchases'];
                                                $grant_total_purchase = $grant_total_purchase + $total_purchase;
                                                $missed_target_purchase = $target-$total_purchase;
                                                if($missed_target_purchase<0){
                                                    $missed_target_purchase = 0;
                                                }
                                            ?>
                                            <tbody>
                                                <tr>
                                                    <td style="" class="text-center">
                                                        <b>{{$key}}</b>
                                                    </td>
                                                    <td class="text-center">
                                                        {{$week['offer_1_purchases']}}
                                                    </td>
                                                    <td class="text-center">
                                                        {{$week['offer_2_purchases']}}
                                                    </td>
                                                    <td class="text-center">
                                                        {{$total_purchase}}
                                                    </td>
                                                    <td class="text-center">
                                                        {{$missed_target_purchase}}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        <?php } ?>
                                            <tfoot>
                                                <tr>
                                                    <td style="" class="text-center">
                                                        <b>Total</b>
                                                    </td>
                                                    <td></td>
                                                    <td></td>
                                                    <td class="text-center">
                                                        {{$grant_total_purchase}}
                                                    </td>
                                                    <td></td>
                                                </tr>
                                            </tfoot>
                                    </table>
                                </div>
                                
                            </div>
                            
                        </div>
                    </div>
                    <!-- END PORTLET-->
                </div>
            </div>

        </div>
        <!-- END CONTENT BODY -->
    </div>

    <!-- END CONTENT -->
@endsection

@section('js')
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <script>
        $(document).on('change','#year',function(){
            $('#filter_form').submit();
        })

        function download_offer_purchase() {
            var year = $('#year').val();
            var url = "{{ url("admin/download_report_offer_purchased_excel") }}?year="+year;
            window.open(url);
        }

        //Chart
        google.charts.load('current', {packages: ['corechart', 'line']});
        google.charts.setOnLoadCallback(drawBasic);

        function drawBasic() {

            var data = new google.visualization.DataTable();
            data.addColumn('number', 'X');
            data.addColumn('number', 'Sell Count');

            data.addRows([
                [0, 0],   [1, 110],  [2, 123],  [3, 117],  [4,118],  [5, 119],
                [6, 11],  [7, 147],  [8, 93],  [9, 180],  [10, 232], [11, 35],
                [12, 130], [13, 140], [14, 102], [15, 247], [16, 44], [17, 248],
                [18, 152], [19, 54], [20, 42], [21, 55], [22, 56], [23, 57],
                [24, 160], [25, 150], [26, 152], [27, 51], [28, 49], [29, 353],
                [30, 155], [31, 260], [32, 61], [33, 59], [34, 262], [35, 65],
                [36, 162], [37, 58], [38, 55], [39, 61], [40, 64], [41, 65],
                [42, 163], [43, 66], [44, 155], [45, 469], [46, 69], [47, 70],
                [48, 172], [49, 268], [50, 166], [51, 65], [52, 67], [53, 270],
                [54, 171], [55, 172]
            ]);

            var options = {
                hAxis: {
                    title: 'Week'
                },
                vAxis: {
                    title: 'No of user',
                    viewWindow: {
                        max: 500
                    }
                }
            };

            var chart = new google.visualization.LineChart(document.getElementById('chart_div'));

            chart.draw(data, options);
            }

    </script>
@endsection

