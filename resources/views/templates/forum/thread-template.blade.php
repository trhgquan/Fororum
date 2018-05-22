<div class="media">
	<div class="media-body">
		<h3 class="media-heading">
			<a href="{{ route('thread', ['thread_id' => $thread->post_id]) }}">{{ $thread->title }}</a>
		</h3>
		<small style="font-style: italic;">
			{{ App\User::username($thread->user_id) }},{{ date_format($thread->created_at, 'd/m/Y H:m:s') }}
		</small>
	</div>
</div>
