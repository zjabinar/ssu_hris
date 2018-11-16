<?php

namespace App\Http\Controllers;

use App\Attendance;
use App\AwardList;
use App\Classes\permission;
use App\EmailTemplate;
use App\Employee;
use App\Expense;
use App\Holiday;
use App\JobApplicants;
use App\Jobs;
use App\Leave;
use App\Notice;
use App\SupportTickets;
use App\Task;

use App\TrainingEvents;
use App\PayrollPeriod;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;

date_default_timezone_set(app_config('Timezone'));

class UserController extends Controller
{
    /* login  Function Start Here */
    public function login()
    {
        if (\Auth::check()) {
            if(\Auth::user()->role_id=='0'){
                session(['portal' => 'master']);
                return redirect('dashboard');
            }else{
                session(['portal' => 'employee']);
                return redirect('employee/dashboard');
            }
        } else {
            return view('admin.login');
        }
    }

    /* getLogin  Function Start Here */
    public function getLogin(Request $request)
    {
        $this->validate($request, [
            'user_name' => 'required', 'password' => 'required',
        ]);

        $check_input = $request->only('user_name', 'password');


        $remember = (Input::has('remember')) ? true : false;

        if (\Auth::attempt($check_input, $remember)) {

            if(\Auth::user()->role_id=='0'){
                session(['portal' => 'employee']);
                return redirect()->intended('employee/dashboard');
            }else{
                
                if (\Auth::user()->user_name =='admin' or \Auth::user()->role_id ==2) {
                    session(['portal' => 'master']);
                    return redirect()->intended('dashboard');
                 }else{
                    session(['portal' => 'employee']);
                    return redirect()->intended('employee/dashboard');
                }
            }
        } else {
            return redirect('/')->withInput($request->only('user_name'))->withErrors([
                'user_name' => language_data('Invalid User Name or Password'),
            ]);
        }
    }

    /* dashboard  Function Start Here */
    public function dashboard()
    {

        $self='dashboard';

       

        if (\Auth::check()) {

            if (\Auth::user()->role_id==0){
                \Auth::logout();

                return redirect('/')->with([
                    'message'=> language_data('Invalid Access'),
                    'message_important'=>true
                ]);
            }

            if ( \Auth::user()->role_id ==1 and \Auth::user()->user_name!=='admin' ) {
                session(['portal' => 'employee']);
                return redirect()->intended('employee/dashboard');
            }

            session(['portal' => 'master']);

            if (\Auth::user()->user_name!=='admin'){
                $get_perm=permission::permitted($self);

                if ($get_perm=='access denied'){
                    return redirect('permission-error')->with([
                        'message' => language_data('You do not have permission to view this page'),
                        'message_important'=>true
                    ]);
                }
            }

            $employee=Employee::where('user_name','!=','admin')->count();
            $leave=Leave::where('status','pending')->count();
            $expense=Expense::where('status','Pending')->count();
            $tickets=SupportTickets::where('status','Pending')->count();

            $trainings_upcoming = TrainingEvents::where('status','upcoming')->count();
            $trainings_list = TrainingEvents::where('status','upcoming')->limit(6)->orderBy('training_from','desc')->get();

            $notice_published = Notice::where('status','published')->count();
            $notice_list = Notice::where('status','published')->limit(6)->orderBy('id','desc')->get();

            $payroll_period = PayrollPeriod::where('payroll_period_id','>','0')->limit(6)->orderBy('payroll_period_id','desc')->get();

            $leave_application=Leave::where('status','pending')->limit(6)->orderBy('id','desc')->get();
            $recent_expense=Expense::where('status','Pending')->limit(6)->orderBy('id','desc')->get();
            $recent_task=Task::limit(6)->orderBy('id','desc')->get();
            $recent_tickets=SupportTickets::where('status','Pending')->limit(6)->orderBy('id','desc')->get();

            $st_pending=SupportTickets::where('status','Pending')->count();
            $st_answered=SupportTickets::where('status','Answered')->count();
            $st_replied=SupportTickets::where('status','Customer Reply')->count();
            $st_closed=SupportTickets::where('status','Closed')->count();

            $expense_json=$recent_expense->toJson();

            $get_expense=Expense::whereRaw('year(`created_at`) = ?', array(date('Y')))->select('amount','purchase_date')->get()->toJson();

            

            return view('admin.dashboard',compact('employee','payroll_period','leave','trainings_upcoming','trainings_list','notice_published','notice_list','expense','tickets','leave_application','recent_expense','recent_task','recent_tickets','expense_json','st_pending','st_closed','st_answered','st_replied', 'get_expense'));
        } else {
            return redirect('/');
        }
    }


