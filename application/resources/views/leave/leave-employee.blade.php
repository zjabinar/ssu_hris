@extends(session('portal'))

{{--External Style Section--}}
@section('style')
    {!! Html::style("assets/libs/data-table/datatables.min.css") !!}
    {!! Html::style("assets/libs/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css") !!}
    {!! Html::style("assets/libs/bootstrap3-wysihtml5-bower/bootstrap3-wysihtml5.min.css") !!}
@endsection


@section('content')

    <section class="wrapper-bottom-sec">
        <div class="p-30">
            <h2 class="page-title">{{language_data('Leave Application')}}</h2>
        </div>
        <div class="p-30 p-t-none p-b-none">
            @include('notification.notify')
            <div class="row">

                <div class="col-lg-3">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">Leave Balance</h3>
                        </div>
                        <div class="panel-body p-none">
                            <table class="table table-hover">
                                <tr>
                                    <td>Vacation Leave (VL)</td><td>{{$balance_vl}}</td>
                                </tr>
                                <tr>
                                    <td>Sick Leave (SL) </td><td>{{$balance_sl}}</td>
                                </tr>
                                <tr>
                                    <td>Leave Balance</td><td>{{$total_balance}}</td>
                                </tr>
                                <tr><td colspan="2"><a class="btn btn-primary btn-xs" href={{url('leave-ledger/'. \Auth::user()->id)}}>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Leave Ledger&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></td></tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">{{language_data('Leave Application')}}</h3>
                            <button class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#new-leave"><i class="fa fa-plus"></i> {{language_data('New Leave')}}
                            </button>
                            <br>
                        </div>
                        <div class="panel-body p-none">
                            <table class="table data-table table-hover table-ultra-responsive">
                                <thead>
                                <tr>
                                    <th style="width: 5%;">No.</th>
                                    <th style="width: 25%;">{{language_data('Leave Type')}}</th>
                                    <th style="width: 15%;">Applied</th>
                                    <th style="width: 15%;">From</th>
                                    <th style="width: 15%;">To</th>
                                    <th style="width: 10%;">Days</th>
                                    <th style="width: 10%;">Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $no = 1; ?>
                                @foreach($leave as $d)
                                    <tr>
                                        <td style="padding: 8px;" data-label="SL">{{$no}}.</td>
                                        <td style="padding: 8px;" data-label="leaveType"><p>{{$d->leave_type->leave}}</p></td>
                                        <td style="padding: 8px;" data-label="leaveType"><p>{{$d->applied_on}}</p></td>
                                        <td style="padding: 8px;" data-label="LeaveFrom"><p>{{$d->leave_from}}</p></td>
                                        <td style="padding: 8px;" data-label="LeaveTo"><p>{{$d->leave_to}}</p></td>
                                        <td style="padding: 8px;" data-label="remark">
                                                {{$d->days}}
                                            </td>
                                        @if($d->status=='approved')
                                            <td style="padding: 8px;" data-label="Status"><p class="btn btn-success btn-xs">{{language_data('Approved')}}</p></td>
                                        @elseif($d->status=='pending')
                                            <td style="padding: 8px;" data-label="Status"><p class="btn btn-warning btn-xs">{{language_data('Pending')}}</p></td>
                                        @else
                                            <td style="padding: 8px;" data-label="Status"><p class="btn btn-danger btn-xs">{{language_data('Rejected')}}</p></td>
                                        @endif
                                        <td style="padding: 8px;" data-label="Actions">
                                            <a class="btn btn-success btn-xs" href="{{url('leave/edit/'.$d->id)}}"><i class="fa fa-eye"></i> {{language_data('View')}}</a>
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

            <!-- Modal -->
            <div class="modal fade" id="new-leave" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">{{language_data('Request For New Leave')}}</h4>
                        </div>
                        <form class="form-some-up" role="form" method="post" action="{{url('employee/leave/post-new-leave')}}">

                            <div class="modal-body">

                                <div class="form-group">
                                    <label>{{language_data('Leave Type')}}</label>
                                    <select name="leave_type" id="e20" class="form-control selectpicker" data-live-search="true">
                                        @foreach($leave_type as $lt)
                                            <option value="{{$lt->id}}">{{$lt->leave}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>{{language_data('Leave From')}}</label>
                                            <input type="text" class="form-control datePicker" name="leave_from" required="">
                                            <select class="form-control selectpicker" data-live-search="true" name="leave_from_ampm">
                                                <option value="morning" selected>morning</option>
                                                <option value="afternoon" >afternoon</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>{{language_data('Leave To')}}</label>
                                            <input type="text" class="form-control datePicker" name="leave_to" required="">
                                            <select class="form-control selectpicker" data-live-search="true" name="leave_to_ampm" required="">
                                                <option value="morning">morning</option>
                                                <option value="afternoon" selected>afternoon</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                             


                                <div class="form-group">
                                    <label>{{language_data('Leave Reason')}}</label>
                                    <textarea class="textarea form-control" style="height:70px;" name="leave_reason"></textarea>
                                </div>


                            </div>
                            <div class="modal-footer">
                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                <button type="button" class="btn btn-default" data-dismiss="modal">{{language_data('Close')}}</button>
                                <button type="submit" class="btn btn-primary">{{language_data('Send')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


        </div>
    </section>

@endsection

{{--External Style Section--}}
@section('script')
    {!! Html::script("assets/libs/moment/moment.min.js")!!}
    {!! Html::script("assets/libs/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js")!!}
    {!! Html::script("assets/libs/wysihtml5x/wysihtml5x-toolbar.min.js")!!}
    {!! Html::script("assets/libs/handlebars/handlebars.runtime.min.js")!!}
    {!! Html::script("assets/libs/bootstrap3-wysihtml5-bower/bootstrap3-wysihtml5.min.js")!!}
    {!! Html::script("assets/js/form-elements-page.js")!!}
    {!! Html::script("assets/libs/data-table/datatables.min.js")!!}
    {!! Html::script("assets/js/bootbox.min.js")!!}


    <script>
        $(document).ready(function () {
            /*For DataTable*/
            $('.data-table').DataTable();

            
        /*For Delete Job Info*/
        $(".cdelete").click(function (e) {
            e.preventDefault();
            var id = this.id;
            bootbox.confirm("Are you sure you want to delete this leave application?", function (result) {
                if (result) {
                    var _url = $("#_url").val();
                    window.location.href = _url + "/leave/delete-leave-application/" + id;
                }
            });
        });

        });
    </script>
@endsection
