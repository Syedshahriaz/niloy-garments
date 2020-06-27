@extends('layouts.admin_master')
@section('title', 'Niloy Garments::Project Settings')
@section('content')

    <style>
        .table td, .table th {
            position: relative;
        }
    </style>

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
                        <span>Project Settings</span>
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
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-share font-red-sunglo hide"></i>
                                <span class="caption-subject font-dark bold uppercase">Rename peojects & tasks </span>
                                <span class="caption-helper"></span>
                            </div>
                        </div>
                        <div class="portlet-body" style="padding-top: 0;">
                            <form id="setting_form" class="register-form" action="" method="post">
                                {{csrf_field()}}

                                <div class="alert alert-success" id="success_message" style="display:none"></div>
                                <div class="alert alert-danger" id="error_message" style="display: none"></div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive" style="max-height: 440px; overflow: auto;">
                                            <table class="table table-striped table-bordered table-hover data-table focus-table dt-responsive" id="user_dash_horizontal_task">
                                                <thead>
                                                    <tr>
                                                        <th class="editable-name">Project</th>
                                                        <th class="editable-name">Title</th>
                                                        <th class="editable-name">Cotton</th>
                                                        <th class="editable-name">Spinning</th>
                                                        <th class="editable-name">Knitting</th>
                                                        <th class="editable-name">Dying</th>
                                                        <th class="editable-name">Finising</th>
                                                        <th class="editable-name">Test</th>
                                                    </tr>
                                                </thead>

                                                <tbody>

                                                    <!-- First table -->
                                                    <tr class="focus-tr">
                                                        <td class="editable-name"> <b>Project</b>
                                                        </td>
                                                        <td class="editable-name"> <b>Rule</b>
                                                        </td>
                                                        <td class="editable-name"> <b>Cutting</b> 
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td rowspan="2" class="editable-name"> <b>A</b>
                                                        </td>
                                                        <td> <b>Due Date</b>
                                                        </td>
                                                        <td>
                                                            Wed, Jun 17, 2020
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="editable-name"> <b>Delivery Date</b>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Wed, Jun 17, 2020
                                                            </div>
                                                        </td>
                                                    </tr>


                                                    <!-- First table -->
                                                    <tr class="focus-tr">
                                                        <td class="editable-name"> <b>Project</b>
                                                        </td>
                                                        <td class="editable-name"> <b>Rule</b>
                                                        </td>
                                                        <td class="editable-name"> <b>Cutting</b> 
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td rowspan="2" class="editable-name"> <b>B</b>
                                                        </td>
                                                        <td class="editable-name"> <b>Due Date</b>
                                                        </td>
                                                        <td>
                                                            Wed, Jun 17, 2020
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="editable-name"> <b>Delivery Date</b>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Wed, Jun 17, 2020
                                                            </div>
                                                        </td>
                                                    </tr>


                                                    <!-- First table -->
                                                    <tr class="focus-tr">
                                                        <td class="editable-name"> <b>Project</b>
                                                        </td>
                                                        <td class="editable-name"> <b>Rule</b>
                                                        </td>
                                                        <td class="editable-name"> <b>Cutting</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Sweing</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Finishing</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Final Inspection</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>X Factor</b> 
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td rowspan="2" class="editable-name"> <b>C</b>
                                                        </td>
                                                        <td class="editable-name"> <b>Due Date</b>
                                                        </td>
                                                        <td>
                                                            Fri, Jul 31, 2020
                                                        </td>
                                                        <td>
                                                            Mon, Aug 31, 2020
                                                        </td>
                                                        <td>
                                                            Thu, Oct 01, 2020
                                                        </td>
                                                        <td>
                                                            Sat, Dec 18, 2021
                                                        </td>
                                                        <td>
                                                            Tue, Jun 17, 2025
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="editable-name"> <b>Delivery Date</b>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Fri, Jul 31, 2020
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Mon, Aug 31, 2020
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Thu, Oct 01, 2020
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Sat, Dec 18, 2021
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Tue, Jun 17, 2025
                                                            </div>
                                                        </td>
                                                    </tr>


                                                    <!-- First table -->
                                                    <tr class="focus-tr">
                                                        <td  class="editable-name"> <b>Project</b>
                                                        </td>
                                                        <td  class="editable-name"> <b>Rule</b>
                                                        </td>
                                                        <td  class="editable-name"> <b>Cutting</b> 
                                                        </td>
                                                        <td  class="editable-name"> <b>Sweing</b> 
                                                        </td>
                                                        <td  class="editable-name"> <b>Finishing</b> 
                                                        </td>
                                                        <td  class="editable-name"> <b>Final Inspection</b> 
                                                        </td>
                                                        <td  class="editable-name"> <b>X Factor</b> 
                                                        </td>
                                                        <td  class="editable-name"> <b>ETA</b> 
                                                        </td>
                                                        <td  class="editable-name"> <b>ETA1</b> 
                                                        </td>
                                                        <td  class="editable-name"> <b>ETA2</b> 
                                                        </td>
                                                        <td  class="editable-name"> <b>ETA3</b> 
                                                        </td>
                                                        <td  class="editable-name"> <b>ETA4</b> 
                                                        </td>
                                                        <td  class="editable-name"> <b>ETA5</b> 
                                                        </td>
                                                        <td  class="editable-name"> <b>ETA6</b> 
                                                        </td>
                                                        <td  class="editable-name"> <b>ETA7</b> 
                                                        </td>
                                                        <td  class="editable-name"> <b>ETA8</b> 
                                                        </td>
                                                        <td  class="editable-name"> <b>ETA9</b> 
                                                        </td>
                                                        <td  class="editable-name"> <b>ETA10</b> 
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td rowspan="2" class="editable-name"> <b>D</b>
                                                        </td>
                                                        <td> <b>Due Date</b>
                                                        </td>
                                                        <td>
                                                            Fri, Jul 31, 2020
                                                        </td>
                                                        <td>
                                                            Mon, Aug 31, 2020
                                                        </td>
                                                        <td>
                                                            Thu, Oct 01, 2020
                                                        </td>
                                                        <td>
                                                            Sat, Dec 18, 2021
                                                        </td>
                                                        <td>
                                                            Tue, Jun 17, 2025
                                                        </td>
                                                        <td>
                                                            Thu, Jun 17, 2032
                                                        </td>
                                                        <td>
                                                            Wed, Jun 18, 2042
                                                        </td>
                                                        <td>
                                                            Tue, Jun 18, 2052
                                                        </td>
                                                        <td>
                                                            Mon, Jun 19, 2062
                                                        </td>
                                                        <td>
                                                            Sun, Jun 19, 2072
                                                        </td>
                                                        <td>
                                                            Sat, Jun 20, 2082
                                                        </td>
                                                        <td>
                                                            Fri, Jun 20, 2092
                                                        </td>
                                                        <td>
                                                            Thu, Jun 22, 2102
                                                        </td>
                                                        <td>
                                                            Wed, Jun 22, 2112
                                                        </td>
                                                        <td>
                                                            Tue, Jun 23, 2122
                                                        </td>
                                                        <td>
                                                            Mon, Jun 23, 2132
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="editable-name"> <b>Delivery Date</b>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Fri, Jul 31, 2020
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Mon, Aug 31, 2020
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Thu, Oct 01, 2020
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Sat, Dec 18, 2021
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Tue, Jun 17, 2025
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Thu, Jun 17, 2032
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Wed, Jun 18, 2042
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Tue, Jun 18, 2052
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Mon, Jun 19, 2062
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Sun, Jun 19, 2072
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Sat, Jun 20, 2082
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Fri, Jun 20, 2092
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Thu, Jun 22, 2102
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Wed, Jun 22, 2112
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Tue, Jun 23, 2122
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Mon, Jun 23, 2132
                                                            </div>
                                                        </td>
                                                    </tr>


                                                    <!-- First table -->
                                                    <tr class="focus-tr">
                                                        <td class="editable-name"> <b>Project</b>
                                                        </td>
                                                        <td class="editable-name"> <b>Rule</b>
                                                        </td>
                                                        <td class="editable-name"> <b>Cutting</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Sweing</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Finishing</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Final Inspection</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>X Factor</b> 
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td rowspan="2" class="editable-name"> <b>E</b>
                                                        </td>
                                                        <td> <b>Due Date</b>
                                                        </td>
                                                        <td>
                                                            Fri, Jul 31, 2020
                                                        </td>
                                                        <td>
                                                            Mon, Aug 31, 2020
                                                        </td>
                                                        <td>
                                                            Thu, Oct 01, 2020
                                                        </td>
                                                        <td>
                                                            Sat, Dec 18, 2021
                                                        </td>
                                                        <td>
                                                            Tue, Jun 17, 2025
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="editable-name"> <b>Delivery Date</b>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Fri, Jul 31, 2020
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Mon, Aug 31, 2020
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Thu, Oct 01, 2020
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Sat, Dec 18, 2021
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Tue, Jun 17, 2025
                                                            </div>
                                                        </td>
                                                    </tr>


                                                    <!-- First table -->
                                                    <tr class="focus-tr">
                                                        <td class="editable-name"> <b>Project</b>
                                                        </td>
                                                        <td class="editable-name"> <b>Rule</b>
                                                        </td>
                                                        <td class="editable-name"> <b>Cutting</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Sweing</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Finishing</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Final Inspection</b> 
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="editable-name" rowspan="2"> <b>F</b>
                                                        </td>
                                                        <td> <b>Due Date</b>
                                                        </td>
                                                        <td>
                                                            Fri, Jul 31, 2020
                                                        </td>
                                                        <td>
                                                            Mon, Aug 31, 2020
                                                        </td>
                                                        <td>
                                                            Thu, Oct 01, 2020
                                                        </td>
                                                        <td>
                                                            Sat, Dec 18, 2021
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="editable-name"> <b>Delivery Date</b>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Fri, Jul 31, 2020
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Mon, Aug 31, 2020
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Thu, Oct 01, 2020
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Sat, Dec 18, 2021
                                                            </div>
                                                        </td>
                                                    </tr>


                                                    <!-- First table -->
                                                    <tr class="focus-tr">
                                                        <td class="editable-name"> <b>Project</b>
                                                        </td>
                                                        <td class="editable-name"> <b>Rule</b>
                                                        </td>
                                                        <td class="editable-name"> <b>Cutting</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Sweing</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Finishing</b> 
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="editable-name" rowspan="2"> <b>G</b>
                                                        </td>
                                                        <td> <b>Due Date</b>
                                                        </td>
                                                        <td>
                                                            Fri, Jul 31, 2020
                                                        </td>
                                                        <td>
                                                            Mon, Aug 31, 2020
                                                        </td>
                                                        <td>
                                                            Thu, Oct 01, 2020
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="editable-name"> <b>Delivery Date</b>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Fri, Jul 31, 2020
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Mon, Aug 31, 2020
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Thu, Oct 01, 2020
                                                            </div>
                                                        </td>
                                                    </tr>


                                                    <!-- First table -->
                                                    <tr class="focus-tr">
                                                        <td class="editable-name"> <b>Project</b>
                                                        </td>
                                                        <td class="editable-name"> <b>Rule</b>
                                                        </td>
                                                        <td class="editable-name"> <b>Cutting</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Sweing</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Finishing</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Final Inspection</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>X Factor</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA</b> 
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="editable-name" rowspan="2"> <b>H</b>
                                                        </td>
                                                        <td> <b>Due Date</b>
                                                        </td>
                                                        <td>
                                                            Fri, Jul 31, 2020
                                                        </td>
                                                        <td>
                                                            Mon, Aug 31, 2020
                                                        </td>
                                                        <td>
                                                            Thu, Oct 01, 2020
                                                        </td>
                                                        <td>
                                                            Thu, Jun 17, 2021
                                                        </td>
                                                        <td>
                                                            Thu, Jun 16, 2039
                                                        </td>
                                                        <td>
                                                            Fri, Jun 15, 2085
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="editable-name"> <b>Delivery Date</b>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Fri, Jul 31, 2020
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Mon, Aug 31, 2020
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Thu, Oct 01, 2020
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Thu, Jun 17, 2021
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Thu, Jun 16, 2039
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Fri, Jun 15, 2085
                                                            </div>
                                                        </td>
                                                    </tr>


                                                    <!-- First table -->
                                                    <tr class="focus-tr">
                                                        <td class="editable-name"> <b>Project</b>
                                                        </td>
                                                        <td class="editable-name"> <b>Rule</b>
                                                        </td>
                                                        <td class="editable-name"> <b>Cutting</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Sweing</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Finishing</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA1</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA2</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA3</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA4</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA5</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA6</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA7</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA8</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA9</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA10</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA11</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA12</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA13</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA14</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA15</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA16</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA17</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA18</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA19</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA20</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA21</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA22</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA23</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA24</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA25</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA26</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA27</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA28</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA29</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA30</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA31</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA32</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA33</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA34</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA35</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA36</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA37</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA38</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA39</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA40</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA41</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA42</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA43</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA44</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA45</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA46</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA47</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA48</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA49</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA50</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA51</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA52</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA53</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA54</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA55</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA56</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA57</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA58</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA59</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA60</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA61</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA62</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA63</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA64</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA65</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA66</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA67</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA68</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA69</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA70</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA71</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA72</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA73</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA74</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA75</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA76</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA77</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA78</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA79</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA80</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA81</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA82</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA83</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA84</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA85</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA86</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA87</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA88</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA89</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA90</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA91</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA92</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA93</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA94</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA95</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA96</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA97</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA98</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA99</b> 
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="editable-name" rowspan="2"> <b>I</b>
                                                        </td>
                                                        <td class="editable-name"> <b>Due Date</b>
                                                        </td>
                                                        <td>
                                                            Fri, Dec 18, 2020
                                                        </td>
                                                        <td>
                                                            Mon, Feb 15, 2021
                                                        </td>
                                                        <td>
                                                            Tue, Feb 15, 2022
                                                        </td>
                                                        <td>
                                                            Thu, Feb 16, 2023
                                                        </td>
                                                        <td>
                                                            Sat, Feb 17, 2024
                                                        </td>
                                                        <td>
                                                            Mon, Feb 17, 2025
                                                        </td>
                                                        <td>
                                                            Wed, Feb 18, 2026
                                                        </td>
                                                        <td>
                                                            Fri, Feb 19, 2027
                                                        </td>
                                                        <td>
                                                            Sun, Feb 20, 2028
                                                        </td>
                                                        <td>
                                                            Tue, Feb 20, 2029
                                                        </td>
                                                        <td>
                                                            Thu, Feb 21, 2030
                                                        </td>
                                                        <td>
                                                            Sat, Feb 22, 2031
                                                        </td>
                                                        <td>
                                                            Mon, Feb 23, 2032
                                                        </td>
                                                        <td>
                                                            Wed, Feb 23, 2033
                                                        </td>
                                                        <td>
                                                            Fri, Feb 24, 2034
                                                        </td>
                                                        <td>
                                                            Sun, Feb 25, 2035
                                                        </td>
                                                        <td>
                                                            Tue, Feb 26, 2036
                                                        </td>
                                                        <td>
                                                            Thu, Feb 26, 2037
                                                        </td>
                                                        <td>
                                                            Sat, Feb 27, 2038
                                                        </td>
                                                        <td>
                                                            Mon, Feb 28, 2039
                                                        </td>
                                                        <td>
                                                            Wed, Feb 29, 2040
                                                        </td>
                                                        <td>
                                                            Fri, Mar 01, 2041
                                                        </td>
                                                        <td>
                                                            Sun, Mar 02, 2042
                                                        </td>
                                                        <td>
                                                            Tue, Mar 03, 2043
                                                        </td>
                                                        <td>
                                                            Thu, Mar 03, 2044
                                                        </td>
                                                        <td>
                                                            Sat, Mar 04, 2045
                                                        </td>
                                                        <td>
                                                            Mon, Mar 05, 2046
                                                        </td>
                                                        <td>
                                                            Wed, Mar 06, 2047
                                                        </td>
                                                        <td>
                                                            Fri, Mar 06, 2048
                                                        </td>
                                                        <td>
                                                            Sun, Mar 07, 2049
                                                        </td>
                                                        <td>
                                                            Tue, Mar 08, 2050
                                                        </td>
                                                        <td>
                                                            Thu, Mar 09, 2051
                                                        </td>
                                                        <td>
                                                            Sat, Mar 09, 2052
                                                        </td>
                                                        <td>
                                                            Mon, Mar 10, 2053
                                                        </td>
                                                        <td>
                                                            Wed, Mar 11, 2054
                                                        </td>
                                                        <td>
                                                            Fri, Mar 12, 2055
                                                        </td>
                                                        <td>
                                                            Sun, Mar 12, 2056
                                                        </td>
                                                        <td>
                                                            Tue, Mar 13, 2057
                                                        </td>
                                                        <td>
                                                            Thu, Mar 14, 2058
                                                        </td>
                                                        <td>
                                                            Sat, Mar 15, 2059
                                                        </td>
                                                        <td>
                                                            Mon, Mar 15, 2060
                                                        </td>
                                                        <td>
                                                            Wed, Mar 16, 2061
                                                        </td>
                                                        <td>
                                                            Fri, Mar 17, 2062
                                                        </td>
                                                        <td>
                                                            Sun, Mar 18, 2063
                                                        </td>
                                                        <td>
                                                            Tue, Mar 18, 2064
                                                        </td>
                                                        <td>
                                                            Thu, Mar 19, 2065
                                                        </td>
                                                        <td>
                                                            Sat, Mar 20, 2066
                                                        </td>
                                                        <td>
                                                            Mon, Mar 21, 2067
                                                        </td>
                                                        <td>
                                                            Wed, Mar 21, 2068
                                                        </td>
                                                        <td>
                                                            Fri, Mar 22, 2069
                                                        </td>
                                                        <td>
                                                            Sun, Mar 23, 2070
                                                        </td>
                                                        <td>
                                                            Tue, Mar 24, 2071
                                                        </td>
                                                        <td>
                                                            Thu, Mar 24, 2072
                                                        </td>
                                                        <td>
                                                            Sat, Mar 25, 2073
                                                        </td>
                                                        <td>
                                                            Mon, Mar 26, 2074
                                                        </td>
                                                        <td>
                                                            Wed, Mar 27, 2075
                                                        </td>
                                                        <td>
                                                            Fri, Mar 27, 2076
                                                        </td>
                                                        <td>
                                                            Sun, Mar 28, 2077
                                                        </td>
                                                        <td>
                                                            Tue, Mar 29, 2078
                                                        </td>
                                                        <td>
                                                            Thu, Mar 30, 2079
                                                        </td>
                                                        <td>
                                                            Sat, Mar 30, 2080
                                                        </td>
                                                        <td>
                                                            Mon, Mar 31, 2081
                                                        </td>
                                                        <td>
                                                            Wed, Apr 01, 2082
                                                        </td>
                                                        <td>
                                                            Fri, Apr 02, 2083
                                                        </td>
                                                        <td>
                                                            Sun, Apr 02, 2084
                                                        </td>
                                                        <td>
                                                            Tue, Apr 03, 2085
                                                        </td>
                                                        <td>
                                                            Thu, Apr 04, 2086
                                                        </td>
                                                        <td>
                                                            Sat, Apr 05, 2087
                                                        </td>
                                                        <td>
                                                            Mon, Apr 05, 2088
                                                        </td>
                                                        <td>
                                                            Wed, Apr 06, 2089
                                                        </td>
                                                        <td>
                                                            Fri, Apr 07, 2090
                                                        </td>
                                                        <td>
                                                            Sun, Apr 08, 2091
                                                        </td>
                                                        <td>
                                                            Tue, Apr 08, 2092
                                                        </td>
                                                        <td>
                                                            Thu, Apr 09, 2093
                                                        </td>
                                                        <td>
                                                            Sat, Apr 10, 2094
                                                        </td>
                                                        <td>
                                                            Mon, Apr 11, 2095
                                                        </td>
                                                        <td>
                                                            Wed, Apr 11, 2096
                                                        </td>
                                                        <td>
                                                            Fri, Apr 12, 2097
                                                        </td>
                                                        <td>
                                                            Sun, Apr 13, 2098
                                                        </td>
                                                        <td>
                                                            Tue, Apr 14, 2099
                                                        </td>
                                                        <td>
                                                            Thu, Apr 15, 2100
                                                        </td>
                                                        <td>
                                                            Sat, Apr 16, 2101
                                                        </td>
                                                        <td>
                                                            Mon, Apr 17, 2102
                                                        </td>
                                                        <td>
                                                            Wed, Apr 18, 2103
                                                        </td>
                                                        <td>
                                                            Fri, Apr 18, 2104
                                                        </td>
                                                        <td>
                                                            Sun, Apr 19, 2105
                                                        </td>
                                                        <td>
                                                            Tue, Apr 20, 2106
                                                        </td>
                                                        <td>
                                                            Thu, Apr 21, 2107
                                                        </td>
                                                        <td>
                                                            Sat, Apr 21, 2108
                                                        </td>
                                                        <td>
                                                            Mon, Apr 22, 2109
                                                        </td>
                                                        <td>
                                                            Wed, Apr 23, 2110
                                                        </td>
                                                        <td>
                                                            Fri, Apr 24, 2111
                                                        </td>
                                                        <td>
                                                            Sun, Apr 24, 2112
                                                        </td>
                                                        <td>
                                                            Tue, Apr 25, 2113
                                                        </td>
                                                        <td>
                                                            Thu, Apr 26, 2114
                                                        </td>
                                                        <td>
                                                            Sat, Apr 27, 2115
                                                        </td>
                                                        <td>
                                                            Mon, Apr 27, 2116
                                                        </td>
                                                        <td>
                                                            Wed, Apr 28, 2117
                                                        </td>
                                                        <td>
                                                            Fri, Apr 29, 2118
                                                        </td>
                                                        <td>
                                                            Sun, Apr 30, 2119
                                                        </td>
                                                        <td>
                                                            Tue, Apr 30, 2120
                                                        </td>
                                                        <td>
                                                            Thu, May 01, 2121
                                                        </td>
                                                        <td>
                                                            Sat, May 02, 2122
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="editable-name"> <b>Delivery Date</b>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Fri, Dec 18, 2020
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Mon, Feb 15, 2021
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Tue, Feb 15, 2022
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Thu, Feb 16, 2023
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Sat, Feb 17, 2024
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Mon, Feb 17, 2025
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Wed, Feb 18, 2026
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Fri, Feb 19, 2027
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Sun, Feb 20, 2028
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Tue, Feb 20, 2029
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Thu, Feb 21, 2030
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Sat, Feb 22, 2031
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Mon, Feb 23, 2032
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Wed, Feb 23, 2033
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Fri, Feb 24, 2034
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Sun, Feb 25, 2035
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Tue, Feb 26, 2036
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Thu, Feb 26, 2037
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Sat, Feb 27, 2038
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Mon, Feb 28, 2039
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Wed, Feb 29, 2040
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Fri, Mar 01, 2041
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Sun, Mar 02, 2042
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Tue, Mar 03, 2043
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Thu, Mar 03, 2044
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Sat, Mar 04, 2045
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Mon, Mar 05, 2046
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Wed, Mar 06, 2047
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Fri, Mar 06, 2048
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Sun, Mar 07, 2049
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Tue, Mar 08, 2050
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Thu, Mar 09, 2051
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Sat, Mar 09, 2052
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Mon, Mar 10, 2053
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Wed, Mar 11, 2054
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Fri, Mar 12, 2055
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Sun, Mar 12, 2056
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Tue, Mar 13, 2057
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Thu, Mar 14, 2058
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Sat, Mar 15, 2059
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Mon, Mar 15, 2060
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Wed, Mar 16, 2061
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Fri, Mar 17, 2062
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Sun, Mar 18, 2063
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Tue, Mar 18, 2064
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Thu, Mar 19, 2065
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Sat, Mar 20, 2066
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Mon, Mar 21, 2067
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Wed, Mar 21, 2068
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Fri, Mar 22, 2069
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Sun, Mar 23, 2070
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Tue, Mar 24, 2071
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Thu, Mar 24, 2072
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Sat, Mar 25, 2073
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Mon, Mar 26, 2074
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Wed, Mar 27, 2075
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Fri, Mar 27, 2076
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Sun, Mar 28, 2077
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Tue, Mar 29, 2078
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Thu, Mar 30, 2079
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Sat, Mar 30, 2080
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Mon, Mar 31, 2081
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Wed, Apr 01, 2082
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Fri, Apr 02, 2083
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Sun, Apr 02, 2084
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Tue, Apr 03, 2085
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Thu, Apr 04, 2086
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Sat, Apr 05, 2087
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Mon, Apr 05, 2088
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Wed, Apr 06, 2089
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Fri, Apr 07, 2090
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Sun, Apr 08, 2091
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Tue, Apr 08, 2092
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Thu, Apr 09, 2093
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Sat, Apr 10, 2094
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Mon, Apr 11, 2095
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Wed, Apr 11, 2096
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Fri, Apr 12, 2097
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Sun, Apr 13, 2098
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Tue, Apr 14, 2099
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Thu, Apr 15, 2100
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Sat, Apr 16, 2101
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Mon, Apr 17, 2102
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Wed, Apr 18, 2103
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Fri, Apr 18, 2104
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Sun, Apr 19, 2105
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Tue, Apr 20, 2106
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Thu, Apr 21, 2107
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Sat, Apr 21, 2108
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Mon, Apr 22, 2109
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Wed, Apr 23, 2110
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Fri, Apr 24, 2111
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Sun, Apr 24, 2112
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Tue, Apr 25, 2113
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Thu, Apr 26, 2114
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Sat, Apr 27, 2115
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Mon, Apr 27, 2116
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Wed, Apr 28, 2117
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Fri, Apr 29, 2118
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Sun, Apr 30, 2119
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Tue, Apr 30, 2120
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Thu, May 01, 2121
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Sat, May 02, 2122
                                                            </div>
                                                        </td>
                                                    </tr>


                                                    <!-- First table -->
                                                    <tr class="focus-tr">
                                                        <td class="editable-name"> <b>Project</b>
                                                        </td>
                                                        <td class="editable-name"> <b>Rule</b>
                                                        </td>
                                                        <td class="editable-name"> <b>Cutting</b> 
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="editable-name" rowspan="2"> <b>J</b>
                                                        </td>
                                                        <td> <b>Due Date</b>
                                                        </td>
                                                        <td>
                                                            Thu, Mar 18, 2021
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="editable-name"> <b>Delivery Date</b>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Thu, Mar 18, 2021
                                                            </div>
                                                        </td>
                                                    </tr>


                                                    <!-- First table -->
                                                    <tr class="focus-tr">
                                                        <td class="editable-name"> <b>Project</b>
                                                        </td>
                                                        <td class="editable-name"> <b>Rule</b>
                                                        </td>
                                                        <td class="editable-name"> <b>Cutting</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Sweing</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA1</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA2</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA3</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA4</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA5</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA6</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA7</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA8</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA9</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA10</b> 
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="editable-name"rowspan="2"> <b>K</b>
                                                        </td>
                                                        <td> <b>Due Date</b>
                                                        </td>
                                                        <td>
                                                            Thu, Mar 18, 2021
                                                        </td>
                                                        <td>
                                                            Wed, Mar 19, 2031
                                                        </td>
                                                        <td>
                                                            Tue, Mar 19, 2041
                                                        </td>
                                                        <td>
                                                            Mon, Mar 20, 2051
                                                        </td>
                                                        <td>
                                                            Sun, Mar 20, 2061
                                                        </td>
                                                        <td>
                                                            Sat, Mar 21, 2071
                                                        </td>
                                                        <td>
                                                            Fri, Mar 21, 2081
                                                        </td>
                                                        <td>
                                                            Thu, Mar 22, 2091
                                                        </td>
                                                        <td>
                                                            Wed, Mar 23, 2101
                                                        </td>
                                                        <td>
                                                            Tue, Mar 24, 2111
                                                        </td>
                                                        <td>
                                                            Mon, Mar 24, 2121
                                                        </td>
                                                        <td>
                                                            Sun, Mar 25, 2131
                                                        </td>
                                                        <td>
                                                            Sat, Mar 25, 2141
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="editable-name"> <b>Delivery Date</b>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Thu, Mar 18, 2021
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Wed, Mar 19, 2031
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Tue, Mar 19, 2041
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Mon, Mar 20, 2051
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Sun, Mar 20, 2061
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Sat, Mar 21, 2071
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Fri, Mar 21, 2081
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Thu, Mar 22, 2091
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Wed, Mar 23, 2101
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Tue, Mar 24, 2111
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Mon, Mar 24, 2121
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Sun, Mar 25, 2131
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Sat, Mar 25, 2141
                                                            </div>
                                                        </td>
                                                    </tr>


                                                    <!-- First table -->
                                                    <tr class="focus-tr">
                                                        <td class="editable-name"> <b>Project</b>
                                                        </td>
                                                        <td class="editable-name"> <b>Rule</b>
                                                        </td>
                                                        <td class="editable-name"> <b>Cutting</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Sweing</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Finishing</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Final Inspection</b> 
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="editable-name" rowspan="2"> <b>L</b>
                                                        </td>
                                                        <td> <b>Due Date</b>
                                                        </td>
                                                        <td>
                                                            Thu, Mar 18, 2021
                                                        </td>
                                                        <td>
                                                            Thu, Jun 17, 2021
                                                        </td>
                                                        <td>
                                                            Wed, Jun 18, 2031
                                                        </td>
                                                        <td>
                                                            Tue, Jun 17, 2036
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="editable-name"> <b>Delivery Date</b>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Thu, Mar 18, 2021
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Thu, Jun 17, 2021
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Wed, Jun 18, 2031
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Tue, Jun 17, 2036
                                                            </div>
                                                        </td>
                                                    </tr>


                                                    <!-- First table -->
                                                    <tr class="focus-tr">
                                                        <td class="editable-name"> <b>Project</b>
                                                        </td>
                                                        <td class="editable-name"> <b>Rule</b>
                                                        </td>
                                                        <td class="editable-name"> <b>Cutting</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Sweing</b> 
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="editable-name" rowspan="2"> <b>M</b>
                                                        </td>
                                                        <td class="editable-name"> <b>Due Date</b>
                                                        </td>
                                                        <td>
                                                            Thu, Jun 17, 2021
                                                        </td>
                                                        <td>
                                                            Sat, Dec 18, 2021
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="editable-name"> <b>Delivery Date</b>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Thu, Jun 17, 2021
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Sat, Dec 18, 2021
                                                            </div>
                                                        </td>
                                                    </tr>


                                                    <!-- First table -->
                                                    <tr class="focus-tr">
                                                        <td class="editable-name"> <b>Project</b>
                                                        </td>
                                                        <td class="editable-name"> <b>Rule</b>
                                                        </td>
                                                        <td class="editable-name"> <b>Cutting</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Sweing</b> 
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td rowspan="2" class="editable-name"> <b>N</b>
                                                        </td>
                                                        <td class="editable-name"> <b>Due Date</b>
                                                        </td>
                                                        <td>
                                                            Thu, Jun 17, 2021
                                                        </td>
                                                        <td>
                                                            Wed, Jun 17, 2026
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="editable-name"> <b>Delivery Date</b>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Thu, Jun 17, 2021
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Wed, Jun 17, 2026
                                                            </div>
                                                        </td>
                                                    </tr>


                                                    <!-- First table -->
                                                    <tr class="focus-tr">
                                                        <td class="editable-name"> <b>Project</b>
                                                        </td>
                                                        <td class="editable-name"> <b>Rule</b>
                                                        </td>
                                                        <td class="editable-name"> <b>Cutting</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Sweing</b> 
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="editable-name" rowspan="2"> <b>O</b>
                                                        </td>
                                                        <td class="editable-name"> <b>Due Date</b>
                                                        </td>
                                                        <td>
                                                            Fri, Sep 17, 2021
                                                        </td>
                                                        <td>
                                                            Tue, Jun 17, 2025
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="editable-name"> <b>Delivery Date</b>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Fri, Sep 17, 2021
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Tue, Jun 17, 2025
                                                            </div>
                                                        </td>
                                                    </tr>


                                                    <!-- First table -->
                                                    <tr class="focus-tr">
                                                        <td class="editable-name"> <b>Project</b>
                                                        </td>
                                                        <td class="editable-name"> <b>Rule</b>
                                                        </td>
                                                        <td class="editable-name"> <b>Cutting</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Sweing</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA1</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA2</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA3</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA4</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA5</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA6</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA7</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA8</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA9</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA10</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA11</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA12</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA13</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA14</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA15</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA16</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA17</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA18</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA19</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA20</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA21</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA22</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA23</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA24</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA25</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA26</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA27</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA28</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA29</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA30</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA31</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA32</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA33</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>ETA34</b> 
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="editable-name" rowspan="2"> <b>P</b>
                                                        </td>
                                                        <td class="editable-name"> <b>Due Date</b>
                                                        </td>
                                                        <td>
                                                            Fri, Jun 17, 2022
                                                        </td>
                                                        <td>
                                                            Tue, Jun 17, 2025
                                                        </td>
                                                        <td>
                                                            Sat, Jun 17, 2028
                                                        </td>
                                                        <td>
                                                            Wed, Jun 18, 2031
                                                        </td>
                                                        <td>
                                                            Sun, Jun 18, 2034
                                                        </td>
                                                        <td>
                                                            Thu, Jun 18, 2037
                                                        </td>
                                                        <td>
                                                            Mon, Jun 18, 2040
                                                        </td>
                                                        <td>
                                                            Fri, Jun 19, 2043
                                                        </td>
                                                        <td>
                                                            Tue, Jun 19, 2046
                                                        </td>
                                                        <td>
                                                            Sat, Jun 19, 2049
                                                        </td>
                                                        <td>
                                                            Wed, Jun 19, 2052
                                                        </td>
                                                        <td>
                                                            Sun, Jun 20, 2055
                                                        </td>
                                                        <td>
                                                            Thu, Jun 20, 2058
                                                        </td>
                                                        <td>
                                                            Mon, Jun 20, 2061
                                                        </td>
                                                        <td>
                                                            Fri, Jun 20, 2064
                                                        </td>
                                                        <td>
                                                            Tue, Jun 21, 2067
                                                        </td>
                                                        <td>
                                                            Sat, Jun 21, 2070
                                                        </td>
                                                        <td>
                                                            Wed, Jun 21, 2073
                                                        </td>
                                                        <td>
                                                            Sun, Jun 21, 2076
                                                        </td>
                                                        <td>
                                                            Thu, Jun 22, 2079
                                                        </td>
                                                        <td>
                                                            Mon, Jun 22, 2082
                                                        </td>
                                                        <td>
                                                            Fri, Jun 22, 2085
                                                        </td>
                                                        <td>
                                                            Tue, Jun 22, 2088
                                                        </td>
                                                        <td>
                                                            Sat, Jun 23, 2091
                                                        </td>
                                                        <td>
                                                            Wed, Jun 23, 2094
                                                        </td>
                                                        <td>
                                                            Sun, Jun 23, 2097
                                                        </td>
                                                        <td>
                                                            Thu, Jun 24, 2100
                                                        </td>
                                                        <td>
                                                            Mon, Jun 25, 2103
                                                        </td>
                                                        <td>
                                                            Fri, Jun 25, 2106
                                                        </td>
                                                        <td>
                                                            Tue, Jun 25, 2109
                                                        </td>
                                                        <td>
                                                            Sat, Jun 25, 2112
                                                        </td>
                                                        <td>
                                                            Wed, Jun 26, 2115
                                                        </td>
                                                        <td>
                                                            Sun, Jun 26, 2118
                                                        </td>
                                                        <td>
                                                            Thu, Jun 26, 2121
                                                        </td>
                                                        <td>
                                                            Mon, Jun 26, 2124
                                                        </td>
                                                        <td>
                                                            Fri, Jun 27, 2127
                                                        </td>
                                                        <td>
                                                            Tue, Jun 27, 2130
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="editable-name"> <b>Delivery Date</b>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Fri, Jun 17, 2022
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Tue, Jun 17, 2025
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Sat, Jun 17, 2028
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Wed, Jun 18, 2031
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Sun, Jun 18, 2034
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Thu, Jun 18, 2037
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Mon, Jun 18, 2040
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Fri, Jun 19, 2043
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Tue, Jun 19, 2046
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Sat, Jun 19, 2049
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Wed, Jun 19, 2052
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Sun, Jun 20, 2055
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Thu, Jun 20, 2058
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Mon, Jun 20, 2061
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Fri, Jun 20, 2064
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Tue, Jun 21, 2067
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Sat, Jun 21, 2070
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Wed, Jun 21, 2073
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Sun, Jun 21, 2076
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Thu, Jun 22, 2079
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Mon, Jun 22, 2082
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Fri, Jun 22, 2085
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Tue, Jun 22, 2088
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Sat, Jun 23, 2091
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Wed, Jun 23, 2094
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Sun, Jun 23, 2097
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Thu, Jun 24, 2100
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Mon, Jun 25, 2103
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Fri, Jun 25, 2106
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Tue, Jun 25, 2109
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Sat, Jun 25, 2112
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Wed, Jun 26, 2115
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Sun, Jun 26, 2118
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Thu, Jun 26, 2121
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Mon, Jun 26, 2124
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Fri, Jun 27, 2127
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Tue, Jun 27, 2130
                                                            </div>
                                                        </td>
                                                    </tr>


                                                    <!-- First table -->
                                                    <tr class="focus-tr">
                                                        <td class="editable-name"> <b>Project</b>
                                                        </td>
                                                        <td class="editable-name"> <b>Rule</b>
                                                        </td>
                                                        <td class="editable-name"> <b>Cutting</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Sweing</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Finishing</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Final Inspection</b> 
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td rowspan="2"> <b>Q</b>
                                                        </td>
                                                        <td class="editable-name"> <b>Due Date</b>
                                                        </td>
                                                        <td>
                                                            Fri, Jun 17, 2022
                                                        </td>
                                                        <td>
                                                            Mon, Jul 18, 2022
                                                        </td>
                                                        <td>
                                                            Thu, Aug 18, 2022
                                                        </td>
                                                        <td>
                                                            Thu, Feb 16, 2023
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="editable-name"> <b>Delivery Date</b>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Fri, Jun 17, 2022
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Mon, Jul 18, 2022
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Thu, Aug 18, 2022
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Thu, Feb 16, 2023
                                                            </div>
                                                        </td>
                                                    </tr>


                                                    <!-- First table -->
                                                    <tr class="focus-tr">
                                                        <td class="editable-name"> <b>Project</b>
                                                        </td>
                                                        <td class="editable-name"> <b>Rule</b>
                                                        </td>
                                                        <td class="editable-name"> <b>Cutting</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Sweing</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Finishing</b> 
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="editable-name" rowspan="2"> <b>R</b>
                                                        </td>
                                                        <td class="editable-name"> <b>Due Date</b>
                                                        </td>
                                                        <td>
                                                            Mon, Jun 17, 2030
                                                        </td>
                                                        <td>
                                                            Thu, Jul 18, 2030
                                                        </td>
                                                        <td>
                                                            Wed, Dec 18, 2030
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="editable-name"> <b>Delivery Date</b>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Mon, Jun 17, 2030
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Thu, Jul 18, 2030
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Wed, Dec 18, 2030
                                                            </div>
                                                        </td>
                                                    </tr>


                                                    <!-- First table -->
                                                    <tr class="focus-tr">
                                                        <td class="editable-name"> <b>Project</b>
                                                        </td>
                                                        <td class="editable-name"> <b>Rule</b>
                                                        </td>
                                                        <td class="editable-name"> <b>Cutting</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 01</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 02</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 03</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 04</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 05</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 06</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 07</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 08</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 09</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 10</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 11</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 12</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 13</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 14</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 15</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 16</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 17</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 18</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 19</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 20</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 21</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 22</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 23</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 24</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 25</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 26</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 27</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 28</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 29</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 30</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 31</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 32</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 33</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 34</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 35</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 36</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 37</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 38</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 39</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 40</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 41</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 42</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 43</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 44</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 45</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 46</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 47</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 48</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 49</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 50</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 51</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 52</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 53</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 54</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 55</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 56</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 57</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 58</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 59</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 60</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 61</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 62</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 63</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 64</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 65</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 66</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 67</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 68</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 69</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 70</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 71</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 72</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 73</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 74</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 75</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 76</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 77</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 78</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 79</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 80</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 81</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 82</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 83</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 84</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 85</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 86</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 87</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 88</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 89</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 90</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 91</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 92</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 93</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 94</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 95</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 96</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 97</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 98</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 99</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 100</b> 
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="editable-name" rowspan="2"> <b>S</b>
                                                        </td>
                                                        <td class="editable-name"> <b>Due Date</b>
                                                        </td>
                                                        <td>
                                                            Mon, Jul 13, 2020
                                                        </td>
                                                        <td>
                                                            Wed, Jul 14, 2021
                                                        </td>
                                                        <td>
                                                            Fri, Jul 15, 2022
                                                        </td>
                                                        <td>
                                                            Sun, Jul 16, 2023
                                                        </td>
                                                        <td>
                                                            Tue, Jul 16, 2024
                                                        </td>
                                                        <td>
                                                            Thu, Jul 17, 2025
                                                        </td>
                                                        <td>
                                                            Sat, Jul 18, 2026
                                                        </td>
                                                        <td>
                                                            Mon, Jul 19, 2027
                                                        </td>
                                                        <td>
                                                            Wed, Jul 19, 2028
                                                        </td>
                                                        <td>
                                                            Fri, Jul 20, 2029
                                                        </td>
                                                        <td>
                                                            Sun, Jul 21, 2030
                                                        </td>
                                                        <td>
                                                            Tue, Jul 22, 2031
                                                        </td>
                                                        <td>
                                                            Thu, Jul 22, 2032
                                                        </td>
                                                        <td>
                                                            Sat, Jul 23, 2033
                                                        </td>
                                                        <td>
                                                            Mon, Jul 24, 2034
                                                        </td>
                                                        <td>
                                                            Wed, Jul 25, 2035
                                                        </td>
                                                        <td>
                                                            Fri, Jul 25, 2036
                                                        </td>
                                                        <td>
                                                            Sun, Jul 26, 2037
                                                        </td>
                                                        <td>
                                                            Tue, Jul 27, 2038
                                                        </td>
                                                        <td>
                                                            Thu, Jul 28, 2039
                                                        </td>
                                                        <td>
                                                            Sat, Jul 28, 2040
                                                        </td>
                                                        <td>
                                                            Mon, Jul 29, 2041
                                                        </td>
                                                        <td>
                                                            Wed, Jul 30, 2042
                                                        </td>
                                                        <td>
                                                            Fri, Jul 31, 2043
                                                        </td>
                                                        <td>
                                                            Sun, Jul 31, 2044
                                                        </td>
                                                        <td>
                                                            Tue, Aug 01, 2045
                                                        </td>
                                                        <td>
                                                            Thu, Aug 02, 2046
                                                        </td>
                                                        <td>
                                                            Sat, Aug 03, 2047
                                                        </td>
                                                        <td>
                                                            Mon, Aug 03, 2048
                                                        </td>
                                                        <td>
                                                            Wed, Aug 04, 2049
                                                        </td>
                                                        <td>
                                                            Fri, Aug 05, 2050
                                                        </td>
                                                        <td>
                                                            Sun, Aug 06, 2051
                                                        </td>
                                                        <td>
                                                            Tue, Aug 06, 2052
                                                        </td>
                                                        <td>
                                                            Thu, Aug 07, 2053
                                                        </td>
                                                        <td>
                                                            Sat, Aug 08, 2054
                                                        </td>
                                                        <td>
                                                            Mon, Aug 09, 2055
                                                        </td>
                                                        <td>
                                                            Wed, Aug 09, 2056
                                                        </td>
                                                        <td>
                                                            Fri, Aug 10, 2057
                                                        </td>
                                                        <td>
                                                            Sun, Aug 11, 2058
                                                        </td>
                                                        <td>
                                                            Tue, Aug 12, 2059
                                                        </td>
                                                        <td>
                                                            Thu, Aug 12, 2060
                                                        </td>
                                                        <td>
                                                            Sat, Aug 13, 2061
                                                        </td>
                                                        <td>
                                                            Mon, Aug 14, 2062
                                                        </td>
                                                        <td>
                                                            Wed, Aug 15, 2063
                                                        </td>
                                                        <td>
                                                            Fri, Aug 15, 2064
                                                        </td>
                                                        <td>
                                                            Sun, Aug 16, 2065
                                                        </td>
                                                        <td>
                                                            Tue, Aug 17, 2066
                                                        </td>
                                                        <td>
                                                            Thu, Aug 18, 2067
                                                        </td>
                                                        <td>
                                                            Sat, Aug 18, 2068
                                                        </td>
                                                        <td>
                                                            Mon, Aug 19, 2069
                                                        </td>
                                                        <td>
                                                            Wed, Aug 20, 2070
                                                        </td>
                                                        <td>
                                                            Fri, Aug 21, 2071
                                                        </td>
                                                        <td>
                                                            Sun, Aug 21, 2072
                                                        </td>
                                                        <td>
                                                            Tue, Aug 22, 2073
                                                        </td>
                                                        <td>
                                                            Thu, Aug 23, 2074
                                                        </td>
                                                        <td>
                                                            Sat, Aug 24, 2075
                                                        </td>
                                                        <td>
                                                            Mon, Aug 24, 2076
                                                        </td>
                                                        <td>
                                                            Wed, Aug 25, 2077
                                                        </td>
                                                        <td>
                                                            Fri, Aug 26, 2078
                                                        </td>
                                                        <td>
                                                            Sun, Aug 27, 2079
                                                        </td>
                                                        <td>
                                                            Tue, Aug 27, 2080
                                                        </td>
                                                        <td>
                                                            Thu, Aug 28, 2081
                                                        </td>
                                                        <td>
                                                            Sat, Aug 29, 2082
                                                        </td>
                                                        <td>
                                                            Mon, Aug 30, 2083
                                                        </td>
                                                        <td>
                                                            Wed, Aug 30, 2084
                                                        </td>
                                                        <td>
                                                            Fri, Aug 31, 2085
                                                        </td>
                                                        <td>
                                                            Sun, Sep 01, 2086
                                                        </td>
                                                        <td>
                                                            Tue, Sep 02, 2087
                                                        </td>
                                                        <td>
                                                            Thu, Sep 02, 2088
                                                        </td>
                                                        <td>
                                                            Sat, Sep 03, 2089
                                                        </td>
                                                        <td>
                                                            Mon, Sep 04, 2090
                                                        </td>
                                                        <td>
                                                            Wed, Sep 05, 2091
                                                        </td>
                                                        <td>
                                                            Fri, Sep 05, 2092
                                                        </td>
                                                        <td>
                                                            Sun, Sep 06, 2093
                                                        </td>
                                                        <td>
                                                            Tue, Sep 07, 2094
                                                        </td>
                                                        <td>
                                                            Thu, Sep 08, 2095
                                                        </td>
                                                        <td>
                                                            Sat, Sep 08, 2096
                                                        </td>
                                                        <td>
                                                            Mon, Sep 09, 2097
                                                        </td>
                                                        <td>
                                                            Wed, Sep 10, 2098
                                                        </td>
                                                        <td>
                                                            Fri, Sep 11, 2099
                                                        </td>
                                                        <td>
                                                            Sun, Sep 12, 2100
                                                        </td>
                                                        <td>
                                                            Tue, Sep 13, 2101
                                                        </td>
                                                        <td>
                                                            Thu, Sep 14, 2102
                                                        </td>
                                                        <td>
                                                            Sat, Sep 15, 2103
                                                        </td>
                                                        <td>
                                                            Mon, Sep 15, 2104
                                                        </td>
                                                        <td>
                                                            Wed, Sep 16, 2105
                                                        </td>
                                                        <td>
                                                            Fri, Sep 17, 2106
                                                        </td>
                                                        <td>
                                                            Sun, Sep 18, 2107
                                                        </td>
                                                        <td>
                                                            Tue, Sep 18, 2108
                                                        </td>
                                                        <td>
                                                            Thu, Sep 19, 2109
                                                        </td>
                                                        <td>
                                                            Sat, Sep 20, 2110
                                                        </td>
                                                        <td>
                                                            Mon, Sep 21, 2111
                                                        </td>
                                                        <td>
                                                            Wed, Sep 21, 2112
                                                        </td>
                                                        <td>
                                                            Fri, Sep 22, 2113
                                                        </td>
                                                        <td>
                                                            Sun, Sep 23, 2114
                                                        </td>
                                                        <td>
                                                            Tue, Sep 24, 2115
                                                        </td>
                                                        <td>
                                                            Thu, Sep 24, 2116
                                                        </td>
                                                        <td>
                                                            Sat, Sep 25, 2117
                                                        </td>
                                                        <td>
                                                            Mon, Sep 26, 2118
                                                        </td>
                                                        <td>
                                                            Wed, Sep 27, 2119
                                                        </td>
                                                        <td>
                                                            Fri, Sep 27, 2120
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="editable-name"> <b>Delivery Date</b>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Mon, Jul 13, 2020
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Wed, Jul 14, 2021
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Fri, Jul 15, 2022
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Sun, Jul 16, 2023
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Tue, Jul 16, 2024
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Thu, Jul 17, 2025
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Sat, Jul 18, 2026
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Mon, Jul 19, 2027
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Wed, Jul 19, 2028
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Fri, Jul 20, 2029
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Sun, Jul 21, 2030
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Tue, Jul 22, 2031
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Thu, Jul 22, 2032
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Sat, Jul 23, 2033
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Mon, Jul 24, 2034
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Wed, Jul 25, 2035
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Fri, Jul 25, 2036
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Sun, Jul 26, 2037
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Tue, Jul 27, 2038
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Thu, Jul 28, 2039
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Sat, Jul 28, 2040
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Mon, Jul 29, 2041
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Wed, Jul 30, 2042
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Fri, Jul 31, 2043
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Sun, Jul 31, 2044
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Tue, Aug 01, 2045
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Thu, Aug 02, 2046
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Sat, Aug 03, 2047
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Mon, Aug 03, 2048
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Wed, Aug 04, 2049
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Fri, Aug 05, 2050
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Sun, Aug 06, 2051
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Tue, Aug 06, 2052
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Thu, Aug 07, 2053
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Sat, Aug 08, 2054
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Mon, Aug 09, 2055
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Wed, Aug 09, 2056
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Fri, Aug 10, 2057
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Sun, Aug 11, 2058
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Tue, Aug 12, 2059
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Thu, Aug 12, 2060
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Sat, Aug 13, 2061
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Mon, Aug 14, 2062
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Wed, Aug 15, 2063
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Fri, Aug 15, 2064
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Sun, Aug 16, 2065
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Tue, Aug 17, 2066
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Thu, Aug 18, 2067
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Sat, Aug 18, 2068
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Mon, Aug 19, 2069
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Wed, Aug 20, 2070
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Fri, Aug 21, 2071
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Sun, Aug 21, 2072
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Tue, Aug 22, 2073
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Thu, Aug 23, 2074
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Sat, Aug 24, 2075
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Mon, Aug 24, 2076
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Wed, Aug 25, 2077
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Fri, Aug 26, 2078
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Sun, Aug 27, 2079
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Tue, Aug 27, 2080
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Thu, Aug 28, 2081
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Sat, Aug 29, 2082
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Mon, Aug 30, 2083
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Wed, Aug 30, 2084
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Fri, Aug 31, 2085
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Sun, Sep 01, 2086
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Tue, Sep 02, 2087
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Thu, Sep 02, 2088
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Sat, Sep 03, 2089
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Mon, Sep 04, 2090
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Wed, Sep 05, 2091
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Fri, Sep 05, 2092
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Sun, Sep 06, 2093
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Tue, Sep 07, 2094
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Thu, Sep 08, 2095
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Sat, Sep 08, 2096
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Mon, Sep 09, 2097
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Wed, Sep 10, 2098
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Fri, Sep 11, 2099
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Sun, Sep 12, 2100
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Tue, Sep 13, 2101
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Thu, Sep 14, 2102
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Sat, Sep 15, 2103
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Mon, Sep 15, 2104
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Wed, Sep 16, 2105
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Fri, Sep 17, 2106
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Sun, Sep 18, 2107
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Tue, Sep 18, 2108
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Thu, Sep 19, 2109
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Sat, Sep 20, 2110
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Mon, Sep 21, 2111
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Wed, Sep 21, 2112
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Fri, Sep 22, 2113
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Sun, Sep 23, 2114
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Tue, Sep 24, 2115
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Thu, Sep 24, 2116
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Sat, Sep 25, 2117
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Mon, Sep 26, 2118
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Wed, Sep 27, 2119
                                                            </div>
                                                        </td>

                                                        <td class="  ">
                                                            <div class="edit-table-date">
                                                                Fri, Sep 27, 2120
                                                            </div>
                                                        </td>
                                                    </tr>

                                                </tbody>

                                                <tbody>

                                                    <!-- First table -->
                                                    <tr class="focus-tr">
                                                        <td class="editable-name"> <b>Project</b>
                                                        </td>
                                                        <td class="editable-name"> <b>Rule</b>
                                                        </td>
                                                        <td class="editable-name"> <b>Cutting</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 01</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 02</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 03</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 04</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 05</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 06</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 07</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 08</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 09</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 10</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 11</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 12</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 13</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 14</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 15</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 16</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 17</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 18</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 19</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 20</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 21</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 22</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 23</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 24</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 25</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 26</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 27</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 28</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 29</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 30</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 31</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 32</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 33</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 34</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 35</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 36</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 37</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 38</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 39</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 40</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 41</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 42</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 43</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 44</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 45</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 46</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 47</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 48</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 49</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 50</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 51</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 52</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 53</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 54</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 55</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 56</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 57</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 58</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 59</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 60</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 61</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 62</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 63</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 64</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 65</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 66</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 67</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 68</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 69</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 70</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 71</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 72</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 73</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 74</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 75</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 76</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 77</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 78</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 79</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 80</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 81</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 82</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 83</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 84</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 85</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 86</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 87</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 88</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 89</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 90</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 91</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 92</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 93</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 94</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 95</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 96</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 97</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 98</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 99</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 100</b> 
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="editable-name" rowspan="2"> <b>S</b>
                                                        </td>
                                                        <td> <b>Due Date</b>
                                                        </td>
                                                        <td>
                                                            Mon, Jun 09, 2014
                                                        </td>
                                                        <td>
                                                            Sat, Jun 08, 2013
                                                        </td>
                                                        <td>
                                                            Thu, Jun 07, 2012
                                                        </td>
                                                        <td>
                                                            Tue, Jun 07, 2011
                                                        </td>
                                                        <td>
                                                            Sun, Jun 06, 2010
                                                        </td>
                                                        <td>
                                                            Fri, Jun 05, 2009
                                                        </td>
                                                        <td>
                                                            Wed, Jun 04, 2008
                                                        </td>
                                                        <td>
                                                            Mon, Jun 04, 2007
                                                        </td>
                                                        <td>
                                                            Sat, Jun 03, 2006
                                                        </td>
                                                        <td>
                                                            Thu, Jun 02, 2005
                                                        </td>
                                                        <td>
                                                            Tue, Jun 01, 2004
                                                        </td>
                                                        <td>
                                                            Sun, Jun 01, 2003
                                                        </td>
                                                        <td>
                                                            Fri, May 31, 2002
                                                        </td>
                                                        <td>
                                                            Wed, May 30, 2001
                                                        </td>
                                                        <td>
                                                            Mon, May 29, 2000
                                                        </td>
                                                        <td>
                                                            Sat, May 29, 1999
                                                        </td>
                                                        <td>
                                                            Thu, May 28, 1998
                                                        </td>
                                                        <td>
                                                            Tue, May 27, 1997
                                                        </td>
                                                        <td>
                                                            Sun, May 26, 1996
                                                        </td>
                                                        <td>
                                                            Fri, May 26, 1995
                                                        </td>
                                                        <td>
                                                            Wed, May 25, 1994
                                                        </td>
                                                        <td>
                                                            Mon, May 24, 1993
                                                        </td>
                                                        <td>
                                                            Sat, May 23, 1992
                                                        </td>
                                                        <td>
                                                            Thu, May 23, 1991
                                                        </td>
                                                        <td>
                                                            Tue, May 22, 1990
                                                        </td>
                                                        <td>
                                                            Sun, May 21, 1989
                                                        </td>
                                                        <td>
                                                            Fri, May 20, 1988
                                                        </td>
                                                        <td>
                                                            Wed, May 20, 1987
                                                        </td>
                                                        <td>
                                                            Mon, May 19, 1986
                                                        </td>
                                                        <td>
                                                            Sat, May 18, 1985
                                                        </td>
                                                        <td>
                                                            Thu, May 17, 1984
                                                        </td>
                                                        <td>
                                                            Tue, May 17, 1983
                                                        </td>
                                                        <td>
                                                            Sun, May 16, 1982
                                                        </td>
                                                        <td>
                                                            Fri, May 15, 1981
                                                        </td>
                                                        <td>
                                                            Wed, May 14, 1980
                                                        </td>
                                                        <td>
                                                            Mon, May 14, 1979
                                                        </td>
                                                        <td>
                                                            Sat, May 13, 1978
                                                        </td>
                                                        <td>
                                                            Thu, May 12, 1977
                                                        </td>
                                                        <td>
                                                            Tue, May 11, 1976
                                                        </td>
                                                        <td>
                                                            Sun, May 11, 1975
                                                        </td>
                                                        <td>
                                                            Fri, May 10, 1974
                                                        </td>
                                                        <td>
                                                            Wed, May 09, 1973
                                                        </td>
                                                        <td>
                                                            Mon, May 08, 1972
                                                        </td>
                                                        <td>
                                                            Sat, May 08, 1971
                                                        </td>
                                                        <td>
                                                            Thu, May 07, 1970
                                                        </td>
                                                        <td>
                                                            Tue, May 06, 1969
                                                        </td>
                                                        <td>
                                                            Sun, May 05, 1968
                                                        </td>
                                                        <td>
                                                            Fri, May 05, 1967
                                                        </td>
                                                        <td>
                                                            Wed, May 04, 1966
                                                        </td>
                                                        <td>
                                                            Mon, May 03, 1965
                                                        </td>
                                                        <td>
                                                            Sat, May 02, 1964
                                                        </td>
                                                        <td>
                                                            Thu, May 02, 1963
                                                        </td>
                                                        <td>
                                                            Tue, May 01, 1962
                                                        </td>
                                                        <td>
                                                            Sun, Apr 30, 1961
                                                        </td>
                                                        <td>
                                                            Fri, Apr 29, 1960
                                                        </td>
                                                        <td>
                                                            Wed, Apr 29, 1959
                                                        </td>
                                                        <td>
                                                            Mon, Apr 28, 1958
                                                        </td>
                                                        <td>
                                                            Sat, Apr 27, 1957
                                                        </td>
                                                        <td>
                                                            Thu, Apr 26, 1956
                                                        </td>
                                                        <td>
                                                            Tue, Apr 26, 1955
                                                        </td>
                                                        <td>
                                                            Sun, Apr 25, 1954
                                                        </td>
                                                        <td>
                                                            Fri, Apr 24, 1953
                                                        </td>
                                                        <td>
                                                            Wed, Apr 23, 1952
                                                        </td>
                                                        <td>
                                                            Mon, Apr 23, 1951
                                                        </td>
                                                        <td>
                                                            Sat, Apr 22, 1950
                                                        </td>
                                                        <td>
                                                            Thu, Apr 21, 1949
                                                        </td>
                                                        <td>
                                                            Tue, Apr 20, 1948
                                                        </td>
                                                        <td>
                                                            Sun, Apr 20, 1947
                                                        </td>
                                                        <td>
                                                            Fri, Apr 19, 1946
                                                        </td>
                                                        <td>
                                                            Wed, Apr 18, 1945
                                                        </td>
                                                        <td>
                                                            Mon, Apr 17, 1944
                                                        </td>
                                                        <td>
                                                            Sat, Apr 17, 1943
                                                        </td>
                                                        <td>
                                                            Thu, Apr 16, 1942
                                                        </td>
                                                        <td>
                                                            Tue, Apr 15, 1941
                                                        </td>
                                                        <td>
                                                            Sun, Apr 14, 1940
                                                        </td>
                                                        <td>
                                                            Fri, Apr 14, 1939
                                                        </td>
                                                        <td>
                                                            Wed, Apr 13, 1938
                                                        </td>
                                                        <td>
                                                            Mon, Apr 12, 1937
                                                        </td>
                                                        <td>
                                                            Sat, Apr 11, 1936
                                                        </td>
                                                        <td>
                                                            Thu, Apr 11, 1935
                                                        </td>
                                                        <td>
                                                            Tue, Apr 10, 1934
                                                        </td>
                                                        <td>
                                                            Sun, Apr 09, 1933
                                                        </td>
                                                        <td>
                                                            Fri, Apr 08, 1932
                                                        </td>
                                                        <td>
                                                            Wed, Apr 08, 1931
                                                        </td>
                                                        <td>
                                                            Mon, Apr 07, 1930
                                                        </td>
                                                        <td>
                                                            Sat, Apr 06, 1929
                                                        </td>
                                                        <td>
                                                            Thu, Apr 05, 1928
                                                        </td>
                                                        <td>
                                                            Tue, Apr 05, 1927
                                                        </td>
                                                        <td>
                                                            Sun, Apr 04, 1926
                                                        </td>
                                                        <td>
                                                            Fri, Apr 03, 1925
                                                        </td>
                                                        <td>
                                                            Wed, Apr 02, 1924
                                                        </td>
                                                        <td>
                                                            Mon, Apr 02, 1923
                                                        </td>
                                                        <td>
                                                            Sat, Apr 01, 1922
                                                        </td>
                                                        <td>
                                                            Thu, Mar 31, 1921
                                                        </td>
                                                        <td>
                                                            Tue, Mar 30, 1920
                                                        </td>
                                                        <td>
                                                            Sun, Mar 30, 1919
                                                        </td>
                                                        <td>
                                                            Fri, Mar 29, 1918
                                                        </td>
                                                        <td>
                                                            Wed, Mar 28, 1917
                                                        </td>
                                                        <td>
                                                            Mon, Mar 27, 1916
                                                        </td>
                                                        <td>
                                                            Sat, Mar 27, 1915
                                                        </td>
                                                        <td>
                                                            Thu, Mar 26, 1914
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td> <b>Delivery Date</b>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Mon, Jun 09, 2014
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Sat, Jun 08, 2013
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Thu, Jun 07, 2012
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Tue, Jun 07, 2011
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Sun, Jun 06, 2010
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Fri, Jun 05, 2009
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Wed, Jun 04, 2008
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Mon, Jun 04, 2007
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Sat, Jun 03, 2006
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Thu, Jun 02, 2005
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Tue, Jun 01, 2004
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Sun, Jun 01, 2003
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Fri, May 31, 2002
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Wed, May 30, 2001
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Mon, May 29, 2000
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Sat, May 29, 1999
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Thu, May 28, 1998
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Tue, May 27, 1997
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Sun, May 26, 1996
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Fri, May 26, 1995
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Wed, May 25, 1994
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Mon, May 24, 1993
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Sat, May 23, 1992
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Thu, May 23, 1991
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Tue, May 22, 1990
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Sun, May 21, 1989
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Fri, May 20, 1988
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Wed, May 20, 1987
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Mon, May 19, 1986
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Sat, May 18, 1985
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Thu, May 17, 1984
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Tue, May 17, 1983
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Sun, May 16, 1982
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Fri, May 15, 1981
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Wed, May 14, 1980
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Mon, May 14, 1979
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Sat, May 13, 1978
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Thu, May 12, 1977
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Tue, May 11, 1976
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Sun, May 11, 1975
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Fri, May 10, 1974
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Wed, May 09, 1973
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Mon, May 08, 1972
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Sat, May 08, 1971
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Thu, May 07, 1970
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Tue, May 06, 1969
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Sun, May 05, 1968
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Fri, May 05, 1967
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Wed, May 04, 1966
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Mon, May 03, 1965
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Sat, May 02, 1964
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Thu, May 02, 1963
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Tue, May 01, 1962
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Sun, Apr 30, 1961
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Fri, Apr 29, 1960
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Wed, Apr 29, 1959
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Mon, Apr 28, 1958
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Sat, Apr 27, 1957
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Thu, Apr 26, 1956
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Tue, Apr 26, 1955
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Sun, Apr 25, 1954
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Fri, Apr 24, 1953
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Wed, Apr 23, 1952
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Mon, Apr 23, 1951
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Sat, Apr 22, 1950
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Thu, Apr 21, 1949
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Tue, Apr 20, 1948
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Sun, Apr 20, 1947
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Fri, Apr 19, 1946
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Wed, Apr 18, 1945
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Mon, Apr 17, 1944
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Sat, Apr 17, 1943
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Thu, Apr 16, 1942
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Tue, Apr 15, 1941
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Sun, Apr 14, 1940
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Fri, Apr 14, 1939
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Wed, Apr 13, 1938
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Mon, Apr 12, 1937
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Sat, Apr 11, 1936
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Thu, Apr 11, 1935
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Tue, Apr 10, 1934
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Sun, Apr 09, 1933
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Fri, Apr 08, 1932
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Wed, Apr 08, 1931
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Mon, Apr 07, 1930
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Sat, Apr 06, 1929
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Thu, Apr 05, 1928
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Tue, Apr 05, 1927
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Sun, Apr 04, 1926
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Fri, Apr 03, 1925
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Wed, Apr 02, 1924
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Mon, Apr 02, 1923
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Sat, Apr 01, 1922
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Thu, Mar 31, 1921
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Tue, Mar 30, 1920
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Sun, Mar 30, 1919
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Fri, Mar 29, 1918
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Wed, Mar 28, 1917
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Mon, Mar 27, 1916
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Sat, Mar 27, 1915
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Thu, Mar 26, 1914
                                                            </div>
                                                        </td>
                                                    </tr>


                                                    <!-- First table -->
                                                    <tr class="focus-tr">
                                                        <td  class="editable-name"> <b>Project</b>
                                                        </td>
                                                        <td  class="editable-name"> <b>Rule</b>
                                                        </td>
                                                        <td  class="editable-name"> <b>Cutting</b> 
                                                        </td>
                                                        <td  class="editable-name"> <b>Sewing</b> 
                                                        </td>
                                                        <td  class="editable-name"> <b>Finishing</b> 
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="editable-name" rowspan="2"> <b>C-NEW</b>
                                                        </td>
                                                        <td  class="editable-name"> <b>Due Date</b>
                                                        </td>
                                                        <td>
                                                            Mon, Jun 09, 2014
                                                        </td>
                                                        <td>
                                                            Fri, May 09, 2014
                                                        </td>
                                                        <td>
                                                            Wed, Nov 06, 2013
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="editable-name"> <b>Delivery Date</b>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Mon, Jun 09, 2014
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Fri, May 09, 2014
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Wed, Nov 06, 2013
                                                            </div>
                                                        </td>
                                                    </tr>


                                                    <!-- First table -->
                                                    <tr class="focus-tr">
                                                        <td  class="editable-name"> <b>Project</b>
                                                        </td>
                                                        <td  class="editable-name"> <b>Rule</b>
                                                        </td>
                                                        <td  class="editable-name"> <b>Cutting</b> 
                                                        </td>
                                                        <td  class="editable-name"> <b>Rule 01</b> 
                                                        </td>
                                                        <td  class="editable-name"> <b>Rule 02</b> 
                                                        </td>
                                                        <td  class="editable-name"> <b>Rule 03</b> 
                                                        </td>
                                                        <td  class="editable-name"> <b>Rule 04</b> 
                                                        </td>
                                                        <td  class="editable-name"> <b>Rule 05</b> 
                                                        </td>
                                                        <td  class="editable-name"> <b>Rule 06</b> 
                                                        </td>
                                                        <td  class="editable-name"> <b>Rule 07</b> 
                                                        </td>
                                                        <td  class="editable-name"> <b>Rule 08</b> 
                                                        </td>
                                                        <td  class="editable-name"> <b>Rule 09</b> 
                                                        </td>
                                                        <td  class="editable-name"> <b>Rule 10</b> 
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="editable-name" rowspan="2"> <b>D-NEW</b>
                                                        </td>
                                                        <td  class="editable-name"> <b>Due Date</b>
                                                        </td>
                                                        <td>
                                                            Mon, Jun 09, 2014
                                                        </td>
                                                        <td>
                                                            Tue, Jun 08, 2004
                                                        </td>
                                                        <td>
                                                            Wed, Jun 08, 1994
                                                        </td>
                                                        <td>
                                                            Thu, Jun 07, 1984
                                                        </td>
                                                        <td>
                                                            Fri, Jun 07, 1974
                                                        </td>
                                                        <td>
                                                            Sat, Jun 06, 1964
                                                        </td>
                                                        <td>
                                                            Sun, Jun 06, 1954
                                                        </td>
                                                        <td>
                                                            Mon, Jun 05, 1944
                                                        </td>
                                                        <td>
                                                            Tue, Jun 05, 1934
                                                        </td>
                                                        <td>
                                                            Wed, Jun 04, 1924
                                                        </td>
                                                        <td>
                                                            Thu, Jun 04, 1914
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="editable-name"> <b>Delivery Date</b>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Mon, Jun 09, 2014
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Tue, Jun 08, 2004
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Wed, Jun 08, 1994
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Thu, Jun 07, 1984
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Fri, Jun 07, 1974
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Sat, Jun 06, 1964
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Sun, Jun 06, 1954
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Mon, Jun 05, 1944
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Tue, Jun 05, 1934
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Wed, Jun 04, 1924
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Thu, Jun 04, 1914
                                                            </div>
                                                        </td>
                                                    </tr>


                                                    <!-- First table -->
                                                    <tr class="focus-tr">
                                                        <td class="editable-name"> <b>Project</b>
                                                        </td>
                                                        <td class="editable-name"> <b>Rule</b>
                                                        </td>
                                                        <td class="editable-name"> <b>Cutting</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Sewing</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Finishing</b> 
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="editable-name" rowspan="2"> <b>E-NEW</b>
                                                        </td>
                                                        <td class="editable-name"> <b>Due Date</b>
                                                        </td>
                                                        <td>
                                                            Mon, Jun 09, 2014
                                                        </td>
                                                        <td>
                                                            Fri, May 09, 2014
                                                        </td>
                                                        <td>
                                                            Wed, Nov 06, 2013
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="editable-name"> <b>Delivery Date</b>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Mon, Jun 09, 2014
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Fri, May 09, 2014
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Wed, Nov 06, 2013
                                                            </div>
                                                        </td>
                                                    </tr>


                                                    <!-- First table -->
                                                    <tr class="focus-tr">
                                                        <td class="editable-name"> <b>Project</b>
                                                        </td>
                                                        <td class="editable-name"> <b>Rule</b>
                                                        </td>
                                                        <td class="editable-name"> <b>Cutting</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Sewing</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Finishing</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Final Inspection</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>X Factory</b> 
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="editable-name" rowspan="2"> <b>H-NEW</b>
                                                        </td>
                                                        <td class="editable-name"> <b>Due Date</b>
                                                        </td>
                                                        <td>
                                                            Sun, Jun 24, 2012
                                                        </td>
                                                        <td>
                                                            Mon, Apr 23, 2012
                                                        </td>
                                                        <td>
                                                            Tue, Jun 24, 2008
                                                        </td>
                                                        <td>
                                                            Sat, Jun 24, 1995
                                                        </td>
                                                        <td>
                                                            Fri, Jun 24, 1949
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="editable-name"> <b>Delivery Date</b>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Sun, Jun 24, 2012
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Mon, Apr 23, 2012
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Tue, Jun 24, 2008
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Sat, Jun 24, 1995
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Fri, Jun 24, 1949
                                                            </div>
                                                        </td>
                                                    </tr>


                                                    <!-- First table -->
                                                    <tr class="focus-tr">
                                                        <td class="editable-name"> <b>Project</b>
                                                        </td>
                                                        <td class="editable-name"> <b>Rule</b>
                                                        </td>
                                                        <td class="editable-name"> <b>Cutting</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 01</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 02</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 03</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 04</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 05</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 06</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 07</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 08</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 09</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 10</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 11</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 12</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 13</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 14</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 15</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 16</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 17</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 18</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 19</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 20</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 21</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 22</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 23</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 24</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 25</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 26</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 27</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 28</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 29</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 30</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 31</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 32</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 33</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 34</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 35</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 36</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 37</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 38</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 39</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 40</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 41</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 42</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 43</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 44</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 45</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 46</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 47</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 48</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 49</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 50</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 51</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 52</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 53</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 54</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 55</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 56</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 57</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 58</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 59</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 60</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 61</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 62</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 63</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 64</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 65</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 66</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 67</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 68</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 69</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 70</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 71</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 72</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 73</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 74</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 75</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 76</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 77</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 78</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 79</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 80</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 81</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 82</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 83</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 84</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 85</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 86</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 87</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 88</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 89</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 90</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 91</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 92</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 93</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 94</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 95</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 96</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 97</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 98</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 99</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 100</b> 
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="editable-name" rowspan="2"> <b>I-NEW</b>
                                                        </td>
                                                        <td class="editable-name"> <b>Due Date</b>
                                                        </td>
                                                        <td>
                                                            Mon, Jun 09, 2014
                                                        </td>
                                                        <td>
                                                            Sat, Jun 08, 2013
                                                        </td>
                                                        <td>
                                                            Thu, Jun 07, 2012
                                                        </td>
                                                        <td>
                                                            Tue, Jun 07, 2011
                                                        </td>
                                                        <td>
                                                            Sun, Jun 06, 2010
                                                        </td>
                                                        <td>
                                                            Fri, Jun 05, 2009
                                                        </td>
                                                        <td>
                                                            Wed, Jun 04, 2008
                                                        </td>
                                                        <td>
                                                            Mon, Jun 04, 2007
                                                        </td>
                                                        <td>
                                                            Sat, Jun 03, 2006
                                                        </td>
                                                        <td>
                                                            Thu, Jun 02, 2005
                                                        </td>
                                                        <td>
                                                            Tue, Jun 01, 2004
                                                        </td>
                                                        <td>
                                                            Sun, Jun 01, 2003
                                                        </td>
                                                        <td>
                                                            Fri, May 31, 2002
                                                        </td>
                                                        <td>
                                                            Wed, May 30, 2001
                                                        </td>
                                                        <td>
                                                            Mon, May 29, 2000
                                                        </td>
                                                        <td>
                                                            Sat, May 29, 1999
                                                        </td>
                                                        <td>
                                                            Thu, May 28, 1998
                                                        </td>
                                                        <td>
                                                            Tue, May 27, 1997
                                                        </td>
                                                        <td>
                                                            Sun, May 26, 1996
                                                        </td>
                                                        <td>
                                                            Fri, May 26, 1995
                                                        </td>
                                                        <td>
                                                            Wed, May 25, 1994
                                                        </td>
                                                        <td>
                                                            Mon, May 24, 1993
                                                        </td>
                                                        <td>
                                                            Sat, May 23, 1992
                                                        </td>
                                                        <td>
                                                            Thu, May 23, 1991
                                                        </td>
                                                        <td>
                                                            Tue, May 22, 1990
                                                        </td>
                                                        <td>
                                                            Sun, May 21, 1989
                                                        </td>
                                                        <td>
                                                            Fri, May 20, 1988
                                                        </td>
                                                        <td>
                                                            Wed, May 20, 1987
                                                        </td>
                                                        <td>
                                                            Mon, May 19, 1986
                                                        </td>
                                                        <td>
                                                            Sat, May 18, 1985
                                                        </td>
                                                        <td>
                                                            Thu, May 17, 1984
                                                        </td>
                                                        <td>
                                                            Tue, May 17, 1983
                                                        </td>
                                                        <td>
                                                            Sun, May 16, 1982
                                                        </td>
                                                        <td>
                                                            Fri, May 15, 1981
                                                        </td>
                                                        <td>
                                                            Wed, May 14, 1980
                                                        </td>
                                                        <td>
                                                            Mon, May 14, 1979
                                                        </td>
                                                        <td>
                                                            Sat, May 13, 1978
                                                        </td>
                                                        <td>
                                                            Thu, May 12, 1977
                                                        </td>
                                                        <td>
                                                            Tue, May 11, 1976
                                                        </td>
                                                        <td>
                                                            Sun, May 11, 1975
                                                        </td>
                                                        <td>
                                                            Fri, May 10, 1974
                                                        </td>
                                                        <td>
                                                            Wed, May 09, 1973
                                                        </td>
                                                        <td>
                                                            Mon, May 08, 1972
                                                        </td>
                                                        <td>
                                                            Sat, May 08, 1971
                                                        </td>
                                                        <td>
                                                            Thu, May 07, 1970
                                                        </td>
                                                        <td>
                                                            Tue, May 06, 1969
                                                        </td>
                                                        <td>
                                                            Sun, May 05, 1968
                                                        </td>
                                                        <td>
                                                            Fri, May 05, 1967
                                                        </td>
                                                        <td>
                                                            Wed, May 04, 1966
                                                        </td>
                                                        <td>
                                                            Mon, May 03, 1965
                                                        </td>
                                                        <td>
                                                            Sat, May 02, 1964
                                                        </td>
                                                        <td>
                                                            Thu, May 02, 1963
                                                        </td>
                                                        <td>
                                                            Tue, May 01, 1962
                                                        </td>
                                                        <td>
                                                            Sun, Apr 30, 1961
                                                        </td>
                                                        <td>
                                                            Fri, Apr 29, 1960
                                                        </td>
                                                        <td>
                                                            Wed, Apr 29, 1959
                                                        </td>
                                                        <td>
                                                            Mon, Apr 28, 1958
                                                        </td>
                                                        <td>
                                                            Sat, Apr 27, 1957
                                                        </td>
                                                        <td>
                                                            Thu, Apr 26, 1956
                                                        </td>
                                                        <td>
                                                            Tue, Apr 26, 1955
                                                        </td>
                                                        <td>
                                                            Sun, Apr 25, 1954
                                                        </td>
                                                        <td>
                                                            Fri, Apr 24, 1953
                                                        </td>
                                                        <td>
                                                            Wed, Apr 23, 1952
                                                        </td>
                                                        <td>
                                                            Mon, Apr 23, 1951
                                                        </td>
                                                        <td>
                                                            Sat, Apr 22, 1950
                                                        </td>
                                                        <td>
                                                            Thu, Apr 21, 1949
                                                        </td>
                                                        <td>
                                                            Tue, Apr 20, 1948
                                                        </td>
                                                        <td>
                                                            Sun, Apr 20, 1947
                                                        </td>
                                                        <td>
                                                            Fri, Apr 19, 1946
                                                        </td>
                                                        <td>
                                                            Wed, Apr 18, 1945
                                                        </td>
                                                        <td>
                                                            Mon, Apr 17, 1944
                                                        </td>
                                                        <td>
                                                            Sat, Apr 17, 1943
                                                        </td>
                                                        <td>
                                                            Thu, Apr 16, 1942
                                                        </td>
                                                        <td>
                                                            Tue, Apr 15, 1941
                                                        </td>
                                                        <td>
                                                            Sun, Apr 14, 1940
                                                        </td>
                                                        <td>
                                                            Fri, Apr 14, 1939
                                                        </td>
                                                        <td>
                                                            Wed, Apr 13, 1938
                                                        </td>
                                                        <td>
                                                            Mon, Apr 12, 1937
                                                        </td>
                                                        <td>
                                                            Sat, Apr 11, 1936
                                                        </td>
                                                        <td>
                                                            Thu, Apr 11, 1935
                                                        </td>
                                                        <td>
                                                            Tue, Apr 10, 1934
                                                        </td>
                                                        <td>
                                                            Sun, Apr 09, 1933
                                                        </td>
                                                        <td>
                                                            Fri, Apr 08, 1932
                                                        </td>
                                                        <td>
                                                            Wed, Apr 08, 1931
                                                        </td>
                                                        <td>
                                                            Mon, Apr 07, 1930
                                                        </td>
                                                        <td>
                                                            Sat, Apr 06, 1929
                                                        </td>
                                                        <td>
                                                            Thu, Apr 05, 1928
                                                        </td>
                                                        <td>
                                                            Tue, Apr 05, 1927
                                                        </td>
                                                        <td>
                                                            Sun, Apr 04, 1926
                                                        </td>
                                                        <td>
                                                            Fri, Apr 03, 1925
                                                        </td>
                                                        <td>
                                                            Wed, Apr 02, 1924
                                                        </td>
                                                        <td>
                                                            Mon, Apr 02, 1923
                                                        </td>
                                                        <td>
                                                            Sat, Apr 01, 1922
                                                        </td>
                                                        <td>
                                                            Thu, Mar 31, 1921
                                                        </td>
                                                        <td>
                                                            Tue, Mar 30, 1920
                                                        </td>
                                                        <td>
                                                            Sun, Mar 30, 1919
                                                        </td>
                                                        <td>
                                                            Fri, Mar 29, 1918
                                                        </td>
                                                        <td>
                                                            Wed, Mar 28, 1917
                                                        </td>
                                                        <td>
                                                            Mon, Mar 27, 1916
                                                        </td>
                                                        <td>
                                                            Sat, Mar 27, 1915
                                                        </td>
                                                        <td>
                                                            Thu, Mar 26, 1914
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="editable-name"> <b>Delivery Date</b>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Mon, Jun 09, 2014
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Sat, Jun 08, 2013
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Thu, Jun 07, 2012
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Tue, Jun 07, 2011
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Sun, Jun 06, 2010
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Fri, Jun 05, 2009
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Wed, Jun 04, 2008
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Mon, Jun 04, 2007
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Sat, Jun 03, 2006
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Thu, Jun 02, 2005
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Tue, Jun 01, 2004
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Sun, Jun 01, 2003
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Fri, May 31, 2002
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Wed, May 30, 2001
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Mon, May 29, 2000
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Sat, May 29, 1999
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Thu, May 28, 1998
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Tue, May 27, 1997
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Sun, May 26, 1996
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Fri, May 26, 1995
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Wed, May 25, 1994
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Mon, May 24, 1993
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Sat, May 23, 1992
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Thu, May 23, 1991
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Tue, May 22, 1990
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Sun, May 21, 1989
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Fri, May 20, 1988
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Wed, May 20, 1987
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Mon, May 19, 1986
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Sat, May 18, 1985
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Thu, May 17, 1984
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Tue, May 17, 1983
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Sun, May 16, 1982
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Fri, May 15, 1981
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Wed, May 14, 1980
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Mon, May 14, 1979
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Sat, May 13, 1978
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Thu, May 12, 1977
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Tue, May 11, 1976
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Sun, May 11, 1975
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Fri, May 10, 1974
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Wed, May 09, 1973
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Mon, May 08, 1972
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Sat, May 08, 1971
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Thu, May 07, 1970
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Tue, May 06, 1969
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Sun, May 05, 1968
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Fri, May 05, 1967
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Wed, May 04, 1966
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Mon, May 03, 1965
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Sat, May 02, 1964
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Thu, May 02, 1963
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Tue, May 01, 1962
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Sun, Apr 30, 1961
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Fri, Apr 29, 1960
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Wed, Apr 29, 1959
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Mon, Apr 28, 1958
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Sat, Apr 27, 1957
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Thu, Apr 26, 1956
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Tue, Apr 26, 1955
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Sun, Apr 25, 1954
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Fri, Apr 24, 1953
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Wed, Apr 23, 1952
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Mon, Apr 23, 1951
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Sat, Apr 22, 1950
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Thu, Apr 21, 1949
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Tue, Apr 20, 1948
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Sun, Apr 20, 1947
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Fri, Apr 19, 1946
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Wed, Apr 18, 1945
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Mon, Apr 17, 1944
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Sat, Apr 17, 1943
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Thu, Apr 16, 1942
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Tue, Apr 15, 1941
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Sun, Apr 14, 1940
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Fri, Apr 14, 1939
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Wed, Apr 13, 1938
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Mon, Apr 12, 1937
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Sat, Apr 11, 1936
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Thu, Apr 11, 1935
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Tue, Apr 10, 1934
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Sun, Apr 09, 1933
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Fri, Apr 08, 1932
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Wed, Apr 08, 1931
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Mon, Apr 07, 1930
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Sat, Apr 06, 1929
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Thu, Apr 05, 1928
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Tue, Apr 05, 1927
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Sun, Apr 04, 1926
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Fri, Apr 03, 1925
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Wed, Apr 02, 1924
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Mon, Apr 02, 1923
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Sat, Apr 01, 1922
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Thu, Mar 31, 1921
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Tue, Mar 30, 1920
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Sun, Mar 30, 1919
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Fri, Mar 29, 1918
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Wed, Mar 28, 1917
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Mon, Mar 27, 1916
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Sat, Mar 27, 1915
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Thu, Mar 26, 1914
                                                            </div>
                                                        </td>
                                                    </tr>


                                                    <!-- First table -->
                                                    <tr class="focus-tr">
                                                        <td class="editable-name"> <b>Project</b>
                                                        </td>
                                                        <td class="editable-name"> <b>Rule</b>
                                                        </td>
                                                        <td class="editable-name"> <b>Cutting</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 01</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 02</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 03</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 04</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 05</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 06</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 07</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 08</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 09</b> 
                                                        </td>
                                                        <td class="editable-name"> <b>Rule 10</b> 
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="editable-name" rowspan="2"> <b>K-NEW</b>
                                                        </td>
                                                        <td class="editable-name"> <b>Due Date</b>
                                                        </td>
                                                        <td>
                                                            Mon, Jun 09, 2014
                                                        </td>
                                                        <td>
                                                            Tue, Jun 08, 2004
                                                        </td>
                                                        <td>
                                                            Wed, Jun 08, 1994
                                                        </td>
                                                        <td>
                                                            Thu, Jun 07, 1984
                                                        </td>
                                                        <td>
                                                            Fri, Jun 07, 1974
                                                        </td>
                                                        <td>
                                                            Sat, Jun 06, 1964
                                                        </td>
                                                        <td>
                                                            Sun, Jun 06, 1954
                                                        </td>
                                                        <td>
                                                            Mon, Jun 05, 1944
                                                        </td>
                                                        <td>
                                                            Tue, Jun 05, 1934
                                                        </td>
                                                        <td>
                                                            Wed, Jun 04, 1924
                                                        </td>
                                                        <td>
                                                            Thu, Jun 04, 1914
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td> <b>Delivery Date</b>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Mon, Jun 09, 2014
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Tue, Jun 08, 2004
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Wed, Jun 08, 1994
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Thu, Jun 07, 1984
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Fri, Jun 07, 1974
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Sat, Jun 06, 1964
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Sun, Jun 06, 1954
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Mon, Jun 05, 1944
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Tue, Jun 05, 1934
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Wed, Jun 04, 1924
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Thu, Jun 04, 1914
                                                            </div>
                                                        </td>
                                                    </tr>


                                                    <!-- First table -->
                                                    <tr class="focus-tr">
                                                        <td> <b>Project</b>
                                                        </td>
                                                        <td> <b>Rule</b>
                                                        </td>
                                                        <td> <b>Cutting</b> 
                                                        </td>
                                                        <td> <b>Sewing</b> 
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td rowspan="2"> <b>L-NEW</b>
                                                        </td>
                                                        <td> <b>Due Date</b>
                                                        </td>
                                                        <td>
                                                            Tue, Jun 24, 2003
                                                        </td>
                                                        <td>
                                                            Wed, Jun 24, 1998
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td> <b>Delivery Date</b>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Tue, Jun 24, 2003
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Wed, Jun 24, 1998
                                                            </div>
                                                        </td>
                                                    </tr>


                                                    <!-- First table -->
                                                    <tr class="focus-tr">
                                                        <td> <b>Project</b>
                                                        </td>
                                                        <td> <b>Rule</b>
                                                        </td>
                                                        <td> <b>Cutting</b> 
                                                        </td>
                                                        <td> <b>Sewing</b> 
                                                        </td>
                                                        <td> <b>Finishing</b> 
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td rowspan="2"> <b>M-NEW</b>
                                                        </td>
                                                        <td> <b>Due Date</b>
                                                        </td>
                                                        <td>
                                                            Mon, Jun 09, 2014
                                                        </td>
                                                        <td>
                                                            Fri, May 09, 2014
                                                        </td>
                                                        <td>
                                                            Wed, Nov 06, 2013
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td> <b>Delivery Date</b>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Mon, Jun 09, 2014
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Fri, May 09, 2014
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Wed, Nov 06, 2013
                                                            </div>
                                                        </td>
                                                    </tr>


                                                    <!-- First table -->
                                                    <tr class="focus-tr">
                                                        <td> <b>Project</b>
                                                        </td>
                                                        <td> <b>Rule</b>
                                                        </td>
                                                        <td> <b>Cutting</b> 
                                                        </td>
                                                        <td> <b>Sewing</b> 
                                                        </td>
                                                        <td> <b>Finishing</b> 
                                                        </td>
                                                        <td> <b>Final Inspection Date</b> 
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td rowspan="2"> <b>N-NEW</b>
                                                        </td>
                                                        <td> <b>Due Date</b>
                                                        </td>
                                                        <td>
                                                            Mon, Jun 24, 2013
                                                        </td>
                                                        <td>
                                                            Sun, Mar 24, 2013
                                                        </td>
                                                        <td>
                                                            Sun, Jun 24, 2001
                                                        </td>
                                                        <td>
                                                            Thu, May 24, 2001
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td> <b>Delivery Date</b>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Mon, Jun 24, 2013
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Sun, Mar 24, 2013
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Sun, Jun 24, 2001
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Thu, May 24, 2001
                                                            </div>
                                                        </td>
                                                    </tr>


                                                    <!-- First table -->
                                                    <tr class="focus-tr">
                                                        <td> <b>Project</b>
                                                        </td>
                                                        <td> <b>Rule</b>
                                                        </td>
                                                        <td> <b>Cutting</b> 
                                                        </td>
                                                        <td> <b>Sewing</b> 
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td rowspan="2"> <b>O-NEW</b>
                                                        </td>
                                                        <td> <b>Due Date</b>
                                                        </td>
                                                        <td>
                                                            Mon, Jun 09, 2014
                                                        </td>
                                                        <td>
                                                            Fri, May 09, 2014
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td> <b>Delivery Date</b>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Mon, Jun 09, 2014
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Fri, May 09, 2014
                                                            </div>
                                                        </td>
                                                    </tr>


                                                    <!-- First table -->
                                                    <tr class="focus-tr">
                                                        <td> <b>Project</b>
                                                        </td>
                                                        <td> <b>Rule</b>
                                                        </td>
                                                        <td> <b>Cutting</b> 
                                                        </td>
                                                        <td> <b>Rule 01</b> 
                                                        </td>
                                                        <td> <b>Rule 02</b> 
                                                        </td>
                                                        <td> <b>Rule 03</b> 
                                                        </td>
                                                        <td> <b>Rule 04</b> 
                                                        </td>
                                                        <td> <b>Rule 05</b> 
                                                        </td>
                                                        <td> <b>Rule 06</b> 
                                                        </td>
                                                        <td> <b>Rule 07</b> 
                                                        </td>
                                                        <td> <b>Rule 08</b> 
                                                        </td>
                                                        <td> <b>Rule 09</b> 
                                                        </td>
                                                        <td> <b>Rule 10</b> 
                                                        </td>
                                                        <td> <b>Rule 11</b> 
                                                        </td>
                                                        <td> <b>Rule 12</b> 
                                                        </td>
                                                        <td> <b>Rule 13</b> 
                                                        </td>
                                                        <td> <b>Rule 14</b> 
                                                        </td>
                                                        <td> <b>Rule 15</b> 
                                                        </td>
                                                        <td> <b>Rule 16</b> 
                                                        </td>
                                                        <td> <b>Rule 17</b> 
                                                        </td>
                                                        <td> <b>Rule 18</b> 
                                                        </td>
                                                        <td> <b>Rule 19</b> 
                                                        </td>
                                                        <td> <b>Rule 20</b> 
                                                        </td>
                                                        <td> <b>Rule 21</b> 
                                                        </td>
                                                        <td> <b>Rule 22</b> 
                                                        </td>
                                                        <td> <b>Rule 23</b> 
                                                        </td>
                                                        <td> <b>Rule 24</b> 
                                                        </td>
                                                        <td> <b>Rule 25</b> 
                                                        </td>
                                                        <td> <b>Rule 26</b> 
                                                        </td>
                                                        <td> <b>Rule 27</b> 
                                                        </td>
                                                        <td> <b>Rule 28</b> 
                                                        </td>
                                                        <td> <b>Rule 29</b> 
                                                        </td>
                                                        <td> <b>Rule 30</b> 
                                                        </td>
                                                        <td> <b>Rule 31</b> 
                                                        </td>
                                                        <td> <b>Rule 32</b> 
                                                        </td>
                                                        <td> <b>Rule 33</b> 
                                                        </td>
                                                        <td> <b>Rule 34</b> 
                                                        </td>
                                                        <td> <b>Rule 35</b> 
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td rowspan="2"> <b>P-NEW</b>
                                                        </td>
                                                        <td> <b>Due Date</b>
                                                        </td>
                                                        <td>
                                                            Mon, Jun 09, 2014
                                                        </td>
                                                        <td>
                                                            Thu, Jun 09, 2011
                                                        </td>
                                                        <td>
                                                            Sun, Jun 08, 2008
                                                        </td>
                                                        <td>
                                                            Wed, Jun 08, 2005
                                                        </td>
                                                        <td>
                                                            Sat, Jun 08, 2002
                                                        </td>
                                                        <td>
                                                            Tue, Jun 08, 1999
                                                        </td>
                                                        <td>
                                                            Fri, Jun 07, 1996
                                                        </td>
                                                        <td>
                                                            Mon, Jun 07, 1993
                                                        </td>
                                                        <td>
                                                            Thu, Jun 07, 1990
                                                        </td>
                                                        <td>
                                                            Sun, Jun 07, 1987
                                                        </td>
                                                        <td>
                                                            Wed, Jun 06, 1984
                                                        </td>
                                                        <td>
                                                            Sat, Jun 06, 1981
                                                        </td>
                                                        <td>
                                                            Tue, Jun 06, 1978
                                                        </td>
                                                        <td>
                                                            Fri, Jun 06, 1975
                                                        </td>
                                                        <td>
                                                            Mon, Jun 05, 1972
                                                        </td>
                                                        <td>
                                                            Thu, Jun 05, 1969
                                                        </td>
                                                        <td>
                                                            Sun, Jun 05, 1966
                                                        </td>
                                                        <td>
                                                            Wed, Jun 05, 1963
                                                        </td>
                                                        <td>
                                                            Sat, Jun 04, 1960
                                                        </td>
                                                        <td>
                                                            Tue, Jun 04, 1957
                                                        </td>
                                                        <td>
                                                            Fri, Jun 04, 1954
                                                        </td>
                                                        <td>
                                                            Mon, Jun 04, 1951
                                                        </td>
                                                        <td>
                                                            Thu, Jun 03, 1948
                                                        </td>
                                                        <td>
                                                            Sun, Jun 03, 1945
                                                        </td>
                                                        <td>
                                                            Wed, Jun 03, 1942
                                                        </td>
                                                        <td>
                                                            Sat, Jun 03, 1939
                                                        </td>
                                                        <td>
                                                            Tue, Jun 02, 1936
                                                        </td>
                                                        <td>
                                                            Fri, Jun 02, 1933
                                                        </td>
                                                        <td>
                                                            Mon, Jun 02, 1930
                                                        </td>
                                                        <td>
                                                            Thu, Jun 02, 1927
                                                        </td>
                                                        <td>
                                                            Sun, Jun 01, 1924
                                                        </td>
                                                        <td>
                                                            Wed, Jun 01, 1921
                                                        </td>
                                                        <td>
                                                            Sat, Jun 01, 1918
                                                        </td>
                                                        <td>
                                                            Tue, Jun 01, 1915
                                                        </td>
                                                        <td>
                                                            Fri, May 31, 1912
                                                        </td>
                                                        <td>
                                                            Mon, May 31, 1909
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td> <b>Delivery Date</b>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Mon, Jun 09, 2014
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Thu, Jun 09, 2011
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Sun, Jun 08, 2008
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Wed, Jun 08, 2005
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Sat, Jun 08, 2002
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Tue, Jun 08, 1999
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Fri, Jun 07, 1996
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Mon, Jun 07, 1993
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Thu, Jun 07, 1990
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Sun, Jun 07, 1987
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Wed, Jun 06, 1984
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Sat, Jun 06, 1981
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Tue, Jun 06, 1978
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Fri, Jun 06, 1975
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Mon, Jun 05, 1972
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Thu, Jun 05, 1969
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Sun, Jun 05, 1966
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Wed, Jun 05, 1963
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Sat, Jun 04, 1960
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Tue, Jun 04, 1957
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Fri, Jun 04, 1954
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Mon, Jun 04, 1951
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Thu, Jun 03, 1948
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Sun, Jun 03, 1945
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Wed, Jun 03, 1942
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Sat, Jun 03, 1939
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Tue, Jun 02, 1936
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Fri, Jun 02, 1933
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Mon, Jun 02, 1930
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Thu, Jun 02, 1927
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Sun, Jun 01, 1924
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Wed, Jun 01, 1921
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Sat, Jun 01, 1918
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Tue, Jun 01, 1915
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Fri, May 31, 1912
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Mon, May 31, 1909
                                                            </div>
                                                        </td>
                                                    </tr>


                                                    <!-- First table -->
                                                    <tr class="focus-tr">
                                                        <td> <b>Project</b>
                                                        </td>
                                                        <td> <b>Rule</b>
                                                        </td>
                                                        <td> <b>Cutting</b> 
                                                        </td>
                                                        <td> <b>Sewing</b> 
                                                        </td>
                                                        <td> <b>Finishing</b> 
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td rowspan="2"> <b>R-NEW</b>
                                                        </td>
                                                        <td> <b>Due Date</b>
                                                        </td>
                                                        <td>
                                                            Thu, Jun 24, 2004
                                                        </td>
                                                        <td>
                                                            Mon, May 24, 2004
                                                        </td>
                                                        <td>
                                                            Tue, Dec 23, 2003
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td> <b>Delivery Date</b>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Thu, Jun 24, 2004
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Mon, May 24, 2004
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Tue, Dec 23, 2003
                                                            </div>
                                                        </td>
                                                    </tr>


                                                    <!-- First table -->
                                                    <tr class="focus-tr">
                                                        <td> <b>Project</b>
                                                        </td>
                                                        <td> <b>Rule</b>
                                                        </td>
                                                        <td> <b>Cutting</b> 
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td rowspan="2"> <b>32-NEW</b>
                                                        </td>
                                                        <td> <b>Due Date</b>
                                                        </td>
                                                        <td>
                                                            Tue, Dec 17, 2013
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td> <b>Delivery Date</b>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Tue, Dec 17, 2013
                                                            </div>
                                                        </td>
                                                    </tr>


                                                    <!-- First table -->
                                                    <tr class="focus-tr">
                                                        <td> <b>Project</b>
                                                        </td>
                                                        <td> <b>Rule</b>
                                                        </td>
                                                        <td> <b>Cutting</b> 
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td rowspan="2"> <b>33-NEW</b>
                                                        </td>
                                                        <td> <b>Due Date</b>
                                                        </td>
                                                        <td>
                                                            Tue, May 13, 2014
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td> <b>Delivery Date</b>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Tue, May 13, 2014
                                                            </div>
                                                        </td>
                                                    </tr>


                                                    <!-- First table -->
                                                    <tr class="focus-tr">
                                                        <td> <b>Project</b>
                                                        </td>
                                                        <td> <b>Rule</b>
                                                        </td>
                                                        <td> <b>Cutting</b> 
                                                        </td>
                                                        <td> <b>Sewing</b> 
                                                        </td>
                                                        <td> <b>Finishing</b> 
                                                        </td>
                                                        <td> <b>Final Inspection</b> 
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td rowspan="2"> <b>34-NEW</b>
                                                        </td>
                                                        <td> <b>Due Date</b>
                                                        </td>
                                                        <td>
                                                            Thu, Jun 24, 1999
                                                        </td>
                                                        <td>
                                                            Mon, May 24, 1999
                                                        </td>
                                                        <td>
                                                            Sun, Feb 21, 1999
                                                        </td>
                                                        <td>
                                                            Sat, Feb 21, 1998
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td> <b>Delivery Date</b>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Thu, Jun 24, 1999
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Mon, May 24, 1999
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Sun, Feb 21, 1999
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="edit-table-date">
                                                                Sat, Feb 21, 1998
                                                            </div>
                                                        </td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- END CONTENT BODY -->
    </div>

    <!-- START TASK Delivery date MODAL -->
    <div class="modal fade" id="name_edit_modal" tabindex="-1" role="select_delivery_modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title text-center font-theme uppercase" id="select_delivery_modalLabel">Edit field name</h4>
                </div>
                
                <form id="unlock_form" method="post" action="">
                    {{ csrf_field() }}
                    <input type="hidden" name="project_task_id" id="project_task_id" value="">

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                <div class="alert alert-success text-center" id="unlock_success_message" style="display:none"></div>
                                <div class="alert alert-danger text-center" id="unlock_error_message" style="display: none"></div>
                                <div class="form-group">
                                    <label for="">Field name</label>
                                    <input type="text" class="form-control">
                                </div>
                            </div>  
                        </div>
                    </div>
                    <div class="modal-footer" style="text-align: center;">
                        <button type="submit" class="btn theme-btn" id="delivery_submit_button">submit</button>
                        <button type="button" class="btn btn-danger" id="" data-dismiss="modal" >cancel</button>
                    </div>
                </form>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- END TASK SUMMERY MODAL -->

    <!-- END CONTENT -->
