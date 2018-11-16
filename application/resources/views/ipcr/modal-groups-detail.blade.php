<div class="modal fade modal-groups-detail{{$ig->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">

    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Edit IPCR Rating Period</h4>
            </div>
            <form class="form-some-up form-block" role="form" action="{{url('ipcr/update-ipcr-group')}}" method="post">

                <div class="modal-body">

                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" required="" name="name" value="{{$ig->name}}">
                    </div>

                    <div class="form-group">
                        <label>Description</label>
                        <input type="text" class="form-control" required="" name="description" value="{{$ig->description}}">
                    </div>

                    <div class="form-group">
                        <label>{{language_data('Employee')}}</label>
                        <select class="form-control selectpicker" multiple data-live-search="true" name="employee[]">
                            @foreach($employees as $e)
                            <?php $group_members=App\IpcrGroupsMember::where('ipcr_group_id',$ig->id)->get(['employee_id'])->toArray(); ?>
                                <option value="{{$e->id}}" @if(in_array_r($e->id,$group_members)) selected @endif>{{$e->fullname}}</option>
                            @endforeach
                        </select>
                    </div>
                    

                </div>
                <div class="modal-footer">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <input type="hidden" name="cmd" value="{{$ig->id}}">
                    <a href="{{url('ipcr/delete-ipcr-group/'. $ig->id)}}" class="btn  btn-danger pull-left">
                        <span class="glyphicon glyphicon-export" aria-hidden="true"></span>Delete
                    </a>

                    <button type="button" class="btn btn-default" data-dismiss="modal">{{language_data('Close')}}</button>
                    <button type="submit" class="btn btn-primary">{{language_data('Update')}}</button>
                </div>

            </form>
        </div>
    </div>

</div>

