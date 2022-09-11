<div class="col-lg-12 col-md-12 col-xl-12">

    <dl class="row p-3">
        <dt class="col-sm-4 col-md-4 col-lg-4 col-xl-4"><span class="h6 text-sm mb-0"><?php echo e(__('Name')); ?></span></dt>
        <dd class="col-sm-8 col-md-8 col-lg-8 col-xl-8"><span class="text-sm"><?php echo e($ZoomMeeting->title); ?></span></dd>


        <dt class="col-sm-4 col-md-4 col-lg-4 col-xl-4"><span class="h6 text-sm mb-0"><?php echo e(__('Meeting Id')); ?></span>
        </dt>
        <dd class="col-sm-8 col-md-8 col-lg-8 col-xl-8"><span class="text-sm"><?php echo e($ZoomMeeting->meeting_id); ?></span></dd>


        <dt class="col-sm-4 col-md-4 col-lg-4 col-xl-4"><span class="h6 text-sm mb-0"><?php echo e(__('User')); ?></span></dt>
        <dd class="col-sm-8 col-md-8 col-lg-8 col-xl-8"><span
                class="text-sm"><?php echo e(!empty($ZoomMeeting->getUserInfo) ? $ZoomMeeting->getUserInfo->name : ''); ?></span>
        </dd>

        <dt class="col-sm-4 col-md-4 col-lg-4 col-xl-4"><span class="h6 text-sm mb-0"><?php echo e(__('Start Date')); ?></span>
        </dt>
        <dd class="col-sm-8 col-md-8 col-lg-8 col-xl-8"><span
                class="text-sm"><?php echo e(\Auth::user()->dateFormat($ZoomMeeting->start_date)); ?></span>
        </dd>

        <dt class="col-sm-4 col-md-4 col-lg-4 col-xl-4"><span class="h6 text-sm mb-0"><?php echo e(__('Duration')); ?></span>
        </dt>
        <dd class="col-sm-8 col-md-8 col-lg-8 col-xl-8"><span class="text-sm"><?php echo e($ZoomMeeting->duration); ?></span></dd>

        <dt class="col-sm-4 col-md-4 col-lg-4 col-xl-4"><span class="h6 text-sm mb-0"><?php echo e(__('Start URl')); ?></span>
        </dt>
        <dd class="col-sm-8 col-md-8 col-lg-8 col-xl-8"><span class="text-sm">
                <?php if($ZoomMeeting->created_by == \Auth::user()->id && $ZoomMeeting->checkDateTime()): ?>
                   
                        <a href="<?php echo e($ZoomMeeting->start_url); ?>" class="text-secondary">
                            <p class="mb-0"><b><?php echo e(__('Start meeting')); ?></b> <i
                                    class="ti ti-external-link"></i></p>
                        </a>
                <?php elseif($ZoomMeeting->checkDateTime()): ?>
                    <a href="<?php echo e($ZoomMeeting->join_url); ?>" class="text-secondary">
                        <p class="mb-0"><b><?php echo e(__('Join meeting')); ?></b> <i
                                class="ti ti-external-link"></i></p>
                    </a>
                <?php else: ?>
                    -
                <?php endif; ?>
            </span></dd>

        <dt class="col-sm-4 col-md-4 col-lg-4 col-xl-4"><span class="h6 text-sm mb-0"><?php echo e(__('Status')); ?></span>
        </dt>
        <dd class="col-sm-8 col-md-8 col-lg-8 col-xl-8">
    
            <?php if($ZoomMeeting->checkDateTime()): ?>
                <?php if($ZoomMeeting->status == 'waiting'): ?>
                    <span class="badge bg-info p-2 px-3 rounded"><?php echo e(ucfirst($ZoomMeeting->status)); ?></span>
                <?php else: ?>
                    <span class="badge bg-success p-2 px-3 rounded"><?php echo e(ucfirst($ZoomMeeting->status)); ?></span>
                <?php endif; ?>
            <?php else: ?>
                <span class="badge bg-danger p-2 px-3 rounded"><?php echo e(__('End')); ?></span>
            <?php endif; ?>

        </dd>

    </dl>

</div>
<?php /**PATH D:\joki\codecanyon-iMuwzIOg-hrmgo-saas-hrm-and-payroll-tool\hr\newhrsystem\resources\views\zoom_meeting\view.blade.php ENDPATH**/ ?>