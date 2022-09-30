<title><?php echo e(config('chatify.name')); ?></title>


<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="route" content="<?php echo e($route); ?>">
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<!-- <meta name="url" content="<?php echo e(url('').'/'.config('chatify.routes.prefix')); ?>" data-user="<?php echo e(Auth::user()->id); ?>"> -->


<script
  src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="<?php echo e(asset('js/chatify/font.awesome.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/chatify/autosize.js')); ?>"></script>



<link rel='stylesheet' href='https://unpkg.com/nprogress@0.2.0/nprogress.css'/>
<link href="<?php echo e(asset('css/chatify/style.css')); ?>" rel="stylesheet" />
<link href="<?php echo e(asset('css/chatify/'.$dark_mode.'.mode.css')); ?>" rel="stylesheet" />
<link href="<?php echo e(asset('css/app.css')); ?>" rel="stylesheet" />


<?php echo $__env->make('Chatify::layouts.messengerColor', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /**PATH D:\joki\codecanyon-iMuwzIOg-hrmgo-saas-hrm-and-payroll-tool\hr\newhrsystem\resources\views/vendor/Chatify/layouts/headLinks.blade.php ENDPATH**/ ?>