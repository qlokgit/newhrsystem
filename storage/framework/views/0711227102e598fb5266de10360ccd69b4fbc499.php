<?php echo e(Form::model($ip, ['route' => ['edit.ip', $ip->id], 'method' => 'POST'])); ?>

<div class="modal-body">
    <div class="row">
        <div class="form-group">
            <?php echo e(Form::label('ip', __('IP'), ['class' => 'col-form-label'])); ?>

            <?php echo e(Form::text('ip', null, ['class' => 'form-control'])); ?>

        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn  btn-light" data-bs-dismiss="modal"><?php echo e(__('Close')); ?></button>
    <input type="submit" value="<?php echo e(__('Update')); ?>" class="btn  btn-primary">

</div>
<?php echo e(Form::close()); ?>

<?php /**PATH D:\joki\codecanyon-iMuwzIOg-hrmgo-saas-hrm-and-payroll-tool\hr\newhrsystem\resources\views\restrict_ip\edit.blade.php ENDPATH**/ ?>