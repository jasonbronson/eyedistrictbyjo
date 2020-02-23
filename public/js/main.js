;

!function($) {

    $.fn.SwatchHover = function() {
        return this.each(function() {
            /**
             * Swatching transition for hover
             */
            if ($(this).attr('hoverIntent_t')) {
                return;
            }

            $(this).data('parent') || ($(this).data('parent', '.swatches'));

            $(this).hoverIntent({
                over: function(e) {
                    var $_p = $(this).parents($(this).data('parent'));
                    $(this).addClass('over');

                    // if !selected swatch, find selected and suppress it
                    !$(this).hasClass('selected') && $_p.find('.selected').addClass('suppress');
                },
                out: function(e) {
                    var $_p = $(this).parents($(this).data('parent'));
                    $(this).removeClass('over');

                    // Added to handle for selecting a swatch via click to prevent the hover from removing this
                    if ($_p.hasClass('clicked')) {
                        $_p.removeClass('clicked');
                        $_p.find('.suppress').removeClass('suppress');
                        return;
                    }
                    // end

                    // if !selected swatch and no other swatches have the 'over' class - show default state
                    if (!$(this).hasClass('selected') && !$_p.find('.over:not(.selected)').length) {
                        $_p.find('.suppress').removeClass('suppress');
                    }
                },
                timeout: 150,
                sensitivity: 8,
                interval:30
            });
        });
    };

    // Readied
    $(function() {
        var $header = $('.header'),
            $body = $('body');
            $navContainer = $(".nav-container"),
            $nav = $("#nav"),
            $navSpiff = $('#hp-spiff'),
            $arrowDown = $('.arrow-down'),
            $menuCat = $('#menu-cat'),
            $menuPane = $('#menu-pane'),
            $menuTrigger = $("#menu-trigger"),
            $mobileUtilities = $('#mobile-utilities'),
            $collectionBanner = $('.cat-landing .banner-full:first-child'),
            $footer = $('.footer'),
            $headerInner = $('.header-inner'),
            $leftNav = $('.left-nav');
        timeout = null;

        /Trident\/7\./.test(navigator.userAgent) && $('html').addClass('ie11');
        /Trident\/6\./.test(navigator.userAgent) && $('html').addClass('ie10');
        /(ie[0-9]{1,2})/.test($('html').attr('class')) && $('html').addClass('is-ie');



        /**
         * ie8 fixes for dom api usage for plugins - something is up with
         * minifying and how ie8 is working with the JS. No time to further
         * investigate the issue
         */
        if ($('html').hasClass('ie8')) {
            /**
             * Dom loaded data api usage
             */
            $(document).on('click.Carousel', '.carousel-control', function(e) {
                var $this = $(this),
                    $parent = $this.parents($this.attr('href'));
                $parent.Carousel('transition', $this.data('direction'));
                e.preventDefault();
            });
            $(document).on('click.Moby', '[data-moby]', function(e) {
                var $this = $(this),
                    $target = $($this.data('target') || $this.attr('href'));
                $target.Moby($this.data('moby'));
                $this.is('a') && e.preventDefault();
            });
        }

        $(document).on('shown.Moby', '.moby', function(e) {
            $('body').addClass('moby-shown');
        })
            .on('hidden.Moby', '.moby', function(e) {
                $('body').removeClass('moby-shown');
            });

        //Fixed header
        $(window).scroll(function() {
            if ($(this).scrollTop() > 1){
                $headerInner.addClass('sticky');
            }
            else{
                $headerInner.removeClass('sticky');
            }
        });

        /**
         * Apply background image from data attribute
         * when it gets tablet view
         *
         */

        if($('body.category-collections').length){
            var $screenWidth = $(window).width(),
                $bkgs = $('.entrance-bg');
            for (var i=0; i<$bkgs.length; i++){
                var desktopSrc = $($bkgs[i]).data('srcdesc'),
                    mobileSrc = $($bkgs[i]).data('srcmob');
                if ($screenWidth < '767') {
                    $($bkgs[i]).css('background', 'url("'+ mobileSrc+ '") center no-repeat');
                }else {
                    $($bkgs[i]).css('background', 'url("'+ desktopSrc+ '") center no-repeat');
                }
            }
        }

        function bkgResize () {
            if($('.sup-collection').length){
                var $screenWidth = $(window).width(),
                    $bkgs = $('.banner-full');
                for (var i=0; i<$bkgs.length; i++){
                    var desktopSrc = $($bkgs[i]).data('srcdesc'),
                        mobileSrc = $($bkgs[i]).data('srcmob');
                    if ($screenWidth < '480') {
                        $($bkgs[i]).css('background-image', 'url("'+ mobileSrc+ '")');
                    }else {
                        $($bkgs[i]).css('background-image', 'url("'+ desktopSrc+ '")');
                    }
                }
            }
        }


        if($('.sup-collection').length) {
            bkgResize();
            $(window).resize(bkgResize);
        }


        /**
		 * Helper function to show/hide menus in/out of view without
		 * css transitions having any effect
		 *
		 * @param $flag (boolean)
		 */
		function transitionMenu($flag) {
			$navContainer.removeClass('transitionable') && window.clearTimeout(timeout);
			if ($flag) {
				timeout = window.setTimeout(function() {
					$navContainer.addClass('transitionable');
				}, 350);
			}
		}

        /**
         * Helper function to show/hide menus in/out of view without
         * css transitions having any effect
         *
         * @param $flag (boolean)
         */
        function transitionMenu($flag) {
            $navContainer.removeClass('transitionable') && window.clearTimeout(timeout);
            if ($flag) {
                timeout = window.setTimeout(function() {
                    $navContainer.addClass('transitionable');
                }, 350);
            }
        }

        /**
         * Handles transitioning of the search menu for responsive
         *
         * @param forceClose
         */
        function transitionSearch(forceClose) {
            var $_search = $('#mobile_search_mini_form');

            // check if revealed and show/hide accordingly
            if (forceClose || $_search.hasClass('reveal')) {
                $_search.addClass('out').removeClass('reveal in');
                $mobileUtilities.find('.search').removeClass('opened');
            } else {
                $_search.addClass('reveal in').removeClass('out');
                $mobileUtilities.find('.search').addClass('opened');
            }
        }


        /**
         * Overwrite the unset functionality for additional needs (inner container height adjustment
         */
        $.extend(Gorilla.ResponsiveMenu.prototype, {
            unset : function() {
                // unbind events
                $(window).off('resize.ResponsiveMenu');
                this.$el.off('.ResponsiveMenu').removeClass('opened');
                this.$navigation.removeClass('transitioning opened').find('.inner-container').height('');
                this.$el.data('ResponsiveMenu', '');
                $('body').removeClass('menu-opened');
            }
        });

        /**
         * Calculates height of sub menus
         */
        function calculateSubMenuHeight() {
            //var height = +self.$navigation.find('.inner-container').height() - parseInt($navContainer.find('#search_mini_form').outerHeight(true, true));
            var height = parseInt(self.$navigation.find('.inner-container').css('height'), 10);
            $menus.each(function() {
                $(this).css('height', height);
            });
        }

        /**
         * Adds class if it should be full-width layout
         */
        if ($('.screen-page').length){
            $('body').addClass('is-full-width');
        }


        /**
         * Change image when it gets tablet view
         */

        function imageresize(){
            var $screenWidth = $(window).width(),
                $imgs = $('.js-set-image').find('img');
            for (var i=0; i<$imgs.length; i++){
                var desktopSrc = $($imgs[i]).data('src'),
                    mobileSrc = $($imgs[i]).data('mob');
                if ($screenWidth < '768') {
                    $($imgs[i]).attr('src', mobileSrc);
                }else {
                    $($imgs[i]).attr('src', desktopSrc);
                }
            }

        }
        if($('.js-set-image').length) {
            imageresize();
            $(window).resize(imageresize);
        }

        /**
         * Collection page: position arrow on bottom of screen (if too low)
         */
        if ($('.category-collections').length && ($('.arrow-down').length == 1)){
            screenHeight = $(window).height();
            $arrowDown = $('.arrow-down');
            arrowPos = $arrowDown.offset();
            arrowTop = arrowPos.top;
            arrowHeight = $arrowDown.height();
            arrowBot = arrowTop + arrowHeight;  // bottom position of the arrow
            if (arrowBot > screenHeight) {
                heightDiff = (arrowBot - screenHeight + 40)* -1;
                $arrowDown.css('margin-top',heightDiff+'px');
            }

            $arrowDown.on('click',function(e){
                $(this).removeAttr('style');
            });
        }

        /**
         * Responsive JS begins - see comments for specific break points
         * and additional notes for functionality
         */


        Respond.to([
            {
                /**
                 * Main break for header & navigation
                 */
                'media' : '(max-width: 780px)',
                'namespace' : '780_collection_banners',
                'fallback' : 'else',	// ie8 fallback callback (optional - defaults to 'if' callback)
                'if' : function() {
                    // tablet

                    if($('body.cms-collection-html').length) {
                        // make first banner same height as screen height
                        vpHeight = $(window).height();
                        bannerPos = $collectionBanner.offset();
                        bannerTop = bannerPos.top+20;
                        bannerHeight = 'calc(100vh - '+bannerTop+'px)';
                        $collectionBanner.css('height',bannerHeight);
                        $arrowDown.removeAttr('style');
                    }

                },
                'else' : function() {

                    if($('body.cms-collection-html').length) {
                        // make first banner same height as screen height
                        $('.cat-landing .banner-full:first-child').css('height','760px');


                        screenHeight = $(window).height();
                        arrowPos = $arrowDown.offset();
                        arrowTop = arrowPos.top;
                        arrowHeight = $arrowDown.height();
                        arrowBot = arrowTop + arrowHeight;  // bottom position of the arrow
                        if (arrowBot > screenHeight) {
                            heightDiff = (arrowBot - screenHeight + 35)* -1;
                            $arrowDown.css('margin-top',heightDiff+'px');
                        }

                        $arrowDown.on('click',function(e){
                            $(this).removeAttr('style');
                        });

                    }
                }
            }
        ]);




        Respond.to([
            {
                /**
                 * Main break for header & navigation
                 */
                'media' : '(max-width: 700px)',
                'namespace' : '700_header_nav',
                'fallback' : 'else',	// ie8 fallback callback (optional - defaults to 'if' callback)
                'if' : function() {
                    // unsets



                    // if empty populate the cart link for mobile if not created... sigh
                    if (!$mobileUtilities.find('.cart-link .placeholder').html()) {
                        $mobileUtilities.find('.cart-link').html($('.top-cart').find('.cart-link a').clone());
                    }


                    // Search Menu Functionality
                    $mobileUtilities.find('.search').on('click.ResponsiveSearch', function(e) {
                        // check if menu is opened: hide menu, after menu close, show search
                        if ($('body').hasClass('menu-opened')) {
                            // bind menu trigger data to close search on responsive menu close (only bound if search is opened first)
                            $menuTrigger.data('ResponsiveMenu').$navigation.on('closed.ResponsiveMenu', function(e) {
                                transitionSearch();
                                $(this).off('closed.ResponsiveMenu');
                            });
                            $menuTrigger.trigger('click');
                        } else {
                            transitionSearch();
                        }
                        e.preventDefault();
                        return false;
                    });
                },
                'else' : function() {
                    // unsets
                    $menuTrigger.ResponsiveMenu('unset');
                    //$header.parents('.page').off('click.ResponsiveMenu');
                    $nav.find('li.parent > a.level-top').off('click.SubMenu');
                    transitionSearch(true);
                }
            },

            /**
             * Main break for footer
             */
            {
                'media' : '(max-width: 1024px)',
                'namespace' : '780_footer',
                'fallback' : 'else',	// ie8 fallback callback (optional - defaults to 'if' callback)
                'if' : function() {
                    $footer.find('.accord').addClass('accordion').Accordion({
                        'headers': '.section h4',
                        'containers': '.section h4 + div',
                        'childrenSelector': '> .footer-content'
                    })
                        .find('.section h4 + .footer-box').addClass('closed');
                },
                'else' : function() {
                    // Footer: Remove accordion class + styles and unset
                    $footer.find('.accordion')
                        .removeClass('accordion')
                        .Accordion('unset')
                        .find('.section h4 + .footer-box')
                        .removeClass('closed');
                }
            }
        ]);

        /**
         * Left Navigation Accordion at mobile breakpoint
         */
        if ($leftNav.length) {
            Respond.to({
                'media' : '(max-width: 700px)',
                'namespace' : '700_leftnav',
                'fallback' : 'else',
                'if' : function() {
                    $leftNav.addClass('accordion').Accordion({
                        'headers': '.block-title',
                        'containers': '.block-content',
                        'childrenSelector': '> ul'
                    });
                },
                'else' : function() {
                    $leftNav.removeClass('accordion')
                        .Accordion('unset')
                        .find('.block-content')
                        .removeClass('closed');
                }
            });
        }

        /**
         * Home carousel functionality
         *
         * @type {*|HTMLElement}
         */
        if($('.collectionArea').length){
            var $carousel = $('#carousel'),
                $slideThumbl = $('.carousel-links li a'),
                startSlideIndex = 1;
            $carousel.owlCarousel({
                items: 1,
                dots: true,
                animateIn: 'fadeIn',
                animateOut: 'fadeOut',
                mouseDrag: false,
                touchDrag: false
            });
            $carousel.trigger('to.owl.carousel', startSlideIndex);
            $slideThumbl.each(function(){
                if ($(this).data('index') === startSlideIndex){
                    $(this).addClass('active');
                }
            });
            $slideThumbl.on('click', function(e) {
                e.preventDefault();
                var $index = $(this).data('index');
                $carousel.trigger('to.owl.carousel', $index);
                $slideThumbl.removeClass('active');
                $(this).addClass('active');
            });
        }

        if($('#carousel2').length){
            var $carousel2 = $('#carousel2');
            if($carousel2.find('.keyImg').size()>1) {
                $carousel2.owlCarousel({
                    items: 1,
                    dots: false,
                    nav: false,
                    animateIn: 'fadeIn',
                    animateOut: 'fadeOut',
                    autoplay:true,
                    autoplayHoverPause:true,
                    loop: true,
                    navText: ['<i class="icon-arrow-l"></i>','<i class="icon-arrow-r"></i>']
                });
            } else {
                $carousel2.attr('class','');
            }
        }

        /*
         *	Lenses Carousel on Home page
         */

        var $lensesCarousel = $('.lenses-carousel');
        if($lensesCarousel.length){
            $lensesCarousel.owlCarousel({
                items: 	1,
                dots: 	true,
                nav: 	true,
                navText: ['<i class="icon-arrow-l"></i>','<i class="icon-arrow-r"></i>'],
                loop:	true,
                animateIn: 'fadeIn',
                animateOut: 'fadeOut'
            });

        }

        /**
         * Image lazy loading for all img's with a product-image or category-image container
         */
        $('.product-image, .category-image').find('img').unveil(200);

        //if($('.product-view.not-configurable').length){
        //    window.setTimeout(function() {
        //        $('.main-image-container').removeClass('hide').addClass('show');
        //    }, 400);
        //}

        //Image loads randomly on HomePage
        var imgArray = [
                { id_: 'pc', cls_: 'fall_desktop jsLoad-FullScreenImages', width_: 2400, height_: 1190 },
                { id_: 'pad_a', cls_: 'fall_tab_a jsLoad-FullScreenImages', width_: 1200, height_: 800 },
                { id_: 'pad_b', cls_: 'fall_tab_b jsLoad-FullScreenImages', width_: 768, height_: 946 },
                { id_: 'sp', cls_: 'fall_mobile jsLoad-FullScreenImages', width_: 640, height_: 800 }],
            rand_key = Math.floor(Math.random() * 10 % 4) + 1,
            // random number
            elem = '';

        for (var i = 0, iLen = imgArray.length; i < iLen; i++) {
            var obj = imgArray[i];
            elem += '<div class="' + obj.cls_ + '" style="background-image:url(/us/media/wysiwyg/movie/images/key_' + obj.id_ + '_' + rand_key + '.jpg)"><\/div>';
        }

        $('#keyMovie-fallback').html(elem);
        /**
         * PL Logic
         */
        var $toFixHeight = $('.transition-in');
        if ($toFixHeight.length) {
            Gorilla.utilities.rowHeightCalculation($toFixHeight, 'li.item', '.content', 200, function() {
                $toFixHeight.addClass('ready');
            });

            // handle resizing for height calculations
            $(window).on('resize.fixHeight', Gorilla.utilities.throttle(function() {
                Gorilla.utilities.rowHeightCalculation($toFixHeight, 'li.item', '.content', 200);
            }, 75));

            // fix for slower networks to trigger height calculation as images are still being loaded over the course of 2 seconds
            var tallnessCtr = 0,
                tallnessInterval = window.setInterval(function() {
                    Gorilla.utilities.rowHeightCalculation($toFixHeight, 'li.item', '.content', 200, function() {
                        $toFixHeight.addClass('ready');
                    });
                    (tallnessCtr++ > 10) && window.clearInterval(tallnessInterval);
                }, 200);
        }

        /**
         * PLP
         */
        var $productListing = $('.catalog-category-view');
        if ($productListing.length) {

            $('.category-products .item .content a.product-image' ).each(function(p) {
                $prodLink = $(this).attr('href');

                if($prodLink.indexOf('#') === -1) {
                    $(this).parent().addClass('boxed');
                }
            });

        }


        /**
         * PLP
         */
        var $productListing = $('.catalog-category-view');
        if ($productListing.length) {

            $('.category-products .item .content a.product-image' ).each(function(p) {
                $prodLink = $(this).attr('href');

                if($prodLink.indexOf('#') === -1) {
                    $(this).parent().addClass('boxed');
                }
            });

        }


        /**
         * PL: Filters
         */
        var $layeredNav = $('#layered-navigation'),
            $layeredNavMob = $('#layered-navigation-mob');
        if ($layeredNav.length) {
            $('#filter-trigger').on('click.Filters', function(e) {
                if ($layeredNav.data('busy')) {
                    return;
                }

                var $_content = $layeredNav.find('.block-content-container');
                if ($layeredNav.hasClass('opened')) {
                    $layeredNav.addClass('block-layered-nav-transition');
                    $(this).removeClass('opened');
                    // set the height, force redraw then close
                    $layeredNav.css('height', $_content.css('height'));
                    $.support.transition && $layeredNav[0].offsetWidth;
                    $layeredNav.addClass('closed');

                    if ($.support.transition) {
                        $layeredNav.one($.support.transition.end, function(e) {
                            $layeredNav.data('busy', false).removeClass('opened').removeClass('block-layered-nav-transition');
                        })
                            .emulateTransitionEnd(300);
                    } else {
                        $layeredNav.data('busy', false).removeClass('opened').removeClass('block-layered-nav-transition');
                    }
                } else {
                    $(this).addClass('opened');
                    $layeredNav.addClass('block-layered-nav-transition');
                    $layeredNav.css('height', $_content.css('height')).removeClass('closed');
                    $.support.transition && $layeredNav[0].offsetWidth;
                    $layeredNav.addClass('opened');

                    if ($.support.transition) {
                        $layeredNav.one($.support.transition.end, function(e) {
                            $layeredNav.removeClass('block-layered-nav-transition').data('busy', false).css('height', 'auto');
                        })
                            .emulateTransitionEnd(300);
                    } else {
                        $layeredNav.removeClass('block-layered-nav-transition').data('busy', false).css('height', 'auto');
                    }
                }

                // ie8 fix
                $('html').hasClass('ie8') && $(this).trigger('blur');

                e.preventDefault();
            });

            Respond.to({
                'media' : '(max-width: 767px)',
                'namespace' : '767_filters',
                'fallback' : 'else',
                'if' : function() {
                    $layeredNav.addClass('accordion').Accordion({
                        'headers': '.section h4',
                        'containers': '.section .accord-container',
                        'childrenSelector': '> .narrow-by-list'
                    })
                        .find('.accord-container').addClass('closed');
                    $layeredNavMob.addClass('moby full fade').css('display', 'none');
                },
                'else' : function() {
                    $layeredNav.removeClass('accordion')
                        .Accordion('unset')
                        .find('.accord-container')
                        .removeClass('closed');

                    Gorilla.utilities.resetInputs($layeredNav);
                    $layeredNavMob.removeClass('moby full fade').css('display', 'block');
                }
            });
        }

        var $toolBar = $('.toolbar-top, .toolbar-bottom');
        if ($toolBar.length) {
            $toolBar.find('.menu').Menu({
                onClick: true,
                onClickClose: true,
                triggerSelector: '.trigger',
                menuSelector: '.content'
            });

            if($('.category-layered').length) {
                $('.framefit-tip-container').appendTo('.page');
                $('.tooltip-plp').each(function(){
                    $(this).on({
                        'mouseenter': function mouseenter() {
                            var tips = $(this).parents('.page').find('.framefit-tip-container');
                            var offsets = $(this).offset();
                            var offtop = offsets.top - 100;
                            var offleft = offsets.left -50;
                            tips.css({
                                'top': offtop + 'px',
                                'left': offleft + 'px'
                            }).stop().fadeIn('fast');
                        },
                        'mouseleave': function mouseleave() {
                            var tips = $(this).parents('.page').find('.framefit-tip-container');
                            tips.stop().fadeOut('fast');
                        }
                    });
                });
            }


            /**
             * Handle hiding the toolbar top when no pagination is present (toolbar top
             * has a static height and the limiter is always there so we need a dynamic
             * way to detect if this needs to be hidden or not)
             *
             * @CBourdage removed and moved this into template check.
             */
            /*if (!$toolBarTop.find('.pager .pages').length) {
             $toolBarTop.addClass('no-paging');
             }*/
        }


        /**
         * SET PLP backgrounds
         */
        var $collectionTitle = $('.collections-title'),
            $categoryProducts = $('.category-products');
        if ($collectionTitle.length) {
            $body.css('background-image', ['url("', $categoryProducts.data('background'), '")'].join('')).addClass('background-ready').addClass('collection-plp');
            $('.page').css('background-color', 'transparent');
        }

        if($categoryProducts.length && !$collectionTitle.length) {
            $('.page').css('background-image', ['url("', $categoryProducts.data('background'), '")'].join(''));
        }


        /**
         * Swatching transitional for hover
         */
        $('.swatches').find('.swatch').SwatchHover();


        /**
         * PDP Logic
         *
         * @type {*|HTMLElement}
         */
        var $pdp = $('.product-view');
        if ($pdp.length) {
            var $fixed = $pdp.find('.fix-me'),
                $imgBox = $pdp.find('.product-img-box'),
                $pdpSlider = $('#pdp-slider');

            Gorilla.utilities._cache = {'main' : $imgBox.find('.main')};

            // enabling more views swatchhover
            $imgBox.find('.more-views a')
                .data('parent', '.more-views')
                .SwatchHover();


            $pdpSlider.owlCarousel({
                items: 1,
                dots: true,
                animateIn: 'fadeIn',
                animateOut: 'fadeOut',
                mouseDrag: false,
                touchDrag: true,
                dotsContainer: '#carousel-custom-dots',
                lazyLoad: true,
                onInitialized: function(){
                    $pdpSlider.parent().addClass('loaded');
                }
            });


            /**
             * Handles transitions for alternate images on the PDP.
             */
            $imgBox.on('click', '[data-media]', function(e) {
                var $_mainImage = $('#main-image');

                // check busy first
                if ($_mainImage.data('busy')) {
                    return;
                }

                // Find the next thumbnail to show
                var $_thumbs = $imgBox.find('.more-views a'),
                    $_nextThumb = null;

                var _currentIdx = $_thumbs.index($_thumbs.filter('.selected'));
                if ($(this).data('media') === 'next') {
                    $_nextThumb = $_thumbs.eq(_currentIdx + 1);
                    if (_currentIdx === $_thumbs.length - 1) {
                        $_nextThumb = $_thumbs.first();
                    }
                } else {
                    $_nextThumb = $_thumbs.eq(_currentIdx - 1);
                    if (_currentIdx === 0) {
                        $_nextThumb = $_thumbs.last();
                    }
                }

                transitionMainImage($_mainImage, $_nextThumb);
                e.preventDefault(true);
            })
                .on('click', '.more-views a', function(e) {
                    var $_mainImage = $('#main-image');
                    e.preventDefault();
                    // check active or busy first
                    if ($_mainImage.data('busy') || $(this).hasClass('selected')) {
                        return;
                    }

                    transitionMainImage($_mainImage, $(this));
                    //e.preventDefault();
                });

            // Swipe handling
            $imgBox.swipe({
                excludedElements: '.noSwipe',
                threshold: 200,
                swipeLeft: function(e, dir, dist, duration) {
                    $imgBox.find('[data-media="next"]').trigger('click');
                },
                swipeRight: function(e, dir, dist, duration) {
                    $imgBox.find('[data-media="previous"]').trigger('click');
                }
            });


            /**
             * Handles the main image transitioning and status
             *
             * @param $mainImage jQuery el
             * @param $nextThumb jQuery el
             */
            function transitionMainImage($mainImage, $nextThumb) {
                // set active and busy classes respectively
                $mainImage.data('busy', true);
                $imgBox.find('.more-views .selected').removeClass('selected suppress');
                $nextThumb.addClass('selected');

                if (!Gorilla.utilities._cache[$nextThumb.data('relation')]) {
                    $mainImage.append($('<img src="' + $nextThumb.addClass('active').attr('href') + '" style="display:none;" class="hide in ' + $nextThumb.data('relation') + '" />'));
                    Gorilla.utilities._cache[$nextThumb.data('relation')] = $mainImage.find('.' + $nextThumb.data('relation'));
                }

                var $_current = $mainImage.find('.show'),
                    $_new = Gorilla.utilities._cache[$nextThumb.data('relation')];

                $mainImage.css('min-height', $_current.css('height'));
                $.support.transition && $mainImage[0].offsetWidth;
                $_new.show();

                $_current.addClass('hide').removeClass('show');
                $.support.transition && $_new[0].offsetWidth;

                $_new.addClass('show');

                if ($.support.transition) {
                    // transition current out, then remove classes so it's a staggered fade
                    $_current.one($.support.transition.end, function() {
                        $_new.removeClass('hide in');
                    });
                    $_new.one($.support.transition.end, function() {
                        $mainImage.data('busy', false);
                    });
                } else {
                    //$_current.removeClass('show');
                    $_new.removeClass('hide in');
                    $mainImage.data('busy', false);
                }
            }


            /**
             * Media queries for:
             *  - fixed add to container
             *  - 780 break for accordions on options and details, etc
             *  - similar frames slider > nothing > accordion
             */
            var initialLoad = true;
            Respond.to({
                'media' : '(max-width: 1024px)',
                'namespace' : 'pdp_fixed_addto',
                'fallback' : 'else',
                'if' : function() {

                },
                'else' : function() {
                    (function() {
                        var _loaded = $.Deferred();

                        // IE fix for cached images
                        if (!initialLoad) {
                            _loaded.resolve();
                        } else {
                            $imgBox.find('img.main').each(function() {
                                var tmpImg = new Image() ;
                                tmpImg.onload = function() {
                                    initialLoad = false;
                                    _loaded.resolve();
                                };
                                tmpImg.src = $(this).attr('src');
                            });
                        }
                    })();
                }
            })
                .to({
                    'media' : '(max-width: 780px)',
                    'namespace' : 'pdp_configurable_accordion',
                    'fallback' : 'else',
                    'if' : function() {
                        $pdp.find('.product-main-selection .options-list').addClass('accordion')
                            .Accordion({
                                'headers': '.option-container h3',
                                'containers': '.option-container .section-container',
                                'childrenSelector': '> .inner'
                            })
                            .find('.section-container').addClass('closed');
                    },
                    'else' : function() {
                        $pdp.find('.accordion')
                            .removeClass('accordion')
                            .Accordion('unset')
                            .find('.section-container')
                            .removeClass('closed');
                    }
                })
                .to({
                    'media' : '(max-width: 1024px)',
                    'namespace' : 'similar_frames_slider',
                    'fallback' : 'else',
                    'if' : function() {
                        $('#related-slider').Slider('unset');
                    },
                    'else' : function() {
                        $('#related-slider').Slider({'navigation' : '.arrows'});
                    }
                });


            var $productOptions = $('.product-options'),
                $frameColor = $('.frame-color'),
                $lensOptionToggle = $('.jsClick-LensoptionList'),
                $frameFitAccHeader = $('#frame-fit-accordion-header'),
                $swatchBg = $('.swatches-bg');

            //Trigger selection of first frame color if there was no selection on PLP
            if($frameColor.find('.selected').length == 0) {
                $frameColor.find('.swatch').eq(0).find('img').trigger('click');
            }


            Respond.to({
                'media': '(max-width: 767px)',
                'namespace': 'lense_color_responsive',
                'fallback': 'else',
                'if': function () { // TABLET
                    //remove events form mobile
                    var $lensColorOption = $('.lens-color');
                    var $framefitBlock = $('.frame-fit');

                    if($lensColorOption.length > 0) {
                        $lensColorOption.find('.swatch:first-child').addClass('active');
                        $lensColorOption.on('click', 'ul .swatch', function (e) {
                            lensTypeToggle($(this));
                        });
                    }

                    $productOptions.addClass('accordion').Accordion({
                        'headers': '.option-container h3',
                        'containers': '.section-container',
                        'childrenSelector': '> .inner',
                        'toggle': true
                    });

                    if($frameColor.find('.swatch').length > 5) {
                        $frameColor.on('click', '.toggle', function() {
                            $(this).toggleClass('clicked');
                            $frameColor.find('.swatches').toggleClass('expand');

                        });
                    } else {
                        $frameColor.find('.toggle').css('display', 'none');
                        $frameColor.find('.swatches').css('width', '100%');
                    }
                    // Add to cart
                    var $productAddtoCartBlock = $('.product-main-info'),
                        $frameColorBlock = $('.frame-color');

                    $productAddtoCartBlock.on('click', '.js-validate-addcart', function(e) {
                        e.preventDefault();

                        var isValid = productAddToCartForm.validator.validate();

                        if(isValid) {
                            productAddToCartForm.submit(this);
                        } else {
                            $frameColorBlock.addClass('container-error');
                            Gorilla.utilities.scrollTo($frameColorBlock, {check : true, threshold : 110}, 400);

                            return false;
                        }

                    });

                    $framefitBlock.find('.swatch').on('click',function(){
                        $frameFitAccHeader.trigger('click');
                    });
                    $swatchBg.removeClass('active');
                },
                'else' : function () { //DESKTOP
                    // Product Options: Remove accordion class + styles and unset
                    $productOptions.find('.accordion')
                        .removeClass('accordion')
                        .Accordion('unset')
                        .find('.section-container h3 + .section-container')
                        .removeClass('closed');

                    //remove events form mobile
                    $frameColor.off('click');

                    var $lensDescription = $('.lens-color-description');
                    if($lensDescription.length > 0) {
                        $lensDescription.find('.swatch:first-child').addClass('active');
                        $lensDescription.on('click', 'ul .swatch', function (e) {
                            lensTypeToggle($(this));
                        });
                    }


                    //if description elements 2 and less we need special styles for its
                    var $lensDescriptionLength = $lensDescription.find('li');
                    if ($lensDescriptionLength.length <= 2 ) {
                        $lensDescription.addClass('lens-color-description-width');
                    }

                    var $lensUpdate = $('.lens-color').find('.lens-update');

                    if($lensUpdate.length > 0) {
                        $lensUpdate.on('click', '.swatch', function (e) {
                            $lensDescription.find('[data-lens="'+$(this).attr('data-lens')+'"]').trigger('click');
                        });
                    }

                    // Lens option box dropdown
                    $lensOptionToggle.on('click', function () {
                        var $self = $(this),
                            isOpen = $self.attr('aria-expanded'),
                            expanded = 'true',
                            hidden = 'false',
                            $parent = $self.closest('.lens-color'),
                            $swatches = $parent.find('.swatches'),
                            swatchesHeight = $swatches.outerHeight(),
                            windowHeight = $(window.top).height(),
                            productOptions = $self.offset(),
                            eTop = productOptions.top - $(window).scrollTop(),
                            offset = swatchesHeight - (windowHeight-eTop);

                        $self.toggleClass('clicked');
                        $swatches.toggleClass('active');

                        $swatchBg.addClass('active');

                        if (isOpen) {
                            // current open
                            expanded = 'false';
                            hidden = 'true';
                        }


                        if(offset < 0) {
                            offset = -53
                        } else {
                            offset = -offset - 60;
                        }

                        $swatches.css({ 'top': offset+ 'px' });


                        $self.attr('aria-expanded', expanded);
                        $swatches.attr({
                            'aria-expanded': expanded,
                            'aria-hidden': hidden
                        });
                    });

                    // Lens options list
                    var $lensColorSwatch = $('.lens-color').find('.swatch');
                    $lensColorSwatch.on('click', function() {
                        var $self = $(this);
                        toggleOptionList($self, $lensOptionToggle);
                    });



                    //Frame fit handler
                    var $framefitBlock = $('.frame-fit');
                    $framefitBlock.on('click', '.jsClick-framefit-list:not(.disabled)', function() {
                        var $self = $(this),
                            isOpen = $self.attr('aria-expanded') !== 'false',
                            expanded = 'true',
                            hidden = 'false',
                            $parent = $self.closest('.frame-fit'),
                            $swatches = $parent.find('.swatches'),
                            swatchesHeight = $swatches.outerHeight(),
                            windowHeight = $(window.top).height(),
                            productOptions = $self.offset(),
                            eTop = productOptions.top - $(window).scrollTop(),
                            offset = swatchesHeight - (windowHeight-eTop);

                        $self.toggleClass('clicked');
                        $framefitBlock.find('.swatches').toggleClass('active');

                        $swatchBg.addClass('active');

                        if (isOpen) {
                            // current open
                            expanded = 'false';
                            hidden = 'true';
                        }

                        if(offset < 0) {
                            //default offset value to place options below select trigger button
                            offset = -53
                        } else {
                            // offset value to place options in view
                            offset = -offset - 60;
                        }

                        $swatches.css({ 'top': offset+ 'px' });

                        $self.attr('aria-expanded', expanded);
                        $framefitBlock.find('.swatches').attr({
                            'aria-expanded': expanded,
                            'aria-hidden': hidden
                        });
                    });

                    //update PDP when frema fit option is selected/changed
                    $('.frame-fit-hidden-select').on('change', function(){
                        var el =  $$('.frame-fit-hidden-select')[0];
                        spConfig.configureElement(el);

                    });

                    var $swatch = $('#frame-fit-options');
                    if($swatch) {
                        $swatch.on('click', '.swatch', function(){
                            $swatch.find('.swatch').removeClass('selected');
                            $(this).addClass('selected');
                        });
                    }

                    $framefitBlock.on('click', '.swatch', function() {
                        var $self = $(this),
                            $selection = $('#frame-fit-selected'),
                            $frameFitSelect = $('.frame-fit-hidden-select');

                        $selection.html($self.find('label').html());

                        $frameFitSelect.val($self.attr('data-val')).trigger('change');

                        toggleOptionList($self, $lensOptionToggle);
                    });


                    function toggleOptionList($elm, $block) {
                        $elm.parent().removeClass('active').attr('style', '');
                        $block.removeClass('clicked');
                    }


                    // Add to cart
                    var $productAddtoCartBlock = $('.product-main-info'),
                        $frameColorBlock = $('.frame-color');

                    $productAddtoCartBlock.on('click', '.js-addtocart', function(e) {
                        e.preventDefault();

                        var $lensSelection = $('.lens-selection'),
                            $lensSelectionHeight = $lensSelection.height() + 50,
                            $offsets = $(this).position(),
                            $offtop = $offsets.top - $lensSelectionHeight,
                            $offleft = $offsets.left - 50,
                            lensTop = $(this).offset().top - $lensSelectionHeight;

                        var isValid = productAddToCartForm.validator.validate();

                        if ($(this).hasClass('js-addtocart')) {
                            if(!isValid) {
                                $frameColorBlock.addClass('container-error');
                                Gorilla.utilities.scrollTo($frameColorBlock, {check : true, threshold : 110}, 400);

                                return false;
                            }
                        }
                        lensPopup();

                        $lensSelection.css({
                            'top': $offtop + 'px',
                            'left': $offleft + 'px'
                        });


                        $swatchBg.addClass('active');

                        if($('body').scrollTop() > lensTop - 80){
                            setTimeout(function(){
                                $('html,body').animate({
                                    scrollTop: lensTop - 80
                                });
                            }, 100);
                        }
                    });

                    $productAddtoCartBlock.on('click', '.js-validate-addcart', function(e) {
                        e.preventDefault();

                        var isValid = productAddToCartForm.validator.validate();

                        if(isValid) {
                            productAddToCartForm.submit(this);
                        } else {

                            $frameColorBlock.addClass('container-error');
                            Gorilla.utilities.scrollTo($frameColorBlock, {check : true, threshold : 110}, 400);

                            return false;
                        }

                    });

                    $frameColorBlock.on('click',function(){
                        if(productAddToCartForm.validator.validate()) {
                            $frameColorBlock.removeClass('container-error');
                        }
                    });

                    $productAddtoCartBlock.on('click', '.lens-selection .close', function(e) {
                        e.preventDefault();
                        lensPopup();
                    });

                    function lensPopup(){
                        $frameColorBlock.removeClass('container-error');
                        $productAddtoCartBlock.find('.lens-selection').toggleClass('active');
                        $productAddtoCartBlock.find('.js-addtocart').toggleClass('clicked');
                    }

                    $swatchBg.on('click', function(){
                        var $swatches = $('.swatches'),
                            $optionTrigger = $('.option-trigger'),
                            $lensSelection = $('.lens-selection');

                        $(this).removeClass('active');
                        $optionTrigger.removeClass('clicked');
                        $swatches.removeClass('clicked active').removeAttr('style');
                        $lensSelection.removeClass('active');
                        $('.js-addtocart').removeClass('clicked');
                    });
                    $('.swatch').on('click', function(){
                        $swatchBg.removeClass('active');
                    });
                }
            });


            function lensTypeToggle (el) {
                var $el = el,
                    $descriptionBlock = $el.parent().next('.alternates-display').find($el.data('lens'));

                $el.addClass('active').siblings('li').removeClass('active');

                if($descriptionBlock.length && !$descriptionBlock.hasClass('opened')){
                    $descriptionBlock.siblings('.opened').removeClass('opened').addClass('closed');
                    $descriptionBlock.removeClass('closed').addClass('opened');
                }else if($descriptionBlock.length == 0){
                    $el.closest('.lens-color').find('.alternates-display').find('.opened').removeClass('opened').addClass('closed');
                }
            }
        } // end of if($pdp.length)

        Respond.to({
            'media': '(max-width: 1024px)',
            'namespace' : 'transiotion_global',
            'fallback' : 'else',
            'if' : function() {
                // unsets
                /*$('#menu-trigger').on('click', function(){
                 if (!$('#navigation-container').hasClass('opened')){
                 $('#navigation-container').addClass('opened');
                 }

                 });*/
                $nav.CombinedMenu('unset');
                $(window).off('resize.CombinedMenu');

                //add specific class to prevent redirect for accordion on mobile
                $nav.find('li.level-top.parent').each(function(){
                    if($(this).find('div').hasClass('level0')){
                        $(this).find(' > a').addClass('no-click');
                    }
                });

                $nav.find('a.no-click').on('click',function(e){
                    e.preventDefault();
                });

                //accordion for navigation on mobile
                $nav.addClass('accordion').Accordion({
                    'headers': 'li.parent a.level-top',
                    'containers': 'div.level0',
                    'childrenSelector': '> ul',
                    'toggle': true
                });

                $menuPane.find('.level0').remove();

                //mobile navigation
                $navContainer.mobileNav({
                    onCloseCallback: function(){
                        $('#navigation-container').removeClass('opened');
                    }
                });

            },
            'else' : function() {
                //unsets
                $nav.removeClass('accordion').Accordion('unset');
                $navContainer.mobileNav('unset');

                // copy menus into the custom menu pane for desktop and mobile
                $nav.find('li.level-top > .level0').each(function() {
                    $menuPane.append($(this).clone(true).addClass('closed'));
                    $menuPane.find('.level0').find('.level1').addClass('grid-2');
                });

                // Setup main menu click handlers
                transitionMenu(false);
                $nav.CombinedMenu({
                    'triggerSelector' : 'li.parent > a.level-top',
                    onReadyCallback: function () {
                        $('li.parent > a.level-top').on('click', function(){
                            if(!$headerInner.hasClass('solidbg') && !$headerInner.hasClass('opened')) {
                                $headerInner.addClass('opened');
                            } else if ($menuPane.hasClass('closed')) {
                                $headerInner.removeClass('opened');
                            }
                        });

                    }
                });
                $(window).on('resize.CombinedMenu', Gorilla.utilities.throttle(function(e) {
                    $nav.CombinedMenu('recalculatePaneHeight');
                }, 50));
                $nav.removeClass('accordion')
                    .Accordion('unset');
            }
        })
            .to({
                'media': '(max-width: 780px)',
                'namespace' : 'transiotion_global',
                'fallback' : 'else',
                'if' : function() {
                    $navSpiff.addClass('accordion').Accordion({
                        'headers': '.box a.level-top',
                        'containers': '.content',
                        'childrenSelector': '> li',
                        'toggle':true
                    })
                        .find('.content').css('display', 'block');
                },
                'else' : function() {
                    $navSpiff.Accordion('unset')
                        .find('.content').css('display', 'none');

                    //Navigation on Home Page
                    $navSpiff.CombinedMenu({
                        'triggerSelector' : 'li.parent > a.level-top',
                        'paneSelector': '#menu-cat'
                    });
                    $(window).on('resize.CombinedMenu', Gorilla.utilities.throttle(function(e) {
                        $navSpiff.CombinedMenu('recalculatePaneHeight');
                    }, 50));
                    $navSpiff.removeClass('accordion')
                        .Accordion('unset');
                }
            });

        /**
         * Prevent copy/paste on email input fields (TS 3.5.1.2)
         */
        if($('body.customer-account-create').length) {
            $(document).on("cut copy paste",".account-create .validate-email, .account-create .validate-cemail",function(e) {
                e.preventDefault();
            });
        }

        /**
         * Cart accordion handling
         */
        if($('body.checkout-cart-index').length) {
            $('.extras').find('.accord').addClass('accordion').Accordion({
                'headers': '.section h4',
                'containers': '.section h4 + div',
                'childrenSelector': '> .shipping'
            })
                .find('.section h4 + div').addClass('closed');
        }

        // If on checkout and customer is logged in we need to set a body class - because of ajax calls
        // we can't do this in local.xml on the customer_logged_in layout handle
        if ($('body.checkout-onepage-index').length && $('.promo-greeting .welcome').length) {
            $('body').addClass('customer-logged-in');
        }

		// If on checkout and customer is logged in we need to set a body class - because of ajax calls
		// we can't do this in local.xml on the customer_logged_in layout handle
		if ($('body.checkout-onepage-index').length && $('.promo-greeting .welcome').length) {
			$('body').addClass('customer-logged-in');
		}

        $('.limiter').find('li').on('click', function () {
            $('.loader').show();
        });

        /**
		 * Checkout RX step accordion handling
		 */
		var $rxCheckout = $('#co-rx-form');
		if ($rxCheckout.length) {
			$rxCheckout.find('.accordion').Accordion({
				'headers': '.heading',
				'containers': '.heading + .content',
				'childrenSelector': '> div',
				'toggle': true,
                transitionSpeed: 0
			})
			.find('.heading + .content').addClass('closed');

            var $buttonRxContinue = jQuery('#rx-buttons-container');
			// Override the activeate method on this to prevent closing active one
			$rxCheckout.find('.accordion').data('Accordion').activate = function($header) {
				if (this.busy || $header.hasClass(this.options.activeClass) || $header.hasClass('disabled')) return;

				this.busy = true;
				if (this.options.toggle) {
					this.toggleAll($header);
                    $buttonRxContinue.css("visibility", "visible");
                    
				} else {
					this.toggleOne($header);
				}
			};

            $rxCheckout.find('.accordion').data('Accordion').expand = function($header) {
                var $_content = $header.next(this.$containers);

                if (!$_content.length || $_content.hasClass(this.options.activeClass)) return;

                this.busy = true;

                // Calculate height before expanding
                $_content.css('height', $_content.find(this.options.childrenSelector).css('height'));

                $header.addClass(this.options.activeClass);
                $_content.removeClass(this.options.collapseClass).addClass([this.options.activeClass, 'transitioning'].join(' '));

                // transition
                this._checkTransition($_content, function() {
                    $_content.removeClass('transitioning');
                    $_content.css('height', 'auto');
                });


                var $input = $header.find('input');
                $input.prop('checked',true);
                Gorilla.utilities.resetInputs($header);

            };

            $rxCheckout.find('.accordion').data('Accordion').collapse = function($header) {
                var $_content = $header.next(this.$containers);

                if (!$_content.length || !$_content.hasClass(this.options.activeClass)) return;

                this.busy = true;

                // Calculate height before collapsing
                $_content.css('height', $_content.find(this.options.childrenSelector).css('height'));
                $.support.transition && $_content[0] && $_content[0].offsetWidth;

                $header.removeClass(this.options.activeClass);
                $_content.removeClass(this.options.activeClass).addClass([this.options.collapseClass, 'transitioning'].join(' '));

                // transition
                this._checkTransition($_content, function() {
                    $_content.removeClass('transitioning');
                });

                var $input = $header.find('input');
                $input.prop('checked',false);
                Gorilla.utilities.resetInputs($header);

            }

            $rxCheckout.find('.heading').on('click',function(){
                var _self = $(this);

                $buttonRxContinue.find('button').prop('disabled', false);

                setTimeout(function(){
                    $('html,body').animate({
                        scrollTop: _self.offset().top-50
                    });
                },100);
            });

			// Expand the checked one - interval it b/c of checkout functionality
			var checkedInterval = window.setInterval(function() {
				var $checked = $rxCheckout.find('.accordion').find('[name="rx[type]"]:checked');
				if ($checked.length) {
					$checked.parents('.heading').trigger('click');
					window.clearInterval(checkedInterval);

					// for ie8 - prototype's dom ready is fired after and radios aren't initializing accordingly upon programatic updates in checkout
					$('html').hasClass('ie8') && Gorilla.utilities.resetInputs($rxCheckout);
				}
			}, 100);
		}

        var $accPromoCheckout = $('.checkout-accordion');
        if ($accPromoCheckout.length) {
            $accPromoCheckout.find('.accordion').Accordion({
                'headers': '.heading',
                'containers': '.heading + .content',
                'childrenSelector': '> div',
                'toggle': true
            })
                .find('.heading + .content').addClass('closed');

            $accPromoCheckout.find('.accordion').data('Accordion').expand = function($header) {
                var $_content = $header.next(this.$containers);

                if (!$_content.length || $_content.hasClass(this.options.activeClass)) return;

                this.busy = true;

                // Calculate height before expanding
                $_content.css('height', $_content.find(this.options.childrenSelector).css('height'));

                $header.addClass(this.options.activeClass);
                $_content.removeClass(this.options.collapseClass).addClass([this.options.activeClass, 'transitioning'].join(' '));

                // transition
                this._checkTransition($_content, function() {
                    $_content.removeClass('transitioning');
                    $_content.css('height', 'auto');
                });

                var $input = $header.find('input');
                $input.prop('checked',true);
                Gorilla.utilities.resetInputs($header);


            };

            $accPromoCheckout.find('.accordion').data('Accordion').collapse = function($header) {
                var $_content = $header.next(this.$containers);

                if (!$_content.length || !$_content.hasClass(this.options.activeClass)) return;

                this.busy = true;

                // Calculate height before collapsing
                $_content.css('height', $_content.find(this.options.childrenSelector).css('height'));
                $.support.transition && $_content[0] && $_content[0].offsetWidth;

                $header.removeClass(this.options.activeClass);
                $_content.removeClass(this.options.activeClass).addClass([this.options.collapseClass, 'transitioning'].join(' '));

                // transition
                this._checkTransition($_content, function() {
                    $_content.removeClass('transitioning');
                });

                var $input = $header.find('input');
                $input.prop('checked',false);
                Gorilla.utilities.resetInputs($header);

            }


        }

        /**
         * Checkbox open/close
         */
        var $checkboxToggle = $('#checkbox-toggle');
        if ($checkboxToggle.length) {

            var $checkboxToggleContainer = $('.checkbox-toggle'),
                $checkboxToggleContent = $('.checkbox-toggle-content');

            Respond.to({
                'media' : '(max-width: 767px)',
                'namespace' : 'checkbox-toggle',
                'fallback' : 'else',
                'if' : function() {
                    $checkboxToggleContainer.removeClass('hidden');
                    $checkboxToggleContent.addClass('closed');
                    $checkboxToggle.on('click', function(){
                            if ($(this).is(':checked')) {
                                $checkboxToggleContent.addClass('opened').removeClass('closed');
                            } else {
                                $checkboxToggleContent.addClass('closed').removeClass('opened');
                            }
                    });
                },
                'else' : function() {
                    $checkboxToggleContainer.addClass('hidden');
                    $checkboxToggleContent.addClass('opened').removeClass('closed');
                }
            });

        }

        /**
         * Shipping In-Store Pickup maps
         */

        var $instoreLocation = $('.in-store-location');

        if($instoreLocation.length > 0 ) {

            $instoreLocation.find('input').on('click',function(){
                var mapId =  $(this).attr('data-store-map'),
                    $maps = $('.in-store-map');

                $maps.each(function(){
                    if($(this).attr('id') == mapId) {
                        $(this).addClass('opened');
                    } else {
                        $(this).removeClass('opened');
                    }
                });
            });
        }

        /**
         * Shipping accordion
         */
        var $shippingCheckout = $('.shipping-checkout');
        if ($shippingCheckout.length > 0) {
            var $shippingAccord = $('.shipping-accord');

            $shippingAccord.addClass('accordion').Accordion({
                'headers': '.checkbox-header',
                'containers': '.shipping-container',
                'childrenSelector': '> .shipping-content',
                'toggle': true
            })
                .find('.shipping-container').addClass('closed');

            $shippingAccord.data('Accordion').expand = function($header) {
                var $_content = $header.next(this.$containers);

                if (!$_content.length || $_content.hasClass(this.options.activeClass)) return;

                this.busy = true;

                // Calculate height before expanding
                $_content.css('height', $_content.find(this.options.childrenSelector).css('height'));

                $header.addClass(this.options.activeClass);
                $_content.removeClass(this.options.collapseClass).addClass([this.options.activeClass, 'transitioning'].join(' '));

                // transition
                this._checkTransition($_content, function() {
                    $_content.removeClass('transitioning');
                    $_content.css('height', 'auto');
                });


                var $input = $header.find('input'),
                    $continue = $('#shipping-buttons-container').find('button');
                $input.prop('checked',true);
                Gorilla.utilities.resetInputs($header);

                if($('.instore-tab').hasClass('opened')) {
                    $continue.prop('disabled',false);
                } else
                if($('.shipping-tab').hasClass('opened') && $('#checkout-shipping-method-load.loaded').length > 0){
                    $continue.prop('disabled',false);
                } else {
                    $continue.prop('disabled',true);
                }

            };

            $shippingAccord.data('Accordion').collapse = function($header) {
                var $_content = $header.next(this.$containers);

                if (!$_content.length || !$_content.hasClass(this.options.activeClass)) return;

                this.busy = true;

                // Calculate height before collapsing
                $_content.css('height', $_content.find(this.options.childrenSelector).css('height'));
                $.support.transition && $_content[0] && $_content[0].offsetWidth;

                $header.removeClass(this.options.activeClass);
                $_content.removeClass(this.options.activeClass).addClass([this.options.collapseClass, 'transitioning'].join(' '));

                // transition
                this._checkTransition($_content, function() {
                    $_content.removeClass('transitioning');
                });

                var $input = $header.find('input');
                $input.prop('checked',false);
                Gorilla.utilities.resetInputs($header);

            }

        }

        /**
         * Checkout Payment step fix form for 480px
         */
        var $payment = $('#checkout-payment-method-load');
        if ($payment.length) {
            Respond.to({
                'media' : '(max-width: 480px)',
                'namespace' : 'fix_form_payment_step',
                'fallback' : 'else',
                'if' : function() {
                    $payment.find('.field-verification').addClass('field')
                        .find('label').removeClass('ignore');

                },
                'else' : function() {
                    $payment.find('.field-verification').removeClass('field')
                        .find('label').addClass('ignore');
                }
            });
        }

        /**
         * FAQ
         */
        if ($('body.cms-faqs').length) {
            var $faqAccordion = $('.faqs').addClass('accordion').Accordion({
                'headers': '.faq-question h4',
                'containers': '.answer',
                'childrenSelector': '> div',
                'toggle': false
            })
                .find('.faq-question h4 + div.answer').addClass('closed');	// close on setup

            $faqAccordion.find('.faqnav').on('click', function(e){
                var $target = $($(this).attr('href'));
                Gorilla.utilities.scrollTo($target, {threshold : 100}, 300);
                $faqAccordion.Accordion('expand', $target.find('.question'));
                e.preventDefault();
            });
        }

        /*Fixed margin on carousel for Safari -> doesn't support percentage correctly */
        var widthCarousel = $('.carousel-container').width();
        var topMargin = widthCarousel * 0.24;
        if (navigator.userAgent.indexOf('Safari') != -1 && navigator.userAgent.indexOf('Chrome') == -1) {
            $('.carousel-control').css('margin-top', topMargin+'px')
        }
        var $btnClose = $('.close')
            ,$fullLocation = $('.full-location');
        if($('.ship-address').length){
            $btnClose.on('click',function(){
                $(this).parents('.full-location').removeClass('opened');
            });
            $fullLocation.addClass('closed');


            var $input = $('input[name="billing[instore_store]"]');
            $input.on('change',function(){
                if ($(this)){
                    $(this).parents('.in-store-map').find('.full-location').addClass('opened');
                }
            });

            $('.map-hours').on('click',function(){
                $(this).parents('.in-store-map').find('.full-location').toggleClass('opened');
            });

            $('.billing-buttons-fake').each(function(){
                if($(this).hasClass('loading')){
                    $(this).find('button').attr('disabled','true');
                }else{
                    $(this).find('button').removeAttr('disabled');
                }
            });
        }

        // fake hover event on owl navigation arrows to increase hover area
        var $currentArrow = {};
        $('.arrow-hover')
            .hover(function() {
                var direction = $(this).data('arrow');
                $currentArrow = $(this).parent('#lenses-carousel').find('.owl-' + direction);
                $currentArrow.addClass('showed');
            }, function() {
                $currentArrow.removeClass('showed');
            })
            .on('click', function(){
                var $active = $(this).parent('#lenses-carousel').find('.owl-item.active');
                document.location = $active.find('a').attr('href');
            });

        // show different qty of items in carousel on Collection page; desktop - 3, tablet - 2, mobile - 1
        var $productsCarousel = $('.products-carousel'),
            getCarouselOptions = function(qty){
                $productsCarousel.owlCarousel('destroy');
                return {
                    items: 	qty,
                    nav: 	true,
                    dots: false,
                    navText: ['<i class="icon-arrow-l"></i>','<i class="icon-arrow-r"></i>'],
                    slideBy: qty
                }
            };
        Respond.to({
            'media' : '(max-width: 1024px)',
            'namespace' : 'collections-products',
            'fallback' : 'else',
            'if' : function() {
                Respond.to({
                    'media' : '(max-width: 780px)',
                    'namespace' : 'collections-products',
                    'fallback' : 'else',
                    'if' : function() {
                        $productsCarousel.owlCarousel(getCarouselOptions(1));
                    },
                    'else' : function() {
                        $productsCarousel.owlCarousel(getCarouselOptions(2));
                    }
                })
            },
            'else' : function() {
                $productsCarousel.owlCarousel(getCarouselOptions(3));
            }
        });

        // adjust height of the video img
        Respond.to({
            'media' : '(max-width: 480px)',
            'namespace' : 'img-homepage',
            'fallback' : 'else',
            'if' : function() {
                $('.jsLoad-FullScreenImages').height(screen.height - 150);
            }
        });

    });

    // Paul code
    $(function() {
        // Homepage carousel
        var $carousel=$(".carousel"), ob=$carousel.data("Carousel");

        // Pause video when transition in
        $carousel.on('in.Carousel', function(){
            $(this).find(".video-js").each(function(){
                if($(this).parents('.item').hasClass('active')){
                    videojs($(this).attr("id")).play();
                }else{
                    videojs($(this).attr("id")).pause();
                }
            });
        });

        // Pause carousel when play a video
        $carousel.find(".video-js.vjs-youtube").each(function(){
            videojs($(this).attr("id")).on('play',function(){ob.pause(true);});
        });

        //header search dropdown
        var $toggleSearch = $('.header-container').find('.open-form'),
            $formSearch = $('#form-search');
        $toggleSearch.on('click', function(e){
            e.preventDefault();
            $formSearch.addClass('form-visible').animate({opacity: 1}, 200);
            $formSearch.find('.textinput').focus();
        });

        //added to move close icon position when keyboard appears on mobile/tablet
        var $mobileBrowsers  = (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent));
        if($mobileBrowsers){
            $formSearch.find('.textinput').focus(function(){
                $('.close-form').css('top', '30%');
            });
            $formSearch.find('.textinput').blur(function(){
                $('.close-form').css('top', '16px');
            });
        }

        $('.close-form').on('click', function(e){
            e.preventDefault();
            $formSearch.find('.input-text')
                .val('')
                .focus();
            $formSearch.removeClass('form-visible').animate({opacity: 0}, 200);
        });


        // Fixed tabs
        //if($("body").hasClass("cms-jins-screen") || $("body").hasClass("cms-performance-lenses")){
        if($('.screen-wrapper').length){
            $('.screen-wrapper').Fixed({
                content: '.screen-header-tabs',
                extraOffset: -200
            });


            $('.screen-header-tabs').clone().removeClass('screen-header-tabs').addClass('screen-header-tabs-mobile').appendTo('body');

            function inview(el, target, threshold) {
                var $el = $(el),
                    $target = $(target);

                if ($el.is(":hidden") || $target.is(':hidden')) return;

                var th = threshold || 0,
                    wt = $(window).scrollTop(),
                    wb = wt + $(window).height(),
                    et = $el.offset().top,
                    eb = et + $el.height();

                if(eb >= wt - th && et <= wb + th){
                    if($target.hasClass('out')) return;
                    $target.removeClass('in').addClass('out');
                }else{
                    if($target.hasClass('in')) return;
                    $target.removeClass('out').addClass('in');
                }
            }
            $(window).on('scroll', function(){
                inview('.screen-header-tabs', '.screen-header-tabs-mobile');
            });


            // Click on tabs and scroll
            $('.screen-header-tabs-2').find("a").on('click', function(e){
                e.preventDefault();
                $(window).scrollTop($('.screen-content-tabs').find(".screen-content-tab").eq($(this).index()).offset().top - 130);
            });

            // When scroll activate the right tab
            window.screenTabs=$(".screen-header-tabs").find("a");
            window.screenTabsMobile =$(".screen-header-tabs-mobile").find("a");
            window.screenContents=$(".screen-content-tab");


            $(window).on('scroll', function(){
                //if($(window).width()>780){
                var idx = null,
                    st = $(window).scrollTop(),
                    wh = $(window).height();
                for (var i=0; i < window.screenContents.length; i++){
                    if(window.screenContents.eq(i).offset().top > st + 130){
                        idx = i;
                        break;
                    }
                }
                if (idx == null) {
                    window.screenTabs.eq(window.screenContents.length-1).addClass("active").siblings().removeClass("active");
                    window.screenTabsMobile.eq(window.screenContents.length-1).addClass("active").siblings().removeClass("active");
                }else if(idx != 0 ){
                    window.screenTabs.eq(idx-1).addClass("active").siblings().removeClass("active");
                    window.screenTabsMobile.eq(idx-1).addClass("active").siblings().removeClass("active");
                }
                // }
            });

            // Testimonials
            $(".header-tabs").on("click", ".tab", function(){
                if(!$(this).hasClass("on")){
                    $(this)
                        .siblings(".on").removeClass("on")
                        .end()
                        .addClass("on");
                    $(this)
                        .closest(".wrapper-tabs")
                        .find(".content-tab.on").removeClass("on")
                        .end()
                        .find(".content-tab").eq($(this).index()).addClass("on");
                }
            });
        }

        // PDP - lens color preselect
        if($("body").is(".catalog-product-view")){
            var myRegexp=/#([0-9]+)=([0-9]+)/g;
            var match=myRegexp.exec(location.href);

            if(match && match[1] && match[2]){
                $("input[name='options[" + match[1] + "]'][value='" + match[2] + "']").click();
                opConfig.reloadPrice();
            }
        }

        // Search results page
        if($('body').hasClass('catalogsearch-result-index')){
            setTimeout(function(){$(window).scroll();}, 100);
        }

        // checkout onepage
        if($('body').hasClass('checkout-onepage-index')){
            var $btn = $('#shipping-buttons-container .button');
            var sfv = shippingForm && shippingForm.validator;
            var sfvi = shippingFormInstore && shippingFormInstore.validator;

            if (sfv && sfvi) {
                // #co-shipping-form
                Validation.noAdvicesAndClasses = 1; // disable advices and error classes

                if(!sfv .validate()) {
                    $btn.prop('disabled', true);
                }

                Validation.noAdvicesAndClasses = 0; // enable advices and error classes - default functionality

                $('#co-shipping-form').find('[name=shipping\\[use_for_shipping\\]], [type=text], select').on('change', function(){
                    Validation.noAdvicesAndClasses = 1;

                    if(!sfv .validate()) {
                        $btn.prop('disabled', true);
                    } else {
                        $btn.prop('disabled', false);
                    }

                    Validation.noAdvicesAndClasses = 0;
                });

                // #co-shipping-form-instore
                Validation.noAdvicesAndClasses = 1;

                if(!sfvi .validate()) {
                    $btn.prop('disabled', true);
                }

                Validation.noAdvicesAndClasses = 0;

                $('#co-shipping-form-instore').find('[name=shipping\\[use_for_shipping\\]], [type=text]').on('change', function(){
                    Validation.noAdvicesAndClasses = 1;

                    if(!sfvi .validate()) {
                        $btn.prop('disabled', true);
                    } else {
                        $btn.prop('disabled', false);
                    }

                    Validation.noAdvicesAndClasses = 0;
                });
            }
        }
    });

    $(function(){

        var $dashboard = $('.customer-account'),
            $change = $dashboard.find('.change-address'),
            $selectionBox = $dashboard.find('.check-selection'),
            $close = $selectionBox.find('.close');
        if($dashboard) {
            $change.on('click', function(){
                $selectionBox.removeClass('active');
                var height = $(this).closest('.info-box').height()+20;
                $(this).prev().css('bottom', height).toggleClass('active');
            });
            $close.on('click', function(){
                $selectionBox.removeClass('active');
            });
        }

        var $elBar = $('#eligibility-bar');

        if($elBar) {
            $elBar.find('.insbar-close').on('click', function(){
                $elBar.hide();
            })
        }


        /**
         * CMS Accordion
         */
        var $cmsAccordion = $(".cms-accordion");
        if($cmsAccordion.length) {
            $cmsAccordion.Accordion({
                'headers': '.cms-accordion__title',
                'containers': '.cms-accordion__content',
                'childrenSelector': '.cms-accordion__content-inner',
                'toggle': false
            });
        }
        /**
         * Eligibility form input mask
         */
        var $elFrom = $("#el-check-form");
        if($elFrom.length) {
            $elFrom.find('#dob').inputmask("99-99-9999",{ "placeholder": "MM-DD-YYYY" });
        }

        var $allOrders = $('#all-orders');

        if($allOrders) {
            $('.view-all-orders').on('click', function() {
                $(this).hide();
                $allOrders.toggleClass('show');
            });
        }

        /**
         * All other cc date fileds
         */
        var $ccDate = $(".cc-card-date");
        if($ccDate.length) {
            $ccDate.inputmask("99-99",{ "placeholder": "MM-YY" });
        }

        /**
         * Saved Credit Cards Type
         */
        var $ccView = $(".my-account-cards-view");
        if($ccView.length) {
            $ccView.find('.cc-image').each(function(){
                var cCNum = $(this).attr('data-cc-num')
                var ccType = '';
                 switch(cCNum) {
                    case '3':
                        ccType = 'american-express';
                        break;
                    case '4':
                        ccType = 'visa';
                        break;
                    case '5':
                        ccType = 'master-card';
                        break;
                    case '6':
                        ccType = 'discover';
                        break;
                    case '1':
                        ccType = 'jcb';
                        break;
                    case '2':
                        ccType = 'jcb';
                        break;
                    case '3':
                        ccType = 'jcb';
                        break;
                    default:
                        ccType = '';
                        break;
                }
                $(this).html('<span class="'+ccType+'"></span>');
            });
        }
        /**
         * Eligibility thank you page
         */
        var $successElBtn = $("#eligibility-form-buttons-container");
        if($successElBtn.length) {

            $successElBtn.on('click', function(){
                var $form = $('.eligibility-form');
                $(this).hide();

                $form.show();
                Gorilla.utilities.resetInputs($form);
            });
        }
    });

}(window.jQuery);

