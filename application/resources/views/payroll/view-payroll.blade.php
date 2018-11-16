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
                            <h3 class="panel-title">Payroll Payslip</h3>
                        </div>
                        <div class="panel-body p-none">
                            <table class="table data-table table-hover table-ultra-responsive">
                                <thead>
                                <tr>
                                    <th width="3%" style="padding: 2x;">No.</th>
                                    <th>Payroll</th>
                                    <th>Type</th>
                                    <th>Yr_Month</th>
                                    <th>Income</th>
                                    <th>Deductions</th>
                                    <th>NetPay</th>
                                    <th class="text-right"></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $no = 1; ?>
                                @foreach($payrolls as $p)
                                    <tr>
                                    	
					                    <td style="padding: 8px;" width="3%" style="padding: 2x;"> {{$no}}.</td>
                                        <td style="padding: 8px;" align="left" width="35%" >{{ DB::table('payroll_period')->where('payroll_period_id', $p->payroll_period_id)->value('description') }}</td>
                                        <td style="padding: 8px;" align="left" width="5%"><p>{{ DB::table('payroll_period')->where('payroll_period_id', $p->payroll_period_id)->value('payroll_type') }}</p></td>
                                        <td style="padding: 8px;" align="right"><p>{{ DB::table('payroll_period')->where('payroll_period_id', $p->payroll_period_id)->value('fsyear') }}-{{ DB::table('payroll_period')->where('payroll_period_id', $p->payroll_period_id)->value('fsmonth') }}</p></td>
                                        <td style="padding: 8px;" align="right"><p>{{ number_format($p->monthly_salary_final,2) }}</p></td>
                                        <?php $deductions = $p->deduct_1 + $p->deduct_2 + $p->deduct_3 + $p->deduct_4 + $p->deduct_5 + $p->deduct_6 + $p->deduct_7 + $p->deduct_8 + $p->deduct_9 + $p->deduct_10 + $p->deduct_11 + $p->deduct_12 ?>
                                        <?php $loans = $p->loan_1 + $p->loan_2 + $p->loan_3 + $p->loan_4 + $p->loan_5 + $p->loan_6 + $p->loan_7 + $p->loan_8 + $p->loan_9  ?>
                                        <td style="padding: 8px;" data-label="Payroll" align="right">{{ number_format($deductions + $loans + $p->tax_withheld_total,2) }}</td>
                                        <td style="padding: 8px;" data-label="Type" align="right"><p>{{ number_format($p->net_pay,2) }}</p></td>

                                        <td style="padding: 8px;" data-label="Actions" width="19%">
                                            <a class="btn btn-success btn-xs pull-right" href="#" data-toggle="modal" data-target=".modal_view_payslip_{{$p->payroll_id}}"><i class="fa fa-eye"></i>&nbsp;Detail&nbsp;&nbsp;</a>
                                            @include('payroll.modal-view-payslip')
                                            <a href="{{url('payroll/download-payslip/'. $p->payroll_id)}}" class="btn btn-xs btn-primary pull-right">
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
    <script>
        $(document).ready(function () {
            /*For DataTable*/
            $('.data-table').DataTable();
        });
        
          $('#mod_payslip', 'tr','td').removeClass("background");
    </script>
@endsection
