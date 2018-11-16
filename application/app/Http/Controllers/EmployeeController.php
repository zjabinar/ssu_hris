<?php

namespace App\Http\Controllers;

use App\Attendance;
use App\Classes\permission;
use App\Department;
use App\Designation;
use App\EmailTemplate;
use App\Employee;
use App\EmployeeBankAccount;
use App\EmployeeFiles;
use App\EmployeeRoles;
use App\EmployeeRolesPermission;

use App\PdsFamily;
use App\PdsEligibility;
use App\PdsExperience;
use App\EmployeeTraining;
use App\PdsTraining;
use App\PdsOrganization;
use App\PdsSkill;
use App\PdsRecognition;
use App\PdsMembership;
use App\PdsReference;

use App\IpcrPeriod;
use App\IpcrEmployee;

use App\IpcrGroup;
use App\IpcrGroupsMember;

use App\IpcrRating;
use App\IpcrRatingsDetail;
use App\IpcrMfoGroup;
use App\LeaveLedger;

use DB;
use App\Http\Requests;
use App\TaxRules;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
date_default_timezone_set(app_config('Timezone'));
class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }


    /* allEmployees  Function Start Here */
    public function allEmployees()
    {
        $self='employees';
        if (\Auth::user()->user_name!=='admin'){
            $get_perm=permission::permitted($self);

            if ($get_perm=='access denied'){
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important'=>true
                ]);
            }
        }

        $check_status=Employee::where('status','active')->where('user_name','!=','admin')->get();
        // if ($check_status){
        //     foreach ($check_status as $cs){
        //         $leave_date=$cs->dol;
        //         if ($leave_date){
        //             if (strtotime($leave_date) < strtotime('now')){
        //                 $cs->status='inactive';
        //                 $cs->save();
        //             }
        //         }

        //     }
        // }

        $employees = Employee::where('user_name', '!=', 'admin')->get();
        return view('admin.employees', compact('employees'));
    }

    /* addEmployee  Function Start Here */
    public function addEmployee()
    {

        $self='add-employee';
        if (\Auth::user()->user_name!=='admin'){
            $get_perm=permission::permitted($self);

            if ($get_perm=='access denied'){
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important'=>true
                ]);
            }
        }

        $department=Department::all();
        $tax=TaxRules::where('status','active')->get();
        $role=EmployeeRoles::where('status','Active')->get();
        return view('admin.add-employee', compact('department','tax','role'));
    }

    /* addEmployeePost  Function Start Here */
    public function addEmployeePost(Request $request)
    {

        $self='add-employee';
        if (\Auth::user()->user_name!=='admin'){
            $get_perm=permission::permitted($self);

            if ($get_perm=='access denied'){
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important'=>true
                ]);
            }
        }


        $v = \Validator::make($request->all(), [
            'firstname' => 'required',  'department' => 'required','designation' => 'required',  'role' => 'required'
        ]);

        if ($v->fails()) {
            return redirect('employees/add')->withErrors($v->errors());
        }

        $employee_code = Input::get('employee_code');
        if ($employee_code != '') {
            $exist = Employee::where('employee_code', '=', $employee_code)->first();
            if ($exist) {
                return redirect('employees/add')->with([
                    'message' => language_data('Employee Code Already Exist'),
                    'message_important' => true
                ]);
            }
        }

        $username = Input::get('username');
        if ($username != '') {
            $exist = Employee::where('user_name', '=', $username)->first();
            if ($exist) {
                return redirect('employees/add')->with([
                    'message' => language_data('Username Already Exist'),
                    'message_important' => true
                ]);
            }
        }
        $email = Input::get('email');
        if ($email != '') {
            $exist = Employee::where('email', '=', $email)->first();
            if ($exist) {
                return redirect('employees/add')->with([
                    'message' => language_data('Email Already Exist'),
                    'message_important' => true
                ]);
            }
        }

        $passowrd = Input::get('password');
        $rpassowrd = Input::get('rpassword');

        if ($passowrd != '') {
            if ($passowrd != $rpassowrd) {
                return redirect('employees/add')->with([
                    'message' => language_data('Both Password Does not Match'),
                    'message_important' => true
                ]);
            }
        }

        $employee = new Employee();
        $employee->firstname = $request->firstname;
        $employee->lastname = $request->lastname;
        $employee->firstname = $request->firstname;
        $employee->lastname = $request->lastname;
        $employee->middlename = $request->middlename;
        // $employee->extension = $request->extension;

        $mi = substr($request->middlename, 0,1) . ".";
        $fullname = ucfirst($request->lastname) . ", " . ucfirst($request->firstname) . " " . ucfirst($mi) ;
        $employee->user_name = $username;
        $employee->email = $email;
        $employee->password = bcrypt($passowrd);
        $employee->designation = $request->designation;
        $employee->department_id = $request->department;
        $employee->role_id = $request->role;
        // $employee->tax_id = $request->tax;
        $employee->gender = $request->gender;
        $employee->save();


        /*For Email Confirmation*/

        $conf = EmailTemplate::where('tplastname', '=', 'Employee SignUp')->first();

        $estatus = $conf->status;

        if ($estatus == '1') {

            $sysEmail = app_config('Email');
            $sysCompany = app_config('AppName');
            $sysUrl = url('/');

            $template = $conf->message;
            $subject = $conf->subject;
            $employee_name=$request->firstname . $request->lastname;
            $data = array(
                'name' => $employee_name,
                'business_name' => $sysCompany,
                'from' => $sysEmail,
                'username' => $username,
                'email' => $email,
                'password' => $passowrd,
                'sys_url' => $sysUrl,
                'template' => $template
            );

            $message = _render($template, $data);
            $mail_subject = _render($subject, $data);
            $body = $message;

            /*Set Authentication*/

            $default_gt = app_config('Gateway');

            if ($default_gt == 'default') {

                $mail=new \PHPMailer();

                $mail->setFrom($sysEmail, $sysCompany);
                $mail->addAddress($email, $employee_name);     // Add a recipient
                $mail->isHTML(true);                                  // Set email format to HTML

                $mail->Subject = $mail_subject;
                $mail->Body    = $body;

                if(!$mail->send()) {
                    return redirect('employees/all')->with([
                        'message' => language_data('Employee Added Successfully But Email Not Send')
                    ]);
                } else {
                    return redirect('employees/all')->with([
                        'message' => language_data('Employee Added Successfully')
                    ]);
                }

            }
            else {
                $host = app_config('SMTPHostName');
                $smtp_username = app_config('SMTPUserName');
                $stmp_password = app_config('SMTPPassword');
                $port = app_config('SMTPPort');
                $secure = app_config('SMTPSecure');


                $mail=new \PHPMailer();

                $mail->isSMTP();                                      // Set mailer to use SMTP
                $mail->Host = $host;  // Specify main and backup SMTP servers
                $mail->SMTPAuth = true;                               // Enable SMTP authentication
                $mail->Username = $smtp_username;                 // SMTP username
                $mail->Password = $stmp_password;                           // SMTP password
                $mail->SMTPSecure = $secure;                            // Enable TLS encryption, `ssl` also accepted
                $mail->Port = $port;

                $mail->setFrom($sysEmail, $sysCompany);
                $mail->addAddress($email, $employee_name);     // Add a recipient
                $mail->isHTML(true);                                  // Set email format to HTML

                $mail->Subject = $mail_subject;
                $mail->Body    = $body;

                if(!$mail->send()) {
                    return redirect('employees/all')->with([
                        'message' => language_data('Employee Added Successfully But Email Not Send')
                    ]);
                } else {
                    return redirect('employees/all')->with([
                        'message' => language_data('Employee Added Successfully')
                    ]);
                }

            }
        }

        return redirect('employees/all')->with([
            'message' => language_data('Employee Added Successfully')
        ]);
    }


    /* viewEmployee  Function Start Here */
    public function viewEmployee($id)
    {

        $self='update-employee';
        if (\Auth::user()->user_name!=='admin'){
            $get_perm=permission::permitted($self);

            if ($get_perm=='access denied'){
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important'=>true
                ]);
            }
        }


        $employee = Employee::find($id);

        if ($employee) {
            $designation = Designation::all();
            $department=Department::all();
            $tax=TaxRules::where('status','active')->get();
            $role=EmployeeRoles::where('status','Active')->get();

            $bank_accounts=EmployeeBankAccount::where('emp_id',$id)->get();
            $employee_doc=EmployeeFiles::where('emp_id',$id)->get();

            return view('admin.view-employee', compact('employee', 'designation','department','bank_accounts','employee_doc','tax','role'));
        } else {
            return redirect('employees/all')->with([
                'message' => language_data('Employee Not Found'),
                'message_important' => true
            ]);
        }
    }


    /* postEmployeePersonalInfo  Function Start Here */
    public function postEmployeePersonalInfo(Request $request)
    {
        $self='update-employee';
        if (\Auth::user()->user_name!=='admin'){
            $get_perm=permission::permitted($self);

            if ($get_perm=='access denied'){
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important'=>true
                ]);
            }
        }


        $cmd = Input::get('cmd');
        $appStage=app_config('AppStage');
        if($appStage=='Demo'){
            return redirect('employees/view/'.$cmd)->with([
                'message' => language_data('You do not have permission to view this page'),
                'message_important'=>true
            ]);
        }

        $v = \Validator::make($request->all(), [
            'firstname' => 'required',  'designation' => 'required',  'role' => 'required'
        ]);

        if ($v->fails()) {
            return redirect('employees/view/' . $cmd)->withErrors($v->errors());
        }

        $employee = Employee::find($cmd);

        $employee_code = Input::get('employee_code');
        $exist_emp_code = $employee->employee_code;
        if ($employee_code != '' AND $employee_code != $exist_emp_code) {
            $exist = Employee::where('employee_code', '=', $employee_code)->first();
            if ($exist) {
                return redirect('employees/view/' . $cmd)->with([
                    'message' => language_data('Employee Code Already Exist'),
                    'message_important' => true
                ]);
            }
        }

        $username = Input::get('username');
        $exist_user_name = $employee->user_name;
        if ($username != '' AND $username != $exist_user_name) {
            $exist = Employee::where('user_name', '=', $username)->first();
            if ($exist) {
                return redirect('employees/view/' . $cmd)->with([
                    'message' => language_data('Username Already Exist'),
                    'message_important' => true
                ]);
            }
        }
        $email = Input::get('email');
        $exist_email = $employee->email;
        if ($email != '' AND $email != $exist_email) {
            $exist = Employee::where('email', '=', $email)->first();
            if ($exist) {
                return redirect('employees/view/' . $cmd)->with([
                    'message' => language_data('Email Already Exist'),
                    'message_important' => true
                ]);
            }
        }

        $passowrd = Input::get('password');
        $rpassowrd = Input::get('rpassword');

        if ($passowrd != '') {
            if ($passowrd != $rpassowrd) {
                return redirect('employees/view/' . $cmd)->with([
                    'message' => language_data('Both Password Does not Match'),
                    'message_important' => true
                ]);
            } else {
                $passowrd = bcrypt($passowrd);
            }
        } else {
            $passowrd = $employee->password;
        }



        $date_join=date('Y-m-d',strtotime($request->hired_date));
        $birthdate=date('Y-m-d',strtotime($request->birthdate));



        $employee->firstname = $request->firstname;
        $employee->lastname = $request->lastname;
        $employee->email = $email;
        // $employee->employee_code = $employee_code;
        $employee->user_name = $username;

        $employee->firstname = $request->firstname;
        $employee->lastname = $request->lastname;
        $employee->middlename = $request->middlename;
        // $employee->extension = $request->extension;

        $mi = substr($request->middlename, 0,1) . ".";
        $fullname = ucfirst($request->lastname) . ", " . ucfirst($request->firstname) . " " . ucfirst($mi) ;
        $employee->fullname = $fullname;
       
        $employee->password = $passowrd;
        $employee->designation = $request->designation;
        $employee->role_id = $request->role;
        $employee->hired_date = $date_join;
        $employee->phone = $request->phone;
        // $employee->phone2 = $request->phone2;
        // $employee->status = $status;
        // $employee->father_name = $request->father_name;
        // $employee->mother_name = $request->mother_name;
        $employee->birthdate = $birthdate;
        // $employee->tax_id = $request->tax;
        $employee->gender = $request->gender;
        // $employee->pre_address = $request->pre_address;
        // $employee->per_address = $request->per_address;

        $employee->save();

        return redirect('employees/all')->with([
            'message' => language_data('Employee Updated Successfully')
        ]);


    }

    /* updateEmployeeAvatar  Function Start Here */
    public function updateEmployeeAvatar(Request $request)
    {
        $cmd = Input::get('cmd');
        $appStage=app_config('AppStage');
        if($appStage=='Demo'){
            return redirect('employees/view/'.$cmd)->with([
                'message' => language_data('You do not have permission to view this page'),
                'message_important'=>true
            ]);
        }

        $self='update-employee';
        if (\Auth::user()->user_name!=='admin'){
            $get_perm=permission::permitted($self);

            if ($get_perm=='access denied'){
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important'=>true
                ]);
            }
        }


        $v = \Validator::make($request->all(), [
            'image' => 'required', 'cmd' => 'required'
        ]);

        if ($v->fails()) {
            return redirect('employees/view/' . $cmd)->withErrors($v->errors());
        }

        $image = Input::file('image');

        $employee = Employee::find($cmd);

        if ($employee) {
            if ($image != '') {
                $destinationPath = public_path() . '/assets/employee_pic/';
                $image_name = $image->getClientOriginalastname();
                Input::file('image')->move($destinationPath, $image_name);

                $employee->avatar = $image_name;
                $employee->save();

                return redirect('employees/view/' . $cmd)->with([
                    'message' => language_data('Avatar Changed Successfully')
                ]);

            } else {
                return redirect('employees/view/' . $cmd)->with([
                    'message' => language_data('Upload an Image'),
                    'message_important' => true
                ]);
            }
        } else {
            return redirect('employees/all')->with([
                'message' => language_data('Employee Not Found'),
                'message_important' => true
            ]);
        }
    }


    /* getDesignation  Function Start Here */
    public function getDesignation(Request $request)
    {
        $dep_id = $request->dep_id;
        if ($dep_id) {
            $designation = Designation::where('did', $dep_id)->get();
            foreach ($designation as $d) {
                echo '<option value="' . $d->id . '">' . $d->designation . '</option>';
            }
        }
    }

    /* addBankInfo  Function Start Here */
    public function addBankInfo(Request $request)
    {

        $self='update-employee';
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
            'bank_name'=>'required','branch_name'=>'required','account_name'=>'required','account_number'=>'required'
        ]);

        if($v->fails()){
            return redirect('employees/view/'.$cmd)->withErrors($v->errors());
        }


        $employee_bank=EmployeeBankAccount::firstOrCreate(['emp_id'=>$cmd,'bank_name'=>$request->bank_name,'branch_name'=>$request->branch_name,'account_name'=>$request->account_name,'account_number'=>$request->account_number,'ifsc_code'=>$request->ifsc_code,'pan_no'=>$request->pan_number]);

        if($employee_bank->wasRecentlyCreated){
            return redirect('employees/view/'.$cmd)->with([
                'message'=>language_data('Bank Account Added Successfully')
            ]);

        }else{
            return redirect('employees/view/'.$cmd)->with([
                'message'=>language_data('Bank Account Already Exist'),
                'message_important'=>true
            ]);
        }
    }


