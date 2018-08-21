<form action="{{ (isset($thread) && !empty($thread)) ? route('createThread') : route('createPost') }}" method="POST" role="form">
	@if ($thread)
		<legend>Create a new thread in {{ $category_name }}</legend>

		<div class="form-group {{ ($errors->has('title')) ? 'has-error' : '' }}">
			<label class="control-label" for="title">Title:</label>
			<input type="text" class="form-control" id="title" name="title" placeholder="Title" value="{{ old('title') }}" required>

			@if ($errors->has('title'))
				<span class="help-block">{{ $errors->first('title') }}</span>
			@endif
		</div>
	@else
		<legend>Post a reply</legend>
	@endif

	<div class="form-group {{ ($errors->has('content')) ? 'has-error' : '' }}">
		<label class="control-label" for="content">Content:</label>
		<textarea id="content" name="content" class="form-control" placeholder="Content" required></textarea>

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

	<button type="submit" class="btn btn-primary pull-right">Post</button>
</form>
