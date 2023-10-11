jQuery(document).ready(function(){
   
    var nameReg = /^[A-Za-z\-\s]+$/;
    var nameVali = /^[A-Za-z]+$/;
    var lastNameVali = /^[a-zA-Z\-\']+$/;
    var numberReg = /^[0-9]+$/;
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;

    jQuery(document).on('click', '.step1-btn', function(){
        var employees = jQuery('#employees').val();
        var options = jQuery('input[name="radio-card"]:checked').val();
        jQuery('.form_errors').remove();
        var options = []; 
        jQuery.each($('#step1 .radio-card input[type="checkbox"]:checked'), function () {
            options.push($(this).val());
        });
        

        if(employees == '' || employees == 0)
        {
            jQuery('#employees').after('<p class="form_errors">Please enter employees.</p>');
            return false;
        }
        if(options.length == 0)
        {
            jQuery('#employees').after('<p class="form_errors">Please select option.</p>');
            return false;
        }
        
        jQuery('#step1').addClass('d-none');
        jQuery('#step3').addClass('d-none');
        jQuery('#step2').removeClass('d-none');
        var y = $(window).scrollTop(); 
        $(window).scrollTop(y-280);
    });
    jQuery(document).on('click', '.step2-btnOld', function(){

        jQuery('#step1').addClass('d-none');
        jQuery('#step2').addClass('d-none');
        jQuery('#step3').removeClass('d-none');
    });
    jQuery(document).on('click', '.step1-back', function(){
        jQuery('#step3').addClass('d-none');
        jQuery('#step2').addClass('d-none');
        jQuery('#step1').removeClass('d-none');
    });
    jQuery(document).on('click', '.step2-back', function(){
        jQuery('#step3').addClass('d-none');
        jQuery('#step1').addClass('d-none');
        jQuery('#step2').removeClass('d-none');
    });

    jQuery(document).on('click', '.step2-btn', function(){  

        var first_name = jQuery('#first_name').val();
        var employees = jQuery('#employees').val();
        var postal_code = jQuery('#postal_code').val();
        var business_name = jQuery('#business_name').val(); 
        var business_email = jQuery('#business_email').val();
        var business_phone = jQuery('#business_phone').val();

        var options = jQuery('input[name="radio-card"]:checked').val();

        var options = []; 
        jQuery.each($('#step1 .radio-card input[type="checkbox"]:checked'), function () {
            options.push($(this).val());
        });
        console.log(options)

       var form_errors = 0;

       jQuery('.form_errors').remove();


        if(first_name == '' || first_name == 0)
        {
            jQuery('#first_name').after('<p class="form_errors">Please enter first name.</p>');
            form_errors = 1;
        }
        if(postal_code == '' || postal_code == 0)
        {
            jQuery('#postal_code').after('<p class="form_errors">Please enter postal code.</p>');
            form_errors = 1;
        }
        if(business_name == '' || business_name == 0)
        {
            jQuery('#business_name').after('<p class="form_errors">Please enter business name.</p>');
            form_errors = 1;
        }

        if(business_email == '' || business_email == 0)
        {
            jQuery('#business_email').after('<p class="form_errors">Please enter email.</p>');
            form_errors = 1;
        } else if(!emailReg.test(business_email)){
            form_errors=1; 
            jQuery('#business_email').after('<p class="form_errors">Please enter a valid email address</p>');
        }

        if(business_phone == '' || business_phone == 0)
        {
            jQuery('#business_phone').after('<p class="form_errors">Please enter phone.</p>');
            form_errors = 1;
        }else if(business_phone.length < 8){
            form_errors=1; 
            jQuery('#business_phone').after('<p class="form_errors"> Please put atleast 8 digit mobile number.</p>');
        }

        if(form_errors == 0)
        {
            var form_data = {
                action              : 'get_coffee_calculator_price',
                options             : options,
                employees           : employees,
                first_name          : first_name,
                postal_code         : postal_code,
                business_name       : business_name,
                business_phone      : business_phone,
                business_email      : business_email,
                security            : coffeeCalculator.ajax_nonce
            }
            var ajaxurl = coffeeCalculator.ajax_url;

            jQuery.ajax({
                url: ajaxurl,
                type: "POST",
                dataType: "json",
                data: form_data,
                beforeSend: function() { 
                    jQuery('#coffee-loader').show();
                },
                success: function(res) {
                    
                    if(res.status == true)
                    {
                        location.href = res.redirectURL;
                        jQuery('.estimated_cost_per_month').html(res.total_monthly_cost);
                        jQuery('.cost_per_cup').html(res.price_per_cup);
                        jQuery('.cust_per_employee_month').html(res.monthly_price_per_employee);
                    }else{
                        jQuery('#coffee-loader').hide();
                        jQuery('.estimated_cost_per_month').html('0');
                        jQuery('.cost_per_cup').html('0');
                        jQuery('.cust_per_employee_month').html('0');
                    } 
                    var y = $(window).scrollTop(); 
                    $(window).scrollTop(y-210);

                    jQuery('#step1').addClass('d-none');
                    jQuery('#step2').addClass('d-none');
                    jQuery('#step3').removeClass('d-none'); 
                }
            })
        }else{
            return false;
        }
                                    
    });
    jQuery(document).on('click', '.step3-btn', function(){  
        location.reload(true);
    });
    jQuery(document).on('vclick', '.step1-btn, .step2-btn', function(){ 
        console.log("click");
        
    });
});
