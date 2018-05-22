<div class="media">
	<div class="media-body">
		<h3 class="media-heading">
			<?php if(!isset($parent)): ?>
				<?php echo e($post->title); ?>

			<?php else: ?>
				re: <?php echo e($parent->title); ?>

			<?php endif; ?>
		</h3>

		<small>
			<?php if(!$single): ?>
				<a href="<?php echo e(route('profile', ['username' => App\User::username($post->user_id)])); ?>"><?php echo e(App\User::username($post->user_id)); ?></a>, <a href="<?php echo e(route('post', ['post_id' => $post->post_id])); ?>"> <?php echo e(date_format($post->created_at, 'd/m/Y H:m:s')); ?> </a>
			<?php else: ?>
				<?php echo e(App\User::username($post->user_id)); ?>, <?php echo e(date_format($post->created_at, 'd/m/Y H:m:s')); ?>

			<?php endif; ?>
		</small>
		<p>
			<?php echo e($post->content); ?>

		</p>
	</div>
</div>
