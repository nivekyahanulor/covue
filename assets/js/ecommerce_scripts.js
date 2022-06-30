var ecom_purch_total = 0;
var jct = 0;
var pre_check_approve = 0;
var reg_fee = 0;
var is_set_reg = 0;
// var currentTab = 0; 
// var body = $("html, body");


// showTab(currentTab); 

// function topFunction() {
//   document.body.scrollTop = 0; 
//   // document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
//   body.stop().animate({scrollTop:0}, 250, 'swing');
// }

// function showTab(n) {
//   var x = document.getElementsByClassName("tab");
//   x[n].style.display = "block";
  
//   if (n == 0) {
//     document.getElementById("prevBtn").style.display = "none";
//   } else {
//     document.getElementById("prevBtn").style.display = "inline";
//   }
//   if (n == (x.length - 1)) {
//     document.getElementById("nextBtn").innerHTML = "Submit";
//   } else {
//     document.getElementById("nextBtn").innerHTML = "Next";
//   }
  
//   fixStepIndicator(n)
// }

// function nextPrev(n) {
//   var x = document.getElementsByClassName("tab");
  
//   if (n == 1 && !validateForm()) return false;
//   x[currentTab].style.display = "none";
//   currentTab = currentTab + n;
//   if (currentTab >= x.length) {
//     document.getElementById("regForm").submit();
//     return false;
//   }
//   showTab(currentTab);
//   topFunction();
//   // alert(""+currentTab)
 
// }

// function validateForm() {
//   var x, y, i, valid = true;
//   x = document.getElementsByClassName("tab");
//   y = x[currentTab].getElementsByTagName("input");
//   for (i = 0; i < y.length; i++) {
//     if (y[i].value == "") {
//       y[i].className += " invalid";
//     }
//   }
//   if (valid) {
//     document.getElementsByClassName("step")[currentTab].className += " finish";
//   }
//   return valid; 
// }

// function fixStepIndicator(n) {
//   var i, x = document.getElementsByClassName("step");
//   for (i = 0; i < x.length; i++) {
//     x[i].className = x[i].className.replace(" active", "");
//   }
//   x[n].className += " active";
// }

$(document).ready(function(){
    // Dropzone.autoDiscover = false;
    
	$('#example').DataTable( {
        "processing": true,
        "serverSide": true,
        "ajax": "scripts/server_processing.php",
        "paging":   false,
        "ordering": false,
        "info":     false,
        "searching": false
    } );

    $('#precheck_terms').change(function(){
        if($(this).is(":checked")) {
            $('#pre_check_btn').removeAttr('disabled');
        }else{
            $('#pre_check_btn').attr('disabled','disabled');
        }
    })


    $('.prod_purch_cb').change(function() {
    	
        if($(this).is(":checked")) {
            // $(this).attr("checked", returnVal);
            // alert('checked')
            $('.other_cb').attr('disabled','disabled')
            ecom_purch_total = ecom_purch_total + parseFloat($(this).data('price'));
            jct = (ecom_purch_total * 0.1);
            if($('#is_reg').val() == 0 && is_set_reg == 0){

            	ecom_purch_total = ecom_purch_total + reg_fee;
            	jct = (ecom_purch_total * 0.1);
            	$('#purch_con').append(`
            			<li id="acc_setup_purch" class="list-group-item d-flex justify-content-between align-items-center purch">
                        <span>IOR One-Time Registration Fee</span><span class="badge" style="font-size: 1.2rem" >`+reg_fee+`</span>
                      	</li>
                      			`);
                is_set_reg = 1;
            }
            $('#purch_con').append(`
            			<li id="acc_setup_purch" class="list-group-item d-flex justify-content-between align-items-center purch">
                        <span>Account Set-up</span><span class="badge" style="font-size: 1.2rem" >`+$(this).data('price')+`</span>
                      	</li>
                      			`);
            $('#jct').text(jct);
            $('#sub_total').text(ecom_purch_total);
            $('#purch_total').text(ecom_purch_total + jct);
        }else{
            is_set_reg = 0;
        	$('.other_cb').removeAttr('disabled')
        	$('#purch_con #acc_setup_purch').remove();
        	ecom_purch_total = ecom_purch_total - parseFloat($(this).data('price'));
            if($('#is_reg').val() == 0){
                ecom_purch_total = ecom_purch_total - reg_fee;
            }
        	jct = (ecom_purch_total * 0.1);
        	$('#jct').text(jct);
        	$('#sub_total').text(ecom_purch_total);
            $('#purch_total').text(ecom_purch_total + jct);
        }
        if(ecom_purch_total == 0){
    		$('#con_btn').attr('disabled','disabled');
    	}else{
    		$('#con_btn').removeAttr('disabled');
    	}
    });

    // Disable PCP click function temporary

    // $('#checkbox2').change(function() {
    //     if($(this).is(":checked")) {
    //         // $(this).attr("checked", returnVal);
    //         // alert('checked')
    //         ecom_purch_total = ecom_purch_total + 500;
    //         jct = (ecom_purch_total * 0.1);
    //         $('#purch_con').append(`<li id="pcp_purch" class="list-group-item d-flex justify-content-between align-items-center purch">
    //                     <span>Primary contact person</span><span class="badge" style="font-size: 1.2rem" >`+500+`</span>
    //                   </li>`);
    //         $('#jct').text(jct);
    //         $('#sub_total').text(ecom_purch_total);
    //         $('#purch_total').text(ecom_purch_total + jct);
    //     }else{
    //     	$('#purch_con #pcp_purch').remove();
    //     	ecom_purch_total = ecom_purch_total - 500;
    //     	jct = (ecom_purch_total * 0.1);
    //     	$('#jct').text(jct);
    //     	$('#sub_total').text(ecom_purch_total);
    //         $('#purch_total').text(ecom_purch_total + jct);
    //     }
    //     if(ecom_purch_total == 0){
    // 		$('#con_btn').attr('disabled','disabled');
    // 	}else{
    // 		$('#con_btn').removeAttr('disabled');
    // 	}
    // });

    

	// $( ".pre_check_inp" ).each(function( index ) {
	  $('.pre_check_inp').change(function(){
		    if ($('.pre_check_inp:checked').length == $('.pre_check_inp').length) {
		       //do something
		       $('#pre_check_btn').removeAttr('disabled');
		    }else{
		    	$('#pre_check_btn').attr('disabled','disabled');
		    }
		    
		});
	// });
});

function getRegFee(){
    $.ajax({
        type: "POST",
        url: "fetch_reg_fee",
        dataType: "JSON",
        success: function (data) {
            reg_fee = parseFloat(data);
        },
    });
}

function gotoPreCheckForm(){
	if(pre_check_approve){
		$('#modal_billing_checkout').modal('toggle');
	}else{
		$('#pre_check_modal').modal('toggle');
	}
	
}

function submitPreCheck(){
	pre_check_approve = 1;
	$('#con_btn').text('Proceed to checkout');
	$('#pre_check_modal').modal('toggle');
	$('#acc_set_btn').attr('disabled','disabled');
    $('#modal_billing_checkout').modal('toggle');
    // $('#pre_check_modal').modal('hide');
}

function submit_purchase(){
	$.ajax({
		type: "POST",
		url: "../japan_ior/product_services_fee",
		data: { 'products_offer': '11|12','subtotal':ecom_purch_total, 'jct': jct, 'total' :(ecom_purch_total + jct),'product_services' : 'amazon' },
		success: function (data) {
			window.location = "../japan_ior/billing_invoices";
		},
	});
}