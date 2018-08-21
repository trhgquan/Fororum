@extends('home')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="jumbotron">
                <h2>Verify your email address</h2>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            A fresh verification link has been sent to your email address.
                        </div>
                    @endif

                    <p>
                        Before proceeding, please check your email for a verification link.
                        If you did not receive the email, <a href="{{ route('verification.resend') }}">click here to request another</a>.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
