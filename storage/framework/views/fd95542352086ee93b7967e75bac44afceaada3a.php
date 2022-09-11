<?php echo e(Form::model($coupon, ['route' => ['coupons.update', $coupon->id], 'method' => 'PUT'])); ?>

<div class="modal-body">
    <div class="row">
        <div class="form-group">
            <?php echo e(Form::label('name', __('Name'), ['class' => 'col-form-label'])); ?>

            <?php echo e(Form::text('name', null, ['class' => 'form-control font-style', 'required' => 'required'])); ?>

        </div>
        <div class="form-group col-md-6">
            <?php echo e(Form::label('discount', __('Discount'), ['class' => 'col-form-label'])); ?>

            <?php echo e(Form::number('discount', null, ['class' => 'form-control', 'required' => 'required', 'step' => '0.01'])); ?>

            <span class="small"><?php echo e(__('Note: Discount in Percentage')); ?></span>
        </div>
        <div class="form-group col-md-6">
            <?php echo e(Form::label('limit', __('Limit'), ['class' => 'col-form-label'])); ?>

            <?php echo e(Form::number('limit', null, ['class' => 'form-control', 'required' => 'required'])); ?>

        </div>
        <div class="form-group">
            <?php echo e(Form::label('code', __('Code'), ['class' => 'col-form-label'])); ?>

            <?php echo e(Form::text('code', null, ['class' => 'form-control', 'required' => 'required'])); ?>

        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn  btn-light" data-bs-dismiss="modal"><?php echo e(__('Close')); ?></button>
    <input type="submit" value="<?php echo e(__('Update')); ?>" class="btn  btn-primary">

</div>
<?php echo e(Form::close()); ?>

<?php /**PATH D:\joki\codecanyon-iMuwzIOg-hrmgo-saas-hrm-and-payroll-tool\hr\newhrsystem\resources\views\coupon\edit.blade.php ENDPATH**/ ?>