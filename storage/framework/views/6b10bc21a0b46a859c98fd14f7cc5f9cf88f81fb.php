<?php $__env->startSection('title', 'Đóng góp quỹ'); ?>

<?php $__env->startSection('navbar_item'); ?>
    <?php echo $__env->make('items.dropdown-items', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php echo e(App\User::profile($username)->count()); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('templates.app-template', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>