var url = $("#base").val();
var keys = $("#keys").val();
var stripe = Stripe(keys);
function billing_invoice_checkout(data) {
	if ($("#billing_invoice_terms").prop("checked") == false) {
		event.preventDefault();
		Toast.fire({
			icon: "error",
			position: "center",
			title: "Please accept our Terms and Conditions to continue payment.",
		});
	} else {
		$("#btn_billing_payment").hide();
		$("#btn-process-payment").show();
		fetch(url + "japan-ior/billing-invoice-checkout/" + data, {
			method: "POST",
		})
			.then(function (response) {
				return response.json();
			})
			.then(function (session) {
				return stripe.redirectToCheckout({ sessionId: session.id });
			})
			.then(function (result) {
				if (result.error) {
					alert(result.error.message);
				}
			})
			.catch(function (error) {
				console.error("Error:", error);
			});
	}
}
function product_label_checkout() {
	if ($("#product_label_fee_terms").prop("checked") == false) {
		event.preventDefault();
		Toast.fire({
			icon: "error",
			position: "center",
			title: "Please accept our Terms and Conditions to continue payment.",
		});
	} else {
		$("#btn_product_label_checkout").hide();
		$("#btn-process-payment").show();
		fetch(url + "japan-ior/product-label-checkout", {
			method: "POST",
		})
			.then(function (response) {
				return response.json();
			})
			.then(function (session) {
				return stripe.redirectToCheckout({ sessionId: session.id });
			})
			.then(function (result) {
				if (result.error) {
					alert(result.error.message);
				}
			})
			.catch(function (error) {
				console.error("Error:", error);
			});
	}
}

function ior_shipping_checkout(data1, data2) {
	if ($("#ior_fee_terms").prop("checked") == false) {
		event.preventDefault();
		Toast.fire({
			icon: "error",
			position: "center",
			title: "Please accept our Terms and Conditions to continue payment.",
		});
	} else {
		$("#ior_fee_checkout").hide();
		$("#btn-process-payment").show();
		fetch(url + "japan-ior/shipping-invoice-checkout/" + data1 + "/" + data2, {
			method: "POST",
		})
			.then(function (response) {
				return response.json();
			})
			.then(function (session) {
				return stripe.redirectToCheckout({ sessionId: session.id });
			})
			.then(function (result) {
				if (result.error) {
					alert(result.error.message);
				}
			})
			.catch(function (error) {
				console.error("Error:", error);
			});
	}
}