    /* employeeDashboard  Function Start Here */
    public function employeeDashboard()
    {
        if (\Auth::check()) {

            if (\Auth::user()->user_name=='admin'){
                \Auth::logout();

                return redirect('/')->with([
                    'message'=> language_data('Invalid Access'),
                    'message_important'=>true
                ]);
            }

            session(['portal' => 'employee']);

            $first_day_this_month = date('Y-m-01');
            $last_day_this_month  = date('Y-m-t');

            $first_day_this_year=date('Y-01-01');
            $last_day_this_year=date('Y-12-31');

            $trainings_upcoming = TrainingEvents::where('status','upcoming')->count();
            $trainings_list = TrainingEvents::where('status','upcoming')->limit(6)->orderBy('training_from','desc')->get();

            $notice_published = Notice::where('status','published')->count();
            $notice_list = Notice::where('status','published')->limit(6)->orderBy('id','desc')->get();


            $leave_application=Leave::where('emp_id',\Auth::user()->id)->limit(6)->orderBy('id','desc')->get();


            $attendance=Attendance::where('emp_id',\Auth::user()->id)->whereBetween('date',[$first_day_this_month,$last_day_this_month])->count();
            $holiday=Holiday::whereBetween('holiday',[$first_day_this_year,$last_day_this_year])->count();
            $award=AwardList::where('emp_id',\Auth::user()->employee_code)->where('year',date('Y'))->count();

            $recent_notice=Notice::where('status','Published')->orderBy('id','desc')->limit(5)->get();
            $recent_tickets=SupportTickets::where('status','!=','Closed')->where('emp_id',\Auth::user()->id)->orderBy('id','desc')->limit(5)->get();

            $user_info=Employee::find(\Auth::user()->id);

            $clock_state=Attendance::where('date',date('Y-m-d'))->where('emp_id',\Auth::user()->id)->first();

            if($clock_state){
                if($clock_state->clock_status=='Clock In'){
                    $clock_status= language_data('Clock In');
                }else{
                    $clock_status= language_data('Clock Out');
                }
            }else{
                $clock_status= language_data('Clock Out');
            }

            return view('employee.dashboard',compact('user_info','trainings_list','notice_list','leave_application', 'attendance','holiday','award','recent_notice','recent_tickets','clock_state','clock_status'));
        } else {
            return redirect('/');
        }
    }


    /* logout  Function Start Here */
    public function logout()
    {
        \Auth::logout();
        return redirect('/')->with(['message' => language_data('Logout Successfully')]);
    }


    /* editProfile  Function Start Here */
    public function editProfile()
    {
        $employee = _info(\Auth::user()->id);

        return view('admin.edit-profile', compact('employee'));
    }

    /* editEditProfile  Function Start Here */
    public function editEditProfile()
    {
        $employee = _info(\Auth::user()->id);
        return view('employee.edit-profile', compact('employee'));
    }


    /* postUserPersonalInfo  Function Start Here */
    public function postUserPersonalInfo(Request $request)
    {
        $appStage = app_config('AppStage');
        if ($appStage == 'Demo') {
            return redirect('user/edit-profile')->with([
                'message' => language_data('This Option is Disable In Demo Mode'),
                'message_important' => true
            ]);
        }

        $v = \Validator::make($request->all(), [
            'firstname' => 'required', 'email' => 'required'
        ]);

        if ($v->fails()) {
            return redirect('user/edit-profile')->withErrors($v->errors());
        }

        $cmd = \Auth::user()->id;
        $employee = Employee::find($cmd);

        $email = Input::get('email');
        $exist_email = $employee->email;
        if ($email != '' AND $email != $exist_email) {
            $exist = Employee::where('email', '=', $email)->first();
            if ($exist) {
                return redirect('user/edit-profile')->with([
                    'message' => language_data('Email Already Exist'),
                    'message_important' => true
                ]);
            }
        }

        $employee->firstname = $request->firstname;
        $employee->lastname = $request->lastname;
        $employee->email = $email;
        $employee->phone = $request->phone;
        $employee->save();

        return redirect('user/edit-profile')->with([
            'message' => language_data('Profile Updated Successfully')
        ]);


    }

