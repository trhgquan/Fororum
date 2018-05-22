<?php $__env->startSection('title', $category_name); ?>

<?php $__env->startSection('forum-content'); ?>
	<a href="<?php echo e(route('forum')); ?>">Quay lại sảnh chính</a>
	<h3 class="page-title">các chủ đề trong <?php echo e($category_name); ?></h3>
	<?php $__currentLoopData = $category_posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		<?php $__env->startComponent('templates.media-template', [
			'url' => route('thread', ['thread_id' => $post->posts_id]), 
			'display_text' => $post->title, 
			'display_small' => $post->created_at,
			'display_content' => 'by ' . App\User::username($post->user_id)
			]); ?>
		<?php echo $__env->renderComponent(); ?>
	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('forum.forum-root-template', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>