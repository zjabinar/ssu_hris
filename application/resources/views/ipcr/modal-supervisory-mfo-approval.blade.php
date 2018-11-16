<div class="modal fade modal-groups-add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">

    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Add MFO</h4>
            </div>
            <form class="form-some-up form-block" role="form" action="{{url('ipcr/post-ipcr-mfo')}}" method="post">

                <div class="modal-body">

                        <div class="form-group">
                        <label>MFO Group</label>
                        <select class="form-control selectpicker" data-live-search="true" name="mfo_group_id">
                            @foreach($mfo_groups as $mg)
                                <option value="{{$mg->id}}">{{$mg->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" required="" name="mfo_name">
                    </div>

                    {{-- <div class="form-group">
                        <label>Default Weight</label>
                        <input type="number" class="form-control" required="" name="default_weight">
                    </div> --}}

                </div>
                <div class="modal-footer">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <input type="hidden" name="ipcr_emp_rec_id" value="{{session('ipcr_emp_rec_id')}}">
                    <input type="hidden" name="ipcr_period_id" value="{{DB::table('ipcr_employees')->where('id',session('ipcr_emp_rec_id'))->value('ipcr_period_id')}}">
                    <input type="hidden" name="mfo_group_sort" value="{{DB::table('ipcr_mfo_groups')->where('id', session('ipcr_emp_rec_id'))->value('sort')}}">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{language_data('Close')}}</button>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>

            </form>
        </div>
    </div>

</div>