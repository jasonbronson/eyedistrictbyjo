@include('header')

<div class="page">

    @include('header-ribbon')

    <div class="main col1-layout">
        <div class="col-main">
            <script type="text/javascript">
                //<![CDATA[
                var isGaEnabled = '0';
                //]]>
            </script>
            <div class="opc-wrapper clearfix">

                <div class="checkout sign-in">
                    <div class="page-title">
                        
                        @if(isset($loginfail) && $loginfail)
                            <p class="title-sub red">Login Failed</p>
                        @elseif(isset($checkout) && $checkout)
                            <h1>Checkout</h1>
                            <p class="title-sub">YOU'RE ONLY A FEW STEPS AWAY!</p>
                        @endif

                    </div>

                    <ol class="opc" id="checkoutSteps" style="height: auto;">
                        <li id="opc-login" class="section allow opened">
                            <div class="step-title hidden">
                            </div>
                            <div id="checkout-step-login" class="step a-item" style="">
                                <div class="step-checkout">
                                    <div class="login-checkout center">
                                        <h4>Sign in</h4>
                                        <form id="login-form" action="/account/login" method="post" class="labelify">
                                            <fieldset>
                                                {{ csrf_field() }}
                                                <ul class="form-list">
                                                    <li class="field">
                                                        <label for="login-email">Email Address</label>
                                                        <div class="input-box">
                                                            <input type="email" class="input-text required-entry validate-email" id="login-email" name="login[username]" value="{{session('username')}}">
                                                        </div>
                                                    </li>
                                                    <li class="field">
                                                        <label for="login-password">Password</label>
                                                        <div class="input-box">
                                                            <input type="password" autocomplete="off" class="input-text validate-password required-entry" id="login-password" name="login[password]">
                                                        </div>
                                                    </li>
                                                    <li class="note">
                                                        <a href="/account/forgotpassword/" class="link">Forgot Your Password?</a>
                                                    </li>
                                                    <li class="buttons-set">
                                                        <input name="context" type="hidden" value="checkout">
                                                        <button type="button" class="button" onclick="$('login-form').submit()"><span><span>Sign in</span></span></button>
                                                        <p class="or">- OR -</p>
                                                        <button id="onepage-guest-register-button" type="button" class="button" onclick="window.location='/account/register/'"><span><span>Create New Account</span></span></button>

                                                    </li>
                                                </ul>
                                            </fieldset>
                                        </form>
                                    </div>


                                </div>
                            </div>
                        </li>

                        <li id="opc-rx" class="section allow">
                            <div class="step-title hidden">
                                <h2>Prescription</h2>
                            </div>
                            <div id="checkout-step-rx" class="step a-item" style="display:none;">
                                <form id="co-rx-form" class="" method="post" action="/rx/onepage/saveRx" enctype="multipart/form-data">
                                    <p><strong>Select how you would like to add a prescription to your order.</strong></p>
                                    <p>Single focal prescriptions only. Prism or multifocal prescriptions can only be fulfilled in-store</p>

                                    <ul class="form-list type-list accordion">
                                        <li class="field saved-prescription disabled">
                                            <div class="control heading">
                                                <div class="input-box">
                                                    <input type="radio" name="rx[type]" value="existing" id="rx:type:id" disabled="">
                                                </div>
                                                <label for="rx:type:id" class="label ignore">
                                                    Saved                </label>
                                            </div>

                                        </li>

                                        <li class="field upload">
                                            <div class="control heading opened">
                                                <div class="input-box">
                                                    <input type="radio" name="rx[type]" value="upload" id="rx:type:upload" class="radio">
                                                </div>
                                                <label for="rx:type:upload" class="label ignore">
                                                    Upload                </label>
                                            </div>
                                            <div class="content opened" style="height: auto;">
                                                <div>
                                                    <p>Take a picture of your prescription and upload it here. We only accept files under 10MB.</p>
                                                    <p>Note: Please make sure that your Pupillary Distance (PD) is written on your prescription. If it is not already included, please follow our <a href="/media/wysiwyg/pdfs/JINS-PD-measurement-guide-v1.pdf" class="link-dark" target="_blank">simple guide</a> to take a measurement.</p>                    <div class="form-list">
                                                        <div class="upload-button">
                                                            <div class="field">
                                                                <div class="input-box">
                                                                    <button type="button" class="button upload"><span><span>Browse</span></span></button>
                                                                    <input type="file" name="rx[image]" id="rx:image" class="required required-file">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div id="upload-results" class="upload-result clearfix" style="display: none;">
                                                            <textarea name="rx[image-data]" id="rx:image-data" class="no-display required"></textarea>
                                                            <ul class="form-list">
                                                                <li class="field">
                                                                    <label for="rx:image-label" class="required">Name your prescription<em>*</em></label>
                                                                    <div class="input-box">
                                                                        <input type="text" name="rx[label]" id="rx:image-label" value="10012017" class="input-text required required-entry validate-prescription-name validate-length maximum-length-55">
                                                                    </div>
                                                                    <div class="validation-advice" id="advice-validate-prescription-name-rx:image-label" style="display:none;">The prescription name should contain only letters, numbers, spaces or following special characters (.,"'()!?), the first character must be a letter or number</div>
                                                                </li>
                                                                <li class="results">
                                                                    <span class="image-name"></span>
                                                                    <a href="javascript:void(0);" onclick="rx.removeFile();" class="link">Change</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="field email-later">
                                            <div class="control heading">
                                                <div class="input-box">
                                                    <input type="radio" name="rx[type]" value="email" id="rx:type:email" class="radio">
                                                </div>
                                                <label for="rx:type:email" class="label ignore">
                                                    Email it Later                </label>
                                            </div>
                                            <div class="content closed">
                                                <div>
                                                    You will receive an e-mail with instructions from us shortly after placing your order.                </div>
                                            </div>
                                        </li>
                                        <li class="field call-doctor">
                                            <div class="control heading">
                                                <div class="input-box">
                                                    <input type="radio" name="rx[type]" value="call" id="rx:type:call">
                                                </div>
                                                <label for="rx:type:call" class="label ignore">
                                                    Call my Doctor                </label>
                                            </div>
                                            <div class="content closed">
                                                <div class="form-fields">
                                                    <fieldset>
                                                        <ul class="form-list">
                                                            <li class="field">
                                                                <label for="rx:patient-name" class="required">Patients' Name<em>*</em></label>
                                                                <div class="input-box">
                                                                    <input type="text" name="rx[patient_name]" value="" id="rx:patient-name" class="input-text required-entry">
                                                                </div>
                                                            </li>
                                                            <li class="field">
                                                                <label for="rx:patient_birthday" class="required">Date Of Birth<em>*</em></label>
                                                                <div class="input-box">
                                                                    <input type="text" name="rx[patient_dob_dob]" placeholder="MM-DD-YYYY" value="" id="rx:patient_birthday" class="input-text required-entry validate-date-dash">
                                                                </div>
                                                            </li>
                                                            <li class="field">
                                                                <label for="rx:doctor-name" class="required">Doctor or Clinic Name<em>*</em></label>
                                                                <div class="input-box">
                                                                    <input type="text" name="rx[doctor_name]" value="" id="rx:doctor-name" class="input-text required-entry">
                                                                </div>
                                                            </li>
                                                            <li class="field">
                                                                <label for="rx:doctor-phone" class="required">Contact Phone<em>*</em></label>
                                                                <div class="input-box">
                                                                    <input type="text" name="rx[doctor_phone]" placeholder="123-456-7890" value="" id="rx:doctor-phone" class="input-text required-entry">
                                                                </div>
                                                            </li>
                                                            <li class="field control">
                                                                <div class="field-row clearfix permission-container">
                                                                    <div class="input-box">
                                                                        <input type="checkbox" name="rx[agreement]" value="agreement" id="rx:doctor-agreement" class="input-checkbox required-entry">
                                                                    </div>
                                                                    <label for="rx:doctor-agreement" class="ignore permission">I give JINS permission to obtain my prescription for the purposes of providing glasses.</label>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </fieldset>
                                                </div>
                                            </div>
                                        </li>

                                        <li class="field readers">
                                            <div class="control heading">
                                                <div class="input-box">
                                                    <input type="radio" name="rx[type]" value="readers" id="rx:type:readers">
                                                </div>
                                                <label for="rx:type:readers" class="label ignore">
                                                    Readers - Prescription not required                </label>
                                            </div>
                                            <div class="content closed">
                                                <div class="form-fields">
                                                    <fieldset>
                                                        <ul class="form-list">
                                                            <li class="field">
                                                                <label for="rx:magnification" class="ignore">Magnification</label>
                                                                <select name="rx[magnification]" id="rx:magnification" class="styled-select required-entry">
                                                                    <option disabled="" selected="" value=""> -- select strength for your readers -- </option>
                                                                    <option value="+0.50">+0.50</option>
                                                                    <option value="+0.75">+0.75</option>
                                                                    <option value="+1.00">+1.00</option>
                                                                    <option value="+1.25">+1.25</option>
                                                                    <option value="+1.50">+1.50</option>
                                                                    <option value="+1.75">+1.75</option>
                                                                    <option value="+2.00">+2.00</option>
                                                                    <option value="+2.25">+2.25</option>
                                                                    <option value="+2.50">+2.50</option>
                                                                </select>
                                                            </li>
                                                        </ul>
                                                    </fieldset>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                    <input type="hidden" name="rx[existing_labels]" value="a:0:{}" id="rx:existing_labels">
                                    <div class="buttons-set loader-container btn-only" id="rx-buttons-container">
                                        <button type="submit" class="button progress-button" title="Continue To Payment">
                                            <span class="progress-wrap"><span>Continue To Payment</span></span>
                                        </button>
                                    </div>

                                    <p class="cart-help">
                                        Need help? Call <strong>1-844-391-2400</strong>            </p>
                                    <input name="form_key" type="hidden" value="d07hQRhToQpg5Hcy">
                                </form>
                                <script type="text/javascript">
                                    //<![CDATA[
                                    var rx = new RxMethod('co-rx-form','/rx/onepage/saveRx/');
                                    document.observe("dom:loaded", function() {
                                        var inputId = 'rx:type:upload';
                                        rx.changeRxType($(inputId));


                                        // Bug fix for ie8 versions for change event handling with labels
                                        !function($) {
                                            if ($('html').hasClass('ie8')) {
                                                // Fix for how the Rx type selection accordion and radio buttons work.
                                                $('.type-list').on('click', '.control', function(e) {
                                                    var $input = $(this).find('input[name="rx[type]"]').prop('checked', true);
                                                    rx.changeRxType($input[0]);
                                                    Gorilla.utilities.resetInputs($('#co-rx-form'));

                                                    $('#co-rx-form').find('select').CustomSelects('unset');
                                                });
                                            }
                                        }(window.jQuery);
                                    });
                                    //]]>
                                </script>
                                <script type="text/javascript">
                                    var theForm = new VarienForm('co-rx-form', true);
                                    Validation.add(
                                        'validate-prescription-name',
                                        'The prescription name should contain only letters, numbers, spaces or following special characters (.,"\'()!?), the first character must be a letter or number',
                                        function(v){
                                            return Validation.get('IsEmpty').test(v) || (/^[a-z0-9][a-z0-9\s\'"\(\)\.,!?]+$/i.test(v));
                                        });

                                </script>                </div>
                        </li>
                        <li id="opc-payment" class="section">
                            <div class="step-title hidden">
                                <h2>Payment Information</h2>
                            </div>
                            <div id="checkout-step-payment" class="step a-item" style="display:none;">
                                <script type="text/javascript">
                                    //<![CDATA[
                                    var quoteBaseGrandTotal = 255;
                                    var checkQuoteBaseGrandTotal = quoteBaseGrandTotal;
                                    var payment = new Payment('co-payment-form', '/checkout/onepage/savePayment/', '/us/checkout/onepage/couponApplyAjax/');
                                    var lastPrice;
                                    //]]>
                                </script>

                                <form action="" id="co-payment-form" class="labelify">
                                    <fieldset>
                                        <div id="checkout-payment-method-load" class="checkout-accordion">
                                            <dl class="sp-methods" id="checkout-payment-method-load">
                                                <!-- Content dynamically loaded. Content from the methods.phtml is loaded during the ajax call -->
                                            </dl>
                                        </div>
                                        <input name="form_key" type="hidden" value="d07hQRhToQpg5Hcy">
                                    </fieldset>
                                </form>

                                <div class="discount checkout-accordion">
                                    <form id="discount-coupon-form" class="labelify" action="" onkeypress="return event.keyCode != 13;">
                                        <fieldset>
                                            <ul class="form-list accordion promo-code type-list">
                                                <li class="field">
                                                    <div class="control heading promo-box">
                                                        <div class="input-box">
                                                            <input id="promo" type="checkbox" name="promo" class="checkbox">
                                                        </div>
                                                        <label for="promo" class="ignore">
                                                            Use Promo Code
                                                        </label>
                                                    </div>
                                                    <div class="content closed">
                                                        <ul class="messages" id="coupon-error">

                                                        </ul>
                                                        <input type="hidden" name="remove" id="remove-coupone" value="0">
                                                        <div class="field">
                                                            <div class="input-box">
                                                                <label for="coupon_code">Promo code</label>
                                                                <input type="text" class="input-text required-entry ignore-disable" id="coupon_code" name="coupon_code" value="">
                                                            </div>
                                                        </div>
                                                        <div class="buttons-set">
                                                            <button type="button" class="button ignore-disable save-coupon" onclick="payment.saveCoupon()" value="Apply"><span><span>Apply</span></span></button>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </fieldset>
                                    </form>
                                    <script type="text/javascript">
                                        //<![CDATA[
                                        jQuery('#coupon_code').one('focusout', function(){
                                            payment.validateCoupon();
                                        });
                                        //]]>
                                    </script>
                                </div>
                                <div class="buttons-set loader-container btn-only" id="payment-buttons-container">
                                    <button type="button" class="button progress-button" onclick="payment.save()">
                                        <span class="progress-wrap"><span>Pay &amp; Finish - </span><span class="total-price"></span></span>
                                    </button>
                                </div>

                                <p class="cart-help">
                                    Need help? Call <strong>1-844-391-2400</strong>    </p>
                                <script type="text/javascript">
                                    //<![CDATA[
                                    function toggleToolTip(event) {
                                        var idToToggle = event.target.getAttribute('data-toggle');
                                        if ($(idToToggle)) {
                                            $(idToToggle).toggle('');
                                        }
                                        if (event.target.hasClassName('cvv-what-is-this')) {
                                            event.target.hide();
                                        }
                                        Event.stop(event);
                                    }

                                    $('co-payment-form').on('click', '.payment-tool-tip-close', function(event) {
                                        $$('.cvv-what-is-this')[0].show();
                                        toggleToolTip(event);
                                    });
                                    //]]>
                                </script>
                                <script type="text/javascript">
                                    //<![CDATA[
                                    payment.currentMethod = "";
                                    //]]>
                                </script>
                            </div>
                        </li>
                    </ol>
                </div>
                <script type="text/javascript">
                    //<![CDATA[
                    var accordion = new Accordion('checkoutSteps', '.step-title', true);
                    accordion.openSection('opc-login');

                    window.dataLayer = window.dataLayer || [];
                    dataLayer.push({
                        'event':'OnepageCheckoutTab',
                        'tabTitle':'Checkout login',
                        'tabUrl':'/us/checkout/onepage/login'
                    });
                    var checkout = new RxCheckout(
                        accordion,
                        {
                            progress: '/checkout/onepage/progress/',
                            review: '/checkout/onepage/review/',
                            saveMethod: '/checkout/onepage/saveMethod/',
                            failure: '/checkout/cart/',
                            totals:  '/checkout/onepage/totals/'
                        },
                        1		);


                    //]]>
                </script>
            </div>


            <script type="text/javascript">
                //<![CDATA[
                function reloadIframe(method) {
                    var iframeContainer = $('payment_form_' + method + '_container');
                    if (iframeContainer) {
                        var hiddenElms = iframeContainer.up('li').select('input');
                        if (hiddenElms) {
                            hiddenElms.each(function(elm){
                                if (elm) elm.remove();
                            });
                        }

                        new Ajax.Updater(
                            iframeContainer,
                            "/enterprise_pbridge/pbridge/iframe/",
                            {parameters : {method_code : method},
                                onSuccess: function(transport) {
                                    if (iframeContainer.previous('span.pbridge-reload') && iframeContainer.previous('span.pbridge-reload').down('a')) {
                                        iframeContainer.previous('span.pbridge-reload').down('a').show();
                                    }
                                    toggleContinueButton(iframeContainer.up('ul'));
                                }
                            }
                        );
                        if (isPaymentSubmitted(method)) {
                            delete submittedPayments[method];
                        }
                    }
                }
                function toggleContinueButton(target) {
                    var buttonsContainer = $('payment-buttons-container');
                    if (buttonsContainer && buttonsContainer.down('button.button')) {
                        var continueButton = buttonsContainer.down('button.button');
                        var checkedRadio = $$('#co-payment-form input[type="radio"][name="payment[method]"]:checked');
                        var isPbridgeMethod = checkedRadio.length && checkedRadio[0].match('[value^="pbridge"]');
                        if ((target.type != 'checkbox' || !target.checked) && isPbridgeMethod) {
                            return continueButton.setStyle({display:'none'});
                        }
                        if (!isPbridgeMethod || isPaymentSubmitted(checkedRadio[0].value)) {
                            continueButton.setStyle({display:'block'});
                        }
                    }
                }

                function isPaymentSubmitted(method)
                {
                    return submittedPayments.hasOwnProperty(method);
                }

                function validateAgreementOnIframe()
                {
                    checkout.setLoadWaiting('review');
                    var params = Form.serialize(payment.form) + '&' + Form.serialize(review.agreementsForm);
                    var request = new Ajax.Request(
                        getAgreementValidationUrl(),
                        {
                            method: 'post',
                            parameters: params,
                            onComplete: review.onComplete,
                            onSuccess: validateAgreements,
                            onFailure: checkout.ajaxFailure.bind(checkout)
                        }
                    );
                }

                function loadReviewIframe(method) {
                    var iframeContainer = $('checkout-pbridgeiframe-load');
                    var methodCode = method || payment.currentMethod;
                    new Ajax.Updater(
                        iframeContainer,
                        "/enterprise_pbridge/pbridge/review/",
                        {parameters : {method_code : methodCode, data: {is_review_iframe: 1}}}
                    );
                    $('iframe-warning').show();
                    $('btn-pay-now').hide();
                }

                /**
                 * Hold validation actions before loading review iframe
                 */
                function preLoadReviewIframe() {
                    if (review.agreementsForm) {
                        validateAgreementOnIframe();
                    } else {
                        loadReviewIframe();
                    }
                }

                function saveOrderAndLoadReviewIframe()
                {
                    if (review.agreementsForm) {
                        validateAgreementOnIframe();
                    } else {
                        var headers = $$('#' + checkout.accordion.container.readAttribute('id') + ' .section');
                        headers.each(function(header) {
                            header.removeClassName('allow');
                        });
                        review.save();
                        $('iframe-warning').show();
                        $('btn-pay-now').hide();
                    }
                }

                /**
                 * Validate agreemnets
                 */
                function validateAgreements(transport) {
                    if (transport && transport.responseText) {
                        try{
                            response = eval('(' + transport.responseText + ')');
                        }
                        catch (e) {
                            response = {};
                        }
                        if (response.success) {
                            /* Accepted terms and conditions are no longer available to decline */
                            review.agreementsForm.hide();
                            loadReviewIframe();
                        } else {
                            review.nextStep(transport);
                        }
                    }
                }

                /**
                 * Get url for server agreements validation
                 *
                 * @return string
                 */
                function getAgreementValidationUrl() {
                    return "/enterprise_pbridge/pbridge/validateAgreement/";
                }
                //]]>
            </script>
            <div id="opc-account-login-prompt" class="moby fade prompt">
                <div class="inner">
                    <p class="top-bar title">
                        <span>Account Found</span>
                        <a href="javascript:void(0);" class="icon close f-right" data-moby="toggle" data-target="#opc-account-login-prompt"></a>
                    </p>
                    <div class="content clearfix">
                        <p>The email address you entered is already associated with an account.</p>
                        <p><a href="javascript:void(0);" onclick="checkout.gotoSection('login');" class="button" data-moby="toggle" data-target="#opc-account-login-prompt">Log In</a></p>
                        <p><a href="javascript:void(0);" onclick="document.getElementById('billing:email').focus();" class="alt-link" data-moby="toggle" data-target="#opc-account-login-prompt">Edit Email Address</a></p>
                    </div>
                </div>
            </div>            </div>
    </div>


</div>


@include('footer')