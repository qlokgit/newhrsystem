<?php echo e(Form::model($interviewSchedule, ['route' => ['interview-schedule.update', $interviewSchedule->id],'method' => 'PUT'])); ?>

<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-6">
            <?php echo e(Form::label('candidate', __('Interviewer'), ['class' => 'col-form-label'])); ?>

            <?php echo e(Form::select('candidate', $candidates, null, ['class' => 'form-control select2', 'required' => 'required'])); ?>

        </div>
        <div class="form-group col-md-6">
            <?php echo e(Form::label('employee', __('Assign Employee'), ['class' => 'col-form-label'])); ?>

            <?php echo e(Form::select('employee', $employees, null, ['class' => 'form-control select2', 'required' => 'required'])); ?>

        </div>
        <div class="form-group col-md-6">
            <?php echo e(Form::label('date', __('Interview Date'), ['class' => 'col-form-label'])); ?>

            <?php echo e(Form::text('date', null, ['class' => 'form-control d_week'])); ?>

        </div>
        <div class="form-group col-md-6">
            <?php echo e(Form::label('time', __('Interview Time'), ['class' => 'col-form-label'])); ?>

            <?php echo e(Form::time('time', null, ['class' => 'form-control timepicker'])); ?>

        </div>
        <div class="form-group">
            <?php echo e(Form::label('comment', __('Comment'), ['class' => 'col-form-label'])); ?>

            <?php echo e(Form::textarea('comment', null, ['class' => 'form-control'])); ?>

        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn  btn-light" data-bs-dismiss="modal"><?php echo e(__('Cancel')); ?></button>
    <input type="submit" value="<?php echo e(__('Update')); ?>" class="btn  btn-primary">

</div>
<?php echo e(Form::close()); ?>

<?php /**PATH D:\joki\codecanyon-iMuwzIOg-hrmgo-saas-hrm-and-payroll-tool\hr\newhrsystem\resources\views\interviewSchedule\edit.blade.php ENDPATH**/ ?>