    /* postEmployeePersonalInfo  Function Start Here */
    public function postEmployeePersonalInfo(Request $request)
    {
        $appStage = app_config('AppStage');
        if ($appStage == 'Demo') {
            return redirect('employee/edit-profile')->with([
                'message' => language_data('This Option is Disable In Demo Mode'),
                'message_important' => true
            ]);
        }

        $v = \Validator::make($request->all(), [
            'firstname' => 'required', 'email' => 'required'
        ]);

        if ($v->fails()) {
            return redirect('employee/edit-profile')->withErrors($v->errors());
        }

        $cmd = \Auth::user()->id;
        $employee = Employee::find($cmd);

        $email = Input::get('email');
        $exist_email = $employee->email;
        if ($email != '' AND $email != $exist_email) {
            $exist = Employee::where('email', '=', $email)->first();
            if ($exist) {
                return redirect('employee/edit-profile')->with([
                    'message' => language_data('Email Already Exist'),
                    'message_important' => true
                ]);
            }
        }

        $employee->firstname = $request->firstname;
        $employee->lastname = $request->lastname;
        $employee->email = $email;
        $employee->phone = $request->phone;
        $employee->save();

        return redirect('employee/edit-profile')->with([
            'message' => language_data('Profile Updated Successfully')
        ]);


    }

    /* updateUserAvatar  Function Start Here */
    public function updateUserAvatar(Request $request)
    {
        $appStage = app_config('AppStage');
        if ($appStage == 'Demo') {
            return redirect('user/edit-profile')->with([
                'message' => language_data('This Option is Disable In Demo Mode'),
                'message_important' => true
            ]);
        }

        $v = \Validator::make($request->all(), [
            'image' => 'required'
        ]);

        if ($v->fails()) {
            return redirect('user/edit-profile')->withErrors($v->errors());
        }

        $cmd = \Auth::user()->id;
        $image = Input::file('image');
        $employee = Employee::find($cmd);

        if ($employee) {
            if ($image != '') {
                $destinationPath = public_path() . '/assets/employee_pic/';
                $image_name = $image->getClientOriginalastname();
                Input::file('image')->move($destinationPath, $image_name);

                $employee->avatar = $image_name;
                $employee->save();

                return redirect('user/edit-profile')->with([
                    'message' => language_data('Avatar Changed Successfully')
                ]);

            } else {
                return redirect('user/edit-profile')->with([
                    'message' => language_data('Upload an Image'),
                    'message_important' => true
                ]);
            }
        } else {
            return $this->logout();
        }
    }

    /* updateEmployeeAvatar  Function Start Here */
    public function updateEmployeeAvatar(Request $request)
    {

        $appStage = app_config('AppStage');
        if ($appStage == 'Demo') {
            return redirect('employee/edit-profile')->with([
                'message' => language_data('This Option is Disable In Demo Mode'),
                'message_important' => true
            ]);
        }

        $v = \Validator::make($request->all(), [
            'image' => 'required'
        ]);

        if ($v->fails()) {
            return redirect('employee/edit-profile')->withErrors($v->errors());
        }

        $cmd = \Auth::user()->id;
        $image = Input::file('image');
        $employee = Employee::find($cmd);

        if ($employee) {
            if ($image != '') {
                $destinationPath = public_path() . '/assets/employee_pic/';
                $image_name = $image->getClientOriginalastname();
                Input::file('image')->move($destinationPath, $image_name);

                $employee->avatar = $image_name;
                $employee->save();

                return redirect('employee/edit-profile')->with([
                    'message' => language_data('Avatar Changed Successfully')
                ]);

            } else {
                return redirect('employee/edit-profile')->with([
                    'message' => language_data('Upload an Image'),
                    'message_important' => true
                ]);
            }
        } else {
            return $this->logout();
        }
    }

    /* changePassword  Function Start Here */
    public function changePassword()
    {
        return view('admin.change-password');
    }

    /* changeEmployeePassword  Function Start Here */
    public function changeEmployeePassword()
    {
        return view('employee.change-password');
    }

