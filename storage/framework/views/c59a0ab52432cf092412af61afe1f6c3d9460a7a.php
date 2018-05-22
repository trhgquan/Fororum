<?php $__env->startSection('title', 'Diễn đàn'); ?>

<?php $__env->startSection('navbar_item'); ?>
	<?php echo $__env->make('items.dropdown-items', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
	<?php $__currentLoopData = $records; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categories): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		<?php $__env->startComponent('templates.media-template', ['url' => route('forum', [$categories->id]),'display_text' => $categories->title,'display_small' => $categories->description]); ?>
		<?php echo $__env->renderComponent(); ?>
	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('templates.app-template', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>