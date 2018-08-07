<div class="media-box">
	<div class="media">
		<div class="media-body">
			<!-- post title -->
			<h3 class="media-heading">
				{{ App\ForumPosts::postTitle($post->post_id) }}
			</h3>
			<!-- post's author & created at -->
			<small>
				@if (!$single)
					Đăng bởi <a href="{{ route('user.profile.username', ['username' => App\User::username($post->user_id)]) }}">{{ App\User::username($post->user_id) }}</a>, vào lúc <a href="{{ route('post', ['post_id' => $post->post_id]) }}">{{ date_format($post->created_at, 'h:i:s A T, d-m-Y') }}</a>
				@else
					Đăng bởi {{ App\User::username($post->user_id) }}, vào lúc {{ date_format($post->created_at, 'h:i:s A T, d-m-Y') }}
				@endif
			</small>

			<div class="media-content">
				<!-- the post content -->
				<p>{{ $post->content }}</p>

				@if (Auth::check())
					@if (App\UserReport::reportable(Auth::id(), $post->post_id, 'post'))
						<!-- the report section -->
						<p class="pull-right">
							@if (!App\UserReport::is_reported(Auth::id(), $post->post_id, 'post'))
								<a href="{{ route('report.post', [$post->post_id]) }}">báo cáo</a>
							@else
								<span class="label label-danger">đã báo cáo</span>
							@endif
						</p>
					@endif
				@endif
			</div>
		</div>
	</div>
</div>
