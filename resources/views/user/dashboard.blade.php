@extends('layouts.master')
@section('title', 'Niloy Garments::Dashboard')
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
                        <a href="index.html">Home</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <span>Dashboard</span>
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
                    <div class="portlet light ">
                        <div class="portlet-body" style="padding-top: 0;">
                            <div class="row">
                                <div class="col-md-4">
                                    <p class="mb-0"><b>Buyer Name:</b> Marcel Holcaustan</p>
                                    <p class="mb-0"><b>Email:</b> marcel@gmail.com</p>
                                    <p class="mb-0"><b>Phone:</b> +112131333334</p>
                                </div>
                                <div class="col-md-4">
                                    <p class="mb-0"><b>Buying Agent Name:</b> Marcel Holcaustan</p>
                                    <p class="mb-0"><b>Email:</b> marcel@gmail.com</p>
                                    <p class="mb-0"><b>Phone:</b> +112131333334</p>
                                </div>
                                <div class="col-md-4">
                                    <p class="mb-0"><b>Address:</b><br> House-3, Road-3, Sec-3, Mirpur, Dhaka-1230</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- BEGIN DASHBOARD STATS 1-->
                    <div class="portlet light ">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-share font-red-sunglo hide"></i>
                                <span class="caption-subject font-dark bold uppercase">All Project Review </span>
                                <span class="caption-helper"></span>
                            </div>

                            <div class="actions">
                                <a title="Vertical View" class="btn btn-transparent theme-btn btn-outline btn-circle btn-sm" href="javascript:;" id="vertical_view_btn">
                                    <!--i class="icon-list icons"></i-->Vertical View
                                </a>
                                <a title="Horizontal View" class="btn btn-transparent theme-btn btn-circle btn-sm" href="javascript:;" id="horzon_view_btn">
                                    <!--i class="icon-grid icons"></i-->Horizontal View
                                </a>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive" style="max-height: 440px; overflow: auto;">
                                        <table class="table table-striped table-bordered table-hover data-table focus-table dt-responsive" id="user_dash_horizontal_task">
                                            <thead>
                                                <tr>
                                                    <th>Title</th>
                                                    <th>Title</th>
                                                    <th>Cotton</th>
                                                    <th>Spinning</th>
                                                    <th>Knitting</th>
                                                    <th>Dying</th>
                                                    <th>Finising </th>
                                                    <th>Test</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- First table -->
                                                <tr class="focus-tr">
                                                    <td> <b>Project</b></td>
                                                    <td> <b>Rule</b></td>
                                                    <td> <b>Cutting</b> </td>
                                                    <td> <b>Sweing</b> </td>
                                                    <td> <b>Finishing</b> </td>
                                                    <td> <b>Final Inspection</b> </td>
                                                    <td> <b>X Factor</b> </td>
                                                    <td> <b>ETA</b> </td>
                                                </tr>
                                                <tr>
                                                    <td rowspan="2"> <b>Project A</b>
                                                    <td> <b>Due Date</b>
                                                    </td>
                                                    <td>
                                                        Wednesday,
                                                        <br>August 16, 2017
                                                    </td>
                                                    <td>
                                                        Saturday,
                                                        <br>September 16, 2017
                                                    </td>
                                                    <td>
                                                        Tuesday,
                                                        <br>October 17, 2017
                                                    </td>
                                                    <td>
                                                        Thursday,
                                                        <br>January 03, 2019
                                                    </td>
                                                    <td>
                                                        Sunday,
                                                        <br>July 03, 2022
                                                    </td>
                                                    <td>
                                                        Tuesday,
                                                        <br>July 03, 2029
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td> <b>Original Delivery Date</b></td>
                                                    <td>
                                                        Wednesday,
                                                        <br>August 16, 2017
                                                    </td>
                                                    <td>
                                                        Saturday,
                                                        <br>September 16, 2017
                                                    </td>
                                                    <td>
                                                        Tuesday,
                                                        <br>October 17, 2017
                                                    </td>
                                                    <td>
                                                        Thursday,
                                                        <br>January 03, 2019
                                                    </td>
                                                    <td>
                                                        Sunday,
                                                        <br>July 03, 2022
                                                    </td>
                                                    <td>
                                                        Tuesday,
                                                        <br>July 03, 2029
                                                    </td>
                                                </tr>

                                                <!-- Second table -->
                                                <tr class="focus-tr">
                                                    <td> <b>Project</b></td>
                                                    <td> <b>Rule</b></td>
                                                    <td> <b>Cutting</b> </td>
                                                    <td> <b>Sweing</b> </td>
                                                    <td> <b>Finishing</b> </td>
                                                    <td> <b>Final Inspection</b> </td>
                                                    <td> <b>X Factor</b> </td>
                                                    <td> <b>ETA</b> </td>
                                                    <td> <b>ETA1</b> </td>
                                                    <td> <b>ETA2</b> </td>
                                                    <td> <b>ETA3</b> </td>
                                                </tr>
                                                <tr>
                                                    <td rowspan="2"> <b>Project B</b>
                                                    <td> <b>Due Date</b>
                                                    </td>
                                                    <td>
                                                        Wednesday,
                                                        <br>August 16, 2017
                                                    </td>
                                                    <td>
                                                        Saturday,
                                                        <br>September 16, 2017
                                                    </td>
                                                    <td>
                                                        Tuesday,
                                                        <br>October 17, 2017
                                                    </td>
                                                    <td>
                                                        Thursday,
                                                        <br>January 03, 2019
                                                    </td>
                                                    <td>
                                                        Sunday,
                                                        <br>July 03, 2022
                                                    </td>
                                                    <td>
                                                        Tuesday,
                                                        <br>July 03, 2029
                                                    </td>
                                                    <td>
                                                        Tuesday,
                                                        <br>July 03, 2029
                                                    </td>
                                                    <td>
                                                        Tuesday,
                                                        <br>July 03, 2029
                                                    </td>
                                                    <td>
                                                        Tuesday,
                                                        <br>July 03, 2029
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td> <b>Original Delivery Date</b></td>
                                                    <td>
                                                        Wednesday,
                                                        <br>August 16, 2017
                                                    </td>
                                                    <td>
                                                        Saturday,
                                                        <br>September 16, 2017
                                                    </td>
                                                    <td>
                                                        Tuesday,
                                                        <br>October 17, 2017
                                                    </td>
                                                    <td>
                                                        Thursday,
                                                        <br>January 03, 2019
                                                    </td>
                                                    <td>
                                                        Sunday,
                                                        <br>July 03, 2022
                                                    </td>
                                                    <td>
                                                        Tuesday,
                                                        <br>July 03, 2029
                                                    </td>
                                                    <td>
                                                        Tuesday,
                                                        <br>July 03, 2029
                                                    </td>
                                                    <td>
                                                        Tuesday,
                                                        <br>July 03, 2029
                                                    </td>
                                                    <td>
                                                        Tuesday,
                                                        <br>July 03, 2029
                                                    </td>
                                                </tr>

                                                <!-- Second table -->
                                                <tr class="focus-tr">
                                                    <td> <b>Project</b></td>
                                                    <td> <b>Rule</b></td>
                                                    <td> <b>Cutting</b> </td>
                                                    <td> <b>Sweing</b> </td>
                                                    <td> <b>Finishing</b> </td>
                                                    <td> <b>Final Inspection</b> </td>
                                                    <td> <b>X Factor</b> </td>
                                                    <td> <b>ETA</b> </td>
                                                    <td> <b>ETA1</b> </td>
                                                    <td> <b>ETA2</b> </td>
                                                    <td> <b>ETA3</b> </td>
                                                </tr>
                                                <tr>
                                                    <td rowspan="2"> <b>Project B</b>
                                                    <td> <b>Due Date</b>
                                                    </td>
                                                    <td>
                                                        Wednesday,
                                                        <br>August 16, 2017
                                                    </td>
                                                    <td>
                                                        Saturday,
                                                        <br>September 16, 2017
                                                    </td>
                                                    <td>
                                                        Tuesday,
                                                        <br>October 17, 2017
                                                    </td>
                                                    <td>
                                                        Thursday,
                                                        <br>January 03, 2019
                                                    </td>
                                                    <td>
                                                        Sunday,
                                                        <br>July 03, 2022
                                                    </td>
                                                    <td>
                                                        Tuesday,
                                                        <br>July 03, 2029
                                                    </td>
                                                    <td>
                                                        Tuesday,
                                                        <br>July 03, 2029
                                                    </td>
                                                    <td>
                                                        Tuesday,
                                                        <br>July 03, 2029
                                                    </td>
                                                    <td>
                                                        Tuesday,
                                                        <br>July 03, 2029
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td> <b>Original Delivery Date</b></td>
                                                    <td>
                                                        Wednesday,
                                                        <br>August 16, 2017
                                                    </td>
                                                    <td>
                                                        Saturday,
                                                        <br>September 16, 2017
                                                    </td>
                                                    <td>
                                                        Tuesday,
                                                        <br>October 17, 2017
                                                    </td>
                                                    <td>
                                                        Thursday,
                                                        <br>January 03, 2019
                                                    </td>
                                                    <td>
                                                        Sunday,
                                                        <br>July 03, 2022
                                                    </td>
                                                    <td>
                                                        Tuesday,
                                                        <br>July 03, 2029
                                                    </td>
                                                    <td>
                                                        Tuesday,
                                                        <br>July 03, 2029
                                                    </td>
                                                    <td>
                                                        Tuesday,
                                                        <br>July 03, 2029
                                                    </td>
                                                    <td>
                                                        Tuesday,
                                                        <br>July 03, 2029
                                                    </td>
                                                </tr>

                                                <!-- Second table -->
                                                <tr class="focus-tr">
                                                    <td> <b>Project</b></td>
                                                    <td> <b>Rule</b></td>
                                                    <td> <b>Cutting</b> </td>
                                                    <td> <b>Sweing</b> </td>
                                                    <td> <b>Finishing</b> </td>
                                                    <td> <b>Final Inspection</b> </td>
                                                    <td> <b>X Factor</b> </td>
                                                    <td> <b>ETA</b> </td>
                                                    <td> <b>ETA1</b> </td>
                                                    <td> <b>ETA2</b> </td>
                                                    <td> <b>ETA3</b> </td>
                                                </tr>
                                                <tr>
                                                    <td rowspan="2"> <b>Project B</b>
                                                    <td> <b>Due Date</b>
                                                    </td>
                                                    <td>
                                                        Wednesday,
                                                        <br>August 16, 2017
                                                    </td>
                                                    <td>
                                                        Saturday,
                                                        <br>September 16, 2017
                                                    </td>
                                                    <td>
                                                        Tuesday,
                                                        <br>October 17, 2017
                                                    </td>
                                                    <td>
                                                        Thursday,
                                                        <br>January 03, 2019
                                                    </td>
                                                    <td>
                                                        Sunday,
                                                        <br>July 03, 2022
                                                    </td>
                                                    <td>
                                                        Tuesday,
                                                        <br>July 03, 2029
                                                    </td>
                                                    <td>
                                                        Tuesday,
                                                        <br>July 03, 2029
                                                    </td>
                                                    <td>
                                                        Tuesday,
                                                        <br>July 03, 2029
                                                    </td>
                                                    <td>
                                                        Tuesday,
                                                        <br>July 03, 2029
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td> <b>Original Delivery Date</b></td>
                                                    <td>
                                                        Wednesday,
                                                        <br>August 16, 2017
                                                    </td>
                                                    <td>
                                                        Saturday,
                                                        <br>September 16, 2017
                                                    </td>
                                                    <td>
                                                        Tuesday,
                                                        <br>October 17, 2017
                                                    </td>
                                                    <td>
                                                        Thursday,
                                                        <br>January 03, 2019
                                                    </td>
                                                    <td>
                                                        Sunday,
                                                        <br>July 03, 2022
                                                    </td>
                                                    <td>
                                                        Tuesday,
                                                        <br>July 03, 2029
                                                    </td>
                                                    <td>
                                                        Tuesday,
                                                        <br>July 03, 2029
                                                    </td>
                                                    <td>
                                                        Tuesday,
                                                        <br>July 03, 2029
                                                    </td>
                                                    <td>
                                                        Tuesday,
                                                        <br>July 03, 2029
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>


                                    <table class="table table-striped table-bordered table-hover data-table focus-table hidden" id="user_dash_vertical_task">
                                        <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th> Role </th>
                                                <th> Due Date </th>
                                                <th> Original Delivery Date </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <!-- END DASHBOARD STATS 1-->
                </div>
            </div>

        </div>
        <!-- END CONTENT BODY -->
    </div>
    <!-- END CONTENT -->
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            // $('#user_dash_horizontal_task, #user_vertical_task').DataTable({
            //     "paging":   false,
            //     "ordering": false,
            //     "info":     false,
            //     "searching": false,
            //     "responsive": true,
            //     "scrollY": "200px",
            //     "scrollCollapse": true,
            //     "paging": false
            // });
        });
    </script>
@endsection

