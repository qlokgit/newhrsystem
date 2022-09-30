<?php echo e(Form::open(['url' => 'event', 'method' => 'post'])); ?>

<div class="modal-body">
    <div class="row">
    <div class="col-md-4">
            <div class="form-group">
                <?php echo e(Form::label('branch_id', __('Branch'), ['class' => 'col-form-label'])); ?>

                <select class="form-control select" name="branch_id" id="branch_id"
                    placeholder="<?php echo e(__('Select Branch')); ?>">
                    <option value=""><?php echo e(__('Select Branch')); ?></option>
                    <option value="0"><?php echo e(__('All Branch')); ?></option>
                    <?php $__currentLoopData = $branch; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($branch->id); ?>"><?php echo e($branch->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <?php echo e(Form::label('department_id', __('Department'), ['class' => 'col-form-label'])); ?>

                <div class="department_div">
                    <select class="form-control department_id" name="department_id[]"
                         placeholder="Select Designation" >
                    <option value=""><?php echo e(__('Select Designation')); ?></option>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <?php echo e(Form::label('employee_id', __('Employee'), ['class' => 'col-form-label'])); ?>

                <div class="employee_div">
                    <select class="form-control  employee_id" name="employee_id[]"
                        placeholder="Select Employee">
                    <option value=""><?php echo e(__('Select Employee')); ?></option>
                    </select>
                </div>

            </div>
        </div>

        <div class="col-md-12 col-sm-12 col-lg-12 col-xl-12">
            <div class="form-group">
                <?php echo e(Form::label('title', __('Event Title'), ['class' => 'col-form-label'])); ?>

                <?php echo e(Form::text('title', null, ['class' => 'form-control ', 'placeholder' => __('Enter Event Title')])); ?>

            </div>
        </div>
        <div class="col-md-6 col-sm-12 col-lg-6 col-xl-6">
            <div class="form-group">
                <?php echo e(Form::label('start_date', __('Event start Date'), ['class' => 'col-form-label'])); ?>

                <?php echo e(Form::date('start_date', null, ['class' => 'form-control datetime-local', 'autocomplete'=>'off'])); ?>

            </div>
        </div>
        <div class="col-md-6 col-sm-12 col-lg-6 col-xl-6">
            <div class="form-group">
                <?php echo e(Form::label('end_date', __('Event End Date'), ['class' => 'col-form-label'])); ?>

                <?php echo e(Form::date('end_date', null, ['class' => 'form-control datetime-local','autocomplete'=>'off' ])); ?>

            </div>
        </div>
        <div class="col-md-12 col-sm-12 col-lg-12 col-xl-12">
            <div class="form-group">
                <?php echo e(Form::label('color', __('Event Select Color'), ['class' => 'col-form-label d-block mb-3'])); ?>

                <div class="btn-group-toggle btn-group-colors event-tag" data-toggle="buttons">
                    <label class="btn bg-info active p-3"><input type="radio" name="color" value="event-info" checked class="d-none"></label>
                    <label class="btn bg-warning p-3"><input type="radio" name="color" value="event-warning" class="d-none"></label>
                    <label class="btn bg-danger p-3"><input type="radio" name="color" value="event-danger" class="d-none"></label>
                    <label class="btn bg-success p-3"><input type="radio" name="color" value="event-success" class="d-none"></label>
                    <label class="btn p-3" style="background-color: #51459d !important"><input type="radio" name="color" class="d-none" value="event-primary"></label>
                </div>
            </div>
        </div>

        <div class="form-group">
            <?php echo e(Form::label('description', __('Event Description'), ['class' => 'col-form-label'])); ?>

            <?php echo e(Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => __('Enter Event Description'),'rows'=>'5'])); ?>

        </div>
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="Cancel" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="<?php echo e(__('Create')); ?>" class="btn  btn-primary">

</div>
<?php echo e(Form::close()); ?>

<?php /**PATH D:\joki\codecanyon-iMuwzIOg-hrmgo-saas-hrm-and-payroll-tool\hr\newhrsystem\resources\views\event\create.blade.php ENDPATH**/ ?>