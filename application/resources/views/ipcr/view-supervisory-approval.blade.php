@extends(session('portal'))

{{--External Style Section--}}
@section('style')
    {!! Html::style("assets/libs/data-table/datatables.min.css") !!}
@endsection


@section('content')

    <section class="wrapper-bottom-sec">
        <div class="p-10">
            
        </div>
        <div class="p-30 p-t-none p-b-none">
            @include('notification.notify')
            <div class="row">

                <div class="col-lg-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">IPCR Supervisory Approval</h3>

                            <br />
                        </div>
                        <div class="panel-body p-none">
                            <table class="table data-table table-hover table-ultra-responsive">
                                <thead>
                                <tr>
                                    <th width="3%" style="padding: 2x;">No.</th>
                                    <th>Name</th>
                                    <th>Department Period</th>
                                    <th>College Unit</th>
                                    <th>Designation</th>
                                    <th>Email</th>
                                    <th class="text-right"></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $no = 1; ?>
                                @foreach($employees as $emp)
                                    <tr>
                                    	
					                    <td style="padding: 10px;" width="3%" style="padding: 2x;"> {{$no}}.</td>
                                        <td style="padding: 10px;" align="left" width="35%" >{{$emp->fullname}}</td>
                                        <td style="padding: 10px;" align="left" width="15%" >{{ DB::table('departments')->where('id', $emp->department_id)->value('department') }}</td>
                                        <td style="padding: 10px;" align="left" width="15%" >{{ DB::table('colleges')->where('id', $emp->college_id)->value('college_short') }}</td>
                                        <td style="padding: 10px;" align="left" width="5%"> {{ DB::table('sys_designation')->where('id',$emp->designation)->value('designation') }}</td>
                                        <td style="padding: 10px;" align="left" width="10%" >{{$emp->email}}</td>
                                        <td style="padding: 10px;" align="left" width="35%" >
                                            
                                            <a href="{{url('ipcr/supervisory-employee-detail/'. $emp->id)}}" class="btn btn-xs btn-primary pull-right">
                                                <span class="glyphicon glyphicon-export" aria-hidden="true"></span>&nbsp;Payslip
                                            </a>
                                        </td>
                                    </tr>
				                <?php $no++ ?>
                                @endforeach

                                </tbody>
                            </table>
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
    {!! Html::script("assets/libs/data-table/datatables.min.js")!!}
    {!! Html::script("assets/js/form-elements-page.js")!!}

@endsection
