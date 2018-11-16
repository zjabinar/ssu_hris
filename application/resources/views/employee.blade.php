<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>{{app_config('AppTitle')}}</title>
    <link rel="icon" type="image/x-icon"  href="<?php echo asset(app_config('AppFav')); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    {{--Global StyleSheet Start--}}
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,300,500,700' rel='stylesheet' type='text/css'>
    {!! Html::style("assets/libs/bootstrap/css/bootstrap.min.css") !!}
    {!! Html::style("assets/libs/bootstrap-toggle/css/bootstrap-toggle.min.css") !!}
    {!! Html::style("assets/libs/font-awesome/css/font-awesome.min.css") !!}
    {!! Html::style("assets/libs/alertify/css/alertify.css") !!}
    {!! Html::style("assets/libs/alertify/css/alertify-bootstrap-3.css") !!}
    {!! Html::style("assets/libs/bootstrap-select/css/bootstrap-select.min.css") !!}

    {{--Custom StyleSheet Start--}}

    @yield('style')

    {{--Global StyleSheet End--}}

    {!! Html::style("assets/css/style.css") !!}
    {!! Html::style("assets/css/admin.css") !!}
    {!! Html::style("assets/css/responsive.css") !!}


</head>



<body class="has-left-bar has-top-bar">

<nav id="left-nav" class="left-nav-bar">
    <div class="nav-top-sec">
        <div class="app-logo">
            <img src="<?php echo asset(app_config('AppLogo')); ?>" alt="logo" class="bar-logo">
        </div>

        <a href="#" id="bar-setting" class="bar-setting"><i class="fa fa-bars"></i></a>
    </div>
    <div class="nav-bottom-sec">
        <ul class="left-navigation" id="left-navigation">

            {{--Dashboard--}}
            <li @if(Request::path()== 'employee/dashboard') class="active" @endif><a href="{{url('employee/dashboard')}}"><span class="menu-text">Dashboard</span> <span class="menu-thumb"><i class="fa fa-dashboard"></i></span></a></li>


 		<li @if(Request::path()== 'employee/edit-pds') class="active" @endif><a href="{{url('employee/edit-pds')}}"><span class="menu-text">Personal Data Sheet</span> <span class="menu-thumb"><i class="fa fa-edit"></i></span></a></li>

            
            
		<!-- Payroll Tab Group-->
            <li class="has-sub @if(Request::path()== 'payroll/employee-payslip' OR Request::path()=='payroll/employe-loan') sub-open init-sub-open @endif">
                <a href="#"><span class="menu-text">Payroll</span> <span class="arrow"></span><span class="menu-thumb"><i class="fa fa-envelope"></i></span></a>
                <ul class="sub">

                    <li @if(Request::path()== 'payroll/employee-payslip'  OR Request::path()=='payroll/employee-payslip/'.view_id()) class="active" @endif><a href={{url('payroll/employee-payslip')}}><span class="menu-text">Payroll Payslip</span> <span class="menu-thumb"><i class="fa fa-list"></i></span></a></li>

                    <li @if(Request::path()== 'payroll/employe-loan') class="active" @endif><a href={{url('payroll/employe-loan')}}><span class="menu-text">Loans</span> <span class="menu-thumb"><i class="fa fa-plus"></i></span></a></li>
                    <li @if(Request::path()== 'payroll/payment-index') class="active" @endif><a href={{url('payroll/payment-index')}}><span class="menu-text">Paymen Index</span> <span class="menu-thumb"><i class="fa fa-money"></i></span></a></li>
                    
                 </ul>
            </li>


            @if(menu_access('Training'))
            {{--Training--}}
            <li class="has-sub @if(Request::path()=='training/employee-training' OR Request::path()=='training/view-employee-training/'.view_id() OR Request::path()=='training/employee-trainings' OR Request::path()=='training/training-needs-assessment'  OR Request::path()=='training/view-training-needs-assessment/'.view_id() OR Request::path()== 'training/training-needs-assessment' OR Request::path()=='training/view-training-needs-assessment/'.view_id() OR Request::path()== 'training/trainers' OR Request::path()=='training/view-trainers-info/'.view_id() OR Request::path()== 'training/evaluations' OR Request::path()=='training/view-evaluations-info/'.view_id() OR Request::path()=='training/training-events' OR Request::path()=='training/view-training-events/'.view_id()) sub-open init-sub-open @endif">
                <a href="#"><span class="menu-text">Trainings</span> <span class="arrow"></span><span class="menu-thumb"><i class="fa fa-graduation-cap"></i></span></a>
                <ul class="sub">

                        <!-- <?php if (\Auth::user()->user_name=='admin'){ ?>
                            <li @if(Request::path()== 'training/employee-trainings' OR Request::path()=='training/view-employee-trainings/'.view_id()) class="active" @endif><a href={{url('training/employee-trainings')}}><span class="menu-text"> All Employee Trainings</span> <span class="menu-thumb"><i class="fa fa-graduation-cap"></i></span></a></li>
                       <?php }elseif (\Auth::user()->role_id==2){ ?>
                            <li @if(Request::path()== 'training/employee-trainings' OR Request::path()=='training/view-employee-trainings/'.view_id()) class="active" @endif><a href={{url('training/employee-trainings')}}><span class="menu-text"> All Employee Trainings</span> <span class="menu-thumb"><i class="fa fa-graduation-cap"></i></span></a></li>
                        <?php } ?> -->

                    <li @if(Request::path()== 'training/employee-training' OR Request::path()=='training/view-employee-training/'.view_id()) class="active" @endif><a href={{url('training/employee-training')}}><span class="menu-text">Trainings </span> <span class="menu-thumb"><i class="fa fa-graduation-cap"></i></span></a></li>


                    <li @if(Request::path()== 'training/training-needs-assessment' OR Request::path()=='training/view-training-needs-assessment/'.view_id()) class="active" @endif><a href={{url('training/training-needs-assessment')}}><span class="menu-text">Training Needs</span> <span class="menu-thumb"><i class="fa fa-search-plus"></i></span></a></li>

                    <li @if(Request::path()== 'training/training-events' OR Request::path()=='training/view-training-events/'.view_id()) class="active" @endif><a href={{url('training/training-events')}}><span class="menu-text">{{language_data('Training Events')}}</span> <span class="menu-thumb"><i class="fa fa-calendar"></i></span></a></li>

                    <!-- <li @if(Request::path()== 'training/trainers' OR Request::path()=='training/view-trainers-info/'.view_id()) class="active" @endif><a href={{url('training/trainers')}}><span class="menu-text">{{language_data('Trainers')}}</span> <span class="menu-thumb"><i class="fa fa-users"></i></span></a></li> -->

                    <li @if(Request::path()== 'training/evaluations' OR Request::path()=='training/view-evaluations-info/'.view_id()) class="active" @endif><a href={{url('training/evaluations')}}><span class="menu-text">{{language_data('Training Evaluations')}}</span> <span class="menu-thumb"><i class="fa fa-clipboard"></i></span></a></li>


                </ul>
            </li>
            @endif

            <li class="has-sub @if(Request::path()== 'ipcr/periods' OR Request::path()=='ipcr/groups' OR Request::path()=='ipcr/employee' OR Request::path()=='ipcr/supervisory') sub-open init-sub-open @endif">
                <a href="#"><span class="menu-text">Performance Evaluation</span> <span class="arrow"></span><span class="menu-thumb"><i class="fa fa-envelope"></i></span></a>
                <ul class="sub">
                    {{-- <li @if(Request::path()== 'ipcr/periods'  OR Request::path()=='ipcr/periods/'.view_id()) class="active" @endif><a href={{url('ipcr/periods')}}><span class="menu-text">IPCR Rating Periods</span> <span class="menu-thumb"><i class="fa fa-list"></i></span></a></li>
                    <li @if(Request::path()== 'ipcr/groups'  OR Request::path()=='ipcr/groups/'.view_id()) class="active" @endif><a href={{url('ipcr/groups')}}><span class="menu-text">Group and Members</span> <span class="menu-thumb"><i class="fa fa-list"></i></span></a></li> --}}
                    <li @if(Request::path()== 'ipcr/employee'  OR Request::path()=='ipcr/employee/'.view_id()) class="active" @endif><a href={{url('ipcr/employee')}}><span class="menu-text">My IPCR</span> <span class="menu-thumb"><i class="fa fa-list"></i></span></a></li>
                    <?php 
                        $supervisor = App\IpcrGroupsMember::where('employee_id',Auth::user()->id)->get();
                    ?>
                    @if(count($supervisor)>0)
                        <li @if(Request::path()== 'ipcr/supervisory'  OR Request::path()=='ipcr/supervisory/'.view_id()) class="active" @endif><a href={{url('ipcr/supervisory')}}><span class="menu-text">Supervisory</span> <span class="menu-thumb"><i class="fa fa-list"></i></span></a></li>
                    @endif
                    
                    <li @if(Request::path()== 'ipcr/reports'  OR Request::path()=='ipcr/supervisory/'.view_id()) class="active" @endif><a href=#><span class="menu-text">Reports</span> <span class="menu-thumb"><i class="fa fa-list"></i></span></a></li>
                </ul>
            </li>
            
            @if(menu_access('Leave'))
            {{--Leave--}}
            <li @if(Request::path()== 'employee/leave') class="active" @endif><a href="{{url('employee/leave')}}"><span class="menu-text">{{language_data('Leave')}}</span> <span class="menu-thumb"><i class="fa fa-bed"></i></span></a></li>
            @endif
            
            {{--SALN--}}
            <li @if(Request::path()== 'employee/edit-profile') class="active" @endif><a href="{{url('employee/edit-saln')}}"><span class="menu-text">SALN</span> <span class="menu-thumb"><i class="fa fa-sticky-note"></i></span></a></li>
            
           
            @if(menu_access('Job Application'))
                {{--Job--}}
                <!-- <li class="has-sub @if(Request::path()== 'jobs/edit' OR Request::path()=='reports/job-applicants' OR Request::path()=='jobs') sub-open init-sub-open @endif">
                    <a href="#"><span class="menu-text">Job Recruitment</span> <span class="arrow"></span><span class="menu-thumb"><i class="fa fa-calendar"></i></span></a>
                    <ul class="sub">

                        <li @if(Request::path()== 'jobs'  OR Request::path()=='jobs/edit/'.view_id() OR Request::path()=='jobs/view-applicant/'.view_id()) class="active" @endif><a href="{{url('jobs')}}"><span class="menu-text">Job Vacancy</span> <span class="menu-thumb"><i class="fa fa-suitcase"></i></span></a></li>

                    </ul>
                </li> -->
            @endif

           





            @if(menu_access('Award'))
            {{--Award--}}
            <li @if(Request::path()== 'employee/award') class="active" @endif><a href="{{url('employee/award')}}"><span class="menu-text">{{language_data('Award')}}</span> <span class="menu-thumb"><i class="fa fa-trophy"></i></span></a></li>
            @endif

            @if(menu_access('Notice Board'))
            {{--Notice Board--}}
            <li @if(Request::path()== 'employee/notice-board') class="active" @endif><a href="{{url('employee/notice-board')}}"><span class="menu-text">{{language_data('Notice Board')}}</span> <span class="menu-thumb"><i class="fa fa-sticky-note"></i></span></a></li>
            @endif

        <li @if(Request::path()== 'employee/edit-profile') class="active" @endif><a href="{{url('employee/edit-profile')}}"><span class="menu-text">Account Credential</span> <span class="menu-thumb"><i class="fa fa-sticky-note"></i></span></a></li>
     
        </ul>
    </div>
