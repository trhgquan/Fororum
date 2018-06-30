<div class="media-box">
	<div class="media">
		<div class="media-body">
			<h3 class="media-heading">
				<a href="{{ route('thread', ['thread_id' => $thread->post_id]) }}">{{ App\ForumPosts::postTitle($thread->post_id) }}</a>
			</h3>
			<small>
				Đăng bởi {{ App\User::username($thread->user_id) }}
				@if (App\ForumPosts::totalPosts($thread->post_id))
					, {{ App\ForumPosts::totalPosts($thread->post_id) }} bài đăng trả lời
				@endif
				, vào lúc {{ date_format($thread->created_at, 'h:i:s A T, d-m-Y') }}
			</small>
		</div>
	</div>
</div>
