<?php $__env->startSection('title', $category_name); ?>

<?php $__env->startSection('forum-content'); ?>
	<legend>các chủ đề trong <?php echo e($category_name); ?></legend>
	<?php $__env->startSection('breadcrumb_content'); ?>
		<li><a href="<?php echo e(route('forum')); ?>">forum</a></li>
		<li class="active"><?php echo e($category_name); ?></li>
	<?php $__env->stopSection(); ?>
	<?php if($category_threads->total() > 0): ?>
		<?php $__currentLoopData = $category_threads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<?php $__env->startComponent('templates.forum.thread-template', ['thread' => $post]); ?>
			<?php echo $__env->renderComponent(); ?>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		<?php echo e($category_threads->links()); ?>

	<?php else: ?>
		là người đầu tiên tạo 1 chủ đề trong <?php echo e($category_name); ?>

	<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('create-post'); ?>
	<?php if(Auth::check()): ?>
		<?php echo $__env->make('forms.create-post-form', [
			'parent' => 0,
			'thread' => true
		], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<?php else: ?>
		đăng nhập để tạo 1 chủ đề mới trong <?php echo e($category_name); ?>

	<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('templates.forum.forum-template', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>