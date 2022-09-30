

<?php echo e(Form::open(['url' => 'attendanceemployee', 'method' => 'post'])); ?>

<div class="card-body p-0">
    <div class="row">
        <div class="form-group col-lg-6 col-md-6">
            <?php echo e(Form::label('employee_id', __('Employee'), ['class' => 'col-form-label'])); ?>

            <?php echo e(Form::select('employee_id', $employees, null, ['class' => 'form-control select2'])); ?>

        </div>
        <div class="form-group col-lg-6 col-md-6">
            <?php echo e(Form::label('date', __('Date'), ['class' => 'col-form-label'])); ?>

            <?php echo e(Form::text('date', null, ['class' => 'form-control d_week','autocomplete'=>'off'])); ?>

        </div>
        <div class="form-group col-lg-6 col-md-6">
            <?php echo e(Form::label('clock_in', __('Clock In'), ['class' => 'col-form-label'])); ?>

            <?php echo e(Form::text('clock_in', null, ['class' => 'form-control timepicker'])); ?>

        </div>
        <div class="form-group col-lg-6 col-md-6">
            <?php echo e(Form::label('clock_out', __('Clock Out'), ['class' => 'col-form-label'])); ?>

            <?php echo e(Form::text('clock_out', null, ['class' => 'form-control timepicker'])); ?>

        </div>
    </div>
</div>
<div class="modal-footer pr-0">
    <button type="button" class="btn dark btn-outline" data-dismiss="modal"><?php echo e(__('Cancel')); ?></button>
    <?php echo e(Form::submit(__('Create'), ['class' => 'btn btn-primary'])); ?>

</div>
<?php echo e(Form::close()); ?>

<?php /**PATH D:\joki\codecanyon-iMuwzIOg-hrmgo-saas-hrm-and-payroll-tool\hr\newhrsystem\resources\views\attendance\create.blade.php ENDPATH**/ ?>