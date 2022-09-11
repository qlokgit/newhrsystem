<div class="favorite-list-item">
     <?php if(!empty($user->avatar)): ?>
    <div data-id="<?php echo e($user->id); ?>" data-action="0" class="avatar av-m" 
        style="background-image: url('<?php echo e(asset('/storage/'.config('chatify.user_avatar.folder').'/'.$user->avatar)); ?>');">
    </div>
     <?php else: ?>
        <div data-id="<?php echo e($user->id); ?>" data-action="0" class="avatar av-m"
             style="background-image: url('<?php echo e(asset('/storage/'.config('chatify.user_avatar.folder').'/avatar.png')); ?>') !important;">
        </div>
    <?php endif; ?>
    <p><?php echo e(strlen($user->name) > 5 ? substr($user->name,0,6).'..' : $user->name); ?></p>
</div>
<?php /**PATH D:\joki\codecanyon-iMuwzIOg-hrmgo-saas-hrm-and-payroll-tool\hr\newhrsystem\resources\views\vendor\Chatify\layouts\favorite.blade.php ENDPATH**/ ?>