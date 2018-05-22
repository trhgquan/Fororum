<li class="dropdown">
	<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo e(Auth::user()->username); ?> <span class="caret"></span></a>
	<ul class="dropdown-menu">
		<li><a href="<?php echo e(url('/user/profile')); ?>">Trang hồ sơ</a></li>
		<li><a href="<?php echo e(route('edit')); ?>">Chỉnh sửa thông tin</a></li>
		<li role="separator" class="divider"></li>
		<li><a href="<?php echo e(route('logout')); ?>">Đăng xuất</a></li>
	</ul>
</li>
