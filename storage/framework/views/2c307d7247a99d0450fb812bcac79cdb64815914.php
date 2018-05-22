<?php $__env->startSection('forum-content'); ?>
	<?php $__env->startSection('breadcrumb_content'); ?>
		<li class="active">forum</li>
		<li></li>
	<?php $__env->stopSection(); ?>
	<legend>sảnh chính</legend>
	<?php $__currentLoopData = $records; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categories): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		<?php $__env->startComponent('templates.forum.category-template', [
			'media' => $categories
		]); ?>
		<?php echo $__env->renderComponent(); ?>
	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('templates.forum.forum-template', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>