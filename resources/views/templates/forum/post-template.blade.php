<div class="media-box">
	<div class="media">
		<div class="media-body">
			<h3 class="media-heading">
				{{ App\ForumPosts::postTitle($post->post_id) }}
			</h3>
			<small>
				@if (!$single)
					đăng bởi <a href="{{ route('profile', ['username' => App\User::username($post->user_id)]) }}">{{ App\User::username($post->user_id) }}</a>, vào lúc <a href="{{ route('post', ['post_id' => $post->post_id]) }}">{{ date_format($post->created_at, 'd/m/Y h:i:s A') }}</a>
				@else
					đăng bởi {{ App\User::username($post->user_id) }}, vào lúc {{ date_format($post->created_at, 'd/m/Y h:i:s A') }}
				@endif
			</small>
			<p class="media-content">{{ $post->content }}</p>
		</div>
	</div>
</div>
