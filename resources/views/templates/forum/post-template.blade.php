<div class="media">
	<div class="media-body">
		<h3 class="media-heading">
			@if (!isset($parent))
				{{ $post->title }}
			@else
				re: {{ $parent->title }}
			@endif
		</h3>

		<small>
			@if (!$single)
				<a href="{{ route('profile', ['username' => App\User::username($post->user_id)]) }}">{{ App\User::username($post->user_id) }}</a>, <a href="{{ route('post', ['post_id' => $post->post_id]) }}"> {{ date_format($post->created_at, 'd/m/Y H:m:s') }} </a>
			@else
				{{ App\User::username($post->user_id) }}, {{ date_format($post->created_at, 'd/m/Y H:m:s') }}
			@endif
		</small>
		<p>
			{{ $post->content }}
		</p>
	</div>
</div>
