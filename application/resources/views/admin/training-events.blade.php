@extends(session('portal'))

{{--External Style Section--}}
@section('style')
    {!! Html::style("assets/libs/data-table/datatables.min.css") !!}
    {!! Html::style("assets/libs/bootstrap3-wysihtml5-bower/bootstrap3-wysihtml5.min.css") !!}
    {!! Html::style("assets/libs/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css") !!}
@endsection


@section('content')

    <section class="wrapper-bottom-sec">
        <div class="p-30">
            <h2 class="page-title">{{language_data('Training Events')}}</h2>
        </div>
        <div class="p-30 p-t-none p-b-none">
            @include('notification.notify')
            <div class="row">

                <div class="col-lg-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">{{language_data('Training Events')}}</h3>
                            <?php if (\Auth::user()->user_name =='admin' or (\Auth::user()->role_id ==2)) { ?>
                            <button class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#add-new-event"><i class="fa fa-plus"></i> {{language_data('Add New Event')}}</button>
                            <?php } ?>
                            <br>
                        </div>
                        <div class="panel-body p-none">
                        <table class="table data-table table-hover table-ultra-responsive">
                                <thead>
                                <tr>
                                    <th style="padding: 8px; width: 20%;">Subject</th>
                                    <th style="padding: 8px; width: 15%;">Venue</th>
                                    @if (session('portal')=="master") 
                                        <th style="padding: 8px; width: 15%;">Employee</th>
                                    @endif
                                    <th style="padding: 8px; width: 8%;">From</th>
                                    <th style="padding: 8px; width: 8%;">To</th>
                                    <th style="padding: 8px; width: 8%;">Sponsor</th>
                                    <th style="padding: 8px; width: 5%;">{{language_data('Status')}}</th>
                                    <th style="padding: 8px; width: 12%;" class="text-right">{{language_data('Actions')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                               @foreach($training_event as $te)
                                    <tr>
    
                                        <td style="padding: 8px;" data-label="Title"><p>{{$te->title}}</p></td>
                                        <td style="padding: 8px;" data-label="Title"><p>{{$te->training_location}}</p></td>
                                        
                                            @if (session('portal')=="master") 
                                            <td style="padding: 8px;" data-label="Training Type"><p>
                                                <?php
                                                    $event_employees=App\TrainingEventsEmployee::where('training_id',$te->id)->get();
                                                    $num = 1;
                                                    foreach ($event_employees as $event_employee){
                                                        if ($num==1) {
                                                            echo DB::table('employee')->where('id', $event_employee->emp_id)->value('fullname');
                                                        }else{
                                                            echo ", " . DB::table('employee')->where('id', $event_employee->emp_id)->value('fullname');
                                                        }
                                                        $num++;
                                                    }
                                                ?>
                                                     </p></td>
                                            @endif
                                   
                                        <td style="padding: 8px;" data-label="Training From"><p>{{$te->training_from}}</p></td>
                                        <td style="padding: 8px;" data-label="Training To"><p>{{$te->training_to}}</p></td>
                                        <td style="padding: 8px;" data-label="Title"><p>{{$te->sponsored_by}}</p></td>
                                        <td style="padding: 8px;" data-label="Status">
                                            @if($te->status=='upcoming')
                                                <span class="label label-warning">Upcomming</span>
                                            @elseif($te->status=='completed')
                                                <span class="label label-info">Completed</span>
                                            @elseif($te->status=='cancelled')
                                                <span class="label label-info">Cancelled</span>
                                            @else
                                                <span class="label label-warning">Upcomming</span>
                                            @endif
                                        </td>
                                        <td data-label="Actions" class="text-right">
                                            <a class="btn btn-success btn-xs" href="{{url('training/view-training-events/'.$te->id)}}"><i class="fa fa-edit"></i> {{language_data('Edit')}}</a>
                                            <a href="#" class="btn btn-danger btn-xs cdelete" id="{{$te->id}}"><i class="fa fa-trash"></i> {{language_data('Delete')}}</a>
                                        </td>
                                    </tr>

                                @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>


            <!-- Modal -->
            <div class="modal fade" id="add-new-event" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">{{language_data('Add New Event')}}</h4>
                        </div>
                        <form class="form-some-up" role="form" method="post" action="{{url('training/post-new-training-event')}}">
                            <div class="modal-body">


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
                                    <label>Subject</label>
                                    <input type="text" class="form-control" name="training_title" required="">
                                </div>

                                <div class="form-group">
                                    <label>Venue</label>
                                    <input type="text" class="form-control" name="training_location">
                                </div>

                                 <div class="form-group">
                                    <label>{{language_data('Employee')}}</label>
                                    <select class="form-control selectpicker" multiple data-live-search="true" name="employee[]">
                                        @foreach($employee as $e)
                                            <option value="{{$e->id}}">{{$e->fullname}}</option>
                                        @endforeach
                                    </select>
                                </div>


                                <div class="form-group">
                                    <label>{{language_data('Sponsored By')}}</label>
                                    <input type="text" class="form-control" name="sponsored_by">
                                </div>

                                <div class="form-group">
                                    <label>{{language_data('Organized By')}}</label>
                                    <input type="text" class="form-control" name="organized_by">
                                </div>

                                <div class="form-group">
                                    <label>{{language_data('Training From')}}</label>
                                    <input type="text" class="form-control datePicker" name="training_from">
                                </div>

                                <div class="form-group">
                                    <label>{{language_data('Training To')}}</label>
                                    <input type="text" class="form-control datePicker" name="training_to">
                                </div>

                                <div class="form-group">
                                    <label>Total Hours</label>
                                    <input type="text" class="form-control" name="hours">
                                </div>
                               


                                <!-- <div class="form-group">
                                    <label>{{language_data('Trainer')}}</label>
                                    <select class="form-control selectpicker" multiple data-live-search="true" name="trainer[]">
                                        @foreach($trainers as $t)
                                            <option value="{{$t->id}}">{{$t->first_name}} {{$t->last_name}}</option>
                                        @endforeach
                                    </select>
                                </div> -->



                                <div class="form-group">
                                    <label>{{language_data('Status')}}</label>
                                    <select class="form-control selectpicker"  name="status">
                                        <option value="upcoming">{{language_data('Upcoming')}}</option>
                                        <option value="completed">{{language_data('Completed')}}</option>
                                    </select>
                                </div>


                                <!-- <div class="form-group">
                                    <label>{{language_data('Externals')}}</label>
                                    <textarea class="textarea-wysihtml5 form-control" name="externals"></textarea>
                                </div> -->

                                <div class="form-group">
                                    <label>{{language_data('Training')}} {{language_data('Description')}}</label>
                                    <textarea class="textarea-wysihtml5 form-control" name="description" style="height:80px"></textarea>
                                </div>


                            </div>
                            <div class="modal-footer">
                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                <button type="button" class="btn btn-default" data-dismiss="modal">{{language_data('Close')}}</button>
                                <button type="submit" class="btn btn-primary">{{language_data('Add')}}</button>
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
                bootbox.confirm("Are you sure?", function (result) {
                    if (result) {
                        var _url = $("#_url").val();
                        window.location.href = _url + "/training/delete-training-event/" + id;
                    }
                });
            });


        });
    </script>
@endsection
