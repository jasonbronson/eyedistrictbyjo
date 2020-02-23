@include('header')

<div class="page">

    @include('header-ribbon')

<div class="main col1-layout">
    <div class="col-main">
        <div class="opc-wrapper clearfix">
            <div class="checkout">
                <div class="page-title">
                    <h1>Payment</h1>
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


                            <li id="payment-progress-opcheckout" class="active">

                                <div class="progress-step">
                                    Payment</div>

                            </li>
                        </ol>

                    </div>


                    
                    
                </div>

                <div>

                    <div id="checkout-review-table-wrapper" class="review-section">
                        <table class="data-table products-table" id="checkout-review-table">
                            <tbody>
                            @if(isset($cartContent))
                            @foreach($cartContent as $item)
                            <tr>
                                <td>
                                    <a href="#" title="" class="product-image">            
                                    <img src="/media/catalog/product/cache/1/thumbnail/340x200/9df78eab33525d08d6e5fb8d27136e95/U/U/UUF-17S-U301_94_02.jpg" width="340" alt="">
                                    </a>	
                                </td>
                                <td>
                                    <div class="product-name">
                                        <a href="{{$item->productURL}}">{{ucwords($item->name)}}</a>
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
                            <tr>
                                <td style="" class="a-right" colspan="2">
                                
                                </td>
                                <td style="" class="a-right">
                                <form action="/checkout/payment/" method="POST">
                                <script
                                    src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                                    data-key="{{config('services.stripe.key')}}"
                                    data-amount="{{$stripeTotal}}"
                                    data-name="EyeDistrictByJo"
                                    data-description="Checkout"
                                    data-zip-code="true"
                                    data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
                                    data-email="{{$email}}"
                                    data-locale="auto">
                                    
                                </script>
                                {{csrf_field()}}
                                </form>
                                </td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                
                         

            </div>

        </div>


    </div>
</div>


</div>


@include('footer')
