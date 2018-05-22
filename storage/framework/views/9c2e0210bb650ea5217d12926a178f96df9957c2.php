<?php $__env->startSection('title', (isset($keyword)) ? 'Kết quả tìm kiếm cho ' . $keyword : 'Tìm kiếm'); ?>
<?php $__env->startSection('extracss'); ?>
	h3 > small
	{
		font-style: italic;
	}
<?php $__env->stopSection(); ?>

<?php $__env->startSection('navbar-brand'); ?>
	<a href="<?php echo e(url('/')); ?>" class="navbar-brand"><?php echo e(config('app.name')); ?> <small>search</small></a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('navbar_item'); ?>
	<?php if(isset($users)): ?>
		<?php echo $__env->make('forms.search-profile-form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<?php elseif(isset($posts)): ?>
		<?php echo $__env->make('forms.search-forum-form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<?php endif; ?>
	<?php echo $__env->make('items.dropdown-items', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
	<?php if($errors->has('keyword')): ?>
		<?php echo e($errors->first('keyword')); ?>

	<?php endif; ?>
	<?php if(isset($users) && !empty($users) && !$errors->has('keyword')): ?>
		<p>Bạn đã tìm kiếm <b><?php echo e($keyword); ?></b> và có <b><?php echo e($users->total()); ?></b> người được tìm thấy.</p>

		<?php if($users->total() > 0): ?>
			<?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<h3><a href="<?php echo e(route('profile', [$user->username])); ?>"><?php echo e($user->username); ?></a> <small><?php echo e(App\UserInformation::userBrandLevels($user->id)); ?></small></h3>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			<?php if($users->total() > 1): ?>
				<?php echo e($users->links()); ?>

			<?php endif; ?>
		<?php endif; ?>
	<?php elseif(isset($posts) && !empty($posts) && !$errors->has('keyword')): ?>
		<p>Bạn đã tìm kiếm <b><?php echo e($keyword); ?></b> và có <b><?php echo e($posts->total()); ?></b> post được tìm thấy.</p>
		<?php if($posts->total() > 0): ?>
			<?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<?php $__env->startComponent('templates.media-template', [
					'url' => route('post', ['id' => $post->post_id]),
					'display_url' => $post->title,
					'display_small' => 'đăng bởi ' . App\User::username($post->user_id) . ' vào lúc ' . date_format($post->created_at, 'H:m:s A, d-m-Y'),
				]); ?>
				<?php echo $__env->renderComponent(); ?>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			<?php if($posts->total() > 1): ?>
				<?php echo e($posts->links()); ?>

			<?php endif; ?>
		<?php endif; ?>
	<?php else: ?>
		<h3 class="page-title">
			tìm kiếm một
			<?php if(isset($users)): ?>
				ai đó
			<?php elseif(isset($posts)): ?>
				chủ đề / bài viết
			<?php endif; ?>
		</h3>
	<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('templates.app-template', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>