<?php $__env->startSection('title', 'Diễn đàn'); ?>

<?php $__env->startSection('navbar-brand'); ?>
	<a href="<?php echo e(route('forum')); ?>" class="navbar-brand"><?php echo e(config('app.name')); ?> <small>forum</small></a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('navbar_item'); ?>
	<?php if(Auth::check()): ?>
		<?php echo $__env->make('forms.search-forum-form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
		<?php echo $__env->make('items.dropdown-items', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<?php else: ?>
		<li><a href="<?php echo e(route('login')); ?>">Đăng nhập</a></li>
		<li><a href="<?php echo e(route('register')); ?>">Đăng ký</a></li>
	<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
	<?php if($errors->has('errors')): ?>
		<?php $__env->startComponent('templates.alert-template', [
			'alert_class' => 'danger',
			'alert_title' => 'Lỗi',
			'alert_content' => $errors->first('errors')
		]); ?>
		<?php echo $__env->renderComponent(); ?>
	<?php endif; ?>
	<?php echo $__env->make('items.breadcrumb-items', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<?php echo $__env->yieldContent('forum-content'); ?>
	<?php echo $__env->yieldContent('create-post'); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('templates.app-template', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>