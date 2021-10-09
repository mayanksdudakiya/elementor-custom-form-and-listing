var scratchcodeCommon = {
    showLoading : function (){
        jQuery(document).find('#loading').show();
    },
    hideLoading : function(){
        jQuery(document).find('#loading').hide();
    }
}

jQuery(document).ready(function(){

    /*@ Start : Business registration */
    jQuery("#btnSubmit").on('click', function(e) {

        var form = jQuery("#businessRegistration"),
        isUpdate = jQuery(document).find('#company_id').val(); 
        
        form.validate({
            errorElement: 'span',
            errorClass: 'help-block',
            highlight: function(element, errorClass, validClass) {
                jQuery(element).closest('.mbr-form-control').addClass("has-error");
            },
            unhighlight: function(element, errorClass, validClass) {
                //jQuery(element).closest('.elementor-field-group').removeClass("has-error");
            },
            invalidHandler: function(form, validator) {
        
                if (!validator.numberOfInvalids())
                    return;
                
                jQuery('html, body').animate({
                    scrollTop: jQuery(validator.errorList[0].element).offset().top
                }, 1000);
                
            },
            rules: {
                business_name: {
                    required: true,
                },
                business_email: {
                    required: true,
                    email: true
                },
                business_phone_no: {
                    number: true,
                    maxlength: 11,
                    minlength: 11,
                },
                phone_number: {
                    number: true,
                    maxlength: 11,
                    minlength: 11,
                },
                buisness_image: {
                    extension: "png|jpg|gif|jpeg"  
                },
                business_web_url: {
                    url: true,  
                },
                business_facebook_link: {
                    url: true,  
                },
                business_linkedIn_link: {
                    url: true,  
                },
                business_instagram_link: {
                    url: true,  
                },
                business_twitter_link: {
                    url: true,  
                },
                first_name: {
                    required: true,  
                },
                last_name: {
                    required: true,  
                },
                username: {
                    required: (isUpdate) ? false : '',  
                },
                password: {
                    required: (isUpdate) ? false : '',  
                },
                login_email: {
                    required: (isUpdate) ? false : '', 
                    email: true 
                },
                confirm_password : {
                    equalTo : "#password"
                }
            },
            messages: {
                business_name: {
                    required: "Business name required",
                },
                business_email: {
                    required: "Business contact email required",
                    email: "Invalid email address"
                },
                business_web_url: {
                    url: "Invalid URL",  
                },
                business_facebook_link: {
                    url: "Invalid URL",  
                },
                business_linkedIn_link: {
                    url: "Invalid URL",  
                },
                business_instagram_link: {
                    url: "Invalid URL",  
                },
                business_twitter_link: {
                    url: "Invalid URL",  
                },
                first_name: {
                    required: "Firstname required",  
                },
                last_name: {
                    required: "Lastname required",  
                },
                username: {
                    required: "Username required",  
                },
                password: {
                    required: "Password required",  
                },
                login_email: {
                    required: "Email required",  
                },
                buisness_image: {
                    extension: "Please select image with a valid extension (png/jpg/gif)"  
                },
            }
        });
    
        if (form.valid() === true) {

            scratchcodeCommon.showLoading();

            var form_data = new FormData(),
            buisness_image = jQuery('#buisness_image').prop('files')[0];

            form.find('input,textarea,select').each(function(){

                if (jQuery(this).attr('type') === 'checkbox'){
                    if (jQuery(this).is(':checked')){
                        form_data.append(this.name, jQuery(this).val());
                    } else {
                        form_data.append(this.name, '');
                    }
                } else {
                    form_data.append(this.name, jQuery(this).val());  
                }
                
            });

            form_data.append('action', 'scratchcode_business_registration');

            if(buisness_image){
                form_data.append('buisness_image', buisness_image);                
            }
            
            jQuery.ajax({
                url: scratchcodeFrontendConfig.ajaxurl,
                type: 'POST',
                data: form_data,
                contentType: false,
                processData: false,
                success: function(data, status, jqXHR) {

                    if ( data.msg ) {

                        PNotify.success({
                            title: 'Success',
                            text: data.msg,
                        });

                        if ( !isUpdate ) {
                            form[0].reset();
                        }

                        scratchcodeCommon.hideLoading();
                        
                        window.location.href = jQuery('#thank_you_url').val();
                    }
                },
                error: function(jqXHR, status, errorThrown){
                    var response = jqXHR.responseJSON;

                    if ( response ) {
                        PNotify.error({
                            title: 'Error',
                            text: response.msg,
                        }); 
                    }

                    scratchcodeCommon.hideLoading();
                }
            });
        }else{
            return false;
        }
    });
    /*@ End : Business registration */  
});