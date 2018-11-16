<div class="modal fade modal-groups-add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">

    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Add Group/Members</h4>
            </div>
            <form class="form-some-up form-block" role="form" action="{{url('ipcr/post-ipcr-groups')}}" method="post">

                <div class="modal-body">

                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" required="" name="name">
                    </div>


                    <div class="form-group">
                        <label>Description</label>
                        <input type="text" class="form-control" name="description">
                    </div>

                    <div class="form-group">
                        <label>{{language_data('Employee')}}</label>
                        <select class="form-control selectpicker" multiple data-live-search="true" name="employee[]">
                            @foreach($employees as $e)
                                <option value="{{$e->id}}">{{$e->fullname}}</option>
                            @endforeach
                        </select>
                    </div>
                    

                </div>
                <div class="modal-footer">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{language_data('Close')}}</button>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>

            </form>
        </div>
    </div>

</div>