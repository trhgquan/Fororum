<html>
	<head>
		<title>MyApp - <?php echo $__env->yieldContent('title'); ?></title>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="<?php echo e(url('css/bootstrap.min.css')); ?>">
		<link rel="stylesheet" type="text/css" href="<?php echo e(url('css/main.css')); ?>">
		<style type="text/css">
			<?php echo $__env->yieldContent('extracss'); ?>
		</style>
	</head>
	<body>
		<?php $__env->startSection('navbar'); ?>
		<nav class="navbar navbar-default navbar-fixed-top">
			<div class="container-fluid">
				<div class="navbar-header">
					<?php $__env->startSection('navbar-brand'); ?>
						<a href="<?php echo e(url('/')); ?>" class="navbar-brand"><?php echo e(config('app.name')); ?></a>
					<?php echo $__env->yieldSection(); ?>
				</div>

				<ul class="nav navbar-nav navbar-right">
					<?php echo $__env->yieldContent('navbar_item'); ?>
				</ul>
			</div>
		</nav>
		<?php echo $__env->yieldSection(); ?>

		<div class="container">
			<?php echo $__env->yieldContent('content'); ?>
		</div>

		<script src="<?php echo e(url('js/jquery.js')); ?>"></script>
		<script src="<?php echo e(url('js/bootstrap.min.js')); ?>"></script>
		
		<?php echo $__env->yieldContent('extrajs'); ?>
	</body>

	<footer>
		<div class="navbar navbar-default navbar-fixed-bottom">
			<div class="container">
				<div class="navbar">
					<p class="navbar-text">Bản quyền bởi <strong><?php echo e(config('app.name')); ?></strong> &copy; <?php echo date('Y') ?>. Mọi quyền được bảo lưu.</p>
				</div>
			</div>
		</div>
	</footer>
</html>
