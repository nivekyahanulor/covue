/*
 *
 * scripts.js
 * Created by: Mike Coros
 * Date: 07/01/2020
 *
 */

var base_url = $("#base").val();

// $(".dropdown-menu").css("margin-top", 0);

// $(".dropdown")
// 	.mouseover(function () {
// 		$(this).addClass("show").attr("aria-expanded", "true");
// 		$(this).find(".dropdown-menu").addClass("show");
// 	})
// 	.mouseout(function () {
// 		$(this).removeClass("show").attr("aria-expanded", "false");
// 		$(this).find(".dropdown-menu").removeClass("show");
// 	});

var homepage_url = "<?php echo base_url(); ?>";
var current_url = window.location.href;
var prod_id_arr = [];
var ior_pli_total = 0;
var upload_num_arr = [1];
var shipping_prod_arr = [];
function stripTrailingSlash(str) {
	if (str.substr(-1) === "/") {
		return str.substr(0, str.length - 1);
	}
	return str;
}

if (current_url.includes("ior/registration")) {
	if (stripTrailingSlash(current_url) != homepage_url) {
		window.onscroll = function () {
			myFunction();
		};

		var header = document.getElementById("myHeader");

		var sticky = header.offsetTop;

		function myFunction() {
			if (window.pageYOffset > sticky) {
				header.classList.add("sticky");
			} else {
				header.classList.remove("sticky");
			}
		}
	}
}

function FormatCurrency(ctrl) {
	if (
		event.keyCode == 37 ||
		event.keyCode == 38 ||
		event.keyCode == 39 ||
		event.keyCode == 40
	) {
		return;
	}

	var val = ctrl.value;

	val = val.replace(/,/g, "");
	ctrl.value = "";
	val += "";
	x = val.split(".");
	x1 = x[0];
	x2 = x.length > 1 ? "." + x[1] : "";

	var rgx = /(\d+)(\d{3})/;

	while (rgx.test(x1)) {
		x1 = x1.replace(rgx, "$1" + "," + "$2");
	}

	ctrl.value = x1 + x2;
}

function CheckNumeric() {
	return (event.keyCode >= 48 && event.keyCode <= 57) || event.keyCode == 46;
}

$(document).ready(function () {
	bsCustomFileInput.init();
	var spinner = $("#loader");

	$("[data-toggle=tooltip]").tooltip();

	$(".toggle-password").click(function () {
		$(this).toggleClass("fa-eye-slash fa-eye");
		var input = $($(this).attr("toggle"));
		if (input.attr("type") == "password") {
			input.attr("type", "text");
		} else {
			input.attr("type", "password");
		}
	});

	$.validator.setDefaults({
		submitHandler: function () {
			spinner.show();
			$("form#shippingForm").submit();
		},
	});
	$("#shippingForm").validate({
		rules: {
			"hscode_ship[]": {
				required: true,
			},
			total_value: {
				required: true,
				number: true,
			},
			shipping_invoice: {
				required: true,
			},
			amazon_seller: {
				required: true,
			},
			terms: {
				required: true,
			},
		},
		messages: {
			"hscode_ship[]": {
				required: "This field is required",
			},
			total_value: {
				required: "This field is required",
			},
			shipping_invoice: {
				required: "This field is required",
			},
			amazon_seller: {
				required: "This field is required",
			},
			terms: {
				required: "This field is required",
			},
		},
		errorElement: "span",
		errorPlacement: function (error, element) {
			error.addClass("invalid-feedback");
			element.closest(".form-group").append(error);
		},
		highlight: function (element, errorClass, validClass) {
			$(element).addClass("is-invalid");
		},
		unhighlight: function (element, errorClass, validClass) {
			$(element).removeClass("is-invalid");
		},
	});

	$.validator.setDefaults({
		submitHandler: function () {
			spinner.show();
			$("form#edit_shipping_details").submit();
		},
	});
	$("#edit_shipping_details").validate({
		rules: {
			"hscode_ship[]": {
				required: true,
			},
			total_value_of_shipment: {
				required: true,
				number: true,
			},
		},
		messages: {
			"hscode_ship[]": {
				required: "This field is required",
			},
			total_value_of_shipment: {
				required: "This field is required",
			},
		},
		errorElement: "span",
		errorPlacement: function (error, element) {
			error.addClass("invalid-feedback");
			element.closest(".form-group").append(error);
		},
		highlight: function (element, errorClass, validClass) {
			$(element).addClass("is-invalid");
		},
		unhighlight: function (element, errorClass, validClass) {
			$(element).removeClass("is-invalid");
		},
	});

	$(".select2").select2();

	$(function () {
		$("#tbl_dashboard").DataTable({
			responsive: true,
			autoWidth: false,
			ordering: false,
			// columnDefs: [
			// 	{
			// 		targets: [0],
			// 		visible: false,
			// 	},
			// ],
		});

		$("#tblJapanIOR_product_reg").DataTable({
			responsive: true,
			autoWidth: false,
			paging: false,
			searching: false,
			info: false,
			ordering: false,
			order: [[0, "asc"]],
		});

		$("#tblBillingInvoices").DataTable({
			responsive: true,
			autoWidth: false,
			bSort: false,
			order: [[0, "asc"]],
		});

		$("#tblJapanIOR_billing").DataTable({
			responsive: true,
			autoWidth: false,
			paging: false,
			searching: false,
			pageLength: 1,
			info: false,
			ordering: false,
			order: [[0, "desc"]],
			columnDefs: [
				{
					targets: [0],
					visible: false,
				},
			],
		});

		$("#tblShipping").DataTable({
			responsive: true,
			autoWidth: false,
			bSort: false,
		});

		$("#tblJapanIOR_shipping").DataTable({
			responsive: true,
			autoWidth: false,
			paging: false,
			searching: false,
			pageLength: 1,
			info: false,
			ordering: false,
			order: [[0, "asc"]],
		});

		$("#tbl_product_registrations").DataTable({
			responsive: true,
			autoWidth: false,
			bSort: false,
		});
		$("#tbl_product_labels").DataTable({
			responsive: true,
			autoWidth: false,
			bSort: false,
		});
		$("#tblShippingDetails").DataTable({
			responsive: true,
			autoWidth: false,
			bSort: false,
		});
		$("#tblShippingCompanies").DataTable({
			responsive: true,
			autoWidth: false,
			bSort: false,
			order: [[0, "desc"]],
		});
		$("#tblUsersSub").DataTable({
			responsive: true,
			autoWidth: false,
			bSort: false,
		});
		$("#tblUsers").DataTable({
			responsive: true,
			autoWidth: false,
			bSort: false,
		});
		$("#tblRegulatedApplications").DataTable({
			responsive: true,
			autoWidth: false,
			bSort: false,
		});

		$("#tblJapanIOR_regulated").DataTable({
			responsive: true,
			autoWidth: false,
			paging: false,
			searching: false,
			pageLength: 1,
			info: false,
			ordering: false,
			order: [[0, "desc"]],
		});

		$("#tblRegulatedTracking").DataTable({
			responsive: true,
			autoWidth: false,
			bSort: false,
		});
		$("#tblCosmeticProducts").DataTable({
			autoWidth: false,
			bSort: false,
			order: [[0, "desc"]],
		});
		$("#tblCosmeticProductsLabels").DataTable({
			autoWidth: false,
			bSort: false,
		});
		$("#tblRegulatedApplicationsAdmin").DataTable({
			responsive: true,
			autoWidth: false,
			order: [[0, "desc"]],
		});
		$("#tblIngredients").DataTable({
			responsive: true,
			autoWidth: false,
			bSort: false,
		});
		$("#tblKnowledgebase").DataTable({
			responsive: true,
			autoWidth: false,
			bSort: false,
		});
		// $("#tblRegulatedApplicationsDetails").DataTable({
		// 	responsive: true,
		// 	autoWidth: false,
		// 	bSort: false,
		// 	order: [[0, "desc"]],
		// });
	});

	// if ($("#fosr_value").val() == "") {
	// 	$("#btn_submit_for_approval_disabled").show();
	// 	$("#btn_submit_for_approval").hide();
	// } else {
	// 	$("#btn_submit_for_approval").show();
	// 	$("#btn_submit_for_approval_disabled").hide();
	// }

	var text_max_supplier = 100;

	$("#supplier_address_count").html(
		"(" + text_max_supplier + " characters remaining)"
	);

	$("#supplier_address").keyup(function () {
		var text_length_supplier = $("#supplier_address").val().length;
		var text_remaining_supplier = text_max_supplier - text_length_supplier;

		$("#supplier_address_count").html(
			"(" + text_remaining_supplier + " characters remaining)"
		);
	});

	var text_max_destination = 100;

	$("#destination_address_count").html(
		"(" + text_max_destination + " characters remaining)"
	);

	$("#destination_address").keyup(function () {
		var text_length_destination = $("#destination_address").val().length;
		var text_remaining_destination =
			text_max_destination - text_length_destination;

		$("#destination_address_count").html(
			"(" + text_remaining_destination + " characters remaining)"
		);
	});

	var text_max_content = 1000;

	$("#content_count").html("(" + text_max_content + " characters remaining)");

	$("#shipping_company").change(function () {
		var id = $("#shipping_company").val();

		if (id == "") {
			Toast.fire({
				icon: "error",
				position: "center",
				title: "Please select a shipping company.",
			});
		} else {
			$.ajax({
				url: base_url + "japan_ior/fetch_shipping_company",
				type: "POST",
				data: { id: id },
				success: function (response) {
					$("strong#selected_shipping_company").html(response);

					$("#modal_select_shipping_company").modal({
						keyboard: false,
						backdrop: "static",
						show: true,
					});
				},
				error: function () {
					Toast.fire({
						icon: "error",
						position: "center",
						title:
							"Sorry for the inconvenience, some errors found. Please contact administrator.",
					});
				},
			});
		}
	});
});

const Toast = Swal.mixin({
	toast: true,
	position: "center",
	showConfirmButton: false,
	timer: 5000,
});

function showConfirmApprove(params, url) {
	if (url != "product_registrations/mailing_products") {
		$("#btn_approve").html(
			'<button type="button" class="btn btn-success" onclick="approveProdReg(\'' +
				params +
				"')\">Yes</button> " +
				'<button type="button" class="btn btn-danger" data-dismiss="modal">No</button>'
		);
		$("#mailing-prod-price").hide();
	} else {
		$("#mailing-prod-price").show();
		$("#btn_approve").html(
			'<button type="button" class="btn btn-success" onclick="approveMailingProdReg(\'' +
				params +
				"')\">Yes</button> " +
				'<button type="button" class="btn btn-danger" data-dismiss="modal">No</button>'
		);
	}

	$("#modal_approve").modal({
		keyboard: false,
		backdrop: "static",
		show: true,
	});
}

function approveMailingProdReg(id) {
	if ($("#mailing_product_price").val() == "") {
		alert("Please enter Amount");
	} else {
		var spinner = $("#loader");

		$.ajax({
			url: base_url + "product_registrations/product_approve_mailing_product",
			type: "POST",
			data: {
				id: id,
				mailing_product_price: $("#mailing_product_price").val(),
			},
			beforeSend: function () {
				spinner.show();
				$("#modal_approve").modal("hide");
			},
			complete: function () {
				spinner.hide();
			},
			success: function (result) {
				if (result == 1) {
					Toast.fire({
						icon: "success",
						position: "center",
						title: "Product is successfully approved!",
					});

					$("td#status_" + id).html(
						'<span class="badge badge-success">Approved</span>'
					);
				}
			},
			error: function () {
				Toast.fire({
					icon: "error",
					position: "center",
					title:
						"Sorry for the inconvenience, some errors found. Please contact administrator.",
				});
			},
		});
	}
}

function approveProdReg(id) {
	var spinner = $("#loader");

	$.ajax({
		url: base_url + "product_registrations/product_approve",
		type: "POST",
		data: { id: id },
		beforeSend: function () {
			spinner.show();
			$("#modal_approve").modal("hide");
		},
		complete: function () {
			spinner.hide();
		},
		success: function (result) {
			if (result == 1) {
				Toast.fire({
					icon: "success",
					position: "center",
					title: "Product is successfully approved!",
				});

				$("td#status_" + id).html(
					'<span class="badge badge-success">Approved</span>'
				);
			}
		},
		error: function () {
			Toast.fire({
				icon: "error",
				position: "center",
				title:
					"Sorry for the inconvenience, some errors found. Please contact administrator.",
			});
		},
	});
}

function showConfirmApproveRegApp(params) {
	$("#btn_approve").html(
		'<button type="button" class="btn btn-success" onclick="approveProdRegApp(\'' +
			params +
			"')\">Yes</button> " +
			'<button type="button" class="btn btn-danger" data-dismiss="modal">No</button>'
	);

	$("#modal_approve").modal({
		keyboard: false,
		backdrop: "static",
		show: true,
	});
}

function approveProdRegApp(id) {
	var spinner = $("#loader");

	$.ajax({
		url: base_url + "product_registrations/product_approve_regapp",
		type: "POST",
		data: { id: id },
		beforeSend: function () {
			spinner.show();
			$("#modal_approve").modal("hide");
		},
		complete: function () {
			spinner.hide();
			location.reload();
		},
		success: function (result) {
			if (result == 1) {
				Toast.fire({
					icon: "success",
					position: "center",
					title: "Product is successfully approved!",
				});

				$("td#status_" + id).html(
					'<span class="badge badge-success">Approved</span>'
				);
			}
			location.reload();
		},
		error: function () {
			Toast.fire({
				icon: "error",
				position: "center",
				title:
					"Sorry for the inconvenience, some errors found. Please contact administrator.",
			});
			location.reload();
		},
	});
}

function showConfirmDecline(params) {
	$("#btn_decline").html(
		'<button type="button" class="btn btn-success" onclick="declineProdReg(\'' +
			params +
			"')\">Send Declined Message</button> " +
			'<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>'
	);

	$("#modal_decline").modal({
		keyboard: false,
		backdrop: "static",
		show: true,
	});
}

function declineProdReg(params) {
	var params_split = params.split("|");

	var spinner = $("#loader");
	var declined_msg = $("#declined_msg").val();

	$.ajax({
		url: base_url + "product_registrations/product_decline",
		type: "POST",
		data: { id: params_split[0], declined_msg: declined_msg },
		beforeSend: function () {
			spinner.show();
			$("#modal_decline").modal("hide");
		},
		complete: function () {
			spinner.hide();
		},
		success: function (result) {
			if (result == 1) {
				Toast.fire({
					icon: "success",
					position: "center",
					title: "Product is declined, successfully sent declined message!",
				});

				$("td#status_" + params).html(
					'<span class="badge badge-danger">Declined</span>'
				);
			}
			spinner.hide();
		},
		error: function () {
			Toast.fire({
				icon: "error",
				position: "center",
				title:
					"Sorry for the inconvenience, some errors found. Please contact administrator.",
			});
			spinner.hide();
		},
	});
}

function showConfirmRevision(params) {
	$("#btn_revision").html(
		'<button type="button" class="btn btn-success" onclick="revisionProdReg(\'' +
			params +
			"')\">Send Revisions</button> " +
			'<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>'
	);

	$("#modal_revision_product_registration").modal({
		keyboard: false,
		backdrop: "static",
		show: true,
	});
}

function revisionProdReg(params) {
	var params_split = params.split("|");

	var spinner = $("#loader");
	var revisions_msg = $("#revisions_msg").val();

	$.ajax({
		url: base_url + "product_registrations/product_revisions",
		type: "POST",
		data: { id: params_split[0], revisions_msg: revisions_msg },
		beforeSend: function () {
			spinner.show();
			$("#modal_revision_product_registration").modal("hide");
		},
		complete: function () {
			spinner.hide();
		},
		success: function (result) {
			if (result == 1) {
				Toast.fire({
					icon: "success",
					position: "center",
					title: "Successfully sent revisions message!",
				});

				$("td#status_" + params).html(
					'<span class="badge badge-warning">Needs Revision</span>'
				);
			}
		},
		error: function () {
			Toast.fire({
				icon: "error",
				position: "center",
				title:
					"Sorry for the inconvenience, some errors found. Please contact administrator.",
			});
		},
	});
}

function showConfirmDelete(id) {
	$("#btn_delete").html(
		'<button type="button" class="btn btn-success" onclick="deleteProdReg(\'' +
			id +
			"')\">Yes</button> " +
			'<button type="button" class="btn btn-danger" data-dismiss="modal">No</button>'
	);
	$("#modal_delete_product").modal({
		keyboard: false,
		backdrop: "static",
		show: true,
	});
}

function deleteProdReg(id) {
	var spinner = $("#loader");

	$.ajax({
		url: base_url + "product_registrations/product_delete",
		type: "POST",
		data: { id: id },
		beforeSend: function () {
			spinner.show();
			$("#modal_delete_product").modal("hide");
		},
		complete: function () {
			spinner.hide();
		},
		success: function (result) {
			if (result == 1) {
				Toast.fire({
					icon: "success",
					position: "center",
					title:
						"Product is successfully deleted! Redirecting to Product Registration List.",
				});

				setTimeout(function () {
					window.location.href = base_url + "product_registrations";
				}, 3000);
			}
		},
		error: function () {
			Toast.fire({
				icon: "error",
				position: "center",
				title:
					"Sorry for the inconvenience, some errors found. Please contact administrator.",
			});
		},
	});
}

function showConfirmationAccepted(params) {
	$("#confirmButtonsAccept").html(
		'<button type="button" class="btn btn-dark-blue" onclick="acceptShipping(\'' +
			params +
			"')\">Yes</button> " +
			'<button type="button" class="btn btn-outline-dark-blue" data-dismiss="modal">No</button>'
	);
	$("#acceptShipping").modal({
		keyboard: false,
		backdrop: "static",
		show: true,
	});
}

function acceptShipping(params) {
	var spinner = $("#loader");

	$.ajax({
		url: base_url + "shipping_details/accept_shipping",
		type: "POST",
		data: { id: params },
		beforeSend: function () {
			spinner.show();
			$("#acceptShipping").modal("hide");
		},
		complete: function () {
			spinner.hide();
		},
		success: function (result) {
			if (result == 1) {
				Toast.fire({
					icon: "success",
					position: "center",
					title: "Shipping is successfully accepted!",
				});

				$("td#status_" + params).html(
					'<span class="badge badge-info">Accepted</span>'
				);
			}
		},
		error: function () {
			Toast.fire({
				icon: "error",
				position: "center",
				title:
					"Sorry for the inconvenience, some errors found. Please contact administrator through livechat or email.",
			});
		},
	});
}

function showConfirmationRevision(params) {
	$("#confirmButtons").html(
		'<button type="button" class="btn btn-dark-blue" onclick="revisionShipping(\'' +
			params +
			"')\">Yes</button> " +
			'<button type="button" class="btn btn-outline-dark-blue" data-dismiss="modal">No</button>'
	);

	$("#revisionShipping").modal({
		keyboard: false,
		backdrop: "static",
		show: true,
	});
}

function revisionShipping(params) {
	var params_split = params.split("|");

	var spinner = $("#loader");
	var revisions_msg = $("#revisions_msg").val();

	$.ajax({
		url: base_url + "shipping_details/revision_shipping",
		type: "POST",
		data: { id: params_split[0], revisions_msg: revisions_msg },
		beforeSend: function () {
			spinner.show();
			$("#revisionShipping").modal("hide");
		},
		complete: function () {
			spinner.hide();
		},
		success: function (result) {
			if (result == 1) {
				Toast.fire({
					icon: "success",
					position: "center",
					title:
						"Product is set to revisions, successfully sent revisions message!",
				});

				$("td#status_" + params).html(
					'<span class="badge badge-warning">Needs Revision</span>'
				);
			}
		},
		error: function () {
			Toast.fire({
				icon: "error",
				position: "center",
				title:
					"Sorry for the inconvenience, some errors found. Please contact administrator through livechat or email.",
			});
		},
	});
}

function showConfirmationCompleted(params) {
	$("#custom_report_id").val(params);

	$("#uploadCustomReport").modal({
		keyboard: false,
		backdrop: "static",
		show: true,
	});
}

$("#btn_upload").click(function () {
	var fd = new FormData();
	var custom_report_id = $("#custom_report_id").val();
	var files = $("#custom_report")[0].files[0];
	fd.append("custom_report", files);

	// AJAX request
	$.ajax({
		url: base_url + "shipping_details/do_upload",
		type: "post",
		data: fd,
		contentType: false,
		processData: false,
		success: function (response) {
			if (response != 0) {
				// Show image preview
				completedShipping(response + "|" + custom_report_id);
			} else {
				alert("Custom Report not uploaded");
			}
		},
	});
});

function completedShipping(params) {
	var spinner = $("#loader");
	var params_split = params.split("|");

	$.ajax({
		url: base_url + "shipping_details/completed_shipping",
		type: "POST",
		data: {
			custom_report_filename: params_split[0],
			custom_report_id: params_split[1],
		},
		beforeSend: function () {
			spinner.show();
			$("#reviewShipping").modal("hide");
		},
		complete: function () {
			spinner.hide();
		},
		success: function (result) {
			if (result == 1) {
				window.location.href = base_url + "shipping_details";
			}
		},
		error: function () {
			Toast.fire({
				icon: "error",
				position: "center",
				title:
					"Sorry for the inconvenience, some errors found. Please contact administrator through livechat or email.",
			});
		},
	});
}

function showConfirmationDeleteRegulatedProduct(params) {
	$("#confirmButtonsDeleteRegulatedProduct").html(
		'<button type="button" class="btn btn-dark-blue" onclick="deleteRegulatedProduct(\'' +
			params +
			"')\">Yes</button> " +
			'<button type="button" class="btn btn-outline-dark-blue" data-dismiss="modal">No</button>'
	);
	$("#deleteShipping").modal({
		keyboard: false,
		backdrop: "static",
		show: true,
	});
}

function showConfirmationDeleteShipping(params) {
	$("#confirmButtonsDeleteShipping").html(
		'<button type="button" class="btn btn-dark-blue" onclick="deleteShipping(\'' +
			params +
			"')\">Yes</button> " +
			'<button type="button" class="btn btn-outline-dark-blue" data-dismiss="modal">No</button>'
	);
	$("#deleteShipping").modal({
		keyboard: false,
		backdrop: "static",
		show: true,
	});
}

function deleteShipping(params) {
	var spinner = $("#loader");

	$.ajax({
		url: base_url + "shipping_details/delete_shipping",
		type: "POST",
		data: { id: params },
		beforeSend: function () {
			spinner.show();
			$("#deleteShipping").modal("hide");
		},
		complete: function () {
			spinner.hide();
		},
		success: function (result) {
			if (result == 1) {
				Toast.fire({
					icon: "success",
					position: "center",
					title: "Successfully deleted, redirecting to Shipping List.",
				});

				setTimeout(function () {
					window.location.href = base_url + "shipping_details";
				}, 3000);
			}
		},
		error: function () {
			Toast.fire({
				icon: "error",
				position: "center",
				title:
					"Sorry for the inconvenience, some errors found. Please contact administrator through livechat or email.",
			});
		},
	});
}

function showConfirmationDeleteAdminUser(params) {
	$("#confirmButtons").html(
		'<button type="button" class="btn btn-success" onclick="deleteAdminUser(\'' +
			params +
			"')\">Yes</button> " +
			'<button type="button" class="btn btn-danger" data-dismiss="modal">No</button>'
	);
	$("#deleteAdminUser").modal({
		keyboard: false,
		backdrop: "static",
		show: true,
	});
}

