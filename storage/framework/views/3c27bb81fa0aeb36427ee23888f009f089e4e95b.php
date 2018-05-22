<div class="media">
	<div class="media-body">
		<h3 class="media-heading">
			<?php if(isset($url, $display_url) && !empty($url) && !empty($display_url)): ?>
				<a href="<?php echo e($url); ?>"><?php echo e($display_url); ?></a>
			<?php endif; ?>
			<?php if(isset($display_text) && !empty($display_text)): ?>
				<p><?php echo e($display_text); ?></p>
			<?php endif; ?>
		</h3>
		<?php if(isset($display_small) && !empty($display_small)): ?>
			<small><i><?php echo e($display_small); ?></i></small>
		<?php endif; ?>
		<?php if(isset($display_content) && !empty($display_content)): ?>
			<p class="media-content"><?php echo e($display_content); ?></p>
		<?php endif; ?>
	</div>
</div>