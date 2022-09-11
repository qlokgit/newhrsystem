<?php echo e(Form::model($warning, ['route' => ['warning.update', $warning->id], 'method' => 'PUT'])); ?>

<div class="modal-body">
    <div class="row">
        <?php if(\Auth::user()->type != 'employee'): ?>
            <div class="form-group col-md-6 col-lg-6">
                <?php echo e(Form::label('warning_by', __('Warning By'), ['class' => 'col-form-label'])); ?>

                <?php echo e(Form::select('warning_by', $employees, null, ['class' => 'form-control select2', 'required' => 'required'])); ?>

            </div>
        <?php endif; ?>
        <div class="form-group col-lg-6 col-md-6">
            <?php echo e(Form::label('warning_to', __('Warning To'), ['class' => 'col-form-label'])); ?>

            <?php echo e(Form::select('warning_to', $employees, null, ['class' => 'form-control select2' ,'required' => 'required'])); ?>

        </div>
        <div class="form-group col-lg-6 col-md-6">
            <?php echo e(Form::label('subject', __('Subject'), ['class' => 'col-form-label'])); ?>

            <?php echo e(Form::text('subject', null, ['class' => 'form-control'])); ?>

        </div>
        <div class="form-group col-lg-6 col-md-6">
            <?php echo e(Form::label('warning_date', __('Warning Date'), ['class' => 'col-form-label'])); ?>

            <?php echo e(Form::text('warning_date', null, ['class' => 'form-control d_week', 'autocomplete' => 'off' ,'required' => 'required'])); ?>

        </div>
        <div class="form-group col-lg-12">
            <?php echo e(Form::label('description', __('Description'), ['class' => 'col-form-label'])); ?>

            <?php echo e(Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => __('Enter Description') ,'rows' => '3' ,'required' => 'required'])); ?>

        </div>
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="Cancel" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="<?php echo e(__('Update')); ?>" class="btn btn-primary">
</div>

<?php echo e(Form::close()); ?>

<?php /**PATH D:\joki\codecanyon-iMuwzIOg-hrmgo-saas-hrm-and-payroll-tool\hr\newhrsystem\resources\views\warning\edit.blade.php ENDPATH**/ ?>