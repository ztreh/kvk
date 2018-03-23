<div  style="padding: 30px">
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal" style="float: right;">Add Slip Features</button>
</div>
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Slip Features</h4>
      </div>
      <div class="modal-body">
        <form  method="post" class="form-horizontal" action="{{url($url_slip_features)}}">
        {{ csrf_field() }}
            <div class="form-group">
                <label class="col-sm-3 control-label">Employee Name</label>
                <div class="col-sm-5">
                    <select class="form-control1 js-example-basic-single" name="employee_name"  id="employee_name" required >
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-3 control-label">Feature Type</label>
                <div class="col-xs-5">
                    <select name="feature_type" id="feature_type" class="form-control1" required>
                      <option value="">Select Feature Type</option>
                      <option value="1">Allowance</option>
                      <option value="2">Deduction</option>
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
                <div class="col-xs-5 col-xs-offset-3">
                    <input type="hidden" name="salary_month_id" id="salary_month_id" value="@if(!empty($salary_month)) {{$salary_month_id}}  @endif" />
                    <input type="hidden" name="salary_month" id="salary_month" value="@if(!empty($salary_month)) {{$salary_month}}  @endif" />
                    <input type="hidden" name="page_type" id="page_type" value="@if(!empty($salary_month)) {{$page_type}}  @endif" />
                    <button type="submit" class="btn btn-primary">Add Slip Feature</button>
                   <!--  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button> -->
                </div>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>