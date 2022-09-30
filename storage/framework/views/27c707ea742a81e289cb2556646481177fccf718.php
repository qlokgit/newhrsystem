

<?php echo e(Form::model($meeting, ['route' => ['meeting.update', $meeting->id], 'method' => 'PUT'])); ?>

<div class="modal-body">

    <div class="row">
    


        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="form-group">
                <?php echo e(Form::label('title', __('Meeting Title'), ['class' => 'form-label'])); ?>

                <div class="form-icon-user">
                    <?php echo e(Form::text('title', null, ['class' => 'form-control ', 'required' => 'required' ,'placeholder' => __('Enter Meeting Title')])); ?>

                </div>
            </div>
        </div>


        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="form-group">
                <?php echo e(Form::label('date', __('Meeting Date'), ['class' => 'form-label'])); ?>

                <div class="form-icon-user">
                    <?php echo e(Form::text('date', null, ['class' => 'form-control d_week', 'required' => 'required'])); ?>

                </div>
            </div>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="form-group">
                <?php echo e(Form::label('time', __('Meeting Time'), ['class' => 'form-label'])); ?>

                <div class="form-icon-user">
                    <?php echo e(Form::time('time', null, ['class' => 'form-control', 'required' => 'required'])); ?>

                </div>
            </div>
        </div>


        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="form-group">
                <?php echo e(Form::label('note', __('Meeting Note'), ['class' => 'form-label'])); ?>

                <div class="form-icon-user">
                    <?php echo e(Form::textarea('note', null, ['class' => 'form-control', 'rows' => '3'])); ?>

                </div>
            </div>
        </div>


    </div>
</div>
<div class="modal-footer">
    <input type="button" value="Cancel" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="<?php echo e(__('Update')); ?>" class="btn btn-primary">
</div>
<?php echo e(Form::close()); ?>


<?php /**PATH D:\joki\codecanyon-iMuwzIOg-hrmgo-saas-hrm-and-payroll-tool\hr\newhrsystem\resources\views\meeting\edit.blade.php ENDPATH**/ ?>