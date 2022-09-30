

<?php $__env->startSection('content'); ?>
<div class="col-11 col-xl-6 py-5 mx-auto ml-md-0">
  <h4 class="text-primary font-weight-normal mb-1"><strong><?php echo e(__('Confirm Password')); ?></strong></h4>
  <span><?php echo e(__('Please confirm your password before continuing.')); ?></span>
  <form action="<?php echo e(route('password.confirm')); ?>" method="POST" class="pt-3 text-left needs-validation" novalidate="">
    <?php echo csrf_field(); ?>
    <label class="d-block position-relative mb-3">
      <p class="text-sm mb-2"><?php echo e(__('Password')); ?></p>
      <input type="password" id="password" name="password"  class="text-sm rounded-6 w-100 py-3 px-3 border text-grayDark <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" >
      <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <span class="invalid-feedback" role="alert">
            <small><?php echo e($message); ?></small>
        </span>
      <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </label>             
    <button type="submit" class="btn-primary px-4 py-2 text-xs"><span class="d-block py-1"><?php echo e(__('Confirm Password')); ?></span></button>
    <?php if(Route::has('password.request')): ?>
        <a class="text-xs text-muted text-center" href="<?php echo e(route('password.request')); ?>">
            <?php echo e(__('Forgot Your Password?')); ?>

        </a>
    <?php endif; ?>
  </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\joki\codecanyon-iMuwzIOg-hrmgo-saas-hrm-and-payroll-tool\hr\newhrsystem\resources\views\auth\confirm-password.blade.php ENDPATH**/ ?>