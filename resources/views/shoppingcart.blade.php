@include('header')

<div class="page">

    @include('header-ribbon')

    @if($cartCount == 0)

        <div class="main col1-layout">
            <div class="col-main">
                <div class="cart empty-cart">
                    <div class="page-title row">
                        <div class="grid-8 no-breadcrumbs">
                            <h1>Shopping Cart</h1>
                        </div>
                    </div>
                    <div class="row">
                        <div class="grid-8 registered-users">
                            <h2>There are no items in your cart.</h2>
                            <div class="cart-empty">
                                <p>Start shopping to fill it up!</p><a class="button utility" href="/">Continue Shopping</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else

    <div class="main col1-layout">
    <div class="col-main">
        @if(session('cartItemAdded'))
            <ul class="messages"><li class="success-msg"><ul><li><span>Item was added to your shopping cart.</span></li></ul></li></ul>
        @endif
        <div class="page-title copy-space">
            <div class="no-breadcrumbs">
                <h1>Shopping Cart</h1>
            </div>
        </div>

        <div class="cart cart-contents">
            <div class="cart-options">
                <div class="cart-totals-title">
                    <h2>Cart Totals</h2>
                </div>

                <div class="cart-collaterals">
                    <div class="extras">
                        <div class="accord accordion">
                            <div class="section">
                                <!--h4 class="">Shipping <span class="toggle show780"></span></h4>
                                <h4 class="">Tax <!--span class="toggle show780"></span></h4 -->
                                <!--div class="closed">
                                    <div class="shipping">
                                        <form action="checkout/cart/estimatePost/" method="post" id="shipping-zip-form" class="labelify">
                                            <fieldset>
                                                <ul class="form-list">
                                                    <li class="no-display">
                                                        <label for="country">Country</label>
                                                        <select name="country_id" id="country" class="validate-select" title="Country"><option value=""> </option><option value="US" selected="selected">United States</option></select>                    </li>
                                                    <li class="field">
                                                        <label for="postcode">Zip/Postal Code</label>
                                                        <div class="input-box">
                                                            <input class="input-text validate-postcode" type="text" id="postcode" name="estimate_postcode" value="12831">
                                                        </div>
                                                    </li>
                                                </ul>
                                                <div class="buttons-set">
                                                    <button type="button" onclick="coShippingMethodForm.submit()" class="button"><span><span>Check</span></span></button>
                                                </div>
                                            </fieldset>
                                        </form>
                                        <script type="text/javascript">
                                            //<![CDATA[
                                            //new RegionUpdater('country', 'region', 'region_id', {"config":{"show_all_regions":true,"regions_required":["AT","CA","EE","FI","FR","DE","LV","LT","RO","ES","CH","US"]},"US":{"1":{"code":"AL","name":"Alabama"},"11":{"code":"AK","name":"Alaska"},"31":{"code":"AZ","name":"Arizona"},"41":{"code":"AR","name":"Arkansas"},"111":{"code":"CA","name":"California"},"121":{"code":"CO","name":"Colorado"},"131":{"code":"CT","name":"Connecticut"},"141":{"code":"DE","name":"Delaware"},"151":{"code":"DC","name":"District of Columbia"},"171":{"code":"FL","name":"Florida"},"181":{"code":"GA","name":"Georgia"},"191":{"code":"GU","name":"Guam"},"201":{"code":"HI","name":"Hawaii"},"211":{"code":"ID","name":"Idaho"},"221":{"code":"IL","name":"Illinois"},"231":{"code":"IN","name":"Indiana"},"241":{"code":"IA","name":"Iowa"},"251":{"code":"KS","name":"Kansas"},"261":{"code":"KY","name":"Kentucky"},"271":{"code":"LA","name":"Louisiana"},"281":{"code":"ME","name":"Maine"},"301":{"code":"MD","name":"Maryland"},"311":{"code":"MA","name":"Massachusetts"},"321":{"code":"MI","name":"Michigan"},"331":{"code":"MN","name":"Minnesota"},"341":{"code":"MS","name":"Mississippi"},"351":{"code":"MO","name":"Missouri"},"361":{"code":"MT","name":"Montana"},"371":{"code":"NE","name":"Nebraska"},"381":{"code":"NV","name":"Nevada"},"391":{"code":"NH","name":"New Hampshire"},"401":{"code":"NJ","name":"New Jersey"},"411":{"code":"NM","name":"New Mexico"},"421":{"code":"NY","name":"New York"},"431":{"code":"NC","name":"North Carolina"},"441":{"code":"ND","name":"North Dakota"},"461":{"code":"OH","name":"Ohio"},"471":{"code":"OK","name":"Oklahoma"},"481":{"code":"OR","name":"Oregon"},"491":{"code":"PW","name":"Palau"},"501":{"code":"PA","name":"Pennsylvania"},"521":{"code":"RI","name":"Rhode Island"},"531":{"code":"SC","name":"South Carolina"},"541":{"code":"SD","name":"South Dakota"},"551":{"code":"TN","name":"Tennessee"},"561":{"code":"TX","name":"Texas"},"571":{"code":"UT","name":"Utah"},"581":{"code":"VT","name":"Vermont"},"601":{"code":"VA","name":"Virginia"},"611":{"code":"WA","name":"Washington"},"621":{"code":"WV","name":"West Virginia"},"631":{"code":"WI","name":"Wisconsin"},"641":{"code":"WY","name":"Wyoming"}}});
                                            //]]>
                                        </script>


                                        <script type="text/javascript">
                                            //<![CDATA[
                                            var coShippingMethodForm = new VarienForm('shipping-zip-form');
                                            var countriesWithOptionalZip = ["HK","IE","MO","PA"];

                                            var formElements = jQuery('#shipping-zip-form').find('input');

                                            formElements.on('focusout', function(){
                                                var country = $F('country');
                                                var optionalZip = false;

                                                for (i=0; i < countriesWithOptionalZip.length; i++) {
                                                    if (countriesWithOptionalZip[i] == country) {
                                                        optionalZip = true;
                                                    }
                                                }
                                                if (optionalZip) {
                                                    $('postcode').removeClassName('required-entry');
                                                }
                                                else {
                                                    $('postcode').addClassName('required-entry');
                                                }
                                            });
                                            coShippingMethodForm.submit = function () {
                                                var country = $F('country');
                                                var optionalZip = false;

                                                for (i=0; i < countriesWithOptionalZip.length; i++) {
                                                    if (countriesWithOptionalZip[i] == country) {
                                                        optionalZip = true;
                                                    }
                                                }
                                                if (optionalZip) {
                                                    $('postcode').removeClassName('required-entry');
                                                }
                                                else {
                                                    $('postcode').addClassName('required-entry');
                                                }
                                                return VarienForm.prototype.submit.bind(coShippingMethodForm)();
                                            }
                                            //]]>
                                        </script>

                                    </div>
                                </div -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="totals">
                    <table id="shopping-cart-totals-table">
                        <colgroup><col>
                            <col width="1">
                        </colgroup><tfoot>
                        <tr>
                            <td style="" class="a-right" colspan="1">
                                <strong>Grand Total</strong>
                            </td>
                            <td style="" class="a-right">
                                <strong><span class="price">{{$cartTotal}}</span></strong>
                            </td>
                        </tr>
                        </tfoot>
                        <tbody>
                        <tr>
                            <td style="" class="a-right" colspan="1">
                                Subtotal    </td>
                            <td style="" class="a-right">
                                <span class="price">{{$cartSubtotal}}</span>    </td>
                        </tr>
                        <tr class="summary-total">
                            <td style="" class="a-right" colspan="1">
                                <div class="summary-collapse">Shipping</div>
                            </td>
                            <td style="" class="a-right"><span class="price">{{$cartShipping}}</span></td>
                        </tr>

                        <!--tr class="summary-details-1 summary-details summary-details-first" style="display:none;">
                            <td class="a-right" style="" colspan="1">
                                NY STATE TAX                                    (4%)
                                <br>
                            </td>
                            <td style="" class="a-right" rowspan="1">
                                <span class="price">$6.00</span>                </td>
                        </tr>

                        <tr class="summary-details-1 summary-details" style="display:none;">
                            <td class="a-right" style="" colspan="1">
                                NY COUNTY TAX                                    (3%)
                                <br>
                            </td>
                            <td style="" class="a-right" rowspan="1">
                                <span class="price">$4.50</span>                </td>
                        </tr-->
                        <tr class="summary-total" onclick="expandDetails(this, '.summary-details-1')">
                            <td style="" class="a-right" colspan="1">
                                <div class="summary-collapse">Tax</div>
                            </td>
                            <td style="" class="a-right"><span class="price">{{$cartTax}}</span></td>
                        </tr>


                        </tbody>
                    </table>
                    <ul class="checkout-types">
                        <li>    <button type="button" title="Checkout" class="button btn-proceed-checkout btn-checkout" onclick="window.location='/checkout/';">
                                <span><span>Checkout</span></span>
                            </button>
                        </li>
                        <li>
                        </li>
                    </ul>
                </div>
                <button type="button" title="Continue Shopping" class="button utility btn-continue" onclick="setLocation('/')">
                    <span><span>Continue Shopping</span></span>
                </button>
                <p class="cart-help">Need help? Call <strong>1-702-998-1795</strong></p>

            </div>

            <div class="cart-products">
                <form action="" method="post">
                    <input name="form_key" type="hidden" value="WcR3N3g6FDgsEDRq">
                    <table id="shopping-cart-table" class="data-table products-table cart-table stacked">
                        <colgroup><col width="1">
                            <col>
                        </colgroup><tbody>
                        @foreach($cartContent as $item)
                           <tr>
                                <td>
                                    <a href="#" title="{{$item->name}}" class="product-image">
                                        <img src="/productimages/{{$item->category}}/{{$item->sku}}_1.jpg" width="300" alt=""></a>
                                </td>
                                <td>
                                    <h2 class="product-name">
                                        <span>{{$item->sku}}</span>
                                        <a href="{{$item->productURL}}">{{ucwords($item->name)}}</a>
                                        <span class="price">${{number_format($item->price, 2)}}</span>
                                    </h2>
                                    <div class="lower-container">
                                        <dl class="item-options">
                                            <dt>Qty</dt>
                                            <dd>{{$item->qty}}</dd>
                                            @foreach($item->options as $key => $option)
                                            <dt>{{$key}}</dt>
                                            <dd>{{$option}}</dd>
                                            @endforeach
                                        </dl>
                                        <a href="/cartremove/?id={{$item->rowId}}" title="Remove" class="btn-remove btn-remove2"><span>Remove</span></a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </form>


            </div>
        </div>
    </div>
        @endif

</div>


@include('footer')