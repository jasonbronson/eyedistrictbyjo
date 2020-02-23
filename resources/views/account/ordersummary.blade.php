@include('header')

<div class="page">

    @include('header-ribbon')

<div class="main col2-left-layout">

    @include('account.account-nav')

    <div class="col-main">
        <div class="my-account clearfix">
           <div class="dashboard">
                <div class="order-info">
                    <h3 class="sub-title2">Order # {{$orderid}}</h3>
                    
                    <div id="checkout-review-table-wrapper" class="review-section">
                        <table class="data-table products-table" id="checkout-review-table">
                            <tbody>
                            @if(isset($cartItems))
                            @foreach($cartItems as $item)
                           
                            <tr>
                                <td>
                                    <a href="#" class="product-image">            
                                    <img src="" width="340">
                                    </a>	
                                </td>
                                <td>
                                    <div class="product-name">
                                        <a href="{{$item->productURL}}" target="_blank">{{ucwords($item->name)}} {{$item->item_id}}</a>
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
                        </div>                
                        <div class="block block-progress opc-block-progress">
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
                
            </div>
            
        </div>
    </div>
</div>


</div>


@include('footer')