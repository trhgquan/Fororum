<?php if(!$this_profile): ?>
    <form action="<?php echo e(route('follow', ['username' => $content['user_content']->username])); ?>" method="POST">
        <input type="hidden" name="uid" value="<?php echo e($content['user_content']->id); ?>">
        <?php echo csrf_field(); ?>
        <?php if(!App\UserFollowers::is_followed(Auth::id(), $content['user_content']->id)): ?>
            <button type="submit" class="btn btn-primary">đăng ký</button>
        <?php else: ?>
            <button type="submit" class="btn btn-danger">huỷ đăng ký</button>
        <?php endif; ?>
    </form>
<?php endif; ?>
