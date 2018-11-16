@extends('master')

@section('content')

    <section class="wrapper-bottom-sec">
        <div class="p-10"></div>
        <div class="p-15 p-t-none p-b-none m-l-10 m-r-10">
        @include('notification.notify')
        </div>
        <div class="row">

            <div class="col-lg-12">
                <div class="panel-body">
                    <div class="row text-center">

                        <div class="col-sm-3 m-b-15">
                            <div class="z-shad-1">
                                <div class="bg-success text-white p-15 clearfix">
                                    <span class="pull-left font-45 m-l-10"><i class="fa fa-users"></i></span>

                                    <div class="pull-right text-right m-t-15">
                                        <span class="small m-b-5 font-15">{{$employee}} {{language_data('Employees')}}</span>
                                        <br>
                                        <a href="{{url('employees/add')}}" class="btn btn-complete btn-xs text-uppercase">{{language_data('Add New')}}</a>
                                    </div>

                                </div>
                            </div>
                        </div>


                        <div class="col-sm-3 m-b-15">
                            <div class="z-shad-1">
                                <div class="bg-complete text-white p-15 clearfix">
                                    <span class="pull-left font-45 m-l-10"><i class="fa fa-bed"></i></span>

                                    <div class="pull-right text-right m-t-15">
                                        <span class="small m-b-5 font-15">{{$leave}} {{language_data('Leave Application')}}</span>
                                        <br>
                                        <a href="{{url('leave')}}" class="btn btn-success btn-xs text-uppercase">{{language_data('View All')}}</a>
                                    </div>

                                </div>
                            </div>
                        </div>


                        <div class="col-sm-3 m-b-15">
                            <div class="z-shad-1">
                                <div class="bg-primary text-white p-15 clearfix">
                                    <span class="pull-left font-45 m-l-10"><i class="fa fa-bar-chart"></i></span>

                                    <div class="pull-right text-right m-t-15">
                                        <span class="small m-b-5 font-15">{{$trainings_upcoming}} Upcoming Trainings</span>
                                        <br>
                                        <a href="{{url('training/training-events')}}" class="btn btn-complete btn-xs text-uppercase">{{language_data('View All')}}</a>
                                    </div>

                                </div>
                            </div>
                        </div>


                        <div class="col-sm-3 m-b-15">
                            <div class="z-shad-1">
                                <div class="bg-complete-darker text-white p-15 clearfix">
                                    <span class="pull-left font-45 m-l-10"><i class="fa fa-envelope"></i></span>

                                    <div class="pull-right text-right m-t-15">
                                        <span class="small m-b-5 font-15">{{$notice_published}} Notice</span>
                                        <br>
                                        <a href="{{url('notice-board')}}"
                                           class="btn btn-success btn-xs text-uppercase">{{language_data('View All')}}</a>
                                    </div>

                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>




        <div class="p-15 p-t-none p-b-none">
            <div class="row">

                <div class="col-lg-12">
                    <div class="panel-body">
                        <div class="row">
                            <div class="panel">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><span style="font-weight: bold;font-size: 15px">Recent Leave Application</span></h3>
                                </div>
                                <div class="panel-body p-none">
                                    <table class="table table-hover table-ultra-responsive">
                                        <thead>
                                        <tr>
                                            <th style="width: 10px;">No.</th>
                                            <th style="width: 30px;">Employee</th>
                                            <th style="width: 30px;">Type</th>
                                            <th style="width: 10px;">From</th>
                                            <th style="width: 10px;">To</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $no = 1; ?>
                                        @foreach($leave_application as $la)
                                            <tr>
                                                <td style="padding: 8px;" data-label="SL">
                                                    <p><a href="{{url('leave/edit/'.$la->id)}}">{{$no}}</a></p>
                                                </td>
                                                <td style="padding: 8px;" data-label="employee">
                                                    <p>
                                                        <a href="{{url('leave/edit/'.$la->id)}}"> {{$la->employee_id->fullname}}</a>
                                                    </p>
                                                </td>
                                                <td data-label="leave type">
                                                    <p>{{$la->leave_type->leave}}</p>
                                                </td>
                                                <td style="padding: 8px;" data-label="leave from">
                                                    <p>{{$la->leave_from}}</p>
                                                </td>
                                                <td style="padding: 8px;" data-label="leave to">
                                                    <p>{{$la->leave_to}}</p>
                                                </td>
                                            </tr>
                                            <?php $no++; ?>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel-body">
                        <div class="row">
                            <div class="panel">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><span style="font-weight: bold;font-size: 15px">Upcoming Trainings</span></h3>
                                </div>
                                <div class="panel-body p-none">
                                    <table class="table table-hover table-ultra-responsive">
                                        <thead>
                                        <tr>
                                            <th style="width: 30px;">Subject</th>
                                            <th style="width: 30px;">Venue</th>
                                            <th style="width: 20px;">Date From</th>
                                            <th style="width: 20px;">Date To</th>
                                            <th style="width: 20px;">Sponsored by</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        @foreach($trainings_list as $tl)
                                            <tr>
                                                <td style="padding: 8px;" data-label="Subject">
                                                    <p>
                                                        <a href="{{url('training/view-training-events/'.$tl->id)}}"> {{$tl->title}}</a>
                                                    </p>
                                                </td>
                                                <td style="padding: 8px;" data-label="Venue">
                                                    <p>
                                                        {{$tl->training_location}}
                                                    </p>
                                                </td>
                                                <td style="padding: 8px;" data-label="Date to">
                                                    <p>{{get_date_format($tl->training_from)}}</p>
                                                </td>
                                                <td style="padding: 8px;" data-label="Date to">
                                                    <p>{{get_date_format($tl->training_to)}}</p>
                                                </td>
                                                <td style="padding: 8px;" data-label="amount">
                                                    <p>{{$tl->sponsored_by}}</p>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>


        <div class="p-15 p-t-none p-b-none">
            <div class="row">

                <div class="col-lg-6">
                    <div class="panel-body">
                        <div class="row">
                            <div class="panel">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><span style="font-weight: bold;font-size: 15px">Payroll Period</span></h3>
                                </div>
                                <div class="panel-body p-none">
                                    <table class="table table-hover table-ultra-responsive">
                                        <thead>
                                        <tr>
                                            <th style="width: 65px;">Description</th>
                                            <th style="width: 15px;">Payroll Type</th>
                                            <th style="width: 7px;">Year</th>
                                            <th style="width: 7px;">Month</th>
                                            <th style="width: 15px;">Remarks</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        @foreach($payroll_period as $pp)
                                            <tr>
                                                <td style="padding: 8px;" data-label="Description">
                                                    <p>{{$pp->description}}</p>
                                                </td>
                                                <td style="padding: 8px;" data-label="Payroll Type">
                                                    <p>{{$pp->payroll_type}}</p>
                                                </td>
                                                <td style="padding: 8px;" data-label="Year">
                                                    <p>{{$pp->fsyear}}</p>
                                                </td>
                                                <td style="padding: 8px;" data-label="Month">
                                                    <p>{{$pp->sponsored_by}}</p>
                                                </td>
                                                <td style="padding: 8px;" data-label="Remarks">
                                                    <p>{{$pp->Remarks}}</p>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="panel-body">
                        <div class="row">
                            <div class="panel">
                                <div class="panel-heading">
                                    <h3 class="panel-title"><span style="font-weight: bold;font-size: 15px"> Notice Board</span></h3>
                                </div>
                                <div class="panel-body p-none">
                                    <table class="table table-hover table-ultra-responsive">
                                        <thead>
                                        <tr>
                                            <th style="width: 30px;">Title</th>
                                            <th style="width: 50px;">Description</th>
                                            <th style="width: 20px;">Status</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($notice_list as $nl)
                                            <tr>
                                                <td data-label="email">
                                                    <p>{{$nl->title}}</p>
                                                </td>
                                                <td data-label="subject">
                                                    <p>{{$nl->title}}</p>
                                                </td>
                                                <td data-label="date">
                                                    <p>{{$nl->status}}</p>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>


    </section>

