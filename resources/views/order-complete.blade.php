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

                            
                        </ol>

                    </div>


                    
                    
                </div>

                <div>
                <h3>Order Complete </h3>
                <p>Your order is now complete if we have any questions we will reach out to you.</p>
                <p>Order #@if (session('order_id')) {{ session('order_id') }}@endif
                    
                </p>    
                <p>
                <button type="button" title="Checkout" class="button btn-proceed-checkout btn-checkout" onclick="window.location='/account/order-history/';">
                    <span><span>View Order Here</span></span>
                </button> 
                            
                </p>
                </div>
                
                         

            </div>

        </div>


    </div>
</div>


</div>


@include('footer')
