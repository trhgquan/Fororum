<form action="{{ (isset($thread) && !empty($thread)) ? route('createThread') : route('createPost') }}" method="POST" role="form">
	@if ($thread)
		<legend>Tạo chủ đề mới trong {{ $category_name }}</legend>

		<div class="form-group {{ ($errors->has('title')) ? 'has-error' : '' }}">
			<label class="control-label" for="title">Tiêu đề bài viết</label>
			<input type="text" class="form-control" id="title" name="title" placeholder="tiêu đề bài viết" value="{{ old('title') }}" required>

			@if ($errors->has('title'))
				<span class="help-block">{{ $errors->first('title') }}</span>
			@endif
		</div>
	@else
		<legend>đăng trả lời</legend>
	@endif

	<div class="form-group {{ ($errors->has('content')) ? 'has-error' : '' }}">
		<label class="control-label" for="content">Nội dung bài viết</label>
		<textarea id="content" name="content" class="form-control" placeholder="nội dung bài viết" required></textarea>

		@if ($errors->has('content'))
			<span class="help-block">{{ $errors->first('content') }}</span>
		@endif
	</div>

	@if (isset($thread) && !empty($thread))
		<input type="hidden" name="category" value="{{ $category_id }}">
	@else
		<input type="hidden" name="parent" value="{{ $parent }}">
	@endif

	@csrf

	<button type="submit" class="btn btn-primary pull-right">Đăng</button>
</form>