Object.extend(Validation, {
    showAdvice : function(elm, advice, adviceName){
        if(!elm.advices){
            elm.advices = new Hash();
        }
        else{
            elm.advices.each(function(pair){
                if (!advice || pair.value.id != advice.id) {
                    // hide non-current advice after delay
                    this.hideAdvice(elm, pair.value);
                }
            }.bind(this));
        }
        elm.advices.set(adviceName, advice);
        if(typeof Effect == 'undefined') {
            advice.style.display = 'block';
        } else {
            if(!advice._adviceAbsolutize) {
                new Effect.Appear(advice, {duration : .1});	// Gorilla modified to reduce transition
            } else {
                Position.absolutize(advice);
                advice.show();
                advice.setStyle({
                    'top':advice._adviceTop,
                    'left': advice._adviceLeft,
                    'width': advice._adviceWidth,
                    'z-index': 1000
                });
                advice.addClassName('advice-absolute');
            }
        }
    },
    hideAdvice : function(elm, advice){
        if (advice != null) {
            new Effect.Fade(advice, {duration : 0, afterFinishInternal : function() { advice.hide(); }});			// Gorilla modified to reduce transition
        }
    }
});


/**
 * Customized stricter telephone Validation
 */
Validation.add('validate-phoneStrict', 'Please enter a valid phone number. For example 123-456-7890 or 1234567890.', function(v) {
    return Validation.get('IsEmpty').test(v) || /^(\()?\d{3}(\))?(-|\.|\s)?\d{3}(-|\.|\s)?\d{4}$/.test(v)
});


