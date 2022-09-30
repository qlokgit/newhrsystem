
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Payslip')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1><?php echo e(__('Employee Salary')); ?></h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#"><?php echo e(__('Home')); ?></a></div>
                    <div class="breadcrumb-item"><?php echo e(__('Employee Salary')); ?></div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">

                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between w-100">
                                    <h4><?php echo e(__('Employee Salary')); ?></h4>

                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped mb-0" id="dataTable1">
                                        <thead>
                                            <tr>
                                                <th><?php echo e(__('Name')); ?></th>
                                                <th><?php echo e(__('Payroll Month')); ?></th>
                                                <th><?php echo e(__('Salary')); ?></th>
                                                <th><?php echo e(__('Net Salary')); ?></th>
                                                <th><?php echo e(__('Status')); ?></th>
                                                <th class="" width="200px"><?php echo e(__('Action')); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php $__currentLoopData = $payslip; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payslip): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e(!empty(\App\PaySlip::employee($payslip->employee_id))? \App\PaySlip::employee($payslip->employee_id)->name: ''); ?>

                                                    </td>
                                                    <td><?php echo e($payslip->salary_month); ?></td>
                                                    <td><?php echo e($payslip->basic_salary); ?></td>
                                                    <td><?php echo e($payslip->net_payble); ?></td>
                                                    <td>
                                                        <?php if($payslip->status == 1): ?>
                                                            <div class="badge badge-success"><a
                                                                    class="text-white"><?php echo e(__('Paid')); ?></a></div>
                                                        <?php else: ?>
                                                            <div class="badge badge-danger"><a
                                                                    class="text-white"><?php echo e(__('Unpaid')); ?></a></div>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <a href="#"
                                                            data-url="<?php echo e(route('payslip.showemployee', $payslip->id)); ?>"
                                                            class="btn btn-sm btn-warning btn-round btn-icon"
                                                            data-ajax-popup="true"
                                                            data-title="<?php echo e(__('View Employee Detail')); ?>"
                                                            data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                            title="<?php echo e(__('View Employee Detail')); ?>">
                                                            <?php echo e(__('View')); ?>

                                                        </a>
                                                        <a href="#"
                                                            data-url="<?php echo e(route('payslip.pdf', [$payslip->employee_id, $payslip->salary_month])); ?>"
                                                            data-size="md-pdf"
                                                            class="btn btn-sm btn-info btn-round btn-icon"
                                                            data-ajax-popup="true"
                                                            data-title="<?php echo e(__('Payslip')); ?>"
                                                            data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                            title="<?php echo e(__('Payslip')); ?>">
                                                            <?php echo e(__('Payslip')); ?>

                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\joki\codecanyon-iMuwzIOg-hrmgo-saas-hrm-and-payroll-tool\hr\newhrsystem\resources\views\payslip\employeepayslip.blade.php ENDPATH**/ ?>