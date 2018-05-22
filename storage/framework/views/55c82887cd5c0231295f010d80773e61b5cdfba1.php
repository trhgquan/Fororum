<?php $__env->startSection('forum-content'); ?>
	<?php if(isset($thread) && $thread): ?>
		<?php $__env->startSection('title', 'chủ đề: ' . $content['thread']->title); ?>
		<?php $__env->startSection('breadcrumb_content'); ?>
			<li><a href="<?php echo e(route('forum')); ?>">forum</a></li>
			<li><a href="<?php echo e(route('category', ['category' => App\ForumCategories::Category($content['thread']->category_id)->keyword ])); ?>"><?php echo e(App\ForumCategories::Category($content['thread']->category_id)->title); ?></a></li>
			<li><?php echo e($content['thread']->title); ?></li>
		<?php $__env->stopSection(); ?>
		<?php $__env->startComponent('templates.forum.post-template',[
			'post' => $content['thread'],
			'single' => false
		]); ?>
		<?php echo $__env->renderComponent(); ?>
		<legend>trả lời</legend>
		<?php if($content['posts']->count() > 0): ?>
			<?php $__currentLoopData = $content['posts']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<?php $__env->startComponent('templates.forum.post-template', [
					'post'   => $post,
					'parent' => $content['thread'],
					'single' => false
				]); ?>
				<?php echo $__env->renderComponent(); ?>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		<?php else: ?>
			trở thành người đầu tiên bình luận về <?php echo e($content['thread']->title); ?>.
		<?php endif; ?>
		<?php $__env->startSection('create-post'); ?>
			<?php if(Auth::check()): ?>
				<?php echo $__env->make('forms.create-post-form', [
					'parent' => (isset($thread) && !empty($thread)) ? $content['thread']->post_id : 0,
					'thread' => false
				], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
			<?php else: ?>
				đăng nhập để bình luận về chủ đề "<?php echo e($content['thread']->title); ?>".
			<?php endif; ?>
		<?php $__env->stopSection(); ?>
	<?php else: ?>
		<?php $__env->startSection('breadcrumb_content'); ?>
			<li><a href="<?php echo e(route('forum')); ?>">forum</a></li>
			<li><a href="<?php echo e(route('category', [
				'category' => App\ForumCategories::Category(App\ForumPosts::thread(!empty($content->parent_id) ? $content->parent_id : $content->post_id)['thread']->category_id)->keyword])); ?>"><?php echo e(App\ForumCategories::Category(App\ForumPosts::thread(!empty($content->parent_id) ? $content->parent_id : $content->post_id)['thread']->category_id)->title); ?></a></li>
			<li><a href="<?php echo e(route('thread', ['thread_id' => !empty($content->parent_id) ? $content->parent_id : $content->post_id])); ?>"><?php echo e(App\ForumPosts::thread(!empty($content->parent_id) ? $content->parent_id : $content->post_id)['thread']->title); ?></a></li>
			<li class="active"><?php echo e($content->title); ?></li>
		<?php $__env->stopSection(); ?>

		<?php $__env->startComponent('templates.forum.post-template', [
			'post'   => $content,
			'parent' => App\ForumPosts::thread($content->parent_id)['thread'],
			'single' => true
		]); ?>
		<?php echo $__env->renderComponent(); ?>
	<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('templates.forum.forum-template', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>