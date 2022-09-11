<?php echo e(Form::open(['route' => ['job.on.board.store', $id], 'method' => 'post'])); ?>

<div class="modal-body">
    <div class="row">
        <?php if($id == 0): ?>
            <div class="form-group col-md-12">
                <?php echo e(Form::label('application', __('Interviewer'), ['class' => 'col-form-label'])); ?>

                <?php echo e(Form::select('application', $applications, null, ['class' => 'form-control select2', 'required' => 'required'])); ?>

            </div>
        <?php endif; ?>
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
    <input type="submit" value="<?php echo e(__('Create')); ?>" class="btn btn-primary">
</div>
<?php echo e(Form::close()); ?>

<?php /**PATH D:\joki\codecanyon-iMuwzIOg-hrmgo-saas-hrm-and-payroll-tool\hr\newhrsystem\resources\views\jobApplication\onboardCreate.blade.php ENDPATH**/ ?>