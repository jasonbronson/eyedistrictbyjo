@include('header')

<div class="page">

    @include('header-ribbon')

<div class="main col1-layout">
    <div class="col-main">
        <div class="opc-wrapper clearfix">
            <ul class="messages"><li class="success-msg"><ul><li><span>Thank you for registering.</span></li></ul></li></ul>
            <div class="checkout">
                <div class="page-title">
                    <h1>Checkout</h1>
                </div>
                <div class="opc-progress-container" id="opc-progress">
                    <div class="block block-progress opc-block-progress">
                        <ol class="block-content">

                            <li id="shipping-progress-opcheckout" class="active">

                                <div class="progress-step">
                                    Shipping</div>

                            </li>

                            <li id="rx-progress-opcheckout">

                                <div class="progress-step">
                                    Prescription</div>
                            </li>


                            <li id="payment-progress-opcheckout">

                                <div class="progress-step">
                                    Payment</div>

                            </li>
                        </ol>

                    </div>


                    <div id="checkout-review-table-wrapper" class="review-section">
                        <table class="data-table products-table" id="checkout-review-table">
                            <tbody>
                            @if(isset($cartContent))
                            @foreach($cartContent as $item)
                            <tr>
                                <td>
                                    <a href="{{$item->productURL}}" class="product-image">            
                                    <img src="/productimages/{{$item->category}}/{{$item->id}}_1.jpg" width="300">
                                    </a>	
                                </td>
                                <td>
                                    <div class="product-name">
                                        <a href="{{$item->productURL}}">{{ucwords($item->name)}} </a>
                                        <span class="price">${{number_format($item->price, 2)}}</span>
                                    </div>
                                    <dl class="item-options">
                                        <dt>Qty</dt>
                                        <dd>{{$item->qty}}</dd>
                                        @foreach($item->options as $key => $option)
                                            <dt>{{$key}}</dt>
                                            <dd>{{$option}}</dd>
                                        @endforeach
                                    </dl>
                                </td>
                                <td></td>
                            </tr>
                            @endforeach
                            @endif
                            </tbody>
                        </table>

                        <div id="checkout-review-submit">
                            <div class="buttons-set loader-container" id="review-buttons-container">
                            </div>
                            <script type="text/javascript">
                                //<![CDATA[
                                //review = new Review('/checkout/onepage/saveOrder/form_key/TTGEiSnnPTmHTW4E/', '/checkout/onepage/success/', $('checkout-agreements'));
                                //]]>
                            </script>
                        </div>                <div class="block block-progress opc-block-progress">
                            <ol class="">


                                <li id="shipping-progress-opcheckout-review">
                                </li>

                                <li id="rx-progress-opcheckout-review">
                                </li>

                                <li id="payment-progress-opcheckout-review">
                                </li>
                            </ol>

                        </div>

                    </div>
                    <div class="review-section">
                        <table class="data-table products-table" id="checkout-review-totals">
                            <tfoot>
                            <tr>
                                <td style="" class="a-right" colspan="2">Shipping</td>
                                <td style="" class="a-right"><span class="shipping">${{$cartShipping}}</span></td>
                            </tr>
                            <tr>
                                <td style="" class="a-right" colspan="2">Subtotal</td>
                                <td style="" class="a-right"><span class="price">${{$cartSubtotal}}</span></td>
                            </tr>

                            <tr>
                                <td style="" class="a-right" colspan="2">
                                    <div class="summary-collapse">Tax</div>
                                </td>
                                <td style="" class="a-right"><span class="price">${{$cartTax}}</span></td>
                            </tr>
                            <tr>
                                <td style="" class="a-right" colspan="2">
                                    <strong>Grand Total</strong>
                                </td>
                                <td style="" class="a-right">
                                    <strong><span class="price">${{$cartTotal }}</span></strong>
                                </td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <form action="/checkout/shipping" id="shipping-form" class="address-form" method="POST">
                    <h3>Shipping Information</h3>
                <ul class="form-list">
                        <li id="shipping-new-address-form" class="new-address-fieldset">
                                    <div class="fieldset">
                                        <ul>
                                            <li><div class="customer-name">
                                              <div class="field name-firstname">
                                                  <label for="shipping:firstname" class="required">First Name<em>*</em></label>
                                                  <div class="input-box">
                                                      <input type="text" id="shipping:firstname" name="shipping[firstname]" value="{{$firstname}}" title="First Name" maxlength="255" class="input-text required-entry">
                                                  </div>
                                              </div>
                                              <div class="field name-lastname">
                                                  <label for="shipping:lastname" class="required">Last Name<em>*</em></label>
                                                  <div class="input-box">
                                                      <input type="text" id="shipping:lastname" name="shipping[lastname]" value="{{$lastname}}" title="Last Name" maxlength="255" class="input-text required-entry">
                                                  </div>
                                              </div>
                                          </div>
                                            </li>

                                                <li class="field">
                                                <label for="shipping:street1" class="required">Address line<em>*</em></label>
                                                <div class="input-box">
                                                    <input type="text" title="Street Address" name="shipping[street1]" id="shipping:street1" value="{{$street1}}" class="input-text  required-entry">
                                                </div>
                                            </li>

                                                                                                                            <li class="field w50">
                                                <label for="shipping:street2">APT / SUITE (OPTIONAL)</label>
                                                <div class="input-box">
                                                    <input type="text" title="Street Address 2" name="shipping[street2]" id="shipping:street2" value="{{$street2}}" class="input-text ">
                                                </div>
                                            </li>

                                        <li class="field w50">
                                            <label for="shipping:company">Company (OPTIONAL)</label>
                                            <div class="input-box">
                                                <input type="text" id="shipping:company" name="shipping[company]" value="{{$company}}" title="Company" class="input-text ">
                                            </div>
                                        </li>


                                            <li class="field">
                                                <label for="shipping:postcode" class="required">Zip/Postal Code<em>*</em></label>
                                                <div class="input-box zipcode-lookup">
                                                    <input type="text" title="Zip/Postal Code" name="shipping[postcode]" id="shipping:postcode" value="{{$postcode}}" data-lookup="zipcode" class="input-text validate-zip-international  required-entry">
                                                    <div id="lookup-error-shipping:postcode" class="validation-advice" style="display: none;">No City or State data was found for this Zip/Postal Code</div>
                                                </div>
                                            </li>
                                            <li class="field w50">
                                                <label for="shipping:city" class="required">City<em>*</em></label>
                                                <div class="input-box">
                                                    <input type="text" title="City" name="shipping[city]" value="{{$city}}" class="input-text  required-entry" id="shipping:city">
                                                </div>
                                            </li>
                                            <li class="field w50">
                                                <div class="input-box">
                                                    <div class="custom-styled-select" style="display: inline-block; position: relative;">

                                                      <select id="shipping:region_id" name="shipping[region_id]" title="State/Province" class="validate-select required-entry custom-styled-select" style="position: absolute; opacity: 0; left: 0px; top: 0px;" defaultvalue="">
                                                    @foreach($states as $item )
                                                     <option value="{{$item->region_id}}">{{$item->state}}</option>
                                                    @endforeach
                                                    </select></div>
                                                </div>
                                            </li>
                                            <li class="field no-display">
                                                <label for="shipping:country_id" class="required">Country<em>*</em></label>
                                                <div class="input-box">
                                                    <select name="shipping[country_id]" id="shipping:country_id" class="validate-select" title="Country" onchange="if(window.shipping)shipping.setSameAsBilling(false);"><option value=""> </option><option value="US" selected="selected">United States</option></select>                                                </div>
                                            </li>
                                            <li class="field">
                                                <label for="shipping:telephone" class="required">Phone (123-123-1234)<em>*</em></label>
                                                <div class="input-box">
                                                    <input type="text" name="shipping[telephone]" value="{{$telephone}}" title="Telephone" class="input-text validate-phoneStrict  required-entry" id="shipping:telephone">
                                                </div>
                                            </li>
                                            </ul>
                                   
                                    </div>
                                    {{csrf_field()}}
                                    <div class="buttons-set form-buttons loader-container btn-only" id="shipping-method-buttons-container">
                                      <button type="button" class="button progress-button" onclick="saveAddress();">
                                          <span class="progress-wrap"><span class="content">Continue</span></span>
                                      </button>
                                    </div>
                                    
                                
                                </li>
                            </ul>
                          </form>
                          <script>
                          function saveAddress(){
                            jQuery('#shipping-form').submit();
                          }
                          </script>

            </div>

        </div>


    </div>
</div>


</div>


@include('footer')