</nav>

<main id="wrapper" class="wrapper">

    <div class="top-bar clearfix">
        <ul class="top-info-bar">
            <li class="dropdown bar-notification @if(count(latest_five_employee_leave_application())>0) active @endif">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-bed"></i></a>
                <ul class="dropdown-menu user-dropdown arrow" role="menu">
                    <li class="title">{{language_data('Recent 5 Leave Applications')}}</li>

                    @foreach(latest_five_employee_leave_application() as $l)
                    <li>
                        <a href="{{url('leave/edit/'.$l->id)}}">
                            @if($l->employee_id->avatar!='')
                                <img class="user-thumb" src="<?php echo asset('assets/employee_pic/'.$l->employee_id->avatar); ?>" alt="{{$l->employee_id->firstname}} {{$l->employee_id->lastname}}">
                            @else
                                <img class="user-thumb" src="<?php echo asset('assets/employee_pic/user.png'); ?>" alt="{{$l->employee_id->firstname}} {{$l->employee_id->lastname}}">
                            @endif

                            <div class="user-name">{{$l->employee_id->firstname}} {{$l->employee_id->lastname}}</div>
                        </a>
                    </li>

                    @endforeach

                    <li class="footer"><a href="{{url('employee/leave')}}">{{language_data('See All Applications')}}</a></li>
                </ul>
            </li>

            <li class="dropdown bar-notification @if(count(latest_five_employee_tickets())>0) active @endif">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-envelope"></i></a>
                <ul class="dropdown-menu arrow message-dropdown" role="menu">
                    <li class="title">{{language_data('Recent 5 Pending Tickets')}}</li>
                    @foreach(latest_five_employee_tickets() as $st)
                    <li>
                        <a href="{{url('employee/support-tickets/view-ticket/'.$st->id)}}">
                            <div class="name">{{$st->name}} <span>{{$st->date}}</span></div>
                            <div class="message">{{$st->subject}}</div>
                        </a>
                    </li>

                    @endforeach

                    <li class="footer"><a href="{{url('employee/support-tickets/all')}}">{{language_data('See All Tickets')}}</a></li>
                </ul>
            </li>
        </ul>

       <div class="navbar-right">

