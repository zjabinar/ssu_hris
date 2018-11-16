<div class="modal fade modal-ipcr-period-add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">

    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Add IPCR Rating Period</h4>
            </div>
            <form class="form-some-up form-block" role="form" action="{{url('ipcr/post-ipcr-period')}}" method="post">

                <div class="modal-body">

                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" required="" name="name">
                    </div>

                    <div class="form-group">
                        <label>Rating Period</label>
                        <input type="text" class="form-control" required="" name="rating_period" >
                    </div>

                    <div class="form-group">
                        <label>Description</label>
                        <input type="text" class="form-control" name="description">
                    </div>

                    <div class="form-group">
                        <label>Year</label>
                        <input type="text" class="form-control"  required="" name="year" >
                    </div>

                     <div class="form-group">
                        <label>Period From</label>
                        <input type="text" class="form-control" required="" name="period_from" >
                    </div>

                     <div class="form-group">
                        <label>Period To</label>
                        <input type="text" class="form-control" required="" name="period_to" >
                    </div>

                     <div class="form-group">
                        <label>Department</label>
                        <input type="text" class="form-control" required="" name="dep_id" >
                    </div>


                    <div class="form-group">
                        <label>Status - Approval</label>
                        <select class="form-control selectpicker"  name="status_approval">
                            <option value="open">Open</option>
                            <option value="closed">Closed</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Status - Rating</label>
                        <select class="form-control selectpicker"  name="status_rating">
                            <option value="open">Open</option>
                            <option value="closed">Closed</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Remarks</label>
                        <input type="text" class="form-control" name="remarks" >
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