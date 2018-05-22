<div class="media">
	<div class="media-body">
		<h3 class="media-heading">
			<a href="{{ route('category', ['forum_category' => $media->keyword]) }}">{{ $media->title }}</a>
		</h3>
		<small>{{ $media->description }}</small>
	</div>
</div>
