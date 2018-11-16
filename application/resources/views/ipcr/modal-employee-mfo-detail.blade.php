<div class="modal fade modal-employee-mfo-detail{{$mfos->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">

    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Edit MFO</h4>
            </div>
            <form class="form-some-up form-block" role="form" action="{{url('ipcr/update-ipcr-mfo')}}" method="post">

                <div class="modal-body">

                	<div class="form-group">
	                        <label>MFO Group</label>
	                        <select class="form-control selectpicker" data-live-search="true" name="mfo_group_id">
	                            @foreach($mfo_groups as $mg)
	                                <option value="{{$mg->id}}" @if($mfos->id==$mg->id) selected @endif >{{$mg->name}}</option>
	                            @endforeach
	                        </select>
	                    </div>
	
	                    <div class="form-group">
	                        <label>Name</label>
	                        <input type="text" class="form-control" required="" name="mfo_name" value="{{$mfos->mfo_name}}">
	                    </div>
	
	                    {{-- <div class="form-group">
	                        <label>Default Weight</label>
	                        <input type="number" class="form-control" required="" name="default_weight" value="{{$mfos->default_weight}}">
	                    </div> --}}
                    

                </div>
                <div class="modal-footer">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <input type="hidden" name="cmd" value="{{$mfos->id}}">
                    <a href="{{url('ipcr/delete-ipcr-mfo/'. $mfos->id)}}" class="btn  btn-danger pull-left">
                        <span class="glyphicon glyphicon-export" aria-hidden="true"></span>Delete
                    </a>

                    <button type="button" class="btn btn-default" data-dismiss="modal">{{language_data('Close')}}</button>
                    <button type="submit" class="btn btn-primary">{{language_data('Update')}}</button>
                </div>

            </form>
        </div>
    </div>

</div>

