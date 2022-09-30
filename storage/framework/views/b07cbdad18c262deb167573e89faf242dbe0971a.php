

<?php $__env->startSection('content'); ?>
<div class="col-11 col-xl-6 py-5 mx-auto ml-md-0">
  <h4 class="text-primary font-weight-normal mb-1"><strong><?php echo e(__('Verify Your Email Address')); ?></strong></h4>
  <?php if(session('status') == 'verification-link-sent'): ?>
  <div class="alert alert-success" role="alert">
    <?php echo e(__('A fresh verification link has been sent to your email address.')); ?>

  </div>
  <?php endif; ?>
  <span><?php echo e(__('Before proceeding, please check your email for a verification link.')); ?></span>
  <span><?php echo e(__('If you did not receive the email')); ?>,</span>
  <form action="<?php echo e(route('verification.resend')); ?>" method="POST" class="pt-3 text-left needs-validation" novalidate="">
    <?php echo csrf_field(); ?>
    <button type="submit" class="btn-primary px-4 py-2 text-xs"><span class="d-block py-1"><?php echo e(__('click here to request another')); ?></span></button>
  </form>
  <form method="POST" action="<?php echo e(route('logout')); ?>">
      <?php echo csrf_field(); ?>

      <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900">
          <?php echo e(__('Log Out')); ?>

      </button>
  </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\joki\codecanyon-iMuwzIOg-hrmgo-saas-hrm-and-payroll-tool\hr\newhrsystem\resources\views\auth\verify-email.blade.php ENDPATH**/ ?>