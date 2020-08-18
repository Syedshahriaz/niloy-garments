@extends('layouts.admin_master')
@section('title', 'Report by Profession')
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
                                <span class="caption-subject font-dark bold uppercase">Profession Report</span>
                                <span class="caption-helper font-dark bold uppercase">
                                    <a class="btn btn-xs btn-success " id="summary_table_excel_button" onclick="download_purchase_by_profession()"> <i class="fa fa-download"></i> Download Excel </a>
                                </span>
                            </div>
                            <div class="actions hidden" id="action_buttons">
                                <button type="button" class="btn btn-transparent theme-btn btn-circle btn-sm" title="Send Email" id="send_email_all">Send Email</button>
                                {{--<button type="button" class="btn btn-transparent theme-btn btn-circle btn-sm" title="Remove Users" id="delete_user_all">Delete Users</button>--}}
                            </div>
                        </div>
                        <div class="portlet-body p-relative">
                            <table id="report_table" class="table table-striped table-bordered table-hover data-table focus-table">
                                <thead>
                                <tr>
                                    <th class="text-center">Profession</th>
                                    <th class="text-center">Total Customer</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $grand_total_user = 0;
                                    foreach($users as $key=>$user){
                                        $grand_total_user = $grand_total_user+$user->total_user;
                                    ?>
                                        <tr>
                                            <td class="text-center">
                                                @if($user->profession != '')
                                                    {{$user->profession}}
                                                @else
                                                    No Profession
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                {{$user->total_user}}
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td class="text-center">
                                            <b>Total</b>
                                        </td>
                                        <td class="text-center">
                                            {{$grand_total_user}}
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
        function download_purchase_by_profession() {
            var url = "{{ url("admin/download_report_profession_excel") }}";
            window.open(url);
        }
    </script>
@endsection

