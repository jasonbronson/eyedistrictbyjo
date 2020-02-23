Object.extend(Validation.prototype, {
    initialize : function(form, options){
        this.form = $(form);
        if (!this.form) {
            return;
        }
        this.options = Object.extend({
            onSubmit : Validation.defaultOptions.onSubmit,
            stopOnFirst : Validation.defaultOptions.stopOnFirst,
            immediate : Validation.defaultOptions.immediate,
            focusOnError : Validation.defaultOptions.focusOnError,
            useTitles : Validation.defaultOptions.useTitles,
            onFormValidate : Validation.defaultOptions.onFormValidate,
            onElementValidate : Validation.defaultOptions.onElementValidate
        }, options || {});
        if(this.options.onSubmit) Event.observe(this.form,'submit',this.onSubmit.bind(this),false);
        if(this.options.immediate) {
            Form.getElements(this.form).each(function(input) { // Thanks Mike!
                if (input.tagName.toLowerCase() == 'select') {
                    Event.observe(input, 'blur', this.onChange.bindAsEventListener(this));
                }
                if (input.type.toLowerCase() == 'radio' || input.type.toLowerCase() == 'checkbox') {
                    Event.observe(input, 'click', this.onChange.bindAsEventListener(this));
                } else {
                    Event.observe(input, 'blur', this.onChange.bindAsEventListener(this));
                }
            }, this);
        }
    }
});

Object.extend(Validation, {
    test : function(name, elm, useTitle) {
        var v = Validation.get(name);
        var prop = '__advice'+name.camelize();
        try {
            if(Validation.isVisible(elm) && !v.test($F(elm), elm)) {

                if(Validation.noAdvicesAndClasses) {
                    return false;
                }

                //if(!elm[prop]) {
                var advice = Validation.getAdvice(name, elm);
                if (advice == null) {
                    advice = this.createAdvice(name, elm, useTitle);
                }
                this.showAdvice(elm, advice, name);
                this.updateCallback(elm, 'failed');
                //}
                elm[prop] = 1;
                if (!elm.advaiceContainer) {
                    elm.removeClassName('validation-passed');
                    elm.addClassName('validation-failed');
                }

                if (Validation.defaultOptions.addClassNameToContainer && Validation.defaultOptions.containerClassName != '') {
                    var container = elm.up(Validation.defaultOptions.containerClassName);
                    if (container && this.allowContainerClassName(elm)) {
                        container.removeClassName('validation-passed');
                        container.addClassName('validation-error');
                    }
                }
                return false;
            } else {

                if(Validation.noAdvicesAndClasses) {
                    return true;
                }

                var advice = Validation.getAdvice(name, elm);
                this.hideAdvice(elm, advice);
                this.updateCallback(elm, 'passed');
                elm[prop] = '';
                elm.removeClassName('validation-failed');
                elm.addClassName('validation-passed');
                if (Validation.defaultOptions.addClassNameToContainer && Validation.defaultOptions.containerClassName != '') {
                    var container = elm.up(Validation.defaultOptions.containerClassName);
                    if (container && !container.down('.validation-failed') && this.allowContainerClassName(elm)) {
                        if (!Validation.get('IsEmpty').test(elm.value) || !this.isVisible(elm)) {
                            container.addClassName('validation-passed');
                        } else {
                            container.removeClassName('validation-passed');
                        }
                        container.removeClassName('validation-error');
                    }
                }
                return true;
            }
        } catch(e) {
            throw(e)
        }
    }
});