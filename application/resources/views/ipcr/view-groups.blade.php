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
                            <h3 class="panel-title">IPCR Groups and Members</h3>
                            <a class="btn btn-primary pull-right" href="#" data-toggle="modal" data-target=".modal-groups-add"><i class="fa fa-plus"></i>&nbsp;Add&nbsp;&nbsp;</a>
                                            @include('ipcr.modal-groups-add')
                            <br />
                        </div>
                        <div class="panel-body p-none">
                            <table class="table data-table table-hover table-ultra-responsive">
                                <thead>
                                <tr>
                                    <th width="3%" style="padding: 2x;">No.</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Members</th>
                                    <th class="text-right"></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $no = 1; ?>
                                @foreach($ipcr_groups as $ig)
                                    <tr>
                                    	
					                    <td style="padding: 10px;" width="3%" style="padding: 2x;"> {{$no}}.</td>
                                        <td style="padding: 10px;" align="left" width="20%" >{{$ig->name}}</td>
                                        <td style="padding: 10px;" align="left" width="40%" >{{$ig->description}}</td>
                                        <td style="padding: 10px;" align="left" width="30%" >
                                            <?php
                                                    $members=App\IpcrGroupsMember::where('ipcr_group_id',$ig->id)->get();
                                                    $num = 1;
                                                    foreach ($members as $member){
                                                        if ($num==1) {
                                                            echo DB::table('employee')->where('id', $member->employee_id)->value('fullname');
                                                        }else{
                                                            echo ", <br /> " . DB::table('employee')->where('id', $member->employee_id)->value('fullname');
                                                        }
                                                        $num++;
                                                    }
                                                ?>
                                        </td>

                                        <td style="padding: 10px;" data-label="Actions" width="19%">
                                            <a class="btn btn-success btn-xs pull-left" href="#" data-toggle="modal" data-target=".modal-groups-detail{{$ig->id}}"><i class="fa fa-eye"></i>&nbsp;Edit&nbsp;&nbsp;</a>
                                            @include('ipcr.modal-groups-detail')
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
