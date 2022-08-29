

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
            <div class="col-md-12">
                <div class="form-group employees row d-flex align-items-center">
                    <?php echo e(Form::label('employee_id', __('Approved By   '), ['class' => 'col-form-label'])); ?>

                    <div class="row d-flex align-items-center">
                        <div class="col-11">
                            <?php echo e(Form::select('approved_employee_id[]', $employees, null, ['class' => 'form-control js-example-basic-single', 'id' => 'approved_employee_id', 'placeholder' => __('Select Employee')])); ?>

                        </div>
                        <div class="col-1">
                            <button type="button" id="click" class="btn btn-sm btn-primary">
                                <i class="ti ti-plus"></i>
                            </button>
                        </div>
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
                        <?php echo e(Form::select('approved_employee_id[]', $employees, null, ['class' => 'form-control js-example-basic-single', 'id' => 'approved_employee_id', 'placeholder' => __('Select Employee')])); ?>

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
<?php /**PATH /var/www/html/Project/External/newhrsystem/resources/views/leave/create.blade.php ENDPATH**/ ?>