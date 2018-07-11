@extends('templates.app-template')

@section('title', 'báo cáo'))

@section('navbar_brand')
    <a href="{{ url('/') }}" class="navbar-brand">{{ config('app.name') }} <small>justice</small></a>
@endsection

@section('navbar_item')
    @include('items.navbar-items')
@endsection

@section('content')
    @if ($type === 'after')
        <div class="notify-title">
            <h1>Bạn đã làm việc có ích cho cộng đồng!</h1>
            <p>Hệ thống đang xem xét báo cáo của bạn và đưa ra quyết định.</p>
        </div>
    @elseif ($type === 'error')
        <div class="notify-title">
            <h1>Dừng lại!</h1>
            <b>Bạn không thể báo cáo bản thân mình hoặc một bài đăng mình đã đăng!</b>
            <p>Ngoài ra bạn không thể báo cáo tài khoản hệ thống, hay những tài khoản đã bị khóa. Tìm hiểu thêm.</p>
        </div>
    @else
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                @include('forms.report-form')
            </div>
        </div>
    @endif
@endsection
