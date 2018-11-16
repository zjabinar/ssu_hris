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
                            <h3 class="panel-title">My IPCR</h3>

                        </div>
                        <div class="panel-body p-none">
                            <table class="table data-table table-hover table-ultra-responsive">
                                <thead>
                                <tr>
                                    <th width="3%" style="padding: 2x;">No.</th>
                                    <th>Name</th>
                                    <th>Rating Period</th>
                                    <th>Description</th>
                                    <th>Year</th>
                                    <th>From</th>
                                    <th>To</th>
                                    <th>Approval</th>
                                    <th >Rating</th>
                                    <th>Supervisor</th>
                                    <th class="text-right"></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $no = 1; ?>
                                @foreach($ipcrs as $p)
                                    <tr>
                                    	
					                    <td style="padding: 10px;" width="3%" style="padding: 2x;"> {{$no}}.</td>
                                        <td style="padding: 10px;" align="left" width="20%" >{{ DB::table('ipcr_periods')->where('id', $p->ipcr_period_id)->value('name') }}</td>
                                        <td style="padding: 10px;" align="left" width="40%" >{{ DB::table('ipcr_periods')->where('id', $p->ipcr_period_id)->value('rating_period') }}</td>
                                        <td style="padding: 10px;" align="left" width="20%" >{{ DB::table('ipcr_periods')->where('id', $p->ipcr_period_id)->value('description') }}</td>
                                        <td style="padding: 10px;" align="left" width="40%" >{{ DB::table('ipcr_periods')->where('id', $p->ipcr_period_id)->value('year') }}</td>
                                        <td style="padding: 10px;" align="left" width="20%" >{{ DB::table('ipcr_periods')->where('id', $p->ipcr_period_id)->value('period_from') }}</td>
                                        <td style="padding: 10px;" align="left" width="40%" >{{ DB::table('ipcr_periods')->where('id', $p->ipcr_period_id)->value('period_to') }}</td>
                                        
                                        <td style="padding: 10px;" align="left" width="20%" >
                                            <?php $approval =  DB::table('ipcr_periods')->where('id', $p->ipcr_period_id)->value('status_approval') ?>
                                            @if($approval=='open')
                                                <span class="label label-info">Open</span>
                                            @elseif($approval=='closed')
                                                <span class="label label-danger">Closed</span>
                                            @else
                                                <span class="label label-info">Open</span>
                                            @endif
                                        </td>
                                        <td style="padding: 10px;" align="left" width="20%" >
                                                <?php $rating =  DB::table('ipcr_periods')->where('id', $p->ipcr_period_id)->value('status_rating') ?>
                                                @if($rating=='open')
                                                    <span class="label label-info">Open</span>
                                                @elseif($rating=='closed')
                                                    <span class="label label-danger">Closed</span>
                                                @else
                                                    <span class="label label-info">Open</span>
                                                @endif
                                            </td>

                                        <td style="padding: 10px;" align="left" width="30%" >  {{ DB::table('employee')->where('id', $p->head_id)->value('fullname') }}  </td>

                                        <td style="padding: 10px;" data-label="Actions" width="19%">
                                                <a href="{{url('ipcr/employee-mfo/'. $p->id)}}" class="btn btn-xs btn-primary pull-right">
                                                    <span class="glyphicon glyphicon-export" aria-hidden="true"></span>&nbsp;Detail
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
    <script>
        $(document).ready(function () {
            /*For DataTable*/
            $('.data-table').DataTable();
        });
        
          $('#mod_payslip', 'tr','td').removeClass("background");
    </script>
@endsection
