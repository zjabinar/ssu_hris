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
                            <h3 class="panel-title">My Leave Ledger</h3>
                        </div>
                        <div class="panel-body p-none">
                            <table class="table data-table table-hover table-ultra-responsive">
                                <thead>
                                <tr>
                                    <th rowspan="2" width="3%" style="padding: 2x;">No.</th>
                                    <th rowspan="2" width="4%">Period</th>
                                    <th rowspan="2" width="4%">Particular</th>
                                    <th rowspan="2" width="4%">Code</th>
                                    <th colspan="4" width="20%" style="vertical-align:middle; text-align:center;">VACATION LEAVE</th>
                                    <th colspan="4" width="2%" style="vertical-align:middle; text-align:center;">SICK LEAVE</th>
                                    <th rowspan="2">Remarks</th>
                                </tr>
                                <tr>
                                    <th>Earned</th>
                                    <th>Abs. Und. W/P</th>
                                    <th>Balance</th>
                                    <th>Abs. Und. W/o Pay</th>
                                    
                                    <th>Earned</th>
                                    <th>Abs. Und. W/P</th>
                                    <th>Balance</th>
                                    <th>Abs. Und. W/o Pay</th>

                                </tr>

                                </thead>
                                <tbody>
                                    <?php $no = 1; ?>
                                        @foreach($ledgers as $ledger)
                                        <tr>
                                            
                                            <td style="padding: 10px;" width="3%" style="padding: 2x;"> {{$no}}.</td>
                                            <td style="padding: 10px;" align="left" width="10%" >{{$ledger->period}}</td>
                                            <td style="padding: 10px;" align="left" width="15%" >{{$ledger->particular}}</td>
                                            <td style="padding: 10px;" align="left" width="5%" >{{$ledger->particular_code}}</td>
                                            <td style="padding: 10px;" align="left" width="10%" > {{$ledger->vl_earned}}</td>
                                            <td style="padding: 10px;" align="left" width="10%" > {{$ledger->vl_deduct}}</td>
                                            <td style="padding: 10px;" align="left" width="10%" > {{$ledger->vl_balance}}</td>
                                            <td style="padding: 10px;" align="left" width="10%" > {{$ledger->vl_deduct_wopay}}</td>

                                            <td style="padding: 10px;" align="left" width="10%" > {{$ledger->sl_earned}}</td>
                                            <td style="padding: 10px;" align="left" width="10%" > {{$ledger->sl_deduct}}</td>
                                            <td style="padding: 10px;" align="left" width="10%" > {{$ledger->sl_balance}}</td>
                                            <td style="padding: 10px;" align="left" width="10%" > {{$ledger->sl_deduct_wopay}}</td>

                                            <td style="padding: 10px;" align="left" width="10%" > {{$ledger->remarks}}</td>

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
