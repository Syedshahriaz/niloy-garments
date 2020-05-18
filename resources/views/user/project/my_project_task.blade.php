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
                        <a href="{{url('/home')}}">Home</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <span>My Projects</span>
                    </li>
                </ul>
                <div class="page-toolbar">
                </div>
            </div>

            <!-- BEGIN PAGE TITLE-->
            <!-- <h3 class="page-title"> Projects
                <small>dashboard &amp; statistics</small>
            </h3> -->
            <!-- END PAGE TITLE-->
            <!-- END PAGE BAR -->
            <!-- END PAGE HEADER-->

            <div class="row mt-3">
                <div class="col-md-12 col-sm-12">
                    <!-- BEGIN PORTLET-->
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-share font-red-sunglo hide"></i>
                                <span class="caption-subject font-dark bold uppercase">Tasks for A </span>
                                <span class="caption-helper"></span>
                            </div>

                            <div class="actions">
                                <a data-toggle="modal" href="#task_summery_modal" class="btn btn-transparent green btn-circle btn-sm">View Summery</a>
                                <a title="List View" class="btn btn-transparent green btn-outline btn-circle btn-sm" href="javascript:;">
                                    <i class="icon-list icons"></i>
                                </a> 
                                <a title="Grid View" class="btn btn-transparent green btn-circle btn-sm" href="javascript:;">
                                    <i class="icon-grid icons"></i>
                                </a> 
                            </div>
                        </div>
                        <div class="portlet-body">

                            <table class="table table-striped table-bordered table-hover data-table " id="user_horizontal_task">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th> Cotton </th>
                                        <th> Spinning </th>
                                        <th> Knitting </th>
                                        <th> Dying </th>
                                        <th> Finising </th>
                                        <th> Test </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td> <b>Rule</b></td>
                                        <td> Cutting </td>
                                        <td> Sewing </td>
                                        <td> Finishing </td>
                                        <td> Final Inspection Date </td>
                                        <td> X Factor </td>
                                        <td> ETA </td>
                                    </tr>
                                    <tr>
                                        <td> <b>Due Date</b></td>
                                        <td> Wednesday<br> August 16, 2017 </td>
                                        <td> Saturday<br> September 16, 2017 </td>
                                        <td> Friday<br> October 20, 2017 </td>
                                        <td> Sunday<br> January 06, 2019 </td>
                                        <td> Wednesday<br> July 06, 2022 </td>
                                        <td> Friday<br> July 06, 2029 </td>
                                    </tr>
                                    <tr>
                                        <td> <b>Original Delivery Date</b></td>
                                        <td> Wednesday<br> August 16, 2017 </td>
                                        <td> Saturday<br> September 16, 2017 </td>
                                        <td> Friday<br> October 20, 2017 </td>
                                        <td> Sunday<br> January 06, 2019 </td>
                                        <td> Wednesday<br> July 06, 2022 </td>
                                        <td> Friday<br> July 06, 2029 </td>
                                    </tr>
                                </tbody>
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

    <!-- START TASK SUMMERY MODAL -->
    <div class="modal fade" id="task_summery_modal" tabindex="-1" role="task_summery_modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Summery of product</h4>
                </div>
                <div class="modal-body"> 
                    <p class="mt-0 mb-0">Description: Men's Short Sleeve T-Shirt.<br>
                    Fabrication: (100% Cotton 180GSM Single Jersey),<br>
                    Colour: Black, White, Blue, Greymarl, Turquise, <br>
                    Quantity: 10,000<br>
                    Size range: XS-S-M-L-XL-XXL<br>
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn blue" data-dismiss="modal">Close</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- END TASK SUMMERY MODAL -->
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $('#user_horizontal_task').DataTable({
                "paging":   false,
                "ordering": false,
                "info":     false,
                "searching": false
            });
        });
    </script>
@endsection

