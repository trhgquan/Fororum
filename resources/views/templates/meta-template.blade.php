<meta name="charset" content="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta property="og:title" content="{{ config('app.name') }} - @yield('title')">
<meta property="og:url" content="{{ url()->full() }}">
@section ('meta')
    @isset ($meta)
        @foreach ($meta as $meta_name => $meta_content)
            @if (is_array($meta_content))
                <meta name="{{ $meta_name }}" content="{{ implode(',', $meta_content) }}">
            @else
                <meta name="{{ $meta_name }}" content="{{ $meta_content }}">
            @endif
        @endforeach
    @endisset
@show
