@extends(session('portal'))

{{--External Style Section--}}
@section('style')
    {!! Html::style("assets/libs/bootstrap3-wysihtml5-bower/bootstrap3-wysihtml5.min.css") !!}
    {!! Html::style("assets/libs/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css") !!}
@endsection


@section('content')

    <section class="wrapper-bottom-sec">
        <div class="p-30">
            <h2 class="page-title">View Training Needs</h2>
        </div>
        <div class="p-30 p-t-none p-b-none">

            @include('notification.notify')
            <div class="row">

                <div class="col-lg-7">
                    <div class="panel">
                        <div class="panel-body">
                            <form class="" role="form" action="{{url('training/post-training-needs-assessment-update')}}" method="post">
                                <div class="panel-heading">
                                    <h3 class="panel-title">View Training Needs</h3>
                                </div>

                                @if (session('portal')=="master") 
                                <div class="form-group">
                                    <label>{{language_data('Training')}} {{language_data('Employee')}}</label>
                                    <select class="form-control selectpicker" data-live-search="true" name="employee_id">
                                        @foreach($employee as $e)
                                        <option value="{{$e->id}}" @if ($e->id==$tnassessment->employee_id) selected @endif>{{$e->fullname}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @else
                                    <input type="hidden" class="form-control" name="employee_id" value="{{\Auth::user()->id}}">
                                @endif

                                <!-- <div class="form-group">
                                    <label>{{language_data('Training Type')}}</label>
                                    <select class="form-control selectpicker" data-live-search="true" name="training_type">
                                        <option value="Online Training">{{language_data('Online Training')}}</option>
                                        <option value="Seminar">{{language_data('Seminar')}}</option>
                                        <option value="Lecture">{{language_data('Lecture')}}</option>
                                        <option value="Workshop">{{language_data('Workshop')}}</option>
                                        <option value="Hands On Training">{{language_data('Hands On Training')}}</option>
                                        <option value="Webinar">{{language_data('Webinar')}}</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>{{language_data('Training')}} {{language_data('Subject')}}</label>
                                    <select class="form-control selectpicker" data-live-search="true" name="training_subject">
                                        <option value="HR Training">{{language_data('HR Training')}}</option>
                                        <option value="Employees Development">{{language_data('Employees Development')}}</option>
                                        <option value="IT Training">{{language_data('IT Training')}}</option>
                                        <option value="Finance Training">{{language_data('Finance Training')}}</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>{{language_data('Nature Of Training')}}</label>
                                    <select class="form-control selectpicker" data-live-search="true" name="training_nature">
                                        <option value="Internal">{{language_data('Internal')}}</option>
                                        <option value="External">{{language_data('External')}}</option>
                                    </select>
                                </div> -->

                                <div class="form-group">
                                    <label>{{language_data('Training')}} {{language_data('Title')}}</label>
                                    <input type="text" class="form-control" name="training_title" required="" value="{{$tnassessment->title}}">
                                </div>

                                <div class="form-group">
                                    <label>Area of Development</label>
                                    <input type="text" class="form-control" name="development_area" value="{{$tnassessment->development_area}}">
                                </div>
                                
                                <div class="form-group">
                                    <label>Priority No.</label>
                                    <input type="number" class="form-control" name="priority" value="{{$tnassessment->priority}}">
                                </div>


                                <div class="form-group">
                                    <label>Target Date Completion</label>
                                    <input type="text" class="form-control datePicker" name="target_completion" value="{{$tnassessment->target_completion}}">
                                </div>

                                <div class="form-group">
                                    <label>Hours</label>
                                    <input type="text" class="form-control datePicker" name="hours" value="{{$tnassessment->hours}}">
                                </div>

                                <div class="form-group">
                                    <label>Responsible Person</label>
                                    <input type="text" class="form-control" name="responsible_person" value="{{$tnassessment->responsible_person}}">
                                </div>

                                
                                <div class="form-group">
                                    <label>{{language_data('Status')}}</label>
                                    <select class="form-control selectpicker" data-live-search="true" name="status">
                                        <option value="pending" @if($tnassessment->status=='pending') selected @endif>{{language_data('Pending')}}</option>
                                        <option value="approved"  @if($tnassessment->status=='approved') selected @endif>{{language_data('Approved')}}</option>
                                        <option value="rejected"  @if($tnassessment->status=='rejected') selected @endif>{{language_data('Rejected')}}</option>
                                        <option value="completed"  @if($tnassessment->status=='completed') selected @endif>{{language_data('Completed')}}</option>
                                    </select>
                                </div>


                                <div class="form-group">
                                    <label>{{language_data('Training')}} {{language_data('Reason')}}</label>
                                    <textarea class="textarea form-control" name="training_reason" style="height:50px;">{{$tnassessment->training_reason}}</textarea>
                                </div>

                                


                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" value="{{$tnassessment->id}}" name="cmd">
                                <button type="submit" class="btn btn-success btn-sm pull-right"><i class="fa fa-edit"></i> {{language_data('Update')}} </button>
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
@endsection
