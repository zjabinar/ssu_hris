@extends(session('portal'))

{{--External Style Section--}}
@section('style')
    {!! Html::style("assets/libs/bootstrap3-wysihtml5-bower/bootstrap3-wysihtml5.min.css") !!}
    {!! Html::style("assets/libs/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css") !!}
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
                        <div class="panel-body p-t-20">
                            <div class="clearfix">
                                <div class="pull-left m-r-30">
                                    <div class="thumbnail m-b-none">

                                        @if($employee->avatar!='')
                                            <img src="<?php echo asset('assets/employee_pic/'.$employee->avatar); ?>" alt="Profile Page" width="200px" height="200px">
                                        @else
                                            <img src="<?php echo asset('assets/employee_pic/user.png');?>" alt="Profile Page" width="200px" height="200px">
                                        @endif
                                    </div>
                                </div>
                                <div class="pull-left">
                                    <h3 class="bold font-color-1">{{$employee->firstname}} {{$employee->lastname}}</h3>
                                    <ul class="info-list">
                                        @if($employee->email!='')
                                        <li><span class="info-list-title">{{language_data('Email')}}</span><span class="info-list-des">{{$employee->email}}</span></li>
                                        @endif

                                        @if($employee->phone!='')
                                            <li><span class="info-list-title">{{language_data('Phone')}}</span><span class="info-list-des">{{$employee->phone}}</span></li>
                                        @endif

                                        @if($employee->user_name!='')
                                            <li><span class="info-list-title">{{language_data('Username')}}</span><span class="info-list-des">{{$employee->user_name}}</span></li>
                                        @endif

                                        @if($employee->pre_address!='')
                                        <li><span class="info-list-title">{{language_data('Address')}}</span><span class="info-list-des">{{$employee->pre_address}}</span></li>
                                        @endif
                                    </ul>
                                    <a href="{{url('employee/download-pds')}}" class="btn btn-primary pull-left">
						<span class="glyphicon glyphicon-export" aria-hidden="true"></span> Civil Service - PDS
					</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
        <div class="p-30 p-t-none p-b-none">
           
            <div class="row">
                <div class="col-lg-12">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#personal_details" aria-controls="home" role="tab" data-toggle="tab">{{language_data('Personal Details')}}</a></li>
                        <li role="presentation"><a href="#address" aria-controls="address" role="tab" data-toggle="tab">Address</a></li>
                        <li role="presentation"><a href="#family" aria-controls="family" role="tab" data-toggle="tab">Family</a></li>
                        <li role="presentation"><a href="#children" aria-controls="children" role="tab" data-toggle="tab">Children</a></li>
                        <li role="presentation"><a href="#accounts" aria-controls="accounts" role="tab" data-toggle="tab">Accounts</a></li>
                        <li role="presentation"><a href="#eligibility" aria-controls="eligibility" role="tab" data-toggle="tab">Eligibilities</a></li>
                        <li role="presentation"><a href="#experience" aria-controls="experience" role="tab" data-toggle="tab">Work Experiences</a></li>
                        <li role="presentation"><a href="#training" aria-controls="training" role="tab" data-toggle="tab">Trainings</a></li>
                        <li role="presentation"><a href="#organization" aria-controls="organization" role="tab" data-toggle="tab">Voluntary Work</a></li>
                        <li role="presentation"><a href="#skill" aria-controls="skill" role="tab" data-toggle="tab">Skills</a></li>
                        <li role="presentation"><a href="#recognition" aria-controls="recognition" role="tab" data-toggle="tab">Recognition</a></li>
                        <li role="presentation"><a href="#membership" aria-controls="membership" role="tab" data-toggle="tab">Membership</a></li>
                        <li role="presentation"><a href="#reference" aria-controls="reference" role="tab" data-toggle="tab">References</a></li>
                        {{-- <li role="presentation"><a href="#document" aria-controls="messages" role="tab" data-toggle="tab">Documents</a></li> --}}
                        <li role="presentation"><a href="#change-picture" aria-controls="settings" role="tab" data-toggle="tab">Profile</a></li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content panel p-20">


                        {{--Personal Details--}}

                        <div role="tabpanel" class="tab-pane active" id="personal_details">
                                <form role="form" method="post" action="{{url('employee/post-pds-infodetails')}}">

                                <div class="row">
                                    <div class="col-md-4">

                                        <div class="form-group">
                                            <label>{{language_data('Last Name')}}</label>
                                            <input type="text" class="form-control" value="{{$employee->lastname}}" name="lastname" required>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label>First Name</label>
                                            <input type="text" class="form-control" required="" value="{{$employee->firstname}}" name="firstname" required>
                                        </div>

                                        <div class="form-group">
                                            <label>Middle Name</label>
                                            <input type="text" class="form-control" required="" value="{{$employee->middlename}}" name="middlename" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Name Extension</label>
                                            <input type="text" class="form-control"  value="{{$employee->extension}}" name="extension">
                                        </div>
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="text" class="form-control"  value="{{$employee->email}}" name="email" required>
                                        </div>
                                        <div class="form-group">
                                            <label>{{language_data('Date Of Birth')}}</label>
                                            <input type="text" class="form-control datePicker" name="birthdate" value="{{get_date_format($employee->birthdate)}}" required>
                                        </div>

                                    </div>




                                    <div class="col-md-4">

                                        <div class="form-group">
                                            <label>Civil Status</label>
                                            <input type="text" class="form-control"  value="{{$employee->civil_status}}" name="civil_status" required>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label>{{language_data('Gender')}}</label>
                                            <select class="selectpicker form-control" name="gender">
                                                <option value="Male" @if($employee->gender=='Male') selected @endif>{{language_data('Male')}}</option>
                                                <option value="Female" @if($employee->gender=='Female') selected @endif>{{language_data('Female')}}</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>Height</label>
                                            <input type="text" class="form-control"  value="{{$employee->height}}" name="height">
                                        </div>
                                        <div class="form-group">
                                            <label>Weight</label>
                                            <input type="text" class="form-control"  value="{{$employee->weight}}" name="weight">
                                        </div>
                                        <div class="form-group">
                                            <label>Blood Type</label>
                                            <input type="text" class="form-control"  value="{{$employee->bloodtype}}" name="bloodtype">
                                        </div>
      
                                       
                                    </div>


                                    <div class="col-md-4">

                                        
                                        <div class="form-group">
                                            <label>Zipcode</label>
                                            <input type="text" class="form-control"  value="{{$employee->zipcode}}" name="zipcode">
                                        </div>
                                        <div class="form-group">
                                            <label>Mobile Phone</label>
                                            <input type="text" class="form-control"  value="{{$employee->phone}}" name="phone">
                                        </div>
                                        <div class="form-group">
                                            <label>Telephone</label>
                                            <input type="text" class="form-control"  value="{{$employee->phone_tel}}" name="phone_tel">
                                        </div>
                                           
                                        <div class="form-group">
                                            <label for="el3">{{language_data('Department')}}</label>
                                            <select class="selectpicker form-control" data-live-search="true" name="department" id="department_id">
                                                <option>{{language_data('Select Department')}}</option>
                                                @foreach($department as $d)
                                                    <option value="{{$d->id}}" @if($employee->department_id==$d->id) selected @endif>  {{$d->department}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        {{-- <div class="form-group">
                                            <label for="el3">{{language_data('Designation')}}</label>
                                            <select class="selectpicker form-control" data-live-search="true" name="designation" id="designation">
                                                <option value="{{$employee->designation}}">{{$employee->designation_name->designation}}</option>
                                            </select>
                                        </div> --}}
    
                                           
        
        
                                          


                                    </div>

                                </div>
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" value="{{$employee->id}}" name="cmd">
                                        <input type="submit" value="{{language_data('Update')}}" class="btn btn-success pull-right">
                            </form>
                        </div>



                        {{-- Address Tab --}}
                        <div role="tabpanel" class="tab-pane" id="address">
                                <form role="form" method="post" action="{{url('employee/post-pds-address')}}">
                                <div class="row">
    
                                    <div class="col-lg-6">
                                        <div class="panel">
                                            <div class="panel-body">
                                                    <strong>Residential Address</strong><br />
                                                    <div class="form-group">
                                                            <label>House/Block/Lot:</label>
                                                            <input type="text" name="resid_block" value="{{$employee->resid_block}}" class="form-control">
                                                        </div>
                
                                                        <div class="form-group">
                                                            <label>Street:</label>
                                                            <input type="text" name="resid_street" value="{{$employee->resid_street}}" class="form-control">
                                                        </div>
                
                                                        <div class="form-group">
                                                            <label>Subdivision/Village:</label>
                                                            <input type="text" name="resid_village" value="{{$employee->resid_village}}" class="form-control">
                                                        </div>
                
                                                        <div class="form-group">
                                                            <label>Barangay:</label>
                                                            <input type="text" name="resid_barangay" value="{{$employee->resid_barangay}}" class="form-control">
                                                        
                                                        </div>
                
                                                        <div class="form-group">
                                                            <label>City/Municipality:</label>
                                                            <input type="text" name="resid_city" value="{{$employee->resid_city}}" class="form-control">
                                                            
                                                        </div>
                
                                                        <div class="form-group">
                                                            <label>Province:</label>
                                                            <input type="text" name="resid_province" value="{{$employee->resid_province}}" class="form-control">
                                                        </div>
                                            </div>
                                        </div>
                                    </div>
    
                                    <div class="col-lg-6">
                                        <div class="panel">

                                            <div class="panel-body">
                                                    <strong>Permanent Address</strong> <br />
                                                    <div class="form-group">
                                                        <label>House/Block/Lot:</label>
                                                        <input type="text" name="resid_per_block" value="{{$employee->resid_per_block}}" class="form-control">
                                                    </div>
            
                                                    <div class="form-group">
                                                        <label>Street:</label>
                                                        <input type="text" name="resid_per_street" value="{{$employee->resid_per_street}}" class="form-control">
                                                    </div>
            
                                                    <div class="form-group">
                                                        <label>Subdivision/Village:</label>
                                                        <input type="text" name="resid_per_village" value="{{$employee->resid_per_village}}" class="form-control">
                                                    </div>
            
                                                    <div class="form-group">
                                                        <label>Barangay:</label>
                                                        <input type="text" name="resid_per_barangay" value="{{$employee->resid_per_barangay}}" class="form-control">
                                                    
                                                    </div>
            
                                                    <div class="form-group">
                                                        <label>City/Municipality:</label>
                                                        <input type="text" name="resid_per_city" value="{{$employee->resid_per_city}}" class="form-control">
                                                        
                                                    </div>
            
                                                    <div class="form-group">
                                                        <label>Province:</label>
                                                        <input type="text" name="resid_per_province" value="{{$employee->resid_per_province}}" class="form-control">
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
    
                                </div>
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" value="{{$employee->id}}" name="cmd">
                                <input type="submit" value="{{language_data('Update')}}" class="btn btn-success pull-right">
                            </form>
                            </div>
                            {{-- Address Tab End --}}


                             {{-- Family Tab --}}
                        <div role="tabpanel" class="tab-pane" id="family">
                                <form role="form" method="post" action="{{url('employee/post-pds-family')}}">
                                <div class="row">
    
                                    <div class="col-lg-4">
                                        <div class="panel">
                                            <div class="panel-body">
                                                <strong>Spouse Info</strong> <br />
                                                <div class="form-group">
                                                    <label>Surname:</label>
                                                    <input type="text" name="spouse_sname" value="{{ $employee->spouse_sname }}" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label>Firstname:</label>
                                                    <input type="text" name="spouse_fname" value="{{$employee->spouse_fname }}" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label>Middlename:</label>
                                                    <input type="text" name="spouse_mname" value="{{ $employee->spouse_mname }}" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label>Extension:</label>
                                                    <input type="text" name="spouse_ext" value="{{ $employee->spouse_ext}}" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label>Occupation</label>
                                                        <input type="text" name="spouse_occupation" value="{{ $employee->spouse_occupation }}" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label>Business:</label>
                                                    <input type="text" name="spouse_bussiness" value="{{ $employee->spouse_bussiness }}" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label>Tel No.:</label>
                                                    <input type="text" name="spouse_add" value="{{$employee->spouse_add }}" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label>Address:</label>
                                                    <input type="text" name="spouse_tel" value="{{$employee->spouse_tel }}" class="form-control">
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                            <div class="panel">
                                                <div class="panel-body">
                                                        <strong>Mothers Name</strong> <br />
                                                        <div class="form-group">
                                                            <label>Maiden Name:</label>
                                                            
                                                                <input type="text" name="mother_maiden" value="{{ $employee->mother_maiden }}" class="form-control">
                                                            
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Surname:</label>
                                                            
                                                                <input type="text" name="mother_same" value="{{  $employee->mother_same }}" class="form-control">
                                                            
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Firstname:</label>
                                                            
                                                                <input type="text" name="mother_fname" value="{{ $employee->mother_fname }}" class="form-control">
                                                            
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Middlename:</label>
                                                            
                                                                <input type="text" name="mother_mname" value="{{ $employee->mother_mname }}" class="form-control">
                                                            
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Extension:</label>
                                                            
                                                                <input type="text" name="mother_ext" value="{{$employee->mother_ext }}" class="form-control">
                                                            
                                                        </div>   
                                                    
                                                </div>
                                            </div>
                                        </div>
    
                                    <div class="col-lg-4">
                                        <div class="panel">

                                            <div class="panel-body">
                                                    <strong>Fathers Name</strong> <br />
                                                    <div class="form-group">
                                                        <label>Surname:</label>
                                                            <input type="text" name="father_sname" value="{{  $employee->father_sname }}" class="form-control">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Firstname:</label>
                                                        
                                                            <input type="text" name="father_fname" value="{{  $employee->father_fname }}" class="form-control">
                                                        
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Middlename:</label>
                                                        
                                                            <input type="text" name="father_mname" value="{{ $employee->father_mname }}" class="form-control">
                                                        
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Extension:</label>
                                                        
                                                            <input type="text" name="father_ext" value="{{  $employee->father_ext}}" class="form-control">
                                                        
                                                    </div>
                                                   
                                            </div>
                                        </div>
                                    </div>
    
                                </div>
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" value="{{$employee->id}}" name="cmd">
                                <input type="submit" value="{{language_data('Update')}}" class="btn btn-success pull-right">
                            </form>
                            </div>
                            {{-- Family Tab end --}}


                             {{-- Children --}}
                             <div role="tabpanel" class="tab-pane" id="children">
                                    <div class="row">
        
                                        <div class="col-lg-4">
                                            <div class="panel">
                                                <div class="panel-body">
                                                    <form class="" role="form" method="post" action="{{url('employee/add-child')}}">
                                                        <div class="panel-heading">
                                                            <h3 class="panel-title"> Add Children</h3>
                                                        </div>
        
                                                        <div class="form-group">
                                                            <label>Name</label>
                                                            <input type="text" class="form-control" required name="name">
                                                        </div>
        
                                                        <div class="form-group">
                                                            <label>Birthdate</label>
                                                            <input type="text"  class="form-control" name="birthdate" >
                                                        </div>
        
 
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                        <input type="hidden" value="{{$employee->id}}" name="cmd">
                                                        <button type="submit" class="btn btn-success btn-sm pull-right"><i class="fa fa-plus"></i> {{language_data('Add')}} </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
        
                                        <div class="col-lg-8">
                                            <div class="panel">
                                                <div class="panel-heading">
                                                    <h3 class="panel-title">Childrens</h3>
                                                </div>
                                                <div class="panel-body p-none">
                                                    <table class="table data-table table-hover table-ultra-responsive">
                                                        <thead>
                                                        <tr>
                                                            <th style="width: 70%;">Name</th>
                                                            <th style="width: 20%;">Birthdate</th>
                                                            <th style="width: 10%;" class="text-right"></th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($childrens as $child)
                                                            <tr>
                                                                <td data-label="Name">{{$child->name}}</td>
                                                                <td data-label="birthdate"><p>{{$child->birthdate}}</p></td>
                                                                <td class="text-right">
                                                                    <a href="#" data-toggle="tooltip" data-placement="top" title="Delete" class="btn btn-danger btn-xs deleteChild" id="{{$child->id}}"><i class="fa fa-trash"></i></a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
        
                                    </div>
                                </div>
                                {{-- tab children end --}}


                               {{-- Account Tab --}}
                        <div role="tabpanel" class="tab-pane" id="accounts">
                                <form role="form" method="post" action="{{url('employee/post-pds-accounts')}}">
                                <div class="row">
    
                                    <div class="col-lg-4">
                                        <div class="panel">
                                            <div class="panel-body">
                                                    <div class="form-group">
                                                        <label>SSU Employee No.:</label>
                                                        <input type="text" name="employee_code" value="{{ $employee->employee_code }}" class="form-control" readonly="">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>ATM No.:</label>
                                                        <input type="text" name="atmnumber" value="{{  $employee->atmnumber }}" class="form-control" readonly="">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>TIN No.</label>
                                                        <input type="text" name="tin_number" value="{{  $employee->tin_number }}" class="form-control" readonly="">
                                                    </div>
                                  
                                                   
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-lg-4">
                                            <div class="panel">
                                                <div class="panel-body">

                                                        <div class="form-group">
                                                            <label>GSIS No.</label>
                                                            <input type="text" name="gsisnumber" value="{{  $employee->gsisnumber }}" class="form-control" readonly="">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>GSIS CRN:</label>
                                                            <input type="text" name="gsisnumber_crn" value="{{ $employee->gsisnumber_crn }}" class="form-control" readonly="">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Pag-ibig MID No.:</label>
                                                            <input type="text" name="hdmfnumber" value="{{ $employee->hdmfnumber }}" class="form-control" readonly="">
                                                        </div>
                            
                                                       
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-lg-4">
                                                <div class="panel">
                                                    <div class="panel-body">
                                                         
                                                            <div class="form-group">
                                                                <label>Philhealth No.:</label>
                                                                <input type="text" name="philhealthnumber" value="{{ $employee->philhealthnumber }}" class="form-control" readonly="">
                                                            </div>
                                                            <div class="form-group">
                                                                <label>SSS No.:</label>
                                                                <input type="text" name="sssnumber" value="{{ $employee->sssnumber }}" class="form-control" readonly="">
                                                            </div>
                                                           
                                                    </div>
                                                </div>
                                            </div>
    
                                </div>
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" value="{{$employee->id}}" name="cmd">
                                <input type="submit" value="{{language_data('Update')}}" class="btn btn-success pull-right">
                            </form>
                            </div>
                            {{-- Account Tab end --}}

.
                            {{-- Eligibility --}}
                            <div role="tabpanel" class="tab-pane" id="eligibility">
                                    <div class="row">

                                        <div class="col-lg-3">
                                            <div class="panel">
                                                <div class="panel-body">
                                                    <form class="" role="form" method="post" action="{{url('employee/add-eligibility')}}">
                                                        <div class="panel-heading">
                                                            <h3 class="panel-title">Add Eligibility</h3>
                                                        </div>

                                                        <div class="form-group">
                                                            <label>Eligibility</label>
                                                            <input type="text" class="form-control" required name="elig_name">
                                                        </div>

                                                        <div class="form-group">
                                                            <label>Rating</label>
                                                            <input type="text"  class="form-control" name="elig_rating" >
                                                        </div>

                                                        <div class="form-group">
                                                            <label>Date</label>
                                                            <input type="text"  class="form-control" name="elig_date" >
                                                        </div>

                                                        <div class="form-group">
                                                            <label>Place</label>
                                                            <input type="text"  class="form-control" name="elig_place" >
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <label>License #:</label>
                                                            <input type="text"  class="form-control" name="elig_license" >
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Expiration Date</label>
                                                            <input type="text"  class="form-control" name="elig_expiry" >
                                                        </div>

                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                        <input type="hidden" value="{{$employee->id}}" name="cmd">
                                                        <button type="submit" class="btn btn-success btn-sm pull-right"><i class="fa fa-plus"></i> {{language_data('Add')}} </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-9">
                                            <div class="panel">
                                                <div class="panel-heading">
                                                    <h3 class="panel-title">Eligibilities</h3>
                                                </div>
                                                <div class="panel-body p-none">
                                                    <table class="table data-table table-hover table-ultra-responsive">
                                                        <thead>
                                                        <tr>
                                                            <th>Eligibility</th>
                                                            <th>Rating</th>
                                                            <th>Date</th>
                                                            <th>Place</th>
                                                            <th>License No.</th>
                                                            <th>Expiry</th>
                                                            <th style="width: 5%;" class="text-right"></th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($eligibilities as $eligibility)
                                                            <tr>
                                                                <td data-label="Eligibility">{{$eligibility->elig_name}}</td>
                                                                <td data-label="Rating"><p>{{$eligibility->elig_rating}}</p></td>
                                                                <td data-label="Date"><p>{{$eligibility->elig_date}}</p></td>
                                                                <td data-label="Place"><p>{{$eligibility->elig_place}}</p></td>
                                                                <td data-label="License No."><p>{{$eligibility->elig_license}}</p></td>
                                                                <td data-label="Expiry"><p>{{$eligibility->elig_expiry}}</p></td>
                                                                <td class="text-right">
                                                                    <a href="#" data-toggle="tooltip" data-placement="top" title="Delete" class="btn btn-danger btn-xs deleteEligibility" id="{{$eligibility->id}}"><i class="fa fa-trash"></i></a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                {{-- tab Eligibility end --}}
                           

                                {{-- Experiences --}}
                                <div role="tabpanel" class="tab-pane" id="experience">
                                        <div class="row">

                                            <div class="col-lg-3">
                                                <div class="panel">
                                                    <div class="panel-body">
                                                        <form class="" role="form" method="post" action="{{url('employee/add-experience')}}">
                                                            <div class="panel-heading">
                                                                <h3 class="panel-title">Add Work Experience</h3>
                                                            </div>

                                                            <div class="form-group">
                                                                <label>Date From:</label>
                                                                <input type="text" class="form-control" required name="work_from">
                                                            </div>

                                                            <div class="form-group">
                                                                <label>Date To:</label>
                                                                <input type="text"  class="form-control" name="work_to" >
                                                            </div>

                                                            <div class="form-group">
                                                                <label>Position:</label>
                                                                <input type="text"  class="form-control" name="work_position" >
                                                            </div>

                                                            <div class="form-group">
                                                                <label>Company:</label>
                                                                <input type="text"  class="form-control" name="work_company" >
                                                            </div>
                                                            
                                                            <div class="form-group">
                                                                <label>Salary:</label>
                                                                <input type="text"  class="form-control" name="work_salary" >
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Grade:</label>
                                                                <input type="text"  class="form-control" name="work_grade" >
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Status:</label>
                                                                <input type="text"  class="form-control" name="work_status" >
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Government:</label>
                                                                <input type="text"  class="form-control" name="work_is_gov" >
                                                            </div>


                                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                            <input type="hidden" value="{{$employee->id}}" name="cmd">
                                                            <button type="submit" class="btn btn-success btn-sm pull-right"><i class="fa fa-plus"></i> {{language_data('Add')}} </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-9">
                                                <div class="panel">
                                                    <div class="panel-heading">
                                                        <h3 class="panel-title">Work Experiences</h3>
                                                    </div>
                                                    <div class="panel-body p-none">
                                                        <table class="table data-table table-hover table-ultra-responsive">
                                                            <thead>
                                                            <tr>
                                                                <th>Date From</th>
                                                                <th>Date To</th>
                                                                <th>Position</th>
                                                                <th>Company</th>
                                                                <th>Salary</th>
                                                                <th>Grade</th>
                                                                <th>Status</th>
                                                                <th>Government</th>
                                                                <th style="width: 5%;" class="text-right"></th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach($experiences as $experience)
                                                                <tr>
                                                                    <td data-label="Date From">{{$experience->work_from}}</td>
                                                                    <td data-label="Date To"><p>{{$experience->work_to}}</p></td>
                                                                    <td data-label="Position"><p>{{$experience->work_position}}</p></td>
                                                                    <td data-label="Company"><p>{{$experience->work_company}}</p></td>
                                                                    <td data-label="Salary"><p>{{$experience->work_salary}}</p></td>
                                                                    <td data-label="Grade"><p>{{$experience->work_grade}}</p></td>
                                                                    <td data-label="Status"><p>{{$experience->work_status}}</p></td>
                                                                    <td data-label="Government"><p>{{$experience->work_is_gov}}</p></td>
                                                                    <td class="text-right">
                                                                        <a href="#" data-toggle="tooltip" data-placement="top" title="Delete" class="btn btn-danger btn-xs deleteExperience" id="{{$experience->id}}"><i class="fa fa-trash"></i></a>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    {{-- tab Experience end --}}

                       
                                     {{-- Trainings --}}
                                    <div role="tabpanel" class="tab-pane" id="training">
                                        <div class="row">

                                            <div class="col-lg-3">
                                                <div class="panel">
                                                    <div class="panel-body">
                                                        <form class="" role="form" method="post" action="{{url('employee/add-training')}}">
                                                            <div class="panel-heading">
                                                                <h3 class="panel-title">Add Training/Seminar</h3>
                                                            </div>

                                                            <div class="form-group">
                                                                <label>Title:</label>
                                                                <input type="text" class="form-control" required name="title">
                                                            </div>

                                                            <div class="form-group">
                                                                <label>Date From:</label>
                                                                <input type="text"  class="form-control" name="training_from" >
                                                            </div>

                                                            <div class="form-group">
                                                                <label>Date To:</label>
                                                                <input type="text"  class="form-control" name="training_to" >
                                                            </div>

                                                            <div class="form-group">
                                                                <label>Hours:</label>
                                                                <input type="text"  class="form-control" name="training_hours" >
                                                            </div>
                                                            
                                                            <div class="form-group">
                                                                <label>Type:</label>
                                                                <input type="text"  class="form-control" name="training_type" >
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Conducted by:</label>
                                                                <input type="text"  class="form-control" name="sponsored_by" >
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Venue:</label>
                                                                <input type="text"  class="form-control" name="training_location" >
                                                            </div>
                                       


                                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                            <input type="hidden" value="{{$employee->id}}" name="cmd">
                                                            <button type="submit" class="btn btn-success btn-sm pull-right"><i class="fa fa-plus"></i> {{language_data('Add')}} </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-9">
                                                <div class="panel">
                                                    <div class="panel-heading">
                                                        <h3 class="panel-title">Trainings and Seminars</h3>
                                                    </div>
                                                    <div class="panel-body p-none">
                                                        <table class="table data-table table-hover table-ultra-responsive">
                                                            <thead>
                                                            <tr>
                                                                <th>Title</th>
                                                                <th>From</th>
                                                                <th>To</th>
                                                                <th>Hours</th>
                                                                <th>Type</th>
                                                                <th>Conducted by</th>
                                                                <th>Venue</th>
                                                                <th style="width: 5%;" class="text-right"></th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach($trainings as $training)
                                                                <tr>
                                                                    <td data-label="Title">{{$training->title}}</td>
                                                                    <td data-label="Date From"><p>{{$training->training_from}}</p></td>
                                                                    <td data-label="Date To"><p>{{$training->training_to}}</p></td>
                                                                    <td data-label="Hours"><p>{{$training->training_hours}}</p></td>
                                                                    <td data-label="Type"><p>{{$training->training_type}}</p></td>
                                                                    <td data-label="Conducted by"><p>{{$training->sponsored_by}}</p></td>
                                                                    <td data-label="Conducted by"><p>{{$training->training_location}}</p></td>
                                                                    <td class="text-right">
                                                                        <a href="#" data-toggle="tooltip" data-placement="top" title="Delete" class="btn btn-danger btn-xs deleteTraining" id="{{$training->id}}"><i class="fa fa-trash"></i></a>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    {{-- tab Trainings end --}}

                                    {{-- Organization --}}
                                    <div role="tabpanel" class="tab-pane" id="organization">
                                            <div class="row">
    
                                                <div class="col-lg-3">
                                                    <div class="panel">
                                                        <div class="panel-body">
                                                            <form class="" role="form" method="post" action="{{url('employee/add-organization')}}">
                                                                <div class="panel-heading">
                                                                    <h3 class="panel-title">Add Voluntary Work</h3>
                                                                </div>
    
                                                                <div class="form-group">
                                                                    <label>Organization</label>
                                                                    <input type="text" class="form-control" required name="org_name">
                                                                </div>
    
                                                                <div class="form-group">
                                                                    <label>Date From:</label>
                                                                    <input type="text"  class="form-control" name="org_from" >
                                                                </div>
    
                                                                <div class="form-group">
                                                                    <label>Date To:</label>
                                                                    <input type="text"  class="form-control" name="org_to" >
                                                                </div>
    
                                                                <div class="form-group">
                                                                    <label>Hours:</label>
                                                                    <input type="text"  class="form-control" name="org_hours" >
                                                                </div>
                                                                
                                                                <div class="form-group">
                                                                    <label>Position:</label>
                                                                    <input type="text"  class="form-control" name="org_position" >
                                                                </div>

                                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                                <input type="hidden" value="{{$employee->id}}" name="cmd">
                                                                <button type="submit" class="btn btn-success btn-sm pull-right"><i class="fa fa-plus"></i> {{language_data('Add')}} </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
    
                                                <div class="col-lg-9">
                                                    <div class="panel">
                                                        <div class="panel-heading">
                                                            <h3 class="panel-title">Voluntary Work</h3>
                                                        </div>
                                                        <div class="panel-body p-none">
                                                            <table class="table data-table table-hover table-ultra-responsive">
                                                                <thead>
                                                                <tr>
                                                                    <th>Organization</th>
                                                                    <th>Date From</th>
                                                                    <th>Date To</th>
                                                                    <th>Hours</th>
                                                                    <th>Position</th>
                                                                    <th style="width: 5%;" class="text-right"></th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                @foreach($organizations as $organization)
                                                                    <tr>
                                                                        <td data-label="Organization">{{$organization->org_name}}</td>
                                                                        <td data-label="Date From"><p>{{$organization->org_from}}</p></td>
                                                                        <td data-label="Date To"><p>{{$organization->org_to}}</p></td>
                                                                        <td data-label="Hours"><p>{{$organization->org_hours}}</p></td>
                                                                        <td data-label="Position"><p>{{$organization->org_position}}</p></td>
                                                                        <td class="text-right">
                                                                            <a href="#" data-toggle="tooltip" data-placement="top" title="Delete" class="btn btn-danger btn-xs deleteOrganization" id="{{$organization->id}}"><i class="fa fa-trash"></i></a>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
    
                                            </div>
                                        </div>
                                        {{-- tab Organization end --}}


                                        {{-- Skill --}}
                                        <div role="tabpanel" class="tab-pane" id="skill">
                                            <div class="row">
    
                                                <div class="col-lg-3">
                                                    <div class="panel">
                                                        <div class="panel-body">
                                                            <form class="" role="form" method="post" action="{{url('employee/add-skill')}}">
                                                                <div class="panel-heading">
                                                                    <h3 class="panel-title">Add Skill</h3>
                                                                </div>
    
                                                                <div class="form-group">
                                                                    <label>Skill</label>
                                                                    <input type="text" class="form-control" required name="name">
                                                                </div>
                                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                                <input type="hidden" value="{{$employee->id}}" name="cmd">
                                                                <button type="submit" class="btn btn-success btn-sm pull-right"><i class="fa fa-plus"></i> {{language_data('Add')}} </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
    
                                                <div class="col-lg-9">
                                                    <div class="panel">
                                                        <div class="panel-heading">
                                                            <h3 class="panel-title">Skills</h3>
                                                        </div>
                                                        <div class="panel-body p-none">
                                                            <table class="table data-table table-hover table-ultra-responsive">
                                                                <thead>
                                                                <tr>
                                                                    <th>Skill</th>
                                                                    <th style="width: 5%;" class="text-right"></th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                @foreach($skills as $skill)
                                                                    <tr>
                                                                        <td data-label="name">{{$skill->name}}</td>
                                                                        <td class="text-right">
                                                                            <a href="#" data-toggle="tooltip" data-placement="top" title="Delete" class="btn btn-danger btn-xs deleteSkill" id="{{$skill->id}}"><i class="fa fa-trash"></i></a>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
    
                                            </div>
                                        </div>
                                        {{-- tab Skill end --}}


                                          {{-- Recognition --}}
                                          <div role="tabpanel" class="tab-pane" id="recognition">
                                                <div class="row">
        
                                                    <div class="col-lg-3">
                                                        <div class="panel">
                                                            <div class="panel-body">
                                                                <form class="" role="form" method="post" action="{{url('employee/add-recognition')}}">
                                                                    <div class="panel-heading">
                                                                        <h3 class="panel-title">Add Recognition</h3>
                                                                    </div>
        
                                                                    <div class="form-group">
                                                                        <label>Skill</label>
                                                                        <input type="text" class="form-control" required name="name">
                                                                    </div>
                                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                                    <input type="hidden" value="{{$employee->id}}" name="cmd">
                                                                    <button type="submit" class="btn btn-success btn-sm pull-right"><i class="fa fa-plus"></i> {{language_data('Add')}} </button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
        
                                                    <div class="col-lg-9">
                                                        <div class="panel">
                                                            <div class="panel-heading">
                                                                <h3 class="panel-title">Recognitions</h3>
                                                            </div>
                                                            <div class="panel-body p-none">
                                                                <table class="table data-table table-hover table-ultra-responsive">
                                                                    <thead>
                                                                    <tr>
                                                                        <th>Skill</th>
                                                                        <th style="width: 5%;" class="text-right"></th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    @foreach($recognitions as $recognition)
                                                                        <tr>
                                                                            <td data-label="name">{{$recognition->name}}</td>
                                                                            <td class="text-right">
                                                                                <a href="#" data-toggle="tooltip" data-placement="top" title="Delete" class="btn btn-danger btn-xs deleteRecognition" id="{{$recognition->id}}"><i class="fa fa-trash"></i></a>
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
        
                                                </div>
                                            </div>
                                            {{-- tab Recognition end --}}

                                        {{-- Membership --}}
                                        <div role="tabpanel" class="tab-pane" id="membership">
                                                <div class="row">
        
                                                    <div class="col-lg-3">
                                                        <div class="panel">
                                                            <div class="panel-body">
                                                                <form class="" role="form" method="post" action="{{url('employee/add-membership')}}">
                                                                    <div class="panel-heading">
                                                                        <h3 class="panel-title">Add Membership</h3>
                                                                    </div>
        
                                                                    <div class="form-group">
                                                                        <label>Skill</label>
                                                                        <input type="text" class="form-control" required name="name">
                                                                    </div>
                                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                                    <input type="hidden" value="{{$employee->id}}" name="cmd">
                                                                    <button type="submit" class="btn btn-success btn-sm pull-right"><i class="fa fa-plus"></i> {{language_data('Add')}} </button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
        
                                                    <div class="col-lg-9">
                                                        <div class="panel">
                                                            <div class="panel-heading">
                                                                <h3 class="panel-title">Memberships</h3>
                                                            </div>
                                                            <div class="panel-body p-none">
                                                                <table class="table data-table table-hover table-ultra-responsive">
                                                                    <thead>
                                                                    <tr>
                                                                        <th>Membership</th>
                                                                        <th style="width: 5%;" class="text-right"></th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    @foreach($memberships as $membership)
                                                                        <tr>
                                                                            <td data-label="name">{{$membership->name}}</td>
                                                                            <td class="text-right">
                                                                                <a href="#" data-toggle="tooltip" data-placement="top" title="Delete" class="btn btn-danger btn-xs deleteMembership" id="{{$membership->id}}"><i class="fa fa-trash"></i></a>
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
        
                                                </div>
                                            </div>
                                            {{-- tab Membership end --}}


                                            {{-- Reference --}}
                                        <div role="tabpanel" class="tab-pane" id="reference">
                                                <div class="row">
        
                                                    <div class="col-lg-3">
                                                        <div class="panel">
                                                            <div class="panel-body">
                                                                <form class="" role="form" method="post" action="{{url('employee/add-reference')}}">
                                                                    <div class="panel-heading">
                                                                        <h3 class="panel-title">Add Reference</h3>
                                                                    </div>
        
                                                                    <div class="form-group">
                                                                        <label>Reference Name:</label>
                                                                        <input type="text" class="form-control" required name="ref_name">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Address:</label>
                                                                        <input type="text" class="form-control" required name="ref_address">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Contact No.:</label>
                                                                        <input type="text" class="form-control" name="ref_tel">
                                                                    </div>
                                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                                    <input type="hidden" value="{{$employee->id}}" name="cmd">
                                                                    <button type="submit" class="btn btn-success btn-sm pull-right"><i class="fa fa-plus"></i> {{language_data('Add')}} </button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
        
                                                    <div class="col-lg-9">
                                                        <div class="panel">
                                                            <div class="panel-heading">
                                                                <h3 class="panel-title">References</h3>
                                                            </div>
                                                            <div class="panel-body p-none">
                                                                <table class="table data-table table-hover table-ultra-responsive">
                                                                    <thead>
                                                                    <tr>
                                                                        <th>Reference Name</th>
                                                                        <th>Address</th>
                                                                        <th>Contact No.</th>
                                                                        <th style="width: 5%;" class="text-right"></th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    @foreach($references as $reference)
                                                                        <tr>
                                                                            <td data-label="name">{{$reference->ref_name}}</td>
                                                                            <td data-label="name">{{$reference->ref_address}}</td>
                                                                            <td data-label="name">{{$reference->ref_tel}}</td>
                                                                            <td class="text-right">
                                                                                <a href="#" data-toggle="tooltip" data-placement="top" title="Delete" class="btn btn-danger btn-xs deleteReference" id="{{$reference->id}}"><i class="fa fa-trash"></i></a>
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
        
                                                </div>
                                            </div>
                                            {{-- tab Reference end --}}



                                    {{-- document tab panel --}}
                        {{-- <div role="tabpanel" class="tab-pane" id="document">

                            <div class="row">

                                <div class="col-lg-3">
                                    <div class="panel">
                                        <div class="panel-body">
                                            <form class="" role="form" method="post" action="{{url('employee/add-document')}}" enctype="multipart/form-data">
                                                <div class="panel-heading">
                                                    <h3 class="panel-title"> {{language_data('Add Document')}}</h3>
                                                </div>

                                                <div class="form-group">
                                                    <label>{{language_data('Document Name')}}</label>
                                                    <span class="help">e.g. "Resume, Joining Letter etc"</span>
                                                    <input type="text" class="form-control" required name="document_name">
                                                </div>

                                                <div class="form-group">

                                                    <label>{{language_data('Select Document')}}</label>
                                                    <div class="input-group input-group-file">
                                                            <span class="input-group-btn">
                                                                <span class="btn btn-primary btn-file">
                                                                    {{language_data('Browse')}} <input type="file" class="form-control" name="file">
                                                                </span>
                                                            </span>
                                                        <input type="text" class="form-control" readonly="">
                                                    </div>
                                                </div>

                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <input type="hidden" value="{{$employee->id}}" name="cmd">
                                                <button type="submit" class="btn btn-success btn-sm pull-right"><i class="fa fa-plus"></i> {{language_data('Add')}} </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-9">
                                    <div class="panel">
                                        <div class="panel-heading">
                                            <h3 class="panel-title">{{language_data('All Documents')}}</h3>
                                        </div>
                                        <div class="panel-body p-none">
                                            <table class="table data-table table-hover table-ultra-responsive">
                                                <thead>
                                                <tr>
                                                    <th style="width: 65%;">{{language_data('Document Name')}}</th>
                                                    <th style="width: 35%;" class="text-right">{{language_data('Actions')}}</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($employee_doc as $ed)
                                                    <tr>
                                                        <td data-label="Document Name">{{$ed->file_title}}</td>
                                                        <td class="text-right">
                                                            <a href="{{url('employee/download-employee-document/'.$ed->id)}}" class="btn btn-success btn-xs"><i class="fa fa-download"></i> {{language_data('Download')}}</a>
                                                            <a href="#" class="btn btn-danger btn-xs deleteEmployeeDoc" id="{{$ed->id}}"><i class="fa fa-trash"></i> {{language_data('Delete')}}</a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div> --}}
                        {{-- document tab end --}}

                        {{-- profile tab --}}
                        <div role="tabpanel" class="tab-pane" id="change-picture">
                            {{-- <form role="form" action="{{url('employees/update-employee-avatar')}}" method="post" enctype="multipart/form-data"> --}}

                                <div class="row">
                                    <div class="col-md-4">

                                        <div class="form-group input-group input-group-file">
                                                <span class="input-group-btn">
                                                    <span class="btn btn-primary btn-file">
                                                        {{language_data('Browse')}} <input type="file" class="form-control" name="image">
                                                    </span>
                                                </span>
                                            <input type="text" class="form-control" readonly="">
                                        </div>

                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" value="{{$employee->id}}" name="cmd">
                                        
                                        <div class="form-group">
                                            <label>{{language_data('Employee Code')}}</label>
                                            <span class="help">e.g. "546814" ({{language_data('Unique For every User')}})</span>
                                            <input type="text" class="form-control" required name="employee_code" value="{{$employee->employee_code}}">
                                        </div>

                                        <div class="form-group">
                                            <label>{{language_data('Username')}}</label>
                                            <span class="help">e.g. "employee" ({{language_data('Unique For every User')}})</span>
                                            <input type="text" class="form-control" required name="username" value="{{$employee->user_name}}">
                                        </div>


                                        <div class="form-group">
                                            <label>{{language_data('Email')}}</label>
                                            <span class="help">e.g. "coderpixel@gmail.com" ({{language_data('Unique For every User')}})</span>
                                            <input type="email" class="form-control" required name="email" value="{{$employee->email}}">
                                        </div>

                                        <div class="form-group">
                                            <label>{{language_data('Password')}}</label>
                                            <span class="help">{{language_data('Leave blank if you no need to change password')}}</span>
                                            <input type="password" class="form-control" name="password">
                                        </div>

                                        <div class="form-group">
                                            <label>{{language_data('Confirm Password')}}</label>
                                            <span class="help">{{language_data('Leave blank if you no need to change password')}}</span>
                                            <input type="password" class="form-control" name="rpassword">
                                        </div>
								
					
                                        <input type="submit" value="{{language_data('Update')}}" class="btn btn-primary">

                                    </div>

                                </div>

                            {{-- </form> --}}
                        </div>
                        {{-- profile tab end --}}




                    </div>
                    
                            
                </div>
                
            </div>
        </div>
    </section>
</form>
@endsection

{{--External Style Section--}}
@section('script')
    {!! Html::script("assets/libs/handlebars/handlebars.runtime.min.js")!!}
    {!! Html::script("assets/libs/moment/moment.min.js")!!}
    {!! Html::script("assets/libs/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js")!!}
    {!! Html::script("assets/libs/wysihtml5x/wysihtml5x-toolbar.min.js")!!}
    {!! Html::script("assets/libs/bootstrap3-wysihtml5-bower/bootstrap3-wysihtml5.min.js")!!}
    {!! Html::script("assets/libs/data-table/datatables.min.js")!!}
    {!! Html::script("assets/js/form-elements-page.js")!!}
    {!! Html::script("assets/js/bootbox.min.js")!!}

    <script>
        $(document).ready(function () {

            /*For DataTable*/
            $('.data-table').DataTable();


            /*For Designation Loading*/
            $("#department_id").change(function () {
                var id = $(this).val();
                var _url = $("#_url").val();
                var dataString = 'dep_id=' + id;
                $.ajax
                ({
                    type: "POST",
                    url: _url + '/employee/get-designation',
                    data: dataString,
                    cache: false,
                    success: function ( data ) {
                        $("#designation").html( data).removeAttr('disabled').selectpicker('refresh');
                    }
                });
            });


            /*For Delete Child*/
            $(".deleteChild").click(function (e) {
                e.preventDefault();
                var id = this.id;
                bootbox.confirm("Are you sure?", function (result) {
                    if (result) {
                        var _url = $("#_url").val();
                        window.location.href = _url + "/employee/delete-child/" + id;
                    }
                });
            });

            /*For Delete Eligibility*/
            $(".deleteEligibility").click(function (e) {
                e.preventDefault();
                var id = this.id;
                bootbox.confirm("Are you sure?", function (result) {
                    if (result) {
                        var _url = $("#_url").val();
                        window.location.href = _url + "/employee/delete-eligibility/" + id;
                    }
                });
            });

            /*For Delete Experience*/
            $(".deleteExperience").click(function (e) {
                e.preventDefault();
                var id = this.id;
                bootbox.confirm("Are you sure?", function (result) {
                    if (result) {
                        var _url = $("#_url").val();
                        window.location.href = _url + "/employee/delete-experience/" + id;
                    }
                });
            });

            /*For Delete Training*/
            $(".deleteTraining").click(function (e) {
                e.preventDefault();
                var id = this.id;
                bootbox.confirm("Are you sure?", function (result) {
                    if (result) {
                        var _url = $("#_url").val();
                        window.location.href = _url + "/employee/delete-training/" + id;
                    }
                });
            });

            /*For Delete Organization*/
            $(".deleteOrganization").click(function (e) {
                e.preventDefault();
                var id = this.id;
                bootbox.confirm("Are you sure?", function (result) {
                    if (result) {
                        var _url = $("#_url").val();
                        window.location.href = _url + "/employee/delete-organization/" + id;
                    }
                });
            });


              /*For Delete Skill*/
              $(".deleteSkill").click(function (e) {
                e.preventDefault();
                var id = this.id;
                bootbox.confirm("Are you sure?", function (result) {
                    if (result) {
                        var _url = $("#_url").val();
                        window.location.href = _url + "/employee/delete-skill/" + id;
                    }
                });
            });

             /*For Delete Recognition*/
             $(".deleteRecognition").click(function (e) {
                e.preventDefault();
                var id = this.id;
                bootbox.confirm("Are you sure?", function (result) {
                    if (result) {
                        var _url = $("#_url").val();
                        window.location.href = _url + "/employee/delete-recognition/" + id;
                    }
                });
            });

             /*For Delete Membership*/
             $(".deleteMembership").click(function (e) {
                e.preventDefault();
                var id = this.id;
                bootbox.confirm("Are you sure?", function (result) {
                    if (result) {
                        var _url = $("#_url").val();
                        window.location.href = _url + "/employee/delete-membership/" + id;
                    }
                });
            });

            /*For Delete Reference*/
            $(".deleteReference").click(function (e) {
                e.preventDefault();
                var id = this.id;
                bootbox.confirm("Are you sure?", function (result) {
                    if (result) {
                        var _url = $("#_url").val();
                        window.location.href = _url + "/employee/delete-reference/" + id;
                    }
                });
            });


            /*For Delete Employee Doc*/
            $(".deleteEmployeeDoc").click(function (e) {
                e.preventDefault();
                var id = this.id;
                bootbox.confirm("Are you sure?", function (result) {
                    if (result) {
                        var _url = $("#_url").val();
                        window.location.href = _url + "/employee/delete-employee-doc/" + id;
                    }
                });
            });


        });
    </script>

@endsection