function deleteAdminUser(params) {
	var spinner = $("#loader");

	$.ajax({
		url: base_url + "users/delete_user",
		type: "POST",
		data: { id: params },
		beforeSend: function () {
			spinner.show();
			$("#reviewShipping").modal("hide");
		},
		complete: function () {
			spinner.hide();
		},
		success: function (result) {
			if (result == 1) {
				window.location.href = base_url + "users/admin_users";
			}
		},
		error: function () {
			Toast.fire({
				icon: "error",
				position: "center",
				title:
					"Sorry for the inconvenience, some errors found. Please contact administrator through livechat or email.",
			});
		},
	});
}

function showShippingNotice(params) {
	$("#confirmButtonsShippingNotice").html(
		'<a href="' +
			base_url +
			"japan_ior/ior_shipping_fee/" +
			params +
			'" id="btnPayNow" class="btn orange-btn disabled">Pay Now</a>'
	);
	$("#shippingNotice").modal({
		keyboard: false,
		backdrop: "static",
		show: true,
	});
}

$("#shipping_terms").change(function () {
	if ($(this).is(":checked")) {
		$("#btnPayNow").removeClass("disabled");
	} else {
		$("#btnPayNow").addClass("disabled");
	}
});

$("#selec_all_regulated_products").change(function () {
	if ($(this).is(":checked")) {
		$(".cb-reg-prod").prop("checked", true);
		$("#approve-all-con").show();
	} else {
		$(".cb-reg-prod").prop("checked", false);
		$("#approve-all-con").hide();
	}
});

$(".cb-reg-prod").click(function () {
	var count = $("input:checkbox[class=cb-reg-prod]:checked").length;
	var allcb = $("input:checkbox[class=cb-reg-prod]").length;

	if ($(this).prop("checked")) {
		prod_id_arr.push($(this).val());
	}

	if (count > 1) {
		$("#approve-all-con").show();
	} else {
		$("#approve-all-con").hide();
	}

	if (count != allcb) {
		$("#selec_all_regulated_products").prop("checked", false);
	} else {
		$("#selec_all_regulated_products").prop("checked", true);
	}
});

function showApproveAllProduct(id = "") {
	$("#modal_approve_regulated_product").modal("toggle");
	$("#mod-bod-approve span").remove();
	if (id == "") {
		$("#mod-bod-approve").append(
			'<span>Are you sure you want to <strong class="text-success">approve</strong> all selected products?</span>'
		);
	} else {
		$("#mod-bod-approve").append(
			'<span>Are you sure you want to <strong class="text-success">approve</strong> this product?</span>'
		);
	}
}

function showDeclineAllProduct() {
	$("#modal_decline_regulated_product").modal("toggle");
}

function showNeedRevAllProduct() {
	$("#modal_need_revision_regulated_product").modal("toggle");
}

function approveAllProduct() {
	var count = $("input:checkbox[class=cb-reg-prod]:checked").length;
	var cnt = 0;
	var loop = 1;
	$.each($("input:checkbox[class=cb-reg-prod]:checked"), function () {
		cnt++;

		if (cnt == count) {
			loop = 0;
		}
		approveRegulatedProduct($(this).val(), loop);
	});
}
function declineAllProduct() {
	var count = $("input:checkbox[class=cb-reg-prod]:checked").length;
	var cnt = 0;
	var loop = 1;
	$.each($("input:checkbox[class=cb-reg-prod]:checked"), function () {
		cnt++;

		if (cnt == count) {
			loop = 0;
		}
		declineRegulatedProduct($(this).val(), loop);
	});
}

function reviseAllProduct() {
	var count = $("input:checkbox[class=cb-reg-prod]:checked").length;
	var cnt = 0;
	var loop = 1;
	$.each($("input:checkbox[class=cb-reg-prod]:checked"), function () {
		cnt++;

		if (cnt == count) {
			loop = 0;
		}
		reviseRegulatedProduct($(this).val(), loop);
	});
}
function approveRegulatedProduct(id, loop) {
	var spinner = $("#loader");

	$.ajax({
		url: base_url + "regulated_applications/product_approve",
		type: "POST",
		data: { reg_prod_id: id },
		beforeSend: function () {
			spinner.show();
			$("#modal_approve_regulated_product").modal("hide");
		},
		complete: function () {
			spinner.hide();
		},
		success: function (response) {
			if (loop == 0) {
				Toast.fire({
					icon: "success",
					position: "center",
					title: "Selected Regulated Products are all approved.",
				});
				setTimeout(function () {
					location.reload();
				}, 3000);
			}
		},
		error: function () {
			Toast.fire({
				icon: "error",
				position: "center",
				title:
					"Sorry for the inconvenience, some errors found. Please contact administrator through livechat or email.",
			});
		},
	});
}
function declineRegulatedProduct(id, loop) {
	var spinner = $("#loader");

	$.ajax({
		url: base_url + "regulated_applications/product_decline",
		type: "POST",
		data: { reg_prod_id: id, declined_msg: $("#declined_all_msg").val() },
		beforeSend: function () {
			spinner.show();
			$("#modal_decline_regulated_product").modal("hide");
		},
		complete: function () {
			spinner.hide();
		},
		success: function (response) {
			if (loop == 0) {
				Toast.fire({
					icon: "success",
					position: "center",
					title: "Selected Regulated Products are all declined.",
				});
				setTimeout(function () {
					location.reload();
				}, 3000);
			}
		},
		error: function () {
			Toast.fire({
				icon: "error",
				position: "center",
				title:
					"Sorry for the inconvenience, some errors found. Please contact administrator through livechat or email.",
			});
		},
	});
}
function reviseRegulatedProduct(id, loop) {
	var spinner = $("#loader");

	$.ajax({
		url: base_url + "regulated_applications/product_revisions",
		type: "POST",
		data: { reg_prod_id: id, revisions_msg: $("#revisions_all_msg").val() },
		beforeSend: function () {
			spinner.show();
			$("#modal_need_revision_regulated_product").modal("hide");
		},
		complete: function () {
			spinner.hide();
		},
		success: function (response) {
			if (loop == 0) {
				Toast.fire({
					icon: "success",
					position: "center",
					title: "Selected Regulated Products need some revisions.",
				});
				setTimeout(function () {
					location.reload();
				}, 3000);
			}
		},
		error: function () {
			Toast.fire({
				icon: "error",
				position: "center",
				title:
					"Sorry for the inconvenience, some errors found. Please contact administrator through livechat or email.",
			});
		},
	});
}
function isValidEmailAddress(emailAddress) {
	var pattern = new RegExp(
		/^(("[\w-+\s]+")|([\w-+]+(?:\.[\w-+]+)*)|("[\w-+\s]+")([\w-+]+(?:\.[\w-+]+)*))(@((?:[\w-+]+\.)*\w[\w-+]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][\d]\.|1[\d]{2}\.|[\d]{1,2}\.))((25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\.){2}(25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\]?$)/i
	);
	return pattern.test(emailAddress);
}

$("#btn_quick_update").click(function () {
	var user_id = $("#user_id").val();
	var contact_person = $("#contact_person").val();
	var contact_number = $("#contact_number").val();
	var email = $("#email").val();

	if (contact_person == "" || contact_number == "" || email == "") {
		Toast.fire({
			icon: "error",
			position: "center",
			title: "Please fill all the required (*) fields.",
		});

		$("#contact_person").focus();
		return false;
	} else {
		if (!isValidEmailAddress(email)) {
			Toast.fire({
				icon: "error",
				position: "center",
				title: "Please input correct email address format.",
			});

			$("#email").focus();
			return false;
		} else {
			$.ajax({
				url: base_url + "japan_ior/quick_update_contact",
				type: "POST",
				data: {
					user_id: user_id,
					contact_person: contact_person,
					contact_number: contact_number,
					email: email,
				},
				success: function (response) {
					if (response != 1) {
						Toast.fire({
							icon: "error",
							position: "center",
							title:
								"Please contact administrator or chat live support for assistance.",
						});
					} else {
						var contact_number_strip = contact_number.replace(/\\/g, "");
						var contact_person_strip = contact_person.replace(/\\/g, "");
						var email_strip = email.replace(/\\/g, "");

						$("label[for=user_contact_no] > strong").text(contact_number_strip);
						$("label[for=user_contact_person] > strong").text(
							contact_person_strip
						);
						$("label[for=user_email] > strong").text(email_strip);
						$("#edit-business-details").modal("hide");

						Toast.fire({
							icon: "success",
							position: "center",
							title: "Successfully updated your contact details.",
						});
					}
				},
				error: function () {
					Toast.fire({
						icon: "error",
						position: "center",
						title:
							"Sorry for the inconvenience, some errors found. Please contact administrator through livechat or email.",
					});
				},
			});
		}
	}
});

$("#shipping_company")
	.select2()
	.on("select2:open", () => {
		$(".select2-results:not(:has(a))").append(
			'<a href="#" id="link_add_shipping_company" style="padding: 6px;height: 20px;display: inline-table;" data-toggle="modal" data-target="#modal_add_shipping_company">+ Add New Shipping Company</a>'
		);

		$("a#link_add_shipping_company").click(function () {
			$("#shipping_company").select2("close");
		});
	});

$("#modal_add_shipping_company").on("shown.bs.modal", function (e) {
	$("#add_shipping_company").focus();
});

$("#btn_add_shipping_company").click(function () {
	var shipping_company = $("#add_shipping_company").val();

	if (shipping_company == "") {
		Toast.fire({
			icon: "error",
			position: "center",
			title: "Please fill up the required (*) field.",
		});
	} else {
		$(this).prop("disabled", true);

		$.ajax({
			url: base_url + "japan_ior/insert_shipping_company",
			type: "POST",
			data: { shipping_company: shipping_company },
			success: function (response) {
				if (response == 0) {
					Toast.fire({
						icon: "error",
						position: "center",
						title: "Shipping Company is already existed.",
					});

					$("#btn_add_shipping_company").prop("disabled", false);
					shipping_company.focus();
				} else {
					location.reload();
				}
			},
			error: function () {
				Toast.fire({
					icon: "error",
					position: "center",
					title:
						"Sorry for the inconvenience, some errors found. Please contact administrator through livechat or email.",
				});
			},
		});
	}
});

$("#same_address").change(function () {
	var supplier_name = $("#supplier_name");
	var supplier_address = $("#supplier_address");
	var supplier_phone_no = $("#supplier_phone_no");

	if ($("#same_address").prop("checked")) {
		supplier_name.val("");
		supplier_address.val("");
		supplier_phone_no.val("");
		supplier_name.attr("disabled", "TRUE");
		supplier_address.attr("disabled", "TRUE");
		supplier_phone_no.attr("disabled", "TRUE");
	} else {
		supplier_name.removeAttr("disabled");
		supplier_address.removeAttr("disabled");
		supplier_phone_no.removeAttr("disabled");
	}
});

function isNumber(evt) {
	evt = evt ? evt : window.event;
	var charCode = evt.which ? evt.which : evt.keyCode;
	if (charCode > 31 && (charCode < 48 || charCode > 57)) {
		return false;
	}
	return true;
}

function validateDec(key) {
	//getting key code of pressed key
	var keycode = key.which ? key.which : key.keyCode;
	//comparing pressed keycodes
	if (!(keycode == 8 || keycode == 46) && (keycode < 48 || keycode > 57)) {
		return false;
	} else {
		var parts = key.srcElement.value.split(".");
		if (parts.length > 1 && keycode == 46) return false;
		return true;
	}
}

