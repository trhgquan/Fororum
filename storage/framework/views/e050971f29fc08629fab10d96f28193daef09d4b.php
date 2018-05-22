<div class="media">
	<div class="media-body">
		<h3 class="media-heading">
			<a href="<?php echo e(route('thread', ['thread_id' => $thread->post_id])); ?>"><?php echo e($thread->title); ?></a>
		</h3>
		<small style="font-style: italic;">
			<?php echo e(App\User::username($thread->user_id)); ?>,<?php echo e(date_format($thread->created_at, 'd/m/Y H:m:s')); ?>

		</small>
	</div>
</div>
