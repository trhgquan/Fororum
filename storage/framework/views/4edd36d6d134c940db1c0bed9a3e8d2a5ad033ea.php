<form action="<?php echo e((isset($thread) && !empty($thread)) ? route('createThread') : route('createPost')); ?>" method="POST" role="form">
	<?php if($thread): ?>
		<legend>tạo chủ đề mới trong <?php echo e($category_name); ?></legend>

		<div class="form-group <?php echo e(($errors->has('title')) ? 'has-error' : ''); ?>">
			<label class="control-label" for="title">tiêu đề bài viết</label>
			<input type="text" class="form-control" id="title" name="title" placeholder="tiêu đề bài viết" value="<?php echo e(old('title')); ?>" required>

			<?php if($errors->has('title')): ?>
				<span class="help-block"><?php echo e($errors->first('title')); ?></span>
			<?php endif; ?>
		</div>
	<?php else: ?>
		<legend>đăng trả lời</legend>
	<?php endif; ?>

	<div class="form-group <?php echo e(($errors->has('content')) ? 'has-error' : ''); ?>">
		<label class="control-label" for="content">nội dung bài viết</label>
		<textarea id="content" name="content" class="form-control" placeholder="nội dung bài viết" required></textarea>

		<?php if($errors->has('content')): ?>
			<span class="help-block"><?php echo e($errors->first('content')); ?></span>
		<?php endif; ?>
	</div>

	<?php if(isset($thread) && !empty($thread)): ?>
		<input type="hidden" name="category" value="<?php echo e($category_id); ?>">
	<?php else: ?>
		<input type="hidden" name="parent" value="<?php echo e($parent); ?>">
	<?php endif; ?>

	<?php echo csrf_field(); ?>

	<button type="submit" class="btn btn-primary pull-right">đăng</button>
</form>
