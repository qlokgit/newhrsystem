

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="<?php echo e(route('shift.store')); ?>" method="post">
                    <?php echo csrf_field(); ?>
                    <div class="p-2">
                        <div class="card p-3">
                            <h6>Add Shift Roster</h6>
                            <div class="alert alert-info mt-5" role="alert">
                                <i class="fa fa-info-circle"></i> The existing shift will be overidden
                            </div>
                            <div class="modal-body p-0">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1">Department</label>
                                            <select class="form-control" name="department_id">
                                                <option>Nothing Selected</option>
                                                <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value=<?php echo e($item->id); ?>><?php echo e($item->name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-8">
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1">Employees</label>
                                            <select class="form-control" name="employee_id">
                                                <option>Nothing Selected</option>
                                                <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value=<?php echo e($item->id); ?>><?php echo e($item->name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1">Employee Shift</label>
                                            <select class="form-control" name="employee_shift_id">
                                                <option>Nothing Selected</option>
                                                <?php $__currentLoopData = $employeeShift; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value=<?php echo e($item->id); ?>><?php echo e($item->name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-8">
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1">Assign Shift By</label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="assign_shift_by" value="date"
                                                    checked>
                                                <label class="form-check-label">
                                                    Date
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="assign_shift_by"
                                                    value="month">
                                                <label class="form-check-label">
                                                    Month
                                                </label>
            
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="validationDefault01">Date</label>
                                        <input type="date" name="dates" class="form-control datepicker"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            
                    <div class="modal-footer">
                        <input type="button" value="Cancel" class="btn btn-light" data-bs-dismiss="modal">
                        <input type="submit" value="<?php echo e(__('Create')); ?>" class="btn btn-primary">
                    </div>
                </form>
                
            </div>
        </div>
    </div><?php /**PATH /var/www/html/Project/main_file/resources/views/shift/create.blade.php ENDPATH**/ ?>