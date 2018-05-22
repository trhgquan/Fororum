<?php if(!$edit): ?>
	<?php $__env->startSection('title', $content['user_content']->username); ?>
	<?php $__env->startSection('extracss'); ?>
		legend>h1>small { font-style: italic; font-size: 50%; }
	<?php $__env->stopSection(); ?>
<?php else: ?> <?php $__env->startSection('title', 'Chỉnh sửa người dùng'); ?>
<?php endif; ?>

<?php $__env->startSection('navbar_item'); ?>
	<?php if(!$edit): ?>
		<?php echo $__env->make('forms.search-profile-form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<?php endif; ?>
	<?php echo $__env->make('items.dropdown-items', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
	<?php if(!$edit): ?>
		<div class="row">
			<div class="col-md-12">
				<legend>
						<h1><?php echo e($content['user_content']->username); ?>

						<small><?php echo e(App\UserInformation::userBrandLevels($content['user_content']->id)); ?></small>
					</h1>
				</legend>
			</div>
			<!-- 3 cột, cột đầu là forum statistics, cột sau là user information, cột cuối cùng là user action -->
			<?php if(!App\UserInformation::userPermissions($content['user_content']->id)['banned']): ?>
				<div class="col-md-4">
					<p>Tổng số chủ đề đã tạo: <b><?php echo e($content['history']['threads']->count()); ?></b></p>
					<p>Tổng số bài đăng trên diễn đàn: <b><?php echo e($content['history']['posts']->count()); ?></b></p>
					<a href="#">tìm tất cả các chủ đề, bài đăng của <?php echo e($content['user_content']->username); ?></a>
				</div>

				<div class="col-md-4">
					<p>Email liên hệ: <b><?php echo e($content['user_content']->email); ?></b></p>
					<p>Tham gia vào ngày <b><?php echo e(date_format($content['user_content']->created_at, 'd-m-Y')); ?></b>, <b><?php echo e(App\ForumPosts::ago($content['user_content']->created_at)); ?></b> ngày trước.</p>
					<?php if($this_profile): ?>
						<a href="<?php echo e(route('edit')); ?>">đến trang chỉnh sửa hồ sơ</a>
					<?php endif; ?>
				</div>

				<div class="col-md-4">
					<p>đã được <b><span id="1strealtime"></span></b> tài khoản đăng ký.</p>
					<p>đã đăng ký <b><span id="2ndrealtime"></span></b> tài khoản.</p>
					<?php echo $__env->make('forms.follow-form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
				</div>
			<?php endif; ?>
		</div>
	<?php else: ?>
		<?php echo $__env->make('forms.edit-profile-form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php if(!$edit): ?>
	<?php $__env->startSection('extrajs'); ?>
		<script src="<?php echo e(url('js/counter.js')); ?>"></script>
		<script type="text/javascript">
			counter(<?php echo e(App\UserFollowers::followers($content['user_content']->id)); ?>, '1strealtime', 75)
			counter(<?php echo e(App\UserFollowers::following($content['user_content']->id)); ?>, '2ndrealtime', 75)
		</script>
	<?php $__env->stopSection(); ?>
<?php endif; ?>

<?php echo $__env->make('templates.app-template', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>