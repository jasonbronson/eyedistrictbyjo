;

// Create Gorilla object in global name space to pass into closure
if (typeof Gorilla === 'undefined') {
	var Gorilla = {};
}

/**
 * Gorilla Utilities/helper methods
 *
 * @param this | window.Gorilla object
 * @param $ | window.jQuery object
 */
!function($) {

	this.utilities = {

		$globalMsgs : $('#global-messages'),

		/*
		 * Height alignment/adjustment for PL Grids
		 *
		 * NOTE: To override this calculation for responsive grids,
		 * add a class of .ignore to the .products-grid element.
		 * @param $objects
		 * @param childSelector
		 */
		heightCalculation : function($objects, childSelector, delay, callback) {
			delay || (delay = 500);
			window.setTimeout(function() {
				Gorilla.utilities.equalHeightCalculation($objects, childSelector);

				if (typeof callback === 'function') {
					callback();
				}
			}, delay);
		},

		equalHeightCalculation : function($objects, childSelector) {
			$objects.not('.ignore').each(function(index, item) {
				var height = 0;
				jQuery(item).find(childSelector).each(function(key, child) {
					if (jQuery(child).outerHeight() > height) {
						height = jQuery(child).outerHeight();
					}
				});

				jQuery(item).find(childSelector).css('min-height', height + 'px');
			});
		},

        rowHeightCalculation : function($objects, childSelector, heightSelector, delay, callback) {
            delay || (delay = 500);
            window.setTimeout(function() {
                Gorilla.utilities.equalHeightByRowCalculation($objects, childSelector, heightSelector);

                if (typeof callback === 'function') {
                    callback();
                } }, delay);
        },


        equalHeightByRowCalculation : function($objects, childSelector, heightSelector) {
            $objects.not('.ignore').each(function(index, item) {

                var list = jQuery(item).children();

                list.removeClass("height-fixed");

                var height = 0;
                var currentRowTopPosition = -1;
                var rowQueue = [];
                var rowData = [];

                jQuery(item).find(childSelector).each(function(key, child) {

                    if (currentRowTopPosition < 0) {
                        currentRowTopPosition = jQuery(child).position().top;
                    } else if (currentRowTopPosition != jQuery(child).position().top) { //New row
                        currentRowTopPosition = jQuery(child).position().top;

                        rowData.push({ height: height, children: rowQueue})

                        //reset
                        height = 0;
                        rowQueue = []
                    }

                    if (jQuery(child).find(heightSelector).height() > height) {
                        height = jQuery(child).find(heightSelector).height()+1;
                    }
                    rowQueue.push(child);
                });

                jQuery(rowData).each(function(k, data){
                    jQuery(data.children).css('height', data.height)
                });

                jQuery(rowQueue).css('height', height + 'px');

                list.addClass("height-fixed");
            });
        },

		/**
		 * Throttling function callbacks to fire at a given timeout.
		 * Useful for event tracking (such as scrolling or resizing)
		 * to prevent firing callback every 1ms.
		 *
		 * @param fn
		 * @param threshold
		 * @param scope
		 * @returns {Function}
		 */
		throttle : function(fn, threshold, scope) {
			var last, deferTimer;
			threshold || (threshold = 250);
			return function() {
				var context = scope || this;
				var now = +new Date, args = arguments;

				if (last && now < last + threshold) {
					// hold on to it
					clearTimeout(deferTimer);
					deferTimer = setTimeout(function () {
						last = now;
						fn.apply(context, args);
					}, threshold);
				} else {
					last = now;
					fn.apply(context, args);
				}
			};
		},

		/**
		 * Debounce method allows a callback to be passed in to
		 * run at the completion of a burst of events (such as
		 * keyup)
		 *
		 * @param fn
		 * @param delay
		 * @returns {Function}
		 */
		debounce : function(fn, delay) {
			var timer = null;
			return function () {
				var context = this, args = arguments;
				clearTimeout(timer);
				timer = setTimeout(function () {
					fn.apply(context, args);
				}, delay);
			};
		},

		/**
		 * Set's an interval based on a maximum number of tries.
		 *
		 * @param max
		 */
		setInterval: function(max, fn) {
			var ctr = 0;
			max || (max = 100);

			var interval = setInterval(function(max) {
				fn && fn();
				if (max != -1 && ctr++ >= max) {
					clearInterval(interval);
					return;
				}
			}.bind(this, max), 50);
		},

		/**
		 * Converts a URL protocol to relative protocol
		 *
		 * @param url String
		 */
		prepareURL: function(url) {
			return url.replace(/http:|https:/, '');
		},

		addSuccess : function(msg, append) {
			this.addMessage('success', msg, append);
		},

		addError : function(msg, append) {
			this.addMessage('error', msg, append);
		},

		/**
		 * Adds a message to the global messages area. Has option to append or just overwrite
		 *
		 * @param type String
		 * @param msg String
		 * @param append boolean
		 */
		addMessage : function(type, msg, append, $altMsgContainer) {
			var $msgsCntr = ($altMsgContainer) ? $altMsgContainer : this.$globalMsgs;
			append || (append = false);
			switch(type) {
				case "success":
					// build classes and markup
					var message = '<li class="success-msg"><ul><li>' + msg +'</li></ul></li>';
					if (append) {
						var $appendTo = $msgsCntr.find('.messages .success-msg').filter(':last-child');
					}
					break;
				case "error":
					// build classes and markup
					var message = '<li class="error-msg"><ul><li>' + msg +'</li></ul></li>';
					if (append) {
						var $appendTo = $msgsCntr.find('.messages .error-msg').filter(':last-child');
					}
					break;
				default:
					var message = '<li class="notice-msg"><ul><li>' + msg +'</li></ul></li>';
					if (append) {
						var $appendTo = $msgsCntr.find('.messages .notice-msg').filter(':last-child');
					}
					break;
			}

			// if set to append, lets append it to the correct ul list else replace html with new messages
			if (append) {
				if ($appendTo.length) {
					$appendTo.after(message);
				} else {
					$msgsCntr.append('<ul class="messages">' + message + '</ul>');
				}
			} else {
				$msgsCntr.html('<ul class="messages">' + message + '</ul>');
			}
			// append to where the messages belong.
		},

		clearMessages : function($altMsgContainer) {
            var $msgsCntr = ($altMsgContainer) ? $altMsgContainer : this.$globalMsgs;

            $msgsCntr.html('');
		},

		/**
		 * Adds a group of messages formatted in a json object/array
		 *
		 * @param msgs
		 * @returns {string}
		 */
		addMessages: function(msgs, type){
			type || (type = 'error');
			this.clearMessages();
			if(msgs instanceof Array){
				for(var i = 0; i < msgs.length; i++) {
					this.addMessage(type, msgs[i], true);
				}
			}else{
				this.addMessage(type, msgs, true);
			}
		},

		scrollTo : function($container, extras, duration) {
			var check = false,
				threshold = 0;

			if (typeof extras === 'object') {
				check = extras.check || check;
				threshold = extras.threshold || threshold;
			} else {
				check = extras
			}
			duration || (duration = 300);
			if (!check || (check && ($container.offset().top - threshold) < window.scrollY)) {
				$('html, body').animate({scrollTop : ($container.offset().top - threshold)}, duration);
			}
		},

		handleTemporaryMessage : function(response) {
			var _d = $.Deferred();

			window.setTimeout(function() {
				var $msgs = $('#temp-global-messages');
				!$msgs.length && $('.breadcrumbs').next().prepend('<div id="temp-global-messages" />');
				$msgs = $('#temp-global-messages').addClass('fix-me staged');

				$('.breadcrumbs + .main').Fixed({
					content: '#temp-global-messages'
				});

				// Setup fixed positioning width calculation
				$(window).on('resize.FixedMsg', Gorilla.utilities.throttle(function() {
					$msgs.hasClass('fixed') && $msgs.css('width', $msgs.parent().width());
				}, 160));

				// Detect if scrolled down to apply a "staged" class and have this transition in
				if ($msgs.hasClass('fixed')) {
					$msgs.css('width', $msgs.parent().css('width'));
					$.support.transition && $msgs[0].offsetWidth;
				}

				// transition in
				$msgs.removeClass('staged').addClass('transition');

				// callbacks for transitions on messages
				if ($.support.transition) {
					$msgs.on($.support.transition.end, function() {
						// If removing from dom
						if ($msgs.hasClass('remove')) {
							$msgs.remove();
							// remove events
							$(window).off('resize.FixedMsg');
							$('.breadcrumbs + .main').Fixed('unset');
						} else {
							$msgs.removeClass('transition');
						}
					});
				} else {
					if ($msgs.hasClass('remove')) {
						$msgs.remove();
						// remove events
						$(window).off('resize.FixedMsg');
						$('.breadcrumbs + .main').Fixed('unset');
					} else {
						$msgs.removeClass('transition');
					}
				}

				// Add content to the container after it's been added to dom to prevent layout jump
				if (response.success) {
					Gorilla.utilities.addMessage('success', response.message, false, $msgs);
				} else {
					Gorilla.utilities.addMessage('error', response.message, false, $msgs);
				}

				// Remove after a few seconds hide it/remove it and remove events associated
				window.setTimeout(function() {
					// Cue up Transition out
					$msgs.addClass('transition staged remove');
				}, 3000);

				_d.resolve(response);
			}, 200);

			return _d.promise();
		},

		/**
		 * resets the custom selects and custom inputs to a given parent element
		 * @param $parent
		 */
		resetInputs: function($parent) {
			"use strict";
			$parent.find('select').CustomSelects('reset');
			$parent.find('input[type="radio"], input[type="checkbox"]').CustomInputs('reset');
		},

		/**
		 * Compares the images natural height and width with a provided
		 * minimum height and width to check against. Fires callback if
		 * valid
		 *
		 * @param $img jQuery Object
		 * @param minH integer
		 * @param minW integer
		 * @param fn function
		 */
		imageZoomDetection: function($img, minH, minW, fn) {
			if (!$img.attr('href')) return;
			var _img = new Image();
			_img.onload = function() {
				var width = this.naturalWidth ? this.naturalWidth : this.width,
					height = this.naturalHeight ? this.naturalHeight : this.height;

				if (height > minH && width > minW) {
					fn();
				}
			};
			_img.src = $img.attr('href');
		},

        toggleSearch : function($container, autoClose){
            if($container.hasClass('form-visible')){
                this.closeSearch($container)
            }else{
                this.openSearch($container, autoClose)
            }
        },

        closeSearch : function($container){
            $container.removeClass('form-visible');
        },

        openSearch : function($container, autoClose){
            var self = this;

            $container.addClass('form-visible');

            if($.support.transition.end){
                $container.one(jQuery.support.transition.end, function(){
                    $container.find('.input-text').focus();
                });
            }else{
                $container.find('.input-text').focus();
            }

            if(autoClose){
                $container.find('.input-text').one('focus', function(e){
                    var $button = $(this).parent('.form-search').find('.close-form');

                    $(document).on('focusin.search click.search touch.search',function(e) {
                        if ($(e.target).closest($container, $button).length) return;
                        $(document).off('.search');
                        self.closeSearch($container);
                    });
                });
            }
        },
        getCcType : function(number) {
            var re = {
                electron: /^(4026|417500|4405|4508|4844|4913|4917)\d+$/,
                maestro: /^(5018|5020|5038|5612|5893|6304|6759|6761|6762|6763|0604|6390)\d+$/,
                dankort: /^(5019)\d+$/,
                interpayment: /^(636)\d+$/,
                unionpay: /^(62|88)\d+$/,
                visa: /^4[0-9]{12}(?:[0-9]{3})?$/,
                mastercard: /^5[1-5][0-9]{14}$/,
                amex: /^3[47][0-9]{13}$/,
                diners: /^3(?:0[0-5]|[68][0-9])[0-9]{11}$/,
                discover: /^6(?:011|5[0-9]{2})[0-9]{12}$/,
                jcb: /^(?:2131|1800|35\d{3})\d{11}$/
            }

            for(var key in re) {
                if(re[key].test(number)) {
                    return key
                }
            }
        }
	};

	/**
	 * Gorilla Cache
	 *
	 * @type {{ajaxQ: {}}}
	 * @private
	 */
	this._cache = {
		ajaxQ: {}
	};

}.call(Gorilla, window.jQuery);

