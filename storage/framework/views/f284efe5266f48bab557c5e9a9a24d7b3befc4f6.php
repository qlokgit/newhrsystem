<div class="favorite-list-item">
    <div data-id="<?php echo e($user->id); ?>" data-action="0" class="avatar av-m"
        style="background-image: url('<?php echo e(Chatify::getUserWithAvatar($user)->avatar); ?>');">
    </div>
    <p><?php echo e(strlen($user->name) > 5 ? substr($user->name,0,6).'..' : $user->name); ?></p>
</div>
<?php /**PATH D:\joki\codecanyon-iMuwzIOg-hrmgo-saas-hrm-and-payroll-tool\hr\newhrsystem\vendor\munafio\chatify\src\views\layouts\favorite.blade.php ENDPATH**/ ?>