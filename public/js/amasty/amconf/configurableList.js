// extension Code

AmConfigurableData = Class.create();
AmConfigurableData.prototype = 
{
    textNotAvailable : "",
    
    mediaUrlMain : "",
    
    currentIsMain : "",
    
    optionProducts : null,
    
    optionDefault : new Array(),
    
    oneAttributeReload : false,
    
    amlboxInstalled : false,
    
    initialize : function(config, optionProducts, container)
    {
        this.optionProducts = optionProducts;
		this.config = config;
		this.container = $(container);
		this.config.productId = this.container.id.replace(/[a-z-]*/, '');

		var attrKeys = Object.keys(this.config.attributes);
		for (var i = 0; i < attrKeys.length; i++) {
			this.buildSwatches(this.config.attributes[attrKeys[i]]);
			continue;

			/*var prevSetting = this.settings[i-1] ? this.settings[i-1] : false;
			var nextSetting = this.settings[i+1] ? this.settings[i+1] : false;
			if (i == 0) {
				this.fillSelect(this.settings[i]);
			} else {
				this.settings[i].disabled = true;
			}
			$(this.settings[i]).childSettings = childSettings.clone();
			$(this.settings[i]).prevSetting   = prevSetting;
			$(this.settings[i]).nextSetting   = nextSetting;
			childSettings.push(this.settings[i]);*/
		}
    },
    
    hasKey : function(key)
    {
        return ('undefined' != typeof(this.optionProducts[key]));
    },
    
    getData : function(key, param)
    {
        if (this.hasKey(key) && 'undefined' != typeof(this.optionProducts[key][param]))
        {
            return this.optionProducts[key][param];
        }
        return false;
    },
    
    saveDefault : function(param, data)
    {
        this.optionDefault['set'] = true;
        this.optionDefault[param] = data;
    },
    
    getDefault : function(param)
    {
        if ('undefined' != typeof(this.optionDefault[param]))
        {
            return this.optionDefault[param];
        }
        return false;
    },


	/**
	 * Custom method that takes an li element and then returns the associated
	 * attribute and product ids.
	 *
	 * @param el
	 * @returns {{productId: string, attributeId: string, optionId: string}}
	 */
	getAttributeData : function(el) {
		var attributeData = el.getAttribute('data-attribute'),
			pos = attributeData.indexOf('-');

		return {
			productId : attributeData.substring(0, pos),
			attributeId : attributeData.substring(pos + 1, attributeData.indexOf('-', pos + 1)),
			optionId : attributeData.substring(attributeData.indexOf('-', pos + 1) + 1, attributeData.length)
		}
	},

	buildSwatches : function(obj) {
		var options = obj.options;
		if (options) {
			// extension Code
			if (this.config.attributes[obj.id].use_image) {
				var holderParent = $('amconf-images-' + this.config.productId + '-' + obj.id);
				if (holderParent) {
					holderParent.parentNode.removeChild(holderParent);
				}

				// Gorilla modified @todo move to docFrag
				holderParent = document.createElement('ul');
				holderParent = $(holderParent); // fix for IE
				holderParent.addClassName('swatches');
				// helper class for larger swatch quantity products
				(options.length > 14) && holderParent.addClassName('fringe');
				holderParent.id = 'amconf-images-' + this.config.productId + '-' + obj.id;
				this.container.appendChild(holderParent);

				var holderDivLI = document.createElement('li'),
					holderDiv = document.createElement('ul')
				holderDivLI = $(holderDivLI); // fix for IE
				holderDiv = $(holderDiv); // fix for IE
				holderParent.appendChild(holderDivLI);
				holderDivLI.appendChild(holderDiv);
			}
			// extension Code End

			// Loop options and build stuffs
			for (var i = 0; i < options.length; i++) {
				var allowedProducts = options[i].products.clone();
				if (allowedProducts.size() > 0) {

					// Gorilla Added
					// if count exceeds 16, we want to mod on 8, else, we're going to check exceeding 8 and then half it and compare to create 2 rows
					// this algorithm is in place to create a specific visual styling for products that have less than 16 swatches
					// Accepts 8 swatches on a row
					if ((options.length > 16 && i%8 === 8) || (options.length > 8 && options.length <= 16 && i === (Math.floor(options.length / 2)))) {
						holderDivLI = document.createElement('li');
						holderDiv = document.createElement('ul');
						holderDivLI = $(holderDivLI); // fix for IE
						holderDiv = $(holderDiv); // fix for IE
						holderParent.appendChild(holderDivLI);
						holderDivLI.appendChild(holderDiv);
						if (i > 10) {
							var moreStyles = document.createElement('li');
							holderDivLI = $(moreStyles); // fix for IE
							moreStyles.addClassName('more-styles');
							moreStyles.innerHTML = 'more styles';
							holderParent.appendChild(moreStyles);
						}
					}
					// Gorilla End

					// extension Code
					if (this.config.attributes[obj.id].use_image) {
						// Gorilla modified
						var imgContainer = document.createElement('li');
						imgContainer = $(imgContainer); // fix for IE
						imgContainer.addClassName('swatch');
						imgContainer.setAttribute('data-attribute', this.config.productId + '-' + obj.id + '-' + options[i].id);
						//imgContainer.setAttribute('data-swatch', this.config.productId);
						imgContainer.id = 'amconf-images-container-' + this.config.productId + '-' + obj.id + '-' + options[i].id;
						holderDiv.appendChild(imgContainer);
						// Gorilla End

						var image = document.createElement('img');
						image = $(image); // fix for IE
						image.src = options[i].image;
						image.addClassName('amconf-image');

						// @todo for out of stock options
						//if (typeof confData[this.config.productId] != 'undefined' && confData[this.config.productId].getData((key + options[i].id), 'not_is_in_stock')) {
						//	image.addClassName('amconf-image-outofstock');
						//}

						image.alt = options[i].label;
						image.title = options[i].label;
						image.observe('click', this.configureImage.bind(this));

						// Gorilla removed tool tips code

						imgContainer.appendChild(image);
					}
					// extension Code End

					options[i].allowedProducts = allowedProducts;
				}
			}
		}
	},

	/**
	 * Gorilla modified slightly for new markup and attributes - customized how we're getting
	 * the attribute data to use a standardized getAttributeData method
	 */
	configureImage : function(event){
		var element = Event.element(event),
			attributeData = this.getAttributeData(element.parentNode);	// added

		//this.selectImage(element);
		//var select = $('attribute-' + attributeData.productId + '-' + attributeData.attributeId);
		//select.value = attributeData.optionId;
		//this.configureElement(select);
		this.configureElement(element);
	},

	configureElement : function(element) {
		// extension Code
		var _self = this,
			attributeData = this.getAttributeData(element.parentNode);	// added

		// @todo
		//this.reloadOptionLabels(element);

		var container = $('amconf-images-container-' + attributeData.productId + '-' + attributeData.attributeId + '-' + attributeData.optionId);
		if (container) {
			this.selectImage(element);
		} else {
			// Gorilla modified
			$('amconf-images-' + attributeData.productId + '-' + attributeData.attributeId).select('.selected').each(function(child) {
				child.removeClassName('selected');
				child.removeClassName('suppress');
			});
			// End
		}
	},

	/**
	 * Gorilla modified slightly for new markup - customized how we're getting
	 * the attribute data to use a standardized getAttributeData method
	 */
	selectImage : function(element) {
		var _self = this,
			attributeData = this.getAttributeData(element.parentNode);	// added

		// Selection state changes
		$('amconf-images-' + attributeData.productId + '-' + attributeData.attributeId).select('.selected').each(function(child){
			child.removeClassName('selected');
			child.removeClassName('suppress');
		});
		element.parentNode.addClassName('selected');


		// Gorilla Add for PDP url to append hash 
		var content = element.up('.content'); 
        if(jQuery(content).hasClass('boxed')){
            content.select('a').each(function(a) {
                if (a.href.match(/javascript/)) return;
                var pos = a.href.indexOf('#');
                if (pos == '-1') {
                    a.href = a.href + '#' + attributeData.attributeId + '=' + attributeData.optionId;
                } else {
                    a.href = a.href.substring(0, pos) + '#' + attributeData.attributeId + '=' + attributeData.optionId;
                }
            });
        }else{
            content.select('a').each(function(a) {
                if (a.href.match(/javascript/)) return;
                var pos = a.href.indexOf('&');
                if (pos == '-1') {
                    a.href = a.href + '&' + attributeData.attributeId + '=' + attributeData.optionId;
                } else {
                    a.href = a.href.substring(0, pos) + '&' + attributeData.attributeId + '=' + attributeData.optionId;
                }
            });
        }

		// Gorilla End

		// Gorilla Add to update Swatch selected attribute on favorites element
		content.select('.favorite').each(function(a) {
			//a.setAttribute('data-product', JSON.stringify({'option' : attributeData.optionId, 'attribute' : attributeData.attributeId, 'product' : attributeData.productId}));
			jQuery(a).data('product', {"option" : attributeData.optionId, "attribute" : attributeData.attributeId, "product" : attributeData.productId});
			//console.log(jQuery(a).data('product'));
		});
		// Gorilla End

        if (typeof(this.optionProducts[attributeData.optionId]['small_image']) !== 'undefined') {
            var mainImage = this.container.up('.item').select('.product-image img')[0];
            mainImage.src = _self.optionProducts[attributeData.optionId]['small_image'];
        }
        if (typeof(this.optionProducts[attributeData.optionId]['alt_image']) !== 'undefined') {
            var mainImage = this.container.up('.item').select('.product-image img.alt-image')[0];
            mainImage.src = _self.optionProducts[attributeData.optionId]['alt_image'];
        }
	}
};


// Preload all small images
Event.observe(window, 'load', function() {
	if (typeof confData === 'undefined') return;

 	var imageObj = new Image();
	for (key in confData) {
		if (parseInt(key) > 0) {
			var keys = Object.keys(confData[key].optionProducts);
			for (var i = 0; i < keys.length; i++) {
				imageObj.src = confData[key]['optionProducts'][keys[i]]['small_image'];
			}
		}
	}
});