<div class="clearfix">


    <div class="dropdown user-profile pull-right">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
            <span class="user-info">{{Auth::user()->firstname}} {{Auth::user()->lastname}}</span>

            @if(Auth::user()->avatar!='')
                <img class="user-image" src="<?php echo asset('assets/employee_pic/'.Auth::user()->avatar); ?>" alt="{{Auth::user()->firstname}} {{Auth::user()->lastname}}">
            @else
                <img class="user-image" src="<?php echo asset('assets/employee_pic/user.png'); ?>" alt="{{Auth::user()->firstname}} {{Auth::user()->lastname}}">
            @endif

        </a>
        <ul class="dropdown-menu arrow right-arrow" role="menu">
            <li><a href="{{url('user/edit-profile')}}"><i class="fa fa-edit"></i>{{language_data('Update Profile')}}</a></li>
            <li><a href="{{url('user/change-password')}}"><i class="fa fa-lock"></i>{{language_data('Change Password')}}</a></li>
            <li class="bg-dark">
                <a href="{{url('user/logout')}}" class="clearfix">
                    <span class="pull-left">{{language_data('Logout')}}</span>
                    <span class="pull-right"><i class="fa fa-power-off"></i></span>
                </a>
            </li>
        </ul>
    </div>



    @if(Auth::user()->role_id==2)
    <div class="top-info-bar m-r-10">

        <div class="pull-right">
            <a href="{{url('dashboard')}}" class="btn btn-success btn-sm" aria-expanded="false">Admin Portal</a>
        </div>
    </div>
    @endif

    



