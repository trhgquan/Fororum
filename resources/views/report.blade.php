@extends('templates.app-template')

@section('title', 'Justice')

@section('navbar_brand')
    <a href="{{ url('/') }}" class="navbar-brand">{{ config('app.name') }} <small>justice</small></a>
@endsection

@section('navbar_item')
    @include('items.navbar-items')
@endsection

@section('content')
    @if ($type === 'after')
        <div class="notify-title">
            <h1>Well done!</h1>
            <p>
                We appreciate you reporting this issue to us. The webmaster will look over this issue and decide if it violated our <a href="#">TERMS OF SERVICES</a>.<br/>
                Now, keep calm and <a href="{{ route('forum') }}">head me to the forum!</a>
            </p>
        </div>
    @elseif ($type === 'error')
        <div class="notify-title">
            <h1>You cannot take this action!</h1>
            <b>You cannot report yourself, or a post you have posted.</b>
            <p>You also cannot report system, non-exist or banned accounts. <a href="#">Find out more</a></p>
        </div>
    @else
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                @include('forms.report-form')
            </div>
        </div>
    @endif
@endsection
