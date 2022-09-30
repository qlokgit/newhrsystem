
<?php echo e(Form::model($payer, ['route' => ['payer.update', $payer->id], 'method' => 'PUT'])); ?>

<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <?php echo e(Form::label('payer_name', __('Payer Name'), ['class' => 'col-form-label'])); ?>

                <?php echo e(Form::text('payer_name', null, ['class' => 'form-control', 'placeholder' => __('Enter Payer Name')])); ?>

            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <?php echo e(Form::label('contact_number', __('Contact Number'), ['class' => 'col-form-label'])); ?>

                <?php echo e(Form::text('contact_number', null, ['class' => 'form-control', 'placeholder' => __('Enter Contact Number')])); ?>

            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="Cancel" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="<?php echo e(__('Update')); ?>" class="btn btn-primary">
</div>

<?php echo e(Form::close()); ?>

<?php /**PATH D:\joki\codecanyon-iMuwzIOg-hrmgo-saas-hrm-and-payroll-tool\hr\newhrsystem\resources\views\payer\edit.blade.php ENDPATH**/ ?>