    /* updateUserPassword  Function Start Here */
    public function updateUserPassword(Request $request)
    {
        $appStage = app_config('AppStage');
        if ($appStage == 'Demo') {
            return redirect('user/change-password')->with([
                'message' => language_data('This Option is Disable In Demo Mode'),
                'message_important' => true
            ]);
        }

        $v = \Validator::make($request->all(), [
            'current_password' => 'required', 'new_password' => 'required', 'confirm_password' => 'required'
        ]);

        if ($v->fails()) {
            return redirect('user/change-password')->withErrors($v->errors());
        }

        $user = Employee::find(\Auth::user()->id);

        $current_password = Input::get('current_password');
        $new_password = Input::get('new_password');
        $confirm_password = Input::get('confirm_password');

        if (\Hash::check($current_password, $user->password)) {

            if ($new_password == $confirm_password) {
                $user->password = bcrypt($new_password);
                $user->save();

                return redirect('user/change-password')->with([
                    'message' => language_data('Password Change Successfully')
                ]);

            } else {
                return redirect('user/change-password')->with([
                    'message' => language_data('Both New Password Does Not Match'),
                    'message_important' => true
                ]);
            }

        } else {
            return redirect('user/change-password')->with([
                'message' => language_data('Current Password Does Not Match'),
                'message_important' => true
            ]);
        }

    }


    /* updateEmployeePassword  Function Start Here */
    public function updateEmployeePassword(Request $request)
    {
        $appStage = app_config('AppStage');
        if ($appStage == 'Demo') {
            return redirect('employee/change-password')->with([
                'message' => language_data('This Option is Disable In Demo Mode'),
                'message_important' => true
            ]);
        }

        $v = \Validator::make($request->all(), [
            'current_password' => 'required', 'new_password' => 'required', 'confirm_password' => 'required'
        ]);

        if ($v->fails()) {
            return redirect('employee/change-password')->withErrors($v->errors());
        }

        $user = Employee::find(\Auth::user()->id);

        $current_password = Input::get('current_password');
        $new_password = Input::get('new_password');
        $confirm_password = Input::get('confirm_password');

        if (\Hash::check($current_password, $user->password)) {

            if ($new_password == $confirm_password) {
                $user->password = bcrypt($new_password);
                $user->save();

                return redirect('employee/change-password')->with([
                    'message' => language_data('Password Change Successfully')
                ]);

            } else {
                return redirect('employee/change-password')->with([
                    'message' => language_data('Both New Password Does Not Match'),
                    'message_important' => true
                ]);
            }

        } else {
            return redirect('employee/change-password')->with([
                'message' => language_data('Current Password Does Not Match'),
                'message_important' => true
            ]);
        }

    }


    /* forgotPassword  Function Start Here */
    public function forgotPassword()
    {
        return view('admin.forgot-password');
    }



