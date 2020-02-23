@include('header')

<div class="page">

    @include('header-ribbon')

    <div class="main col1-layout">
        <div class="col-main">
            <div class="account-create account-forms">
                <div class="page-title copy-space">
                    <div class="no-breadcrumbs no-sub-title">
                        <h1>Account</h1>
                        @foreach ($errors->all() as $message)

                            <p>{{$message}}</p>

                        @endforeach

                    </div>
                </div>
                <form action="/account/register/" method="post" id="form-validate" enctype="multipart/form-data" class="labelify">
                    <input style="display:none">
                    <input type="password" style="display:none" autocomplete="off">
                    <div class="fieldset row">
                        <div class="grid-4">
                            <h2>Create an Account</h2>
                            <input type="hidden" name="success_url" value="" autocomplete="off">
                            <input type="hidden" name="error_url" value="" autocomplete="off">
                            <input type="hidden" name="form_key" value="d07hQRhToQpg5Hcy">
                            <ul class="form-list">
                                <li class="field">
                                    <label for="firstname" class="required">Firstname<em>*</em></label>
                                    <div class="input-box">
                                        <input type="text" id="firstname" name="firstname" value="{{$firstname}}" title="firstname required-entry" maxlength="255" class="input-text required-entry" autocomplete="off">
                                    </div>
                                </li>
                                <li class="field">
                                    <label for="lastname" class="required">Lastname<em>*</em></label>
                                    <div class="input-box">
                                        <input type="text" id="lastname" name="lastname" value="{{$lastname}}" title="lastname required-entry" maxlength="255" class="input-text required-entry" autocomplete="off">
                                    </div>
                                </li>
                                <li class="field">
                                    <label for="email_address" class="required">Email Address<em>*</em></label>
                                    <div class="input-box">
                                        <input type="email" name="email" id="email_address" value="{{$email}}" title="Email Address" class="input-text validate-email required-entry" autocomplete="off">
                                    </div>
                                </li>

                            </ul>


                            <ul class="form-list password-fields">
                                <li class="field">
                                    <label for="password" class="required">Password<em>*</em></label>
                                    <div class="input-box">
                                        <input type="password" name="password" id="password" title="Password" class="input-text required-entry validate-password" autocomplete="off">
                                    </div>
                                </li>
                                <li class="field">
                                    <label for="confirmation" class="required">Confirm Password<em>*</em></label>
                                    <div class="input-box">
                                        <input type="password" name="password_confirmation" title="Confirm Password" id="confirmation" class="input-text required-entry validate-cpassword" autocomplete="off">
                                    </div>
                                </li>
                                <li class="control">
                                    <div class="input-box">
                                        <input type="checkbox" name="subscribed" title="Sign Up for Newsletter" value="0" id="subscribed">
                                    </div>
                                    <label for="is_subscribed">Email Me with News &amp; Updates</label>
                                </li>
                            </ul>

                            <div class="buttons-set form-buttons">
                                <button type="submit" class="button" title="Create account"><span><span>Create account</span></span></button>
                            </div>
                        </div>
                    </div>
                    {{ csrf_field() }}
                </form>
                <script>
                    $(function() {
                        $('.custom-styled-checkbox').click(function () {
                            $('#subscribed').val() == 0 ? 1 : 0;
                        });
                    });
                </script>
            </div>
        </div>
    </div>

</div>


@include('footer')