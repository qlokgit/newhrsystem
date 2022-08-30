
<?php echo e(Form::open(['url' => 'leave/changeaction', 'method' => 'post'])); ?>

<div class="modal-body">
    <div class="row">
        <div class="col-12">
            <table class="table" id="pc-dt-simple">
                <tr role="row">
                    <th><?php echo e(__('Employee')); ?></th>
                    <td><?php echo e(!empty($employee->name) ? $employee->name : ''); ?></td>
                </tr>
                <tr>
                    <th><?php echo e(__('Leave Type ')); ?></th>
                    <td><?php echo e(!empty($leavetype->title) ? $leavetype->title : ''); ?></td>
                </tr>
                <tr>
                    <th><?php echo e(__('Appplied On')); ?></th>
                    <td><?php echo e(\Auth::user()->dateFormat($leave->applied_on)); ?></td>
                </tr>
                <tr>
                    <th><?php echo e(__('Start Date')); ?></th>
                    <td><?php echo e(\Auth::user()->dateFormat($leave->start_date)); ?></td>
                </tr>
                <tr>
                    <th><?php echo e(__('End Date')); ?></th>
                    <td><?php echo e(\Auth::user()->dateFormat($leave->end_date)); ?></td>
                </tr>
                <tr>
                    <th><?php echo e(__('Leave Reason')); ?></th>
                    <td><?php echo e(!empty($leave->leave_reason) ? $leave->leave_reason : ''); ?></td>
                </tr>
                <tr>
                    <th><?php echo e(__('Status')); ?></th>
                    <td><?php echo e(!empty($leave->status) ? $leave->status : ''); ?></td>
                </tr>
                <tr>
                    <th><?php echo e(__('Approved By')); ?></th>
                    <td>
                        <?php $__currentLoopData = $approvedLeave; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="row mt-2">
                                <div class="col-8">
                                    <?php echo e($item->employee->name); ?>

                                </div>
                                <?php if($item->status == 'Pending'): ?>
                                    <div class="col-4 badge bg-warning p-2 px-3 rounded status-badge5">
                                        <?php echo e($item->status); ?></div>
                                <?php elseif($item->status == 'Waiting'): ?>
                                    <div class="col-4 badge bg-info p-2 px-3 rounded status-badge5">
                                        <?php echo e($item->status); ?></div>
                                <?php elseif($item->status == 'Approved'): ?>
                                    <div class="col-4 badge bg-success p-2 px-3 rounded status-badge5">
                                        <?php echo e($item->status); ?></div>
                                <?php else: ?>
                                    <div class="col-4 badge bg-danger p-2 px-3 rounded status-badge5">
                                        <?php echo e($item->status); ?></div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </td>
                </tr>
                <input type="hidden" value="<?php echo e($leave->id); ?>" name="leave_id">
            </table>
        </div>
    </div>
</div>

<?php if($leave->status == 'Pending'): ?>
    <div class="modal-footer">
        <input type="submit" value="<?php echo e(__('Approved')); ?>" class="btn btn-success rounded" name="status">
        <input type="submit" value="<?php echo e(__('Reject')); ?>" class="btn btn-danger rounded" name="status">
    </div>
<?php endif; ?>
<?php echo e(Form::close()); ?>

<?php /**PATH /var/www/html/Project/External/newhrsystem/resources/views/leave/action.blade.php ENDPATH**/ ?>