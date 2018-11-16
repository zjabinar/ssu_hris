@extends(session('portal'))

{{--External Style Section--}}
@section('style')
    {!! Html::style("assets/libs/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css") !!}
    {!! Html::style("assets/libs/data-table/datatables.min.css") !!}
@endsection


@section('content')

    <section class="wrapper-bottom-sec">
        <div class="p-10">
            {{--  <h2 class="page-title">{{language_data('Leave Application')}}</h2>  --}}
        </div>
        <div class="p-30 p-t-none p-b-none">
            @include('notification.notify')
            <div class="row">

                <div class="col-lg-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <h2 class="panel-title">Leave Application {{$status}}</h2>
                            <button class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#new-leave"><i class="fa fa-plus"></i> {{language_data('New Leave')}}
                            </button>
                            <br>
                        </div>
                        <div class="panel-body p-none">
                            <table class="table data-table table-hover table-ultra-responsive">
                                <thead>
                                <tr>
                                    <th style="width: 5%;">No.</th>
                                    <th style="width: 20%;">{{language_data('Employee')}}</th>
                                    <th style="width: 20%;">{{language_data('Leave Type')}}</th>
                                    <th style="width: 13%;">Applied</th>
                                    <th style="width: 13%;">From</th>
                                    <th style="width: 13%;">To</th>
                                    <th style="width: 13%;">Days</th>
                                    <th style="width: 10%;">{{language_data('Status')}}</th>
                                    <th style="width: 10%;">{{language_data('Actions')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $no = 1; ?>
                                @foreach($leave as $d)
                                    <tr>
                                        <td style="padding: 8px;" data-label="SL">{{$no}}.</td>
                                        <td style="padding: 8px;" data-label="emoployeCode"><p><a href="{{url('leave/edit/'.$d->id)}}"> {{$d->employee_id->fullname}}</a></p></td>
                                        <td style="padding: 8px;" data-label="leaveType"><p>{{$d->leave_type->leave}}</p></td>
                                        <td style="padding: 8px;" data-label="LeaveFrom"><p>{{$d->applied_on}}</p></td>
                                        <td style="padding: 8px;" data-label="LeaveFrom"><p>{{$d->leave_from}}</p></td>
                                        <td style="padding: 8px;" data-label="LeaveTo"><p>{{$d->leave_to}}</p></td>
                                        <td style="padding: 8px;" data-label="LeaveTo"><p>{{$d->days}}</p></td>
                                        @if($d->status=='approved')
                                            <td style="padding: 8px;" data-label="Status"><p class="btn btn-success btn-xs">{{language_data('Approved')}}</p></td>
                                        @elseif($d->status=='pending')
                                            <td style="padding: 8px;" data-label="Status"><p class="btn btn-warning btn-xs">{{language_data('Pending')}}</p></td>
                                        @else
                                            <td style="padding: 8px;" data-label="Status"><p class="btn btn-danger btn-xs">{{language_data('Rejected')}}</p></td>
                                        @endif

                                        <td style="padding: 8px;" data-label="Actions">
                                            <a class="btn btn-success btn-xs" href="{{url('leave/edit/'.$d->id)}}"><i class="fa fa-eye"></i> {{language_data('View')}}</a>
                                            {{-- <a href="#" class="btn btn-danger btn-xs cdelete" id="{{$d->id}}"><i class="fa fa-trash"></i> {{language_data('Delete')}}</a> --}}
                                        </td>
                                    </tr>
                                    <?php $no++; ?>

                                @endforeach

                                </tbody>
                            </table>
                        </div>


                        <!-- Modal -->
                        <div class="modal fade" id="new-leave" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="myModalLabel">{{language_data('Add')}} {{language_data('New Leave')}}</h4>
                                    </div>
                                    <form class="form-some-up" role="form" method="post" action="{{url('leave/post-new-leave')}}">

                                        <div class="modal-body">

                                            <div class="form-group">
                                                <label>{{language_data('Employee')}}</label>
                                                <select name="employee" class="form-control selectpicker" data-live-search="true">
                                                    @foreach($employee as $e)
                                                        <option value="{{$e->id}}">{{$e->firstname}} {{$e->lastname}}</option>
                                                    @endforeach
                                                </select>
                                            </div>


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
                                                <label>{{language_data('Status')}}</label>
                                                <select class="selectpicker form-control" name="status">
                                                    <option value="approved">{{language_data('Approved')}}</option>
                                                    <option value="pending" selected>{{language_data('Pending')}}</option>
                                                    <option value="rejected">{{language_data('Rejected')}}</option>
                                                </select>
                                            </div>


                                            <div class="form-group">
                                                <label>{{language_data('Leave Reason')}}</label>
                                                <textarea class="form-control" rows="5" name="leave_reason"></textarea>
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
                </div>

            </div>


        </div>
    </section>

@endsection

{{--External Style Section--}}
@section('script')
    {!! Html::script("assets/libs/handlebars/handlebars.runtime.min.js")!!}
    {!! Html::script("assets/libs/moment/moment.min.js")!!}
    {!! Html::script("assets/libs/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js")!!}
    {!! Html::script("assets/libs/data-table/datatables.min.js")!!}
    {!! Html::script("assets/js/form-elements-page.js")!!}
    {!! Html::script("assets/js/bootbox.min.js")!!}

    <script>
        $(document).ready(function () {
            /*For DataTable*/
            $('.data-table').DataTable();

            /*For Delete Job Info*/
            $(".cdelete").click(function (e) {
                e.preventDefault();
                var id = this.id;
                bootbox.confirm("Are you sure?", function (result) {
                    if (result) {
                        var _url = $("#_url").val();
                        window.location.href = _url + "/leave/delete-leave-application/" + id;
                    }
                });
            });


        });
    </script>
@endsection