/**
 * Customized email confirmation inputs
 */
Validation.addAllThese([
    ['validate-cemail', 'Please make sure your emails match.', function(v) {
        var conf = $$('.validate-cemail')[0];
        var pass = false;
        if ($('email')) {
            pass = $('email');
        }
        var emailElements = $$('.validate-email');
        for (var i = 0; i < emailElements.size(); i++) {
            var emailElement = emailElements[i];
            if (emailElement.up('form').id == conf.up('form').id) {
                pass = emailElement;
            }
        }
        if ($$('.validate-admin-email').size()) {
            pass = $$('.validate-admin-email')[0];
        }
        return (pass.value == conf.value);
    }]
]);


/**
 * Gorilla extended to modify how validation works when
 * blurring and changing inputs. See below
 */
Object.extend(Varien.DateElement.prototype, {
    validate: function() {
        var error = false,
            day   = parseInt(this.day.value, 10)   || 0,
            month = parseInt(this.month.value, 10) || 0,
            year  = parseInt(this.year.value, 10)  || 0;

        if (this.day.value.strip().empty() && this.month.value.strip().empty() && this.year.value.strip().empty()) {
            if (this.required) {
                error = 'This date is a required value.';
            } else {
                this.full.value = '';
            }
        } else if (!day || !month || !year) {
            // Gorilla modified - if the event is a change or blur we want to bypass the error message display
            if (['change', 'blur'].indexOf(window.event.type) === -1) {
                error = 'Please enter a valid full date.';
            }
            // Gorilla end
        } else {
            var date = new Date, countDaysInMonth = 0, errorType = null;
            date.setYear(year);date.setMonth(month-1);date.setDate(32);
            countDaysInMonth = 32 - date.getDate();
            if(!countDaysInMonth || countDaysInMonth>31) countDaysInMonth = 31;

            if (day<1 || day>countDaysInMonth) {
                errorType = 'day';
                error = 'Please enter a valid day (1-%d).';
            } else if (month<1 || month>12) {
                errorType = 'month';
                error = 'Please enter a valid month (1-12).';
            } else {
                if(day % 10 == day) this.day.value = '0'+day;
                if(month % 10 == month) this.month.value = '0'+month;
                this.full.value = this.format.replace(/%[mb]/i, this.month.value).replace(/%[de]/i, this.day.value).replace(/%y/i, this.year.value);
                var testFull = this.month.value + '/' + this.day.value + '/'+ this.year.value;
                var test = new Date(testFull);
                if (isNaN(test)) {
                    error = 'Please enter a valid date.';
                } else {
                    this.setFullDate(test);
                }
            }
            var valueError = false;
            if (!error && !this.validateData()){//(year<1900 || year>curyear) {
                errorType = this.validateDataErrorType;//'year';
                valueError = this.validateDataErrorText;//'Please enter a valid year (1900-%d).';
                error = valueError;
            }
        }

        if (error !== false) {
            try {
                error = Translator.translate(error);
            }
            catch (e) {}
            if (!valueError) {
                this.advice.innerHTML = error.replace('%d', countDaysInMonth);
            } else {
                this.advice.innerHTML = this.errorTextModifier(error);
            }
            this.advice.show();
            return false;
        }

        // fixing elements class
        this.day.removeClassName('validation-failed');
        this.month.removeClassName('validation-failed');
        this.year.removeClassName('validation-failed');

        this.advice.hide();
        return true;
    }
});