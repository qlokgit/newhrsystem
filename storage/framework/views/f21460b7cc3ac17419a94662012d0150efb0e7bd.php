<?php echo e(Form::model($loan, ['route' => ['loan.update', $loan->id], 'method' => 'PUT'])); ?>

<div class="modal-body">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <?php echo e(Form::label('title', __('Title'), ['class' => 'col-form-label'])); ?>

                <?php echo e(Form::text('title', null, ['class' => 'form-control ', 'required' => 'required','placeholder'=>'Enter Title'])); ?>

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <?php echo e(Form::label('loan_option', __('Loan Options*'), ['class' => 'col-form-label'])); ?>

                <?php echo e(Form::select('loan_option', $loan_options, null, ['class' => 'form-control select2','required' => 'required'])); ?>

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <?php echo e(Form::label('type', __('Type'), ['class' => 'col-form-label'])); ?>

                <?php echo e(Form::select('type', $loans, null, ['class' => 'form-control select2 amount_type','required' => 'required'])); ?>

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <?php echo e(Form::label('amount', __('Loan Amount'), ['class' => 'col-form-label amount_label'])); ?>

                <?php echo e(Form::number('amount', null, ['class' => 'form-control ', 'required' => 'required','placeholder'=>'Enter Amount'])); ?>

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <?php echo e(Form::label('start_date', __('Start Date'), ['class' => 'col-form-label'])); ?>

                <?php echo e(Form::text('start_date', null, ['class' => 'form-control d_week','required' => 'required','autocomplete'=>'off'])); ?>

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <?php echo e(Form::label('end_date', __('End Date'), ['class' => 'col-form-label'])); ?>

                <?php echo e(Form::text('end_date', null, ['class' => 'form-control d_week', 'required' => 'required','autocomplete'=>'off'])); ?>

            </div>
        </div>
        <div class="form-group">
            <?php echo e(Form::label('reason', __('Reason'), ['class' => 'col-form-label'])); ?>

            <?php echo e(Form::textarea('reason', null, ['class' => 'form-control ', 'required' => 'required','rows' => 3])); ?>

        </div>
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="Cancel" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="<?php echo e(__('Update')); ?>" class="btn btn-primary">
</div>

<?php echo e(Form::close()); ?>

<?php /**PATH D:\joki\codecanyon-iMuwzIOg-hrmgo-saas-hrm-and-payroll-tool\hr\newhrsystem\resources\views\loan\edit.blade.php ENDPATH**/ ?>