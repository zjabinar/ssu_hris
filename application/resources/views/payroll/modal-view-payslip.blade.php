<div class="modal fade modal_view_payslip_{{$p->payroll_id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">

    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">View Payroll <span style="font-weight: bold"> ({{DB::table('payroll_period')->where('payroll_period_id',$p->payroll_period_id)->value('description')}})</span></h4>
            </div>
            <form class="form-some-up form-block">

                <div class="modal-body">

			<div class="row">
        
	                    <div class="col-lg-3">
                                <table width="100%">

                                    <tr>
                                        <th colspan="2"><strong>Earnings</strong></th>
                                    </tr>
                                        <tr >
                                        	<td style="padding: 4px;">Regular Pay</td>
                                            	<td style="padding: 4px;" align="right">{{ number_format($p->reg_pay,2) }}</td>
                                        </tr>
                                        <tr >
                                        	<td style="padding: 4px;">Step Increment</td>
                                            	<td style="padding: 4px;" align="right">{{ number_format($p->step_inc,2) }}</td>
                                        </tr>
                                         <tr >
                                        	<td style="padding: 4px;">NBC 540</td>
                                            	<td style="padding: 4px;" align="right">{{ number_format($p->nbc_540,2) }}</td>
                                        </tr>
                                        <tr >
                                        	<td style="padding: 4px;">NBC 461</td>
                                            	<td style="padding: 4px;" align="right">{{ number_format($p->nbc_461,2) }}</td>
                                        </tr>
                                         <tr >
                                        	<td style="padding: 4px;" align="right"><strong><span style="align-right">Total:</span></strong></td>
                                            	<td style="padding: 4px;" align="right"><strong><span style="align-right">{{ number_format($p->monthly_salary_final,2) }}</span></strong></td>
                                        </tr>
                                </table>
	                    </div>
	
	                    <div class="col-lg-3">
                                <table width="100%">
      
                                    <tr>
                                    	<th colspan="2"><strong>Deductions</strong></th>
                                    </tr>

                                   
                                        <tr>
                                        	<td style="padding: 4px;">{{ DB::table('deductions')->where('deduction_id', 1)->value('name') }}</td>
                                            	<td style="padding: 4px;" align="right">{{ number_format($p->deduct_1,2) }}</td>
                                        </tr>
                                        <tr>
                                        	<td style="padding: 4px;">{{ DB::table('deductions')->where('deduction_id', 2)->value('name') }}</td>
                                            	<td style="padding: 4px;" align="right">{{ number_format($p->deduct_2,2) }}</td>
                                        </tr>
                                        <tr>
                                        	<td style="padding: 4px;">{{ DB::table('deductions')->where('deduction_id', 3)->value('name') }}</td>
                                            	<td style="padding: 4px;" align="right">{{ number_format($p->deduct_3,2) }}</td>
                                        </tr>
                                        @if (DB::table('deductions')->where('deduction_id', 4)->value('flag_use')=="Y")
                                            <tr>
                                                <td style="padding: 4px;">{{ DB::table('deductions')->where('deduction_id', 4)->value('name') }}</td>
                                                    <td style="padding: 4px;" align="right">{{ number_format($p->deduct_4,2) }}</td>
                                            </tr>
                                        @endif
                                        @if (DB::table('deductions')->where('deduction_id', 5)->value('flag_use')=="Y")
                                            <tr>
                                                <td style="padding: 4px;">{{ DB::table('deductions')->where('deduction_id', 5)->value('name') }}</td>
                                                    <td style="padding: 4px;" align="right">{{ number_format($p->deduct_5,2) }}</td>
                                            </tr>
                                        @endif
                                        @if (DB::table('deductions')->where('deduction_id', 6)->value('flag_use')=="Y")
                                            <tr>
                                                <td style="padding: 4px;">{{ DB::table('deductions')->where('deduction_id', 6)->value('name') }}</td>
                                                    <td style="padding: 4px;" align="right">{{ number_format($p->deduct_6,2) }}</td>
                                            </tr>
                                        @endif
                                        @if (DB::table('deductions')->where('deduction_id', 7)->value('flag_use')=="Y")
                                            <tr>
                                                <td style="padding: 4px;">{{ DB::table('deductions')->where('deduction_id', 7)->value('name') }}</td>
                                                    <td style="padding: 4px;" align="right">{{ number_format($p->deduct_7,2) }}</td>
                                            </tr>
                                        @endif
                                        @if (DB::table('deductions')->where('deduction_id', 8)->value('flag_use')=="Y")
                                            <tr>
                                                <td style="padding: 4px;">{{ DB::table('deductions')->where('deduction_id', 8)->value('name') }}</td>
                                                    <td style="padding: 4px;" align="right">{{ number_format($p->deduct_8,2) }}</td>
                                            </tr>
                                        @endif
                                        @if (DB::table('deductions')->where('deduction_id', 9)->value('flag_use')=="Y")
                                            <tr>
                                                <td style="padding: 4px;">{{ DB::table('deductions')->where('deduction_id', 9)->value('name') }}</td>
                                                    <td style="padding: 4px;" align="right">{{ number_format($p->deduct_9,2) }}</td>
                                            </tr>
                                        @endif
                                        @if (DB::table('deductions')->where('deduction_id', 10)->value('flag_use')=="Y")
                                            <tr>
                                                <td style="padding: 4px;">{{ DB::table('deductions')->where('deduction_id', 10)->value('name') }}</td>
                                                    <td style="padding: 4px;" align="right">{{ number_format($p->deduct_10,2) }}</td>
                                            </tr>
                                        @endif
                                        @if (DB::table('deductions')->where('deduction_id', 11)->value('flag_use')=="Y")
                                            <tr>
                                                <td style="padding: 4px;">{{ DB::table('deductions')->where('deduction_id', 11)->value('name') }}</td>
                                                    <td style="padding: 4px;" align="right">{{ number_format($p->deduct_11,2) }}</td>
                                            </tr>
                                        @endif
                                        @if (DB::table('deductions')->where('deduction_id', 12)->value('flag_use')=="Y")
                                            <tr>
                                                <td style="padding: 4px;">{{ DB::table('deductions')->where('deduction_id', 12)->value('name') }}</td>
                                                    <td style="padding: 4px;" align="right">{{ number_format($p->deduct_12,2) }}</td>
                                            </tr>
                                        @endif
                                        @if (DB::table('deductions')->where('deduction_id', 13)->value('flag_use')=="Y")
                                            <tr>
                                                <td style="padding: 4px;">{{ DB::table('deductions')->where('deduction_id', 13)->value('name') }}</td>
                                                    <td style="padding: 4px;" align="right">{{ number_format($p->deduct_13,2) }}</td>
                                            </tr>
                                        @endif
                                        @if (DB::table('deductions')->where('deduction_id', 14)->value('flag_use')=="Y")
                                            <tr>
                                                <td style="padding: 4px;">{{ DB::table('deductions')->where('deduction_id', 14)->value('name') }}</td>
                                                    <td style="padding: 4px;" align="right">{{ number_format($p->deduct_14,2) }}</td>
                                            </tr>
                                        @endif
                                        @if (DB::table('deductions')->where('deduction_id', 15)->value('flag_use')=="Y")
                                            <tr>
                                                <td style="padding: 4px;">{{ DB::table('deductions')->where('deduction_id', 15)->value('name') }}</td>
                                                    <td style="padding: 4px;" align="right">{{ number_format($p->deduct_15,2) }}</td>
                                            </tr>
                                        @endif
                                        @if (DB::table('deductions')->where('deduction_id', 16)->value('flag_use')=="Y")
                                            <tr>
                                                <td style="padding: 4px;">{{ DB::table('deductions')->where('deduction_id', 16)->value('name') }}</td>
                                                    <td style="padding: 4px;" align="right">{{ number_format($p->deduct_16,2) }}</td>
                                            </tr>
                                        @endif
                                        @if (DB::table('deductions')->where('deduction_id', 17)->value('flag_use')=="Y")
                                            <tr>
                                                <td style="padding: 4px;">{{ DB::table('deductions')->where('deduction_id', 17)->value('name') }}</td>
                                                    <td style="padding: 4px;" align="right">{{ number_format($p->deduct_17,2) }}</td>
                                            </tr>
                                        @endif
                                        @if (DB::table('deductions')->where('deduction_id', 18)->value('flag_use')=="Y")
                                            <tr>
                                                <td style="padding: 4px;">{{ DB::table('deductions')->where('deduction_id', 18)->value('name') }}</td>
                                                    <td style="padding: 4px;" align="right">{{ number_format($p->deduct_18,2) }}</td>
                                            </tr>
                                        @endif
                                        @if (DB::table('deductions')->where('deduction_id', 19)->value('flag_use')=="Y")
                                            <tr>
                                                <td style="padding: 4px;">{{ DB::table('deductions')->where('deduction_id', 19)->value('name') }}</td>
                                                    <td style="padding: 4px;" align="right">{{ number_format($p->deduct_19,2) }}</td>
                                            </tr>
                                        @endif
                                        @if (DB::table('deductions')->where('deduction_id', 20)->value('flag_use')=="Y")
                                            <tr>
                                                <td style="padding: 4px;">{{ DB::table('deductions')->where('deduction_id', 20)->value('name') }}</td>
                                                    <td style="padding: 4px;" align="right">{{ number_format($p->deduct_20,2) }}</td>
                                            </tr>
                                        @endif


                                         <tr>
                                        	<td style="padding: 4px;" align="right"><strong><span style="align-right">Total:</span></strong></td>
                                        	<?php $deductions = $p->deduct_1 + $p->deduct_2 + $p->deduct_3 + $p->deduct_4 + $p->deduct_5 + $p->deduct_6 + $p->deduct_7 + $p->deduct_8 + $p->deduct_9 + $p->deduct_10 + $p->deduct_11 + $p->deduct_12 ?>
                                            	<td style="padding: 4px;" align="right"><strong><span style="align-right">{{ number_format($deductions,2) }}</span></strong></td>
                                        </tr>
     
                                </table>
	                    </div>
	                    
	                    
	                    <div class="col-lg-3">
                                <table width="100%">
                                    <tr>
                                        <th colspan="2"><strong>Loans</strong></th>
                                    </tr>
                                        @if (DB::table('loans')->where('loan_id', 1)->value('flag_use')=="Y")
                                            <tr>
                                                <td style="padding: 4px;">{{ DB::table('loans')->where('loan_id', 1)->value('name') }}</td>
                                                    <td style="padding: 4px;" align="right">{{ number_format($p->loan_1,2) }}</td>
                                            </tr>
                                        @endif
                                        @if (DB::table('loans')->where('loan_id', 2)->value('flag_use')=="Y")
                                            <tr>
                                                <td style="padding: 4px;">{{ DB::table('loans')->where('loan_id', 2)->value('name') }}</td>
                                                    <td style="padding: 4px;" align="right">{{ number_format($p->loan_2,2) }}</td>
                                            </tr>
                                        @endif
                                        @if (DB::table('loans')->where('loan_id', 3)->value('flag_use')=="Y")
                                            <tr>
                                                <td style="padding: 4px;">{{ DB::table('loans')->where('loan_id', 3)->value('name') }}</td>
                                                    <td style="padding: 4px;" align="right">{{ number_format($p->loan_3,2) }}</td>
                                            </tr>
                                        @endif
                                        @if (DB::table('loans')->where('loan_id', 4)->value('flag_use')=="Y")
                                            <tr>
                                                <td style="padding: 4px;">{{ DB::table('loans')->where('loan_id', 4)->value('name') }}</td>
                                                    <td style="padding: 4px;" align="right">{{ number_format($p->loan_4,2) }}</td>
                                            </tr>
                                        @endif
                                        @if (DB::table('loans')->where('loan_id', 5)->value('flag_use')=="Y")
                                            <tr>
                                                <td style="padding: 4px;">{{ DB::table('loans')->where('loan_id', 5)->value('name') }}</td>
                                                    <td style="padding: 4px;" align="right">{{ number_format($p->loan_5,2) }}</td>
                                            </tr>
                                        @endif
                                        @if (DB::table('loans')->where('loan_id', 6)->value('flag_use')=="Y")
                                            <tr>
                                                <td style="padding: 4px;">{{ DB::table('loans')->where('loan_id', 6)->value('name') }}</td>
                                                    <td style="padding: 4px;" align="right">{{ number_format($p->loan_6,2) }}</td>
                                            </tr>
                                        @endif
                                        @if (DB::table('loans')->where('loan_id', 7)->value('flag_use')=="Y")
                                            <tr>
                                                <td style="padding: 4px;">{{ DB::table('loans')->where('loan_id', 7)->value('name') }}</td>
                                                    <td style="padding: 4px;" align="right">{{ number_format($p->loan_7,2) }}</td>
                                            </tr>
                                        @endif
                                        @if (DB::table('loans')->where('loan_id', 8)->value('flag_use')=="Y")
                                            <tr>
                                                <td style="padding: 4px;">{{ DB::table('loans')->where('loan_id', 8)->value('name') }}</td>
                                                    <td style="padding: 4px;" align="right">{{ number_format($p->loan_8,2) }}</td>
                                            </tr>
                                        @endif
                                        @if (DB::table('loans')->where('loan_id', 9)->value('flag_use')=="Y")
                                            <tr>
                                                <td style="padding: 4px;">{{ DB::table('loans')->where('loan_id', 9)->value('name') }}</td>
                                                    <td style="padding: 4px;" align="right">{{ number_format($p->loan_9,2) }}</td>
                                            </tr>
                                        @endif
                                        @if (DB::table('loans')->where('loan_id', 10)->value('flag_use')=="Y")
                                            <tr>
                                                <td style="padding: 4px;">{{ DB::table('loans')->where('loan_id', 10)->value('name') }}</td>
                                                <td style="padding: 4px;" align="right">{{ number_format($p->loan_10,2) }}</td>
                                            </tr>
                                        @endif
                                        @if (DB::table('loans')->where('loan_id', 11)->value('flag_use')=="Y")
                                            <tr>
                                                <td style="padding: 4px;">{{ DB::table('loans')->where('loan_id', 11)->value('name') }}</td>
                                                <td style="padding: 4px;" align="right">{{ number_format($p->loan_11,2) }}</td>
                                            </tr>
                                        @endif
                                        @if (DB::table('loans')->where('loan_id', 12)->value('flag_use')=="Y")
                                            <tr>
                                                <td style="padding: 4px;">{{ DB::table('loans')->where('loan_id', 12)->value('name') }}</td>
                                                <td style="padding: 4px;" align="right">{{ number_format($p->loan_12,2) }}</td>
                                            </tr>
                                        @endif
                                        @if (DB::table('loans')->where('loan_id', 13)->value('flag_use')=="Y")
                                            <tr>
                                                <td style="padding: 4px;">{{ DB::table('loans')->where('loan_id', 13)->value('name') }}</td>
                                                <td style="padding: 4px;" align="right">{{ number_format($p->loan_13,2) }}</td>
                                            </tr>
                                        @endif
                                        @if (DB::table('loans')->where('loan_id', 14)->value('flag_use')=="Y")
                                            <tr>
                                                <td style="padding: 4px;">{{ DB::table('loans')->where('loan_id', 14)->value('name') }}</td>
                                                <td style="padding: 4px;" align="right">{{ number_format($p->loan_14,2) }}</td>
                                            </tr>
                                        @endif
                                        @if (DB::table('loans')->where('loan_id', 15)->value('flag_use')=="Y")
                                            <tr>
                                                <td style="padding: 4px;">{{ DB::table('loans')->where('loan_id', 15)->value('name') }}</td>
                                                <td style="padding: 4px;" align="right">{{ number_format($p->loan_15,2) }}</td>
                                            </tr>
                                        @endif
                                        @if (DB::table('loans')->where('loan_id', 16)->value('flag_use')=="Y")
                                            <tr>
                                                <td style="padding: 4px;">{{ DB::table('loans')->where('loan_id', 16)->value('name') }}</td>
                                                <td style="padding: 4px;" align="right">{{ number_format($p->loan_16,2) }}</td>
                                            </tr>
                                        @endif
                                        @if (DB::table('loans')->where('loan_id', 17)->value('flag_use')=="Y")
                                            <tr>
                                                <td style="padding: 4px;">{{ DB::table('loans')->where('loan_id', 17)->value('name') }}</td>
                                                <td style="padding: 4px;" align="right">{{ number_format($p->loan_17,2) }}</td>
                                            </tr>
                                        @endif
                                        @if (DB::table('loans')->where('loan_id', 18)->value('flag_use')=="Y")
                                            <tr>
                                                <td style="padding: 4px;">{{ DB::table('loans')->where('loan_id', 18)->value('name') }}</td>
                                                <td style="padding: 4px;" align="right">{{ number_format($p->loan_18,2) }}</td>
                                            </tr>
                                        @endif
                                        @if (DB::table('loans')->where('loan_id', 19)->value('flag_use')=="Y")
                                            <tr>
                                                <td style="padding: 4px;">{{ DB::table('loans')->where('loan_id', 19)->value('name') }}</td>
                                                <td style="padding: 4px;" align="right">{{ number_format($p->loan_19,2) }}</td>
                                            </tr>
                                        @endif
                                        @if (DB::table('loans')->where('loan_id', 20)->value('flag_use')=="Y")
                                            <tr>
                                                <td style="padding: 4px;">{{ DB::table('loans')->where('loan_id', 20)->value('name') }}</td>
                                                <td style="padding: 4px;" align="right">{{ number_format($p->loan_20,2) }}</td>
                                            </tr>
                                        @endif

                                         <tr>
                                        	<td style="padding: 4px;" align="right"><strong><span style="align-right">Total:</span></strong></td>
                                        	<?php $loans = $p->loan_1 + $p->loan_2 + $p->loan_3 + $p->loan_4 + $p->loan_5 + $p->loan_6 + $p->loan_7 + $p->loan_8 + $p->loan_9  ?>
                                            	<td style="padding: 4px;" align="right"><strong><span style="align-right;">{{ number_format($loans,2) }}</span></strong></td>
                                        </tr>
            
                                </table>
	                    </div>
	                    
	                    
	                    <div class="col-lg-3">
                                <table width="100%">
             
                                    <tr>
                                        <th colspan="2"><strong>Total</strong></th>
                                    </tr>

                                   
                                        <tr>
                                           	<td style="padding: 4px; font-size: 14px;">Gross Pay</td>
                                            	<td style="padding: 4px; font-size: 14px;" align="right">{{ number_format($p->monthly_salary_final,2) }}</td>
                                        </tr>
                                        <tr>
                                           	<td style="padding: 4px; font-size: 14px;">Less Deductions</td>
                                            	<td style="padding: 4px; font-size: 14px;" align="right">{{ number_format($deductions + $loans,2)  }}</td>
                                        </tr>
                                        <tr>
                                           	<td style="padding: 4px; font-size: 14px;">Less Tax</td>
                                            	<td style="padding: 4px; font-size: 14px;" align="right">{{ number_format($p->tax_withheld_total,2) }}</td>
                                        </tr>

                                         <tr>
                                        	<td style="padding: 4px; font-size: 14px;" align="right"><strong><span style="align-right;font-size:16px;">Total Net Pay:</span></strong></td>
                                            	<td style="padding: 4px; font-size: 14px;" align="right"><strong><span style="align-right;font-size:16px;">{{ number_format($p->net_pay,2)  }}</span></strong></td>
                                        </tr>

                                </table>
	                    </div>
	                    
	
	                </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{language_data('Close')}}</button>
                </div>

            </form>
        </div>
    </div>

</div>

