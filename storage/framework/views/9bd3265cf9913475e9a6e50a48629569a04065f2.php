

<?php echo e(Form::open(['url' => 'leave', 'method' => 'post'])); ?>

<div class="modal-body" id="create_leave">


    <?php if(\Auth::user()->type != 'employee'): ?>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <?php echo e(Form::label('employee_id', __('Employee'), ['class' => 'col-form-label'])); ?>

                    <?php echo e(Form::select('employee_id', $employees, null, ['class' => 'form-control select2', 'id' => 'employee_id', 'placeholder' => __('Select Employee')])); ?>

                </div>
            </div>
        </div>
    <?php endif; ?>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <?php echo e(Form::label('leave_type_id', __('Leave Type*'), ['class' => 'col-form-label'])); ?>

                <select name="leave_type_id" id="leave_type_id" class="form-control select2">
                    <option selected> Pilih</option>
                    <?php $__currentLoopData = $leavetypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $leave): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($leave->id); ?>,<?php echo e($leave->days); ?>"><?php echo e($leave->title); ?> (<p
                                class="float-right pr-5">
                                <?php echo e($leave->days); ?></p>)</option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>



            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <?php echo e(Form::label('start_date', __('Start Date'), ['class' => 'col-form-label'])); ?>

                <?php echo e(Form::text('start_date', null, ['class' => 'form-control d_week', 'autocomplete' => 'off'])); ?>

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <?php echo e(Form::label('end_date', __('End Date'), ['class' => 'col-form-label'])); ?>

                <?php echo e(Form::text('end_date', null, ['class' => 'form-control d_week', 'autocomplete' => 'off'])); ?>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <?php echo e(Form::label('leave_reason', __('Leave Reason'), ['class' => 'col-form-label'])); ?>

                <?php echo e(Form::textarea('leave_reason', null, ['class' => 'form-control', 'placeholder' => __('Leave Reason'), 'rows' => '3'])); ?>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <?php echo e(Form::label('remark', __('Remark'), ['class' => 'col-form-label'])); ?>

                <?php echo e(Form::textarea('remark', null, ['class' => 'form-control', 'placeholder' => __('Leave Remark'), 'rows' => '3'])); ?>

            </div>
        </div>
    </div>
    <?php if(\Auth::user()->type != 'employee'): ?>
        <div class="row">
            <div class="d-flex flex-row-reverse">
                <button type="button" id="click" class="btn btn-sm btn-primary add-employee">
                    <i class="ti ti-plus"></i> Add
                </button>
            </div>
            <div class="form-group">
                <?php echo e(Form::label('department_id', __('Select Department*'), ['class' => 'form-label'])); ?>

                <div class="form-icon-user">
                    <?php echo e(Form::select('department_id', $departments, null, ['class' => 'form-control select2 department_id', 'id' => 'department_id', 'placeholder' => 'Select Department', 'required'])); ?>

                </div>
            </div>

            <div class="form-group">
                <?php echo e(Form::label('designation_id', __('Select Designation'), ['class' => 'form-label'])); ?>


                <div class="form-icon-user">
                    <div class="designation_div">
                        <select class="form-control designation_id" name="designation_id" id="choices-multiple" required
                            placeholder="Select Designation">
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="form-group employees row d-flex align-items-center">
                    <?php echo e(Form::label('', __('Approved By'), ['class' => 'form-label'])); ?>

                    <div>
                        <select class="form-control employee_id data_employee_id" name="approved_employee_id[]"
                            placeholder="Select Employee" required>
                            <option selected disabled>Select Employee</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
<div class="modal-footer">
    <button type="button" class="btn  btn-light" data-bs-dismiss="modal"><?php echo e(__('Close')); ?></button>
    <input type="submit" value="<?php echo e(__('Create')); ?>" class="btn  btn-primary">
</div>
<?php echo e(Form::close()); ?>


