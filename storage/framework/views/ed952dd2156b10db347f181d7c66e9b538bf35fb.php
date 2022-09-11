



<?php $__env->startSection('page-title'); ?>
    <?php echo e(__("Manage Plan Order")); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>"><?php echo e(__("Home")); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__("Plan Order")); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

        <div class="col-xl-12">
            <div class="card">
                <div class="card-header card-body table-border-style">
                    
                    <div class="table-responsive">
                        <table class="table" id="pc-dt-simple">
                            <thead>
                                <tr>
                                    <th><?php echo e(__('Order Id')); ?></th>
                                    <th><?php echo e(__('Name')); ?></th>
                                    <th><?php echo e(__('Plan Name')); ?></th>
                                    <th><?php echo e(__('Price')); ?></th>
                                    <th><?php echo e(__('Status')); ?></th>
                                    <th><?php echo e(__('Date')); ?></th>
                                    <th><?php echo e(__('Coupon')); ?></th>
                                    <th><?php echo e(__('Type')); ?></th>
                                    <th><?php echo e(__('Invoice')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($order->order_id); ?></td>
                                        <td><?php echo e($order->user_name); ?></td>
                                        <td><?php echo e($order->plan_name); ?></td>
                                        <td><?php echo e((!empty(env('CURRENCY_SYMBOL')) ? env('CURRENCY_SYMBOL') : '$') . $order->price); ?>

                                        </td>
                                        <td>
                                            <?php if($order->payment_status == 'succeeded'): ?>
                                                <i class="mdi mdi-circle text-success"></i>
                                                <?php echo e(ucfirst($order->payment_status)); ?>

                                            <?php else: ?>
                                                <i class="mdi mdi-circle text-danger"></i>
                                                <?php echo e(ucfirst($order->payment_status)); ?>

                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e($order->created_at->format('d M Y')); ?></td>
                                        <td><?php echo e(!empty($order->total_coupon_used)? (!empty($order->total_coupon_used->coupon_detail)? $order->total_coupon_used->coupon_detail->code: '-'): '-'); ?>

                                        </td>
                                        <td><?php echo e($order->payment_type); ?></td>
                                        <td>
                                            <?php if(empty($order->receipt)): ?>
                                                <p><?php echo e(__('Manually plan upgraded by super admin')); ?></p>
                                            <?php elseif($order->receipt == 'free coupon'): ?>
                                                <p><?php echo e(__('Used 100 % discount coupon code.')); ?></p>
                                            <?php else: ?>
                                                <a href="<?php echo e($order->receipt); ?>" title="Invoice" target="_blank"
                                                    class="action-btn btn-primary me-1 btn btn-sm d-inline-flex align-items-center"><i
                                                        class="ti ti-file-invoice"></i> </a>
                                            <?php endif; ?>
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

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\joki\codecanyon-iMuwzIOg-hrmgo-saas-hrm-and-payroll-tool\hr\newhrsystem\resources\views/order/index.blade.php ENDPATH**/ ?>