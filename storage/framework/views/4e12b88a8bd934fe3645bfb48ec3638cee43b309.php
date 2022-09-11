


<?php echo e(Form::model($appraisal, ['route' => ['appraisal.update', $appraisal->id], 'method' => 'PUT'])); ?>

<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <?php echo e(Form::label('branch', __('Branch*'), ['class' => 'col-form-label'])); ?>

                <?php echo e(Form::select('branch', $brances, null, ['class' => 'form-control select2', 'required' => 'required', 'id' => 'branch'])); ?>

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <?php echo e(Form::label('employee', __('Employee*'), ['class' => 'col-form-label'])); ?>

                <div class="employee_div">
                    <?php echo e(Form::select('employee', $employee, null, ['class' => 'form-control select2 employee', 'required' => 'required'])); ?>

                 </div>

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <?php echo e(Form::label('appraisal_date', __('Select Month*'), ['class' => 'col-form-label'])); ?>

                <?php echo e(Form::text('appraisal_date', null, ['class' => 'form-control d_filter' ,'required' => 'required'])); ?>

            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <?php echo e(Form::label('remark', __('Remarks'), ['class' => 'col-form-label'])); ?>

                <?php echo e(Form::textarea('remark', null, ['class' => 'form-control', 'rows' => '3'])); ?>

            </div>
        </div>
    </div>
    <div class="row">
        <?php $__currentLoopData = $performance_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $performances): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-12 mt-3">
                <h6><?php echo e($performances->name); ?></h6>
                <hr class="mt-0">
            </div>
            <?php $__currentLoopData = $performances->types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $types): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-6">
                    <?php echo e($types->name); ?>

                </div>
                <div class="col-6">
                    <fieldset id='demo1' class="rate">
                        <input class="stars" type="radio" id="technical-5-<?php echo e($types->id); ?>"
                            name="rating[<?php echo e($types->id); ?>]" value="5"
                            <?php echo e(isset($ratings[$types->id]) && $ratings[$types->id] == 5 ? 'checked' : ''); ?>>
                        <label class="full" for="technical-5-<?php echo e($types->id); ?>"
                            title="Awesome - 5 stars"></label>
                        <input class="stars" type="radio" id="technical-4-<?php echo e($types->id); ?>"
                            name="rating[<?php echo e($types->id); ?>]" value="4"
                            <?php echo e(isset($ratings[$types->id]) && $ratings[$types->id] == 4 ? 'checked' : ''); ?>>
                        <label class="full" for="technical-4-<?php echo e($types->id); ?>"
                            title="Pretty good - 4 stars"></label>
                        <input class="stars" type="radio" id="technical-3-<?php echo e($types->id); ?>"
                            name="rating[<?php echo e($types->id); ?>]" value="3"
                            <?php echo e(isset($ratings[$types->id]) && $ratings[$types->id] == 3 ? 'checked' : ''); ?>>
                        <label class="full" for="technical-3-<?php echo e($types->id); ?>"
                            title="Meh - 3 stars"></label>
                        <input class="stars" type="radio" id="technical-2-<?php echo e($types->id); ?>"
                            name="rating[<?php echo e($types->id); ?>]" value="2"
                            <?php echo e(isset($ratings[$types->id]) && $ratings[$types->id] == 2 ? 'checked' : ''); ?>>
                        <label class="full" for="technical-2-<?php echo e($types->id); ?>"
                            title="Kinda bad - 2 stars"></label>
                        <input class="stars" type="radio" id="technical-1-<?php echo e($types->id); ?>"
                            name="rating[<?php echo e($types->id); ?>]" value="1"
                            <?php echo e(isset($ratings[$types->id]) && $ratings[$types->id] == 1 ? 'checked' : ''); ?>>
                        <label class="full" for="technical-1-<?php echo e($types->id); ?>"
                            title="Sucks big time - 1 star"></label>
                    </fieldset>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>

\

<div class="modal-footer">
    <input type="button" value="Cancel" class="btn btn-light" data-bs-dismiss="modal">
<input type="submit" value="<?php echo e(__('Update')); ?>" class="btn btn-primary">
</div>
<?php echo e(Form::close()); ?>



<script type="text/javascript">
    function getEmployee(did) {
        $.ajax({
            url: '<?php echo e(route('branch.employee.json')); ?>',
            type: 'POST',
            data: {
                "branch": did,
                "_token": "<?php echo e(csrf_token()); ?>",
            },
            success: function(data) {
                // $('#employee').empty();
                // $('#employee').append('<option value=""><?php echo e(__('Select Branch')); ?></option>');
                // $.each(data, function(key, value) {
                //     var select = '';
                //     if (key == '<?php echo e($appraisal->employee); ?>') {
                //         select = 'selected';
                //     }

                //     $('#employee').append('<option value="' + key + '"  ' + select + '>' + value +
                //         '</option>');
                // });


                $('.employee').empty();
                    var emp_selct = ` <select class="form-control  employee" name="employee" id="choices-multiple"
                                            placeholder="Select Employee" >
                                            </select>`;
                    $('.employee_div').html(emp_selct);

                    $('.employee').append('<option value="0"> <?php echo e(__('All')); ?> </option>');
                    $.each(data, function(key, value) {
                        var select = '';
                    if (key == '<?php echo e($appraisal->employee); ?>') {
                        select = 'selected';
                    }

                    $('.employee').append('<option value="' + key + '"  ' + select + '>' + value +
                        '</option>');
                    });
                    new Choices('#choices-multiple', {
                        removeItemButton: true,
                    });
            }
        });
    }

    $(document).ready(function() {
        var d_id = $('#branch').val();
        getEmployee(d_id);
    });
</script>
<?php /**PATH D:\joki\codecanyon-iMuwzIOg-hrmgo-saas-hrm-and-payroll-tool\hr\newhrsystem\resources\views\appraisal\edit.blade.php ENDPATH**/ ?>