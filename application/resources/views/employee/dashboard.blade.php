@extends('employee')

@section('content')

    <section class="wrapper-bottom-sec">
        <div class="p-10"></div>
        <div class="p-15 p-t-none p-b-none m-l-10 m-r-10">
        @include('notification.notify')
        </div>


        <div class="p-15 p-t-none p-b-none">
        
            
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


                <div class="col-lg-6">
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
                                            <th style="width: 5px;">No.</th>
                                            <th style="width: 40px;">Leave Type</th>
                                            <th style="width: 15px;">Status</th>
                                            <th style="width: 12px;">{{language_data('Leave From')}}</th>
                                            <th style="width: 12px;">{{language_data('Leave To')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $no=1; ?>
                                        @foreach($leave_application as $la)
                                            <tr>
                                                <td style="padding: 8px;" data-label="SL">
                                                    <p><a href="{{url('leave/edit/'.$la->id)}}">{{$no}}.</a></p>
                                                </td>
                                                <td style="padding: 8px;" data-label="Leave Type">
                                                    <p> {{$la->leave_type->leave}}</p>
                                                </td>
                                                <td data-label="Status">
                                                    <?php 
                                                        $lbl_status = "warning";
                                                        if ($la->status=="pending"){
                                                            $lbl_status = "warning";
                                                        }elseif($la->status=="approved"){
                                                            $lbl_status = "success";
                                                        }elseif($la->status=="rejected"){
                                                            $lbl_status = "danger";
                                                        }else{
                                                            $lbl_status = "warning";
                                                        }
                                                    ?>
                                                    <p><span class="btn btn-{{$lbl_status}} btn-xs">{{$la->status}}</span></p>
                                                </td>
                                                <td style="padding: 8px;" data-label="leave from">
                                                    <p>{{get_date_format($la->leave_from)}}</p>
                                                </td>
                                                <td style="padding: 8px;" data-label="leave to">
                                                    <p>{{get_date_format($la->leave_to)}}</p>
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
        </div>


    </section>

@endsection


{{--External Style Section--}}
@section('script')

{!! Html::script("assets/libs/bootstrap-calendar/js/underscore.js")!!}
{!! Html::script("assets/libs/bootstrap-calendar/js/calendar.min.js")!!}
{!! Html::script("assets/libs/handlebars/handlebars.runtime.min.js")!!}

<script>
    $(document).ready(function () {
        var _asset_url = $("#_asset_path").val() + '/';
        var _url = $("#_url").val();
        var calendar = $('#calendar').calendar({
            weekbox: false,
            tmpl_path: _asset_url,
            events_source: _url+'/employee/holiday/ajax-event-calendar',
            onAfterViewLoad: function(view) {
                $('#month').text(this.getTitle());
                $('.btn-group button').removeClass('active');
            }
        });

        $('.btn-group button[data-calendar-nav]').each(function () {
            var $this = $(this);
            $this.click(function () {
                calendar.navigate($this.data('calendar-nav'));
            });
        });


    });
</script>

@endsection

