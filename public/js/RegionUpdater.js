/**
 * RegionUpdater updates
 * @see /js/varien/form.js
 */
RegionUpdater.prototype.update = function() {
	if (this.regions[this.countryEl.value]) {
		var i, option, region, def;

		def = this.regionSelectEl.getAttribute('defaultValue');
		if (this.regionTextEl) {
			if (!def) {
				def = this.regionTextEl.value.toLowerCase();
			}
			this.regionTextEl.value = '';
		}

		this.regionSelectEl.options.length = 1;
		for (regionId in this.regions[this.countryEl.value]) {
			region = this.regions[this.countryEl.value][regionId];

			option = document.createElement('OPTION');
			option.value = regionId;
			option.text = region.name.stripTags();
			option.title = region.name;

			if (this.regionSelectEl.options.add) {
				this.regionSelectEl.options.add(option);
			} else {
				this.regionSelectEl.appendChild(option);
			}

			if (regionId==def || (region.name && region.name.toLowerCase()==def) ||
				(region.name && region.code.toLowerCase()==def)
				) {
				this.regionSelectEl.value = regionId;
			}
		}

		if (this.disableAction=='hide') {
			if (this.regionTextEl) {
				this.regionTextEl.style.display = 'none';
			}

			this.regionSelectEl.style.display = '';

			// Gorilla: Added for custom selects
			if(!this.regionSelectEl.up('.custom-styled-select')){
				jQuery('#' + this.regionSelectEl.id.replace(':', '\\:')).CustomSelects('reset');
			}
			// End additions


		} else if (this.disableAction=='disable') {
			if (this.regionTextEl) {
				this.regionTextEl.disabled = true;
			}
			this.regionSelectEl.disabled = false;
		}
		this.setMarkDisplay(this.regionSelectEl, true);
	} else {
		this.regionSelectEl.options.length = 1;
		if (this.disableAction=='hide') {
			if (this.regionTextEl) {
				this.regionTextEl.style.display = '';
			}

			// Gorilla: Added for custom selects
			if(this.regionSelectEl.up('.custom-styled-select')){
				jQuery('#' + this.regionSelectEl.id.replace(':', '\\:')).CustomSelects('remove');
			}
			// End additions

			this.regionSelectEl.style.display = 'none';
			Validation.reset(this.regionSelectEl);
		} else if (this.disableAction=='disable') {
			if (this.regionTextEl) {
				this.regionTextEl.disabled = false;
			}
			this.regionSelectEl.disabled = true;
		} else if (this.disableAction=='nullify') {
			this.regionSelectEl.options.length = 1;
			this.regionSelectEl.value = '';
			this.regionSelectEl.selectedIndex = 0;
			this.lastCountryId = '';
		}
		this.setMarkDisplay(this.regionSelectEl, false);
	}

	this._checkRegionRequired();

	// Make Zip and its label required/optional
	var zipUpdater = new ZipUpdater(this.countryEl.value, this.zipEl);
	zipUpdater.update();
};
