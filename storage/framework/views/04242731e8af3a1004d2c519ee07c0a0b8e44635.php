

<?php $__env->startSection('page-title'); ?>
   <?php echo e(__('Ticket Reply')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>"><?php echo e(__('Home')); ?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo e(url('ticket')); ?>"><?php echo e(__('Ticket')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Ticket Reply')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('action-button'); ?>
<?php if(\Auth::user()->type == 'company' || $ticket->ticket_created == \Auth::user()->id): ?>
        <a href="#" data-url="<?php echo e(URL::to('ticket/' . $ticket->id . '/edit')); ?>" data-ajax-popup="true"
            data-title="<?php echo e(__('Edit Ticket')); ?>" data-size="lg" data-bs-toggle="tooltip" title=""
            class="btn btn-sm btn-info" data-bs-original-title="<?php echo e(__('Edit')); ?>">
            <i class="ti ti-pencil"></i>
        </a>
        <?php endif; ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
    <div class="col-md-6">
        <?php $__currentLoopData = $ticketreply; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reply): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="card">
                <ul class="list-group team-msg">
                    <div class="card-header d-flex justify-content-between">
                        <h5> <?php echo e(!empty(\Auth::user()->getUser($reply->created_by)) ? \Auth::user()->getUser($reply->created_by)->name : ''); ?>

                        </h5>
                        <span><?php echo e($reply->created_at->diffForHumans()); ?></span>
                    </div>
                    <div class="card-body">
                        <p><?php echo e($reply->description); ?> </p>
                    </div>

                </ul>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <?php if($ticket->status == 'open'): ?>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5> <?php echo e(__('Support Reply')); ?></h5>
                </div>
                <?php echo e(Form::open(['url' => 'ticket/changereply', 'method' => 'post'])); ?>

                <li class="list-group-item border-0 d-flex align-items-center">
                    <div class="avatar me-3">
                        <?php if(Auth::user()->avatar == ''): ?>
                            <img src="<?php echo e(asset('assets/images/user/avatar-2.jpg')); ?>" alt="kal" class="img-user">
                        <?php endif; ?>
                    </div>
                    <input type="hidden" value="<?php echo e($ticket->id); ?>" name="ticket_id">
                    <div class="form-group mb-0 form-send w-100">
                        <?php echo e(Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => __('Ticket Reply')])); ?>

                        <button class="btn btn-send" type="submit"><i
                                class="f-16 text-primary ti ti-brand-telegram"></i></button>
                    </div>
                </li>
                <?php echo e(Form::close()); ?>

            </div>
        </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\joki\codecanyon-iMuwzIOg-hrmgo-saas-hrm-and-payroll-tool\hr\newhrsystem\resources\views\ticket\reply.blade.php ENDPATH**/ ?>