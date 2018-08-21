<div class="panel panel-primary">
    <div class="panel-heading">
        I remember the email I had used to register {{ config('app.name') }} account!
    </div>
    <div class="panel-body">
        <form action="{{ route('recover.requestToken') }}" method="POST">
            <div class="form-group {{ (!$errors->any()) ?: (!$errors->has('email') ? 'has-success' : 'has-error' ) }}">
                <label for="email" class="control-label">Your account's email address:</label>
                <div class="input-group">
                    <input type="email" id="email" name="email" class="form-control" placeholder="john.doe@example.com" required>
                    <div class="input-group-btn">
                        <button class="btn btn-primary">Send reset password email</button>
                    </div>
                </div>
                @foreach ($errors->all() as $error)
                    <span class="help-block">{{ $error }}</span>
                @endforeach
                @csrf
            </div>

            <div class="form-group">
                <p>You will receive an email, which contains the reset password's link. Click on that link to reset your password.</p>
                <p><b>Please notice</b>: You can only receive the reset password link when your {{ config('app.name') }} account has been verified with that email.</p>
            </div>
        </form>
    </div>
</div>
