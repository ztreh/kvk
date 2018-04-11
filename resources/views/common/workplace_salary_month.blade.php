<div class="form-group">
  <label for="focusedinput" class="col-sm-2 control-label">Workplace Salary Session <span class="error_required"><strong>*</strong></span></label>
  <div class="col-sm-8">
    <select class="form-control1 js-example-basic-single" name="salary_session_work_places_id"  id="salary_session_work_places_id">
      @if(!empty($workplace_salary_session))
          <option value="{{$workplace_salary_session->work_places_id}}" selected="selected">{{$workplace_salary_session->work_places->name }}</option>
      @endif
    </select>
    
    @if ($errors->has('salary_session_work_places_id'))
            <span class="help-block error_required">
                <strong>Enter Workplace  Salary Session </strong>
            </span>
        @endif
  </div>
</div>
<script type="text/javascript">
  @include('scripts.workplace_salary_session')
</script>
