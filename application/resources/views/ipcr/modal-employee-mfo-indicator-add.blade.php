<div class="modal fade modal-employee-mfo-indicator-add{{$mfos->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">

    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Add Indicator</h4>
            </div>
            <form class="form-some-up form-block" role="form" action="{{url('ipcr/post-ipcr-mfo-indicator')}}" method="post">

                <div class="modal-body">


                            <div class="form-group">
                                <label>Indicator</label>
                                <input type="text" class="form-control" required="" name="indicator">
                            </div>
        
                            <div class="form-group">
                                <label>Weight</label>
                                <input type="number" class="form-control" required="" name="weight">
                            </div>

                            <div class="form-group">
                                <label>Approval Group</label>
                                <select class="form-control selectpicker" data-live-search="true" name="group_approval_id">
                                    @foreach($group_members as $gm)
                                        <option value="{{$gm->id}}">{{$gm->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Rating Group</label>
                                <select class="form-control selectpicker" data-live-search="true" name="group_rating_id">
                                    @foreach($group_members as $gm)
                                        <option value="{{$gm->id}}">{{$gm->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Accomplishment</label>
                                <input type="text" class="form-control"  name="accomplishments">
                            </div>

                </div>
                <div class="modal-footer">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <input type="hidden" name="ipcr_emp_rec_id" value="{{session('ipcr_emp_rec_id')}}">
                    <input type="hidden" name="ipcr_rating_id" value="{{$mfos->id}}">
                    <input type="hidden" name="ipcr_period_id" value="{{DB::table('ipcr_employees')->where('id',session('ipcr_emp_rec_id'))->value('ipcr_period_id')}}">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{language_data('Close')}}</button>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>

            </form>
        </div>
    </div>

</div>