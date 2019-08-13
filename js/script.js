function save_token_cred() {


    var api_key = $('#api_key').val();


    var secret_key = $('#secret_key').val();


    var data_arr = {


        api_key: api_key,


        secret_key: secret_key


    };


    var data = {


        action: 'save_oAuth_token',


        data_arr: data_arr


    };


    jQuery.post(ajaxurl, data, function(data) {


        if (data != '') {


            alert(data);


        } else {


            alert('Please enter value');


        }


        location.reload();


    });


}





function sub_status_inactive(id) {


    if (confirm('Are you sure you want to cancel this?')) {


        jQuery("#" + id).prop('value', 'Processing...');


        jQuery("#" + id).css("font-size", "12px");


        var data = {


            action: 'SSM_applyToinactive_sub',


            id: id


        };


        jQuery.post(my_ajax_object.ajax_url, data, function(data) {


            location.reload();


        });


    }


}


function sub_status_inactive2(id) {
	
    if (confirm('Are you sure you want to cancel this?')) {
        	
        jQuery(".cancle2").html('Processing...');	
		
		jQuery(".cancle2").css('pointer-events', 'none');
        jQuery(".cancle2").css("font-size", "12px");
		
        var data = {
            action: 'SSM_applyToinactive_sub',
            id: id
		};
        jQuery.post(my_ajax_object.ajax_url, data, function(data) {
            location.reload();
        });
    }
}


function sub_status_inactive_EndOfCycle(id) {

    if (confirm('Are you sure you want to cancel this?')) {

        jQuery("#" + id).html('Processing...');	

		jQuery("#" + id).css('pointer-events', 'none');

        jQuery("#" + id).css("font-size", "12px");

        var data = {
            action: 'SSM_applyToinactive_sub_EndOfCycle',
            id: id
        };
        jQuery.post(my_ajax_object.ajax_url, data, function(data) {
            location.reload();
        });
    }
}


function Add_credit_card() {


	document.getElementById("Add_card").disabled = true;


    jQuery('#card_loading').addClass('card_processing_img');


    //var customer_iid = jQuery('#Customer_list').find(":selected").val();


    var card_type = jQuery('#card_type').find(":selected").val();


    var card_number = jQuery('#card_number').val();


    //var currency = jQuery('#currency').val();


    var month = jQuery('#Month').find(":selected").val();


    var year = jQuery('#year').find(":selected").val();


    var cvv = jQuery('#cvv').val();


    var card_holder = jQuery("#card_holder").val();


    var street1 = jQuery("#street1").val();


    var street2 = jQuery("#street2").val();


    var city = jQuery("#city").val();


    var postal = jQuery("#postal").val();


    var state = jQuery("#state").val();


    var country = jQuery("#country").val();


    var data_arr = {


        card_type: card_type,


        //customer_iid: customer_iid,


        card_number: card_number,


        //currency: currency,


        month: month,


        year: year,


        cvv: cvv,


        card_holder: card_holder,


        street1: street1,


        street2: street2,


        city: city,


        postal: postal,


        state: state,


        country: country


    };


    var data = {


        action: 'Create_Credit_Card',


        type: "POST",


        data: data_arr,


        dataType: "html",


    };


    jQuery.post(my_ajax_object.ajax_url, data, function(data) {


        jQuery('#card_loading').removeClass('card_processing_img');


        alert(data);


        location.reload();


    });


}

function Add_credit_card_reg() {


	document.getElementById("Add_card").disabled = true;


    jQuery('#card_loading').addClass('card_processing_img');


    //var customer_iid = jQuery('#Customer_list').find(":selected").val();


    var card_type = jQuery('#card_type').find(":selected").val();


    var card_number = jQuery('#card_number').val();


    //var currency = jQuery('#currency').val();


    var month = jQuery('#Month').find(":selected").val();


    var year = jQuery('#year').find(":selected").val();


    var cvv = jQuery('#cvv').val();


    var card_holder = jQuery("#card_holder").val();


    var street1 = jQuery("#street1").val();


    var street2 = jQuery("#street2").val();


    var city = jQuery("#city").val();


    var postal = jQuery("#postal").val();


    var state = jQuery("#state").val();


    var country = jQuery("#country").val();


    var data_arr = {


        card_type: card_type,


        //customer_iid: customer_iid,


        card_number: card_number,


        //currency: currency,


        month: month,


        year: year,


        cvv: cvv,


        card_holder: card_holder,


        street1: street1,


        street2: street2,


        city: city,


        postal: postal,


        state: state,


        country: country


    };

    var data = {


        action: 'Create_Credit_Card_Reg',


        type: "POST",


        data: data_arr,


        dataType: "html",


    };


    jQuery.post(my_ajax_object.ajax_url, data, function(data) {


        jQuery('#card_loading').removeClass('card_processing_img');


        alert(data);


        location.reload();


    });


}





