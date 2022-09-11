

<?php echo e(Form::model($indicator, ['route' => ['indicator.update', $indicator->id], 'method' => 'PUT'])); ?>

<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <?php echo e(Form::label('branch', __('Branch*'), ['class' => 'col-form-label'])); ?>


                
                <?php echo e(Form::select('branch', $brances, null, ['class' => 'form-control select2', 'required' => 'required'])); ?>

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <?php echo e(Form::label('department', __('Department*'), ['class' => 'col-form-label'])); ?>

                <?php echo e(Form::select('department', $departments, null, ['class' => 'form-control select2', 'required' => 'required', 'id' => 'department_id'])); ?>

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <?php echo e(Form::label('designation', __('Designation'), ['class' => 'col-form-label'])); ?>

                <div class="designation_div">
                    <select class="select2 form-control designation_id" name="designation"
                    data-placeholder="<?php echo e(__('Select Designation ...')); ?>" required>
               </select>
                </div>

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

<div class="modal-footer">
    <input type="button" value="Cancel" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="<?php echo e(__('Update')); ?>" class="btn btn-primary">
</div>
    <?php echo e(Form::close()); ?>


<script type="text/javascript">
    function getDesignation(did) {
        $.ajax({
            url: '<?php echo e(route('employee.json')); ?>',
            type: 'POST',
            data: {
                "department_id": did,
                "_token": "<?php echo e(csrf_token()); ?>",
            },
            success: function(data) {
                console.log(data);



                // $('#designation_id').empty();
                // $('#designation_id').append('<option value="">Select any Designation</option>');
                // $.each(data, function(key, value) {
                //     var select = '';
                //     if (key == '<?php echo e($indicator->designation); ?>') {
                //         select = 'selected';
                //     }

                //     $('#designation_id').append('<option value="' + key + '"  ' + select + '>' +
                //         value + '</option>');
                // });


                $('.designation_id').empty();
                    var emp_selct = ` <select class="form-control  designation_id" name="designation" id="choices-multiple"
                                            placeholder="Select Designation" >
                                            </select>`;
                     $('.designation_div').html(emp_selct);
                    $.each(data, function(key, value) {
                    var select = '';
                    if (key == '<?php echo e($indicator->designation); ?>') {
                        select = 'selected';
                    }

                    $('.designation_id').append('<option value="' + key + '"  ' + select + '>' +
                        value + '</option>');
                });

                    // $('.designation_id').append('<option value="0"> <?php echo e(__('All')); ?> </option>');
                    // $.each(data, function(key, value) {
                    //     $('.designation_id').append('<option value="' + key + '">' + value +
                    //         '</option>');
                    // });
                    new Choices('#choices-multiple', {
                        removeItemButton: true,
                    });
            }
        });
    }

    $(document).ready(function() {
        var d_id = $('#department_id').val();
        getDesignation(d_id);
    });
</script>

<?php /**PATH D:\joki\codecanyon-iMuwzIOg-hrmgo-saas-hrm-and-payroll-tool\hr\newhrsystem\resources\views\indicator\edit.blade.php ENDPATH**/ ?>