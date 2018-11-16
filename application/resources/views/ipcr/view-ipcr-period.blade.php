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
                            <h3 class="panel-title">IPCR Rating Period</h3>
                            <a class="btn btn-primary pull-right" href="#" data-toggle="modal" data-target=".modal-ipcr-period-add"><i class="fa fa-plus"></i>&nbsp;Add&nbsp;&nbsp;</a>
                                            @include('ipcr.modal-ipcr-period-add')
                            <br />
                        </div>
                        <div class="panel-body p-none">
                            <table class="table data-table table-hover table-ultra-responsive">
                                <thead>
                                <tr>
                                    <th width="3%" style="padding: 2x;">No.</th>
                                    <th>Name</th>
                                    <th>Rating Period</th>
                                    <th>Description</th>
                                    <th>Department</th>
                                    <th>Year</th>
                                    <th>Period From</th>
                                    <th>Period To</th>
                                    <th>Remarks</th>
                                    <th>Approval</th>
                                    <th>Rating</th>
                                    <th class="text-right"></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $no = 1; ?>
                                @foreach($ipcr_periods as $ip)
                                    <tr>
                                    	
					                    <td style="padding: 10px;" width="3%" style="padding: 2x;"> {{$no}}.</td>
                                        <td style="padding: 10px;" align="left" width="35%" >{{$ip->name}}</td>
                                        <td style="padding: 10px;" align="left" width="15%" >{{$ip->rating_period}}</td>
                                        <td style="padding: 10px;" align="left" width="15%" >{{$ip->description}}</td>
                                        <td style="padding: 10px;" align="left" width="5%"><p>{{ DB::table('departments')->where('id',$ip->dep_id)->value('dep') }}</p></td>
                                        <td style="padding: 10px;" align="left" width="10%" >{{$ip->year}}</td>
                                        <td style="padding: 10px;" align="left" width="35%" >{{$ip->period_from}}</td>
                                        <td style="padding: 10px;" align="left" width="35%" >{{$ip->period_to}}</td>
                                        <td style="padding: 10px;" align="left" width="35%" >{{$ip->remarks}}</td>
                                        <td style="padding: 10px;" align="left" width="35%" >
                                            @if($ip->status_approval=='open')
                                                <span class="label label-info">Open</span>
                                            @elseif($ip->status_approval=='closed')
                                                <span class="label label-danger">Closed</span>
                                            @else
                                                <span class="label label-info">Open</span>
                                            @endif
                                        </td>
                                        <td style="padding: 10px;" align="left" width="35%" >
                                            @if($ip->status_rating=='open')
                                                <span class="label label-info">Open</span>
                                            @elseif($ip->status_rating=='closed')
                                                <span class="label label-danger">Closed</span>
                                            @else
                                                <span class="label label-info">Open</span>
                                            @endif
                                        </td>
                                        <td style="padding: 10px;" data-label="Actions" width="19%">
                                            <a class="btn btn-success btn-xs pull-left" href="#" data-toggle="modal" data-target=".modal-ipcr-period-detail{{$ip->id}}"><i class="fa fa-eye"></i>&nbsp;Edit&nbsp;&nbsp;</a>
                                            @include('ipcr.modal-ipcr-period-detail')
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
    <script>
        $(document).ready(function () {
            /*For DataTable*/
            $('.data-table').DataTable();
        });
        
          $('#mod_payslip', 'tr','td').removeClass("background");
    </script>
@endsection
