<?php

namespace App\Http\Controllers;

use App\Classes\permission;
use App\Employee;
use App\Leave;
use App\LeaveType;
use App\LeaveLedger;
use Illuminate\Http\Request;

use DB;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
date_default_timezone_set(app_config('Timezone'));
class LeaveController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    /* leave  Function Start Here */
    public function leave($status)
    {
        $self='leave-application';
        if (\Auth::user()->user_name!=='admin'){
            $get_perm=permission::permitted($self);

            if ($get_perm=='access denied'){
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important'=>true
                ]);
            }
        }

        $employee=Employee::where('status','active')->where('user_name','!=','admin')->get();
        $leave_type=LeaveType::all();
        $leave=Leave::where('status',$status)->orderby('id','desc')->get();
        return view('leave.leave',compact('leave','leave_type','employee','status'));
    }

        /* leave  Function Start Here */
        public function leaveLedger($employee_id)
        {
            $self='leave-application';
            if (\Auth::user()->user_name!=='admin'){
                $get_perm=permission::permitted($self);
    
                if ($get_perm=='access denied'){
                    return redirect('permission-error')->with([
                        'message' => language_data('You do not have permission to view this page'),
                        'message_important'=>true
                    ]);
                }
            }
    
            $employee=Employee::where('status','active')->where('user_name','!=','admin')->get();
            $ledgers=LeaveLedger::where('employee_id',\Auth::user()->id)->where('year',DB::table('sys_leave_setup')->where('id', 1)->value('year_active'))->orderby('id','asc')->get();
            $leave=Leave::all();
            return view('leave.view-leave-ledger',compact('leave','ledgers'));
        }

    /* viewLeave  Function Start Here */
    public function viewLeave($id)
    {
        $self='leave-application';
        if (\Auth::user()->user_name!=='admin'){
            $get_perm=permission::permitted($self);

            if ($get_perm=='access denied'){
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important'=>true
                ]);
            }
        }

        $leave=Leave::find($id);

        return view('leave.view-leave-application',compact('leave'));

    }



    //======================================================================
    // postNewLeave Function Start Here
    //======================================================================
    public function postNewLeave(Request $request){
        $v=\Validator::make($request->all(),[
            'employee'=>'required','leave_type'=>'required','leave_from'=>'required','leave_to' => 'required','status'=>'required'
        ]);


        if ($v->fails()) {
            return redirect('leave')->withErrors($v->errors());
        }

        $leave_from=date('Y-m-d',strtotime($request->leave_from));
        $leave_to=date('Y-m-d',strtotime($request->leave_to));


        $leave = new Leave();
        $leave->emp_id = $request->employee;
        $leave->leave_from = $leave_from;
        $leave->leave_to = $leave_to;
        $leave->ltype_id = $request->leave_type;
        $leave->applied_on = date('Y-m-d');
        $leave->leave_reason = $request->leave_reason;
        $leave->status = $request->status;



        $leave->leave_from_ampm = $request->leave_from_ampm;
        $leave->leave_to_ampm = $request->leave_to_ampm;

        //compute day difference excluding weekends
        $start = new \DateTime($leave_from);
        $end = new \DateTime($leave_to);

        $end->modify('+1 day');
        $interval = $end->diff($start);

        $days = $interval->days;
        $period = new \DatePeriod($start, new \DateInterval('P1D'), $end);
        foreach($period as $dt) {
            $curr = $dt->format('D');

            if ($curr == 'Sat' || $curr == 'Sun') {
                $days--;
            }
        }

        //end day compuation

        if ($request->leave_from_ampm=="afternoon"){
            $days = $days - 0.5;
        }
        if ($request->leave_to_ampm=="morning"){
            $days = $days - 0.5;
        }


        $leave->days = $days;
        $leave->points = $days;


        // if($leave){
        //     $leave->status=$request->status;
        //     $leave->remark=$request->remark;
        //     $leave->date_approved = $request->date_approved;

        //     try {
        //         if ($request->status=="approved"){
        //             $leave_ledger = LeaveLedger::where('employee_id',\Auth::user()->id)->orderby('id','desc')->first();
        //             if ($leave_ledger){
        //                 if($leave->ltype_id==1){ //Sick Leave
        //                     if ($leave_ledger->sl_balance > $leave->points){
        //                         $leave_ledger->sl_balance = $leave_ledger->sl_balance - $leave->points;
        //                     }elseif($leave_ledger->sl_balance>0){
        //                         $leave->points = $leave->points - $leave_ledger->sl_balance;
        //                         $leave_ledger->sl_deduct_wopay = $leave_ledger->sl_deduct_wopay + $leave->points;
        //                         $leave_ledger->sl_balance = 0;
        //                     }else{
        //                         $leave_ledger->sl_deduct_wopay = $leave_ledger->sl_deduct_wopay + $leave->points;
        //                         $leave_ledger->sl_balance = 0;
        //                     }
        //                     $leave_ledger_new = new LeaveLedger();

        //                     $approved = new \DateTime($leave->date_approved);

        //                     $leave_ledger_new->employee_id = $leave_ledger->employee_id;
        //                     $leave_ledger_new->year = $leave_ledger->year;
        //                     $leave_ledger_new->period =date_format($approved, "M-d-Y");
        //                     $leave_ledger_new->particular = "(" .  $leave->days . "-0-0) SL";
        //                     $leave_ledger_new->particular_code = "SL";
    
        //                     $leave_ledger_new->vl_balance = $leave_ledger->vl_balance;
        //                     $leave_ledger_new->vl_deduct_wopay = $leave_ledger->vl_deduct_wopay;
    
        //                     $leave_ledger_new->sl_leave_id = $leave->id;
        //                     $leave_ledger_new->sl_deduct = $leave->points;
        //                     $leave_ledger_new->sl_balance = $leave_ledger->sl_balance;
        //                     $leave_ledger_new->sl_deduct_wopay = $leave_ledger->sl_deduct_wopay;
        //                     $leave_ledger_new->save();
        //                     // dd($leave_ledger_new);
    
        //                 }
        //                 if($leave->ltype_id==2){ //Vacation Leave
        //                     if ($leave_ledger->vl_balance > $leave->points){
        //                         $leave_ledger->vl_balance = $leave_ledger->vl_balance - $leave->points;
        //                     }elseif($leave_ledger->vl_balance>0){
        //                         $leave->points = $leave->points - $leave_ledger->vl_balance;
        //                         $leave_ledger->vl_deduct_wopay = $leave_ledger->vl_deduct_wopay + $leave->points;
        //                         $leave_ledger->vl_balance = 0;
        //                     }else{
        //                         $leave_ledger->vl_deduct_wopay = $leave_ledger->vl_deduct_wopay + $leave->points;
        //                         $leave_ledger->vl_balance = 0;
        //                     }
                            
        //                     $leave_ledger_new = new LeaveLedger();

        //                     $approved = new \DateTime($leave->date_approved);

        //                     $leave_ledger_new->employee_id = $leave_ledger->employee_id;
        //                     $leave_ledger_new->year = $leave_ledger->year;
        //                     $leave_ledger_new->period = date_format($approved, "M-d-Y");
        //                     $leave_ledger_new->particular = "(" .  $leave->days . "-0-0) VL";
        //                     $leave_ledger_new->particular_code = "VL";
    
        //                     $leave_ledger_new->sl_balance = $leave_ledger->sl_balance;
        //                     $leave_ledger_new->sl_deduct_wopay = $leave_ledger->sl_deduct_wopay;
    
        //                     $leave_ledger_new->vl_leave_id = $leave->id;
        //                     $leave_ledger_new->vl_deduct = $leave->points;
        //                     $leave_ledger_new->vl_balance = $leave_ledger->vl_balance;
        //                     $leave_ledger_new->vl_deduct_wopay = $leave_ledger->vl_deduct_wopay;
        //                     $leave_ledger_new->save();
        //                     // dd($leave_ledger_new);
        //                 }
        //             }
        //         }
                
        //     } catch (Exception $e) {
        //         echo 'Caught exception: ',  $e->getMessage(), "\n";
        //     }
        // }

        $leave->save();

        return redirect('leave/'.$request->status)->with([
            'message' => language_data('Leave added Successfully')
        ]);

    }


    /* postJobStatus  Function Start Here */
    public function postJobStatus(Request $request)
    {
        $self='leave-application';
        if (\Auth::user()->user_name!=='admin'){
            $get_perm=permission::permitted($self);

            if ($get_perm=='access denied'){
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important'=>true
                ]);
            }
        }


        $cmd=Input::get('cmd');
        $v=\Validator::make($request->all(),[
            'status'=>'required'
        ]);

        if($v->fails()){
            return redirect('leave/edit/'.$cmd)->withErrors($v->errors());
        }

        $leave_view = "";
        if (session('portal')=="master"){
            $leave_view = "leave/".$request->status;
        }else{
            $leave_view = "employee/leave";
        }

        $leave=Leave::find($cmd);
        if($leave){
            
            $leave->remark=$request->remark;
            $leave->date_approved = $request->date_approved;
            if ($leave->status<>"approved") {
                try {
                    if ($request->status=="approved"){
                        $leave->status=$request->status;
                        $leave_ledger = LeaveLedger::where('employee_id',$leave->emp_id)->orderby('id','desc')->first();
                        if ($leave_ledger){
                            if($leave->ltype_id==1){ //Sick Leave
                                if ($leave_ledger->sl_balance > $leave->points){
                                    $leave_ledger->sl_balance = $leave_ledger->sl_balance - $leave->points;
                                }elseif($leave_ledger->sl_balance>0){
                                    $leave->points = $leave->points - $leave_ledger->sl_balance;
                                    $leave_ledger->sl_deduct_wopay = $leave_ledger->sl_deduct_wopay + $leave->points;
                                    $leave_ledger->sl_balance = 0;
                                }else{
                                    $leave_ledger->sl_deduct_wopay = $leave_ledger->sl_deduct_wopay + $leave->points;
                                    $leave_ledger->sl_balance = 0;
                                }
                                $leave_ledger_new = new LeaveLedger();

                                $approved = new \DateTime($leave->date_approved);

                                $leave_ledger_new->employee_id = $leave_ledger->employee_id;
                                $leave_ledger_new->year = $leave_ledger->year;
                                $leave_ledger_new->period =date_format($approved, "M-d-Y");
                                $leave_ledger_new->particular = "(" .  $leave->days . "-0-0) SL";
                                $leave_ledger_new->particular_code = "SL";
        
                                $leave_ledger_new->vl_balance = $leave_ledger->vl_balance;
                                $leave_ledger_new->vl_deduct_wopay = $leave_ledger->vl_deduct_wopay;
        
                                $leave_ledger_new->sl_leave_id = $leave->id;
                                $leave_ledger_new->sl_deduct = $leave->points;
                                $leave_ledger_new->sl_balance = $leave_ledger->sl_balance;
                                $leave_ledger_new->sl_deduct_wopay = $leave_ledger->sl_deduct_wopay;
                                $leave_ledger_new->save();
                                // dd($leave_ledger_new);
        
                            }
                            if($leave->ltype_id==2){ //Vacation Leave
                                if ($leave_ledger->vl_balance > $leave->points){
                                    $leave_ledger->vl_balance = $leave_ledger->vl_balance - $leave->points;
                                }elseif($leave_ledger->vl_balance>0){
                                    $leave->points = $leave->points - $leave_ledger->vl_balance;
                                    $leave_ledger->vl_deduct_wopay = $leave_ledger->vl_deduct_wopay + $leave->points;
                                    $leave_ledger->vl_balance = 0;
                                }else{
                                    $leave_ledger->vl_deduct_wopay = $leave_ledger->vl_deduct_wopay + $leave->points;
                                    $leave_ledger->vl_balance = 0;
                                }
                                
                                $leave_ledger_new = new LeaveLedger();

                                $approved = new \DateTime($leave->date_approved);

                                $leave_ledger_new->employee_id = $leave_ledger->employee_id;
                                $leave_ledger_new->year = $leave_ledger->year;
                                $leave_ledger_new->period = date_format($approved, "M-d-Y");
                                $leave_ledger_new->particular = "(" .  $leave->days . "-0-0) VL";
                                $leave_ledger_new->particular_code = "VL";
        
                                $leave_ledger_new->sl_balance = $leave_ledger->sl_balance;
                                $leave_ledger_new->sl_deduct_wopay = $leave_ledger->sl_deduct_wopay;
        
                                $leave_ledger_new->vl_leave_id = $leave->id;
                                $leave_ledger_new->vl_deduct = $leave->points;
                                $leave_ledger_new->vl_balance = $leave_ledger->vl_balance;
                                $leave_ledger_new->vl_deduct_wopay = $leave_ledger->vl_deduct_wopay;
                                $leave_ledger_new->save();
                                // dd($leave_ledger_new);
                            }
                        }
                       
                    }
                    
                } catch (Exception $e) {
                    echo 'Caught exception: ',  $e->getMessage(), "\n";
                }
            }
           

            $leave->save();

            
            return redirect($leave_view)->with([
                'message'=>language_data('Status updated successfully')
            ]);
        }else{
            return redirect($leave_view)->with([
                'message'=> language_data('Leave Application not found'),
                'message_important'=>true
            ]);
        }
    }

    /* deleteLeaveApplication  Function Start Here */
    public function deleteLeaveApplication($id)
    {
        $appStage=app_config('AppStage');
        if($appStage=='Demo'){
            return redirect('leave')->with([
                'message' => language_data('This Option is Disable In Demo Mode'),
                'message_important'=>true
            ]);
        }

        $self='leave-application';
        if (\Auth::user()->user_name!=='admin'){
            $get_perm=permission::permitted($self);

            if ($get_perm=='access denied'){
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important'=>true
                ]);
            }
        }

        $leave_view = "";
        if (session('portal')=="master"){
            $leave_view = "leave";
        }else{
            $leave_view = "employee/leave";
        }

        $leave=Leave::find($id);
        if($leave){
            $leave->delete();
            return redirect($leave_view)->with([
                'message'=> language_data('Leave Application Deleted Successfully')
            ]);
        }else{
            return redirect($leave_view)->with([
                'message'=>'Leave Application not found',
                'message_important'=>true
            ]);
        }
    }


}