function numberWithCommas(x) {
	return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

$("#add_product").click(function () {
	var tr_count = $("#product_table_list > tbody > tr").length;
	var tr_number = tr_count;
	var fba = $(this).attr("data-fba");
	var category_0 = $("#category_0").val();
	var tr_product = tr_count - 1;

	$.getJSON(
		base_url + "japan_ior/registered_products",
		{ category: category_0 },
		function (data) {
			$.each(data, function (index, element) {
				// if(!shipping_prod_arr.includes(element.id)){
				$("#product_" + tr_number).append(
					'<option class="opt_sel_' +
						element.id +
						'" value="' +
						element.id +
						'">' +
						element.product_name +
						"</option>"
				);
				// }
			});
		}
	);

	if (fba == "fba-invoice") {
		var markup =
			'<tr id="product_table_' +
			tr_number +
			'">' +
			'<td><input type="hidden" class="prod_selected" id="cur_sel_' +
			tr_number +
			'"><select class="text-center form-control" id="product_' +
			tr_number +
			'" name="product[]' +
			'" onchange="displaySKU(' +
			tr_number +
			')">' +
			'<option value="" selected>- Select Product -</option></td>' +
			'<td><input type="text" class="text-center form-control" id="sku_' +
			tr_number +
			'" name="sku[]' +
			'" placeholder="HS Code" readonly></td>' +
			'<td><input type="text" class="text-center form-control" id="asin_' +
			tr_number +
			'" name="asin[]' +
			'" placeholder="ASIN"></td>' +
			'<td><input type="text" class="text-center form-control" id="qty_' +
			tr_number +
			'" name="qty[]' +
			'" placeholder="1" value="1" onkeypress="return isNumber(event)" onkeyup="calcTotalAmount(' +
			tr_number +
			')"></td>' +
			'<td><input type="text" class="text-right form-control" id="price_' +
			tr_number +
			'" name="price[]' +
			'" placeholder="0.00" value="0.00" onkeypress="return validateDec(event)" onkeyup="calcTotalAmount(' +
			tr_number +
			')"></td>' +
			'<td><input type="text" class="text-right form-control" id="unit_value_' +
			tr_number +
			'" name="unit_value[]' +
			'" placeholder="0.00" value="0.00" readonly></td>' +
			'<td><input type="text" class="text-right form-control" id="fba_listing_fee_' +
			tr_number +
			'" name="fba_listing_fee[]' +
			'" placeholder="0.00" value="0.00" onkeypress="return validateDec(event)" onkeyup="calcTotalAmount(' +
			tr_number +
			')"></td>' +
			'<td><input type="text" class="text-right form-control" id="fba_shipping_fee_' +
			tr_number +
			'" name="fba_shipping_fee[]' +
			'" placeholder="0.00" value="0.00" onkeypress="return validateDec(event)" onkeyup="calcTotalAmount(' +
			tr_number +
			')"></td>' +
			'<td><input type="text" class="text-right form-control" id="total_amount_' +
			tr_number +
			'" name="total_amount[]' +
			'" placeholder="0.00" value="0.00" readonly></td>' +
			'<td><input type="text" class="text-right form-control" id="unit_value_total_amount_' +
			tr_number +
			'" name="unit_value_total_amount[]' +
			'" placeholder="0.00" value="0.00" readonly></td>' +
			'<td><button type="button" id="add_product_details_' +
			tr_number +
			'" class="btn btn-outline-dark-blue " onclick="addProductDetails(' +
			tr_number +
			')"><i class="fas fa-plus-circle"></i> Add</button></td>' +
			'<td><button type="button" id="remove_product_' +
			tr_number +
			'" class="btn btn-block btn-outline-danger" onclick="removeRow(' +
			tr_number +
			')"><i class="fas fa-times-circle"></i></button></td>' +
			"</tr>";
	} else {
		if ($("#user_role_id").val() != 3) {
			var markup =
				'<tr id="product_table_' +
				tr_number +
				'">' +
				'<td><input type="hidden" class="prod_selected" id="cur_sel_' +
				tr_number +
				'"><select class="text-center form-control" id="product_' +
				tr_number +
				'" name="product[]' +
				'" onchange="displaySKU(' +
				tr_number +
				')">' +
				'<option value="" selected>- Select Product -</option></td>' +
				'<td><input type="text" class="text-center form-control" id="sku_' +
				tr_number +
				'" name="sku[]' +
				'" placeholder="HS Code" readonly></td>' +
				'<td><input type="text" class="text-center form-control" id="qty_' +
				tr_number +
				'" name="qty[]' +
				'" placeholder="1" value="1" onkeypress="return isNumber(event)" onkeyup="calcTotalAmount(' +
				tr_number +
				')"></td>' +
				'<td><input type="text" class="text-right form-control" id="price_' +
				tr_number +
				'" name="price[]' +
				'" placeholder="0.00" value="0.00" onkeypress="return validateDec(event)" onkeyup="calcTotalAmount(' +
				tr_number +
				')"></td>' +
				'<td><input type="text" class="text-right form-control" id="total_amount_' +
				tr_number +
				'" name="total_amount[]' +
				'" placeholder="0.00" value="0.00" readonly></td>' +
				'<td><button type="button" id="add_product_details_' +
				tr_number +
				'" class="btn btn-outline-dark-blue " onclick="addProductDetails(' +
				tr_number +
				')"><i class="fas fa-plus-circle"></i> Add</button></td>' +
				'<td><button type="button" id="remove_product_' +
				tr_number +
				'" class="btn btn-block btn-outline-danger" onclick="removeRow(' +
				tr_number +
				')"><i class="fas fa-times-circle"></i></button></td>' +
				"</tr>";
		} else {
			var markup =
				'<tr id="product_table_' +
				tr_number +
				'">' +
				'<td><input type="hidden" class="prod_selected" id="cur_sel_' +
				tr_number +
				'"><select class="text-center form-control sel_prod" id="product_' +
				tr_number +
				'" name="product[]' +
				'" onchange="displaySKU(' +
				tr_number +
				')">' +
				'<option value="" selected>- Select Product -</option></td>' +
				'<td><input type="text" class="text-center form-control" id="product_type_' +
				tr_number +
				'" name="product_type[]' +
				'" placeholder="Product Type" readonly></td>' +
				'<td><input type="text" class="text-center form-control" id="sku_' +
				tr_number +
				'" name="sku[]' +
				'" placeholder="HS Code" readonly></td>' +
				'<td><input type="text" class="text-center form-control" id="qty_' +
				tr_number +
				'" name="qty[]' +
				'" placeholder="1" value="1" onkeypress="return isNumber(event)" onkeyup="calcTotalAmount(' +
				tr_number +
				')"></td>' +
				'<td><input type="text" class="text-right form-control" id="price_' +
				tr_number +
				'" name="price[]' +
				'" placeholder="0.00" value="0.00" onkeypress="return validateDec(event)" onkeyup="calcTotalAmount(' +
				tr_number +
				')"></td>' +
				'<td><input type="text" class="text-right form-control" id="total_amount_' +
				tr_number +
				'" name="total_amount[]' +
				'" placeholder="0.00" value="0.00" readonly></td>' +
				'<td><button type="button" id="add_product_details_' +
				tr_number +
				'" class="btn btn-outline-dark-blue " onclick="addProductDetails(' +
				tr_number +
				')"><i class="fas fa-plus-circle"></i> Add</button></td>' +
				'<td><button type="button" id="remove_product_' +
				tr_number +
				'" class="btn btn-block btn-outline-danger" onclick="removeRow(' +
				tr_number +
				')"><i class="fas fa-times-circle"></i></button></td>' +
				"</tr>";
		}
	}
	$("table#product_table_list tbody").append(markup);

	var tr_count_minus = tr_count - 1;
	$("#remove_product_" + tr_count_minus).attr("disabled", "TRUE");
});

//** ADD PRODUCT SAMPLING */

$("#add_product_sampling").click(function () {
	var tr_count = $("#product_table_list > tbody > tr").length;
	var tr_number = tr_count;
	var fba = $(this).attr("data-fba");
	var category_0 = $("#category_0").val();
	var tr_product = tr_count - 1;

	$.getJSON(
		base_url + "japan_ior/registered_products_sampling",
		{ category: category_0 },
		function (data) {
			$.each(data, function (index, element) {
				// if(!shipping_prod_arr.includes(element.id)){
				$("#product_" + tr_number).append(
					'<option class="opt_sel_' +
						element.id +
						'" value="' +
						element.id +
						'">' +
						element.product_name +
						"</option>"
				);
				// }
			});
		}
	);

	if (fba == "fba-invoice") {
		var markup =
			'<tr id="product_table_' +
			tr_number +
			'">' +
			'<td><input type="hidden" class="prod_selected" id="cur_sel_' +
			tr_number +
			'"><select class="text-center form-control" id="product_' +
			tr_number +
			'" name="product[]' +
			'" onchange="displaySKU(' +
			tr_number +
			')">' +
			'<option value="" selected>- Select Product -</option></td>' +
			'<td><input type="text" class="text-center form-control" id="sku_' +
			tr_number +
			'" name="sku[]' +
			'" placeholder="HS Code" readonly></td>' +
			'<td><input type="text" class="text-center form-control" id="asin_' +
			tr_number +
			'" name="asin[]' +
			'" placeholder="ASIN"></td>' +
			'<td><input type="text" class="text-center form-control" id="qty_' +
			tr_number +
			'" name="qty[]' +
			'" placeholder="1" value="1" onkeypress="return isNumber(event)" onkeyup="calcTotalAmount(' +
			tr_number +
			')"></td>' +
			'<td><input type="text" class="text-right form-control" id="price_' +
			tr_number +
			'" name="price[]' +
			'" placeholder="0.00" value="0.00" onkeypress="return validateDec(event)" onkeyup="calcTotalAmount(' +
			tr_number +
			')"></td>' +
			'<td><input type="text" class="text-right form-control" id="unit_value_' +
			tr_number +
			'" name="unit_value[]' +
			'" placeholder="0.00" value="0.00" readonly></td>' +
			'<td><input type="text" class="text-right form-control" id="fba_listing_fee_' +
			tr_number +
			'" name="fba_listing_fee[]' +
			'" placeholder="0.00" value="0.00" onkeypress="return validateDec(event)" onkeyup="calcTotalAmount(' +
			tr_number +
			')"></td>' +
			'<td><input type="text" class="text-right form-control" id="fba_shipping_fee_' +
			tr_number +
			'" name="fba_shipping_fee[]' +
			'" placeholder="0.00" value="0.00" onkeypress="return validateDec(event)" onkeyup="calcTotalAmount(' +
			tr_number +
			')"></td>' +
			'<td><input type="text" class="text-right form-control" id="total_amount_' +
			tr_number +
			'" name="total_amount[]' +
			'" placeholder="0.00" value="0.00" readonly></td>' +
			'<td><input type="text" class="text-right form-control" id="unit_value_total_amount_' +
			tr_number +
			'" name="unit_value_total_amount[]' +
			'" placeholder="0.00" value="0.00" readonly></td>' +
			'<td><button type="button" id="remove_product_' +
			tr_number +
			'" class="btn btn-block btn-outline-danger" onclick="removeRow(' +
			tr_number +
			')"><i class="fas fa-times-circle"></i></button></td>' +
			"</tr>";
	} else {
		if ($("#user_role_id").val() != 3) {
			var markup =
				'<tr id="product_table_' +
				tr_number +
				'">' +
				'<td><input type="hidden" class="prod_selected" id="cur_sel_' +
				tr_number +
				'"><select class="text-center form-control" id="product_' +
				tr_number +
				'" name="product[]' +
				'" onchange="displaySKU(' +
				tr_number +
				')">' +
				'<option value="" selected>- Select Product -</option></td>' +
				'<td><input type="text" class="text-center form-control" id="sku_' +
				tr_number +
				'" name="sku[]' +
				'" placeholder="HS Code" readonly></td>' +
				'<td><input type="text" class="text-center form-control" id="qty_' +
				tr_number +
				'" name="qty[]' +
				'" placeholder="1" value="1" onkeypress="return isNumber(event)" onkeyup="calcTotalAmount(' +
				tr_number +
				')"></td>' +
				'<td><input type="text" class="text-right form-control" id="price_' +
				tr_number +
				'" name="price[]' +
				'" placeholder="0.00" value="0.00" onkeypress="return validateDec(event)" onkeyup="calcTotalAmount(' +
				tr_number +
				')"></td>' +
				'<td><input type="text" class="text-right form-control" id="total_amount_' +
				tr_number +
				'" name="total_amount[]' +
				'" placeholder="0.00" value="0.00" readonly></td>' +
				'<td><button type="button" id="remove_product_' +
				tr_number +
				'" class="btn btn-block btn-outline-danger" onclick="removeRow(' +
				tr_number +
				')"><i class="fas fa-times-circle"></i></button></td>' +
				"</tr>";
		} else {
			var markup =
				'<tr id="product_table_' +
				tr_number +
				'">' +
				'<td><input type="hidden" class="prod_selected" id="cur_sel_' +
				tr_number +
				'"><select class="text-center form-control sel_prod" id="product_' +
				tr_number +
				'" name="product[]' +
				'" onchange="displaySKU(' +
				tr_number +
				')">' +
				'<option value="" selected>- Select Product -</option></td>' +
				'<td><input type="text" class="text-center form-control" id="product_type_' +
				tr_number +
				'" name="product_type[]' +
				'" placeholder="Product Type" readonly></td>' +
				'<td><input type="text" class="text-center form-control" id="sku_' +
				tr_number +
				'" name="sku[]' +
				'" placeholder="HS Code" readonly></td>' +
				'<td><input type="text" class="text-center form-control" id="qty_' +
				tr_number +
				'" name="qty[]' +
				'" placeholder="1" value="1" onkeypress="return isNumber(event)" onkeyup="calcTotalAmount(' +
				tr_number +
				')"></td>' +
				'<td><input type="text" class="text-right form-control" id="price_' +
				tr_number +
				'" name="price[]' +
				'" placeholder="0.00" value="0.00" onkeypress="return validateDec(event)" onkeyup="calcTotalAmount(' +
				tr_number +
				')"></td>' +
				'<td><input type="text" class="text-right form-control" id="total_amount_' +
				tr_number +
				'" name="total_amount[]' +
				'" placeholder="0.00" value="0.00" readonly></td>' +
				'<td><button type="button" id="remove_product_' +
				tr_number +
				'" class="btn btn-block btn-outline-danger" onclick="removeRow(' +
				tr_number +
				')"><i class="fas fa-times-circle"></i></button></td>' +
				"</tr>";
		}
	}
	$("table#product_table_list tbody").append(markup);

	var tr_count_minus = tr_count - 1;
	$("#remove_product_" + tr_count_minus).attr("disabled", "TRUE");
});

//** END ADD PRODUCT SAMPLING */

$("#add_upload_lab_testing").click(function () {
	var data_id = parseInt($(".upload-row").last().data("id")) + 1;
	if (data_id) {
		data_id = data_id;
	} else {
		data_id = 1;
	}
	upload_num_arr.push(data_id);
	console.log(upload_num_arr);
	$("#upload_num_id").val(upload_num_arr.toString());
	$("#upload-lab-test-con").append(
		`<div class="row upload-row" id="con-upload-` +
			data_id +
			`" data-id="` +
			data_id +
			`">
                <div class="col-12">
                    <div class="form-group col-12">
                        <div class="input-group">
                            <div class="custom-file" style="border-radius: .25rem;">
                                <input type="file" class="custom-file-input" id="con_file_` +
			data_id +
			`" name="con_file_` +
			data_id +
			`">
                                <label class="custom-file-label" for="con_file_` +
			data_id +
			`">Upload Product Lab Test Here</label>
                            </div>
                            &nbsp;&nbsp;
                            <button type="button" class="btn btn-outline-danger" onclick="removeUploadCon('` +
			data_id +
			`')"><i class="fas fa-times-circle"></i></button>
                        </div>

                    </div>
                </div>
                
            </div>`
	);
	$("#con_file_" + data_id).on("change", function () {
		//get the file name
		var fileName = $(this).val().replace("C:\\fakepath\\", " ");
		//replace the "Choose a file" label
		$(this).next(".custom-file-label").html(fileName);
	});
});

function removeUploadCon(id) {
	$("#con-upload-" + id).remove();
	var removeItem = id;

	upload_num_arr = jQuery.grep(upload_num_arr, function (value) {
		return value != removeItem;
	});
	$("#upload_num_id").val(upload_num_arr.toString());
	console.log(upload_num_arr);
}

//** PRODUCT SAMPLING EDIT */
$("#add_product_sampling_edit").click(function () {
	var tr_count = $("#product_table_list > tbody > tr").length;
	var tr_number = tr_count;
	var fba = $(this).attr("data-fba");
	var category_0 = $("#category_0").val();
	$.getJSON(
		base_url + "japan_ior/registered_products_sampling",
		{ category: category_0 },
		function (data) {
			$.each(data, function (index, element) {
				$("#product_" + tr_number).append(
					'<option value="' +
						element.id +
						'">' +
						element.product_name +
						"</option>"
				);
			});
		}
	);

	var product_tbl_count = $("#product_tbl_count").val();
	add_product_tbl_count = +product_tbl_count + 1;
	$("#product_tbl_count").val(add_product_tbl_count);
	if (fba == 2) {
		if ($("#user_role_id").val() != 3) {
			var markup =
				'<tr id="product_table_' +
				tr_number +
				'">' +
				'<input type="hidden" id="new_shipping_invoice_' +
				tr_number +
				'" name="new_shipping_invoice[]" value="1">' +
				'<td><input type="hidden" class="prod_selected" id="cur_sel_' +
				tr_number +
				'"><select class="form-control" id="product_' +
				tr_number +
				'" name="product[]' +
				'" onchange="displaySKU(' +
				tr_number +
				')">' +
				'<option value="" selected>- Select Product -</option></td>' +
				'<td><input type="text" class="text-center form-control" id="sku_' +
				tr_number +
				'" name="sku[]' +
				'" placeholder="HS Code" readonly></td>' +
				'<td><input type="text" class="text-center form-control" id="qty_' +
				tr_number +
				'" name="qty[]' +
				'" placeholder="1" value="1" onkeypress="return isNumber(event)" onkeyup="calcTotalAmount(' +
				tr_number +
				')"></td>' +
				'<td><input type="text" class="text-right form-control" id="price_' +
				tr_number +
				'" name="price[]' +
				'" placeholder="0.00" value="0.00" onkeypress="return validateDec(event)" onkeyup="calcTotalAmount(' +
				tr_number +
				')"></td>' +
				'<td><input type="text" class="text-right form-control" id="total_amount_' +
				tr_number +
				'" name="total_amount[]' +
				'" placeholder="0.00" value="0.00" readonly></td>' +
				'<td><button type="button" id="remove_product_' +
				tr_number +
				'" class="btn btn-block btn-outline-danger" onclick="removeRowEdit(' +
				tr_number +
				')"><i class="fas fa-times-circle"></i></button></td>' +
				"</tr>";
		} else {
			var markup =
				'<tr id="product_table_' +
				tr_number +
				'">' +
				'<input type="hidden" id="new_shipping_invoice_' +
				tr_number +
				'" name="new_shipping_invoice[]" value="1">' +
				'<td><input type="hidden" class="prod_selected" id="cur_sel_' +
				tr_number +
				'"><select class="form-control" id="product_' +
				tr_number +
				'" name="product[]' +
				'" onchange="displaySKU(' +
				tr_number +
				')">' +
				'<option value="" selected>- Select Product -</option></td>' +
				'<td><input type="text" class="text-center form-control" id="product_type_' +
				tr_number +
				'" name="product_type[]' +
				'" placeholder="Product Type" readonly></td>' +
				'<td><input type="text" class="text-center form-control" id="sku_' +
				tr_number +
				'" name="sku[]' +
				'" placeholder="HS Code" readonly></td>' +
				'<td><input type="text" class="text-center form-control" id="qty_' +
				tr_number +
				'" name="qty[]' +
				'" placeholder="1" value="1" onkeypress="return isNumber(event)" onkeyup="calcTotalAmount(' +
				tr_number +
				')"></td>' +
				'<td><input type="text" class="text-right form-control" id="price_' +
				tr_number +
				'" name="price[]' +
				'" placeholder="0.00" value="0.00" onkeypress="return validateDec(event)" onkeyup="calcTotalAmount(' +
				tr_number +
				')"></td>' +
				'<td><input type="text" class="text-right form-control" id="total_amount_' +
				tr_number +
				'" name="total_amount[]' +
				'" placeholder="0.00" value="0.00" readonly></td>' +
				'<td><button type="button" id="remove_product_' +
				tr_number +
				'" class="btn btn-block btn-outline-danger" onclick="removeRowEdit(' +
				tr_number +
				')"><i class="fas fa-times-circle"></i></button></td>' +
				"</tr>";
		}
	} else {
		var markup =
			'<tr id="product_table_' +
			tr_number +
			'">' +
			'<input type="hidden" id="new_shipping_invoice_' +
			tr_number +
			'" name="new_shipping_invoice[]" value="1">' +
			'<td><input type="hidden" class="prod_selected" id="cur_sel_' +
			tr_number +
			'"><select class="form-control" id="product_' +
			tr_number +
			'" name="product[]' +
			'" onchange="displaySKU(' +
			tr_number +
			')">' +
			'<option value="" selected>- Select Product -</option></td>' +
			'<td><input type="text" class="text-center form-control" id="product_type_' +
			tr_number +
			'" name="product_type[]' +
			'" placeholder="Product Type" readonly></td>' +
			'<td><input type="text" class="text-center form-control" id="sku_' +
			tr_number +
			'" name="sku[]' +
			'" placeholder="HS Code" readonly></td>' +
			'<td><input type="text" class="text-center form-control" id="qty_' +
			tr_number +
			'" name="qty[]' +
			'" placeholder="1" value="1" onkeypress="return isNumber(event)" onkeyup="calcTotalAmount(' +
			tr_number +
			')"></td>' +
			'<td><input type="text" class="text-right form-control" id="price_' +
			tr_number +
			'" name="price[]' +
			'" placeholder="0.00" value="0.00" onkeypress="return validateDec(event)" onkeyup="calcTotalAmount(' +
			tr_number +
			')"></td>' +
			'<td><input type="text" class="text-right form-control" id="total_amount_' +
			tr_number +
			'" name="total_amount[]' +
			'" placeholder="0.00" value="0.00" readonly></td>' +
			'<td><button type="button" id="remove_product_' +
			tr_number +
			'" class="btn btn-block btn-outline-danger" onclick="removeRowEdit(' +
			tr_number +
			')"><i class="fas fa-times-circle"></i></button></td>' +
			"</tr>";
	}

	$("table#product_table_list tbody").append(markup);

	var tr_count_minus = tr_count - 1;
	$("#remove_product_" + tr_count_minus).attr("disabled", "TRUE");
});
//** END PRODUCT SAMPLING EDIT */

$("#add_product_edit").click(function () {
	var tr_count = $("#product_table_list > tbody > tr").length;
	var tr_number = tr_count;
	var fba = $(this).attr("data-fba");
	var category_0 = $("#category_0").val();
	$.getJSON(
		base_url + "japan_ior/registered_products",
		{ category: category_0 },
		function (data) {
			$.each(data, function (index, element) {
				$("#product_" + tr_number).append(
					'<option value="' +
						element.id +
						'">' +
						element.product_name +
						"</option>"
				);
			});
		}
	);

	var product_tbl_count = $("#product_tbl_count").val();
	add_product_tbl_count = +product_tbl_count + 1;
	$("#product_tbl_count").val(add_product_tbl_count);
	if (fba == 2) {
		if ($("#user_role_id").val() != 3) {
			var markup =
				'<tr id="product_table_' +
				tr_number +
				'">' +
				'<input type="hidden" id="new_shipping_invoice_' +
				tr_number +
				'" name="new_shipping_invoice[]" value="1">' +
				'<td><input type="hidden" class="prod_selected" id="cur_sel_' +
				tr_number +
				'"><select class="form-control" id="product_' +
				tr_number +
				'" name="product[]' +
				'" onchange="displaySKU(' +
				tr_number +
				')">' +
				'<option value="" selected>- Select Product -</option></td>' +
				'<td><input type="text" class="text-center form-control" id="sku_' +
				tr_number +
				'" name="sku[]' +
				'" placeholder="HS Code" readonly></td>' +
				'<td><input type="text" class="text-center form-control" id="qty_' +
				tr_number +
				'" name="qty[]' +
				'" placeholder="1" value="1" onkeypress="return isNumber(event)" onkeyup="calcTotalAmount(' +
				tr_number +
				')"></td>' +
				'<td><input type="text" class="text-right form-control" id="price_' +
				tr_number +
				'" name="price[]' +
				'" placeholder="0.00" value="0.00" onkeypress="return validateDec(event)" onkeyup="calcTotalAmount(' +
				tr_number +
				')"></td>' +
				'<td><input type="text" class="text-right form-control" id="total_amount_' +
				tr_number +
				'" name="total_amount[]' +
				'" placeholder="0.00" value="0.00" readonly></td>' +
				'<td><button type="button" id="add_product_details_' +
				tr_number +
				'" class="btn btn-outline-dark-blue " onclick="addProductDetails(' +
				tr_number +
				')"><i class="fas fa-plus-circle"></i> Add</button></td>' +
				'<td><button type="button" id="remove_product_' +
				tr_number +
				'" class="btn btn-block btn-outline-danger" onclick="removeRowEdit(' +
				tr_number +
				')"><i class="fas fa-times-circle"></i></button></td>' +
				"</tr>";
		} else {
			var markup =
				'<tr id="product_table_' +
				tr_number +
				'">' +
				'<input type="hidden" id="new_shipping_invoice_' +
				tr_number +
				'" name="new_shipping_invoice[]" value="1">' +
				'<td><input type="hidden" class="prod_selected" id="cur_sel_' +
				tr_number +
				'"><select class="form-control" id="product_' +
				tr_number +
				'" name="product[]' +
				'" onchange="displaySKU(' +
				tr_number +
				')">' +
				'<option value="" selected>- Select Product -</option></td>' +
				'<td><input type="text" class="text-center form-control" id="product_type_' +
				tr_number +
				'" name="product_type[]' +
				'" placeholder="Product Type" readonly></td>' +
				'<td><input type="text" class="text-center form-control" id="sku_' +
				tr_number +
				'" name="sku[]' +
				'" placeholder="HS Code" readonly></td>' +
				'<td><input type="text" class="text-center form-control" id="qty_' +
				tr_number +
				'" name="qty[]' +
				'" placeholder="1" value="1" onkeypress="return isNumber(event)" onkeyup="calcTotalAmount(' +
				tr_number +
				')"></td>' +
				'<td><input type="text" class="text-right form-control" id="price_' +
				tr_number +
				'" name="price[]' +
				'" placeholder="0.00" value="0.00" onkeypress="return validateDec(event)" onkeyup="calcTotalAmount(' +
				tr_number +
				')"></td>' +
				'<td><input type="text" class="text-right form-control" id="total_amount_' +
				tr_number +
				'" name="total_amount[]' +
				'" placeholder="0.00" value="0.00" readonly></td>' +
				'<td><button type="button" id="add_product_details_' +
				tr_number +
				'" class="btn btn-outline-dark-blue " onclick="addProductDetails(' +
				tr_number +
				')"><i class="fas fa-plus-circle"></i> Add</button></td>' +
				'<td><button type="button" id="remove_product_' +
				tr_number +
				'" class="btn btn-block btn-outline-danger" onclick="removeRowEdit(' +
				tr_number +
				')"><i class="fas fa-times-circle"></i></button></td>' +
				"</tr>";
		}
	} else {
		var markup =
			'<tr id="product_table_' +
			tr_number +
			'">' +
			'<input type="hidden" id="new_shipping_invoice_' +
			tr_number +
			'" name="new_shipping_invoice[]" value="1">' +
			'<td><input type="hidden" class="prod_selected" id="cur_sel_' +
			tr_number +
			'"><select class="form-control" id="product_' +
			tr_number +
			'" name="product[]' +
			'" onchange="displaySKU(' +
			tr_number +
			')">' +
			'<option value="" selected>- Select Product -</option></td>' +
			'<td><input type="text" class="text-center form-control" id="sku_' +
			tr_number +
			'" name="sku[]' +
			'" placeholder="HS Code" readonly></td>' +
			'<td><input type="text" class="text-center form-control" id="asin_' +
			tr_number +
			'" name="asin[]' +
			'" placeholder="ASIN"></td>' +
			'<td><input type="text" class="text-center form-control" id="qty_' +
			tr_number +
			'" name="qty[]' +
			'" placeholder="1" value="1" onkeypress="return isNumber(event)" onkeyup="calcTotalAmount(' +
			tr_number +
			')"></td>' +
			'<td><input type="text" class="text-right form-control" id="price_' +
			tr_number +
			'" name="price[]' +
			'" placeholder="0.00" value="0.00" onkeypress="return validateDec(event)" onkeyup="calcTotalAmount(' +
			tr_number +
			')"></td>' +
			'<td><input type="text" class="text-right form-control" id="unit_value_' +
			tr_number +
			'" name="unit_value[]' +
			'" placeholder="0.00" value="0.00" readonly></td>' +
			'<td><input type="text" class="text-right form-control" id="fba_listing_fee_' +
			tr_number +
			'" name="fba_listing_fee[]' +
			'" placeholder="0.00" value="0.00" onkeypress="return validateDec(event)" onkeyup="calcTotalAmount(' +
			tr_number +
			')"></td>' +
			'<td><input type="text" class="text-right form-control" id="fba_shipping_fee_' +
			tr_number +
			'" name="fba_shipping_fee[]' +
			'" placeholder="0.00" value="0.00" onkeypress="return validateDec(event)" onkeyup="calcTotalAmount(' +
			tr_number +
			')"></td>' +
			'<td><input type="text" class="text-right form-control" id="total_amount_' +
			tr_number +
			'" name="total_amount[]' +
			'" placeholder="0.00" value="0.00" readonly></td>' +
			'<td><input type="text" class="text-right form-control" id="unit_value_total_amount_' +
			tr_number +
			'" name="unit_value_total_amount[]' +
			'" placeholder="0.00" value="0.00" readonly></td>' +
			'<td><button type="button" id="add_product_details_' +
			tr_number +
			'" class="btn btn-outline-dark-blue " onclick="addProductDetails(' +
			tr_number +
			')"><i class="fas fa-plus-circle"></i> Add</button></td>' +
			'<td><button type="button" id="remove_product_' +
			tr_number +
			'" class="btn btn-block btn-outline-danger" onclick="removeRowEdit(' +
			tr_number +
			')"><i class="fas fa-times-circle"></i></button></td>' +
			"</tr>";
	}
	$("table#product_table_list tbody").append(markup);

	var tr_count_minus = tr_count - 1;
	$("#remove_product_" + tr_count_minus).attr("disabled", "TRUE");
});

function removeRow(id) {
	var row_id = $("#product_table_" + id);
	row_id.remove();

	var tr_count = $("#product_table_list > tbody > tr").length;

	if (tr_count == "1") {
		var remaining_row_id = $("#product_table_list > tbody")
			.find("tr:first")
			.attr("id");
		var row_id = remaining_row_id.slice(-1);
		$("#remove_product_" + row_id).attr("disabled", "TRUE");
	} else {
		var tr_count_minus = tr_count - 1;
		$("#remove_product_" + tr_count_minus).removeAttr("disabled");
	}

	calcOverallTotalAmount();
}

function removeRowEdit(id) {
	var active_row_id = $("#shipping_invoice_active_" + id);
	var row_id = $("#product_table_" + id);

	active_row_id.val(0);
	row_id.remove();

	var tr_count = $("#product_table_list > tbody > tr").length;

	if (tr_count == "1") {
		var remaining_row_id = $("#product_table_list > tbody")
			.find("tr:first")
			.attr("id");
		var row_id = remaining_row_id.slice(-1);
		$("#remove_product_" + row_id).attr("disabled", "TRUE");
	} else {
		var tr_count_minus = tr_count - 1;
		$("#remove_product_" + tr_count_minus).removeAttr("disabled");
	}

	calcOverallTotalAmount();
}

//** FOR PRODUCT SAMPLING */

$("#product_sampling_0").change(function () {
	var id = $(this).val();
	var cat = $("#category_name").val();
	$.ajax({
		url: base_url + "japan_ior/fetch_product_data",
		type: "POST",
		data: { id: id },
		success: function (response) {
			var json = $.parseJSON(response);
			if (json.category_name == cat) {
				if (
					json.category_name == "Food Import - Food Apparatus" ||
					json.category_name == "Food Import - Health Food Supplements" ||
					json.category_name == "Food Import - Shelf Stable Food" ||
					json.category_name == "Toys under 6 years old" ||
					json.category_name == "CBD"
				) {
					$("#product_table_list tr:gt(1)").remove();
				}
			} else {
				$("#product_table_list tr:gt(1)").remove();
			}
		},
	});
});

$("#product_sampling_0").change(function (e) {
	var id = $(this).val();
	shipping_prod_arr = $(".prod_selected")
		.map((_, el) => el.value)
		.get();
	shipping_prod_arr = shipping_prod_arr.filter(function (el) {
		return el != "";
	});
	if (shipping_prod_arr.includes(id)) {
		alert("You already selected this product.");
		// $(this).val($('#cur_sel_0').val());
		console.log($(this).val($("#cur_sel_0").val()));
		// alert($('#cur_sel_0').val());
		$("#cur_sel_0").val($("#cur_sel_0").val());
		return;
	}

	if (id != "") {
		$.ajax({
			url: base_url + "japan_ior/fetch_product_data",
			type: "POST",
			data: { id: id },
			success: function (response) {
				// if(!shipping_prod_arr.includes(id)){
				// 	shipping_prod_arr.push(id);
				// 	$('#cur_sel_0').val(id)
				// }else{
				// 	alert('Invalid selection');
				// 	$(this).val(id);
				// 	return;
				// }
				// $('.opt_sel_'+id).hide();
				// $('.opt_sel_'+$('#cur_sel_0').val()).show();

				$("#cur_sel_0").val(id);
				var json = $.parseJSON(response);
				var p_type = "Non-Commercial";
				$("#sku_0").val(json.sku);
				if (json.product_type == 1) {
					p_type = "Commercial";
				}
				$("#product_type_0").val(p_type);
				$("#category_0").val(json.category_id);
				$("#category_name").val(json.category_name);
				if (
					json.category_id == "1" ||
					json.category_id == "11" ||
					json.category_id == "8"
				) {
					// ** SHOW ADD PRODUCT BUTTON **/
					$("#add_product_sampling").show();

					//** SET PRODUCT CATEGORY AS 0 */
					$("#product_category").val(json.category_id);
					$("#category_type").val(json.category_id);

					// ** SAVE INPUT **//
					var drn1 = $("#destination_recipient_name").val();
					var dcn1 = $("#destination_company_name").val();
					var da1 = $("#destination_address").val();
					var dpn1 = $("#destination_phone_no").val();
					var coo1 = $("#country_of_origin").val();

					var drn = $("#destination_recipient_name_v").val();
					var dcn = $("#destination_company_name_v").val();
					var da = $("#destination_address_v").val();
					var dpn = $("#destination_phone_no_v").val();
					var coo = $("#country_of_origin_v").val();

					if (drn != "" || dcn != "" || da != "" || dpn != "" || coo != "") {
						var drn = $("#destination_recipient_name_v").val();
						var dcn = $("#destination_company_name_v").val();
						var da = $("#destination_address_v").val();
						var dpn = $("#destination_phone_no_v").val();
						var coo = $("#country_of_origin_v").val();

						// ** INPUT COVUE DETAILS **//
						$("#destination_recipient_name").val(drn);
						$("#destination_company_name").val(dcn);
						$("#destination_address").val(da);
						$("#destination_phone_no").val(dpn);
						$("#country_of_origin").val(coo).trigger("change");
					} else {
						if (
							drn1 == "COVUE JAPAN K.K" ||
							dcn1 == "Logiport Amagasaki 403" ||
							da == "20 Ougimachi​ Amagasaki, Hyogo, 660-0096, Japan​"
						) {
							$("#destination_recipient_name").val("");
							$("#destination_company_name").val("");
							$("#destination_address").val("");
							$("#destination_phone_no").val("");
						}
					}

					//** CALL MODAL */
					var mymodal = $("#non-regulated-modal");
					mymodal
						.find("#selected-category")
						.html(
							"You have selected a product that is under <strong>" +
								capitalizeFirstLetter(json.category_name) +
								"</strong> category."
						);

					mymodal.modal("show");
				} else if (
					json.category_id == "4" ||
					json.category_id == "3" ||
					json.category_id == "12" ||
					json.category_id == "13" ||
					json.category_id == "9"
				) {
					// ** SHOW ADD PRODUCT BUTTON **/
					$("#add_product_sampling").show();

					//** SET PRODUCT CATEGORY */
					$("#product_category").val(json.category_id);
					$("#category_type").val(json.category_id);

					// ** SAVE INPUT **//
					var drn1 = $("#destination_recipient_name").val();
					var dcn1 = $("#destination_company_name").val();
					var da1 = $("#destination_address").val();
					var dpn1 = $("#destination_phone_no").val();
					var coo1 = $("#country_of_origin").val();

					var drn = $("#destination_recipient_name_v").val();
					var dcn = $("#destination_company_name_v").val();
					var da = $("#destination_address_v").val();
					var dpn = $("#destination_phone_no_v").val();
					var coo = $("#country_of_origin_v").val();

					if (drn != "" || dcn != "" || da != "" || dpn != "" || coo != "") {
						var drn = $("#destination_recipient_name_v").val();
						var dcn = $("#destination_company_name_v").val();
						var da = $("#destination_address_v").val();
						var dpn = $("#destination_phone_no_v").val();
						var coo = $("#country_of_origin_v").val();
					} else {
						var drn = $("#destination_recipient_name_v").val(drn1);
						var dcn = $("#destination_company_name_v").val(dcn1);
						var da = $("#destination_address_v").val(da1);
						var dpn = $("#destination_phone_no_v").val(dpn1);
						var coo = $("#country_of_origin_v").val(coo1);
					}

					// ** INPUT COVUE DETAILS **//
					$("#destination_recipient_name").val("COVUE JAPAN K.K");
					$("#destination_company_name").val("Logiport Amagasaki 403");
					$("#destination_address").val(
						"20 Ougimachi​ Amagasaki, Hyogo, 660-0096, Japan​"
					);
					$("#destination_phone_no").val("+81 (0)50 8881 2699");
					//$("#country_of_origin").val(107).trigger("change");

					//** MAKE READONLY */
					$("#destination_recipient_name").attr("readonly", "readonly");
					$("#destination_company_name").attr("readonly", "readonly");
					$("#destination_address").attr("readonly", "readonly");
					$("#destination_phone_no").attr("readonly", "readonly");
					//$("#country_of_origin").prop("disabled", true);

					//** CALL MODAL */
					var mymodal = $("#non-cosmetics-modal");
					mymodal
						.find("#selected-category")
						.html(
							"You have selected a product that is under <strong>" +
								capitalizeFirstLetter(json.category_name) +
								"</strong> category."
						);
					mymodal.modal("show");
				} else if (
					json.category_id == "5" ||
					json.category_id == "6" ||
					json.category_id == "7" ||
					json.category_id == "10" ||
					json.category_id == "2"
				) {
					// ** HIDE ADD PRODUCT BUTTON **/
					$("#add_product_sampling").hide();

					//** SET PRODUCT CATEGORY AS 1 */
					$("#product_category").val(json.category_id);
					$("#category_type").val(json.category_id);


					var fba = $("#fba").val();

					var markup = "";

					// ** SAVE INPUT **//
					var drn1 = $("#destination_recipient_name").val();
					var dcn1 = $("#destination_company_name").val();
					var da1 = $("#destination_address").val();
					var dpn1 = $("#destination_phone_no").val();
					var coo1 = $("#country_of_origin").val();

					var drn = $("#destination_recipient_name_v").val();
					var dcn = $("#destination_company_name_v").val();
					var da = $("#destination_address_v").val();
					var dpn = $("#destination_phone_no_v").val();
					var coo = $("#country_of_origin_v").val();

					if (drn != "" || dcn != "" || da != "" || dpn != "" || coo != "") {
						var drn = $("#destination_recipient_name_v").val();
						var dcn = $("#destination_company_name_v").val();
						var da = $("#destination_address_v").val();
						var dpn = $("#destination_phone_no_v").val();
						var coo = $("#country_of_origin_v").val();

						// ** INPUT COVUE DETAILS **//
						$("#destination_recipient_name").val(drn);
						$("#destination_company_name").val(dcn);
						$("#destination_address").val(da);
						$("#destination_phone_no").val(dpn);
						$("#country_of_origin").val(coo).trigger("change");
					} else {
						if (
							drn1 == "COVUE JAPAN K.K" ||
							dcn1 == "Logiport Amagasaki 403" ||
							da == "20 Ougimachi​ Amagasaki, Hyogo, 660-0096, Japan​"
						) {
							$("#destination_recipient_name").val("");
							$("#destination_company_name").val("");
							$("#destination_address").val("");
							$("#destination_phone_no").val("");
						}
					}

					$.ajax({
						url: base_url + "japan_ior/fetch_all_regulated_category_data",
						type: "POST",
						data: {
							category: json.category_id,
							regulated_application: json.regulated_application_id,
							id: id,
						},
						success: function (data) {
							var t = JSON.parse(data);
							var length = t.length + 1;
							var n = 1;
							$.each(t, function (index, item) {
								var tr_number = n++;
								$tbody = $("table#product_table_list tbody");
								$row = $tbody.find("tr:last");
								if (fba == 2) {
									var markup =
										'<tr id="product_table_' +
										tr_number +
										'">' +
										'<input type="hidden" id="new_shipping_invoice_' +
										tr_number +
										'" name="new_shipping_invoice[]" value="1">' +
										"<td >" +
										'<input type="hidden" class="form-control" id="product_' +
										tr_number +
										'" value = "' +
										item["prod_reg_id"] +
										' " name="product[]"><input class="form-control" id="product_' +
										tr_number +
										'" value = "' +
										item["product_name"] +
										' " style="width:300px;" readonly>' +
										"</td>" +
										'<td><input type="text" class="text-center form-control" id="sku_' +
										tr_number +
										'" name="sku[]' +
										'" value = "' +
										item["sku"] +
										' "' +
										'" placeholder="HS Code" readonly></td>' +
										'<td><input type="text" class="text-center form-control" id="qty_' +
										tr_number +
										'" name="qty[]' +
										'" placeholder="1" value="1" onkeypress="return isNumber(event)" onkeyup="calcTotalAmount(' +
										tr_number +
										')"></td>' +
										'<td><input type="text" class="text-right form-control" id="price_' +
										tr_number +
										'" name="price[]' +
										'" placeholder="0.00" value="0.00" onkeypress="return validateDec(event)" onkeyup="calcTotalAmount(' +
										tr_number +
										')"></td>' +
										'<td><input type="text" class="text-right form-control" id="total_amount_' +
										tr_number +
										'" name="total_amount[]' +
										'" placeholder="0.00" value="0.00" readonly></td>' +
										'<td><button type="button" id="remove_product_' +
										tr_number +
										'" class="btn btn-block btn-outline-danger" onclick="removeRowEdit(' +
										tr_number +
										')"><i class="fas fa-times-circle"></i></button></td>' +
										"</tr>";
								} else {
									var markup =
										'<tr id="product_table_' +
										tr_number +
										'">' +
										'<input type="hidden" id="new_shipping_invoice_' +
										tr_number +
										'" name="new_shipping_invoice[]" value="1">' +
										"<td>" +
										'<input type="hidden" class="form-control" id="product_' +
										tr_number +
										'" value = "' +
										item["prod_reg_id"] +
										' " name="product[]"><input class="form-control" id="product_' +
										tr_number +
										'" value = "' +
										item["product_name"] +
										' " style="width:100%;" readonly>' +
										"</td>" +
										'<td><input type="text" class="text-center form-control" id="sku_' +
										tr_number +
										'" name="sku[]' +
										'" value = "' +
										item["sku"] +
										' "' +
										'" placeholder="HS Code" readonly></td>' +
										'<td><input type="text" class="text-center form-control" id="asin_' +
										tr_number +
										'" name="asin[]' +
										'" placeholder="ASIN"></td>' +
										'<td><input type="text" class="text-center form-control" id="qty_' +
										tr_number +
										'" name="qty[]' +
										'" placeholder="1" value="1" onkeypress="return isNumber(event)" onkeyup="calcTotalAmount(' +
										tr_number +
										')"></td>' +
										'<td><input type="text" class="text-right form-control" id="price_' +
										tr_number +
										'" name="price[]' +
										'" placeholder="0.00" value="0.00" onkeypress="return validateDec(event)" onkeyup="calcTotalAmount(' +
										tr_number +
										')"></td>' +
										'<td><input type="text" class="text-right form-control" id="unit_value_' +
										tr_number +
										'" name="unit_value[]' +
										'" placeholder="0.00" value="0.00" readonly></td>' +
										'<td><input type="text" class="text-right form-control" id="fba_listing_fee_' +
										tr_number +
										'" name="fba_listing_fee[]' +
										'" placeholder="0.00" value="0.00" onkeypress="return validateDec(event)" onkeyup="calcTotalAmount(' +
										tr_number +
										')"></td>' +
										'<td><input type="text" class="text-right form-control" id="fba_shipping_fee_' +
										tr_number +
										'" name="fba_shipping_fee[]' +
										'" placeholder="0.00" value="0.00" onkeypress="return validateDec(event)" onkeyup="calcTotalAmount(' +
										tr_number +
										')"></td>' +
										'<td><input type="text" class="text-right form-control" id="total_amount_' +
										tr_number +
										'" name="total_amount[]' +
										'" placeholder="0.00" value="0.00" readonly></td>' +
										'<td><input type="text" class="text-right form-control" id="unit_value_total_amount_' +
										tr_number +
										'" name="unit_value_total_amount[]' +
										'" placeholder="0.00" value="0.00" readonly></td>' +
										'<td><button type="button" id="remove_product_' +
										tr_number +
										'" class="btn btn-block btn-outline-danger" onclick="removeRowEdit(' +
										tr_number +
										')"><i class="fas fa-times-circle"></i></button></td>' +
										"</tr>";
								}

								$tbody.append(markup);
							});
						},
					});

					//** CALL MODAL */
					var mymodal = $("#non-food-modal");
					mymodal
						.find("#selected-category")
						.html(
							"You have selected a product that is under <strong>" +
								capitalizeFirstLetter(json.category_name) +
								"</strong> category."
						);

					mymodal.modal("show");
				}
			},
			error: function () {
				$("#cur_sel_0").val("");
				Toast.fire({
					icon: "error",
					position: "center",
					title: "Please select a product!",
				});
			},
		});
	} else {
		alert($("#cur_sel_0").val());
		$("#sku_0").val("");
		$("#product_type_0").val("");
		// $('.opt_sel_'+$('#cur_sel_0').val()).show();
		$("#cur_sel_0").val("");
		Toast.fire({
			icon: "error",
			position: "center",
			title: "Please select a product!",
		});
	}
});
// ** END PRODUCT SAMPLING */

$("#product_0").change(function () {
	var id = $(this).val();
	var cat = $("#category_name").val();
	$.ajax({
		url: base_url + "japan_ior/fetch_product_data",
		type: "POST",
		data: { id: id },
		success: function (response) {
			var json = $.parseJSON(response);
			if ($("#user_role_id").val() != 3) {
				if (json.category_name == cat) {
					if (
						json.category_name == "Food Import - Food Apparatus" ||
						json.category_name == "Food Import - Health Food Supplements" ||
						json.category_name == "Food Import - Shelf Stable Food" ||
						json.category_name == "Toys under 6 years old" ||
						json.category_name == "CBD"
					) {
						$("#product_table_list tr:gt(1)").remove();
					}
				} else {
					$("#product_table_list tr:gt(1)").remove();
				}
			}
		},
	});
});

$("#product_0").change(function (e) {
	var id = $(this).val();

	$(".prod_selected").val();
	$('#add_product_details_0').prop("disabled", false); 
	$("#prod_log_id").val(id);

	shipping_prod_arr = $(".prod_selected")
		.map((_, el) => el.value)
		.get();
	shipping_prod_arr = shipping_prod_arr.filter(function (el) {
		return el != "";
	});
	if (shipping_prod_arr.includes(id)) {
		Toast.fire({
			icon: "error",
			position: "center",
			title: "You already selected this product.",
		});
		// $(this).val($('#cur_sel_0').val());
		// console.log($(this).val($("#cur_sel_0").val()));
		// alert($('#cur_sel_0').val());
		$("#cur_sel_0").val($("#cur_sel_0").val());
		return;
	}

	if (id != "") {
		$.ajax({
			url: base_url + "japan_ior/fetch_product_data",
			type: "POST",
			data: { id: id },
			success: function (response) {
				// if(!shipping_prod_arr.includes(id)){
				// 	shipping_prod_arr.push(id);
				// 	$('#cur_sel_0').val(id)
				// }else{
				// 	alert('Invalid selection');
				// 	$(this).val(id);
				// 	return;
				// }
				// $('.opt_sel_'+id).hide();
				// $('.opt_sel_'+$('#cur_sel_0').val()).show();

				$("#cur_sel_0").val(id);
				var json = $.parseJSON(response);
				var p_type = "Non-Commercial";
				$("#sku_0").val(json.sku);
				if (json.product_type == 1) {
					p_type = "Commercial";
				}
				$("#product_type_0").val(p_type);
				$("#category_0").val(json.category_id);
				$("#category_name").val(json.category_name);
				if (
					json.category_id == "1"  ||
					json.category_id == "11" ||
					json.category_id == "8"  ||
					json.category_id == "9"
				) {
					// ** SHOW ADD PRODUCT BUTTON **/

					$("#add_product").show();

					var disbaled = "";

					//** SET PRODUCT CATEGORY AS 0 */
					$("#product_category").val(json.category_id);
					$("#category_type").val(json.category_id);


					// ** SAVE INPUT **//
					var drn1 = $("#destination_recipient_name").val();
					var dcn1 = $("#destination_company_name").val();
					var da1 = $("#destination_address").val();
					var dpn1 = $("#destination_phone_no").val();
					var coo1 = $("#country_of_origin").val();

					var drn = $("#destination_recipient_name_v").val();
					var dcn = $("#destination_company_name_v").val();
					var da = $("#destination_address_v").val();
					var dpn = $("#destination_phone_no_v").val();
					var coo = $("#country_of_origin_v").val();

					if (drn != "" || dcn != "" || da != "" || dpn != "" || coo != "") {
						var drn = $("#destination_recipient_name_v").val();
						var dcn = $("#destination_company_name_v").val();
						var da = $("#destination_address_v").val();
						var dpn = $("#destination_phone_no_v").val();
						var coo = $("#country_of_origin_v").val();

						// ** INPUT COVUE DETAILS **//
						$("#destination_recipient_name").val(drn);
						$("#destination_company_name").val(dcn);
						$("#destination_address").val(da);
						$("#destination_phone_no").val(dpn);
						$("#country_of_origin").val(coo).trigger("change");
					} else {
						if (
							drn1 == "COVUE JAPAN K.K" ||
							dcn1 == "Logiport Amagasaki 403" ||
							da == "20 Ougimachi​ Amagasaki, Hyogo, 660-0096, Japan​"
						) {
							$("#destination_recipient_name").val("");
							$("#destination_company_name").val("");
							$("#destination_address").val("");
							$("#destination_phone_no").val("");
						}
					}

					//** MAKE READONLY */
					$("#destination_recipient_name").removeAttr("readonly");
					$("#destination_company_name").removeAttr("readonly");
					$("#destination_address").removeAttr("readonly");
					$("#destination_phone_no").removeAttr("readonly");
					$("#country_of_origin").prop("disabled", false);

					//** CALL MODAL */
					var mymodal = $("#non-regulated-modal");
					mymodal
						.find("#selected-category")
						.html(
							"You have selected a product that is under <strong>" +
								capitalizeFirstLetter(json.category_name) +
								"</strong> category."
						);

					mymodal.modal("show");
				} else if (
					json.category_id == "4" ||
					json.category_id == "3" ||
					json.category_id == "12" ||
					json.category_id == "13" 
				) {
					// ** SHOW ADD PRODUCT BUTTON **/
					$("#add_product").show();

					var disbaled = "";

					//** SET PRODUCT CATEGORY */
					$("#product_category").val(json.category_id);
					$("#category_type").val(json.category_id);


					// ** SAVE INPUT **//
					var drn1 = $("#destination_recipient_name").val();
					var dcn1 = $("#destination_company_name").val();
					var da1 = $("#destination_address").val();
					var dpn1 = $("#destination_phone_no").val();
					var coo1 = $("#country_of_origin").val();

					var drn = $("#destination_recipient_name_v").val();
					var dcn = $("#destination_company_name_v").val();
					var da = $("#destination_address_v").val();
					var dpn = $("#destination_phone_no_v").val();
					var coo = $("#country_of_origin_v").val();

					if (drn != "" || dcn != "" || da != "" || dpn != "" || coo != "") {
						var drn = $("#destination_recipient_name_v").val();
						var dcn = $("#destination_company_name_v").val();
						var da = $("#destination_address_v").val();
						var dpn = $("#destination_phone_no_v").val();
						var coo = $("#country_of_origin_v").val();
					} else {
						var drn = $("#destination_recipient_name_v").val(drn1);
						var dcn = $("#destination_company_name_v").val(dcn1);
						var da = $("#destination_address_v").val(da1);
						var dpn = $("#destination_phone_no_v").val(dpn1);
						var coo = $("#country_of_origin_v").val(coo1);
					}

					// ** INPUT COVUE DETAILS **//
					$("#destination_recipient_name").val("COVUE JAPAN K.K");
					$("#destination_company_name").val("Logiport Amagasaki 403");
					$("#destination_address").val(
						"20 Ougimachi​ Amagasaki, Hyogo, 660-0096, Japan​"
					);
					$("#destination_phone_no").val("+81 (0)50 8881 2699");
					//$("#country_of_origin").val(107).trigger("change");

					//** MAKE READONLY */
					$("#destination_recipient_name").attr("readonly", "readonly");
					$("#destination_company_name").attr("readonly", "readonly");
					$("#destination_address").attr("readonly", "readonly");
					$("#destination_phone_no").attr("readonly", "readonly");
					//$("#country_of_origin").prop("disabled", true);

					//** CALL MODAL */
					var mymodal = $("#non-cosmetics-modal");
					mymodal
						.find("#selected-category")
						.html(
							"You have selected a product that is under <strong>" +
								capitalizeFirstLetter(json.category_name) +
								"</strong> category."
						);
					mymodal.modal("show");
				} else if (
					json.category_id == "5" ||
					json.category_id == "6" ||
					json.category_id == "7" ||
					json.category_id == "10" ||
					json.category_id == "2"
				) {
					// ** HIDE ADD PRODUCT BUTTON **/
					$("#add_product").hide();

					var disbaled = "disabled";
					
					//** SET PRODUCT CATEGORY AS 1 */
					$("#product_category").val(json.category_id);
					$("#category_type").val(json.category_id);


					var fba = $("#fba").val();

					var markup = "";

					// ** SAVE INPUT **//
					var drn1 = $("#destination_recipient_name").val();
					var dcn1 = $("#destination_company_name").val();
					var da1 = $("#destination_address").val();
					var dpn1 = $("#destination_phone_no").val();
					var coo1 = $("#country_of_origin").val();

					var drn = $("#destination_recipient_name_v").val();
					var dcn = $("#destination_company_name_v").val();
					var da = $("#destination_address_v").val();
					var dpn = $("#destination_phone_no_v").val();
					var coo = $("#country_of_origin_v").val();

					if (drn != "" || dcn != "" || da != "" || dpn != "" || coo != "") {
						var drn = $("#destination_recipient_name_v").val();
						var dcn = $("#destination_company_name_v").val();
						var da = $("#destination_address_v").val();
						var dpn = $("#destination_phone_no_v").val();
						var coo = $("#country_of_origin_v").val();

						// ** INPUT COVUE DETAILS **//
						$("#destination_recipient_name").val(drn);
						$("#destination_company_name").val(dcn);
						$("#destination_address").val(da);
						$("#destination_phone_no").val(dpn);
						$("#country_of_origin").val(coo).trigger("change");
					} else {
						if (
							drn1 == "COVUE JAPAN K.K" ||
							dcn1 == "Logiport Amagasaki 403" ||
							da == "20 Ougimachi​ Amagasaki, Hyogo, 660-0096, Japan​"
						) {
							$("#destination_recipient_name").val("");
							$("#destination_company_name").val("");
							$("#destination_address").val("");
							$("#destination_phone_no").val("");
						}
					}

					//** MAKE READONLY */
					$("#destination_recipient_name").removeAttr("readonly");
					$("#destination_company_name").removeAttr("readonly");
					$("#destination_address").removeAttr("readonly");
					$("#destination_phone_no").removeAttr("readonly");
					$("#country_of_origin").prop("disabled", false);

					$.ajax({
						url: base_url + "japan_ior/fetch_all_regulated_category_data",
						type: "POST",
						data: {
							category: json.category_id,
							regulated_application: json.regulated_application_id,
							id: id,
						},
						success: function (data) {
							var t = JSON.parse(data);
							var length = t.length + 1;
							var n = 1;
							$.each(t, function (index, item) {
								var tr_number = n++;
								$tbody = $("table#product_table_list tbody");
								$row = $tbody.find("tr:last");
								if (fba == 2) {
									var markup =
										'<tr id="product_table_' +
										tr_number +
										'">' +
										'<input type="hidden" id="new_shipping_invoice_' +
										tr_number +
										'" name="new_shipping_invoice[]" value="1">' +
										"<td >" +
										'<input type="hidden" class="prod_selected" id="cur_sel_' +
										tr_number +
										'" value = "' +
										item["prod_reg_id"] +
										' " >' +
										'<input type="hidden" class="form-control" id="product_' +
										tr_number +
										'" value = "' +
										item["prod_reg_id"] +
										' " name="product[]"><input class="form-control" style="text-align:center;;width:100%;" id="product_' +
										tr_number +
										'" value = "' +
										item["product_name"] +
										' " style="width:300px;" readonly>' +
										"</td>" +
										'<td><input type="text" class="text-center form-control" id="sku_' +
										tr_number +
										'" name="sku[]' +
										'" value = "' +
										item["sku"] +
										' "' +
										'" placeholder="HS Code" readonly></td>' +
										'<td><input type="text" class="text-center form-control" id="qty_' +
										tr_number +
										'" name="qty[]' +
										'" placeholder="1" value="1" onkeypress="return isNumber(event)" onkeyup="calcTotalAmount(' +
										tr_number +
										')"></td>' +
										'<td><input type="text" class="text-right form-control" id="price_' +
										tr_number +
										'" name="price[]' +
										'" placeholder="0.00" value="0.00" onkeypress="return validateDec(event)" onkeyup="calcTotalAmount(' +
										tr_number +
										')"></td>' +
										'<td><input type="text" class="text-right form-control" id="total_amount_' +
										tr_number +
										'" name="total_amount[]' +
										'" placeholder="0.00" value="0.00" readonly></td>' +
										'<td><button type="button" id="add_product_details_' +
										tr_number +
										'" class="btn btn-outline-dark-blue " onclick="addProductDetails(' +
										tr_number +
										')"><i class="fas fa-plus-circle"></i> Add</button></td>' +
										'<td><button type="button" id="remove_product_' +
										tr_number +
										'" class="btn btn-block btn-outline-danger" onclick="removeRowEdit(' +
										tr_number +
										')" '+disbaled+'><i class="fas fa-times-circle"></i></button></td>' +
										"</tr>";
								} else {
									var markup =
										'<tr id="product_table_' +
										tr_number +
										'">' +
										'<input type="hidden" id="new_shipping_invoice_' +
										tr_number +
										'" name="new_shipping_invoice[]" value="1">' +
										"<td>"  +
										'<input type="hidden" class="prod_selected" id="cur_sel_' +
										tr_number +
										'" value = "' +
										item["prod_reg_id"] +
										' " >' +
										'<input type="hidden" class="form-control" id="product_' +
										tr_number +
										'" value = "' +
										item["prod_reg_id"] +
										' " name="product[]"><input class="form-control" style="text-align:center;width:100%;" id="product_' +
										tr_number +
										'" value = "' +
										item["product_name"] +
										' " style="width:100%;" readonly>' +
										"</td>" +
										'<td><input type="text" class="text-center form-control" id="sku_' +
										tr_number +
										'" name="sku[]' +
										'" value = "' +
										item["sku"] +
										' "' +
										'" placeholder="HS Code" readonly></td>' +
										'<td><input type="text" class="text-center form-control" id="asin_' +
										tr_number +
										'" name="asin[]' +
										'" placeholder="ASIN"></td>' +
										'<td><input type="text" class="text-center form-control" id="qty_' +
										tr_number +
										'" name="qty[]' +
										'" placeholder="1" value="1" onkeypress="return isNumber(event)" onkeyup="calcTotalAmount(' +
										tr_number +
										')"></td>' +
										'<td><input type="text" class="text-right form-control" id="price_' +
										tr_number +
										'" name="price[]' +
										'" placeholder="0.00" value="0.00" onkeypress="return validateDec(event)" onkeyup="calcTotalAmount(' +
										tr_number +
										')"></td>' +
										'<td><input type="text" class="text-right form-control" id="unit_value_' +
										tr_number +
										'" name="unit_value[]' +
										'" placeholder="0.00" value="0.00" readonly></td>' +
										'<td><input type="text" class="text-right form-control" id="fba_listing_fee_' +
										tr_number +
										'" name="fba_listing_fee[]' +
										'" placeholder="0.00" value="0.00" onkeypress="return validateDec(event)" onkeyup="calcTotalAmount(' +
										tr_number +
										')"></td>' +
										'<td><input type="text" class="text-right form-control" id="fba_shipping_fee_' +
										tr_number +
										'" name="fba_shipping_fee[]' +
										'" placeholder="0.00" value="0.00" onkeypress="return validateDec(event)" onkeyup="calcTotalAmount(' +
										tr_number +
										')"></td>' +
										'<td><input type="text" class="text-right form-control" id="total_amount_' +
										tr_number +
										'" name="total_amount[]' +
										'" placeholder="0.00" value="0.00" readonly></td>' +
										'<td><input type="text" class="text-right form-control" id="unit_value_total_amount_' +
										tr_number +
										'" name="unit_value_total_amount[]' +
										'" placeholder="0.00" value="0.00" readonly></td>' +
										'<td><button type="button" id="add_product_details_' +
										tr_number +
										'" class="btn btn-outline-dark-blue " onclick="addProductDetails(' +
										tr_number +
										')"><i class="fas fa-plus-circle"></i> Add</button></td>' +
										'<td><button type="button" id="remove_product_' +
										tr_number +
										'" class="btn btn-block btn-outline-danger" onclick="removeRowEdit(' +
										tr_number +
										')" '+disbaled+'><i class="fas fa-times-circle"></i></button></td>' +
										"</tr>";
								}

								$tbody.append(markup);
							});
						},
					});

					//** CALL MODAL */
					var mymodal = $("#non-food-modal");
					mymodal
						.find("#selected-category")
						.html(
							"You have selected a product that is under <strong>" +
								capitalizeFirstLetter(json.category_name) +
								"</strong> category."
						);

					mymodal.modal("show");
				}
			},
			error: function () {
				$("#cur_sel_0").val("");
				Toast.fire({
					icon: "error",
					position: "center",
					title: "Please select a product!",
				});
			},
		});
	} else {
		alert($("#cur_sel_0").val());
		$("#sku_0").val("");
		$("#product_type_0").val("");
		// $('.opt_sel_'+$('#cur_sel_0').val()).show();
		$("#cur_sel_0").val("");
		Toast.fire({
			icon: "error",
			position: "center",
			title: "Please select a product!",
		});
	}
});

function calcOverallTotalAmount() {
	var unit_value_total_amount = $("input[name='unit_value_total_amount[]']");
	var unit_value_total_amount = unit_value_total_amount
		.map(function () {
			var total_amount_input = $(this).val().replace(/\,/g, "");
			return parseFloat(total_amount_input).toFixed(2);
		})
		.get();

	var total_unit_value = unit_value_total_amount.reduce(function (a, b) {
		return +a + +b;
	}, 0);

	$("input[name=total_unit_value]").val(total_unit_value.toFixed(2));
	$("#total_unit_value").text(numberWithCommas(total_unit_value.toFixed(2)));

	var total_amount = $("input[name='total_amount[]']");
	var total_amount_array = total_amount
		.map(function () {
			var total_amount_input = $(this).val().replace(/\,/g, "");
			return parseFloat(total_amount_input).toFixed(2);
		})
		.get();

	var total_value_of_shipment = total_amount_array.reduce(function (a, b) {
		return +a + +b;
	}, 0);

	$("input[name=total_value_of_shipment]").val(
		total_value_of_shipment.toFixed(2)
	);
	$("#total_value_of_shipment").text(
		numberWithCommas(total_value_of_shipment.toFixed(2))
	);

	var fba_fees = +total_value_of_shipment - +total_unit_value;
	$("input[name=fba_fees]").val(fba_fees.toFixed(2));
	$("#fba_fees").text(numberWithCommas(fba_fees.toFixed(2)));
}

function displaySKU(id) {
	var product_id = $("#product_" + id).val();
	shipping_prod_arr = $(".prod_selected")
		.map((_, el) => el.value)
		.get();
	shipping_prod_arr = shipping_prod_arr.filter(function (el) {
		return el != "";
	});
	if (shipping_prod_arr.includes(product_id)) {
		Toast.fire({
			icon: "error",
			position: "center",
			title: "You already selected this product.",
		});
		// $(this).val($('#cur_sel_0').val());
		console.log($("#product_" + id).val($("#cur_sel_" + id).val()));
		// alert($('#cur_sel_'+id).val());
		$("#cur_sel_" + id).val($("#cur_sel_" + id).val());
		return;
	}
	if (product_id === "") {
		$("#sku_" + id).val("");
		$("#product_type_" + id).val("");
		$(".opt_sel_" + $("#cur_sel_" + id).val()).show();
		$("#cur_sel_" + id).val("");
		Toast.fire({
			icon: "error",
			position: "center",
			title: "Please select a product.",
		});
	} else {
		$.ajax({
			url: base_url + "japan_ior/fetch_product_data",
			type: "POST",
			data: { id: product_id },
			success: function (response) {
				var json = $.parseJSON(response);
				// $('.opt_sel_'+product_id).hide();
				// $('.opt_sel_'+$('#cur_sel_'+id).val()).show();
				$("#cur_sel_" + id).val(product_id);
				var p_type = "Non-Commercial";
				$("#sku_" + id).val(json.sku);
				if (json.product_type == 1) {
					p_type = "Commercial";
				}
				$("#product_type_" + id).val(p_type);
			},
			error: function () {
				Toast.fire({
					icon: "error",
					position: "center",
					title:
						"Sorry for the inconvenience, some errors found. Please contact administrator through livechat or email.",
				});
			},
		});
	}
}

function calcTotalAmount(id) {


	var qty = $("#qty_" + id).val();
	var price = $("#price_" + id).val().replace(/\,/g,'');
	var fba_listing_fee = $("#fba_listing_fee_" + id).val();
	var fba_shipping_fee = $("#fba_shipping_fee_" + id).val();

	var unit_value = +price - +fba_listing_fee - +fba_shipping_fee;
	$("#unit_value_" + id).val(unit_value);
	var unit_value_input = $("#unit_value_" + id).val();

	var unit_value_total_amount = +unit_value_input * +qty;
	var unit_value_total_amount_dec = numberWithCommas(
		unit_value_total_amount.toFixed(2)
	);

	var total_price = +price * +qty;
	var total_price_dec = numberWithCommas(total_price.toFixed(2));

	$("#unit_value_total_amount_" + id).val(unit_value_total_amount_dec);
	$("#total_amount_" + id).val(total_price_dec);
	calcOverallTotalAmount();
}

if (current_url.includes("edit-shipping-invoice")) {
	$("#modal_invoice_created").modal("show");
} else {
	$("#modal_invoice_created").modal("hide");
}

$("#btn_generate_preview").click(function () {
	setTimeout(function () {
		location.reload();
	}, 1000);
	$("#frm_update_shipping_invoice").attr("target", "_blank");
});

$("#btn_submit_for_approval").click(function () {
	$("#frm_update_shipping_invoice").removeAttr("target");
});

$("#btn_save_draft").click(function () {
	$("#frm_update_shipping_invoice").removeAttr("target");
});

$("#btn_submit_for_approval").click(function (e) {
	if (
		$("#terms").prop("checked") == false ||
		$("#no_edit_terms").prop("checked") == false
	) {
		e.preventDefault();
		Toast.fire({
			icon: "error",
			position: "center",
			title:
				"Please agree to all the terms and conditions before you submit your IOR Shipping request.",
		});
	}
});

function showConfirmationInvoiceCancel(id) {
	$("#btn_cancel_invoice").html(
		'<button type="button" class="btn btn-dark-blue" onclick="cancelShippingInvoice(\'' +
			id +
			"')\">Yes</button> " +
			'<button type="button" class="btn btn-outline-dark-blue" data-dismiss="modal">No</button>'
	);
	$("#modal_cancel_invoice").modal({
		keyboard: false,
		backdrop: "static",
		show: true,
	});
}

function showConfirmationRemoveFile(id) {
	$("#btn_remove_file").html(
		'<button type="button" class="btn btn-dark-blue" onclick="removeFile(\'' +
			id +
			"')\">Yes</button> " +
			'<button type="button" class="btn btn-outline-dark-blue" data-dismiss="modal">No</button>'
	);
	$("#modal_remove_file").modal({
		keyboard: false,
		backdrop: "static",
		show: true,
	});
}


function showCreateShippingInvoice(user_role) {
	if (user_role == 3) {
		nonFbaInvoice();
	} else {
		$("#btn-fba-invoice").html(
			'<button type="button" class="btn btn-dark-blue" onclick="FbaInvoice()">Yes</button> <button type="button" onclick="nonFbaInvoice()" class="btn btn-outline-dark-blue">No</button>'
		);
		$("#createshippinginvoice").modal({
			keyboard: false,
			backdrop: "static",
			show: true,
		});
	}
}

function FbaInvoice() {
	window.location.href =
		base_url + "japan-ior/add-shipping-invoice/fba-invoice";
}
function nonFbaInvoice() {
	window.location.href =
		base_url + "japan-ior/add-shipping-invoice/non-fba-invoice";
}

function cancelShippingInvoice(id) {
	var spinner = $("#loader");

	$.ajax({
		url: base_url + "japan_ior/cancel_shipping_invoice",
		type: "POST",
		data: { id: id },
		beforeSend: function () {
			spinner.show();
			$("#modal_cancel_invoice").modal("hide");
		},
		complete: function () {
			spinner.hide();
		},
		success: function (response) {
			if (response == 1) {
				Toast.fire({
					icon: "success",
					position: "center",
					title: "Successfully cancelled shipping invoice.",
				});

				location.reload();
			} else {
				Toast.fire({
					icon: "error",
					position: "center",
					title: "Some errors found. Please contact administrator.",
				});
			}
		},
		error: function () {
			Toast.fire({
				icon: "error",
				position: "center",
				title:
					"Sorry for the inconvenience, some errors found. Please contact administrator through livechat or email.",
			});
		},
	});
}

function removeFile(id) {
	var spinner = $("#loader");

	$.ajax({
		url: base_url + "japan_ior/remove_file_upload",
		type: "POST",
		data: { id: id },
		beforeSend: function () {
			spinner.show();
			$("#modal_remove_file").modal("hide");
		},
		complete: function () {
			spinner.hide();
		},
		success: function (response) {
			if (response == 1) {
				Toast.fire({
					icon: "success",
					position: "center",
					title: "Successfully removed file.",
				});

				location.reload();
			} else {
				Toast.fire({
					icon: "error",
					position: "center",
					title: "Some errors found. Please contact administrator.",
				});
			}
		},
		error: function () {
			Toast.fire({
				icon: "error",
				position: "center",
				title:
					"Sorry for the inconvenience, some errors found. Please contact administrator through livechat or email.",
			});
		},
	});
}


function showShippingInvoiceNotice(params) {
	$("#confirmButtonsShippingInvoiceNotice").html(
		'<a href="' +
			base_url +
			"japan-ior/shipping-invoice-fee/" +
			params +
			'" id="btn_pay_now" class="btn btn-dark-blue disabled">Pay Now</a>'
	);
	$("#shippingInvoiceNotice").modal({
		keyboard: false,
		backdrop: "static",
		show: true,
	});
}

$("#shipping_terms").change(function () {
	if ($(this).is(":checked")) {
		$("#btn_pay_now").removeClass("disabled");
	} else {
		$("#btn_pay_now").addClass("disabled");
	}
});

function showConfirmationInvoiceAccepted(id) {
	$("#btn_accept_invoice").html(
		'<button type="button" class="btn btn-success" onclick="acceptShippingInvoice(\'' +
			id +
			"')\">Yes</button> " +
			'<button type="button" class="btn btn-danger" data-dismiss="modal">No</button>'
	);
	$("#modal_accepted_invoice").modal({
		keyboard: false,
		backdrop: "static",
		show: true,
	});
}

function acceptShippingInvoice(id) {
	var spinner = $("#loader");

	$.ajax({
		url: base_url + "shipping_invoices/accept_shipping_invoice",
		type: "POST",
		data: { id: id },
		beforeSend: function () {
			spinner.show();
			$("#modal_accepted_invoice").modal("hide");
		},
		complete: function () {
			spinner.hide();
		},
		success: function (result) {
			if (result == 1) {
				Toast.fire({
					icon: "success",
					position: "center",
					title: "Shipping Invoice is successfully accepted!",
				});

				$("td#status_" + id).html(
					'<span class="badge badge-primary">Accepted</span>'
				);
			}
		},
		error: function () {
			Toast.fire({
				icon: "error",
				position: "center",
				title:
					"Sorry for the inconvenience, some errors found. Please contact administrator through livechat or email.",
			});
		},
	});
}

function showConfirmationInvoicePaid(id) {
	$("#btn_paid_invoice").html(
		'<button type="button" class="btn btn-success" onclick="paidShippingInvoice(\'' +
			id +
			"')\">Yes</button> " +
			'<button type="button" class="btn btn-danger" data-dismiss="modal">No</button>'
	);
	$("#modal_paid_invoice").modal({
		keyboard: false,
		backdrop: "static",
		show: true,
	});
}

function paidShippingInvoice(id) {
	var spinner = $("#loader");

	$.ajax({
		url: base_url + "shipping_invoices/paid_shipping_invoice",
		type: "POST",
		data: { id: id },
		beforeSend: function () {
			spinner.show();
			$("#modal_paid_invoice").modal("hide");
		},
		complete: function () {
			spinner.hide();
		},
		success: function (result) {
			if (result == 1) {
				Toast.fire({
					icon: "success",
					position: "center",
					title: "Shipping Invoice is successfully set to paid!",
				});

				$("td#status_" + id).html(
					'<span class="badge badge-primary">Paid</span>'
				);
			}
		},
		error: function () {
			Toast.fire({
				icon: "error",
				position: "center",
				title:
					"Sorry for the inconvenience, some errors found. Please contact administrator through livechat or email.",
			});
		},
	});
}

function showConfirmationInvoiceCompleted(id) {
	$("#custom_report_id").val(id);

	$("#modal_custom_report").modal({
		keyboard: false,
		backdrop: "static",
		show: true,
	});
}

$("#btn_custom_report").click(function () {
	var fd = new FormData();
	var custom_report_id = $("#custom_report_id").val();
	var files = $("#custom_report")[0].files[0];
	fd.append("custom_report", files);

	// AJAX request
	$.ajax({
		url: base_url + "shipping_invoices/do_upload",
		type: "post",
		data: fd,
		contentType: false,
		processData: false,
		success: function (response) {
			if (response != 0) {
				completedShippingInvoice(response + "|" + custom_report_id);
			} else {
				Toast.fire({
					icon: "error",
					position: "center",
					title: "Custom report is not yet uploaded.",
				});
			}
		},
	});
});

function completedShippingInvoice(params) {
	var spinner = $("#loader");
	var params_split = params.split("|");

	$.ajax({
		url: base_url + "shipping_invoices/completed_shipping_invoice",
		type: "POST",
		data: {
			custom_report_filename: params_split[0],
			custom_report_id: params_split[1],
		},
		beforeSend: function () {
			spinner.show();
		},
		complete: function () {
			spinner.hide();
		},
		success: function (result) {
			if (result == 1) {
				Toast.fire({
					icon: "success",
					position: "center",
					title: "Successfully uploaded custom report! Refreshing page ...",
				});
				window.location.href = base_url + "shipping_invoices";
			}
		},
		error: function (n) {
			Toast.fire({
				icon: "error",
				position: "center",
				title:
					"Sorry for the inconvenience, some errors found. Please contact administrator through livechat or email.",
			});
		},
	});
}

function showConfirmationInvoiceRevision(id) {
	$("#btn_revision_invoice").html(
		'<button type="button" class="btn btn-success" onclick="revisionShippingInvoice(\'' +
			id +
			"')\">Yes</button> " +
			'<button type="button" class="btn btn-danger" data-dismiss="modal">No</button>'
	);

	$("#modal_revision_invoice").modal({
		keyboard: false,
		backdrop: "static",
		show: true,
	});
}

function revisionShippingInvoice(id) {
	var spinner = $("#loader");
	var message = $("#revision_messsage").val();

	$.ajax({
		url: base_url + "shipping_invoices/revision_shipping_invoice",
		type: "POST",
		data: { id: id, message: message },
		beforeSend: function () {
			spinner.show();
			$("#modal_revision_invoice").modal("hide");
		},
		complete: function () {
			spinner.hide();
		},
		success: function (result) {
			if (result == 1) {
				Toast.fire({
					icon: "success",
					position: "center",
					title: "Successfully sent revisions message!",
				});

				$("td#status_" + id).html(
					'<span class="badge badge-warning">Needs Revision</span>'
				);
			}
		},
		error: function () {
			Toast.fire({
				icon: "error",
				position: "center",
				title:
					"Sorry for the inconvenience, some errors found. Please contact administrator through livechat or email.",
			});
		},
	});
}

function showConfirmationInvoiceArrived(id) {
	$("#btn_arrived_invoice").html(
		'<button type="button" class="btn btn-success" onclick="arrivedShippingInvoice(\'' +
			id +
			"')\">Yes</button> " +
			'<button type="button" class="btn btn-danger" data-dismiss="modal">No</button>'
	);
	$("#modal_arrived_invoice").modal({
		keyboard: false,
		backdrop: "static",
		show: true,
	});
}

function arrivedShippingInvoice(id) {
	var spinner = $("#loader");

	$.ajax({
		url: base_url + "shipping_invoices/arrived_shipping_invoice",
		type: "POST",
		data: { id: id },
		beforeSend: function () {
			spinner.show();
			$("#modal_arrived_invoice").modal("hide");
		},
		complete: function () {
			spinner.hide();
		},
		success: function (result) {
			if (result == 1) {
				Toast.fire({
					icon: "success",
					position: "center",
					title:
						"Shipping Invoice is successfully set to Shipment Arrived at COVUE Facility!",
				});

				$("td#status_" + id).html(
					'<span class="badge badge-info">Shipment Arrived at COVUE Facility</span>'
				);
			}
		},
		error: function () {
			Toast.fire({
				icon: "error",
				position: "center",
				title:
					"Sorry for the inconvenience, some errors found. Please contact administrator through livechat or email.",
			});
		},
	});
}

function showConfirmationInvoiceReady(id) {
	$("#btn_ready_invoice").html(
		'<button type="button" class="btn btn-success" onclick="readyShippingInvoice(\'' +
			id +
			"')\">Yes</button> " +
			'<button type="button" class="btn btn-danger" data-dismiss="modal">No</button>'
	);
	$("#modal_ready_invoice").modal({
		keyboard: false,
		backdrop: "static",
		show: true,
	});
}

function readyShippingInvoice(id) {
	var spinner = $("#loader");

	$.ajax({
		url: base_url + "shipping_invoices/ready_shipping_invoice",
		type: "POST",
		data: { id: id },
		beforeSend: function () {
			spinner.show();
			$("#modal_ready_invoice").modal("hide");
		},
		complete: function () {
			spinner.hide();
		},
		success: function (result) {
			if (result == 1) {
				Toast.fire({
					icon: "success",
					position: "center",
					title:
						"Shipping Invoice is successfully set to Shipment Ready for Pickup!",
				});

				$("td#status_" + id).html(
					'<span class="badge badge-info">Shipment Ready for Pickup</span>'
				);
			}
		},
		error: function () {
			Toast.fire({
				icon: "error",
				position: "center",
				title:
					"Sorry for the inconvenience, some errors found. Please contact administrator through livechat or email.",
			});
		},
	});
}

function generateApprovedInvoice(id, fba, shipping_link) {
	$("#btn_generate_invoice").html(
		'<a href="' +
			base_url +
			"japan_ior/generate_shipping_invoice/" +
			id +
			"/" +
			fba +
			"/" +
			shipping_link +
			'" class="btn btn-dark-blue" target="_blank">Generate</a>'
	);
	$("#modal_generate_approved_invoicce").modal({
		keyboard: false,
		backdrop: "static",
		show: true,
	});
}

$("#btn_generate_invoice").click(function () {
	setTimeout(function () {
		location.reload();
	}, 1000);

	$("#modal_generate_approved_invoicce").modal("hide");
});

$("#btn_product_registration").click(function () {
	$("#modal_product_registration").modal("hide");
	$("form#frmProdQ").submit();
});

function showConfirmationDeleteShippingCompany(id) {
	$("#confirmButtons").html(
		'<button type="button" class="btn btn-success" onclick="deleteShippingCompany(\'' +
			id +
			"')\">Yes</button> " +
			'<button type="button" class="btn btn-danger" data-dismiss="modal">No</button>'
	);
	$("#modal_delete_shipping_company").modal({
		keyboard: false,
		backdrop: "static",
		show: true,
	});
}

function deleteShippingCompany(id) {
	var spinner = $("#loader");

	$.ajax({
		url: base_url + "shipping_companies/delete_shipping_company",
		type: "POST",
		data: { id: id },
		beforeSend: function () {
			spinner.show();
			$("#modal_delete_shipping_company").modal("hide");
		},
		complete: function () {
			spinner.hide();
		},
		success: function (result) {
			if (result == 1) {
				Toast.fire({
					icon: "success",
					position: "center",
					title: "Successfully deleted shipping company.",
				});
			}

			$("tr#" + id).remove();
		},
		error: function () {
			Toast.fire({
				icon: "error",
				position: "center",
				title:
					"Sorry for the inconvenience, some errors found. Please contact administrator.",
			});
		},
	});
}

function showConfirmationDeleteRegulatedProduct(
	id,
	product_details,
	user_type
) {
	$("#confirmButtons").html(
		'<button type="button" class="btn btn-success" onclick="deleteRegulatedProduct(\'' +
			id +
			"','" +
			user_type +
			"')\">Yes</button> " +
			'<button type="button" class="btn btn-danger" data-dismiss="modal">No</button>'
	);
	$("#modal_delete_regulated_product").modal({
		keyboard: false,
		backdrop: "static",
		show: true,
	});
	$("#product_details").text(product_details);
}

function showConfirmationDeleteDetail(
	id,
	detail,
) {
	$("#confirmDeleteDetails").html(
		'<button type="button" class="btn btn-success" onclick="removeDetail(\'' +
			id +
			"')\">Yes</button> " +
			'<button type="button" class="btn btn-danger" data-dismiss="modal">No</button>'
	);
	$("#modal_delete_detail").modal({
		keyboard: false,
		backdrop: "static",
		show: true,
	});
	$("#detail_name").text(detail);
}

function removeDetail(id){
        $.ajax({
            url: base_url + "regulated_applications/remove_details",
            type: "POST",
            data: { id: id },
            success: function (response) {
                window.location.reload();
            },
            error: function () {
                Toast.fire({
                    icon: "error",
                    position: "center",
                    title:
                        "Sorry for the inconvenience, some errors found. Please contact administrator.",
                });
            },
        });
    }

function deleteRegulatedProduct(id, user_type, loop = 0) {
	alert("" + id);
	var spinner = $("#loader");
	var url = "";
	if (user_type == "client") {
		url = base_url + "japan_ior/delete_regulated_product";
	} else {
		url = base_url + "regulated_applications/delete_regulated_product";
	}
	$.ajax({
		url: url,
		type: "POST",
		data: { id: id },
		beforeSend: function () {
			spinner.show();
			$("#modal_delete_regulated_product").modal("hide");
		},
		complete: function () {
			spinner.hide();
		},
		success: function (result) {
			if (result == 1) {
				if (loop == 0) {
					Toast.fire({
						icon: "success",
						position: "center",
						title: "Successfully deleted regulated product.",
					});
					setTimeout(function () {
						location.reload();
					}, 3000);
				}
			}

			$("tr#" + id).remove();
		},
		error: function () {
			Toast.fire({
				icon: "error",
				position: "center",
				title:
					"Sorry for the inconvenience, some errors found. Please contact administrator.",
			});
		},
	});
}

$("#ior_reg_checkout").click(function (e) {
	if ($("#ior_reg_terms").prop("checked") == false) {
		e.preventDefault();
		Toast.fire({
			icon: "error",
			position: "center",
			title: "Please accept our Terms and Conditions to continue payment.",
		});
	}
});

$("#ior_fee_checkout").click(function (e) {
	if ($("#ior_fee_terms").prop("checked") == false) {
		e.preventDefault();
		Toast.fire({
			icon: "error",
			position: "center",
			title: "Please accept our Terms and Conditions to continue payment.",
		});
	}
});

$("#btn_product_label_checkout").click(function (e) {
	if ($("#product_label_fee_terms").prop("checked") == false) {
		e.preventDefault();
		Toast.fire({
			icon: "error",
			position: "center",
			title: "Please accept our Terms and Conditions to continue payment.",
		});
	}
});

$("#btn_create_product_label").click(function (e) {
	if ($("#create_product_label_terms").prop("checked") == false) {
		e.preventDefault();
		Toast.fire({
			icon: "error",
			position: "center",
			title: "Please accept our Terms and Conditions to submit.",
		});
	}
});

$("#btn_update_product_label").click(function (e) {
	if ($("#update_product_label_terms").prop("checked") == false) {
		e.preventDefault();
		Toast.fire({
			icon: "error",
			position: "center",
			title: "Please accept our Terms and Conditions to update.",
		});
	}
});

function showUploadProductLabel(params) {
	var params_split = params.split("|");
	$("#product_label_id").val(params_split[0]);
	$("#product_registration_id").val(params_split[1]);

	$("#modal_upload_product_label").modal({
		keyboard: false,
		backdrop: "static",
		show: true,
	});
}

$("#btn_upload_product_label").click(function () {
	var fd = new FormData();
	var product_label_id = $("#product_label_id").val();
	var product_registration_id = $("#product_registration_id").val();
	var files = $("#product_label")[0].files[0];

	fd.append("product_label_id", product_label_id);
	fd.append("product_registration_id", product_registration_id);
	fd.append("product_label", files);

	$.ajax({
		url: base_url + "product_registrations/do_upload_product_label",
		type: "POST",
		data: fd,
		contentType: false,
		processData: false,
		success: function (response) {
			if (response != 0) {
				uploadProductLabel(
					response + "|" + product_label_id + "|" + product_registration_id
				);
			} else {
				Toast.fire({
					icon: "error",
					position: "center",
					title:
						"Sorry for the inconvenience, there was an error uploading the file. Please try again later.",
				});
			}
		},
	});
});

function uploadProductLabel(params) {
	var spinner = $("#loader");
	var params_split = params.split("|");

	$.ajax({
		url: base_url + "product_registrations/upload_product_label",
		type: "POST",
		data: {
			product_label: params_split[0],
			product_label_id: params_split[1],
			product_registration_id: params_split[2],
		},
		beforeSend: function () {
			spinner.show();
			$("#modal_upload_product_label").modal("hide");
		},
		complete: function () {
			spinner.hide();
		},
		success: function (result) {
			if (result == 0) {
				Toast.fire({
					icon: "error",
					position: "center",
					title:
						"Sorry for the inconvenience, some errors found. Please contact administrator.",
				});
			} else {
				Toast.fire({
					icon: "success",
					position: "center",
					title: "Congratulations! Label is now uploaded. Refreshing page ...",
				});

				setTimeout(function () {
					window.location.href =
						base_url + "product_registrations/product_labels";
				}, 3000);
			}
		},
		error: function () {
			Toast.fire({
				icon: "error",
				position: "center",
				title:
					"Sorry for the inconvenience, some errors found. Please contact administrator.",
			});
		},
	});
}

var maxAmount = 200;

function textCounter(textField, showCountField) {
	if (textField.value.length > maxAmount) {
		textField.value = textField.value.substring(0, maxAmount);
	} else {
		showCountField.value = maxAmount - textField.value.length;
	}
}

function showConfirmPaidPLI(params) {
	$("#btn_pli").html(
		'<button type="button" class="btn btn-success" onclick="paidPLI(\'' +
			params +
			"')\">Yes</button> " +
			'<button type="button" class="btn btn-danger" data-dismiss="modal">No</button>'
	);
	$("#modal_paid_pli").modal({
		keyboard: false,
		backdrop: "static",
		show: true,
	});
}

function paidPLI(params) {
	var spinner = $("#loader");

	$.ajax({
		url: base_url + "users/paid_pli",
		type: "POST",
		data: { id: params },
		beforeSend: function () {
			spinner.show();
			$("#modal_paid_pli").modal("hide");
		},
		complete: function () {
			spinner.hide();
		},
		success: function (result) {
			if (result == 1) {
				window.location.href = base_url + "users/listing";
			}
		},
		error: function () {
			Toast.fire({
				icon: "error",
				position: "center",
				title:
					"Sorry for the inconvenience, some errors found. Please contact administrator.",
			});
		},
	});
}

function showConfirmPaidProductLabel(params) {
	$("#btn_product_label").html(
		'<button type="button" class="btn btn-success" onclick="paidProductLabel(\'' +
			params +
			"')\">Yes</button> " +
			'<button type="button" class="btn btn-danger" data-dismiss="modal">No</button>'
	);
	$("#modal_paid_product_label").modal({
		keyboard: false,
		backdrop: "static",
		show: true,
	});
}

function paidProductLabel(params) {
	var spinner = $("#loader");

	$.ajax({
		url: base_url + "users/paid_product_label",
		type: "POST",
		data: { id: params },
		beforeSend: function () {
			spinner.show();
			$("#modal_paid_product_label").modal("hide");
		},
		complete: function () {
			spinner.hide();
		},
		success: function (result) {
			if (result == 1) {
				window.location.href = base_url + "users/listing";
			}
		},
		error: function () {
			Toast.fire({
				icon: "error",
				position: "center",
				title:
					"Sorry for the inconvenience, some errors found. Please contact administrator.",
			});
		},
	});
}

function showConfirmDeleteUser(params) {
	$("#btn_delete_user").html(
		'<button type="button" class="btn btn-success" onclick="deleteUser(\'' +
			params +
			"')\">Yes</button> " +
			'<button type="button" class="btn btn-danger" data-dismiss="modal">No</button>'
	);
	$("#modal_delete_user").modal({
		keyboard: false,
		backdrop: "static",
		show: true,
	});
}

function showConfirmDeleteConsultant(params) {
	$("#btn_delete_consultant").html(
		'<button type="button" class="btn btn-success" onclick="deleteConsultant(\'' +
			params +
			"')\">Yes</button> " +
			'<button type="button" class="btn btn-danger" data-dismiss="modal">No</button>'
	);
	$("#modal_delete_consultant").modal({
		keyboard: false,
		backdrop: "static",
		show: true,
	});
}

function deleteUser(params) {
	var spinner = $("#loader");

	$.ajax({
		url: base_url + "users/delete_user",
		type: "POST",
		data: { id: params },
		beforeSend: function () {
			spinner.show();
			$("#modal_delete_user").modal("hide");
		},
		complete: function () {
			spinner.hide();
		},
		success: function (result) {
			if (result == 1) {
				Toast.fire({
					icon: "success",
					position: "center",
					title: "Successfully deleted user, refreshing page ...",
				});

				window.location.href = base_url + "users/listing";
			}
		},
		error: function () {
			Toast.fire({
				icon: "error",
				position: "center",
				title:
					"Sorry for the inconvenience, some errors found. Please contact administrator.",
			});
		},
	});
}

function deleteConsultant(params) {
	var spinner = $("#loader");

	$.ajax({
		url: base_url + "users/delete_user",
		type: "POST",
		data: { id: params },
		beforeSend: function () {
			spinner.show();
			$("#modal_delete_consultant").modal("hide");
		},
		complete: function () {
			spinner.hide();
		},
		success: function (result) {
			if (result == 1) {
				Toast.fire({
					icon: "success",
					position: "center",
					title: "Successfully deleted user, refreshing page ...",
				});

				window.location.href = base_url + "users/consultant_listing";
			}
		},
		error: function () {
			Toast.fire({
				icon: "error",
				position: "center",
				title:
					"Sorry for the inconvenience, some errors found. Please contact administrator.",
			});
		},
	});
}

function showConfirmProductLabelApprove(params) {
	$("#btn_product_label_approve").html(
		'<button type="button" class="btn btn-success" onclick="productLabelApprove(\'' +
			params +
			"')\">Yes</button> " +
			'<button type="button" class="btn btn-danger" data-dismiss="modal">No</button>'
	);
	$("#modal_product_label_approve").modal({
		keyboard: false,
		backdrop: "static",
		show: true,
	});
}

function productLabelApprove(params) {
	var spinner = $("#loader");

	$.ajax({
		url: base_url + "product_registrations/product_label_approve",
		type: "POST",
		data: { id: params },
		beforeSend: function () {
			spinner.show();
			$("#modal_product_label_approve").modal("hide");
		},
		complete: function () {
			spinner.hide();
		},
		success: function (response) {
			if (response == 1) {
				Toast.fire({
					icon: "success",
					position: "center",
					title:
						"Congratulations! successfully approved the Product Label! Refreshing page ...",
				});

				setTimeout(function () {
					window.location.href =
						base_url + "product_registrations/product_labels";
				}, 3000);
			}
		},
		error: function () {
			Toast.fire({
				icon: "error",
				position: "center",
				title:
					"Sorry for the inconvenience, some errors found. Please contact administrator.",
			});
		},
	});
}

function showConfirmSetProductLabelOnProcess(params) {
	$("#btn_product_label_on_process").html(
		'<button type="button" class="btn btn-dark-blue" onclick="productLabelOnProcess(\'' +
			params +
			"')\">Yes</button> " +
			'<button type="button" class="btn btn-outline-dark-blue" data-dismiss="modal">No</button>'
	);
	$("#modal_product_label_on_process").modal({
		keyboard: false,
		backdrop: "static",
		show: true,
	});
}

function productLabelOnProcess(params) {
	var spinner = $("#loader");

	$.ajax({
		url: base_url + "product_registrations/product_label_on_process",
		type: "POST",
		data: { id: params },
		beforeSend: function () {
			spinner.show();
			$("#modal_product_label_on_process").modal("hide");
		},
		complete: function () {
			spinner.hide();
		},
		success: function (result) {
			if (result == 1) {
				Toast.fire({
					icon: "success",
					position: "center",
					title: "Product Label is now on accepted.",
				});

				window.location.href =
					base_url + "product_registrations/product_labels";
			}
		},
		error: function () {
			Toast.fire({
				icon: "error",
				position: "center",
				title:
					"Sorry for the inconvenience, some errors found. Please contact administrator.",
			});
		},
	});
}

function showConfirmProductLabelRevision(id) {
	$("#btn_product_label_revision").html(
		'<button type="button" class="btn btn-success" onclick="productLabelRevision(\'' +
			id +
			"')\">Yes</button> " +
			'<button type="button" class="btn btn-danger" data-dismiss="modal">No</button>'
	);

	$("#modal_product_label_revision").modal({
		keyboard: false,
		backdrop: "static",
		show: true,
	});
}

function productLabelRevision(id) {
	var spinner = $("#loader");
	var message = $("#revisions_msg").val();

	$.ajax({
		url: base_url + "product_registrations/product_label_revision",
		type: "POST",
		data: { id: id, message: message },
		beforeSend: function () {
			spinner.show();
			$("#modal_product_label_revision").modal("hide");
		},
		complete: function () {
			spinner.hide();
		},
		success: function (response) {
			if (response == 1) {
				Toast.fire({
					icon: "success",
					position: "center",
					title: "Successfully sent revisions message!",
				});

				setTimeout(function () {
					window.location.href =
						base_url + "product_registrations/product_labels";
				}, 3000);
			}
		},
		error: function () {
			Toast.fire({
				icon: "error",
				position: "center",
				title:
					"Sorry for the inconvenience, some errors found. Please contact administrator.",
			});
		},
	});
}

$("#product_services").change(function () {
	var spinner = $("#loader");
	var id = $("#product_services").val();

	$.ajax({
		url: base_url + "japan_ior/fetch_product_offer_by_service_id",
		type: "POST",
		data: { id: id },
		beforeSend: function () {
			spinner.show();
		},
		complete: function () {
			spinner.hide();
		},
		success: function (response) {
			if (id == 3) {
				$("#products_offer option").remove();
				$("#products_offer").append('<option value="">Coming Soon*</option>');
				$("#paypalCheckoutIORregistered").hide();
				$("#paypalCheckoutIOR").hide();
				$("#proc_ecom_btn").hide();
				$("#products_offer_con").show();
				$("#paypalCheckoutIORregistered").show();
			} else if (id == 2) {
				$("#proc_ecom_btn").show();
				$("#products_offer_con").hide();
				$("#paypalCheckoutIORregistered").hide();
			} else {
				$("#proc_ecom_btn").hide();
				$("#products_offer_con").show();
				$("#paypalCheckoutIORregistered").show();
				$("#products_offer option").remove();
				$("#products_offer").append(response);

				if ($("#ior_registered").val() == 1 && $("#pli").val() == 1) {
					$("#non_reg_notes").show();
					$("#paypalCheckoutIORregistered").show();
					$("#paypalCheckoutIOR").hide();
				} else {
					$("#non_reg_notes").hide();
					$("#paypalCheckoutIORregistered").hide();
					$("#paypalCheckoutIOR").show();
				}

				$("#regulated_name").html("");
				$("#regulated_price").html("");

				if ($("#ior_registered").val() != 1 && $("#pli").val() != 1) {
					var ior_pli_total = +$("#ior_reg_fee").val() + +$("#pli_fee").val();
				} else if ($("#ior_registered").val() == 1 && $("#pli").val() != 1) {
					var ior_pli_total = $("#pli_fee").val();
				} else {
					var ior_pli_total = 0;
				}

				$("#subtotal_val").val(parseFloat(ior_pli_total).toFixed(2));
				$("#subtotal").html(
					"$" + numberWithCommas(parseFloat(ior_pli_total).toFixed(2))
				);

				var jct = ior_pli_total * 0.1;
				$("#jct_val").val(parseFloat(jct).toFixed(2));
				$("#jct").html("$" + numberWithCommas(parseFloat(jct).toFixed(2)));

				var total = +ior_pli_total + +jct;
				$("#total_val").val(parseFloat(total).toFixed(2));
				$("#total").html("$" + numberWithCommas(parseFloat(total).toFixed(2)));
			}
		},
		error: function () {
			Toast.fire({
				icon: "error",
				position: "center",
				title:
					"Sorry for the inconvenience, some errors found. Please contact administrator.",
			});
		},
	});
});

$("#products_offer").change(function () {
	var spinner = $("#loader");
	var products_offer = $("#products_offer").val().split("|");
	var product_offer_id = products_offer[1];

	switch (product_offer_id) {
		case "3": // CBD
			$("#product_title_info").html("CBD Regulated Application Services");
			$("#product_info").html(
				'CBD (Cannabidiol)  Import Applications are approved by the Japan Ministry of Health Labor and Welfare (MHLW). Every shipment requires an application and pre-approval from MHLW prior to shipping.<br><br>MHLW is the sole determining agency for CBD (Cannabidiol) Import Applications. Each application is reviewed and approved by the agency.<br><br>MHLW requires only one manufacturer per import application. All products listed on the application must be shipped. To know more, <a href="https://www.covue.com/wp-content/uploads/2021/06/COVUE-IOR-for-CBD-Pricing-and-Information.pdf" class="dark-blue-link" target="_blank"><strong>Click Here!</strong></a>'
			);
			break;
		case "4": // Class One Medical Devices
			$("#product_title_info").html(
				"Class 1 Medical Device Regulated Application Services"
			);
			$("#product_info").html(
				'Class 1 Medical Device Import Applications are approved by the Japan Ministry of Health Labor and Welfare (MHLW), PMDA division (Pharmaceuticals & Medical Devices Agency).<br><br>PMDA requires only one manufacturer per import application. There is no limitation to the number of products that can be added to the application. Each application is reviewed and approved by the agency. Once approved, the products may be shipped under the IOR’s license as a general approval. No additional applications are required.<br><br>PMDA requires only one manufacturer per import application. To know more about importing Medical Devices in Japan, <a href="https://www.covue.com/wp-content/uploads/2021/06/COVUE-IOR-for-Class-1-and-2-Medical-Device-Pricing-and-Information.pdf" class="dark-blue-link" target="_blank"><strong>Click Here!</strong></a>'
			);
			break;
		case "5": // Cosmetics and Personal Care
			$("#product_title_info").html(
				"Cosmetics and Personal Care Regulated Application Services"
			);
			$("#product_info").html(
				'Cosmetics & Personal Care Import Applications are approved by the Japan Ministry of Health Labor and Welfare (MHLW), PMDA division (Pharmaceuticals & Medical Devices Agency).<br><br>PMDA requires only one manufacturer per import application. There is no limitation to the number of products that can be added to the application. Each application is reviewed and approved by the agency. Once approved, the products may be shipped under the IOR’s license as a general approval. No additional applications are required.<br><br>PMDA requires only one manufacturer per import application. To know more about importing Cosmetics and Personal Care products in Japan, <a href="https://www.covue.com/wp-content/uploads/2021/06/IOR-for-Cosmetics-and-personal-care-Pricing-and-Information.pdf" class="dark-blue-link" target="_blank"><strong>Click Here!</strong></a>'
			);
			break;
		case "6": // Food Apparatus
			$("#product_title_info").html(
				"Food Apparatus Regulated Application Services"
			);
			$("#product_info").html(
				'Food apparatuses are products that come in contact with food or liquids that are intended for human consumption or, products that come into contact with the human mouth.<br><br>Food Apparatus Import Applications are approved by the Japan Ministry of Health Labor and Welfare (MHLW). Every shipment requires an application and pre-approval from MHLW prior to shipping<br><br>MHLW is the sole determining agency for  Food Apparatus Import Applications. Each application is reviewed and approved by the agency.<br><br>MHLW requires only one manufacturer per import application. All products listed on the application must be shipped. To know more about importing Food Apparatuses in Japan, <a href="https://www.covue.com/wp-content/uploads/2021/06/COVUE-Food-Apparatus-Pricing-and-Information-1.pdf" class="dark-blue-link" target="_blank"><strong>Click Here!</strong></a>'
			);
			break;
		case "7": // Health Food Supplements
			$("#product_title_info").html(
				"Health Food Supplements Regulated Application Services"
			);
			$("#product_info").html(
				'Health Food Supplement Import Applications are approved by the Japan Ministry of Health Labor and Welfare (MHLW). Every shipment requires an application and pre-approval from MHLW prior to shipping.<br><br>MHLW is the sole determining agency for Health Food Supplement Import Applications. Each application is reviewed and approved by the agency.<br><br>MHLW requires only one manufacturer per import application. All products listed on the application must be shipped. To know more, <a href="https://www.covue.com/wp-content/uploads/2021/06/COVUE-IOR-for-Health-Food-Supplements-Pricing-and-Information.pdf" class="dark-blue-link" target="_blank"><strong>Click Here!</strong></a>'
			);
			break;
		case "8": // Shelf Stable Foods
			$("#product_title_info").html(
				"Shelf Stable Foods Regulated Application Services"
			);
			$("#product_info").html(
				'Shelf Stable Food Import Applications are approved by the Japan Ministry of Health Labor and Welfare (MHLW). Every shipment requires an application and pre-approval from MHLW prior to shipping.<br><br>MHLW is the sole determining agency for Shelf Stable Food Import Applications. Each application is reviewed and approved by the agency.<br><br>MHLW requires only one manufacturer per import application. All products listed on the application must be shipped. To know more about importing Shelf Stable Foods in Japan, <a href="https://www.covue.com/wp-content/uploads/2021/06/COVUE-Shelf-Stable-Food-Pricing-and-Information.pdf" class="dark-blue-link" target="_blank"><strong>Click Here!</strong></a>'
			);
			break;
		case "11": // Baby Products and Toys under 6
			$("#product_title_info").html(
				"Baby Products and Toys under 6 Regulated Application Services"
			);
			$("#product_info").html(
				'Baby Products and Toys under 6 Applications are approved by the Japan Ministry of Health Labor and Welfare (MHLW). Every shipment requires an application and pre-approval from MHLW prior to shipping.<br><br>MHLW is the sole determining agency for Baby products and Toys under 6 Import Applications. Each application is reviewed and approved by the agency.<br><br>MHLW requires only one manufacturer per import application. All products listed on the application must be shipped. To know more about importing Baby Products and Toys under 6, <a href="https://www.covue.com/wp-content/uploads/2021/06/IOR-for-Toys-under-6-Pricing-and-Information.pdf" class="dark-blue-link" target="_blank"><strong>Click Here!</strong></a>'
			);
			break;
		case "15": // Class 2 Medical Devices
			$("#product_title_info").html(
				"Class 2 Medical Devices Regulated Application Services"
			);
			$("#product_info").html(
				'Class 2 Medical Device Import Applications are approved by the Japan Ministry of Health Labor and Welfare (MHLW), PMDA division (Pharmaceuticals & Medical Devices Agency).<br><br>PMDA requires only one manufacturer per import application. There is no limitation to the number of products that can be added to the application. Each application is reviewed and approved by the agency. Once approved, the products may be shipped under the IOR’s license as a general approval. No additional applications are required.<br><br>PMDA requires only one manufacturer per import application. To know more about importing Medical Devices in Japan, <a href="https://www.covue.com/wp-content/uploads/2021/06/COVUE-IOR-for-Class-1-and-2-Medical-Device-Pricing-and-Information.pdf" class="dark-blue-link" target="_blank"><strong>Click Here!</strong></a>'
			);
			break;
		case "16": // Quasi Drug
			$("#product_title_info").html(
				"Quasi Drug Regulated Application Services"
			);
			$("#product_info").html(
				'Quasi-Drug Import Applications are approved by the Japan Ministry of Health Labor and Welfare (MHLW), PMDA division (Pharmaceuticals & Medical Devices Agency).<br><br>PMDA requires only one manufacturer per import application. There is no limitation to the number of products that can be added to the application. Each application is reviewed and approved by the agency. Once approved, the products may be shipped under the IOR’s license as a general approval. No additional applications are required.<br><br>PMDA requires only one manufacturer per import application. To know more about importing Quasi-drug into Japan, <a href="https://www.covue.com/wp-content/uploads/2021/06/COVUE-IOR-for-Quasi-Drug-Pricing-and-Information.pdf" class="dark-blue-link" target="_blank"><strong>Click Here!</strong></a>'
			);
			break;
		default:
			// Non-regulated
			$("#product_title_info").html("Non-regulated Applications Services");
			$("#product_info").html(
				'Non-Regulated products are defined as products that can be imported without pre-approval from a Japan government agency or, that do not require the seller to have a Japan license for that product to be sold. <br><br>To know more about importing Non Regulated Product in Japan, <a href="https://www.covue.com/wp-content/uploads/2021/06/Non-Regulated-Pricing-and-Information-3-1.pdf" class="dark-blue-link" target="_blank"><strong>Click Here!</strong></a>'
			);
	}

	if ($("#ior_registered").val() != 1 && $("#pli").val() != 1) {
		ior_pli_total = +$("#ior_reg_fee").val() + +$("#pli_fee").val();
	} else if ($("#ior_registered").val() == 1 && $("#pli").val() != 1) {
		ior_pli_total = $("#pli_fee").val();
	} else {
		ior_pli_total = 0;
	}

	if (product_offer_id == 0) {
		$("#products_testing_con").hide();
		if ($("#ior_registered").val() == 1 && $("#pli").val() == 1) {
			$("#paypalCheckoutIORregistered").show();
			$("#paypalCheckoutIOR").hide();
		} else {
			$("#paypalCheckoutIORregistered").hide();
			$("#paypalCheckoutIOR").show();
		}

		$("#regulated_name").html("");
		$("#cosmetics_desc").hide();
		$("#medical_devices_desc").hide();
		$("#regulated_price").html("");

		$("#subtotal_val").val(parseFloat(ior_pli_total).toFixed(2));
		$("#subtotal").html(
			"$" + numberWithCommas(parseFloat(ior_pli_total).toFixed(2))
		);

		var jct = ior_pli_total * 0.1;
		$("#jct_val").val(parseFloat(jct).toFixed(2));
		$("#jct").html("$" + numberWithCommas(parseFloat(jct).toFixed(2)));

		var total = +ior_pli_total + +jct;
		$("#total_val").val(parseFloat(total).toFixed(2));
		$("#total").html("$" + numberWithCommas(parseFloat(total).toFixed(2)));

		$("#non_reg_notes").show();
	} else {
		$("#products_testing_con").show();
		$("#paypalCheckoutIORregistered").hide();
		$("#paypalCheckoutIOR").show();
		$("#non_reg_notes").hide();

		$.ajax({
			url: base_url + "japan_ior/fetch_product_offer",
			type: "POST",
			data: { product_offer_id: product_offer_id },
			beforeSend: function () {
				spinner.show();
			},
			complete: function () {
				spinner.hide();
			},
			success: function (response) {
				product_offer_val = response.split("|");
				product_offer_price_raw = parseFloat(product_offer_val[1]);
				product_offer_price = numberWithCommas(
					product_offer_price_raw.toFixed(2)
				);

				$("#regulated_name").html(product_offer_val[2]);

				switch (product_offer_id) {
					case "4": // Class 1 Medical Devices
						$("#medical_devices_desc").show();
						$("#cosmetics_desc").hide();
						$("#japan_radio_desc").hide();
						break;
					case "5": // Cosmetics and Personal Care
						$("#cosmetics_desc").show();
						$("#medical_devices_desc").hide();
						$("#japan_radio_desc").hide();
						break;
					case "15": // Class 2 Medical Devices
						$("#medical_devices_desc").show();
						$("#cosmetics_desc").hide();
						$("#japan_radio_desc").hide();
						break;
					case "16": // Quasi Drug
						$("#cosmetics_desc").show();
						$("#medical_devices_desc").hide();
						$("#japan_radio_desc").hide();
						break;
					default:
						$("#cosmetics_desc").hide();
						$("#medical_devices_desc").hide();
						$("#japan_radio_desc").hide();
				}

				$("#regulated_price").html("$" + product_offer_price);

				subtotal = +ior_pli_total + +product_offer_price_raw;
				$("#subtotal_val").val(parseFloat(subtotal).toFixed(2));
				$("#subtotal").html(
					"$" + numberWithCommas(parseFloat(subtotal).toFixed(2))
				);

				var jct = subtotal * 0.1;
				$("#jct_val").val(parseFloat(jct).toFixed(2));
				$("#jct").html("$" + numberWithCommas(parseFloat(jct).toFixed(2)));

				var total = +subtotal + +jct;
				$("#total_val").val(parseFloat(total).toFixed(2));
				$("#total").html("$" + numberWithCommas(parseFloat(total).toFixed(2)));
			},
			error: function () {
				Toast.fire({
					icon: "error",
					position: "center",
					title:
						"Sorry for the inconvenience, some errors found. Please contact administrator.",
				});
			},
		});
	}
});

$("#product_testing").keyup(function () {
	var ptp_raw = 0;
	if ($(this).val() != "") {
		$("#product_testing_con").show();
		ptp_raw = parseFloat($(this).val() * 250);
		var ptp = numberWithCommas(ptp_raw.toFixed(2));
		$("#plt_val").val(parseFloat(ptp_raw).toFixed(2));
		$("#product_testing_price").text("$" + ptp);
	} else {
		$("#product_testing_con").hide();
		$("#product_testing_price").text("0");
		ptp_raw = 0;
		$("#plt_val").val(parseFloat(ptp_raw).toFixed(2));
	}

	subtotal = +ior_pli_total + +product_offer_price_raw + +ptp_raw;
	$("#subtotal_val").val(parseFloat(subtotal).toFixed(2));
	$("#subtotal").text("$" + numberWithCommas(parseFloat(subtotal).toFixed(2)));

	var jct = subtotal * 0.1;
	$("#jct_val").val(parseFloat(jct).toFixed(2));
	$("#jct").text("$" + numberWithCommas(parseFloat(jct).toFixed(2)));

	var total = +subtotal + +jct;
	$("#total_val").val(parseFloat(total).toFixed(2));
	$("#total").text("$" + numberWithCommas(parseFloat(total).toFixed(2)));
});

$("#btn_submit_checkout").click(function (e) {
	if ($("#billing_checkout_terms").prop("checked") == false) {
		e.preventDefault();
		Toast.fire({
			icon: "error",
			position: "center",
			title: "Please agree to all the terms and conditions before checkout.",
		});
	} else {
		$("#modal_billing_checkout").modal("hide");
		$("form#frmProductsServices").submit();
	}
});

$("#btn_submit_checkout_shipping").click(function (e) {
	if ($("#billing_checkout_terms").prop("checked") == false) {
		e.preventDefault();
		Toast.fire({
			icon: "error",
			position: "center",
			title: "Please agree to all the terms and conditions before checkout.",
		});
	} else {
		$("#modal_billing_checkout_shipping").modal("hide");
		$("form#frmShippingFee").submit();
	}
});

$("#btn_submit_product_label_checkout").click(function (e) {
	if ($("#billing_checkout_terms").prop("checked") == false) {
		e.preventDefault();
		Toast.fire({
			icon: "error",
			position: "center",
			title: "Please agree to all the terms and conditions before checkout.",
		});
	} else {
		$("#modal_billing_checkout").modal("hide");
		$("#purchaseProductLabel").submit();
	}
});

function showConfirmDeleteBillingInvoice(id) {
	$("#btn_delete_billing_invoice").html(
		'<button type="button" class="btn btn-dark-blue" onclick="deleteBillingInvoice(\'' +
			id +
			"')\">Yes</button> " +
			'<button type="button" class="btn btn-outline-dark-blue" data-dismiss="modal">No</button>'
	);
	$("#modal_delete_billing_invoice").modal({
		keyboard: false,
		backdrop: "static",
		show: true,
	});
}

function deleteBillingInvoice(id) {
	var spinner = $("#loader");

	$.ajax({
		url: base_url + "japan_ior/delete_billing_invoice",
		type: "POST",
		data: { id: id },
		beforeSend: function () {
			spinner.show();
			$("#modal_delete_billing_invoice").modal("hide");
		},
		complete: function () {
			spinner.hide();
		},
		success: function (result) {
			if (result == 1) {
				Toast.fire({
					icon: "success",
					position: "center",
					title:
						"Billing Invoice is successfully deleted! Redirecting you to back the list.",
				});

				setTimeout(function () {
					window.location.href = base_url + "japan_ior/billing_invoices";
				}, 3000);
			}
		},
		error: function () {
			Toast.fire({
				icon: "error",
				position: "center",
				title:
					"Sorry for the inconvenience, some errors found. Please contact administrator through livechat or email.",
			});
		},
	});
}

function setCategory(product_registration_id, product_category) {
	$("#product_registration_id").val(product_registration_id);
	$("#product_category").val(product_category).change();

	$("#modal_set_category").modal({
		keyboard: false,
		backdrop: "static",
		show: true,
	});
}

$("#btn_set_category").click(function () {
	var spinner = $("#loader");
	var product_registration_id = $("#product_registration_id").val();
	var product_category_values = $("#product_category").val();
	var product_category = product_category_values.split("|");

	$.ajax({
		url: base_url + "product_registrations/update_product_category",
		type: "POST",
		data: {
			product_registration_id: product_registration_id,
			product_category_id: product_category[0],
		},
		beforeSend: function () {
			spinner.show();
			$("#modal_set_category").modal("hide");
		},
		complete: function () {
			spinner.hide();
		},
		success: function (response) {
			if (response == 1) {
				Toast.fire({
					icon: "success",
					position: "center",
					title: "Successfully updated the product category!",
				});

				$("td#prod_cat_" + product_registration_id).html(product_category[1]);
			}
		},
		error: function () {
			Toast.fire({
				icon: "error",
				position: "center",
				title:
					"Sorry for the inconvenience, some errors found. Please contact administrator.",
			});
		},
	});
});

$("#btn_billing_payment").click(function (e) {
	if ($("#billing_invoice_terms").prop("checked") == false) {
		e.preventDefault();
		Toast.fire({
			icon: "error",
			position: "center",
			title: "Please accept our Terms and Conditions to continue payment.",
		});
	}
});

function showSetBillingComplete(id) {
	$("#btn_billing_complete").html(
		'<button type="button" class="btn btn-success" onclick="completeBillingInvoice(\'' +
			id +
			"')\">Yes</button> " +
			'<button type="button" class="btn btn-danger" data-dismiss="modal">No</button>'
	);
	$("#modal_billing_complete").modal({
		keyboard: false,
		backdrop: "static",
		show: true,
	});
}

function completeBillingInvoice(id) {
	var spinner = $("#loader");

	$.ajax({
		url: base_url + "billing_invoices/complete_billing_invoice",
		type: "POST",
		data: { id: id },
		beforeSend: function () {
			spinner.show();
			$("#modal_billing_complete").modal("hide");
		},
		complete: function () {
			spinner.hide();
		},
		success: function (result) {
			if (result == 1) {
				Toast.fire({
					icon: "success",
					position: "center",
					title:
						"Billing Invoice is successfully set to complete! Redirecting you to back the list.",
				});

				setTimeout(function () {
					window.location.href = base_url + "billing_invoices";
				}, 3000);
			}
		},
		error: function () {
			Toast.fire({
				icon: "error",
				position: "center",
				title:
					"Sorry for the inconvenience, some errors found. Please contact administrator.",
			});
		},
	});
}

function showSetBillingPaid(id) {
	$("#btn_billing_paid").html(
		'<button type="button" class="btn btn-success" onclick="paidBillingInvoice(\'' +
			id +
			"')\">Yes</button> " +
			'<button type="button" class="btn btn-danger" data-dismiss="modal">No</button>'
	);
	$("#modal_billing_paid").modal({
		keyboard: false,
		backdrop: "static",
		show: true,
	});
}

function paidBillingInvoice(id) {
	var spinner = $("#loader");

	$.ajax({
		url: base_url + "billing_invoices/paid_billing_invoice",
		type: "POST",
		data: { id: id },
		beforeSend: function () {
			spinner.show();
			$("#modal_billing_paid").modal("hide");
		},
		complete: function () {
			spinner.hide();
		},
		success: function (result) {
			if (result == 1) {
				Toast.fire({
					icon: "success",
					position: "center",
					title:
						"Billing Invoice is successfully set to paid! Redirecting you to back the list.",
				});

				setTimeout(function () {
					window.location.href = base_url + "billing_invoices";
				}, 3000);
			}
		},
		error: function () {
			Toast.fire({
				icon: "error",
				position: "center",
				title:
					"Sorry for the inconvenience, some errors found. Please contact administrator.",
			});
		},
	});
}

function showSetBillingCancel(id) {
	$("#btn_billing_cancel").html(
		'<button type="button" class="btn btn-success" onclick="cancelBillingInvoice(\'' +
			id +
			"')\">Yes</button> " +
			'<button type="button" class="btn btn-danger" data-dismiss="modal">No</button>'
	);
	$("#modal_billing_cancel").modal({
		keyboard: false,
		backdrop: "static",
		show: true,
	});
}

function cancelBillingInvoice(id) {
	var spinner = $("#loader");

	$.ajax({
		url: base_url + "billing_invoices/cancel_billing_invoice",
		type: "POST",
		data: { id: id },
		beforeSend: function () {
			spinner.show();
			$("#modal_billing_cancel").modal("hide");
		},
		complete: function () {
			spinner.hide();
		},
		success: function (result) {
			if (result == 1) {
				Toast.fire({
					icon: "success",
					position: "center",
					title:
						"Billing Invoice is cancelled. Redirecting you to back the list.",
				});

				setTimeout(function () {
					window.location.href = base_url + "billing_invoices";
				}, 3000);
			}
		},
		error: function () {
			Toast.fire({
				icon: "error",
				position: "center",
				title:
					"Sorry for the inconvenience, some errors found. Please contact administrator.",
			});
		},
	});
}

$(".product_category").on("change", function () {
	var spinner = $("#loader");
	var product_registration_id = $(this).attr("data-id");
	var product_category_values = this.value;
	var user_id = $(this).attr("data-user-id");

	if (product_category_values == 1) {
		// Non-Regulated
		$.ajax({
			url: base_url + "product_registrations/update_product_category",
			type: "POST",
			data: {
				product_registration_id: product_registration_id,
				product_category_id: product_category_values,
				user_id: user_id,
			},
			beforeSend: function () {
				spinner.show();
			},
			complete: function () {
				spinner.hide();
			},
			success: function (response) {
				if (response == 1) {
					Toast.fire({
						icon: "success",
						position: "center",
						title: "Successfully updated the product category!",
					});
				}
			},
			error: function () {
				Toast.fire({
					icon: "error",
					position: "center",
					title:
						"Sorry for the inconvenience, some errors found. Please contact administrator.",
				});
			},
		});
	} else if (product_category_values == 8) {
		// Electronics - Japan Radio
		$("#btn_japan_radio").html(
			'<button type="button" class="btn btn-success" onclick="japanRadioCert(\'' +
				product_registration_id +
				"','" +
				product_category_values +
				"','" +
				user_id +
				"')\">Yes</button> " +
				'<button type="button" class="btn btn-danger" onclick="location.reload();">No</button>'
		);
		$("#modal_japan_radio").modal({
			keyboard: false,
			backdrop: "static",
			show: true,
		});
	} else if (product_category_values == 11) {
		// Non-Regulated - Baby Products
		$("#btn_baby_non_reg").html(
			'<button type="button" class="btn btn-success" onclick="babyNonReg(\'' +
				product_registration_id +
				"','" +
				product_category_values +
				"','" +
				user_id +
				"')\">Yes</button> " +
				'<button type="button" class="btn btn-danger" onclick="location.reload();">No</button>'
		);
		$("#modal_baby_non_reg").modal({
			keyboard: false,
			backdrop: "static",
			show: true,
		});
	} else {
		$("#btn_regulated").html(
			'<button type="button" class="btn btn-success" onclick="regulatedProductsSet(\'' +
				product_registration_id +
				"','" +
				product_category_values +
				"','" +
				user_id +
				"')\">Yes</button> " +
				'<button type="button" class="btn btn-danger" onclick="location.reload();">No</button>'
		);
		$("#modal_regulated").modal({
			keyboard: false,
			backdrop: "static",
			show: true,
		});
	}
});

function regulatedProductsSet(
	product_registration_id,
	product_category_values,
	user_id
) {
	var spinner = $("#loader");

	$.ajax({
		url: base_url + "product_registrations/update_product_category",
		type: "POST",
		data: {
			product_registration_id: product_registration_id,
			product_category_id: product_category_values,
			user_id: user_id,
		},
		beforeSend: function () {
			spinner.show();
			$("#modal_regulated").modal("hide");
		},
		complete: function () {
			spinner.hide();
		},
		success: function (response) {
			if (response == 1) {
				Toast.fire({
					icon: "success",
					position: "center",
					title: "Successfully updated the regulated product category!",
				});
			}
		},
		error: function () {
			Toast.fire({
				icon: "error",
				position: "center",
				title:
					"Sorry for the inconvenience, some errors found. Please contact administrator.",
			});
		},
	});
}

function japanRadioCert(
	product_registration_id,
	product_category_values,
	user_id
) {
	var spinner = $("#loader");

	$.ajax({
		url: base_url + "product_registrations/update_product_category",
		type: "POST",
		data: {
			product_registration_id: product_registration_id,
			product_category_id: product_category_values,
			user_id: user_id,
		},
		beforeSend: function () {
			spinner.show();
			$("#modal_japan_radio").modal("hide");
		},
		complete: function () {
			spinner.hide();
		},
		success: function (response) {
			if (response == 1) {
				Toast.fire({
					icon: "success",
					position: "center",
					title: "Successfully updated the product category!",
				});
			}
		},
		error: function () {
			Toast.fire({
				icon: "error",
				position: "center",
				title:
					"Sorry for the inconvenience, some errors found. Please contact administrator.",
			});
		},
	});
}

function babyNonReg(product_registration_id, product_category_values, user_id) {
	var spinner = $("#loader");

	$.ajax({
		url: base_url + "product_registrations/update_product_category",
		type: "POST",
		data: {
			product_registration_id: product_registration_id,
			product_category_id: product_category_values,
			user_id: user_id,
		},
		beforeSend: function () {
			spinner.show();
			$("#modal_baby_non_reg").modal("hide");
		},
		complete: function () {
			spinner.hide();
		},
		success: function (response) {
			if (response == 1) {
				Toast.fire({
					icon: "success",
					position: "center",
					title: "Successfully updated the product category!",
				});
			}
		},
		error: function () {
			Toast.fire({
				icon: "error",
				position: "center",
				title:
					"Sorry for the inconvenience, some errors found. Please contact administrator.",
			});
		},
	});
}

function myFunction() {
	var copyText = document.getElementById("myInput");

	copyText.select();
	copyText.setSelectionRange(0, 99999);

	document.execCommand("copy");
	Toast.fire({
		icon: "success",
		position: "top",
		title: "Copied Successfully",
	});
}

$(".assign_admin_reg").on("change", function () {
	var regulated_application_id = $(this).attr("data-id");
	var assigned_admin_id = this.value;
	var assigned_admin_name = $(this).find(":selected").data("name");
	var assignor = $(this).find(":selected").data("assignor");
	var last_assign_admin_reg = $(
		"#last_assign_admin_reg" + regulated_application_id
	).val();

	$("strong#assign_admin_name").html(assigned_admin_name);

	$("#confirmButtons").html(
		'<button type="button" class="btn btn-success" onclick="assignedAdminReg(\'' +
			regulated_application_id +
			"','" +
			assigned_admin_id +
			"','" +
			assignor +
			"')\">Confirm</button> " +
			'<button type="button" class="btn btn-danger" onclick="cancelAssignedAdminReg(\'' +
			last_assign_admin_reg +
			"')\">Cancel</button>"
	);

	$("#modal_assigned_admin_reg").modal({
		keyboard: false,
		backdrop: "static",
		show: true,
	});
});

function assignedAdminReg(
	regulated_application_id,
	assigned_admin_id,
	assignor
) {
	var spinner = $("#loader");

	$.ajax({
		url: base_url + "regulated_applications/update_assigned_admin",
		type: "POST",
		data: {
			regulated_application_id: regulated_application_id,
			assigned_admin_id: assigned_admin_id,
			assignor: assignor,
		},
		beforeSend: function () {
			spinner.show();
			$("#modal_assigned_admin_reg").modal("hide");
		},
		complete: function () {
			spinner.hide();
		},
		success: function (response) {
			if (response == 1) {
				Toast.fire({
					icon: "success",
					position: "center",
					title: "Successfully updated the assigned personnel!",
				});
			}
		},
		error: function () {
			Toast.fire({
				icon: "error",
				position: "center",
				title:
					"Sorry for the inconvenience, some errors found. Please contact administrator.",
			});
		},
	});
}

function cancelAssignedAdminReg(last_assign_admin_reg) {
	$("#modal_assigned_admin_reg").modal("hide");
	$("#assign_admin_reg").val(last_assign_admin_reg).change();
}

$("#modal_assigned_admin_reg button.close").click(function () {
	var last_assign_admin_reg = $("#last_assign_admin_reg").val();

	$("#modal_assigned_admin_reg").modal("hide");
	$("#assign_admin_reg").val(last_assign_admin_reg).change();
});

$("#btn_sign_up").click(function (e) {
	if ($("#terms").prop("checked") == false) {
		e.preventDefault();
		Toast.fire({
			icon: "error",
			position: "center",
			title:
				"Please accept our Terms and Conditions to continue signup process.",
		});
	}
});

$(".btn-remove-verification").click(function () {
	$(".custom-file-input").removeAttr("required");
});

// function getNotification() {
// 	$.getJSON(
// 		base_url + "japan_ior/regulated_status_notification",
// 		function (data) {
// 			$.each(data, function (index) {
// 				$(".navbar-badge").html(data.length);
// 				$("#no_new_notif").remove();
// 				$(".regulated-status").append(
// 					'<a href="' +
// 						base_url +
// 						"japan-ior/tracking-application/" +
// 						data[index].id +
// 						'" class="dropdown-item"><i class="fas fa-envelope mr-2"></i> New Regulated Application Remarks <span class="float-right text-muted text-sm"></span></a>'
// 				);
// 			});
// 		}
// 	);
// }
// getNotification();

// ** PUSHER ** //

// SHOW upload product label

function showUploadProductLabelAdmin(id) {
	$("#uploadproductlabel").modal("toggle");
	$("#regulated_product_id").val(id);
}

function showBulkUploadProductLabelAdmin(id) {
	$("#uploadbulkproductlabel").modal("toggle");
}

function showDeleteProductLabelAdmin(id) {
	$("#deleteproductlabel").modal("toggle");
	$("#regulated_product_btn_delete").val(id);
}

$("#btn_start_regulated").click(function () {
	$(this).hide();
	$("#btn_start_loading").show();
});

function showConfirmRegulatedSubmit(params) {
	$("#btn_regulated_submit").html(
		'<button type="button" class="btn btn-dark-blue" onclick="regulatedSubmit(\'' +
			params +
			"')\">Yes</button> " +
			'<button type="button" class="btn btn-outline-dark-blue" data-dismiss="modal">No</button>'
	);
	$("#modal_regulated_submit").modal({
		keyboard: false,
		backdrop: "static",
		show: true,
	});
}

function regulatedSubmit(params) {
	var spinner = $("#loader");

	$.ajax({
		url: base_url + "japan_ior/submit_pre_import",
		type: "POST",
		data: { id: params },
		beforeSend: function () {
			spinner.show();
			$("#modal_regulated_submit").modal("hide");
		},
		complete: function () {
			spinner.hide();
		},
		success: function (response) {
			if (response == 1) {
				Toast.fire({
					icon: "success",
					position: "center",
					title:
						"Congratulations! successfully submitted your Pre-import documents! Redirecting you back to Tracking Application Status ...",
				});

				setTimeout(function () {
					window.location.href =
						base_url + "japan-ior/tracking-application/" + params;
				}, 3000);
			} else {
				Toast.fire({
					icon: "error",
					position: "center",
					title:
						"Please add Manufacturer Details and Regulated Products to proceed.",
				});
			}
		},
		error: function () {
			Toast.fire({
				icon: "error",
				position: "center",
				title:
					"Sorry for the inconvenience, some errors found. Please contact administrator.",
			});
		},
	});
}

function showConfirmRegulatedCancel(params) {
	$("#btn_regulated_cancel").html(
		'<button type="button" class="btn btn-dark-blue" onclick="regulatedCancel(\'' +
			params +
			"')\">Yes</button> " +
			'<button type="button" class="btn btn-outline-dark-blue" data-dismiss="modal">No</button>'
	);
	$("#modal_regulated_cancel").modal({
		keyboard: false,
		backdrop: "static",
		show: true,
	});
}

function regulatedCancel(params) {
	var spinner = $("#loader");

	$.ajax({
		url: base_url + "japan_ior/cancel_reg_application",
		type: "POST",
		data: { id: params },
		beforeSend: function () {
			spinner.show();
			$("#modal_regulated_cancel").modal("hide");
		},
		complete: function () {
			spinner.hide();
		},
		success: function (response) {
			if (response == 1) {
				Toast.fire({
					icon: "success",
					position: "center",
					title: "Successfully cancelled your Regulated Application.",
				});

				setTimeout(function () {
					window.location.href = base_url + "japan-ior/regulated-applications	";
				}, 3000);
			}
		},
		error: function () {
			Toast.fire({
				icon: "error",
				position: "center",
				title:
					"Sorry for the inconvenience, some errors found. Please contact administrator.",
			});
		},
	});
}

function showConfirmRegulatedPreApprove(params) {
	$("#btn_approve_pre_import").html(
		'<button type="button" class="btn btn-success" onclick="regulatedPreApprove(\'' +
			params +
			"')\">Yes</button> " +
			'<button type="button" class="btn btn-danger" data-dismiss="modal">No</button>'
	);
	$("#modal_approve_pre_import").modal({
		keyboard: false,
		backdrop: "static",
		show: true,
	});
}

function regulatedPreApprove(params) {
	var spinner = $("#loader");

	$.ajax({
		url: base_url + "regulated_applications/approve_pre_import",
		type: "POST",
		data: { id: params },
		beforeSend: function () {
			spinner.show();
			$("#modal_approve_pre_import").modal("hide");
		},
		complete: function () {
			spinner.hide();
		},
		success: function (response) {
			if (response == 1) {
				Toast.fire({
					icon: "success",
					position: "center",
					title:
						"Congratulations! successfully approved Pre-import documents! Redirecting you back to Tracking Details ...",
				});

				setTimeout(function () {
					window.location.href =
						base_url + "regulated-applications/tracking-details/" + params;
				}, 3000);
			} else {
				Toast.fire({
					icon: "error",
					position: "center",
					title:
						"There is no approved products. Please approve regulated products to proceed.",
				});
			}
		},
		error: function () {
			Toast.fire({
				icon: "error",
				position: "center",
				title:
					"Sorry for the inconvenience, some errors found. Please contact administrator.",
			});
		},
	});
}

function showConfirmRegulatedPreDecline(params) {
	$("#btn_decline_pre_import").html(
		'<button type="button" class="btn btn-success" onclick="regulatedPreDecline(\'' +
			params +
			"')\">Yes</button> " +
			'<button type="button" class="btn btn-danger" data-dismiss="modal">No</button>'
	);
	$("#modal_decline_pre_import").modal({
		keyboard: false,
		backdrop: "static",
		show: true,
	});
}

function regulatedPreDecline(params) {
	var spinner = $("#loader");
	var remarks = $("#declined_remarks").val();

	$.ajax({
		url: base_url + "regulated-applications/decline-pre-import",
		type: "POST",
		data: { id: params, remarks: remarks },
		beforeSend: function () {
			spinner.show();
			$("#modal_decline_pre_import").modal("hide");
		},
		complete: function () {
			spinner.hide();
		},
		success: function (response) {
			if (response == 1) {
				Toast.fire({
					icon: "success",
					position: "center",
					title:
						"Successfully declined Pre-import documents! Redirecting you back to Tracking Details ...",
				});

				setTimeout(function () {
					window.location.href =
						base_url + "regulated-applications/tracking-details/" + params;
				}, 3000);
			}
		},
		error: function () {
			Toast.fire({
				icon: "error",
				position: "center",
				title:
					"Sorry for the inconvenience, some errors found. Please contact administrator.",
			});
		},
	});
}

function showConfirmRegulatedPreRevision(params) {
	$("#btn_revision_pre_import").html(
		'<button type="button" class="btn btn-success" onclick="regulatedPreRevision(\'' +
			params +
			"')\">Yes</button> " +
			'<button type="button" class="btn btn-danger" data-dismiss="modal">No</button>'
	);
	$("#modal_revision_pre_import").modal({
		keyboard: false,
		backdrop: "static",
		show: true,
	});
}

function regulatedPreRevision(params) {
	var spinner = $("#loader");
	var remarks = $("#revision_remarks").val();

	$.ajax({
		url: base_url + "regulated-applications/revision-pre-import",
		type: "POST",
		data: { id: params, remarks: remarks },
		beforeSend: function () {
			spinner.show();
			$("#modal_revision_pre_import").modal("hide");
		},
		complete: function () {
			spinner.hide();
		},
		success: function (response) {
			if (response == 1) {
				Toast.fire({
					icon: "success",
					position: "center",
					title:
						"Successfully sent Revisions for Pre-import documents! Redirecting you back to Tracking Details ...",
				});

				setTimeout(function () {
					window.location.href =
						base_url + "regulated-applications/tracking-details/" + params;
				}, 3000);
			}
		},
		error: function () {
			Toast.fire({
				icon: "error",
				position: "center",
				title:
					"Sorry for the inconvenience, some errors found. Please contact administrator.",
			});
		},
	});
}

function showConfirmRegulatedPreCancel(params) {
	$("#btn_cancel_pre_import").html(
		'<button type="button" class="btn btn-success" onclick="regulatedPreCancel(\'' +
			params +
			"')\">Yes</button> " +
			'<button type="button" class="btn btn-danger" data-dismiss="modal">No</button>'
	);
	$("#modal_cancel_pre_import").modal({
		keyboard: false,
		backdrop: "static",
		show: true,
	});
}

function regulatedPreCancel(params) {
	var spinner = $("#loader");

	$.ajax({
		url: base_url + "regulated_applications/cancel_pre_import",
		type: "POST",
		data: { id: params },
		beforeSend: function () {
			spinner.show();
			$("#modal_cancel_pre_import").modal("hide");
		},
		complete: function () {
			spinner.hide();
		},
		success: function (response) {
			if (response == 1) {
				Toast.fire({
					icon: "success",
					position: "center",
					title:
						"Successfully cancelled Pre-import documents! Redirecting you back to Tracking Details ...",
				});

				setTimeout(function () {
					window.location.href =
						base_url + "regulated-applications/tracking-details/" + params;
				}, 3000);
			}
		},
		error: function () {
			Toast.fire({
				icon: "error",
				position: "center",
				title:
					"Sorry for the inconvenience, some errors found. Please contact administrator.",
			});
		},
	});
}

function showDownloadProductLabel(id) {
	$("#down-prod-label-modal").modal();
	$(".regid").val(id);
}
function showPurchaseProductLabel(id, cat, cnt, cat_id) {
	$("#purchase-product-label").modal("toggle");
	$("#category_name").text(cat);
	$("#category_id").val(cat_id);
	if (cat_id == 2 || cat_id == 5 || cat_id == 10) {
		totcnt = cnt;
	} else {
		totcnt = 1;
	}

	$("#item-count").text("(" + totcnt + " x $4.95)");

	var regulated_price = totcnt * 4.95;
	var jct = regulated_price * 0.1;
	var total = jct + regulated_price;

	$("#regulated_price").text("$" + regulated_price.toFixed(2));
	$("#subtotal").text("$" + regulated_price.toFixed(2));
	$("#subtotal_val").val(regulated_price.toFixed(2));
	$("#jct").text("$" + jct.toFixed(2));
	$("#jct_val").val(jct.toFixed(2));
	$("#total").text("$" + total.toFixed(2));
	$("#total_val").val(total.toFixed(2));
}

function showUploadTestResult(id) {
	$("#uploadTestResult").modal("toggle");
	$("#product_registration_id_upload").val(id);
}

function showDeleteTestResult(id) {
	$("#deleteTestResult").modal("toggle");
	$("#product_registration_id_delete").val(id);
}

function showBillingModal() {
	$("#modal_billing_checkout").modal("toggle");
	$("#purchase-product-label").modal("toggle");
}

function capitalizeFirstLetter(string) {
	return string.charAt(0).toUpperCase() + string.slice(1);
}

$("#btn_completed").click(function () {
	$(this).hide();
	$("#btn_sending").show();
});

function showConfirmDelKnowledgebaseProd(id) {
	$("#confirmButtons").html(
		'<button type="button" class="btn btn-success" onclick="deleteKnowledgebaseProd(\'' +
			id +
			"')\">Yes</button> " +
			'<button type="button" class="btn btn-danger" data-dismiss="modal">No</button>'
	);
	$("#modal_delete_knowledgebase_product").modal({
		keyboard: false,
		backdrop: "static",
		show: true,
	});
}

function deleteKnowledgebaseProd(id) {
	var spinner = $("#loader");

	$.ajax({
		url: base_url + "knowledgebase/delete_product",
		type: "POST",
		data: { id: id },
		beforeSend: function () {
			spinner.show();
			$("#modal_delete_knowledgebase_product").modal("hide");
		},
		complete: function () {
			spinner.hide();
		},
		success: function (result) {
			if (result == 1) {
				Toast.fire({
					icon: "success",
					position: "center",
					title:
						"Knowledgebase Product is successfully deleted! Refreshing list ...",
				});

				setTimeout(function () {
					window.location.href = base_url + "knowledgebase";
				}, 3000);
			}
		},
		error: function () {
			Toast.fire({
				icon: "error",
				position: "center",
				title:
					"Sorry for the inconvenience, some errors found. Please contact administrator.",
			});
		},
	});
}

/** Password Validation */

$(document).on("keyup", ".password", function () {
	var password = $(this).val();
	console.log(password);
	var color = "Red";
	var uppercase = /[A-Z]/;
	var lowercase = /[a-z]/;
	var number = /[0-9]/;
	var special = /[\W]{1,}/;
	var pswd_length = password.length < 8;
	if (
		!uppercase.test(password) ||
		!lowercase.test(password) ||
		!number.test(password) ||
		!special.test(password) ||
		pswd_length
	) {
		$("#passwordvalidation").html("(Password not match to the requirements)");
		$("#passwordvalidation").css("color", color);
		$(".password")
			.popover({
				placement: "right",
				content:
					"your password must be 8 - 12 characters, <br> and include at least one uppercase , one number and special character",
				html: true,
			})
			.popover("show");
		$(":submit").attr("disabled", true);
	} else {
		$("#passwordvalidation").html("");
		$(".password").popover("hide");
		$(":submit").attr("disabled", false);
	}
});

/** End Password Validation */

/** Select Onchange Tracking Status */

var rowCount = $("#tblRegulatedApplicationsDetails >tbody >tr").length - 1;
$("#stepcount").val(rowCount);
var id = $("#regulated_application_id").val();

$("#tracking-status").on("change", function () {
	$("#btn-notif").show();
	$("#tracking_status").val(this.value);

	/** MODAL */
	$("#confirm-modal").modal("show");
	$("#confirm-modal").find("input#tracking_status_a").val(this.value);
	$("#confirm-modal").find("input#stepcount_a").val(rowCount);

	if (this.value == 4) {
		$("td#product-lab").html(
			"<a href=" +
				base_url +
				"regulated-applications/upload-test-results/" +
				id +
				" class='btn btn-xs btn-primary'><i class='fas fa-flask mr-2'></i>Upload Lab/Product Test Results</a></a>"
		);
	} else if (this.value == 5) {
		$("td#product-lab").html(
			"<a href=" +
				base_url +
				"regulated-applications/upload-product-labels/" +
				id +
				" class='btn btn-xs btn-primary'><i class='fas fa-tags mr-2'></i>Upload Product Labels</a>"
		);
	} else {
		$("td#product-lab").html("");
	}
});
$("#no-status").click(function () {
	window.location.reload();
});
/** End Select Onchange Tracking Status */

function showProductSamplingModal(id) {
	$("#modal_product_sampling_status").modal({
		keyboard: false,
		backdrop: "static",
		show: true,
	});

	$.ajax({
		url: base_url + "regulated_applications/product_sampling",
		type: "POST",
		data: { id: id },
		success: function (result) {
			$("#product_sampling_status").html(result);
		},
		error: function () {
			Toast.fire({
				icon: "error",
				position: "center",
				title:
					"Sorry for the inconvenience, some errors found. Please contact administrator.",
			});
		},
	});
}

function showSyncUser(params) {
	$("#btn_sync_user").html(
		'<button type="button" class="btn btn-success" onclick="syncUser(\'' +
			params +
			"')\">Yes</button> " +
			'<button type="button" class="btn btn-danger" data-dismiss="modal">No</button>'
	);
	$("#modal_sync_user").modal({
		keyboard: false,
		backdrop: "static",
		show: true,
	});
}

function syncUser(params) {
	var spinner = $("#loader");
	var accnt_id = '';
	$.ajax({
		url: base_url + "users/sync_user",
		type: "POST",
		dataType: 'JSON',
		data: { id: params },
		beforeSend: function () {
			spinner.show();
			$("#modal_sync_user").modal("hide");
		},
		complete: function () {
			// spinner.hide();
		},
		success: function (result) {
			// console.log(result.local_data);
			
			if(result.result_data === false){
				addUserToZoho(result.local_data);
			}else{
				if(result.result_data['data'][0].Phone){
					accnt_id = result.result_data['data'][0].id;
					updateUserToZoho(accnt_id,result.local_data);
				}else{
					addUserToZoho(result.local_data);
				}
			}
			// if (result == 1) {
			// 	Toast.fire({
			// 		icon: "success",
			// 		position: "center",
			// 		title: "Successfully syncd user, refreshing page ...",
			// 	});

			// 	window.location.href = base_url + "users/listing";
			// }
		},
		error: function () {
			Toast.fire({
				icon: "error",
				position: "center",
				title:
					"Sorry for the inconvenience, some errors found. Please contact administrator.",
			});
		},
	});
}

function addUserToZoho(data) {
	var spinner = $("#loader");
	var accnt_id = '';
	$.ajax({
		url: base_url + "users/add_user_zoho",
		type: "POST",
		dataType: 'JSON',
		data: { data: data },
		beforeSend: function () {
			// spinner.show();
			// $("#modal_sync_user").modal("hide");
		},
		complete: function () {
			spinner.hide();
		},
		success: function (result) {
			console.log(result);
			// accnt_id = result.result_data['data'][0].id;
			// if(result == 'false'){
			// 	addUserToZoho(result.local_data);
			// }else{
			// 	if(result.data[0].Phone){
			// 		updateUserToZoho(accnt_id,result.local_data);
			// 	}else{
			// 		addUserToZoho(result.local_data);
			// 	}
			// }
			if (result == 1) {
				Toast.fire({
					icon: "success",
					position: "center",
					title: "Successfully syncd user, refreshing page ...",
				});

				window.location.href = base_url + "users/listing";
			}
		},
		error: function (err) {
			console.log(err.responseText)
			Toast.fire({
				icon: "error",
				position: "center",
				title:
					"Sorry for the inconvenience, some errors found. Please contact administrator.",
			});
		},
	});
}

function updateUserToZoho(id,data) {
	var spinner = $("#loader");
	var accnt_id = id;
	$.ajax({
		url: base_url + "users/update_user_zoho",
		type: "POST",
		dataType: 'JSON',
		data: { id: accnt_id , data:data },
		beforeSend: function () {
			// spinner.show();
			// $("#modal_sync_user").modal("hide");
		},
		complete: function () {
			spinner.hide();
		},
		success: function (result) {
			// console.log(result.local_data);
			// accnt_id = result.result_data['data'][0].id;
			// if(result == 'false'){
			// 	addUserToZoho(result.local_data);
			// }else{
			// 	if(result.data[0].Phone){
			// 		updateUserToZoho(accnt_id,result.local_data);
			// 	}else{
			// 		addUserToZoho(result.local_data);
			// 	}
			// }
			if (result == 1) {
				Toast.fire({
					icon: "success",
					position: "center",
					title: "Successfully syncd user, refreshing page ...",
				});

				window.location.href = base_url + "users/listing";
			}
		},
		error: function () {
			Toast.fire({
				icon: "error",
				position: "center",
				title:
					"Sorry for the inconvenience, some errors found. Please contact administrator.",
			});
		},
	});
}


$('#logistic_form').on('change', function(e){
	if(e.target.checked){
	  $('#logistic-details-modal').modal();
	}
});

$("#logistic_form_v").click(function () {
	$('#logistic-details-modal').modal();
});
 
 function addProductDetails(id) {
	var ids = $("#cur_sel_" + id).val();
	$("#prod_log_id").val(ids);
	var shipping_code = $("#shipping_session_v").val();
	$('#add-product-details').modal('show');

	$("#batch_number").val('');
	$("#fda_no").val('');
	$("#barcode").val('');
	$("#pallets").val('');
	$("#cases").val('');
	$("#units").val('');
	$("#pallet_length").val('');
	$("#pallet_height").val('');
	$("#pallet_width").val('');
	$("#gw").val('');
	$("#volume").val('');
	$('#work_order').val(null).trigger('change');
	$("#md").val('');
	$("#ed").val('');
	
	$.ajax({
		url: base_url + "japan_ior/fetch_logistic_product_details",
		type: "POST",
		data: {	ids: ids,shipping_code:shipping_code},
		success: function (data) {
			var t = JSON.parse(data);
			$.each(t, function (index, item) {
				var arrayOfValues = item['work_order'].replace(/[\[\]']+/g,'').replace(/\"/g, "", "");;
				var nameArr = arrayOfValues.split(',');
				$("#batch_number").val(item['batch_number']);
				$("#fda_no").val(item['fda_no']);
				$("#barcode").val(item['barcode']);
				$("#pallets").val(item['pallets']);
				$("#cases").val(item['cases']);
				$("#units").val(item['units']);
				$("#pallet_length").val(item['pallet_length']);
				$("#pallet_height").val(item['pallet_height']);
				$("#pallet_width").val(item['pallet_width']);
				$("#gw").val(item['gw']);
				$("#volume").val(item['volume']);
				$("#work_order").select2().val(nameArr).trigger('change'); 
				$("#md").val(item['date_of_manufacture']);
				$("#ed").val(item['expiration_date']);
			});
		},
	});

 }

//$('#add_product_details').click(function(){
	//var id = $(".prod_selected").val();
	//$("#prod_log_id").val(id);
	//$('#add-product-details').modal('show')
//});

$(document).ready(function(){
	$('#work_order').select2({
					allowClear: true,
					minimumResultsForSearch: -1,
	});
});

$( "#add_logistic_details" ).submit(function( event ) {

	$("#process_add_logistic").show();
	$("#btn_add_logistic").hide();
	$("#btn_close_logistic").hide();

	var shipping_session = $("#shipping_session").val();
	var prod_log_id = $("#prod_log_id").val();
	var batch_number = $("#batch_number").val();
	var fda_no = $("#fda_no").val();
	var barcode = $("#barcode").val();
	var pallets = $("#pallets").val();
	var cases = $("#cases").val();
	var units = $("#units").val();
	var pallet_length = $("#pallet_length").val();
	var pallet_width = $("#pallet_width").val();
	var pallet_height = $("#pallet_height").val();
	var gw = $("#gw").val();
	var volume = $("#volume").val();
	var md = $("#md").val();
	var ed = $("#ed").val();
	var work_order = $("#work_order").val();

	setTimeout(function () {
	$.ajax({
		url: base_url + "japan_ior/add_logistic_product_details",
		type: "POST",
		data: { 
				work_order: work_order,
				shipping_session: shipping_session,
				prod_log_id: prod_log_id,
				batch_number: batch_number,
				fda_no: fda_no,
				barcode: barcode,
				pallets: pallets,
				cases: cases,
				units: units,
				pallet_length: pallet_length,
				pallet_width: pallet_width,
				pallet_height: pallet_height,
				gw: gw,
				volume: volume,
				md: md,
				ed: ed
			},
		success: function (result) {

			setTimeout(function () {
				Toast.fire({
					icon: "success",
					position: "center",
					title:
						"Successfully added import logistics details!",
				});

				$('#add-product-details').modal('hide');
				$("#process_add_logistic").hide();
				$("#btn_add_logistic").show();
				$("#btn_close_logistic").show();
			}, 3000);

		},
		error: function () {
			Toast.fire({
				icon: "error",
				position: "center",
				title:
					"Sorry for the inconvenience, some errors found. Please contact administrator.",
			});
		},
	});

	}, 1000);


	event.preventDefault();


});

$( "#add_port_of_arrival" ).submit(function( event ) {

	$("#process_add_port_of_arrival").show();
	$("#button_done_process").hide();

	var shipping_session = $("#shipping_session").val();
	var street_address = $("#street_address").val();
	var address_line_2 = $("#address_line_2").val();
	var city = $("#city").val();
	var state = $("#state").val();
	var postal = $("#postal").val();
	var country_1 = $("#country_1").val();
	var user_id = $("#user_id").val();

	setTimeout(function () {
	$.ajax({
		url: base_url + "japan_ior/add_port_of_arrival_details",
		type: "POST",
		data: { 
				shipping_session: shipping_session,
				street_address: street_address,
				address_line_2: address_line_2,
				city: city,
				state: state,
				postal: postal,
				country_1: country_1,
				user_id: user_id,
			},
		success: function (result) {

			setTimeout(function () {
				Toast.fire({
					icon: "success",
					position: "center",
					title:
						"Successfully added Port of Arrival details!",
				});

				$('#logistic-details-modal').modal('hide');
				$("#process_add_port_of_arrival").hide();
				$("#button_done_process").show();
				$("#edit_logistic_form").show();
			}, 3000);

		},
		error: function () {
			Toast.fire({
				icon: "error",
				position: "center",
				title:
					"Sorry for the inconvenience, some errors found. Please contact administrator.",
			});
		},
	});

	}, 1000);


	event.preventDefault();


});