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

    <div class="row">
        <div class="form-group">
            {{ Form::label('department_id', __('Select Department*'), ['class' => 'form-label']) }}
            <div class="form-icon-user">
                {{ Form::select('department_id', $departments, null, ['class' => 'form-control select2', 'id' => 'department_id', 'required' => 'required', 'placeholder' => 'Select Department']) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('designation_id', __('Select Designation'), ['class' => 'form-label']) }}

            <div class="form-icon-user">
                <div class="designation_div">
                    <select class="form-control  designation_id" name="designation_id" id="choices-multiple"
                        placeholder="Select Designation">
                    </select>
                </div>
            </div>
        </div>
    </div>

    @if (\Auth::user()->type != 'employee')
        <div class="row">
            <div class="col-md-12">
                <div class="form-group employees row d-flex align-items-center">
                    {{ Form::label('employee_id', __('Approved By'), ['class' => 'form-label']) }}

                    <div class="row  d-flex align-items-center">
                        <div class="col-11">
                            <select class="form-control employee_id data_employee_id" name="approved_employee_id[]"
                               placeholder="Select Employee" required>
                                <option selected disabled>Select Employee</option>
                            </select>
                        </div>
                        <div class="col-1">
                            <button type="button" id="click" class="btn btn-sm btn-primary add-employee">
                                <i class="ti ti-plus"></i>
                            </button>
                        </div>
                    </div>
                    {{-- {{ Form::label('employee_id', __('Approved By   '), ['class' => 'col-form-label']) }}
                    <div class="row d-flex align-items-center">
                        <div class="col-11">
                            {{ Form::select('approved_employee_id[]', $employees, null, ['class' => 'form-control js-example-basic-single', 'id' => 'approved_employee_id', 'placeholder' => __('Select Employee'), 'required' => 'required']) }}
                        </div>
                        <div class="col-1">
                            <button type="button" id="click" class="btn btn-sm btn-primary">
                                <i class="ti ti-plus"></i>
                            </button>
                        </div>
                    </div> --}}
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
    let number = 1;

    $(document).ready(function() {

        var selectDesignation = $('.designation_id').val();
        console.log(selectDesignation);
        if (selectDesignation == null) {
            document.getElementById('click').style.display = 'none'
        }

        $(document).on('click', '#removeRow', function() {
            $(this).closest('#inputRow').remove();
        });

        $('#click').click(function(e) {

            e.preventDefault();
            // number += 1;
            number += 1;

            var html = `
                    <div class="row mt-4 d-flex align-items-center" id="inputRow">
                        <div class="col-11">
                            <select class="form-control employee_id add_data_employee_id-${number}" name="approved_employee_id[]" ""id=
                                placeholder="Select Employee" required>
                                <option selected disabled>Select Employee</option>
                            </select>
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

    $(document).ready(function() {
        var d_id = $('.department_id').val();
        getDesignation(d_id);
    });

    $(document).on('change', 'select[name=department_id]', function() {
        var department_id = $(this).val();
        getDesignation(department_id);
    });

    $(document).on('change', 'select[name=designation_id]', function() {
        var department_id = $(this).val();
        var designation_id = $('.designation_id').val();
        document.getElementById('click').style.display = 'block'
        getEmployee(department_id, designation_id, 'first');
    });

    // $(document).on('click', '.add-employee', function() {

    // });

    $(".add-employee").click(function() {
        var department_id = $('#department_id').val();
        var designation_id = $('.designation_id').val();

        getEmployee(department_id, designation_id, 'add');
    });

    function getDesignation(did) {

        $.ajax({
            url: '{{ route('employee.json') }}',
            type: 'POST',
            data: {
                "department_id": did,
                "_token": "{{ csrf_token() }}",
            },
            success: function(data) {

                $('.designation_id').empty();
                var emp_selct = ` <select class="form-control  designation_id" name="designation_id" id="choices-multiple"
                                        placeholder="Select Designation" >
                                        </select>`;
                $('.designation_div').html(emp_selct);

                $('.designation_id').append('<option value="0"> {{ __('All') }} </option>');
                $.each(data, function(key, value) {
                    $('.designation_id').append('<option value="' + key + '">' + value +
                        '</option>');
                });
                new Choices('#choices-multiple', {
                    removeItemButton: true,
                });
            }
        });
    }

    var base_url = window.location.origin;

    function getEmployee(department, designation, type) {
        $.ajax({
            'url': base_url + '/get-employee/' + department + '/' + designation,
            'type': 'GET',
            success: function(data) {
                var html = '';
                var i;
                html += '<option selected disabled>Select Employee</option>';
                for (i = 0; i < data.length; i++) {
                    html += '<option value=' + data[i].id + '>' + data[i]
                        .name + '</option>';
                }

                if (type == 'add') {
                    $('.add_data_employee_id-' + number).html(html);
                } else {
                    $('.data_employee_id').html(html);
                }
            }
        })
    }
</script>
