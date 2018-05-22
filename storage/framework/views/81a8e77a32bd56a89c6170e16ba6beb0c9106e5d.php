<?php $__env->startSection('title', 'Đăng ký'); ?>

<?php $__env->startSection('navbar_item'); ?>
	<li><a href="<?php echo e(route('login')); ?>">Đăng nhập</a></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
	<?php echo $__env->make('forms.register-form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('templates.app-template', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>