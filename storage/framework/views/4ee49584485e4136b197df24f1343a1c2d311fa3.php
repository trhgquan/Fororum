<?php $__env->startSection('title', 'Trang chủ'); ?>

<?php if(!Auth::check()): ?>
	<?php $__env->startSection('navbar_item'); ?>
		<li><a href="<?php echo e(route('login')); ?>">Đăng nhập</a></li>
		<li><a href="<?php echo e(route('register')); ?>">Đăng ký</a></li>
	<?php $__env->stopSection(); ?>
<?php else: ?>
	<?php $__env->startSection('navbar_item'); ?>
		<?php echo $__env->make('items.dropdown-items', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<?php $__env->stopSection(); ?>
<?php endif; ?>

<?php $__env->startSection('content'); ?>
	<div class="jumbotron">
		<?php if(Auth::check()): ?>
			<h1>Chào <?php echo e(Auth::user()->username); ?>!</h1>
			<p>Chỉ người dùng đã đăng nhập mới có thể thấy nội dung này.</p>
			<a href="<?php echo e(route('forum')); ?>">vào diễn đàn</a>
		<?php else: ?>
			<h1 class="page-title"><?php echo e(config('app.name')); ?> <small>The first and only <?php echo e(config('app.name')); ?></small></h1>
			<p>Đã có <span id="realtime">0</span> người dùng tham gia!</p>
		<?php endif; ?>
	</div>
<?php $__env->stopSection(); ?>

<?php if(!Auth::check()): ?>
	<?php $__env->startSection('extrajs'); ?>
		<script src="<?php echo e(url('js/counter.js')); ?>"></script>
		<script type="text/javascript">counter(<?php echo e(App\User::count()); ?>, 'realtime', 75)</script>
	<?php $__env->stopSection(); ?>
<?php endif; ?>

<?php echo $__env->make('templates.app-template', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>