 <div class="modal-body">
    <div class="table-responsive">
        <table class="table table-bordered ">
            <tbody>
                <tr>
                    <td class="text-dark fw-bold"><?php echo e(__('Company')); ?></td>
                    <td style="display: table-cell;"> <?php echo e(!empty($trainer->branches) ? $trainer->branches->name : ''); ?>

                    </td>
                </tr>
                <tr>
                    <td class="text-dark fw-bold"><?php echo e(__('First Name')); ?></td>
                    <td style="display: table-cell;"><?php echo e($trainer->firstname); ?></td>
                </tr>
                <tr>
                    <td class="text-dark fw-bold"><?php echo e(__('Last Name')); ?></td>
                    <td style="display: table-cell;"><?php echo e($trainer->lastname); ?></td>
                </tr>
                <tr>
                    <td class="text-dark fw-bold"><?php echo e(__('Contact Number')); ?></td>
                    <td style="display: table-cell;"><?php echo e($trainer->contact); ?></td>
                </tr>
                <tr>
                    <td class="text-dark fw-bold"><?php echo e(__('Email')); ?></td>
                    <td style="display: table-cell;"><?php echo e($trainer->email); ?></td>
                </tr>
                <tr>
                    <td class="text-dark fw-bold"><?php echo e(__('Expertise')); ?></td>
                    <td style="display: table-cell;"><?php echo e($trainer->expertise); ?></td>
                </tr>
                <tr>
                    <td class="text-dark fw-bold"><?php echo e(__('Address')); ?></td>
                    <td style="display: table-cell;"><?php echo e($trainer->address); ?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div> 


<?php /**PATH D:\joki\codecanyon-iMuwzIOg-hrmgo-saas-hrm-and-payroll-tool\hr\newhrsystem\resources\views\trainer\show.blade.php ENDPATH**/ ?>