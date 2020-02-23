@include('header')

<div class="page">
    @include('header-ribbon')
    <div class="centering">
        <div class="page-title copy-space category-title">
            <div class="row">
                <div class="grid-12">
                    @if(count($products) > 0)
                    <h1>{{$type}}</h1>
                    <p class="style-count">Viewing {{count($products)}} items </p>
                    @else
                        <h1>No products found</h1>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="main col1-layout">
        <div class="col-main">
            <div class="category-view">
                <div class="col-left">
                    @include('partials.toolbartop') 
                    @include('partials.toolbarfilter')
                </div>
                @if(count($products) > 0)
                <div class="category-products" data-background="/media/girls-with-glasses-3.jpg">
                    <div class="col-4-grid transition-in ready">
                        <ul class="products-grid row first last odd height-fixed">
                        @foreach($products as $item)
                            <li class="grid-2 item first" style="height: 193px;">
                                <div class="content boxed">
                                    <a href="{{$item->sku}}" class="product-image">
                                        <figure class="product-image">
                                            @if( file_exists(public_path('productimages')."/{$item->sku}_1.jpg") )
                                                    <img src="/productimages/{{$item->sku}}_1.jpg" data-src="/productimages/{{$item->sku}}_1.jpg" class="img-responsive">
                                                @if( file_exists(public_path('productimages')."/{$item->sku}_2.jpg") )
                                                    <img class="alt-image img-responsive" src="" data-src="/productimages/{{$item->sku}}_2.jpg">
                                                @else
                                                    <img class="alt-image img-responsive" src="" data-src="/productimages/none.jpg">
                                                @endif
                                            @else
                                                <img src="/productimages/none.jpg" data-src="/productimages/none.jpg" class="img-responsive">
                                            @endif
                                        </figure>
                                    </a>
                                    <div class="additional">
                                        <div class="info clearfix">
                                            <h2 class="product-name"><a href="{{$item->sku}}">{{$item->sku}}</a></h2>
                                            <div class="price-box">
                                               <span class="price">${{$item->price}}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                            
                        </ul>
                    </div>
                </div>
                @endif



                @include('partials.toolbarbottom')

            </div>
        </div>
    </div>
    <span class="framefit-tip-container">
        <div data-attr-type="standard-fit"><strong>Standard fit</strong> - lower nose pads</div>
        <div data-attr-type="alternative-fit"><strong>Alternative fit</strong> - higher nose pads</div>
        <div data-attr-type="adjustable"><strong>Adjustable</strong> - can be adjusted</div> 
    </span>


</div>
<!-- end of page div -->

<div class="loader" style="display: none;"><img alt="" src="/media/ajax-loader.gif"></div>
@include('footer')