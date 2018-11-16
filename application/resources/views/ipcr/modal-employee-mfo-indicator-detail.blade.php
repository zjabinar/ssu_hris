<div class="modal fade modal-employee-mfo-indicator-detail{{$indicator->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">

    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Edit Indicator</h4>
            </div>
            <form class="form-some-up form-block" role="form" action="{{url('ipcr/update-ipcr-mfo-indicator')}}" method="post">

                <div class="modal-body">

                    @if (DB::table('ipcr_periods')->where('id', $indicator->ipcr_period_id)->value('status_approval')=="open")
                        <div class="form-group">
                                <label>Indicator</label>
                                <input type="text" class="form-control" required="" name="indicator" value="{{$indicator->indicator}}">
                            </div>
        
                            <div class="form-group">
                                <label>Weight</label>
                                <input type="number" class="form-control" required="" name="weight" value="{{$indicator->weight}}">
                            </div>

                            <div class="form-group">
                                <label>Approval Group</label>
                                <select class="form-control selectpicker" data-live-search="true" name="group_approval_id">
                                    @foreach($group_members as $gm)
                                        <option value="{{$gm->id}}" @if ($indicator->group_approval_id==$gm->id) selected @endif >{{$gm->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Rating Group</label>
                                <select class="form-control selectpicker" data-live-search="true" name="group_rating_id">
                                    @foreach($group_members as $gm)
                                        <option value="{{$gm->id}}"  @if ($indicator->group_rating_id==$gm->id) selected @endif>{{$gm->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        @else
                            <input type="hidden" class="form-control" required="" name="indicator" value="{{$indicator->indicator}}">
                            <input type="hidden" class="form-control" required="" name="indicator" value="{{$indicator->weight}}">
                            <input type="hidden" class="form-control" required="" name="indicator" value="{{$indicator->group_approval_id}}">
                            <input type="hidden" class="form-control" required="" name="indicator" value="{{$indicator->group_rating_id}}">
                        @endif

                        @if (DB::table('ipcr_periods')->where('id', $indicator->ipcr_period_id)->value('status_rating')=="open")
                            <div class="form-group">
                                <label>Accomplishment</label>
                            <input type="text" class="form-control"  name="accomplishments" value="{{$indicator->accomplishments}}" >
                            </div>
                        @else
                            <input type="hidden" class="form-control"  name="accomplishments"  value="{{$indicator->accomplishments}}" >
                        @endif
                    

                </div>
                <div class="modal-footer">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <input type="hidden" name="cmd" value="{{$indicator->id}}">

                    @if (DB::table('ipcr_periods')->where('id', $indicator->ipcr_period_id)->value('status_approval')=="open")
                        <a href="{{url('ipcr/delete-ipcr-mfo-indicator/'. $indicator->id)}}" class="btn  btn-danger pull-left">
                            <span class="glyphicon glyphicon-export" aria-hidden="true"></span>Delete
                        </a>
                    @endif

                    <button type="button" class="btn btn-default" data-dismiss="modal">{{language_data('Close')}}</button>
                    <button type="submit" class="btn btn-primary">{{language_data('Update')}}</button>
                </div>

            </form>
        </div>
    </div>

</div>

