@include('header')

<div class="page">

    @include('header-ribbon')

<div class="main col2-left-layout">

    @include('account.account-nav')

    <div class="col-main">
        <div class="my-account clearfix"><div class="dashboard">
                <div class="personal-info">
                    <h3 class="sub-title">Order History</h3>
                    <ul class="field-list">
                    @foreach($orders as $order)
                        <li>
                            <span>Order# {{$order->id}}</span>
                            <span><a href="/account/order-history/{{$order->id}}/">View Order</a> </span>
                        </li>
                    @endforeach    
                    </ul>
                </div>
        </div>
    </div>
</div>


</div>


@include('footer')