@include('header')

<div class="page">

    @include('header-ribbon')

    <div class="main col1-layout">
        <div class="col-main">
            <div class="account-forms">
                <div class="page-title login-title copy-space">
                    <div class="">
                        <h1>Account</h1>
                    </div>
                </div>
                @if(isset($link) && $link)
                    <form action="/password/reset/" method="post" id="form-validate" class="labelify">
                        <div class="fieldset row">
                            <div class="grid-4">
                                <h2>Enter a new password</h2>
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <ul class="form-list">
                                    <li class="field">
                                        <label for="email_address" class="required">Email</label>
                                        <div class="input-box validation-error">
                                            <input type="text" name="email" alt="email" class="input-text required-entry validate-email validation-failed" value="">
                                            <div class="validation-advice" id="advice-required-entry-" style="">This is a required field.</div>
                                        </div>
                                    </li>
                                    <li class="field">
                                        <label for="email_address" class="required">New Password</label>
                                        <div class="input-box validation-error">
                                            <input type="password" name="password" alt="password" class="input-text required-entry validate-password validation-failed" value="">
                                            <div class="validation-advice" id="advice-required-entry-" style="">This is a required field.</div>
                                        </div>
                                    </li>
                                    <li class="field">
                                        <label for="email_address" class="required">Confirm Password</label>
                                        <div class="input-box validation-error">
                                            <input type="password" name="password_confirmation" alt="password_confirm" class="input-text required-entry validate-password validation-failed" value="">
                                            <div class="validation-advice" id="advice-required-entry-" style="">This is a required field.</div>
                                        </div>
                                    </li>
                                </ul>
                                <div class="buttons-set form-buttons">
                                    <button type="submit" class="button"><span><span>Save</span></span></button>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="token" value="{{ $token }}">
                        {{ csrf_field() }}
                    </form>
                @elseif(isset($passwordReset) && $passwordReset)
                    <h1>Password reset link emailed</h1>
                @else
                <form action="/account/forgotpassword/" method="post" id="form-validate" class="labelify">
                    <div class="fieldset row">
                        <div class="grid-4">
                            <h2>Forgot Password</h2>
                            <p>Enter your email to receive a link to reset your password.</p>
                            <ul class="form-list">
                                <li class="field">
                                    <label for="email_address" class="required">Email Address</label>
                                    <div class="input-box validation-error">
                                        <input type="email" name="email" alt="email" id="email_address" class="input-text required-entry validate-email validation-failed" value=""><div class="validation-advice" id="advice-required-entry-email_address" style="">This is a required field.</div>
                                    </div>
                                </li>
                            </ul>
                            <div class="buttons-set form-buttons">
                                <button type="submit" class="button"><span><span>Send a password reset link</span></span></button>
                            </div>
                        </div>
                    </div>
                    {{ csrf_field() }}
                </form>
                 @endif

            </div>
        </div>
    </div>


</div>


@include('footer')