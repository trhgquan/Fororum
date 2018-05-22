<div class="media">
	<div class="media-body">
		<h3 class="media-heading">
			<a href="<?php echo e(route('category', ['forum_category' => $media->keyword])); ?>"><?php echo e($media->title); ?></a>
		</h3>
		<small><?php echo e($media->description); ?></small>
	</div>
</div>
