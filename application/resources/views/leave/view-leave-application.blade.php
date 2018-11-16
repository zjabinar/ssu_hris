@extends(session('portal'))

{{--External Style Section--}}
@section('style')
    {!! Html::style("assets/libs/bootstrap3-wysihtml5-bower/bootstrap3-wysihtml5.min.css") !!}
@endsection

@section('content')

    <section class="wrapper-bottom-sec">
        <div class="p-15">
            <h2 class="page-title">{{language_data('View Application')}}</h2>
        </div>
        <div class="p-15 p-t-none p-b-none">

            @include('notification.notify')
            <div class="row">

                <div class="col-lg-6">
                    <div class="panel">
                        <div class="panel-body">
                            <form class="" role="form" action="{{url('leave/post-job-status')}}" method="post">
                                {{-- <div class="panel-heading">
                                    <h3 class="panel-title"> {{language_data('View Application')}}</h3>
                                </div> --}}

                                <div class="form-group">
                                    <label>{{language_data('Employee Name')}}</label>
                                    <input type="text" class="form-control" readonly value="{{$leave->employee_id->fullname}} ">
                                </div>

                                <div class="form-group">
                                    <label>{{language_data('Leave Type')}}</label>
                                    <input type="text" class="form-control" readonly value="{{$leave->leave_type->leave}}">
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>{{language_data('Leave From')}}</label>
                                            <input type="text" class="form-control" readonly value="{{$leave->leave_from}}">
                                            <input type="text" class="form-control" readonly value="{{$leave->leave_from_ampm}}">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>{{language_data('Leave To')}}</label>
                                            <input type="text" class="form-control" readonly value="{{$leave->leave_to}}">
                                            <input type="text" class="form-control" readonly value="{{$leave->leave_to_ampm}}">
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label>{{language_data('Applied On')}}</label>
                                    <input type="text" class="form-control" value="{{$leave->applied_on}}" readonly>
                                </div>


                                <div class="form-group">
                                    <label>{{language_data('Leave Reason')}}</label>
                                    <textarea class="textarea form-control" readonly style="height:50px;">{{$leave->leave_reason}}</textarea>
                                </div>
                                

                                <div class="form-group">
                                    <label>{{language_data('Current Status')}}</label>
                                    <input type="text" class="form-control" value="{{$leave->status}}" readonly>
                                </div>

                                @if (session('portal')=="master") 
                                <div class="form-group">
                                    <label>{{language_data('Change Status')}}</label>
                                    <select class="selectpicker form-control" name="status" >
                                        <option value="approved" @if($leave->status=='approved') selected @endif>{{language_data('Approved')}}</option>
                                        <option value="pending"  @if($leave->status=='pending') selected @endif>{{language_data('Pending')}}</option>
                                        <option value="rejected" @if($leave->status=='rejected') selected @endif>{{language_data('Rejected')}}</option>
                                    </select>
                                </div>
                                @else
                                <input type="hidden" name="status" value="{{$leave->status}}" readonly>
                                @endif

                                <div class="form-group">
                                    <label>{{language_data('Remark')}}</label>
                                    <textarea class="form-control" name="remark" rows="4" style="height:50px;">{{$leave->remark}}</textarea>
                                </div>


                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" value="{{$leave->id}}" name="cmd">
                                @if(session('portal')=="employee")
                                    @if ($leave->status=="pending")
                                        <a href="#" class="btn btn-danger btn-sm cdelete pull-left" id="{{$leave->id}}"><i class="fa fa-trash"></i> {{language_data('Delete')}}</a>
                                    @endif
                                @endif
                                <button type="submit" class="btn btn-success btn-sm pull-right"><i class="fa fa-save"></i> {{language_data('Update')}} </button>
                            </form>
                        </div>
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

    </script>

@endsection


