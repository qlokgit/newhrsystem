<?php echo e(Form::open(['url' => 'saturationdeduction', 'method' => 'post'])); ?>

<?php echo e(Form::hidden('employee_id', $employee->id, [])); ?>

<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-6">
            <?php echo e(Form::label('deduction_option', __('Deduction Options*'), ['class' => 'col-form-label'])); ?>

            <?php echo e(Form::select('deduction_option', $deduction_options, null, ['class' => 'form-control select2', 'required' => 'required'])); ?>

        </div>
        <div class="form-group col-md-6">
            <?php echo e(Form::label('title', __('Title'), ['class' => 'col-form-label'])); ?>

            <?php echo e(Form::text('title', null, ['class' => 'form-control ', 'required' => 'required', 'placeholder' => 'Enter Title'])); ?>

        </div>
        <div class="form-group col-md-6">
            <?php echo e(Form::label('type', __('Type'), ['class' => 'col-form-label'])); ?>

            <?php echo e(Form::select('type', $saturationdeduc, null, ['class' => 'form-control select2 amount_type', 'required' => 'required'])); ?>

        </div>
        <div class="form-group col-md-6">
            <?php echo e(Form::label('amount', __('Amount'), ['class' => 'col-form-label amount_label'])); ?>

            <?php echo e(Form::number('amount', null, ['class' => 'form-control ', 'required' => 'required', 'step' => '0.01', 'placeholder' => 'Enter Amonut'])); ?>

        </div>
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="Cancel" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="<?php echo e(__('Create')); ?>" class="btn btn-primary">
</div>
<?php echo e(Form::close()); ?>

<?php /**PATH D:\joki\codecanyon-iMuwzIOg-hrmgo-saas-hrm-and-payroll-tool\hr\newhrsystem\resources\views\saturationdeduction\create.blade.php ENDPATH**/ ?>