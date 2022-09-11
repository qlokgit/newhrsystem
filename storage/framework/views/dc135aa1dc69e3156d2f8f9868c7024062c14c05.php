<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<body>
    Halo <?php echo e($leave['employee']->name); ?>

    <p>
       <b><?php echo e($leave['leave']['employees']['name']); ?></b> meminta persutujuan cuti dari anda
       <p>silahkan approve status cuti di dashboard</p>
       <p><a href="<?php echo e(route('home')); ?>">Masuk</a></p>
    </p>
</body>
</html><?php /**PATH D:\joki\codecanyon-iMuwzIOg-hrmgo-saas-hrm-and-payroll-tool\hr\newhrsystem\resources\views/email/approved_leave.blade.php ENDPATH**/ ?>