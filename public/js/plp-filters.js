var ListingFilters = Class.create();
ListingFilters.prototype = {
    initialize: function (url, categoryId) {
        var self = this;
        this.url = url;
        this.categoryId = categoryId;
        this.parsedFilters = {};
        this.baseUrl = window.location.protocol + '//' + location.host + location.pathname;
        this.currentPageUrl = window.location.href;

        var plpNavigation = '#layered-navigation';

        this.updateListing(plpNavigation);
        this.addEvents(plpNavigation);

        var currentParams = this.parseUrl(this.currentPageUrl);

        if(currentParams) {
            this.addParams(currentParams);
        }
    },
    showLoader: function(active){
        var $loader = jQuery('#plp-filter-loader');

        if(active == true) {
            $loader.show();
        } else {
            $loader.hide();
        }
    },
    getResultsNumber: function(url,selected,$button,$filter){
        var params = this.parseUrl(url),
            str = jQuery.param( params),
            ajaxUrl = this.createUrl(params, selected),
            btnBox = jQuery('.products-number-box');
            btnSet = jQuery('#filter-button-set');

        this.showLoader(true);

        var request = new Ajax.Request(
            ajaxUrl[1],
            {
                method:'get',
                onComplete: function(response){
                    var response = response.responseText.evalJSON(),
                        qty = response.products_count,
                        btnLbl = '';

                    if(response.success == true) {

                        if($filter.hasClass('selected')) {
                            $button.show();
                            btnSet.removeClass('active_filters_none').addClass('active_filters_block').hide();
                        } else {
                            $button.hide();
                            if (!btnSet.hasClass('active_filters')) {
                                // two extra CSS classes required to force value of display
                                // what's defined as !important by show1078 class
                                btnSet.removeClass('active_filters_block').addClass('active_filters_none').hide();
                            }
                        }
                        $filter.removeClass('disabled');
                        btnLbl = 'See ' + qty + ((qty == 1) ? ' model' : ' models');

                        if(qty != 0) {
                            $button.find('.products-number').text(btnLbl);
                        } else {
                            $button.find('.products-number').text('There are no products matching the selection');

                            $filter.each(function(){
                                var $this = jQuery(this);

                               if( !$this.hasClass('selected')) {
                                   $this.addClass('disabled');
                               }
                            });

                        }
                        btnBox.show();
                        $button.attr('href','');
                        $button.attr('href',ajaxUrl[0]);

                        plpFilters.showLoader(false);
                    }
                },
                onFailure: function(response){
                    var response = response.responseText.evalJSON();
                    console.log('Failure');
                    console.log(response);
                }
            }
        );
    },
    createUrl: function(params,add){
        var newUrl =[];
        if(add == true) {
            //add params
            this.addParams(params);
        } else {
            //remove params
            this.removeParams(params);
        }
        newUrl[0] = this.baseUrl+'?'+jQuery.param( this.parsedFilters );
        newUrl[1] = this.url+'?'+jQuery.param( this.parsedFilters );

            return newUrl;
    },
    addParams: function(params) {
        var i = 0;
        for( var prop in params) {
            var paramName = Object.keys(params)[i];
            if (this.parsedFilters.hasOwnProperty(paramName) && this.parsedFilters[paramName] != '') {
                //check if the parameter is alredy added
                if (this.parsedFilters[paramName].indexOf(params[paramName]) == -1)
                    this.parsedFilters[paramName] = this.parsedFilters[paramName] + ';' + params[paramName].replace(this.parsedFilters[paramName]+';', '');
            } else {
                //add new parameter
                this.parsedFilters[paramName] = params[paramName];
            }
            i++;
        }
        return paramName;
    },
    removeParams: function(params) {

        var paramName = Object.keys(params)[Object.keys(params).length-1];

        if(this.parsedFilters[paramName].indexOf(params[paramName]) > -1) {
            if(this.parsedFilters[paramName].charAt(this.parsedFilters[paramName].indexOf(params[paramName]) -1) == ';') {
                this.parsedFilters[paramName] = this.parsedFilters[paramName].replace(';'+params[paramName], '');
            } else {
                this.parsedFilters[paramName] = this.parsedFilters[paramName].replace(params[paramName], '');
            }
            if(this.parsedFilters[paramName].charAt(0) == ';') {
                this.parsedFilters[paramName] = this.parsedFilters[paramName].replace(';', '');
            }

            if(this.parsedFilters[paramName] == '') {
                delete this.parsedFilters[paramName];
            }
        }
    },
    updateListing: function(el){
        var $el = jQuery(el);

        $el.find('.accord-container a').prepend('<span class="icon-checkbox"></span><span class="icon-checkbox-selected"></span>');
    },
    addEvents: function(el){
        var $el = jQuery(el),
            $filter = $el.find('.accord-container a'),
            $filterButton = $el.find('.apply-filters');

        $filter.on('click', function(e){
            e.preventDefault();

            var $this = jQuery(this);

            $this.toggleClass('selected');

            //add or remove a parameter based on selection
            if($this.hasClass('selected')) {
                plpFilters.getResultsNumber($this.attr('href'),true,$filterButton,$filter);
            } else {
                plpFilters.getResultsNumber($this.attr('href'),false,$filterButton,$filter);
            }
        });

    },
    parseUrl: function(url){
        var match,
            pl     = /\+/g,  // Regex for replacing addition symbol with a space
            search = /([^&=]+)=?([^&]*)/g,
            decode = function (s) { return decodeURIComponent(s.replace(pl, " ")); },
            query  = url.substring(url.indexOf('?')+1, url.length);

        var urlParams = {};
        if (url.indexOf('?')>0) {
            while (match = search.exec(query))
                urlParams[decode(match[1])] = decode(match[2]);
        }

        return urlParams;
    },
    setLoadWaiting: function(keepDisabled) {

        var container = $('eligibility-buttons-container');
        if (keepDisabled) {
            container.addClassName('loading');
        } else {
            container.removeClassName('loading');
        }
    }
};