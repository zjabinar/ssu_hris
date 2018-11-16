@extends(session('portal'))

{{--External Style Section--}}
@section('style')
    {!! Html::style("assets/libs/data-table/datatables.min.css") !!}
@endsection

<?php
function getMonthName($num){
    if ($num==1){
        return "January";
    }elseif ($num==2){
        return "February";
    }elseif ($num==3){
        return "March";
    }elseif ($num==4){
        return "April";
    }elseif ($num==5){
        return "May";
    }elseif ($num==6){
        return "June";
    }elseif ($num==7){
        return "July";
    }elseif ($num==8){
        return "August";
    }elseif ($num==9){
        return "September";
    }elseif ($num==10){
        return "October";
    }elseif ($num==11){
        return "November";
    }elseif ($num==12){
        return "December";
    }else {
        return "Month";
    }
}

?>


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
                            <h3 class="panel-title">Loans</h3>
                        </div>
                        <div class="panel-body p-none">
                            <table class="table data-table table-hover table-ultra-responsive">
                                <thead>
                                <tr>
                                  <th width="3%" style="padding: 2x;">No.</th>
                                    <th>Loan Name</th>
                                    <th>Loan Date</th>
                                    <th>Loan Amount</th>
                                    <th>Amorti-zation</th>
                                    <th>Start Balance</th>
                                    <th>Deduct Start</th>
                                    <th>Deduct End</th>
                                    <th>Active</th>
                                    <th class="text-right"></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $no = 1; ?>
                                @foreach($loans as $l)
                                    <tr>
                                    	<td style="padding: 8px;" width="3%" style="padding: 2x;"> {{$l->employee_id}} {{\Auth::user()->id}}.</td>
                                        <td style="padding: 8px;" width="20%">{{$l->loan_name}}</td>
                                        <td style="padding: 8px;" data-label="Type"><p>{{$l->loan_date}}</p></td>
                                        <td style="padding: 8px;" data-label="Year"><p>{{$l->loan_amount}}</p></td>
                                        <td style="padding: 8px;" data-label="Payroll">{{$l->amortization}}</td>
                                        <td style="padding: 8px;" data-label="Type"><p>{{$l->loan_balance}}</p></td>
                                        <td style="padding: 8px;" data-label="Year"><p>{{$l->date_deduct_start}}</p></td>
                                        <td style="padding: 8px;" data-label="Payroll">{{$l->date_deduct_end}}</td>
                                        <td style="padding: 8px;" data-label="Type"><p>{{$l->flag_active}}</p></td>

                                        <td style="padding: 8px;" data-label="Actions"  width="35%">
                                            <a class="btn btn-success btn-xs pull-right" href="#" data-toggle="modal" data-target=".modal_view_loans_{{$l->record_id}}"><i class="fa fa-eye"></i>&nbsp;Detail&nbsp;&nbsp;</a>
                                            @include('payroll.modal-view-loandetail')
                                            <a href="{{url('payroll/download-loan/'. $l->record_id)}}" class="btn btn-xs btn-primary pull-right">
                                                <span class="glyphicon glyphicon-export" aria-hidden="true"></span>&nbsp;Ledger&nbsp;
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
    </script>
@endsection
