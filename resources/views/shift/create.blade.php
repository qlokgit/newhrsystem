{{-- 
<div class="modal-lg">
    <form action="{{ route('shift.store') }}" method="post">
        @csrf
        <div class="p-2">
            <div class="card p-3">
                <h6>Add Shift Roster</h6>
                <div class="alert alert-info mt-5" role="alert">
                    <i class="fa fa-info-circle"></i> The existing shift will be overidden
                </div>
                <div class="modal-body p-0">
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Department</label>
                                <select class="form-control" name="department_id">
                                    <option>Nothing Selected</option>
                                    @foreach ($departments as $item)
                                        <option value={{ $item->id }}>{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-8">
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Employees</label>
                                <select class="form-control" name="employee_id">
                                    <option>Nothing Selected</option>
                                    @foreach ($employees as $item)
                                        <option value={{ $item->id }}>{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Employee Shift</label>
                                <select class="form-control" name="employee_shift_id">
                                    <option>Nothing Selected</option>
                                    @foreach ($employeeShift as $item)
                                        <option value={{ $item->id }}>{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-8">
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Assign Shift By</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="assign_shift_by" value="date"
                                        checked>
                                    <label class="form-check-label">
                                        Date
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="assign_shift_by"
                                        value="month">
                                    <label class="form-check-label">
                                        Month
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="validationDefault01">Date</label>
                            <input type="date" name="dates" class="form-control datepicker"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <input type="button" value="Cancel" class="btn btn-light" data-bs-dismiss="modal">
            <input type="submit" value="{{ __('Create') }}" class="btn btn-primary">
        </div>
    </form>
</div>
{{-- <script src="http://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script> --}}

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
               
            </div>
        </div>
    </div>