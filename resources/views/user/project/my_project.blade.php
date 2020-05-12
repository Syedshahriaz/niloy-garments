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
                                <span class="caption-subject font-dark bold uppercase">My projects</span>
                                <span class="caption-helper">My selected project</span>
                            </div>
                            <div class="actions">

                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="row">
                                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                    <div class="dashboard-stat2 project-item">
                                        <div class="display">
                                            <div class="number">
                                                <h5 class="font-theme project-item-name">
                                                    PROJECT NAME
                                                </h5>
                                            </div>
                                            <div class="icon">
                                                <i class="icon-check"></i>
                                            </div>
                                        </div>
                                        <div class="progress-info">
                                            <div class="progress">
                                                <span style="width: 100%;" class="progress-bar theme-bg"></span>
                                            </div>
                                            <div class="status">
                                                <div class="status-title"> Due Date </div>
                                                <div class="status-number"> Wed Jun 20, 2020 </div>
                                            </div>
                                        </div>
                                        <input type="hidden" class="project-item-check" value="0">
                                    </div>
                                </div>

                                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                    <div class="dashboard-stat2 project-item">
                                        <div class="display">
                                            <div class="number">
                                                <h5 class="font-theme project-item-name">
                                                    PROJECT NAME
                                                </h5>
                                            </div>
                                            <div class="icon">
                                                <i class="icon-check"></i>
                                            </div>
                                        </div>
                                        <div class="progress-info">
                                            <div class="progress">
                                                <span style="width: 100%;" class="progress-bar theme-bg"></span>
                                            </div>
                                            <div class="status">
                                                <div class="status-title"> Due Date </div>
                                                <div class="status-number"> Wed Jun 20, 2020 </div>
                                            </div>
                                        </div>
                                        <input type="hidden" class="project-item-check" value="0">
                                    </div>
                                </div>

                                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                    <div class="dashboard-stat2 project-item">
                                        <div class="display">
                                            <div class="number">
                                                <h5 class="font-theme project-item-name">
                                                    PROJECT NAME
                                                </h5>
                                            </div>
                                            <div class="icon">
                                                <i class="icon-check"></i>
                                            </div>
                                        </div>
                                        <div class="progress-info">
                                            <div class="progress">
                                                <span style="width: 100%;" class="progress-bar theme-bg"></span>
                                            </div>
                                            <div class="status">
                                                <div class="status-title"> Due Date </div>
                                                <div class="status-number"> Wed Jun 20, 2020 </div>
                                            </div>
                                        </div>
                                        <input type="hidden" class="project-item-check" value="0">
                                    </div>
                                </div>

                                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                    <div class="dashboard-stat2 project-item">
                                        <div class="display">
                                            <div class="number">
                                                <h5 class="font-theme project-item-name">
                                                    PROJECT NAME
                                                </h5>
                                            </div>
                                            <div class="icon">
                                                <i class="icon-check"></i>
                                            </div>
                                        </div>
                                        <div class="progress-info">
                                            <div class="progress">
                                                <span style="width: 100%;" class="progress-bar theme-bg"></span>
                                            </div>
                                            <div class="status">
                                                <div class="status-title"> Due Date </div>
                                                <div class="status-number"> Wed Jun 20, 2020 </div>
                                            </div>
                                        </div>
                                        <input type="hidden" class="project-item-check" value="0">
                                    </div>
                                </div>

                                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                    <div class="dashboard-stat2 project-item">
                                        <div class="display">
                                            <div class="number">
                                                <h5 class="font-theme project-item-name">
                                                    PROJECT NAME
                                                </h5>
                                            </div>
                                            <div class="icon">
                                                <i class="icon-check"></i>
                                            </div>
                                        </div>
                                        <div class="progress-info">
                                            <div class="progress">
                                                <span style="width: 100%;" class="progress-bar theme-bg"></span>
                                            </div>
                                            <div class="status">
                                                <div class="status-title"> Due Date </div>
                                                <div class="status-number"> Wed Jun 20, 2020 </div>
                                            </div>
                                        </div>
                                        <input type="hidden" class="project-item-check" value="0">
                                    </div>
                                </div>

                                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                    <div class="dashboard-stat2 project-item">
                                        <div class="display">
                                            <div class="number">
                                                <h5 class="font-theme project-item-name">
                                                    PROJECT NAME
                                                </h5>
                                            </div>
                                            <div class="icon">
                                                <i class="icon-check"></i>
                                            </div>
                                        </div>
                                        <div class="progress-info">
                                            <div class="progress">
                                                <span style="width: 100%;" class="progress-bar theme-bg"></span>
                                            </div>
                                            <div class="status">
                                                <div class="status-title"> Due Date </div>
                                                <div class="status-number"> Wed Jun 20, 2020 </div>
                                            </div>
                                        </div>
                                        <input type="hidden" class="project-item-check" value="0">
                                    </div>
                                </div>

                                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                    <div class="dashboard-stat2 project-item">
                                        <div class="display">
                                            <div class="number">
                                                <h5 class="font-theme project-item-name">
                                                    PROJECT NAME
                                                </h5>
                                            </div>
                                            <div class="icon">
                                                <i class="icon-check"></i>
                                            </div>
                                        </div>
                                        <div class="progress-info">
                                            <div class="progress">
                                                <span style="width: 100%;" class="progress-bar theme-bg"></span>
                                            </div>
                                            <div class="status">
                                                <div class="status-title"> Due Date </div>
                                                <div class="status-number"> Wed Jun 20, 2020 </div>
                                            </div>
                                        </div>
                                        <input type="hidden" class="project-item-check" value="0">
                                    </div>
                                </div>

                                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                    <div class="dashboard-stat2 project-item">
                                        <div class="display">
                                            <div class="number">
                                                <h5 class="font-theme project-item-name">
                                                    PROJECT NAME
                                                </h5>
                                            </div>
                                            <div class="icon">
                                                <i class="icon-check"></i>
                                            </div>
                                        </div>
                                        <div class="progress-info">
                                            <div class="progress">
                                                <span style="width: 100%;" class="progress-bar theme-bg"></span>
                                            </div>
                                            <div class="status">
                                                <div class="status-title"> Due Date </div>
                                                <div class="status-number"> Wed Jun 20, 2020 </div>
                                            </div>
                                        </div>
                                        <input type="hidden" class="project-item-check" value="0">
                                    </div>
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
    <script>

    </script>
@endsection
