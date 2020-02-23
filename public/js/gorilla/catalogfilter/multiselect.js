/**
 * Gorilla's catalogfilter multiselect js.
 *
 */
var Gorilla = function(Gorilla, $, window, document) {
	"use strict";

	return Object.extend(Gorilla, {

		Filters: {
			/**
			 * Handles the processing of the filter inputs and makin' it happen
			 *
			 * @param n
			 * @constructor
			 */
			Filter: function(n) {
				var inputs = $$('[name|="' + n + '"]'),
					code = inputs[0].getAttribute('data-var'),
					sep = inputs[0].getAttribute('data-separator'),
					curr = inputs[0].getAttribute('data-vals');

				if (!inputs.length) return;

				// filter out selected inputs only
				switch(inputs[0].tagName.toLowerCase()) {
					case 'select':
						inputs = $A(inputs[0].options).filter(function(v) {
							return v.selected;
						});
						break;
					case 'checkbox':
					default:
						inputs = inputs.filter(function(v) {
							return v.checked;
						});
						break;
				}

				// map values of inputs
				var values = inputs.map(function(v) {
					return v.value;
				});

				location.href = Gorilla.Filters.BuildUrl(values, code, curr, sep);
			},

			/**
			 * Builds the url based on all things Query String!
			 * scenarios:
			 *  - no QS: domain.com ==> domain.com?attr=value;value2
			 *  - existing QS no 'attr': domain.com?color=value;value2 ==> domain.com?color=value;value2&attr=value;value2
			 *  - existing QS and 'attr': domain.com?color=value;value2&attr=value&length=1;2;3 ==> domain.com?color=value;value2&attr=value;value2;value3&length=1;2;3
			 *
			 * @param values
			 * @param code
			 * @param curr
			 * @param sep
			 * @returns {string}
			 * @constructor
			 */
			BuildUrl: function(values, code, curr, sep) {
				var url = location.href;
				var qsRegex = new RegExp(code + '=.*?(&|$)');

				// encode each piece of the URI
				values.each(function(i, k) { values[k] = encodeURIComponent(i); });

				if (qsRegex.test(url)) {
					// find string... and replace the "values" portion of the qs
					url = url.replace(qsRegex, function(match, replace, offset, str) {
						// build replacement to match code=value;value;value(&)?
						// @todo - are the current values encoded already?
						return code + '=' + curr + sep + values.join(sep) + (match[match.length-1] === '&' ? '&' : '');
					});
				} else {
					// check url for ? and append ?code=values else, append &code=values
					url += (/\?/.test(url) ? '&' : '?') + code + '=' + values.join(sep);
				}
				return url;
			}
		}
	});
}(Gorilla || {}, $, window, document);