    /* forgotPasswordToken  Function Start Here */
    public function forgotPasswordToken(Request $request)
    {

        $appStage=app_config('AppStage');
        if($appStage=='Demo'){
            return redirect('/')->with([
                'message' => language_data('This Option is Disable In Demo Mode'),
                'message_important'=>true
            ]);
        }

        $v=\Validator::make($request->all(),[
            'email'=>'required'
        ]);

        if($v->fails()){
            return redirect('forgot-password')->withErrors($v->errors());
        }

        $email=Input::get('email');

        $d=Employee::where('email','=',$email)->count();
        if($d=='1'){
            $fprand=substr(str_shuffle(str_repeat('0123456789','16')),0,'16');
            $ef=Employee::where('email','=',$email)->first();
            $name=$ef->firstname .' '.$ef->lastname;
            $username=$ef->user_name;
            $ef->passwordresetkey = $fprand;
            $ef->save();

            $ip=\Request::getClientIp();

            /*For Email Confirmation*/

            $conf = EmailTemplate::where('tplastname', '=', 'Forgot Admin Password')->first();

            $estatus=$conf->status;
            if($estatus=='1'){
                $sysEmail = app_config('Email');
                $sysCompany = app_config('AppName');
                $fpw_link = url('forgot-password-token-code/'.$fprand);

                $template = $conf->message;
                $subject = $conf->subject;

                $data = array('name' => $name,
                    'business_name'=> $sysCompany,
                    'username'=> $username,
                    'ip_address'=> $ip,
                    'from'=> $sysEmail,
                    'template'=> $template,
                    'forgotpw_link' => $fpw_link
                );

                $message = _render($template, $data);
                $mail_subject = _render($subject, $data);
                $body = $message;

                /*Set Authentication*/

                $default_gt = app_config('Gateway');

                if ($default_gt == 'default') {

                    $mail = new \PHPMailer();

                    $mail->setFrom($sysEmail, $sysCompany);
                    $mail->addAddress($email,$name);     // Add a recipient
                    $mail->isHTML(true);                                  // Set email format to HTML
                    $mail->Subject = $mail_subject;
                    $mail->Body = $body;
                    if (!$mail->send()) {
                        return redirect('forgot-password')->with([
                            'message' => language_data('Please check your email setting')
                        ]);
                    } else {
                        return redirect('forgot-password')->with([
                            'message' => language_data('Password Reset Successfully. Please check your email')
                        ]);
                    }

                }
                else {
                    $host = app_config('SMTPHostName');
                    $smtp_username = app_config('SMTPUserName');
                    $stmp_password = app_config('SMTPPassword');
                    $port = app_config('SMTPPort');
                    $secure = app_config('SMTPSecure');


                    $mail = new \PHPMailer();

                    $mail->isSMTP();                                      // Set mailer to use SMTP
                    $mail->Host = $host;  // Specify main and backup SMTP servers
                    $mail->SMTPAuth = true;                               // Enable SMTP authentication
                    $mail->Username = $smtp_username;                 // SMTP username
                    $mail->Password = $stmp_password;                           // SMTP password
                    $mail->SMTPSecure = $secure;                            // Enable TLS encryption, `ssl` also accepted
                    $mail->Port = $port;

                    $mail->setFrom($sysEmail, $sysCompany);
                    $mail->addAddress($email,$name);     // Add a recipient
                    $mail->isHTML(true);                                  // Set email format to HTML

                    $mail->Subject = $mail_subject;
                    $mail->Body = $body;

                    if (!$mail->send()) {
                        return redirect('forgot-password')->with([
                            'message' => language_data('Please check your email setting')
                        ]);
                    } else {
                        return redirect('forgot-password')->with([
                            'message' => language_data('Password Reset Successfully. Please check your email')
                        ]);
                    }

                }
            }

            return redirect('forgot-password')->with([
                'message'=> language_data('Your Password Already Reset. Please Check your email')
            ]);
        }else{
            return redirect('forgot-password')->with([
                'message'=> language_data('Sorry There is no registered user with this email address'),
                'message_important'=>true
            ]);
        }

    }