@endsection

@section('js')
    <script>
        $(document).on('click', '.editable-name', function() {
            $('#name_edit_modal').modal('show');
        });
        $(document).on("submit", "#setting_form", function(event) {
            event.preventDefault();

            var options = {
                theme: "sk-cube-grid",
                message: 'Please wait while saving all data.....',
                backgroundColor: "#1847B1",
                textColor: "white"
            };

            HoldOn.open(options);

            //var username = $("#username").val();

            var validate = "";

            /*if (username.trim() == "") {
                validate = validate + "Username is required</br>";
            }*/

            if (validate == "") {
                var formData = new FormData($("#setting_form")[0]);
                var url = "{{ url('admin/update_common_settings') }}";

                $.ajax({
                    type: "POST",
                    url: url,
                    data: formData,
                    success: function(data) {
                        HoldOn.close();
                        if (data.status == 200) {
                            $("#success_message").show();
                            $("#error_message").hide();
                            $("#success_message").html(data.reason);

                            setTimeout(function(){
                                $("#success_message").hide();
                            },2000);
                        } else {
                            $("#success_message").hide();
                            $("#error_message").show();
                            $("#error_message").html(data.reason);
                        }
                    },
                    error: function(data) {
                        HoldOn.close();
                        $("#success_message").hide();
                        $("#error_message").show();
                        $("#error_message").html(data);
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            } else {
                HoldOn.close();
                $("#success_message").hide();
                $("#error_message").show();
                $("#error_message").html(validate);
            }
        });
    </script>
@endsection

