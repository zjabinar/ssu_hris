<div class="modal fade modal_view_loans_{{$l->record_id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <?php 
        $has_rec = true;
        $loan_id = "loan_".$l->loan_id."_recid";

        try {
            $payrolls_loans=App\Payroll::where('employee_id',\Auth::user()->id)->where($loan_id,$l->record_id)->orderBy('payroll_id', 'desc')->get(); 
        } catch (Exception $e) {
            $has_rec = false;
        }

    ?>

        

    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Loan Detail: {{$l->loan_name}}</h4>
                <table width="100%">
                    <tr> 
                        <td style="padding: 5px;">Name</td>
                        <td style="padding: 5px;">Loan</td>
                        <td style="padding: 5px;">Amount</td>
                        <td style="padding: 5px;">Amortization</td>
                        <td style="padding: 5px;">Date Loaned</td>
                        <td style="padding: 5px;">Deduction Start</td>
                        <td style="padding: 5px;">Deduction End</td>
                        <td style="padding: 5px;">Starting Balance</td>
                    </tr>
                    <tr> 
                            <td style="padding: 5px;">{{$l->employee_name}}</td>
                            <td style="padding: 5px;">{{$l->loan_name}}</td>
                            <td style="padding: 5px;">{{number_format($l->loan_amount,2)}}</td>
                            <td style="padding: 5px;">{{number_format($l->amortization,2)}}</td>
                            <td style="padding: 5px;">{{$l->loan_date}}</td>
                            <td style="padding: 5px;">{{$l->date_deduct_start}}</td>
                            <td style="padding: 5px;">{{$l->date_deduct_end}}</td>
                            <td style="padding: 5px;">{{number_format($l->loan_balance,2)}}</td>
                        </tr>
                </table>
            </div>
            <form class="form-some-up form-block">

                <div class="modal-body">

			<div class="row">
                     
	                    <div class="col-lg-12">
                                <table width="100%" class="table data-table table-hover table-ultra-responsive">
                                    <thead>
                                        <tr>
                                            <th width="3%" style="padding: 2x;">No.</th>
                                            <th>Payroll Description</th>
                                            <th>Year / Month</th>
                                            <th>Deduction</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <?php  $total_deductions = 0; ?>
                                            @foreach($payrolls_loans as $p)
                                            <tr>
                                                <td style="padding: 5px;" width="20px style="padding: 2x;" > {{$no}}.</td>
                                                <td style="padding: 5px;"align="left" width="55%" > {{ DB::table('payroll_period')->where('payroll_period_id', $p->payroll_period_id)->value('description') }} </td>
                                                <td style="padding: 5px;" align="center" width="18%"> {{ DB::table('payroll_period')->where('payroll_period_id', $p->payroll_period_id)->value('fsyear') }} - {{ getMonthName(DB::table('payroll_period')->where('payroll_period_id', $p->payroll_period_id)->value('fsmonth')) }} </td>
                                                
                                                <?php
                                                    echo '<td style="padding: 5px;" align="right" width="5%">';
                                                        if ($l->loan_id==1) { 
                                                            echo number_format( $p->loan_1,2)  ;
                                                            $total_deductions = + $total_deductions + $p->loan_1;
                                                        }elseif ($l->loan_id==2)  {
                                                            echo number_format($p->loan_2,2)  ;
                                                            $total_deductions = + $total_deductions + $p->loan_2;
                                                        }elseif ($l->loan_id==3)  {
                                                            echo number_format($p->loan_3,2)  ;
                                                            $total_deductions = + $total_deductions + $p->loan_3;
                                                        }elseif ($l->loan_id==4)  {
                                                            echo number_format($p->loan_4,2)  ;
                                                            $total_deductions = + $total_deductions + $p->loan_4;
                                                        }elseif ($l->loan_id==5)  {
                                                            echo number_format($p->loan_5,2)  ;
                                                            $total_deductions = + $total_deductions + $p->loan_5;
                                                        }elseif ($l->loan_id==6)  {
                                                            echo number_format($p->loan_6,2)  ;
                                                            $total_deductions = + $total_deductions + $p->loan_6;
                                                        }elseif ($l->loan_id==7)  {
                                                            echo number_format($p->loan_7,2)  ;
                                                            $total_deductions = + $total_deductions + $p->loan_7;
                                                        }elseif ($l->loan_id==8)  {
                                                            echo number_format($p->loan_8,2)  ;
                                                            $total_deductions = + $total_deductions + $p->loan_8;
                                                        }elseif ($l->loan_id==9)  {
                                                            echo number_format($p->loan_9,2)  ;
                                                            $total_deductions = + $total_deductions + $p->loan_9;
                                                        }elseif ($l->loan_id==10)  {
                                                            echo number_format($p->loan_10,2)  ;
                                                            $total_deductions = + $total_deductions + $p->loan_10;
                                                        }elseif ($l->loan_id==11)  {
                                                            echo number_format($p->loan_11,2)  ;
                                                            $total_deductions = + $total_deductions + $p->loan_11;
                                                        }elseif ($l->loan_id==12)  {
                                                            echo number_format($p->loan_12,2)  ;
                                                            $total_deductions = + $total_deductions + $p->loan_12;
                                                        }elseif ($l->loan_id==13)  {
                                                            echo number_format($p->loan_13,2)  ;
                                                            $total_deductions = + $total_deductions + $p->loan_13;
                                                        }elseif ($l->loan_id==14)  {
                                                            echo number_format($p->loan_14,2)  ;
                                                            $total_deductions = + $total_deductions + $p->loan_14;
                                                        }elseif ($l->loan_id==15)  {
                                                            echo number_format($p->loan_15,2)  ;
                                                            $total_deductions = + $total_deductions + $p->loan_15;
                                                        }elseif ($l->loan_id==16)  {
                                                            echo number_format($p->loan_16,2)  ;
                                                            $total_deductions = + $total_deductions + $p->loan_16;
                                                        }elseif ($l->loan_id==17)  {
                                                            echo number_format($p->loan_17,2)  ;
                                                            $total_deductions = + $total_deductions + $p->loan_17;
                                                        }elseif ($l->loan_id==18)  {
                                                            echo number_format($p->loan_18,2)  ;
                                                            $total_deductions = + $total_deductions + $p->loan_18;
                                                        }elseif ($l->loan_id==19)  {
                                                            echo number_format($p->loan_19,2)  ;
                                                            $total_deductions = + $total_deductions + $p->loan_19;
                                                        }elseif ($l->loan_id==20)  {
                                                            echo number_format($p->loan_20,2) ;
                                                            $total_deductions = + $total_deductions + $p->loan_20;
                                                        }else{
                                                            echo "";
                                                        }
                                                    echo '</td>';
                                                    
                                                ?>
                                            </tr>
                                            <?php $no++ ?>
                                            @endforeach
                                            
                                        </tbody>
                                </table>

	                    </div>
	
	                   
	                    
	
	                </div>


                </div>
                <div class="modal-footer">
                    <span class="pull-left" style="font-size:14px; font-weight: bold;">Total Deduction: {{number_format($total_deductions,2)}}</span>
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{language_data('Close')}}</button>
                </div>

            </form>
        </div>
    </div>

</div>

