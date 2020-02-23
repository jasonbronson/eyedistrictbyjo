var EligibilityCheck = Class.create();
EligibilityCheck.prototype = {
    initialize: function (form, urlChek, urlSave, urlConfirmation, urlClaim, urlClaimConfirm, urlClaimSend, urlSaveInDb, urlReload) {
        var _self = this;
        this.form = form;
        this.urlChek = urlChek;
        this.urlSave = urlSave;
        this.urlConfirmation = urlConfirmation;
        this.urlClaim = urlClaim;
        this.urlClaimConfirm = urlClaimConfirm;
        this.urlReload = urlReload;
        this.urlClaimSend = urlClaimSend;
        this.urlSaveInDb = urlSaveInDb;

        var $elBtn = jQuery('.eligibility-modal'),
            $elModal  = jQuery('#eligibility-moby');

        $elBtn.on('click', function(){
            $elModal.Moby('show');

            $elModal.find('select').CustomSelects();
        });

        $elModal.find('.close').on('click', function(){
            $elModal.Moby('hide');
        });
    },
    errorMsg: function(error){
        var container = jQuery('#eligibility-content-load');

        this.setLoadWaiting(false);
        
        if(container.find('.error')) {
            container.find('.error').remove();
        }

        container.prepend('<div class="error">'+error+'</div>');

        setTimeout(function(){
            container.find('.error').remove();
        },3000);
    },
    setLoadWaiting: function(keepDisabled) {

        var container = $('eligibility-buttons-container');
        if (keepDisabled) {
            container.addClassName('loading');
        } else {
            container.removeClassName('loading');
        }
    },

    loadPage: function(url, callback){
        var container = jQuery('#eligibility-content-load');

        var request = new Ajax.Request(
            url,
            {
                method:'get',
                onComplete: function(response){
                    var response = response.responseText;
                    container.html(response);
                    callback();
                },
                onFailure: function(response){
                    var response = response.responseText.evalJSON();
                    console.log('Failure');
                    console.log(response);
                }
            }
        );
    },
    saveInsurance: function(){
        this.setLoadWaiting(true);

        var request = new Ajax.Request(
            this.urlSaveInDb,
            {
                method:'post',
                onComplete: function(response){
                    var response = response.responseText.evalJSON();

                    if(response.success) {
                        eligCheck.loadPage(eligCheck.urlConfirmation);
                    } else {
                        eligCheck.errorMsg(response.message);
                    }
                },
                onFailure: function(data){
                    console.log('Failure');
                    console.log(data);
                },
                parameters: Form.serialize(this.form)
            }
        );


    },
    loadConfirmationClaim: function(){
        this.loadPage(this.urlClaimConfirm);
    },
    loadClaim: function(){
        this.loadPage(this.urlClaim);
    },
    saveInsuranceClaim: function(){
        var container = jQuery('#eligibility-content-load');

        var request = new Ajax.Request(
            this.urlClaimSend,
            {
                method:'get',
                onComplete: function(response){
                    var response = response.responseText.evalJSON();
                    if(response.success) {
                        eligCheck.loadConfirmationClaim();
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
    reloadForm: function(){
        this.loadPage(this.urlReload, function(){

            var container = jQuery('#eligibility-content-load');
            Gorilla.utilities.resetInputs(container);
            container.find('#dob').inputmask("99-99-9999",{ "placeholder": "MM-DD-YYYY" });
        });

    },
    save: function(){
        var validator = new Validation(this.form);
        if (validator.validate()) {

            this.setLoadWaiting(true);

            var request = new Ajax.Request(
                this.urlChek,
                {
                    method:'post',
                    onComplete: function(response){
                        var response = response.responseText.evalJSON();

                        if(response.success) {
                            eligCheck.loadPage(response.next);
                        } else {
                            eligCheck.errorMsg(response.message);
                        }
                    },
                    onFailure: function(data){
                        console.log('Failure');
                        console.log(data);
                    },
                    parameters: Form.serialize(this.form)
                }
            );
        }
    }
}