+function($) {
	$(function() {
		// Smooth Scroll Setup
		if ($('.scrollable').length) {
			$(document).on('click', '.scrollable a, a[href="#top"]', function(e) {
				var $this = $(this);
				if ($this.attr("href").match(/^#/)) {
					var top = $($this.attr("href")).length ? $($this.attr("href")).offset().top : 0;
					$('html, body').animate({scrollTop : top}, 500, function() { });
					return false;
				}
			});
		}


		// Scroll to top Setup
        /*var $scrollToTop = $('<a href="#top" class="back-to-top scrollable"/>');
        $('body').append($scrollToTop);
        $(window).on('scroll.Top', function(e) {
            if ($(this).scrollTop() >= 800) {
                $scrollToTop.addClass('show');
            } else {
                $scrollToTop.removeClass('show');
            }
        });*/
	});
}(window.jQuery);


/* ========================================================================
 * Bootstrap: transition.js v3.0.0
 * http://twbs.github.com/bootstrap/javascript.html#transitions
 * ========================================================================
 * Copyright 2013 Twitter, Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * ======================================================================== */

+function ($) {
	"use strict";

	// CSS TRANSITION SUPPORT (Shoutout: http://www.modernizr.com/)
	// ============================================================

	function transitionEnd() {
		var el = document.createElement('bootstrap')

		var transEndEventNames = {
			'WebkitTransition': 'webkitTransitionEnd',
			'MozTransition': 'transitionend',
			'OTransition': 'oTransitionEnd otransitionend',
			'transition': 'transitionend'
		}

		for (var name in transEndEventNames) {
			if (el.style[name] !== undefined) {
				return { end: transEndEventNames[name] }
			}
		}
	}

	// http://blog.alexmaccaw.com/css-transitions
	$.fn.emulateTransitionEnd = function (duration) {
		var called = false, $el = this
		$(this).one($.support.transition.end, function () {
			called = true
		})
		var callback = function () {
			if (!called) {
				$($el).trigger($.support.transition.end)
			}
		}
		setTimeout(callback, duration)
		return this
	}

	$(function () {
		$.support.transition = transitionEnd()
	})

}(window.jQuery);




/**
 * Bind polyfill for ie8
 */
if (!Function.prototype.bind) {
	Function.prototype.bind = function (oThis) {
		if (typeof this !== "function") {
			// closest thing possible to the ECMAScript 5
			// internal IsCallable function
			throw new TypeError("Function.prototype.bind - what is trying to be bound is not callable");
		}

		var aArgs = Array.prototype.slice.call(arguments, 1),
			fToBind = this,
			fNOP = function () {},
			fBound = function () {
				return fToBind.apply(this instanceof fNOP && oThis
					? this
					: oThis,
					aArgs.concat(Array.prototype.slice.call(arguments)));
			};

		fNOP.prototype = this.prototype;
		fBound.prototype = new fNOP();

		return fBound;
	};
}

/**
 * String.prototype.trim Polyfil
 */
if (!String.prototype.trim) {
	String.prototype.trim = function () {
		return this.replace(/^\s+|\s+$/g, '');
	};
}

if (!Array.prototype.indexOf) {
	Array.prototype.indexOf = function(searchElement, fromIndex) {

		var k;

		// 1. Let O be the result of calling ToObject passing
		//    the this value as the argument.
		if (this == null) {
			throw new TypeError('"this" is null or not defined');
		}

		var O = Object(this);

		// 2. Let lenValue be the result of calling the Get
		//    internal method of O with the argument "length".
		// 3. Let len be ToUint32(lenValue).
		var len = O.length >>> 0;

		// 4. If len is 0, return -1.
		if (len === 0) {
			return -1;
		}

		// 5. If argument fromIndex was passed let n be
		//    ToInteger(fromIndex); else let n be 0.
		var n = +fromIndex || 0;

		if (Math.abs(n) === Infinity) {
			n = 0;
		}

		// 6. If n >= len, return -1.
		if (n >= len) {
			return -1;
		}

		// 7. If n >= 0, then Let k be n.
		// 8. Else, n<0, Let k be len - abs(n).
		//    If k is less than 0, then let k be 0.
		k = Math.max(n >= 0 ? n : len - Math.abs(n), 0);

		// 9. Repeat, while k < len
		while (k < len) {
			var kValue;
			// a. Let Pk be ToString(k).
			//   This is implicit for LHS operands of the in operator
			// b. Let kPresent be the result of calling the
			//    HasProperty internal method of O with argument Pk.
			//   This step can be combined with c
			// c. If kPresent is true, then
			//    i.  Let elementK be the result of calling the Get
			//        internal method of O with the argument ToString(k).
			//   ii.  Let same be the result of applying the
			//        Strict Equality Comparison Algorithm to
			//        searchElement and elementK.
			//  iii.  If same is true, return k.
			if (k in O && O[k] === searchElement) {
				return k;
			}
			k++;
		}
		return -1;
	};
}

if (!Array.prototype.filter) {
	Array.prototype.filter = function(fun/*, thisArg*/) {
		'use strict';

		if (this === void 0 || this === null) {
			throw new TypeError();
		}

		var t = Object(this);
		var len = t.length >>> 0;
		if (typeof fun !== 'function') {
			throw new TypeError();
		}

		var res = [];
		var thisArg = arguments.length >= 2 ? arguments[1] : void 0;
		for (var i = 0; i < len; i++) {
			if (i in t) {
				var val = t[i];

				// NOTE: Technically this should Object.defineProperty at
				//       the next index, as push can be affected by
				//       properties on Object.prototype and Array.prototype.
				//       But that method's new, and collisions should be
				//       rare, so use the more-compatible alternative.
				if (fun.call(thisArg, val, i, t)) {
					res.push(val);
				}
			}
		}

		return res;
	};
}

// From https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Object/keys
if (!Object.keys) {
	Object.keys = (function() {
		'use strict';
		var hasOwnProperty = Object.prototype.hasOwnProperty,
			hasDontEnumBug = !({ toString: null }).propertyIsEnumerable('toString'),
			dontEnums = [
				'toString',
				'toLocaleString',
				'valueOf',
				'hasOwnProperty',
				'isPrototypeOf',
				'propertyIsEnumerable',
				'constructor'
			],
			dontEnumsLength = dontEnums.length;

		return function(obj) {
			if (typeof obj !== 'object' && (typeof obj !== 'function' || obj === null)) {
				throw new TypeError('Object.keys called on non-object');
			}

			var result = [], prop, i;

			for (prop in obj) {
				if (hasOwnProperty.call(obj, prop)) {
					result.push(prop);
				}
			}

			if (hasDontEnumBug) {
				for (i = 0; i < dontEnumsLength; i++) {
					if (hasOwnProperty.call(obj, dontEnums[i])) {
						result.push(dontEnums[i]);
					}
				}
			}
			return result;
		};
	}());
}

// Production steps of ECMA-262, Edition 5, 15.4.4.19
// Reference: http://es5.github.io/#x15.4.4.19
if (!Array.prototype.map) {

	Array.prototype.map = function(callback, thisArg) {

		var T, A, k;

		if (this == null) {
			throw new TypeError(' this is null or not defined');
		}

		// 1. Let O be the result of calling ToObject passing the |this|
		//    value as the argument.
		var O = Object(this);

		// 2. Let lenValue be the result of calling the Get internal
		//    method of O with the argument "length".
		// 3. Let len be ToUint32(lenValue).
		var len = O.length >>> 0;

		// 4. If IsCallable(callback) is false, throw a TypeError exception.
		// See: http://es5.github.com/#x9.11
		if (typeof callback !== 'function') {
			throw new TypeError(callback + ' is not a function');
		}

		// 5. If thisArg was supplied, let T be thisArg; else let T be undefined.
		if (arguments.length > 1) {
			T = thisArg;
		}

		// 6. Let A be a new array created as if by the expression new Array(len)
		//    where Array is the standard built-in constructor with that name and
		//    len is the value of len.
		A = new Array(len);

		// 7. Let k be 0
		k = 0;

		// 8. Repeat, while k < len
		while (k < len) {

			var kValue, mappedValue;

			// a. Let Pk be ToString(k).
			//   This is implicit for LHS operands of the in operator
			// b. Let kPresent be the result of calling the HasProperty internal
			//    method of O with argument Pk.
			//   This step can be combined with c
			// c. If kPresent is true, then
			if (k in O) {

				// i. Let kValue be the result of calling the Get internal
				//    method of O with argument Pk.
				kValue = O[k];

				// ii. Let mappedValue be the result of calling the Call internal
				//     method of callback with T as the this value and argument
				//     list containing kValue, k, and O.
				mappedValue = callback.call(T, kValue, k, O);

				// iii. Call the DefineOwnProperty internal method of A with arguments
				// Pk, Property Descriptor
				// { Value: mappedValue,
				//   Writable: true,
				//   Enumerable: true,
				//   Configurable: true },
				// and false.

				// In browsers that support Object.defineProperty, use the following:
				// Object.defineProperty(A, k, {
				//   value: mappedValue,
				//   writable: true,
				//   enumerable: true,
				//   configurable: true
				// });

				// For best browser support, use the following:
				A[k] = mappedValue;
			}
			// d. Increase k by 1.
			k++;
		}

		// 9. return A
		return A;
	};
}



/**
 * Modernizr rules
 */
Modernizr.addTest('csscalc', function() {
	var prop = 'width:',
		el = document.createElement('div');
	el.style.cssText = prop + Modernizr._prefixes.join('calc(10px);' + prop);
	return !!el.style.length;
})
.addTest('vh', function() {
	var prop = 'height:',
		el = document.createElement('div');
	el.style.cssText = prop + Modernizr._prefixes.join('10vh;' + prop);
	return !!el.style.length;
});