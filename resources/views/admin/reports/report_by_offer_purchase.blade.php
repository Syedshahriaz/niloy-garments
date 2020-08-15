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
                                <span class="caption-helper"></span>
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
                            <table id="report_table" class="table table-striped table-bordered table-hover data-table focus-table">
                                <thead>
                                <tr>
                                    <th class="text-center">Week</th>
                                    <th class="text-center">Green Offer Purchase</th>
                                    <th class="text-center">Red Offer Purchase</th>
                                    <th class="text-center">Total Purchase</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                    $total_purchase = 0;
                                    $grant_total_purchase = 0;
                                    foreach($week_array as $key=>$week){
                                    $total_purchase = $week['offer_1_purchases']+$week['offer_2_purchases'];
                                    $grant_total_purchase = $grant_total_purchase + $total_purchase;
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
                                        </tr>
                                    </tfoot>
                            </table>
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
    <script>
        $(document).on('change','#year',function(){
            $('#filter_form').submit();
        })
    </script>
@endsection

