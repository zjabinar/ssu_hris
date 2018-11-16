<div class="modal fade modal-ipcr-period-detail{{$ip->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">

    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Edit IPCR Rating Period</h4>
            </div>
            <form class="form-some-up form-block" role="form" action="{{url('ipcr/update-ipcr-period')}}" method="post">

                <div class="modal-body">

                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" required="" name="name" value="{{$ip->name}}">
                    </div>

                    <div class="form-group">
                        <label>Rating Period</label>
                        <input type="text" class="form-control" required="" name="rating_period" value="{{$ip->rating_period}}">
                    </div>

                    <div class="form-group">
                        <label>Description</label>
                        <input type="text" class="form-control" required="" name="description" value="{{$ip->description}}">
                    </div>

                    <div class="form-group">
                        <label>Year</label>
                        <input type="text" class="form-control" required="" name="year" value="{{$ip->year}}">
                    </div>

                     <div class="form-group">
                        <label>Period From</label>
                        <input type="text" class="form-control" required="" name="period_from" value="{{$ip->period_from}}">
                    </div>

                     <div class="form-group">
                        <label>Period To</label>
                        <input type="text" class="form-control" required="" name="period_to" value="{{$ip->period_to}}">
                    </div>

                     <div class="form-group">
                        <label>Department</label>
                        <input type="text" class="form-control" required="" name="dep_id" value="{{$ip->dep_id}}">
                    </div>

                    <div class="form-group">
                        <label>Status - Approval</label>
                        <select class="form-control selectpicker" data-live-search="true" name="status_approval">
                            <option value="open" @if($ip->status_approval=='open') selected @endif>Open</option>
                            <option value="closed"  @if($ip->status_approval=='closed') selected @endif>Closed</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Status - Rating</label>
                        <select class="form-control selectpicker" data-live-search="true" name="status_rating">
                            <option value="open" @if($ip->status_rating=='open') selected @endif>Open</option>
                            <option value="closed"  @if($ip->status_rating=='closed') selected @endif>Closed</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Remarks</label>
                        <input type="text" class="form-control" required="" name="remarks" value="{{$ip->remarks}}">
                    </div>
                    

                </div>
                <div class="modal-footer">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <input type="hidden" name="cmd" value="{{$ip->id}}">
                    <a href="{{url('ipcr/delete-ipcr-period/'. $ip->id)}}" class="btn  btn-danger pull-left">
                        <span class="glyphicon glyphicon-export" aria-hidden="true"></span>Delete
                    </a>

                    <button type="button" class="btn btn-default" data-dismiss="modal">{{language_data('Close')}}</button>
                    <button type="submit" class="btn btn-primary">{{language_data('Update')}}</button>
                </div>

            </form>
        </div>
    </div>

</div>

