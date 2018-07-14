<ol class="breadcrumb">
    <li><a href="{{ route('forum') }}">Forum</a></li>
    @foreach ($breadcrumb as $item => $route)
        @if (array_search($route, array_values($breadcrumb)) !== count($breadcrumb) - 1)
            @if (count($breadcrumb) > 2 && strlen($route['title']) > 10)
                {{-- if the title is too long, replace the title with 3 dots. --}}
                <li><a href="{{ route($item, $route['id']) }}">...</a></li>
            @else
                <li><a href="{{ route($item, $route['id']) }}">{{ $route['title'] }}</a></li>
            @endif
        @else
            {{-- last item will have active class --}}
            <li class="active">{{ $route['title'] }}</li>
        @endif
    @endforeach
</ol>