function update_cards1(q) {


	document.getElementById("update_cards").disabled = true;


    //jQuery('#card_loading_edit_'+q).addClass('card_processing_img');


    var customer_id = jQuery("#customer_id").val();


    var card_id = jQuery("#card_id").val();


    var month = jQuery('#Month').find(":selected").val();


    var year = jQuery('#year').find(":selected").val();


    var card_holder = jQuery("#card_holder").val();


    var street1 = jQuery("#street1").val();


    var street2 = jQuery("#street2").val();


    var city = jQuery("#city").val();


    var postal = jQuery("#postal").val();


    var state = jQuery("#state").val();


    var country = jQuery("#country").val();


    var data_arr = {


        customer_id: customer_id,


        card_id: card_id,


        card_holder: card_holder,


        street1: street1,


        street2: street2,


        city: city,


        postal: postal,


        state: state,


        country: country,


        month: month,


        year: year


    };


    var data = {


        action: 'update_Credit_Card',


        data: data_arr


    };


    jQuery.post(my_ajax_object.ajax_url, data, function(data) {


        jQuery('#card_loading_edid_'+q).removeClass('card_processing_img');


        alert(data);


        location.reload();


    });


}

jQuery(document).ready(function(jQuery) {
	
	jQuery("#invoice_nm").change(function() {
		
		var id = jQuery(this).val();
		if (id) {
            jQuery('#card_loading').addClass('card_processing_img');
            var data = {
                action: 'SSM_List_Transaction',
                type: 'GET',
                dataType: 'json',
                id: id                
            };
            jQuery.post(my_ajax_object.ajax_url, data, function(data) {
							
				if(data != 0)
				{
					jQuery('#invoice_tra_list tbody').html(data);
				} else {
					jQuery('#invoice_tra_list tbody').html('<tr><td colspan="5">No data found.</td></tr>');
				}
				
            });
        }
	});
	
});



jQuery(document).ready(function(jQuery) {
	
    jQuery("#card_name").change(function() {


        var id = jQuery(this).children(":selected").attr("id");


        var c_id = jQuery(this).children(":selected").attr("c_id");


        if (id) {


            jQuery('#card_loading').addClass('card_processing_img');


            var data = {


                action: 'List_Subscriber_Card',


                type: 'GET',


                dataType: 'json',


                id: id,


                c_id: c_id


            };


            jQuery.post(my_ajax_object.ajax_url, data, function(data) {


                jQuery('#card_loading').removeClass('card_processing_img');


                jQuery('#card_form').html(data);


            });


        }


    });


});


jQuery(document).ready(function(jQuery) {


    jQuery("#add_new_card").click(function() {


		jQuery('#add_new_card').attr('disabled','disabled');


        var cust_idd = jQuery("#cust_idd").val();


        jQuery('#card_loading').addClass('card_processing_img');


        var data = {


            action: 'add_new_card',


            cust_idd: cust_idd,


            type: 'GET'


        };


        jQuery.post(my_ajax_object.ajax_url, data, function(data) {


            jQuery('#card_loading').removeClass('card_processing_img');


            jQuery('#card_form').html(data);


        });


    });


});


function update_selected_card(card_id, cust_id, q) {





       //var id = $(this).c_idlick.attr("card_id");


       //var c_id = $(this).children(":selected").attr("cuse_id");


       


       var id = card_id;


       var c_id = cust_id;


       if (id) {


           jQuery('#card_loading_edit_'+q).addClass('card_processing_img');


           var data = {


               action: 'List_Subscriber_Card',


               type: 'GET',


               dataType: 'json',


               id: id,


               c_id: c_id,


			   q:q


           };


          jQuery.post(my_ajax_object.ajax_url, data, function(data) {


               jQuery('#card_loading_edit_'+q).removeClass('card_processing_img');


               jQuery('#card_form_edit_'+q).html(data);


           });


       }

   }