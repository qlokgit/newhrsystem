


<?php echo e(Form::model($leave, ['route' => ['leave.update', $leave->id], 'method' => 'PUT'])); ?>

<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <?php echo e(Form::label('employee_id', __('Employee'), ['class' => 'col-form-label'])); ?>

                <?php echo e(Form::select('employee_id', $employees, null, ['class' => 'form-control select2', 'placeholder' => __('Select Employee')])); ?>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <?php echo e(Form::label('leave_type_id', __('Leave Type*'), ['class' => 'col-form-label'])); ?>

                <?php echo e(Form::select('leave_type_id', $leavetypes, null, ['class' => 'form-control select2', 'placeholder' => __('Select Leave Type')])); ?>

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
    <?php if(auth()->check() && auth()->user()->hasRole('Company')): ?>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <?php echo e(Form::label('status', __('Status'), ['class' => 'col-form-label'])); ?>

                    <select name="status" id="" class="form-control select2">
                        <option value=""><?php echo e(__('Select Status')); ?></option>
                        <option value="pending" <?php if($leave->status == 'Pending'): ?> selected="" <?php endif; ?>><?php echo e(__('Pending')); ?>

                        </option>
                        <option value="approval" <?php if($leave->status == 'Approval'): ?> selected="" <?php endif; ?>><?php echo e(__('Approval')); ?>

                        </option>
                        <option value="reject" <?php if($leave->status == 'Reject'): ?> selected="" <?php endif; ?>><?php echo e(__('Reject')); ?>

                        </option>
                    </select>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php if(\Auth::user()->type != 'employee'): ?>
        <?php
            $department = !empty($approvedLeave[0]->employee->department_id) ? $approvedLeave[0]->employee->department_id : null;
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group employees row ">
                    <?php echo e(Form::label('employee_id', __('Approved By   '), ['class' => 'col-form-label'])); ?>

                    <div class="d-flex flex-row-reverse mb-2">
                        <button type="button" class="btn btn-sm btn-primary add-employee " id="click">
                            <i class="ti ti-plus"></i> Add
                        </button>
                    </div>
                    <?php $__currentLoopData = $approvedLeave; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        
                        <div class="d-flex flex-row-reverse">
                            <a href="<?php echo e(route('delete.approve.leave', $item->id)); ?>" class="btn btn-sm btn-danger delete">
                                <i class="ti ti-trash"></i> Delete
                            </a>
                        </div>
                        <?php echo Form::hidden('old_approved_employee_id[]', $item->employee_id); ?>

                        <div class="">
                            <div class="form-group">
                                <?php echo e(Form::label('department_id', __('Select Department*'), ['class' => 'form-label'])); ?>

                                <div class="form-icon-user">
                                    <?php echo e(Form::select('department_id', $departments, $department, ['class' => 'form-control select2', 'disabled' => 'disabled', 'id' => 'department_id', 'required' => 'required', 'placeholder' => 'Select Department'])); ?>

                                </div>
                            </div>
                            <input type="hidden" name="department_ids" class="department_id-<?php echo e($key + 1); ?>"
                                value="<?php echo e($item->employee->department_id); ?>">
                            <div class="form-group">
                                <?php echo e(Form::label('designation_id', __('Select Designation'), ['class' => 'form-label'])); ?>


                                <div class="form-icon-user">
                                    <div class="designation_div-<?php echo e($key + 1); ?>">
                                        <select class="form-control  designation_id-<?php echo e($key + 1); ?>"
                                            name="designation_id" placeholder="Select Designation" disabled>
                                            <option value=""><?php echo e($item->employee->designation->name); ?></option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                            <div>
                                <?php echo e(Form::select('approved_employee_id[]', $employees, $item->employee_id, ['class' => 'form-control js-example-basic-single', 'id' => 'approved_employee_id', 'placeholder' => __('Select Employee'), 'required' => 'required', 'disabled' => 'disabled'])); ?>

                            </div>
                            <div class="col-2">
                                <div class="">
                                    
                                    
                                </div>
                            </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
<div class="modal-footer">
    <button type="button" class="btn  btn-light" data-bs-dismiss="modal"><?php echo e(__('Close')); ?></button>
    <input type="submit" value="<?php echo e(__('Update')); ?>" class="btn  btn-primary">

</div>
<?php echo e(Form::close()); ?>


<script>
    let number = 1;

    $(document).ready(function() {
        // $('.click').css('display', 'none')
        let leave = <?php echo json_encode($approvedLeave->toArray()); ?>


        for (let index = 0; index < leave.length; index++) {
            number += 1
            var department_id = $('.department_id-' + number).val();
            getDesignation(department_id, 'first');
        }

        $(document).on('click', '#removeRow', function() {
            $(this).closest('#inputRow').remove();
        });

        $('#click').click(function(e) {
            var add_employee = $('.add_data_employee_id-' + number).val();

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
                                    <?php echo e(Form::select('department_id', $departments, null, ['class' => 'form-control select2 department_id-${number}', 'id' => 'department_id-${number}', 'required' => 'required', 'placeholder' => 'Select Department'])); ?>

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
        var department_id = $(this).val();
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
    // function getDesignation(did) {

    //     $.ajax({
    //         url: '<?php echo e(route('employee.json')); ?>',
    //         type: 'POST',
    //         data: {
    //             "department_id": did,
    //             "_token": "<?php echo e(csrf_token()); ?>",
    //         },
    //         success: function(data) {

    //             $('.designation_id').empty();
    //             var emp_selct = ` <select class="form-control  designation_id" name="designation_id" id="choices-multiple"
    //                                     placeholder="Select Designation" >
    //                                     </select>`;
    //             $('.designation_div').html(emp_selct);

    //             $('.designation_id').append('<option value="0"> <?php echo e(__('All')); ?> </option>');
    //             $.each(data, function(key, value) {
    //                 $('.designation_id').append('<option value="' + key + '">' + value +
    //                     '</option>');
    //             });
    //             new Choices('#choices-multiple', {
    //                 removeItemButton: true,
    //             });
    //         }
    //     });
    // }
</script>
<?php /**PATH D:\joki\codecanyon-iMuwzIOg-hrmgo-saas-hrm-and-payroll-tool\hr\newhrsystem\resources\views/leave/edit.blade.php ENDPATH**/ ?>