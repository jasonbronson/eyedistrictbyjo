@include('header')

<script src="/js/owl.carousel.js" type="text/javascript">
</script>    

<div class="page">
    @include('header-ribbon')

    <div class="centering">
        <div class="breadcrumbs row">
            <ul class="grid-8">
                <li class="home">
                    <a href="/" title="Go to Home Page">Home</a>
                    <span>/</span>
                </li>
                <li class="category81">
                    {{strtolower($category)}}
                    <span>/</span>
                </li>
                <li class="product">
                    <span>{{$sku}}</span>
                </li>
            </ul>
        </div>
    </div>

    <div class="main col1-layout">
        <div class="col-main">

            <div id="messages_product_view">

            </div>
            <div class="product-view " itemscope="" itemtype="http://schema.org/Product">
                <form action="" method="post" id="product_addtocart_form">
                    <div class="no-display">
                        <input type="hidden" name="product" value="{{$sku}}">
                    </div>
                    <div class="product-essential">
                        <div class="product-name">
                            <h1 itemprop="name">{{$sku}}</h1>
                        </div>

                        <div class="option-container attribute-container frame-color section">
                            <h3 class="red sr-only">
				<span class="option-title">Frame Color</span> <span class="selection-img"><img src="{{$image1}}" width="50px"></span>

			</h3>
                            <div class="section-container">
                                <div class="inner">
                                    <!--ul class="swatches" id="amconf-images-10294-1831">
                                    <li class="swatch selected" data-attribute="10294-1831-3521" id="amconf-images-container-10294-1831-3521"><img src="//www.jins.com/us/media/catalog/product/cache/5cbb7f4086f3d4dabf7a95c2eb211215.jpg" class="amconf-image" alt="Brown Tortoise" title="Brown Tortoise"></li>
                                    <li class="swatch" data-attribute="10294-1831-2081" id="amconf-images-container-10294-1831-2081"><img src="//www.jins.com/us/media/catalog/product/cache/4e7df9ecf60e0ae86767f81a7f902ee3.jpg" class="amconf-image" alt="Gold" title="Gold"></li>
                                    <li class="swatch" data-attribute="10294-1831-3526" id="amconf-images-container-10294-1831-3526"><img src="//www.jins.com/us/media/catalog/product/cache/d083c1194b3f4646abccbb91e22913d2.jpg" class="amconf-image" alt="Moss Green" title="Moss Green"></li>
                                    <li class="swatch" data-attribute="10294-1831-2011" id="amconf-images-container-10294-1831-2011"><img src="//www.jins.com/us/media/catalog/product/cache/9e711966edaf46df0970bd9d7a836391.jpg" class="amconf-image" alt="Red" title="Red"></li>
                                </ul-->
                                    <select name="super_attribute[1831]" id="attribute1831" class="required-entry super-attribute-select no-display">

                                        <option value="">Choose an Option...</option>
                                        <option value="3521">Brown Tortoise</option>
                                        <option value="2081">Gold</option>
                                        <option value="3526">Moss Green</option>
                                        <option value="2011">Red</option>
                                    </select>
                                </div>
                                <span class="toggle show700"><span class="more">More</span><span class="less">Less</span></span>
                                <p class="selection a-center">@isset($details['color']) {{$details['color']}} @endisset</p>
                            </div>
                        </div>

                        <div class="product-img-box" style="">
                            <div class="main-image-container show">

                                <figure class="product-image loaded" id="main-image">
                                    <div id="pdp-slider" class="owl-carousel owl-loaded">

                                        <div id="owl-glasses" class="owl-carousel owl-theme">

                                                <div class="item"><img src="/productimages/{{$sku}}_1.jpg" alt=""></div>
                                                <div class="item"><img src="/productimages/{{$sku}}_2.jpg" alt=""></div>
                                                <div class="item"><img src="/productimages/{{$sku}}_3.jpg" alt=""></div>
                                                <div class="item"><img src="/productimages/{{$sku}}_4.jpg" alt=""></div>
                                                <!--div class="item"><img src="/watermark2.php?filename={{$sku}}_2.jpg&size={{$size}}"></div-->
                                                <div class="item"><img src="/watermark.php?filename={{$sku}}_3.jpg&size={{$size}}"></div>
                                        </div>
                                        
                                    </div>
                                    

                                </figure>

                            </div>
                        </div>
                    </div>
                    <div class="product-shop clearfix">
                        <div id="selection-template" class="no-display">
                            <span class="price"></span> <span class="copy"></span>
                        </div>
                        <div class="product-main-selection product-options" id="product-options-wrapper">

                            <div class="option-container frame-fit section">
                                <!-- here -->
                                <div class="product-main-details">
                                        <div class="details section">
                                            <div class="section-container">
                                                <div class="inner">
                
                                                    
                                                    
                                                    <div class="std description" itemprop="description"></div>
                                                    <div class="additional-info">
                                                        <ul class="attribute-list clearfix" id="attribute-list">
                                                            <li class="odd">
                                                                <span class="label">SKU</span>
                                                                <span class="data" itemprop="sku">{{$sku}}</span>
                                                            </li>
                                                            <li class="even">
                                                                <span class="label">Material Type</span>
                                                                <span class="data" itemprop="material">{{$material}}</span>
                                                            </li>
                                                            <!--li class="even">
                                                                <span class="label">Pairs included</span>
                                                                <span class="data" itemprop="material">{{$pairs}}</span>
                                                            </li-->
                                                            <li class="even">
                                                                <span class="label">Size</span>
                                                                <span class="data" itemprop="material">{{$size}}</span>
                                                            </li>    
                                                            
                                                            @foreach($details as $detail)
                                                            <li class="even">
                                                                <div class="label">Frame Shape </div>
                                                                <span class="data">Other</span>
                                                            </li>
                                                            <li class="odd">
                                                                <div class="label">Frame Type </div>
                                                                <span class="data">Full Rim</span>
                                                            </li>
                                                            @endforeach
                
                                                        </ul>
                                                        <script type="text/javascript">
                                                            decorateList($('attribute-list'), ['odd', 'even', 'first', 'last'])
                                                        </script>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                
                                    </div>

                            </div>

                            <div class="option-container product-main-info">

                                
                                <div class="add-to-box">
                                    <div class="alert-stock-hidden alert-stock link-stock-alert">
                                        <h3>Out of stock</h3>
                                        <!--a href="" title="Notify me when back in stock" data-href="productalert/add/stock/product_id//uenc/aHR0cHM6Ly93d3cuamlucy5jb20vdXMvd29tZW4vd29tZW4tb3B0aWNhbC9sbWYtMTZhLTI2OC5odG1s/" class="button btn-notify-oos utility">
        Notify me when back in stock    </a-->
                                    </div>
                                    <div class="add-to-cart loader-container">
                                        <script type="text/javascript">
                                            function addCart() {
                                                //location.href = "/addcart/{{$sku}}";
                                                location.href = "/locations/";
                                            }
                                        </script>
                                        <button type="button" title="Add to Cart" class="button btn-cart" onclick="addCart()"><span><span>Locate Store</span></span>
                                        </button>

                                    </div>
                                </div>

                                <div class="price-wrap">

                                    <div class="price-box">

                                        <span class="regular-price" id="product-price-10294" itemprop="price">
													<span class="price">${{$price}}</span>
                                        </span>

                                    </div>

                                </div>

                                <p class="availability in-stock">Availability: <span>In stock</span></p>
                            </div>
                        </div>

                        <div class="swatches-bg"></div>

                    </div>
                   
                </form>
            </div>

        </div>
    </div>

</div>
<!-- end of page div -->

<script>
        jQuery(document).ready(function() {
 
            jQuery("#owl-glasses").owlCarousel({
           
                navigation : true, // Show next and prev buttons
                slideSpeed : 300,
                paginationSpeed : 400,
                singleItem:true
           
                // "singleItem:true" is a shortcut for:
                // items : 1, 
                // itemsDesktop : false,
                // itemsDesktopSmall : false,
                // itemsTablet: false,
                // itemsMobile : false
           
            });
           
          });
</script>    


<div class="loader" style="display: none;"><img alt="" src="/media/ajax-loader.gif"></div>
@include('footer')