<html>
	<head>
		<title>MyApp - <?php echo $__env->yieldContent('title'); ?></title>
		<link rel="stylesheet" type="text/css" href="<?php echo e(url('css/bootstrap.min.css')); ?>">
	</head>
	<body>
		<?php $__env->startSection('sidebar'); ?>
			<nav class="navbar navbar-default">
				<div class="container-fluid">
					<a class="navbar-brand" href="#"><?php echo e(config('app.name')); ?></a>
				</div>
			</nav>
		<?php echo $__env->yieldSection(); ?>

		<div class="container">
			<?php echo $__env->yieldContent('content'); ?>
		</div>
	</body>
</html>