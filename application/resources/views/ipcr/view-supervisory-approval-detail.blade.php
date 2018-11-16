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
                            <h3 class="panel-title">IPCR Supervisory Indicator Approval</h3>
                            <a class="btn btn-primary pull-right" href="#"><i class="fa fa-plus"></i>&nbsp;Approve All</a>
                            <br />
                        </div>
                        <div class="panel-body p-none">
                            <table class="table">
                                <thead>
                                    <tr>    
                                        <th rowspan="2">MFO/POP</th>
                                        <th rowspan="2">&nbsp;</th>
                                        <th rowspan="2">Weight</th>
                                        <th rowspan="2">Indicator</th>
                                        <th rowspan="2">Approved By</th>
                                        <th rowspan="2">&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                        
                                       
                                        @if ($grp_cnt_1>0)
                                            <tr>
                                                <td colspan="15">{{DB::table('ipcr_mfo_groups')->where('id', 1)->value('name')}} - {{DB::table('ipcr_employees')->where('id',session('ipcr_emp_rec_id'))->value('mfo_group_1_weight')}}%</td>
                                            </tr>

                                            @foreach($ipcr_mfos as $mfos)
                                                <?php 
                                                    $mfo_indicators = App\IpcrRatingsDetail::where('employee_id',$ratee_emp_id)->where('ipcr_rating_id',$mfos->id)->get(); 
                                                    $count_indicator = count($mfo_indicators);
                                                    if($count_indicator==0){
                                                        $count_indicator = 1;
                                                    }
                                                ?>
                                                @if ($mfos->mfo_group_id==1)
                                                    <tr >
                                                        <td rowspan="{{$count_indicator}}">{{$mfos->mfo_name}}</td>
                                                        <td rowspan="{{$count_indicator}}">&nbsp;
                                                        </td>

                                                        <?php 
                                                           $newrow = false;
                                                            if ($mfo_indicators){
                                                                foreach ($mfo_indicators as $indicator) {
                                                                    if ($newrow==true){
                                                                        echo "<tr>";
                                                                    }
                                                                    echo "<td>" . $indicator->weight . "</td>";
                                                                    echo "<td>" . $indicator->indicator . "</td>";
                                                                    
                                                                    if ( DB::table('ipcr_periods')->where('id', $indicator->ipcr_period_id)->value('status_approval')=="open" ){
                                                                        $status_approval = "info";
                                                                    }else{
                                                                        $status_approval = "danger";
                                                                    }
                                                                    if (DB::table('ipcr_periods')->where('id', $indicator->ipcr_period_id)->value('status_rating')=="open"){
                                                                        $status_rating = "info";
                                                                    }else{
                                                                        $status_rating = "danger";
                                                                    }
                                                                    echo '<td><span class="label label-' . $status_approval . '" >' . DB::table('ipcr_groups')->where('id', $indicator->group_approval_id)->value('name') .'</span></td>';
                                                                    echo "<td>";
                                                                    ?>
                                                                  
                                                                  <div class="form-group">
            
                                                                        <select class="form-control selectpicker"  name="{{ $indicator->status_approval }}">
                                                                            <option value="Pending" @if($indicator->status_approval=='Pending') selected @endif><span class="label-primary">Pending</span></option>
                                                                            <option value="Approved" @if($indicator->status_approval=='Approved') selected @endif>Approved</option>
                                                                            <option value="Rejected" @if($indicator->status_approval=='Rejected') selected @endif>Rejected</option>
                                                                        </select>
                                                                    </div>


                                                                    <?php
                                                                    
                                                                    echo "</td>";
                                                                   if ($count_indicator>1){
                                                                       $newrow = true;
                                                                       echo "</tr>";
                                                                   }
                                                                }

                                                            }else{
                                                                echo '<td></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td></td>';
                                                            }
                                                        ?>

                                                        
                                                      </tr>
                                                @endif
                                            @endforeach
                                        @endif

                                        @if ($grp_cnt_2>0)
                                            <tr>
                                                <td colspan="15">{{DB::table('ipcr_mfo_groups')->where('id', 2)->value('name')}} - {{DB::table('ipcr_employees')->where('id', $mfos->ipcr_emp_rec_id)->value('mfo_group_2_weight')}}%</td>
                                            </tr>
                                            @foreach($ipcr_mfos as $mfos)
                                                <?php 
                                                    $mfo_indicators = App\IpcrRatingsDetail::where('employee_id',$ratee_emp_id)->where('ipcr_rating_id',$mfos->id)->get(); 
                                                    $count_indicator = count($mfo_indicators);
                                                    if($count_indicator==0){
                                                        $count_indicator = 1;
                                                    }
                                                ?>
                                                @if ($mfos->mfo_group_id==2)
                                                    <tr >
                                                        <td rowspan="{{$count_indicator}}">{{$mfos->mfo_name}}</td>
                                                        <td rowspan="{{$count_indicator}}">&nbsp;
                                                        </td>

                                                        <?php 
                                                           $newrow = false;
                                                            if ($mfo_indicators){
                                                                foreach ($mfo_indicators as $indicator) {
                                                                    if ($newrow==true){
                                                                        echo "<tr>";
                                                                    }
                                                                    echo "<td>" . $indicator->weight . "</td>";
                                                                    echo "<td>" . $indicator->indicator . "</td>";
                                                                    if ( DB::table('ipcr_periods')->where('id', $indicator->ipcr_period_id)->value('status_approval')=="open" ){
                                                                        $status_approval = "info";
                                                                    }else{
                                                                        $status_approval = "danger";
                                                                    }
                                                                    if (DB::table('ipcr_periods')->where('id', $indicator->ipcr_period_id)->value('status_rating')=="open"){
                                                                        $status_rating = "info";
                                                                    }else{
                                                                        $status_rating = "danger";
                                                                    }
                                                                    echo '<td><span class="label label-' . $status_approval . '" >' . DB::table('ipcr_groups')->where('id', $indicator->group_approval_id)->value('name') .'</span></td>';
                                                                    echo "<td>";
                                                                    ?>
                                                                    <a class="btn btn-primary btn-xs pull-right" href="#" data-toggle="modal" data-target=".modal-employee-mfo-indicator-detail{{$indicator->id}}"><i class="fa fa-plus"></i>&nbsp;Approve</a>
                                                             @include('ipcr.modal-employee-mfo-indicator-detail')
                                                                    
                                                                    <?php
                                                                    echo "</td>";
                                                                   if ($count_indicator>1){
                                                                       $newrow = true;
                                                                       echo "</tr>";
                                                                   }
                                                                }

                                                            }else{
                                                                echo '<td></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td></td>';
                                                            }
                                                        ?>

                                                        
                                                      </tr>
                                                @endif
                                            @endforeach
                                        @endif
                                        @if ($grp_cnt_3>0)
                                            <tr>
                                                <td colspan="15">{{DB::table('ipcr_mfo_groups')->where('id', 3)->value('name')}} - {{DB::table('ipcr_employees')->where('id', $mfos->ipcr_emp_rec_id)->value('mfo_group_3_weight')}}%</td>
                                            </tr>
                                            @foreach($ipcr_mfos as $mfos)
                                                <?php 
                                                    $mfo_indicators = App\IpcrRatingsDetail::where('employee_id',$ratee_emp_id)->where('ipcr_rating_id',$mfos->id)->get(); 
                                                    $count_indicator = count($mfo_indicators);
                                                    if($count_indicator==0){
                                                        $count_indicator = 1;
                                                    }
                                                ?>
                                                @if ($mfos->mfo_group_id==3)
                                                    <tr >
                                                        <td rowspan="{{$count_indicator}}">{{$mfos->mfo_name}}</td>
                                                        <td rowspan="{{$count_indicator}}">&nbsp;
                                                        </td>

                                                        <?php 
                                                           $newrow = false;
                                                            if ($mfo_indicators){
                                                                foreach ($mfo_indicators as $indicator) {
                                                                    if ($newrow==true){
                                                                        echo "<tr>";
                                                                    }
                                                                    echo "<td>" . $indicator->weight . "</td>";
                                                                    echo "<td>" . $indicator->indicator . "</td>";
                                                                    if ( DB::table('ipcr_periods')->where('id', $indicator->ipcr_period_id)->value('status_approval')=="open" ){
                                                                        $status_approval = "info";
                                                                    }else{
                                                                        $status_approval = "danger";
                                                                    }
                                                                    if (DB::table('ipcr_periods')->where('id', $indicator->ipcr_period_id)->value('status_rating')=="open"){
                                                                        $status_rating = "info";
                                                                    }else{
                                                                        $status_rating = "danger";
                                                                    }
                                                                    echo '<td><span class="label label-' . $status_approval . '" >' . DB::table('ipcr_groups')->where('id', $indicator->group_approval_id)->value('name') .'</span></td>';
                                                                    echo "<td>";
                                                                    ?>
                                                                    <a class="btn btn-primary btn-xs pull-right" href="#" data-toggle="modal" data-target=".modal-employee-mfo-indicator-detail{{$indicator->id}}"><i class="fa fa-plus"></i>&nbsp;Approve</a>
                                                             @include('ipcr.modal-employee-mfo-indicator-detail')
                                                                    <?php
                                                                    
                                                                    echo "</td>";
                                                                   if ($count_indicator>1){
                                                                       $newrow = true;
                                                                       echo "</tr>";
                                                                   }
                                                                }

                                                            }else{
                                                                echo '<td></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td></td>';
                                                            }
                                                        ?>

                                                        
                                                      </tr>
                                                @endif
                                            @endforeach
                                        @endif
                                        @if ($grp_cnt_4>0)
                                            <tr>
                                                <td colspan="15">{{DB::table('ipcr_mfo_groups')->where('id', 4)->value('name')}} - {{DB::table('ipcr_employees')->where('id', $mfos->ipcr_emp_rec_id)->value('mfo_group_4_weight')}}%</td>
                                            </tr>
                                            @foreach($ipcr_mfos as $mfos)
                                                <?php 
                                                    $mfo_indicators = App\IpcrRatingsDetail::where('employee_id',$ratee_emp_id)->where('ipcr_rating_id',$mfos->id)->get(); 
                                                    $count_indicator = count($mfo_indicators);
                                                    if($count_indicator==0){
                                                        $count_indicator = 1;
                                                    }
                                                ?>
                                                @if ($mfos->mfo_group_id==4)
                                                    <tr >
                                                        <td rowspan="{{$count_indicator}}">{{$mfos->mfo_name}}</td>
                                                        <td rowspan="{{$count_indicator}}">&nbsp;
                                                        </td>

                                                        <?php 
                                                           $newrow = false;
                                                            if ($mfo_indicators){
                                                                foreach ($mfo_indicators as $indicator) {
                                                                    if ($newrow==true){
                                                                        echo "<tr>";
                                                                    }
                                                                    echo "<td>" . $indicator->weight . "</td>";
                                                                    echo "<td>" . $indicator->indicator . "</td>";
                                                                    if ( DB::table('ipcr_periods')->where('id', $indicator->ipcr_period_id)->value('status_approval')=="open" ){
                                                                        $status_approval = "info";
                                                                    }else{
                                                                        $status_approval = "danger";
                                                                    }
                                                                    if (DB::table('ipcr_periods')->where('id', $indicator->ipcr_period_id)->value('status_rating')=="open"){
                                                                        $status_rating = "info";
                                                                    }else{
                                                                        $status_rating = "danger";
                                                                    }
                                                                    echo '<td><span class="label label-' . $status_approval . '" >' . DB::table('ipcr_groups')->where('id', $indicator->group_approval_id)->value('name') .'</span></td>';
                                                                    echo "<td>";
                                                                    ?>
                                                                    <a class="btn btn-primary btn-xs pull-right" href="#" data-toggle="modal" data-target=".modal-employee-mfo-indicator-detail{{$indicator->id}}"><i class="fa fa-plus"></i>&nbsp;Approve</a>
                                                             @include('ipcr.modal-employee-mfo-indicator-detail')
                                                                    <?php
                                                                    
                                                                    echo "</td>";
                                                                   if ($count_indicator>1){
                                                                       $newrow = true;
                                                                       echo "</tr>";
                                                                   }
                                                                }

                                                            }else{
                                                                echo '<td></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td></td>';
                                                            }
                                                        ?>

                                                        
                                                      </tr>
                                                @endif
                                            @endforeach
                                        @endif
                                        @if ($grp_cnt_5>0)
                                            <tr>
                                                <td colspan="15">{{DB::table('ipcr_mfo_groups')->where('id', 5)->value('name')}} - {{DB::table('ipcr_employees')->where('id', $mfos->ipcr_emp_rec_id)->value('mfo_group_5_weight')}}%</td>
                                            </tr>
                                            @foreach($ipcr_mfos as $mfos)
                                                <?php 
                                                    $mfo_indicators = App\IpcrRatingsDetail::where('employee_id',$ratee_emp_id)->where('ipcr_rating_id',$mfos->id)->get(); 
                                                    $count_indicator = count($mfo_indicators);
                                                    if($count_indicator==0){
                                                        $count_indicator = 1;
                                                    }
                                                ?>
                                                @if ($mfos->mfo_group_id==5)
                                                    <tr >
                                                        <td rowspan="{{$count_indicator}}">{{$mfos->mfo_name}}</td>
                                                        <td rowspan="{{$count_indicator}}">&nbsp;
                                                        </td>

                                                        <?php 
                                                           $newrow = false;
                                                            if ($mfo_indicators){
                                                                foreach ($mfo_indicators as $indicator) {
                                                                    if ($newrow==true){
                                                                        echo "<tr>";
                                                                    }
                                                                    echo "<td>" . $indicator->weight . "</td>";
                                                                    echo "<td>" . $indicator->indicator . "</td>";
                                                                    if ( DB::table('ipcr_periods')->where('id', $indicator->ipcr_period_id)->value('status_approval')=="open" ){
                                                                        $status_approval = "info";
                                                                    }else{
                                                                        $status_approval = "danger";
                                                                    }
                                                                    if (DB::table('ipcr_periods')->where('id', $indicator->ipcr_period_id)->value('status_rating')=="open"){
                                                                        $status_rating = "info";
                                                                    }else{
                                                                        $status_rating = "danger";
                                                                    }
                                                                    echo '<td><span class="label label-' . $status_approval . '" >' . DB::table('ipcr_groups')->where('id', $indicator->group_approval_id)->value('name') .'</span></td>';
                                                                    echo "<td>";
                                                                    ?>
                                                                    <a class="btn btn-primary btn-xs pull-right" href="#" data-toggle="modal" data-target=".modal-employee-mfo-indicator-detail{{$indicator->id}}"><i class="fa fa-plus"></i>&nbsp;Approve</a>
                                                             @include('ipcr.modal-employee-mfo-indicator-detail')
                                                                    <?php
                                                                    
                                                                    echo "</td>";
                                                                   if ($count_indicator>1){
                                                                       $newrow = true;
                                                                       echo "</tr>";
                                                                   }
                                                                }

                                                            }else{
                                                                echo '<td></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td></td>';
                                                            }
                                                        ?>

                                                        
                                                      </tr>
                                                @endif
                                            @endforeach
                                        @endif
                                        @if ($grp_cnt_6>0)
                                            <tr>
                                                <td colspan="15">{{DB::table('ipcr_mfo_groups')->where('id', 6)->value('name')}} - {{DB::table('ipcr_employees')->where('id', $mfos->ipcr_emp_rec_id)->value('mfo_group_6_weight')}}%</td>
                                            </tr>
                                            @foreach($ipcr_mfos as $mfos)
                                                <?php 
                                                    $mfo_indicators = App\IpcrRatingsDetail::where('employee_id',$ratee_emp_id)->where('ipcr_rating_id',$mfos->id)->get(); 
                                                    $count_indicator = count($mfo_indicators);
                                                    if($count_indicator==0){
                                                        $count_indicator = 1;
                                                    }
                                                ?>
                                                @if ($mfos->mfo_group_id==6)
                                                    <tr >
                                                        <td rowspan="{{$count_indicator}}">{{$mfos->mfo_name}}</td>
                                                        <td rowspan="{{$count_indicator}}">&nbsp;
                                                        </td>

                                                        <?php 
                                                           $newrow = false;
                                                            if ($mfo_indicators){
                                                                foreach ($mfo_indicators as $indicator) {
                                                                    if ($newrow==true){
                                                                        echo "<tr>";
                                                                    }
                                                                    echo "<td>" . $indicator->weight . "</td>";
                                                                    echo "<td>" . $indicator->indicator . "</td>";
                                                                    if ( DB::table('ipcr_periods')->where('id', $indicator->ipcr_period_id)->value('status_approval')=="open" ){
                                                                        $status_approval = "info";
                                                                    }else{
                                                                        $status_approval = "danger";
                                                                    }
                                                                    if (DB::table('ipcr_periods')->where('id', $indicator->ipcr_period_id)->value('status_rating')=="open"){
                                                                        $status_rating = "info";
                                                                    }else{
                                                                        $status_rating = "danger";
                                                                    }
                                                                    echo '<td><span class="label label-' . $status_approval . '" >' . DB::table('ipcr_groups')->where('id', $indicator->group_approval_id)->value('name') .'</span></td>';
                                                                    echo "<td>";
                                                                    ?>
                                                                    <a class="btn btn-primary btn-xs pull-right" href="#" data-toggle="modal" data-target=".modal-employee-mfo-indicator-detail{{$indicator->id}}"><i class="fa fa-plus"></i>&nbsp;Approve</a>
                                                             @include('ipcr.modal-employee-mfo-indicator-detail')
                                                                    <?php
                                                                    
                                                                    echo "</td>";
                                                                   if ($count_indicator>1){
                                                                       $newrow = true;
                                                                       echo "</tr>";
                                                                   }
                                                                }

                                                            }else{
                                                                echo '<td></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td></td>';
                                                            }
                                                        ?>

                                                        
                                                      </tr>
                                                @endif
                                            @endforeach
                                        @endif
                                        @if ($grp_cnt_7>0)
                                            <tr>
                                                <td colspan="15">{{DB::table('ipcr_mfo_groups')->where('id', 7)->value('name')}} - {{DB::table('ipcr_employees')->where('id', $mfos->ipcr_emp_rec_id)->value('mfo_group_7_weight')}}%</td>
                                            </tr>
                                            @foreach($ipcr_mfos as $mfos)
                                                <?php 
                                                    $mfo_indicators = App\IpcrRatingsDetail::where('employee_id',$ratee_emp_id)->where('ipcr_rating_id',$mfos->id)->get(); 
                                                    $count_indicator = count($mfo_indicators);
                                                    if($count_indicator==0){
                                                        $count_indicator = 1;
                                                    }
                                                ?>
                                                @if ($mfos->mfo_group_id==7)
                                                    <tr >
                                                        <td rowspan="{{$count_indicator}}">{{$mfos->mfo_name}}</td>
                                                        <td rowspan="{{$count_indicator}}">&nbsp;
                                                        </td>

                                                        <?php 
                                                           $newrow = false;
                                                            if ($mfo_indicators){
                                                                foreach ($mfo_indicators as $indicator) {
                                                                    if ($newrow==true){
                                                                        echo "<tr>";
                                                                    }
                                                                    echo "<td>" . $indicator->weight . "</td>";
                                                                    echo "<td>" . $indicator->indicator . "</td>";
                                                                    if ( DB::table('ipcr_periods')->where('id', $indicator->ipcr_period_id)->value('status_approval')=="open" ){
                                                                        $status_approval = "info";
                                                                    }else{
                                                                        $status_approval = "danger";
                                                                    }
                                                                    if (DB::table('ipcr_periods')->where('id', $indicator->ipcr_period_id)->value('status_rating')=="open"){
                                                                        $status_rating = "info";
                                                                    }else{
                                                                        $status_rating = "danger";
                                                                    }
                                                                    echo '<td><span class="label label-' . $status_approval . '" >' . DB::table('ipcr_groups')->where('id', $indicator->group_approval_id)->value('name') .'</span></td>';
                                                                    echo "<td>";
                                                                    ?>
                                                                    <a class="btn btn-primary btn-xs pull-right" href="#" data-toggle="modal" data-target=".modal-employee-mfo-indicator-detail{{$indicator->id}}"><i class="fa fa-plus"></i>&nbsp;Approve</a>
                                                             @include('ipcr.modal-employee-mfo-indicator-detail')
                                                                    <?php
                                                                    
                                                                    echo "</td>";
                                                                   if ($count_indicator>1){
                                                                       $newrow = true;
                                                                       echo "</tr>";
                                                                   }
                                                                }

                                                            }else{
                                                                echo '<td></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td></td>';
                                                            }
                                                        ?>

                                                        
                                                      </tr>
                                                @endif
                                            @endforeach
                                        @endif
                                        @if ($grp_cnt_8>0)
                                            <tr>
                                                <td colspan="15">{{DB::table('ipcr_mfo_groups')->where('id', 8)->value('name')}} - {{DB::table('ipcr_employees')->where('id', $mfos->ipcr_emp_rec_id)->value('mfo_group_8_weight')}}%</td>
                                            </tr>
                                            @foreach($ipcr_mfos as $mfos)
                                                <?php 
                                                    $mfo_indicators = App\IpcrRatingsDetail::where('employee_id',$ratee_emp_id)->where('ipcr_rating_id',$mfos->id)->get(); 
                                                    $count_indicator = count($mfo_indicators);
                                                    if($count_indicator==0){
                                                        $count_indicator = 1;
                                                    }
                                                ?>
                                                @if ($mfos->mfo_group_id==8)
                                                    <tr >
                                                        <td rowspan="{{$count_indicator}}">{{$mfos->mfo_name}}</td>
                                                        <td rowspan="{{$count_indicator}}">&nbsp;
                                                        </td>

                                                        <?php 
                                                           $newrow = false;
                                                            if ($mfo_indicators){
                                                                foreach ($mfo_indicators as $indicator) {
                                                                    if ($newrow==true){
                                                                        echo "<tr>";
                                                                    }
                                                                    echo "<td>" . $indicator->weight . "</td>";
                                                                    echo "<td>" . $indicator->indicator . "</td>";
                                                                    if ( DB::table('ipcr_periods')->where('id', $indicator->ipcr_period_id)->value('status_approval')=="open" ){
                                                                        $status_approval = "info";
                                                                    }else{
                                                                        $status_approval = "danger";
                                                                    }
                                                                    if (DB::table('ipcr_periods')->where('id', $indicator->ipcr_period_id)->value('status_rating')=="open"){
                                                                        $status_rating = "info";
                                                                    }else{
                                                                        $status_rating = "danger";
                                                                    }
                                                                    echo '<td><span class="label label-' . $status_approval . '" >' . DB::table('ipcr_groups')->where('id', $indicator->group_approval_id)->value('name') .'</span></td>';
                                                                    echo "<td>";
                                                                    ?>
                                                                    <a class="btn btn-primary btn-xs pull-right" href="#" data-toggle="modal" data-target=".modal-employee-mfo-indicator-detail{{$indicator->id}}"><i class="fa fa-plus"></i>&nbsp;Approve</a>
                                                             @include('ipcr.modal-employee-mfo-indicator-detail')
                                                                    <?php
                                                                    
                                                                    echo "</td>";
                                                                   if ($count_indicator>1){
                                                                       $newrow = true;
                                                                       echo "</tr>";
                                                                   }
                                                                }

                                                            }else{
                                                                echo '<td></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td></td>';
                                                            }
                                                        ?>

                                                        
                                                      </tr>
                                                @endif
                                            @endforeach
                                        @endif
                                 
    
                                    </tbody>
                                </table>
                        </div>

                        <div class="panel-footer">
                            <div class="form-group">
                                <label>Overall Remarks</label>
                                <textarea class="textarea-wysihtml5 form-control" style="height:60px;" class="pull-left"></textarea>
                            </div>
                            <a class="btn btn-primary pull-right" href="#"><i class="fa fa-plus"></i>&nbsp;Approve All</a>
                            <br />
                            <br />
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

@endsection
