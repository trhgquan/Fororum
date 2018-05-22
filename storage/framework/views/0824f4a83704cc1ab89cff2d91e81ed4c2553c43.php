<?php $__env->startSection('title', 'Diễn đàn'); ?>

<?php $__env->startSection('navbar_item'); ?>
	<?php if(Auth::check()): ?>
		<?php echo $__env->make('items.dropdown-items', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<?php else: ?>
		<li><a href="<?php echo e(route('login')); ?>">Đăng nhập</a></li>
		<li><a href="<?php echo e(route('register')); ?>">Đăng ký</a></li>
	<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
	<?php echo $__env->yieldContent('forum-content'); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('templates.app-template', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>