/* add Child  Function Start Here */
public function addChild(Request $request)
{

    $self='update-employee';

    $cmd=Input::get('cmd');
    $v=\Validator::make($request->all(),[
        'name'=>'required','birthdate'=>'required'
    ]);

    if($v->fails()){
        return redirect('employee/edit-pds')->withErrors($v->errors());
    }

    $bod = get_date_format($request->birthdate);


    $child=PdsFamily::firstOrCreate(['emp_id'=>$cmd,'name'=>$request->name,'birthdate'=>$request->birthdate]);

    if($child->wasRecentlyCreated){
        return redirect('employee/edit-pds')->with([
            'message'=>"Child Added Successfully"
        ]);

    }else{
        return redirect('employee/edit-pds')->with([
            'message'=>"Child Already Exist",
            'message_important'=>true
        ]);
    }
}

  /* deleteChild  Function Start Here */
  public function deleteChild($id)
  {

      $self='update-employee';

      $child=PdsFamily::find($id);
      $cmd=$child->emp_id;
      if($child){
          $child->delete();

          return redirect('employee/edit-pds')->with([
              'message'=>"Child Deleted Successfully"
          ]);

      }else{
        return redirect('employee/edit-pds')->with([
              'message'=>"Child Not Found",
              'message_important'=>true
          ]);
      }
  }




  /* add Eligibility  Function Start Here */
public function addEligibility(Request $request)
{

    $self='update-employee';

    $cmd=Input::get('cmd');
    $v=\Validator::make($request->all(),[
        'elig_name'=>'required'
    ]);

    if($v->fails()){
        return redirect('employee/edit-pds')->withErrors($v->errors());
    }



    $child=PdsEligibility::firstOrCreate(['emp_id'=>$cmd,'elig_name'=>$request->elig_name,'elig_rating'=>$request->elig_rating, 'elig_date'=>$request->elig_date, 'elig_place'=>$request->elig_place, 'elig_license'=>$request->elig_license, 'elig_expiry'=>$request->elig_expiry ]);

    if($child->wasRecentlyCreated){
        return redirect('employee/edit-pds')->with([
            'message'=>"Eligibility Added Successfully"
        ]);

    }else{
        return redirect('employee/edit-pds')->with([
            'message'=>"Eligibility Already Exist",
            'message_important'=>true
        ]);
    }
}

  /* deleteEligibility  Function Start Here */
  public function deleteEligibility($id)
  {

      $self='update-employee';

      $eligibility=PdsEligibility::find($id);
      $cmd=$eligibility->emp_id;
      if($eligibility){
          $eligibility->delete();

          return redirect('employee/edit-pds')->with([
              'message'=>"Eligibility Deleted Successfully"
          ]);

      }else{
        return redirect('employee/edit-pds')->with([
              'message'=>"Eligibility Not Found",
              'message_important'=>true
          ]);
      }
  }



   /* add Experience  Function Start Here */
public function addExperience(Request $request)
{

    $self='update-employee';

    $cmd=Input::get('cmd');
    $v=\Validator::make($request->all(),[
        'work_from'=>'required', 'work_to'=>'required', 'work_company'=>'required'
    ]);

    if($v->fails()){
        return redirect('employee/edit-pds')->withErrors($v->errors());
    }



    $experience=PdsExperience::firstOrCreate(['emp_id'=>$cmd,'work_from'=>$request->work_from,'work_to'=>$request->work_to, 'work_position'=>$request->work_position, 'work_company'=>$request->work_company, 'work_salary'=>$request->work_salary, 'work_grade'=>$request->work_grade, 'work_status'=>$request->work_status, 'work_is_gov'=>$request->work_is_gov ]);

    if($experience->wasRecentlyCreated){
        return redirect('employee/edit-pds')->with([
            'message'=>"Work Experience Added Successfully"
        ]);

    }else{
        return redirect('employee/edit-pds')->with([
            'message'=>"Work Expereince Already Exist",
            'message_important'=>true
        ]);
    }
}

  /* deleteExperience  Function Start Here */
  public function deleteExperience($id)
  {

      $self='update-employee';

      $experience=PdsExperience::find($id);
      $cmd=$experience->emp_id;
      if($experience){
          $experience->delete();

          return redirect('employee/edit-pds')->with([
              'message'=>"Work Experience Deleted Successfully"
          ]);

      }else{
        return redirect('employee/edit-pds')->with([
              'message'=>"Work Experience Not Found",
              'message_important'=>true
          ]);
      }
  }


    /* add Training  Function Start Here */
