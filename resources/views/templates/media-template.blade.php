<div class="media">
	<div class="media-body">
		<h3 class="media-heading">
			@if (isset($url, $display_url) && !empty($url) && !empty($display_url))
				<a href="{{ $url }}">{{ $display_url }}</a>
			@endif
			@if (isset($display_text) && !empty($display_text))
				<p>{{ $display_text }}</p>
			@endif
		</h3>
		@if (isset($display_small) && !empty($display_small))
			<small><i>{{ $display_small }}</i></small>
		@endif
		@if (isset($display_content) && !empty($display_content))
			<p class="media-content">{{ $display_content }}</p>
		@endif
	</div>
</div>