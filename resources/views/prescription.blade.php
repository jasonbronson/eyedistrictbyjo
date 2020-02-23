@include('header')
<div class="page">
	@include('header-ribbon')
	<div class="main col1-layout">
		<div class="col-main">
			<div class="page-title">
				<h2>Upload Your Prescription</h2>
			</div>
			<div class="opc-progress-container" id="opc-progress">
                    <div class="block block-progress opc-block-progress">
                        <ol class="block-content">

                            <li id="shipping-progress-opcheckout" class="active">

                                <div class="progress-step">
                                    Shipping</div>

                            </li>

                            <li id="rx-progress-opcheckout" class="active">

                                <div class="progress-step">
                                    Prescription</div>
                            </li>


                            <li id="payment-progress-opcheckout">

                                <div class="progress-step">
                                    Payment</div>

                            </li>
                        </ol>

                    </div>
			</div>
			<form action="/checkout/payment/" class="" enctype="multipart/form-data" id="checkout-step-rx" name="co-rx-form">
				<p>Single focal prescriptions only. Prism or multifocal prescriptions can only be fulfilled in-store</p>
				<ul class="form-list type-list">
					<li class="field upload">
						<div class="control heading hidden">
							<div class="input-box">
								<div class="custom-styled-radio checked ">
									<input class="radio custom-styled-radio" id="rx:type:upload" name="rx[type]" type="radio" value="upload">
								</div>
							</div><label class="label ignore" for="rx:type:upload">Upload</label>
						</div>
						<div class="content opened" style="height: auto;">
							<div>
								<p>Take a picture of your prescription and upload it here. We only accept files under 10MB.</p>
								<p>Note: Please make sure that your Pupillary Distance (PD) is written on your prescription. If it is not already included, please follow our 
								<a class="link-dark" href="/pdfs/measurement-guide-v1.pdf" target="_blank">simple guide</a> to take a measurement.</p>
								<div class="form-list">
									<div class="upload-button">
										<div class="field">
											<div class="input-box">
												<button class="button upload btn-browse-prescription" type="button"><span><span>Browse</span></span></button> 
												<input class="required required-file" id="rx-image" name="rx-image" type="file" data-url="/account/uploadprescription/">
											</div>
										</div>
									</div>
									<div class="upload-result clearfix validation-failed" id="upload-results" style="display: none;">
										<textarea class="no-display required" id="rx:image-data" name="rx[image-data]"></textarea>
										<ul class="form-list">
											<li class="field">
												<label class="required" for="rx:image-label">Name your prescription<em>*</em></label>
												<div class="input-box">
													<input class="input-text required required-entry validate-prescription-name validate-length maximum-length-55" id="rx:image-label" name="rx[label]" type="text" value="10072017">
												</div>
												<div class="validation-advice" id="advice-validate-prescription-name-rx:image-label" style="display:none;">
													The prescription name should contain only letters, numbers, spaces or following special characters (.,"'()!?), the first character must be a letter or number
												</div>
											</li>
											
										</ul>
									</div>
								</div>
							</div>
						</div>
					</li>
				</ul>
				<div class="buttons-set loader-container btn-only" id="rx-buttons-container">
					<button class="button progress-button" type="submit"><span class="progress-wrap"><span class="btn-continue-text">Skip Prescription</span></span></button>
				</div>
				<p class="cart-help">Need help? Call <strong>1-702-998-1795</strong></p>
				{{csrf_field()}}
				
			</form>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="/js/jquery.ui.widget.js"></script>
<script src="/js/jquery.iframe-transport.js"></script>
<script src="/js/jquery.fileupload.js"></script>
<script>
jQuery(function () {
	var j$ = jQuery.noConflict();
	var url = '/account/uploadprescription/?_token={{ csrf_token() }}';
    j$('#rx-image').fileupload({
        dataType: 'json',
        done: function (e, data) {
			console.log("Sending File");
			jQuery('.btn-continue-text').html("Continue To Payment");
			jQuery('.btn-browse-prescription').css("background-color", "white");
			jQuery('.btn-browse-prescription').css("color", "#3a4763");
			
        }
    });
});


</script>
		</div>
	</div>
</div>
@include('footer')