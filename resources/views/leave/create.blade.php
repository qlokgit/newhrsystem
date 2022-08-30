{{-- {{ Form::open(['url' => 'leave', 'method' => 'post']) }}
<div class="modal-body">
    <div class="row">
        @if (\Auth::user()->type != 'employee')
            <div class="form-group">
                {{ Form::label('employee_id', __('Employee'), ['class' => 'col-form-label']) }}
                {{ Form::select('employee_id', $employees, null, ['class' => 'form-control  ','id' => 'employee_id','placeholder' => __('Select Employee')]) }}
            </div>
        @endif
        <div class="form-group">
            {{ Form::label('leave_type_id', __('Leave Type'), ['class' => 'col-form-label']) }}
            <select name="leave_type_id" id="leave_type_id" class="form-control  ">
                @foreach ($leavetypes as $leave)
                    <option value="{{ $leave->id }}">{{ $leave->title }} (<p class="float-right pr-5">
                            {{ $leave->days }}</p>)</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('start_date', __('Start Date'), ['class' => 'col-form-label']) }}
                {{ Form::text('start_date', null, ['class' => 'form-control', 'id' => 'data_picker1']) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('end_date', __('End Date'), ['class' => 'col-form-label']) }}
                {{ Form::text('end_date', null, ['class' => 'form-control', 'id' => 'data_picker2']) }}
            </div>
        </div>
        <div class="form-group">
            {{ Form::label('leave_reason', __('Leave Reason'), ['class' => 'col-form-label']) }}
            {{ Form::textarea('leave_reason', null, ['class' => 'form-control', 'placeholder' => __('Leave Reason')]) }}
        </div>
        <div class="form-group">
            {{ Form::label('remark', __('Remark'), ['class' => 'col-form-label']) }}
            {{ Form::textarea('remark', null, ['class' => 'form-control', 'placeholder' => __('Leave Remark')]) }}
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn  btn-light" data-bs-dismiss="modal">{{ __('Close') }}</button>
    <input type="submit" value="{{ __('Create') }}" class="btn  btn-primary">
</div>
{{ Form::close() }} --}}

{{ Form::open(['url' => 'leave', 'method' => 'post']) }}
<div class="modal-body" id="create_leave">


    @if (\Auth::user()->type != 'employee')
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    {{ Form::label('employee_id', __('Employee'), ['class' => 'col-form-label']) }}
                    {{ Form::select('employee_id', $employees, null, ['class' => 'form-control select2', 'id' => 'employee_id', 'placeholder' => __('Select Employee')]) }}
                </div>


            </div>
        </div>
    @endif
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {{ Form::label('leave_type_id', __('Leave Type*'), ['class' => 'col-form-label']) }}
                <select name="leave_type_id" id="leave_type_id" class="form-control select2">
                    <option selected> Pilih</option>
                    @foreach ($leavetypes as $leave)
                        <option value="{{ $leave->id }},{{ $leave->days }}">{{ $leave->title }} (<p
                                class="float-right pr-5">
                                {{ $leave->days }}</p>)</option>
                    @endforeach
                </select>



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
    @if (\Auth::user()->type != 'employee')
        <div class="row">
            <div class="col-md-12">
                <div class="form-group employees row d-flex align-items-center">
                    {{ Form::label('employee_id', __('Approved By   '), ['class' => 'col-form-label']) }}
                    <div class="col-11">
                        {{ Form::select('approved_employee_id[]', $employees, null, ['class' => 'form-control js-example-basic-single', 'id' => 'approved_employee_id', 'placeholder' => __('Select Employee')]) }}
                    </div>
                    <div class="col-1">
                        <button type="button" id="click" class="btn btn-sm btn-primary">
                            <i class="ti ti-plus"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
<div class="modal-footer">
    <button type="button" class="btn  btn-light" data-bs-dismiss="modal">{{ __('Close') }}</button>
    <input type="submit" value="{{ __('Create') }}" class="btn  btn-primary">
</div>
{{ Form::close() }}

<script>
    $(document).ready(function() {
        let number = 1;

        $(document).on('click', '#removeRow', function() {
            $(this).closest('#inputRow').remove();
        });

        $('#click').click(function(e) {

            e.preventDefault();
            // number += 1;
            number += 1;

            var html = `
                    <div class="row mt-4" id="inputRow">
                    <div class="col-11">
                        {{ Form::select('approved_employee_id[]', $employees, null, ['class' => 'form-control js-example-basic-single', 'id' => 'approved_employee_id', 'placeholder' => __('Select Employee')]) }}
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
</script>
