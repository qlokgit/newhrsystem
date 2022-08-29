{{-- {{ Form::model($leave, ['route' => ['leave.update', $leave->id], 'method' => 'PUT']) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group">
            {{ Form::label('employee_id', __('Employee')) }}
            {{ Form::select('employee_id', $employees, null, ['class' => 'form-control select2','placeholder' => __('Select Employee')]) }}
        </div>


        <div class="form-group">
            {{ Form::label('leave_type_id', __('Leave Type')) }}
            {{ Form::select('leave_type_id', $leavetypes, null, ['class' => 'form-control select2','placeholder' => __('Select Leave Type')]) }}
        </div>


        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('start_date', __('Start Date')) }}
                {{ Form::text('start_date', null, ['class' => 'form-control ', 'id' => 'data_picker1']) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('end_date', __('End Date')) }}
                {{ Form::text('end_date', null, ['class' => 'form-control ', 'id' => 'data_picker2']) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('leave_reason', __('Leave Reason')) }}
            {{ Form::textarea('leave_reason', null, ['class' => 'form-control', 'placeholder' => __('Leave Reason')]) }}
        </div>

        <div class="form-group">
            {{ Form::label('remark', __('Remark')) }}
            {{ Form::textarea('remark', null, ['class' => 'form-control', 'placeholder' => __('Leave Remark')]) }}
        </div>

        @role('Company')
            <div class="form-group">
                {{ Form::label('status', __('Status')) }}
                <select name="status" id="" class="form-control select2">
                    <option value="">{{ __('Select Status') }}</option>
                    <option value="pending" @if ($leave->status == 'Pending') selected="" @endif>{{ __('Pending') }}
                    </option>
                    <option value="approval" @if ($leave->status == 'Approval') selected="" @endif>{{ __('Approval') }}
                    </option>
                    <option value="reject" @if ($leave->status == 'Reject') selected="" @endif>{{ __('Reject') }}
                    </option>
                </select>
            </div>
        @endrole
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn  btn-light" data-bs-dismiss="modal">{{ __('Close') }}</button>
    <input type="submit" value="{{ __('Update') }}" class="btn  btn-primary">

</div>

{{ Form::close() }} --}}


{{ Form::model($leave, ['route' => ['leave.update', $leave->id], 'method' => 'PUT']) }}
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {{ Form::label('employee_id', __('Employee'), ['class' => 'col-form-label']) }}
                {{ Form::select('employee_id', $employees, null, ['class' => 'form-control select2', 'placeholder' => __('Select Employee')]) }}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {{ Form::label('leave_type_id', __('Leave Type*'), ['class' => 'col-form-label']) }}
                {{ Form::select('leave_type_id', $leavetypes, null, ['class' => 'form-control select2', 'placeholder' => __('Select Leave Type')]) }}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('start_date', __('Start Date'), ['class' => 'col-form-label']) }}
                {{ Form::text('start_date', null, ['class' => 'form-control d_week', 'autocomplete' => 'off']) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('end_date', __('End Date'), ['class' => 'col-form-label']) }}
                {{ Form::text('end_date', null, ['class' => 'form-control d_week', 'autocomplete' => 'off']) }}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {{ Form::label('leave_reason', __('Leave Reason'), ['class' => 'col-form-label']) }}
                {{ Form::textarea('leave_reason', null, ['class' => 'form-control', 'placeholder' => __('Leave Reason'), 'rows' => '3']) }}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {{ Form::label('remark', __('Remark'), ['class' => 'col-form-label']) }}
                {{ Form::textarea('remark', null, ['class' => 'form-control', 'placeholder' => __('Leave Remark'), 'rows' => '3']) }}
            </div>
        </div>
    </div>
    @role('Company')
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    {{ Form::label('status', __('Status'), ['class' => 'col-form-label']) }}
                    <select name="status" id="" class="form-control select2">
                        <option value="">{{ __('Select Status') }}</option>
                        <option value="pending" @if ($leave->status == 'Pending') selected="" @endif>{{ __('Pending') }}
                        </option>
                        <option value="approval" @if ($leave->status == 'Approval') selected="" @endif>{{ __('Approval') }}
                        </option>
                        <option value="reject" @if ($leave->status == 'Reject') selected="" @endif>{{ __('Reject') }}
                        </option>
                    </select>
                </div>
            </div>
        </div>
    @endrole
    {{-- @if (\Auth::user()->type != 'employee')
        <div class="row">
            <div class="col-md-12">
                <div class="form-group employees row ">
                    {{ Form::label('employee_id', __('Approved By   '), ['class' => 'col-form-label']) }}
                    @foreach ($approvedLeave as $item)
                    {!! Form::hidden('old_approved_employee_id[]', $item->employee_id) !!}
                        <div class="row d-flex align-items-center mb-4">
                            <div class="col-11">
                                {{ Form::select('approved_employee_id[]', $employees, $item->employee_id, ['class' => 'form-control js-example-basic-single', 'id' => 'approved_employee_id', 'placeholder' => __('Select Employee'), 'required' => 'required']) }}
                            </div>
                            <div class="col-1">
                                <button type="button" class="btn btn-sm btn-primary click">
                                    <i class="ti ti-plus"></i>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif --}}
</div>
<div class="modal-footer">
    <button type="button" class="btn  btn-light" data-bs-dismiss="modal">{{ __('Close') }}</button>
    <input type="submit" value="{{ __('Update') }}" class="btn  btn-primary">

</div>
{{ Form::close() }}

{{-- <script>
    $(document).ready(function() {
        let number = 1;

        $(document).on('click', '#removeRow', function() {
            $(this).closest('#inputRow').remove();
        });

        $('.click').click(function(e) {

            e.preventDefault();
            // number += 1;
            number += 1;

            var html = `
                    <div class="row mt-4" id="inputRow">
                    <div class="col-11">
                        {{ Form::select('approved_employee_id[]', $employees, null, ['class' => 'form-control js-example-basic-single', 'id' => 'approved_employee_id', 'placeholder' => __('Select Employee'), 'required' => 'required']) }}
                    </div>
                    <div class="col-1">
                        <button type="button" id="removeRow" class="btn btn-sm btn-danger" >
                            <i class="ti ti-trash"></i>
                        </button>
                    </div>
                    </div>
                    `;

            $('.employees').append(html);

        });
    });
</script> --}}
