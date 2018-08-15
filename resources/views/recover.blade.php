@extends('templates.app-template',[
    'meta' => [
        'description' => 'Recover ' . config('app.name') . ' account',
        'og:description' => 'Recover ' . config('app.name') . ' account'
    ],
    'navbar_brand' => 'support'
])

@section('title', 'Support')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-title">Oops, something went wrong, isn't it? </h1>
            <p>Don't worry. We have some solutions to solve your problem:</p>
        </div>

        <div class="col-md-6">
            @include('forms.auth.reset-verification')
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Now this is serious: I don't remember anything!
                </div>
                <div class="panel-body">
                    <p>That would be shame. However, there is a hope to gain back your account's access.</p>
                    <p>Contact <b>{{ 'webmaster@' . explode('//', url('/'))[1]  }}</b>. You will need some proofs about when (don't need to be exact) did the {{ config('app.name') }} account was created, the last email you used to create the {{ config('app.name') }} account,..</p>
                    <p>We will give you an answer as soon as possible. Your account's credentials will be sent to your email right after we confirmed you are the true-owner of the account.</p>
                    <p>Best regards - {{ config('app.name') }} supporters and webmasters.</p>
                </div>
            </div>
        </div>
    </div>
@endsection
