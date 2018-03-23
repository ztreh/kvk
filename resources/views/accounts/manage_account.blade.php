<div  style="padding: 30px">
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal" style="float: right;">Add Credit/Debit</button>
</div>
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Credit/Debit Details</h4>
      </div>
      <div class="modal-body">
        <form  method="post" class="form-horizontal" action="{{url($url)}}">
        {{ csrf_field() }}
            
            <div class="form-group">
                <label class="col-xs-3 control-label">Type</label>
                <div class="col-xs-5">
                    <select name="type" id="type" class="form-control1" required>
                      <option value="">Select Type</option>
                      <option value="1">Credit</option>
                      <option value="2">Debit</option>
                    </select> 
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-3 control-label">Description</label>
                <div class="col-xs-5">
                    <input type="text" class="col-sm-4 form-control1 " name="description"  id="description" placeholder="Description" value="" required  />
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-3 control-label">Amount</label>
                <div class="col-xs-5">
                    <input type="text" class="col-sm-4 form-control1 " name="amount"  id="amount" placeholder="Amount" value="" required  />
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-3 control-label">Date</label>
                <div class="col-xs-5">
                    <input type="text" class="col-sm-4 form-control1 " name="date"  id="date" placeholder="Date" value="" required  />
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-5 col-xs-offset-3">
                    <button type="submit" class="btn btn-primary">Add Credit/Debit</button>
                </div>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>