<script>
    let number = 1;

    $(document).ready(function() {
        document.getElementById('click').style.display = 'none'

        $(document).on('click', '#removeRow', function() {
            $(this).closest('#inputRow').remove();
        });

        $('#click').click(function(e) {

            e.preventDefault();

            var html = `
                    <div class="mt-4" id="inputRow">
                        <div class="row">
                            <div class="d-flex flex-row-reverse">
                                <button type="button" id="removeRow" class="btn btn-sm btn-danger" >
                                    <i class="ti ti-trash"></i> Delete
                                </button>
                            </div>
                            <div class="form-group">
                                <?php echo e(Form::label('department_id', __('Select Department*'), ['class' => 'form-label'])); ?>

                                <div class="form-icon-user">
                                    <?php echo e(Form::select('department_id', $departments, null, ['class' => 'form-control select2 department_id-${number}', 'id' => 'department_id-${number}', 'placeholder' => 'Select Department', 'required'])); ?>

                                </div>
                            </div>

                            <div class="form-group">
                                <?php echo e(Form::label('designation_id', __('Select Designation'), ['class' => 'form-label'])); ?>


                                <div class="form-icon-user">
                                    <div class="designation_div-${number}">
                                        <select class="form-control  designation_id-${number}" name="designation_id" id="choices-multiple-${number}"
                                            placeholder="Select Designation">
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                           <div>
                            <select class="form-control employee_id add_data_employee_id-${number}" name="approved_employee_id[]" ""id=
                                placeholder="Select Employee" required>
                                <option selected disabled>Select Employee</option>
                            </select>
                            </div>
                        </div>
                    </div>
                    `;

            $('.employees').append(html);

        });
    });

    $(document).on('change', '.data_employee_id', function() {
        var department = $('.department_id').val();
        var designation = $('.designation_id').val();
        var employee = $('.data_employee_id').val();
        if (department != '' && designation != null && employee != null) {
            document.getElementById('click').style.display = 'block'
        }

    });

    $(document).on('change', '.department_id', function() {
        console.log('tes');
        var department_id = $(this).val();
        getDesignation(department_id, 'first');
    });

    $(".add-employee").click(function() {
        number += 1

        $(document).on('change', '.department_id-' + number, function() {
            var department_id = $(this).val();
            getDesignation(department_id, 'add');
        });

        $(document).on('change', '.designation_id-' + number, function() {
            var department_id = $('.department_id-' + number).val();
            var designation_id = $('.designation_id-' + number).val();
            getEmployee(department_id, designation_id, 'add');
        });
    });



    $(document).on('change', '.designation_id', function() {
        var department_id = $('.department_id').val();
        var designation_id = $('.designation_id').val();
        getEmployee(department_id, designation_id, 'first');
    });




    function getDesignation(did, type) {

        $.ajax({
            url: '<?php echo e(route('employee.json')); ?>',
            type: 'POST',
            data: {
                "department_id": did,
                "_token": "<?php echo e(csrf_token()); ?>",
            },
            success: function(data) {
                if (type == 'add') {
                    $('.designation_id-' + number).empty();
                    var emp_selct = ` <select class="form-control  designation_id-${number}" name="designation_id" id="choices-multiple-${number}"
                                        placeholder="Select Designation" >
                                        </select>`;
                    $('.designation_div-' + number).html(emp_selct);

                    $('.designation_id-' + number).append(
                        '<option value="0"> <?php echo e(__('All')); ?> </option>');
                    $.each(data, function(key, value) {
                        $('.designation_id-' + number).append('<option value="' + key + '">' +
                            value +
                            '</option>');
                    });
                    new Choices('#choices-multiple-' + number, {
                        removeItemButton: true,
                    });
                } else {
                    $('.designation_id').empty();
                    var emp_selct = ` <select class="form-control  designation_id" name="designation_id" id="choices-multiple"
                                        placeholder="Select Designation" >
                                        </select>`;
                    $('.designation_div').html(emp_selct);

                    $('.designation_id').append('<option value="0"> <?php echo e(__('All')); ?> </option>');
                    $.each(data, function(key, value) {
                        $('.designation_id').append('<option value="' + key + '">' + value +
                            '</option>');
                    });
                    new Choices('#choices-multiple', {
                        removeItemButton: true,
                    });
                }
            }
        });
    }

    var base_url = window.location.origin;

    function getEmployee(department, designation, type) {
        console.log(department + ' - ' + designation + ' - ' + type);
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
<?php /**PATH D:\joki\codecanyon-iMuwzIOg-hrmgo-saas-hrm-and-payroll-tool\hr\newhrsystem\resources\views/leave/create.blade.php ENDPATH**/ ?>