public function addTraining(Request $request)
{
    $self='update-employee';

    $cmd=Input::get('cmd');
    $v=\Validator::make($request->all(),[
        'train_title'=>'required', 'train_hours'=>'required'
    ]);

    if($v->fails()){
        return redirect('employee/edit-pds')->withErrors($v->errors());
    }

    $training=EmployeeTraining::firstOrCreate(['employee_id'=>$cmd,'title'=>$request->title,'training_from'=>$request->training_from, 'training_to'=>$request->training_to, 'training_hours'=>$request->training_hours, 'training_type'=>$request->training_type, 'sponsored_by'=>$request->sponsored_by, 'training_location'=>$request->training_location ]);

    if($training->wasRecentlyCreated){
        return redirect('employee/edit-pds')->with([
            'message'=>"Training/Seminar Added Successfully"
        ]);

    }else{
        return redirect('employee/edit-pds')->with([
            'message'=>"Training/Seminar Already Exist",
            'message_important'=>true
        ]);
    }
}

  /* deleteTraining  Function Start Here */
  public function deleteTraining($id)
  {

      $self='update-employee';

      $training=EmployeeTraining::find($id);
      $cmd=$training->emp_id;
      if($training){
          $training->delete();

          return redirect('employee/edit-pds')->with([
              'message'=>"Training/Seminar Deleted Successfully"
          ]);

      }else{
        return redirect('employee/edit-pds')->with([
              'message'=>"Training/Seminar Not Found",
              'message_important'=>true
          ]);
      }
  }


   /* add Organization  Function Start Here */
   public function addOrganization(Request $request)
   {
       $self='update-employee';
   
       $cmd=Input::get('cmd');
       $v=\Validator::make($request->all(),[
           'org_name'=>'required'
       ]);
   
       if($v->fails()){
           return redirect('employee/edit-pds')->withErrors($v->errors());
       }
   
       $organization=PdsOrganization::firstOrCreate(['emp_id'=>$cmd,'org_name'=>$request->org_name,'org_from'=>$request->org_from, 'org_to'=>$request->org_to, 'org_hours'=>$request->org_hours, 'org_position'=>$request->org_position ]);
   
       if($organization->wasRecentlyCreated){
           return redirect('employee/edit-pds')->with([
               'message'=>"Voluntary Work Added Successfully"
           ]);
   
       }else{
           return redirect('employee/edit-pds')->with([
               'message'=>"Voluntary Work Already Exist",
               'message_important'=>true
           ]);
       }
   }
   
     /* deleteOrganization  Function Start Here */
     public function deleteOrganization($id)
     {
   
         $self='update-employee';
   
         $organization=PdsOrganization::find($id);
         $cmd=$organization->emp_id;
         if($organization){
             $organization->delete();
   
             return redirect('employee/edit-pds')->with([
                 'message'=>"Voluntary Work Deleted Successfully"
             ]);
   
         }else{
           return redirect('employee/edit-pds')->with([
                 'message'=>"Voluntary Work Not Found",
                 'message_important'=>true
             ]);
         }
     }


 /* add Skill  Function Start Here */
 public function addSkill(Request $request)
 {
     $self='update-employee';
 
     $cmd=Input::get('cmd');
     $v=\Validator::make($request->all(),[
         'name'=>'required'
     ]);
 
     if($v->fails()){
         return redirect('employee/edit-pds')->withErrors($v->errors());
     }
 
     $skill=PdsSkill::firstOrCreate(['emp_id'=>$cmd,'name'=>$request->name ]);
 
     if($skill->wasRecentlyCreated){
         return redirect('employee/edit-pds')->with([
             'message'=>"Skill Added Successfully"
         ]);
 
     }else{
         return redirect('employee/edit-pds')->with([
             'message'=>"Skill Already Exist",
             'message_important'=>true
         ]);
     }
 }
 
   /* deleteSkill  Function Start Here */
   public function deleteSkill($id)
   {
 
       $self='update-employee';
 
       $skill=PdsSkill::find($id);
       $cmd=$skill->emp_id;
       if($skill){
           $skill->delete();
 
           return redirect('employee/edit-pds')->with([
               'message'=>"Skill Deleted Successfully"
           ]);
 
       }else{
         return redirect('employee/edit-pds')->with([
               'message'=>"Skill Not Found",
               'message_important'=>true
           ]);
       }
   }


   /* add Skill  Function Start Here */
 public function addRecognition(Request $request)
 {
     $self='update-employee';
 
     $cmd=Input::get('cmd');
     $v=\Validator::make($request->all(),[
         'name'=>'required'
     ]);
 
     if($v->fails()){
         return redirect('employee/edit-pds')->withErrors($v->errors());
     }
 
     $recognition=PdsRecognition::firstOrCreate(['emp_id'=>$cmd,'name'=>$request->name ]);
 
     if($recognition->wasRecentlyCreated){
         return redirect('employee/edit-pds')->with([
             'message'=>"Recognition Added Successfully"
         ]);
 
     }else{
         return redirect('employee/edit-pds')->with([
             'message'=>"Recognition Already Exist",
             'message_important'=>true
         ]);
     }
 }
 
   /* deleteSkill  Function Start Here */
   public function deleteRecognition($id)
   {
 
       $self='update-employee';
 
       $recognition=PdsRecognition::find($id);
       $cmd=$recognition->emp_id;
       if($recognition){
           $recognition->delete();
 
           return redirect('employee/edit-pds')->with([
               'message'=>"Recognition Deleted Successfully"
           ]);
 
       }else{
         return redirect('employee/edit-pds')->with([
               'message'=>"Recognition Not Found",
               'message_important'=>true
           ]);
       }
   }



     /* add Membership  Function Start Here */
 public function addMembership(Request $request)
 {
     $self='update-employee';
 
     $cmd=Input::get('cmd');
     $v=\Validator::make($request->all(),[
         'name'=>'required'
     ]);
 
     if($v->fails()){
         return redirect('employee/edit-pds')->withErrors($v->errors());
     }
 
     $membership=PdsMembershp::firstOrCreate(['emp_id'=>$cmd,'name'=>$request->name ]);
 
     if($membership->wasRecentlyCreated){
         return redirect('employee/edit-pds')->with([
             'message'=>"Membership Added Successfully"
         ]);
 
     }else{
         return redirect('employee/edit-pds')->with([
             'message'=>"Membership Already Exist",
             'message_important'=>true
         ]);
     }
 }
 
   /* deleteMembership  Function Start Here */
   public function deleteMembership($id)
   {
 
       $self='update-employee';
 
       $membership=PdsMembership::find($id);
       $cmd=$membership->emp_id;
       if($membership){
           $membership->delete();
 
           return redirect('employee/edit-pds')->with([
               'message'=>"Membership Deleted Successfully"
           ]);
 
       }else{
         return redirect('employee/edit-pds')->with([
               'message'=>"Membership Not Found",
               'message_important'=>true
           ]);
       }
   }


      /* add Reference  Function Start Here */
 public function addReference(Request $request)
 {
     $self='update-employee';
 
     $cmd=Input::get('cmd');
     $v=\Validator::make($request->all(),[
         'ref_name'=>'required'
     ]);
 
     if($v->fails()){
         return redirect('employee/edit-pds')->withErrors($v->errors());
     }
 
     $reference=PdsReference::firstOrCreate(['emp_id'=>$cmd,'ref_name'=>$request->ref_name, 'ref_address'=>$request->ref_address, 'ref_tel'=>$request->ref_tel ]);
 
     if($reference->wasRecentlyCreated){
         return redirect('employee/edit-pds')->with([
             'message'=>"Reference Added Successfully"
         ]);
 
     }else{
         return redirect('employee/edit-pds')->with([
             'message'=>"Reference Already Exist",
             'message_important'=>true
         ]);
     }
 }
 
   /* deleteReference  Function Start Here */
   public function deleteReference($id)
   {
 
       $self='update-employee';
 
       $reference=PdsReference::find($id);
       $cmd=$reference->emp_id;
       if($reference){
           $reference->delete();
 
           return redirect('employee/edit-pds')->with([
               'message'=>"Reference Deleted Successfully"
           ]);
 
       }else{
         return redirect('employee/edit-pds')->with([
               'message'=>"Reference Not Found",
               'message_important'=>true
           ]);
       }
   }


    /* deleteBankAccount  Function Start Here */
    public function deleteBankAccount($id)
    {

        $self='update-employee';
        if (\Auth::user()->user_name!=='admin'){
            $get_perm=permission::permitted($self);

            if ($get_perm=='access denied'){
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important'=>true
                ]);
            }
        }

        $emp_bank=EmployeeBankAccount::find($id);
        $cmd=$emp_bank->emp_id;
        if($emp_bank){
            $emp_bank->delete();

            return redirect('employees/view/'.$cmd)->with([
                'message'=>language_data('Bank Account Deleted Successfully')
            ]);

        }else{
            return redirect('employees/view/'.$cmd)->with([
                'message'=>language_data('Bank Account Not Found'),
                'message_important'=>true
            ]);
        }
    }

    /* addDocument  Function Start Here */
    public function addDocument(Request $request)
    {

        $self='update-employee';
        if (\Auth::user()->user_name!=='admin'){
            $get_perm=permission::permitted($self);

            if ($get_perm=='access denied'){
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important'=>true
                ]);
            }
        }

        $cmd = Input::get('cmd');

        $v = \Validator::make($request->all(), [
            'document_name' => 'required','file' => 'required', 'cmd' => 'required'
        ]);

        if ($v->fails()) {
            return redirect('employees/view/' . $cmd)->withErrors($v->errors());
        }

        $document_name=Input::get('document_name');
        $file = Input::file('file');

        $exist=EmployeeFiles::where('file_title',$document_name)->where('emp_id',$cmd)->first();

        if($exist){
            return redirect('employees/view/' . $cmd)->with([
                'message' => language_data('This Document Already Exist'),
                'message_important' => true
            ]);
        }

        $employee = Employee::find($cmd);

        if ($employee) {
            if ($file != '') {
                $destinationPath = public_path() . '/assets/employee_doc/';
                $file_name = $file->getClientOriginalastname();
                Input::file('file')->move($destinationPath, $file_name);

                $employee_doc=new EmployeeFiles();
                $employee_doc->emp_id=$cmd;
                $employee_doc->file_title=$document_name;
                $employee_doc->file=$file_name;
                $employee_doc->save();

                return redirect('employees/view/' . $cmd)->with([
                    'message' => language_data('Document Uploaded Successfully')
                ]);

            } else {
                return redirect('employees/view/' . $cmd)->with([
                    'message' => language_data('Upload an Image'),
                    'message_important' => true
                ]);
            }
        } else {
            return redirect('employees/all')->with([
                'message' => language_data('Employee Not Found'),
                'message_important' => true
            ]);
        }
    }

    /* downloadEmployeeDocument  Function Start Here */
    public function downloadEmployeeDocument($id)
    {

        $self='update-employee';
        if (\Auth::user()->user_name!=='admin'){
            $get_perm=permission::permitted($self);

            if ($get_perm=='access denied'){
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important'=>true
                ]);
            }
        }



        $file = EmployeeFiles::find($id)->file;
        return response()->download(public_path('assets/employee_doc/' . $file));
    }


    /* deleteEmployeeDoc  Function Start Here */
    public function deleteEmployeeDoc($id)
    {
        $self='update-employee';
        if (\Auth::user()->user_name!=='admin'){
            $get_perm=permission::permitted($self);

            if ($get_perm=='access denied'){
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important'=>true
                ]);
            }
        }

        $emp_doc=EmployeeFiles::find($id);
        $file=$emp_doc->file;
        $cmd=$emp_doc->emp_id;
        if($emp_doc){
            \File::delete(public_path('assets/employee_doc/' . $file));
            $emp_doc->delete();

            return redirect('employees/view/'.$cmd)->with([
                'message'=>language_data('Document Deleted Successfully')
            ]);

        }else{
            return redirect('employees/view/'.$cmd)->with([
                'message'=>language_data('Document Not Found'),
                'message_important'=>true
            ]);
        }
    }

    /* deleteEmployee  Function Start Here */
    public function deleteEmployee($id)
    {

        $appStage=app_config('AppStage');
        if($appStage=='Demo'){
            return redirect('employees/all')->with([
                'message' => language_data('You do not have permission to view this page'),
                'message_important'=>true
            ]);
        }

        $self='delete-employee';
        if (\Auth::user()->user_name!=='admin'){
            $get_perm=permission::permitted($self);

            if ($get_perm=='access denied'){
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important'=>true
                ]);
            }
        }

        $employee=Employee::find($id);
        if ($employee) {
            EmployeeBankAccount::where('emp_id',$id)->delete();
            $employee_doc=EmployeeFiles::where('emp_id',$id)->get();

            foreach($employee_doc as $ed){
                \File::delete(public_path('assets/employee_doc/' . $ed->file));
                $ed->delete();
            }
            \File::delete(public_path('assets/employee_pic/' . $employee->avatar));

            $employee->delete();

            return redirect('employees/all')->with([
                'message' => language_data('Employee Deleted Successfully')
            ]);

        } else {
            return redirect('employees/all')->with([
                'message' => language_data('Employee Not Found'),
                'message_important' => true
            ]);
        }
    }


    /*Version 1.5*/

    /* employeeRoles  Function Start Here */
    public function employeeRoles()
    {
        $self='employee-roles';
        if (\Auth::user()->user_name!=='admin'){
            $get_perm=permission::permitted($self);

            if ($get_perm=='access denied'){
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important'=>true
                ]);
            }
        }


        $emp_roles=EmployeeRoles::all();
        return view('admin.employee-roles',compact('emp_roles'));
    }

    /* addEmployeeRoles  Function Start Here */
    public function addEmployeeRoles(Request $request){

        $self='add-employee-role';
        if (\Auth::user()->user_name!=='admin'){
            $get_perm=permission::permitted($self);

            if ($get_perm=='access denied'){
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important'=>true
                ]);
            }
        }


        $v=\Validator::make($request->all(),[
            'role_name'=>'required','status'=>'required'
        ]);

        if ($v->fails()){
            return redirect('employees/roles')->withErrors($v->errors());
        }

        $emp_roles=new EmployeeRoles();
        $emp_roles->role_name=$request->role_name;
        $emp_roles->status=$request->status;
        $emp_roles->save();

        return redirect('employees/roles')->with([
            'message'=> language_data('Employee Role added successfully')
        ]);

    }

    /* updateEmployeeRoles  Function Start Here */
    public function updateEmployeeRoles(Request $request){

        $self='employee-roles';
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
            'role_name'=>'required','status'=>'required'
        ]);

        if ($v->fails()){
            return redirect('employees/roles')->withErrors($v->errors());
        }

        $emp_roles=EmployeeRoles::find($cmd);

        if ($emp_roles){
            $emp_roles->role_name=$request->role_name;
            $emp_roles->status=$request->status;
            $emp_roles->save();

            return redirect('employees/roles')->with([
                'message'=> language_data('Employee Role updated successfully')
            ]);
        }else{

            return redirect('employees/roles')->with([
                'message'=> language_data('Employee Role info not found'),
                'message_important'=>true
            ]);
        }

    }

    /* setEmployeeRoles  Function Start Here */
    public function setEmployeeRoles($id)
    {
        $self='employee-roles';
        if (\Auth::user()->user_name!=='admin'){
            $get_perm=permission::permitted($self);

            if ($get_perm=='access denied'){
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important'=>true
                ]);
            }
        }


        $emp_roles=EmployeeRoles::find($id);
        return view('admin.set-employee-roles',compact('emp_roles'));
    }

    /* updateEmployeeSetRoles  Function Start Here */
    public function updateEmployeeSetRoles(Request $request)
    {
        $self='employee-roles';
        if (\Auth::user()->user_name!=='admin'){
            $get_perm=permission::permitted($self);

            if ($get_perm=='access denied'){
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important'=>true
                ]);
            }
        }


        $role_id=Input::get('role_id');

        $v=\Validator::make($request->all(),[
            'perms'=>'required','role_id'=>'required'
        ]);

        if ($v->fails()){
            return redirect('employees/set-roles/'.$role_id)->withErrors($v->errors());
        }

        $perms = Input::get('perms');
        if (count($perms) == 0) {
            return redirect('employees/set-roles/'.$role_id)->with([
                'message' => language_data('Permission not assigned'),
                'message_important' => true
            ]);
        }

        EmployeeRolesPermission::where('role_id',$role_id)->delete();

        foreach($perms as $perm){
            $emp_r_perm=new EmployeeRolesPermission();

            $emp_r_perm->role_id=$role_id;
            $emp_r_perm->perm_id=$perm;
            $emp_r_perm->save();
        }

        return redirect('employees/set-roles/'.$role_id)->with([
            'message'=> language_data('Permission Updated')
        ]);


    }

    /* deleteEmployeeRoles  Function Start Here */
    public function deleteEmployeeRoles($id)
    {
        $appStage=app_config('AppStage');
        if($appStage=='Demo'){
            return redirect('employees/roles')->with([
                'message' => language_data('You do not have permission to view this page'),
                'message_important'=>true
            ]);
        }


        $self='delete-employee-role';
        if (\Auth::user()->user_name!=='admin'){
            $get_perm=permission::permitted($self);

            if ($get_perm=='access denied'){
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important'=>true
                ]);
            }
        }


        $emp_role=EmployeeRoles::find($id);

        if ($emp_role){

            $emp_check=Employee::where('role_id',$id)->where('user_name','!=','admin')->first();

            if ($emp_check){
                return redirect('employees/roles')->with([
                    'message'=> language_data('An Employee contain this role'),
                    'message_important'=>true
                ]);
            }


            EmployeeRolesPermission::where('role_id',$id)->delete();
            $emp_role->delete();

            return redirect('employees/roles')->with([
                'message'=> language_data('Employee role deleted successfully')
            ]);

        }else{
            return redirect('employees/roles')->with([
                'message'=> language_data('Employee Role info not found'),
                'message_important'=>true
            ]);
        }



    }
    
    
    
    
          /* viewEmployee  Function Start Here */
    public function viewEmployeePDS()
    {

        $self='update-employee';


        $employee = Employee::find(\Auth::user()->id);

        if ($employee) {
            $designation = Designation::all();
            $department=Department::all();
            $role=EmployeeRoles::where('status','Active')->get();

            //$childrens=EmployeeBankAccount::where('emp_id',\Auth::user()->id)->get();
            $employee_doc=EmployeeFiles::where('emp_id',\Auth::user()->id)->get();

            $childrens=PdsFamily::where('emp_id',\Auth::user()->id)->get();
            $eligibilities=PdsEligibility::where('emp_id',\Auth::user()->id)->get();
            $experiences=PdsExperience::where('emp_id',\Auth::user()->id)->get();
            $trainings=EmployeeTraining::where('employee_id',\Auth::user()->id)->get();
            $organizations=PdsOrganization::where('emp_id',\Auth::user()->id)->get();
            $skills=PdsSkill::where('emp_id',\Auth::user()->id)->get();
            $recognitions=PdsRecognition::where('emp_id',\Auth::user()->id)->get();
            $memberships=PdsMembership::where('emp_id',\Auth::user()->id)->get();
            $references=PdsReference::where('emp_id',\Auth::user()->id)->get();

            return view('employee.view-employee', compact('employee', 'designation','department','childrens','eligibilities','experiences','trainings','organizations','skills','recognitions','memberships','references','employee_doc','role'));
        } else {
            return redirect('employee/dashboard')->with([
                'message' => language_data('Employee Not Found'),
                'message_important' => true
            ]);
        }
    }
    



    public function downloadEmployeePDS()
    {

        
       
        include_once(base_path().'/libraries/fpdm/fpdm_employee.php');

        $e = Employee::find(\Auth::user()->id);

        try {
            $fields['lastname'] = chk_isdbnull(utf8_decode($e->lastname));
            $fields['firstname'] = chk_isdbnull(utf8_decode($e->firstname));
            $fields['middlename'] = chk_isdbnull(utf8_decode($e->middlename));
            $fields['extension'] = chk_isdbnull($e->extension);
            $fields['birthdate'] = chk_isdbnull($e->birthdate);
            $fields['birth_place'] = chk_isdbnull($e->birth_place);
            $fields['height'] = chk_isdbnull($e->height);
            $fields['weight'] = chk_isdbnull($e->weight);
            $fields['bloodtype'] = chk_isdbnull($e->bloodtype);
            $fields['gsisnumber'] = chk_isdbnull($e->gsisnumber);
            $fields['hdmfnumber'] = chk_isdbnull($e->hdmfnumber);
            $fields['philhealthnumber'] = chk_isdbnull($e->philhealthnumber);
            $fields['sssnumber'] = chk_isdbnull($e->sssnumber);
            $fields['tin_number'] = chk_isdbnull($e->tin_number);
            $fields['employee_code'] = chk_isdbnull($e->employee_code);
        } catch (Exception $x) {
            echo 'Caught exception: (1) ',  $x->getMessage(), "\n";
        }
        
        
        try {
            $fields['resid_block1'] = chk_isdbnull($e->resid_block);
            $fields['resid_street1'] = chk_isdbnull($e->resid_street);
            $fields['resid_village'] = chk_isdbnull($e->resid_village);
            $fields['resid_barangay'] = chk_isdbnull($e->resid_barangay);
            $fields['resid_city'] = chk_isdbnull($e->resid_city);
            $fields['resid_province'] = chk_isdbnull($e->resid_province);
            $fields['resid_zipcode'] = chk_isdbnull($e->resid_zipcode);
            
            $fields['resid_per_block'] = chk_isdbnull($e->resid_per_block);
            $fields['resid_per_street1'] = chk_isdbnull($e->resid_per_street);
            $fields['resid_per_village'] = chk_isdbnull($e->resid_per_village);
            $fields['resid_per_barangay'] = chk_isdbnull($e->resid_per_barangay);
            $fields['resid_per_city'] = chk_isdbnull($e->resid_per_city);
            $fields['resid_per_province'] = chk_isdbnull($e->resid_per_province);
            $fields['resid_per_zipcode'] = chk_isdbnull($e->resid_per_zipcode);
        } catch (Exception $e) {
            echo 'Caught exception: (2) ',  $e->getMessage(), "\n";
        }
        
        
        try {
            $fields['phone_tel'] = chk_isdbnull($e->phone_tel);
            $fields['phone'] = chk_isdbnull($e->phone);
            $fields['email'] = chk_isdbnull($e->email);
            
            $fields['spouse_sname'] = chk_isdbnull(utf8_decode($e->spouse_sname));
            $fields['spouse_fname'] = chk_isdbnull($e->spouse_fname);
            $fields['spouse_mname'] = chk_isdbnull(utf8_decode($e->spouse_mname));
            $fields['spouse_ext'] = chk_isdbnull($e->spouse_ext);
            $fields['spouse_occupation'] = chk_isdbnull($e->spouse_occupation);
            $fields['spouse_bussiness'] = chk_isdbnull($e->spouse_business);
            $fields['spouse_address'] = chk_isdbnull($e->spouse_address);
            $fields['spouse_tel'] = chk_isdbnull($e->spouse_tel);
            
            $fields['father_sname'] = chk_isdbnull(utf8_decode($e->father_sname));
            $fields['father_fname'] = chk_isdbnull($e->father_fname);
            $fields['father_mname'] = chk_isdbnull($e->father_mname);
            $fields['father_ext'] = chk_isdbnull($e->father_ext);
            
            $fields['mother_maiden'] = chk_isdbnull($e->mother_maiden);
            $fields['mother_sname'] = chk_isdbnull(utf8_decode($e->mother_sname));
            $fields['mother_fname'] = chk_isdbnull($e->moter_fname);
            $fields['mother_mname'] = chk_isdbnull($e->mother_mname);
        } catch (Exception $x) {
            echo 'Caught exception: (3) ',  $x->getMessage(), "\n";
        }
        
        try {
            $fields['elem_name'] = chk_isdbnull($e->elem_name);
            $fields['elem_course'] = chk_isdbnull($e->elem_course);
            $fields['elem_from'] = chk_isdbnull($e->elem_from);
            $fields['elem_to'] = chk_isdbnull($e->elem_to);
            $fields['elem_earned'] = chk_isdbnull($e->elem_earned);
            $fields['elem_yeargrad'] = chk_isdbnull($e->elem_yeargrad);
            $fields['elem_honors'] = chk_isdbnull($e->elem_honors);
            
            $fields['sec_name'] = chk_isdbnull($e->sec_name);
            $fields['sec_course'] = chk_isdbnull($e->sec_course);
            $fields['sec_from'] = chk_isdbnull($e->sec_from);
            $fields['sec_to'] = chk_isdbnull($e->sec_to);
            $fields['sec_earned'] = chk_isdbnull($e->sec_earned);
            $fields['sec_yeargrad'] = chk_isdbnull($e->sec_yeargrad);
            $fields['sec_honors'] = chk_isdbnull($e->sec_honors);
            
            $fields['voc_name'] = chk_isdbnull($e->voc_name);
            $fields['voc_course'] = chk_isdbnull($e->voc_course);
            $fields['voc_from'] = chk_isdbnull($e->voc_from);
            $fields['voc_to'] = chk_isdbnull($e->voc_to);
            $fields['voc_earned'] = chk_isdbnull($e->voc_earned);
            $fields['voc_yeargrad'] = chk_isdbnull($e->voc_yeargrad);
            $fields['voc_honors'] = chk_isdbnull($e->voc_honors);
            
            $fields['col_name'] = chk_isdbnull($e->col_name);
            $fields['col_course'] = chk_isdbnull($e->col_course);
            $fields['col_from'] = chk_isdbnull($e->col_from);
            $fields['col_to'] = chk_isdbnull($e->col_to);
            $fields['col_earned'] = chk_isdbnull($e->col_earned);
            $fields['col_yeargrad'] = chk_isdbnull($e->col_yeargrad);
            $fields['col_honors'] = chk_isdbnull($e->col_honors);
            
            $fields['grad_name'] = chk_isdbnull($e->grad_name);
            $fields['grad_course'] = chk_isdbnull($e->grad_course);
            $fields['grad_from'] = chk_isdbnull($e->grad_from);
            $fields['grad_to'] = chk_isdbnull($e->grad_to);
            $fields['grad_earned'] = chk_isdbnull($e->grad_earned);
            $fields['grad_yeargrad'] = chk_isdbnull($e->grad_yeargrad);
            $fields['grad_honors'] = chk_isdbnull($e->grad_honors);
        } catch (Exception $x) {
            echo 'Caught exception: (4) ',  $x->getMessage(), "\n";
        }

        //Family
        $children = PdsFamily::where('emp_id',\Auth::user()->id)->get();
        try{
            $i=1;
            foreach($children as $child){
                if ($i<=12){
                    $fields['child_name_'.$i] = chk_isdbnull(utf8_decode($child->name));
                    $fields['child_birthdate_'.$i] = chk_isdbnull($child->birthdate);
                }
                $i++;
            }
        }catch (Exception $x) {
            echo 'Caught exception: (5) ',  $x->getMessage(), "\n";
        }


        //Eligibility
        $eligibilities = PdsEligibility::where('emp_id',\Auth::user()->id)->get();
        try{
            $i=1;
            foreach($eligibilities as $eligibility){
                if ($i<=7){
                    $fields['elig_name_'.$i] = chk_isdbnull($eligibility->elig_name);
                    $fields['elig_rating_'.$i] = chk_isdbnull($eligibility->elig_rating);
                    $fields['elig_date_'.$i] = chk_isdbnull($eligibility->elig_date);
                    $fields['elig_place_'.$i] = chk_isdbnull($eligibility->elig_place);
                    $fields['elig_license_'.$i] = chk_isdbnull($eligibility->elig_license);
                    $fields['elig_expiry_'.$i] = chk_isdbnull($eligibility->elig_expiry);
                }
                $i++;
            }
        }catch (Exception $x) {
            echo 'Caught exception: (6) ',  $x->getMessage(), "\n";
        }

        //Experiences
        $experiences = PdsExperience::where('emp_id',\Auth::user()->id)->get();
        try{
            $i=1;
            foreach($experiences as $experience){
                if ($i<=28){
                    $fields['work_from_'.$i] = chk_isdbnull($experience->work_from);
                    $fields['work_to_'.$i] = chk_isdbnull($experience->work_to);
                    $fields['work_position_'.$i] = chk_isdbnull($experience->work_position);
                    $fields['work_company_'.$i] = chk_isdbnull($experience->work_company);
                    $fields['work_salary_'.$i] = chk_isdbnull($experience->work_salary);
                    $fields['work_grade_'.$i] = chk_isdbnull($experience->work_grade);
                    $fields['work_status_'.$i] = chk_isdbnull($experience->work_status);
                    $fields['work_is_gov_'.$i] = chk_isdbnull($experience->work_is_gov);
                }
                $i++;
            }
        }catch (Exception $x) {
            echo 'Caught exception: (7) ',  $x->getMessage(), "\n";
        }

        //Trainings
        $trainings = EmployeeTraining::where('employee_id',\Auth::user()->id)->orderby('training_from','desc')->get();
        try{
            $i=1;
            foreach($trainings as $training){
                if ($i<=21){
                    $fields['train_title_'.$i] = chk_isdbnull($training->title);
                    $fields['train_from_'.$i] = chk_isdbnull($training->training_from);
                    $fields['train_to_'.$i] = chk_isdbnull($training->training_to);
                    $fields['train_hours_'.$i] = chk_isdbnull($training->training_hours);
                    $fields['train_type_'.$i] = chk_isdbnull($training->training_type);
                    $fields['train_conducted_by_'.$i] = chk_isdbnull($training->sponsored_by);
                }
                $i++;
            }
        }catch (Exception $x) {
            echo 'Caught exception: (8) ',  $x->getMessage(), "\n";
        }

        //Organizations
        $organizations = PdsOrganization::where('emp_id',\Auth::user()->id)->get();
        try{
            $i=1;
            foreach($organizations as $organization){
                if ($i<=7){
                    $fields['org_name_'.$i] = chk_isdbnull($organization->org_name);
                    $fields['org_from_'.$i] = chk_isdbnull($organization->org_from);
                    $fields['org_to_'.$i] = chk_isdbnull($organization->org_to);
                    $fields['org_hours_'.$i] = chk_isdbnull($organization->org_hours);
                    $fields['org_position_'.$i] = chk_isdbnull($organization->org_position);
                }
                $i++;
            }
        }catch (Exception $x) {
            echo 'Caught exception: (9) ',  $x->getMessage(), "\n";
        }

         //Skills
         $skills = PdsSkill::where('emp_id',\Auth::user()->id)->get();
         try{
             $i=1;
             foreach($skills as $skill){
                 if ($i<=7){
                     $fields['skills_'.$i] = chk_isdbnull($skill->name);
                 }
                 $i++;
             }
         }catch (Exception $x) {
             echo 'Caught exception: (10) ',  $x->getMessage(), "\n";
         }

          //PdsRecognition
          $recognitions = PdsRecognition::where('emp_id',\Auth::user()->id)->get();
          try{
              $i=1;
              foreach($recognitions as $recognition){
                  if ($i<=7){
                      $fields['recognition_'.$i] = chk_isdbnull($recognition->name);
                  }
                  $i++;
              }
          }catch (Exception $x) {
              echo 'Caught exception: (11) ',  $x->getMessage(), "\n";
          }

          //PdsMembership
          $memberships = PdsMembership::where('emp_id',\Auth::user()->id)->get();
          try{
              $i=1;
              foreach($memberships as $membership){
                  if ($i<=7){
                      $fields['membership_'.$i] = chk_isdbnull($membership->name);
                  }
                  $i++;
              }
          }catch (Exception $x) {
              echo 'Caught exception: (11) ',  $x->getMessage(), "\n";
          }

            //PdsReference
            $references = PdsReference::where('emp_id',\Auth::user()->id)->get();
            try{
                $i=1;
                foreach($references as $reference){
                    if ($i<=3){
                        $fields['ref_name_'.$i] = chk_isdbnull(utf8_decode($reference->ref_name));
                        $fields['ref_address_'.$i] = chk_isdbnull($reference->ref_address);
                        $fields['ref_tel_'.$i] = chk_isdbnull($reference->ref_tel);
                    }
                    $i++;
                }
            }catch (Exception $x) {
                echo 'Caught exception: (12) ',  $x->getMessage(), "\n";
            }

        //use App\PdsFamily;
        // use App\PdsEligibility;
        // use App\PdsExperience;
        // use App\PdsTraining;
        // use App\PdsOrganization;
        // use App\PdsSkill;
        // use App\PdsRecognition;
        // use App\PdsMembership;
        // use App\PdsReference;

        PDF_Civil_Service($fields, base_path() .'/libraries/fpdm/CSC_PDS.pdf',"CSC_PDS - ".utf8_decode($e->firstname)." " . utf8_decode($e->lastname).".pdf");
        //return redirect('profile');
    
    }

   
    
    
     /* postPDSInfoDetail  Function Start Here */
    public function postPDSInfoDetail(Request $request)
    {
        $self='update-employee';


        $cmd = Input::get('cmd');
        $appStage=app_config('AppStage');   

        $v = \Validator::make($request->all(), [
            'firstname' => 'required', 'lastname' => 'required'
        ]);

        if ($v->fails()) {
            return redirect('employee/edit-pds/')->withErrors($v->errors());
        }

        $employee = Employee::find($cmd);

        $tmp_emp_code = Input::get('employee_code');

        try {
            if (Input::get('employee_code') <> ""){
                $employee_code = Input::get('employee_code');
                $exist_emp_code = $employee->employee_code;
                if ($employee_code != '' AND $employee_code != $exist_emp_code) {
                    $exist = Employee::where('employee_code', '=', $employee_code)->first();
                    if ($exist) {
                        return redirect('employee/edit-pds/')->with([
                            'message' => language_data('Employee Code Already Exist'),
                            'message_important' => true
                        ]);
                    }
                }
            }
           
        } catch (Exception $e) {
           
        }
        
        try {
            if (Input::get('username') <> ""){
                $username = Input::get('username');
                $exist_user_name = $employee->user_name;
                if ($username != '' AND $username != $exist_user_name) {
                    $exist = Employee::where('user_name', '=', $username)->first();
                    if ($exist) {
                        return redirect('employee/edit-pds/')->with([
                            'message' => language_data('Username Already Exist'),
                            'message_important' => true
                        ]);
                    }
                }
            }
           
        } catch (Exception $e) {
           
        }
        
        try {
            if (Input::get('email') <> ""){
                $email = Input::get('email');
                $exist_email = $employee->email;
                if ($email != '' AND $email != $exist_email) {
                    $exist = Employee::where('email', '=', $email)->first();
                    if ($exist) {
                        return redirect('employee/edit-pds/')->with([
                            'message' => language_data('Email Already Exist'),
                            'message_important' => true
                        ]);
                    }
                }
            }
           
        } catch (Exception $e) {
           
        }

        

        // $passowrd = Input::get('password');
        // $rpassowrd = Input::get('rpassword');

        // if ($passowrd != '') {
        //     if ($passowrd != $rpassowrd) {
        //         return redirect('employee/edit-pds/' . $cmd)->with([
        //             'message' => language_data('Both Password Does not Match'),
        //             'message_important' => true
        //         ]);
        //     } else {
        //         $passowrd = bcrypt($passowrd);
        //     }
        // } else {
        //     $passowrd = $employee->password;
        // }




        $date_join=date('Y-m-d',strtotime($request->hired_date));
        $birthdate=date('Y-m-d',strtotime($request->birthdate));



        $employee->firstname = $request->firstname;
        $employee->lastname = $request->lastname;
        $employee->middlename = $request->middlename;
        $employee->extension = $request->extension;

        $mi = substr($request->middlename, 0,1) . ".";
        $fullname = ucfirst($request->lastname) . ", " . ucfirst($request->firstname) . " " . ucfirst($mi) . " " . $request->extension;
        $employee->fullname = $fullname;

        $employee->email = $email;
        $employee->civil_status = $request->civil_status;
        $employee->birthdate = $birthdate;
        $employee->hired_date = $date_join;
        $employee->gender = $request->gender;
        $employee->height = $request->height;
        $employee->weight = $request->weight;
        $employee->bloodtype = $request->bloodtype;
        $employee->zip = $request->zip;
        $employee->phone = $request->phone;
        $employee->phone_tel = $request->phone_tel;

        $employee->department_id = $request->department_id;
        $employee->designation = $request->designation;

       
        


        $employee->save();

        return redirect('employee/edit-pds')->with([
            'message' => language_data('Employee Updated Successfully')
        ]);


    }



      /* postPDSAddress  Function Start Here */
      public function postPDSAddress(Request $request)
      {
          $self='update-employee';
  
  
          $cmd = Input::get('cmd');
          $appStage=app_config('AppStage');   
  
          $v = \Validator::make($request->all(), [
             
            ]);
  
          if ($v->fails()) {
              return redirect('employee/edit-pds/')->withErrors($v->errors());
          }
  
          $employee = Employee::find($cmd);
  

  
          $employee->resid_block = $request->resid_block;
          $employee->resid_street = $request->resid_street;
          $employee->resid_village =$request->resid_village;
          $employee->resid_barangay =$request->resid_barangay;
          $employee->resid_city =$request->resid_city;
          $employee->resid_province =$request->resid_province;
          $employee->resid_zipcode = $request->resid_zipcode;

          $employee->resid_per_block = $request->resid_per_block;
          $employee->resid_per_street = $request->resid_per_street;
          $employee->resid_per_village =$request->resid_per_village;
          $employee->resid_per_barangay =$request->resid_per_barangay;
          $employee->resid_per_city =$request->resid_per_city;
          $employee->resid_per_province =$request->resid_per_province;
          $employee->resid_per_zipcode = $request->resid_per_zipcode;
  
  
          $employee->save();
  
          return redirect('employee/edit-pds')->with([
              'message' => language_data('Employee Updated Successfully')
          ]);
  
  
      }


       /* postPDSFamily  Function Start Here */
       public function postPDSFamily(Request $request)
       {
           $self='update-employee';
   
   
           $cmd = Input::get('cmd');
           $appStage=app_config('AppStage');   
   
           $v = \Validator::make($request->all(), [
              
             ]);
   
           if ($v->fails()) {
               return redirect('employee/edit-pds/')->withErrors($v->errors());
           }
   
           $employee = Employee::find($cmd);
   
 
   
           $employee->spouse_sname = $request->spouse_sname;
           $employee->spouse_fname = $request->spouse_fname;
           $employee->spouse_mname =$request->spouse_mname;
           $employee->spouse_ext =$request->spouse_ext;
           $employee->spouse_occupation =$request->spouse_occupation;
           $employee->spouse_bussiness =$request->spouse_bussiness;
           $employee->spouse_address = $request->spouse_address;
           $employee->spouse_tel = $request->spouse_tel;
 
           $employee->father_sname = $request->father_sname;
           $employee->father_fname = $request->father_fname;
           $employee->father_mname =$request->father_mname;
           $employee->father_ext =$request->father_ext;
           
           $employee->mother_maiden =$request->mother_maiden;
           $employee->mother_sname =$request->mother_sname;
           $employee->mother_fname = $request->mother_fname;
           $employee->mother_mname = $request->mother_mname;
           $employee->mother_ext = $request->mother_ext;
   
           $employee->save();
   
           return redirect('employee/edit-pds')->with([
               'message' => language_data('Employee Updated Successfully')
           ]);
   
   
       }



       /* postPDSAccounts  Function Start Here */
       public function postPDSAccounts(Request $request)
       {
           $self='update-employee';
   
   
           $cmd = Input::get('cmd');
           $appStage=app_config('AppStage');   
   
           $v = \Validator::make($request->all(), [
              
             ]);
   
           if ($v->fails()) {
               return redirect('employee/edit-pds/')->withErrors($v->errors());
           }
   
           $employee = Employee::find($cmd);
   
 
   
           $employee->employee_code = $request->employee_code;
           $employee->atmnumber = $request->atmnumber;
           $employee->gsisnumber =$request->gsisnumber;
           $employee->gsisnumber_crn =$request->gsisnumber_crn;
           $employee->hdmfnumber =$request->hdmfnumber;
           $employee->philhealthnumber =$request->philhealthnumber;
           $employee->tin_number = $request->tin_number;
           
   
           $employee->save();
   
           return redirect('employee/edit-pds')->with([
               'message' => language_data('Employee Updated Successfully')
           ]);
   
   
       }



    //IPCR
    /* getIpcrPeriod  Function Start Here */
    public function showIpcrPeriod()
    {
        $ipcr_periods = IpcrPeriod::orderby('id','desc')->get();;

        return view('ipcr.view-ipcr-period', compact('ipcr_periods'));

    }



    //IPCR
    /* getIpcrPeriod  Function Start Here */
    public function PostIpcrPeriod(Request $request)
    {
        $v = \Validator::make($request->all(), [
              
            ]);
  
          if ($v->fails()) {
              return redirect('ipcr/periods/')->withErrors($v->errors());
          }


        $ip = new IpcrPeriod;
        $ip->name =   $request->name;
        $ip->rating_period =   $request->rating_period;
        $ip->description =   $request->description;
        $ip->year =   $request->year;
        $ip->period_from  =   $request->period_from;
        $ip->period_to =   $request->period_to;
        $ip->dep_id =   $request->dep_id;
        $ip->remarks =   $request->remarks;
        $ip->status_approval =   $request->status_approval;
        $ip->status_rating =   $request->status_rating;
        $ip->save();

        $employees=Employee::where('status','active')->where('user_name','!=','admin')->where('department_id',$request->dep_id)->get();

         foreach($employees as $emp){
             $ipcr_emp = new IpcrEmployee;
             $ipcr_emp->ipcr_period_id = $ip->id;
             $ipcr_emp->employee_id = $emp->id;
             $ipcr_emp->dep_id = $ip->dep_id;
             $ipcr_emp->rating_period = $ip->rating_period;
             $ipcr_emp->save();
         }


        return redirect('ipcr/periods/');

    }


    /* updateIpcrPeriod  Function Start Here */
    public function updateIpcrPeriod(Request $request)
    {
        $v = \Validator::make($request->all(), [
              
            ]);
  
          if ($v->fails()) {
              return redirect('ipcr/periods/')->withErrors($v->errors());
          }


        $ip = IpcrPeriod::find($request->cmd);
        $ip->name =   $request->name;
        $ip->rating_period =   $request->rating_period;
        $ip->description =   $request->description;
        $ip->year =   $request->year;
        $ip->period_from  =   $request->period_from;
        $ip->period_to =   $request->period_to;
        $ip->dep_id =   $request->dep_id;
        $ip->remarks =   $request->remarks;
        $ip->status_approval =   $request->status_approval;
        $ip->status_rating =   $request->status_rating;
        $ip->save();


        return redirect('ipcr/periods/');

    }

     /* deleteIpcrPeriod  Function Start Here */
     public function deleteIpcrPeriod($cmd)
     {

         $ip = IpcrPeriod::find($cmd);
         if($ip){
            $ip->delete();
        }
 
        IpcrEmployee::where('ipcr_period_id',$cmd)->delete();
 
         return redirect('ipcr/periods/');
 
     }




     /* getIpcrPeriod  Function Start Here */
    public function showIpcrGroup()
    {
        $ipcr_groups = IpcrGroup::all();
        $employees=Employee::where('status','active')->where('user_name','!=','admin')->get();

        return view('ipcr.view-groups', compact('ipcr_groups','employees'));

    }



    /* getIpcrPeriod  Function Start Here */
    public function PostIpcrGroup(Request $request)
    {
        $v = \Validator::make($request->all(), [
              
            ]);
  
          if ($v->fails()) {
              return redirect('ipcr/groups/')->withErrors($v->errors());
          }

        $ig = new IpcrGroup;
        $ig->name =   $request->name;
        $ig->description =   $request->description;
        $ig->save();

       $employee = Input::get('employee');
        if (count($employee) <> 0) {
            $group_id = $ig->id;

            foreach ($employee as $e) {
                $igm = new IpcrGroupsMember();
                $igm->ipcr_group_id = $group_id;
                $igm->employee_id = $e;
                $igm->save();
            }
        }

        return redirect('ipcr/groups/');

    }


    /* updateIpcrPeriod  Function Start Here */
    public function updateIpcrGroup(Request $request)
    {
        $v = \Validator::make($request->all(), [
              
            ]);
  
          if ($v->fails()) {
              return redirect('ipcr/groups/')->withErrors($v->errors());
          }


        $ig = IpcrGroup::find($request->cmd);
        $ig->name =   $request->name;
        $ig->description =   $request->description;
        $ig->save();

        IpcrGroupsMember::where('ipcr_group_id',$request->cmd)->delete();

        $employee = Input::get('employee');
        if (count($employee) <> 0) {
            $group_id = $ig->id;

            foreach ($employee as $e) {
                $igm = new IpcrGroupsMember();
                $igm->ipcr_group_id = $group_id;
                $igm->employee_id = $e;
                $igm->save();
            }
        }

        return redirect('ipcr/groups/');

    }

     /* deleteIpcrPeriod  Function Start Here */
     public function deleteIpcrGroup($cmd)
     {

         $ig = IpcrGroup::find($cmd);
         if($ig){
            $ig->delete();
        }
 
        IpcrGroupsMember::where('ipcr_group_id',$cmd)->delete();
 
         return redirect('ipcr/groups/');
 
     }





        /* showIpcrEmployee  Function Start Here */
        public function showIpcrEmployee()
        {
            $ipcrs = IpcrEmployee::where('employee_id',\Auth::user()->id)->orderby('id', 'desc')->get();    
            return view('ipcr.view-employee', compact('ipcrs'));
    
        }



        /* showIpcrMfo  Function Start Here */
    public function showIpcrMfo($id)
    {
        $ipcr_mfos = IpcrRating::where('ipcr_emp_rec_id',$id)->orderby('mfo_group_sort')->get();
        session(['ipcr_emp_rec_id' => $id]);
        $mfo_groups = IpcrMfoGroup::all();
        $grp_cnt_1 = IpcrRating::where('ipcr_emp_rec_id',$id)->where('mfo_group_id',1)->count();
        $grp_cnt_2 = IpcrRating::where('ipcr_emp_rec_id',$id)->where('mfo_group_id',2)->count();
        $grp_cnt_3 = IpcrRating::where('ipcr_emp_rec_id',$id)->where('mfo_group_id',3)->count();
        $grp_cnt_4 = IpcrRating::where('ipcr_emp_rec_id',$id)->where('mfo_group_id',4)->count();
        $grp_cnt_5 = IpcrRating::where('ipcr_emp_rec_id',$id)->where('mfo_group_id',5)->count();
        $grp_cnt_6 = IpcrRating::where('ipcr_emp_rec_id',$id)->where('mfo_group_id',6)->count();
        $grp_cnt_7 = IpcrRating::where('ipcr_emp_rec_id',$id)->where('mfo_group_id',7)->count();
        $grp_cnt_8 = IpcrRating::where('ipcr_emp_rec_id',$id)->where('mfo_group_id',8)->count();


        $group_members = IpcrGroup::all();
        return view('ipcr.view-employee-mfo', compact('ipcr_mfos','mfo_groups','group_members','grp_cnt_1','grp_cnt_2','grp_cnt_3','grp_cnt_4','grp_cnt_5','grp_cnt_6','grp_cnt_7','grp_cnt_8') );

    }



    /* PostIpcrMfo  Function Start Here */
    public function PostIpcrMfo(Request $request)
    {
        $v = \Validator::make($request->all(), [
              
            ]);
  
          if ($v->fails()) {
              return redirect('ipcr/employee-mfo/'. session('ipcr_emp_rec_id'))->withErrors($v->errors());
          }

        $ir = new IpcrRating;
        $ir->ipcr_emp_rec_id =   $request->ipcr_emp_rec_id;
        $ir->employee_id =   \Auth::user()->id;
        $ir->ipcr_period_id = DB::table('ipcr_employees')->where('id', $request->ipcr_emp_rec_id)->value('ipcr_period_id');
        $ir->mfo_group_id = $request->mfo_group_id;
        $ir->mfo_group_sort = DB::table('ipcr_mfo_groups')->where('id', $request->mfo_group_id)->value('sort');
        $ir->mfo_name = $request->mfo_name;
        $ir->default_weight = $request->default_weight;
        $ir->save();



        return redirect('ipcr/employee-mfo/'. session('ipcr_emp_rec_id'));

    }


    /* updateIpcrMfo  Function Start Here */
    public function updateIpcrMfo(Request $request)
    {
        $v = \Validator::make($request->all(), [
              
            ]);
  
          if ($v->fails()) {
              return redirect('ipcr/employee-mfo/'. session('ipcr_emp_rec_id'))->withErrors($v->errors());
          }

        $ir = IpcrRating::find($request->cmd);
        $ir->ipcr_emp_rec_id =   $request->ipcr_emp_rec_id;
        $ir->employee_id =   \Auth::user()->id;
        $ir->ipcr_period_id = DB::table('ipcr_employees')->where('id', $request->ipcr_emp_rec_id)->value('ipcr_period_id');
        $ir->mfo_group_id = $request->mfo_group_id;
        $ir->mfo_group_sort = DB::table('ipcr_mfo_groups')->where('id', $request->mfo_group_id)->value('sort');
        $ir->mfo_name = $request->mfo_name;
        $ir->default_weight = $request->default_weight;
        $ir->save();

        return redirect('ipcr/employee-mfo/'. session('ipcr_emp_rec_id'));

    }

     /* deleteIpcrMfo  Function Start Here */
     public function deleteIpcrMfo($cmd)
     {

        $ir = IpcrRating::find(cmd);
         if($ir){
            $ir->delete();
        }
 
        IpcrRatingDetail::where('ipcr_rating_id',$cmd)->delete();
 
         return redirect('ipcr/employee-mfo/'. session('ipcr_emp_rec_id'));
 
     }





       /* PostIpcrMfoIndicator  Function Start Here */
    public function PostIpcrMfoIndicator(Request $request)
    {
        $v = \Validator::make($request->all(), [
              
            ]);
  
          if ($v->fails()) {
              return redirect('ipcr/employee-mfo/'. session('ipcr_emp_rec_id'))->withErrors($v->errors());
          }

        $ird = new IpcrRatingsDetail;
        $ird->ipcr_rating_id =   $request->ipcr_rating_id;
        $ird->employee_id =   \Auth::user()->id;
        $ird->ipcr_period_id = DB::table('ipcr_employees')->where('id', $request->ipcr_emp_rec_id)->value('ipcr_period_id');
        $ird->indicator = $request->indicator;
        $ird->group_rating_id =  $request->group_rating_id;
        $ird->group_approval_id =  $request->group_approval_id;
        $ird->accomplishments =  $request->accomplishments;
        $ird->weight = $request->weight;
        $ird->save();



        return redirect('ipcr/employee-mfo/'. session('ipcr_emp_rec_id'));

    }


    /* updateIpcrMfoIndicator  Function Start Here */
    public function updateIpcrMfoIndicator(Request $request)
    {
        $v = \Validator::make($request->all(), [
              
            ]);
  
          if ($v->fails()) {
              return redirect('ipcr/employee-mfo/'. session('ipcr_emp_rec_id'))->withErrors($v->errors());
          }

        $ird = IpcrRatingsDetail::find($request->cmd);
       
        $ird->indicator = $request->indicator;
        $ird->group_rating_id =  $request->group_rating_id;
        $ird->group_approval_id =  $request->group_approval_id;
        $ird->accomplishments =  $request->accomplishments;
        $ird->weight = $request->weight;
        $ird->save();

        return redirect('ipcr/employee-mfo/'. session('ipcr_emp_rec_id'));

    }

     /* deleteIpcrMfoIndicator  Function Start Here */
     public function deleteIpcrMfoIndicator($cmd)
     {

        $ird = IpcrRatingsDetail::find($cmd);
         if($ird){
            $ird->delete();
        }
 
         return redirect('ipcr/employee-mfo/'. session('ipcr_emp_rec_id'));
 
     }



    //IPCR
    /* showIpcrSupervisory  Function Start Here */
    public function showIpcrSupervisory()
    {
        $ipcr_periods = IpcrPeriod::orderby('id','desc')->get();

        return view('ipcr.view-supervisory', compact('ipcr_periods'));

    }


    /* showIpcrSupervisoryEmployee  Function Start Here */
    public function showIpcrSupervisoryEmployee($ipcr_period_id)
    {
        $mygroup = IpcrGroupsMember::where('employee_id',\Auth::user()->id)->get(['ipcr_group_id'])->toArray();

        $ratee_employee = IpcrRatingsDetail::groupBy('employee_id')->where('ipcr_period_id',$ipcr_period_id)
            ->wherein('group_approval_id', $mygroup)
            ->get(['employee_id'])->toArray();

            session(['ipcr_period_id' => $ipcr_period_id]);

        $employees = Employee::wherein('id',$ratee_employee)->get();

        return view('ipcr.view-supervisory-approval', compact('employees'));

    }


        /* showIpcrSupervisoryEmployeeDetail  Function Start Here */
        public function showIpcrSupervisoryEmployeeDetail($employee_id)
        {
            $id = IpcrEmployee::where('employee_id',$employee_id)->where('ipcr_period_id',session('ipcr_period_id'))->value('id');
            $ipcr_mfos = IpcrRating::where('ipcr_emp_rec_id',$id)->orderby('mfo_group_sort')->get();
            session(['ipcr_emp_rec_id' => $id]);
            $mfo_groups = IpcrMfoGroup::all();
            $grp_cnt_1 = IpcrRating::where('ipcr_emp_rec_id',$id)->where('mfo_group_id',1)->count();
            $grp_cnt_2 = IpcrRating::where('ipcr_emp_rec_id',$id)->where('mfo_group_id',2)->count();
            $grp_cnt_3 = IpcrRating::where('ipcr_emp_rec_id',$id)->where('mfo_group_id',3)->count();
            $grp_cnt_4 = IpcrRating::where('ipcr_emp_rec_id',$id)->where('mfo_group_id',4)->count();
            $grp_cnt_5 = IpcrRating::where('ipcr_emp_rec_id',$id)->where('mfo_group_id',5)->count();
            $grp_cnt_6 = IpcrRating::where('ipcr_emp_rec_id',$id)->where('mfo_group_id',6)->count();
            $grp_cnt_7 = IpcrRating::where('ipcr_emp_rec_id',$id)->where('mfo_group_id',7)->count();
            $grp_cnt_8 = IpcrRating::where('ipcr_emp_rec_id',$id)->where('mfo_group_id',8)->count();
            $ratee_emp_id = $employee_id;
    
    
            $group_members = IpcrGroup::all();
            return view('ipcr.view-supervisory-approval-detail', compact('ipcr_mfos','mfo_groups','group_members','ratee_emp_id','grp_cnt_1','grp_cnt_2','grp_cnt_3','grp_cnt_4','grp_cnt_5','grp_cnt_6','grp_cnt_7','grp_cnt_8') );
    
    
        }



             /* getIpcrPeriod  Function Start Here */
    public function updateUsename()
    {

        $employees=Employee::where('status','active')->where('user_name','!=','admin')->get();

        foreach ($employees as $employee){
            $emp_user_change= Employee::find($employee->id);
            $tmp_fname = substr($employee->firstname,0,2);
            $emp_user_change->user_name = strtolower($tmp_fname) . strtolower($employee->lastname);
            $emp_user_change->save();
        }

        return ("updating password sucessfull");

    }

    /* getIpcrPeriod  Function Start Here */
    public function updateLeaveLedger()
    {

        $employees=Employee::where('status','active')->where('user_name','!=','admin')->get();

        foreach ($employees as $employee){
            $ledger= new LeaveLedger();
            $ledger->employee_id = $employee->id;
            $ledger->year="2018";
            $ledger->particular = "forwarded balance";
            $ledger->vl_balance = 20;
            $ledger->sl_balance = 20;
            $ledger->save();
        }

        return ("updating ledger sucessfull");

    }


}
