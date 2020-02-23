@include('header')

<div class="page">

    @include('header-ribbon')

    <div class="main col1-layout">
        <div class="col-main">
            <div class="std">
                <div class="cms-page-title cms-copy-space">
                    <div>
                        <h1>CONTACT US</h1>
                        <p></p>
                        <!--a href="#mapArea" class="button button--auto" id="map-view">MAP VIEW</a-->
                    </div>
                </div>
                <div class="wrapper">
                    <section class="wide-content--center wide-content--first">
                        <div class="contents contents--no-top-padding">

                            <div class="case-block">
                                <div class="case-block__cell case-block__cell--info">
                                    <div class="contact-us">
									@if($sent)
										<h1>Email sent we will respond soon.</h1>
									@else
                                            <h3 class="legend">Have questions? We have answers.</h3>
                                            <p>
                                            </p><h4>Customer Support Hours: </h4>
                                            T: 702-998-1795<br>
                                            F: 702-906-1953
                                            <p></p>
                                            <div id="messages_product_view"></div>
                                            <form action="/contactus/" id="contactForm" class="labelify" method="post">
                                                <div class="">
                                                    <ul class="form-list">
                                                        <li class="field">
                                                            <label for="name" class="required">Name</label>
                                                            <div class="input-box validation-error">
                                                                <input name="name" id="name" title="Name" value="" class="input-text required-entry validation-failed" type="text"><div class="validation-advice" id="advice-required-entry-name" style="">This is a required field.</div>
                                                            </div>
                                                        </li>
                                                        <li class="field">
                                                            <label for="email" class="required">Email</label>
                                                            <div class="input-box">
                                                                <input name="email" id="email" title="Email" value="" class="input-text required-entry validate-email" type="email">
                                                            </div>
                                                        </li>
                                                        <li class="field">
                                                            <label for="telephone">Phone (123-123-1234)</label>
                                                            <div class="input-box">
                                                                <input name="telephone" id="telephone" title="Phone" value="" class="input-text" type="text">
                                                            </div>
                                                        </li>
                                                        <li class="field">
                                                            <label for="subject">Subject</label>
                                                            <div class="input-box">
                                                                <input name="subject" id="subject" title="Subject" value="" class="input-text required-entry" type="text">
                                                            </div>
                                                        </li>
                                                        <li class="field">
                                                            <label for="comment" class="required">Message</label>
                                                            <div class="input-box">
                                                                <textarea name="comment" id="comment" title="Message" class="required-entry input-text" cols="5" rows="3"></textarea>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                    <div class="buttons-set form-buttons btn-only loader-container">
                                                        <input type="text" name="hideit" id="hideit" value="" style="display:none !important;">
                                                        <button type="submit" class="button progress-button" title="Submit">
                                                           {{csrf_field()}}
                                                            <span><span>Submit</span></span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                     @endif   
                                </div>
                                <div class="case-block__cell case-block__cell--photo" >
                                        <img src="/media/store.jpg" class="img-responsive">
                                </div>
                                
                            </div>



                    </section>
                </div>
                 

            </div>
        </div>
    </div>
</div>




@include('footer')





