@include('header')

<div class="page">

    @include('header-ribbon')

<div class="main col2-left-layout">

    @include('account.account-nav')

    <div class="col-main">
        <div class="my-account clearfix"><div class="dashboard">
              <form action="/account/edit/" method="post">
                <div class="personal-info">
                    <h3 class="sub-title">Shipping Address</h3>

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
                                                    <option value="">Please select region, state or province</option>
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
                                    <input type="hidden" name="_token" value="A4xrgGmxb45iYiyaic238CR4AqNiSgyCuF1nuTHq">
                                    <div class="buttons-set form-buttons loader-container btn-only" id="shipping-method-buttons-container">
                                      <button type="button" class="button progress-button" onclick="saveAddress();">
                                          <span class="progress-wrap"><span class="content">Save</span></span>
                                      </button>
                                </div>
                                
                                </li>
                            </ul>

                </div>
                </form>
                </div>            
                
                </div>
                
    </div>
</div>


</div>


@include('footer')