<html>
	<head>
		<title>MyApp - <?php echo $__env->yieldContent('title'); ?></title>
		<link rel="stylesheet" type="text/css" href="<?php echo e(url('css/bootstrap.min.css')); ?>">
		<meta charset="utf-8">
	</head>
	<body>
		<?php $__env->startSection('navbar'); ?>
		<nav class="navbar navbar-default">
			<div class="container-fluid">
				<div class="navbar-header">
					<a class="navbar-brand" href="<?php echo e(url('/')); ?>"><?php echo e(config('app.name')); ?></a>
				</div>

				<ul class="nav navbar-nav navbar-right">
					<?php if(Auth::check()): ?>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $__env->yieldContent('navbar_text'); ?> <span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li><a href="#">Trang hồ sơ</a></li>
							<li><a href="#">Chỉnh sửa thông tin</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="<?php echo e(route('logoutRoute')); ?>">Đăng xuất</a></li>
						</ul>
					</li>
					<?php else: ?>
						<?php echo $__env->yieldContent('navbar_text'); ?>
					<?php endif; ?>
				</ul>
			</div>
		</nav>
		<?php echo $__env->yieldSection(); ?>

		<div class="container">
			<?php echo $__env->yieldContent('content'); ?>
		</div>

		<script src="<?php echo e(url('js/jquery.js')); ?>"></script>
		<script src="<?php echo e(url('js/bootstrap.min.js')); ?>"></script>
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