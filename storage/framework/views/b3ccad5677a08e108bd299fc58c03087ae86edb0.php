<?php
$logo=asset(Storage::url('uploads/logo'));
$company_favicon=Utility::getValByName('company_favicon');
?>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title><?php if(Auth::user()->type == 'super admin'): ?>  <?php echo e(config('app.name', 'Hrmgo Saas')); ?> <?php else: ?> <?php echo e((Utility::getValByName('title_text')) ? Utility::getValByName('title_text') : config('app.name', 'Hrmgo SaaS')); ?> <?php endif; ?></title>
<?php if(Auth::user()->type == 'super admin'): ?>
  <link rel="icon" href="<?php echo e($logo.'/favicon.png'); ?>" type="image" sizes="16x16">
<?php else: ?>
  <link rel="icon" href="<?php echo e((isset($company_favicon) && !empty($company_favicon)?asset(Storage::url($company_favicon)):'favicon.png')); ?>" type="image" sizes="16x16">
<?php endif; ?>
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
</head>
<?php
$plan_id= \Illuminate\Support\Facades\Crypt::decrypt($data['plan_id']);
$plandata=App\Models\Plan::find($plan_id);
?>
<script src="https://api.paymentwall.com/brick/build/brick-default.1.5.0.min.js"> </script>
<div id="payment-form-container"> </div>
<script>

var brick = new Brick({
  public_key: '<?php echo e($admin_payment_setting['paymentwall_public_key']); ?>', // please update it to Brick live key before launch your project
  amount: '<?php echo e($plandata->price); ?>',
  currency: '<?php echo e(env("CURRENCY")); ?>',
  container: 'payment-form-container',
  action: '<?php echo e(route("plan.pay.with.paymentwall",[$data["plan_id"],$data["coupon"]])); ?>',
  success_url: '<?php echo e(route("plans.index")); ?>',
  form: {
    merchant: 'Paymentwall',
    product:  '<?php echo e($plandata->name); ?>',
    pay_button: 'Pay',
    show_zip: true, // show zip code
    show_cardholder: true // show card holder name
  }
});


brick.showPaymentForm(function(data) {
    if(data.flag == 1){
        window.location.href ='<?php echo e(route("callback.error",1)); ?>';
    }else{
        window.location.href ='<?php echo e(route("callback.error",2)); ?>';
    }
    }, function(errors) {
    if(errors.flag == 1){
        window.location.href ='<?php echo e(route("callback.error",1)); ?>';
    }else{
        window.location.href ='<?php echo e(route("callback.error",2)); ?>';
    }
});

</script><?php /**PATH D:\joki\codecanyon-iMuwzIOg-hrmgo-saas-hrm-and-payroll-tool\hr\newhrsystem\resources\views\plan\paymentwall.blade.php ENDPATH**/ ?>