<?php echo e(Form::model($jobOnBoard, ['route' => ['job.on.board.update', $jobOnBoard->id], 'method' => 'post'])); ?>

<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-12">
            <?php echo Form::label('joining_date', __('Joining Date'), ['class' => 'col-form-label']); ?>

            <?php echo Form::text('joining_date', null, ['class' => 'form-control d_week','autocomplete'=>'off']); ?>

        </div>
        <div class="form-group col-md-12">
            <?php echo e(Form::label('status', __('Status'), ['class' => 'col-form-label'])); ?>

            <?php echo e(Form::select('status', $status, null, ['class' => 'form-control select2'])); ?>

        </div>
    </div>
</div>

<div class="modal-footer">
    <input type="button" value="Cancel" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="<?php echo e(__('Update')); ?>" class="btn btn-primary">
</div>

<?php echo e(Form::close()); ?>

<?php /**PATH D:\joki\codecanyon-iMuwzIOg-hrmgo-saas-hrm-and-payroll-tool\hr\newhrsystem\resources\views\jobApplication\onboardEdit.blade.php ENDPATH**/ ?>