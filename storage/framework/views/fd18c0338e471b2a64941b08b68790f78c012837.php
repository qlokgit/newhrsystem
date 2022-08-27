<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Employee Shift')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>"><?php echo e(__('Home')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Employee Shift')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('action-button'); ?>
    
    <a href="#" data-url="<?php echo e(route('employee_shift.create')); ?>" data-ajax-popup="true"
        data-title="<?php echo e(__('Create New Employee Shift')); ?>" data-bs-toggle="tooltip" title=""
        class="btn btn-sm btn-primary" data-bs-original-title="<?php echo e(__('Create')); ?>">
        <i class="ti ti-plus"></i>
    </a>
    
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
    <div class="col-3">
        <?php echo $__env->make('layouts.hrm_setup', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
    <div class="col-9">
        <div class="card">
            <div class="card-header card-body table-border-style">
                <div class="table-responsive">
                    <table class="table" id="pc-dt-simple">
                        <thead>
                            <tr>
                                <th><?php echo e(__('Employee Shift')); ?></th>
                                <th><?php echo e(__('Initial')); ?></th>
                                <th><?php echo e(__('Color')); ?></th>
                                <th><?php echo e(__('Time Start')); ?></th>
                                <th><?php echo e(__('Time End')); ?></th>
                                <th width="200px"><?php echo e(__('Action')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $employeeShift; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($item->name); ?></td>
                                    <td><?php echo e($item->initial); ?></td>
                                    <td><div style="width:100%;height:10px;background-color:<?php echo e($item->color); ?>"></div></td>
                                    <td><?php echo e($item->time_start); ?></td>
                                    <td><?php echo e($item->time_end); ?></td>
                                    <td class="Action">
                                        <span>
                                            
                                                <div class="action-btn btn-info ms-2">
                                                    <a href="#" data-size="md"
                                                        data-url="<?php echo e(URL::to('employee_shift/' . $item->id . '/edit')); ?>"
                                                        data-ajax-popup="true" data-title="<?php echo e(__('Edit Employee Shift')); ?>"
                                                        class="mx-3 btn btn-sm d-inline-flex align-items-center"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="<?php echo e(__('Edit Employee Shift')); ?>"><i
                                                            class="ti ti-pencil text-white"></i></a>
                                                </div>
                                            
                                            
                                                <div class="action-btn bg-danger ms-2">
                                                    <?php echo Form::open(['method' => 'DELETE', 'route' => ['employee_shift.destroy', $item->id]]); ?>

                                                    <a href="#!"
                                                        class="mx-3 btn btn-sm d-inline-flex align-items-center bs-pass-para"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="<?php echo e(__('Delete')); ?>">
                                                        <span class="text-white"> <i class="ti ti-trash"></i></span></a>
                                                    <?php echo Form::close(); ?>

                                                </div>
                                
                                </span>
                                </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/Project/main_file/resources/views/employee_shift/index.blade.php ENDPATH**/ ?>