</div>

</div>
    </div>

    {{--Content File Start Here--}}

    @yield('content')

    {{--Content File End Here--}}

    <input type="hidden" id="_url" value="{{url('/')}}">
    <input type="hidden" id="_DatePicker" value="{{app_config('DateFormat')}}">
</main>

{{--Global JavaScript Start--}}
{!! Html::script("assets/libs/jquery-1.10.2.min.js") !!}
{!! Html::script("assets/libs/jquery.slimscroll.min.js") !!}
{!! Html::script("assets/libs/bootstrap/js/bootstrap.min.js") !!}
{!! Html::script("assets/libs/bootstrap-toggle/js/bootstrap-toggle.min.js") !!}
{!! Html::script("assets/libs/alertify/js/alertify.js") !!}
{!! Html::script("assets/libs/bootstrap-select/js/bootstrap-select.min.js") !!}
{!! Html::script("assets/js/scripts.js") !!}
{{--Global JavaScript End--}}

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-Token': $('input[name="_token"]').val()
        }
    });
    

    
    	var width = $(window).width();
	$(window).resize(function () {
	    if ($(window).width() <= '620') {
	        $('body').removeClass('no-nav-animation left-bar-open');
//	        alert("hi: " + $(window).width() );
	    }else{
	    	$('body').addClass('no-nav-animation left-bar-open');
//	    	alert("hello: " + $(window).width() );
	    }
	});
	if ($(window).width() <= '620') {
	        $('body').removeClass('no-nav-animation left-bar-open');
//	        alert("hi: " + $(window).width() );
	    }else{
	    	$('body').addClass('no-nav-animation left-bar-open');
//	    	alert("hello: " + $(window).width() );
	    }

</script>

{{--Custom JavaScript Start--}}

@yield('script')

{{--Custom JavaScript End Here--}}
<script>

</script>
</body>

</html>
