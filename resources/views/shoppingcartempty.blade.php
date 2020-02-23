@include('header')

<div class="page">

    @include('header-ribbon')

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
                            <p>Start shopping to fill it up!</p>
                            <a href="/" class="button utility">Continue Shopping</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>


@include('footer')