    /* forgotPasswordTokenCode  Function Start Here */
    public function forgotPasswordTokenCode($token)
    {

        $appStage=app_config('AppStage');
        if($appStage=='Demo'){
            return redirect('/')->with([
                'message' => language_data('This Option is Disable In Demo Mode'),
                'message_important'=>true
            ]);
        }

        $tfnd=Employee::where('passwordresetkey','=',$token)->count();

        if($tfnd=='1'){
            $d=Employee::where('passwordresetkey','=',$token)->first();
            $name=$d->firstname .' '.$d->lastname;
            $email=$d->email;
            $username=$d->user_name;

            $rawpass=substr(str_shuffle(str_repeat('0123456789','16')),0,'16');
            $password=bcrypt($rawpass);

            $d->password=$password;
            $d->passwordresetkey = '';
            $d->save();

            /*For Email Confirmation*/

            $conf = EmailTemplate::where('tplastname', '=', 'Admin Password Reset')->first();

            $estatus=$conf->status;
            if($estatus=='1'){
                $sysEmail = app_config('Email');
                $sysCompany = app_config('AppName');
                $fpw_link = url('/');

                $template = $conf->message;
                $subject = $conf->subject;

                $data = array('name' => $name,
                    'business_name'=> $sysCompany,
                    'username'=> $username,
                    'password'=> $rawpass,
                    'template'=>$template,
                    'sys_url' => $fpw_link
                );

                $message = _render($template, $data);
                $mail_subject = _render($subject, $data);
                $body = $message;

                /*Set Authentication*/

                $default_gt = app_config('Gateway');

                if ($default_gt == 'default') {

                    $mail = new \PHPMailer();

                    $mail->setFrom($sysEmail, $sysCompany);
                    $mail->addAddress($email,$name);     // Add a recipient
                    $mail->isHTML(true);                                  // Set email format to HTML
                    $mail->Subject = $mail_subject;
                    $mail->Body = $body;
                    if (!$mail->send()) {
                        return redirect('/')->with([
                            'message' => language_data('Please check your email setting')
                        ]);
                    } else {
                        return redirect('/')->with([
                            'message' => language_data('A New Password Generated. Please Check your email.')
                        ]);
                    }

                }
                else {
                    $host = app_config('SMTPHostName');
                    $smtp_username = app_config('SMTPUserName');
                    $stmp_password = app_config('SMTPPassword');
                    $port = app_config('SMTPPort');
                    $secure = app_config('SMTPSecure');


                    $mail = new \PHPMailer();

                    $mail->isSMTP();                                      // Set mailer to use SMTP
                    $mail->Host = $host;  // Specify main and backup SMTP servers
                    $mail->SMTPAuth = true;                               // Enable SMTP authentication
                    $mail->Username = $smtp_username;                 // SMTP username
                    $mail->Password = $stmp_password;                           // SMTP password
                    $mail->SMTPSecure = $secure;                            // Enable TLS encryption, `ssl` also accepted
                    $mail->Port = $port;

                    $mail->setFrom($sysEmail, $sysCompany);
                    $mail->addAddress($email,$name);     // Add a recipient
                    $mail->isHTML(true);                                  // Set email format to HTML

                    $mail->Subject = $mail_subject;
                    $mail->Body = $body;

                    if (!$mail->send()) {
                        return redirect('/')->with([
                            'message' => language_data('Please check your email setting')
                        ]);
                    } else {
                        return redirect('/')->with([
                            'message' => language_data('A New Password Generated. Please Check your email.')
                        ]);
                    }

                }

            }
            return redirect('/')->with([
                'message'=> language_data('A New Password Generated. Please Check your email.')
            ]);
        }else{
            return redirect('/')->with([
                'message'=> language_data('Sorry Password reset Token expired or not exist, Please try again.'),
                'message_important'=>true
            ]);
        }

    }

    /* applyJob  Function Start Here */
    public function applyJob()
    {
        $jobs=Jobs::where('status','opening')->get();
        return view('employee.apply-job',compact('jobs'));

    }

    /* applyJobDetails  Function Start Here */
    public function applyJobDetails($id)
    {
        $job=Jobs::find($id);

        if($job){
            return view('employee.job-details',compact('job'));
        }else{
            return redirect('apply-job')->with([
                'message'=> language_data('Job Details Not found'),
                'message_important'=>true
            ]);
        }

    }

    /* postApplicantResume  Function Start Here */
    public function postApplicantResume(Request $request)
    {
        $cmd=Input::get('cmd');


        $v=\Validator::make($request->all(),[
            'name'=>'required','email'=>'required','phone'=>'required','resume'=>'mimes:'.app_config('JobFileExtension')
        ]);

        if($v->fails()){
            return redirect('apply-job/details/'.$cmd)->withErrors($v->errors());
        }



        $name = Input::get('name');
        $email = Input::get('email');
        $phone = Input::get('phone');
        $resume = Input::file('resume');

        if ($request->hasFile('resume')) {
            $destinationPath = storage_path() . '/app/resume/';
            $resume_name = "resume-". Input::get('name');
            Input::file('resume')->move($destinationPath, $resume_name);
        } else {
            return redirect('apply-job/details/'.$cmd)->with([
                'message'=> language_data('Please upload your resume'),
                'message_important'=>true
            ]);
        }

        $job_applicant=new JobApplicants();
        $job_applicant->job_id=$cmd;
        $job_applicant->name=$name;
        $job_applicant->email=$email;
        $job_applicant->phone=$phone;
        $job_applicant->status='Unread';
        $job_applicant->resume=$resume_name;
        $job_applicant->save();

        return redirect('apply-job/details/'.$cmd)->with([
            'message'=> language_data('Resume Submitted Successfully')
        ]);

    }

    /* permissionError  Function Start Here */
    public function permissionError()
    {
        return view('admin.permission-error');
    }


    /* updateApplication  Function Start Here */
    public function updateApplication()
    {



    }


}