@endsection


{{--External Style Section--}}
@section('script')

    {!! Html::script("assets/js/highcharts.js")!!}

    <script>
        $(document).ready(function () {

            var get_expense = <?php echo $get_expense; ?>;

            var get_expense_data = [
                { month: 'Jan', val: [] },
                { month: 'Feb', val: [] },
                { month: 'Mar', val: [] },
                { month: 'Apr', val: [] },
                { month: 'May', val: [] },
                { month: 'Jun', val: [] },
                { month: 'Jul', val: [] },
                { month: 'Aug', val: [] },
                { month: 'Sep', val: [] },
                { month: 'Oct', val: [] },
                { month: 'Nov', val: [] },
                { month: 'Dec', val: [] }
            ];

            get_expense.forEach( function( item ) {
                get_expense_data[new Date(item.purchase_date).getMonth()].val.push( Number(item.amount) );
            });


            get_expense_data = get_expense_data.map( function( item ) {
                if ( item.val.length > 0 ) {
                    item.val = item.val.reduce(function(a, b) {
                        return a+b;
                    });
                } else {
                    item.val = 0;
                }

                return item;
            });

            var get_expense_months = get_expense_data.map(function(item){
                return item.month;
            });

            var get_expense_amounts = get_expense_data.map(function(item){
                return item.val;
            });


            Highcharts.chart('supportTickets', {
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie'
                },
                title: {
                    text: ''
                },
                credits: {
                    enabled: false
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.y}</b>'
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            format: '<b>{point.name}</b>: {point.y}',
                            style: {
                                color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                            }
                        }
                    }
                },
                series: [{
                    name: 'SupportTickets',
                    colorByPoint: true,
                    data: [{
                        name: 'Pending',
                        y: <?php echo $st_pending;?>
                    }, {
                        name: 'Closed',
                        y: <?php echo $st_closed;?>
                    }, {
                        name: 'Customer Reply',
                        y: <?php echo $st_replied; ?>
                    }, {
                        name: 'Answered',
                        y: <?php echo $st_answered; ?>
                    }]
                }]
            });


            Highcharts.chart('expense', {

                title: {
                    text: ''
                },

                credits: {
                    enabled: false
                },

                xAxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
                },

                yAxis: {
                    title: {
                        text: 'Expense Amount'
                    }
                },
                plotOptions: {
                    series: {
                        dataLabels: {
                            enabled: false,
                            borderRadius: 5,
                            backgroundColor: 'rgba(252, 255, 197, 0.7)',
                            borderWidth: 1,
                            borderColor: '#AAA',
                            y: -6
                        }
                    }
                },

                series: [{
                    name: 'Expense',
                    data: get_expense_amounts
                }]

            });

        });
    </script>
@endsection