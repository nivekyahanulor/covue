function formatDollar(num) {
	var p = parseFloat(num).toFixed(2).split(".");
	return (
		"$" +
		p[0]
			.split("")
			.reverse()
			.reduce(function (acc, num, i, orig) {
				return num == "-" ? acc : num + (i && !(i % 3) ? "," : "") + acc;
			}, "") +
		"." +
		p[1]
	);
}

function comma(ctrl) {
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

function iorLabelFee(ior_category, ior_label) {
	if (ior_category == "Non-regulated" || ior_category == "Japan Radio") {
		total = ior_label * 4.95;
	} else {
		total = ior_label * 100;
	}
	$("#ior_label_total").html(
		'<div class="col-md-12 col-12"> <table width="100%">' +
			"<tr><td><h4>PRODUCT LABEL FEES</h4></td></tr> " +
			'<tr><td>Japan Compliant Product label</td> <td style="text-align:right;"> ' +
			formatDollar(total) +
			" </td></tr></table></div>"
	);
}

function shippingFee(category, ior_import_val) {
	var under = "";
	var import_vals = "";
	var import_val = "";

	if (
		category == "Non-regulated" ||
		category == "Supplemental PSE" ||
		category == "Japan Radio"
	) {
		if (ior_import_val == 1 || ior_import_val <= 500000) {
			under = "Under 500,000 ¥ in value";
			import_val = 26.25;
		} else if (ior_import_val == 500001 || ior_import_val <= 1000000) {
			under = "Under 1,000,000 ¥ in value";
			import_val = 36.75;
		} else if (ior_import_val == 1000001 || ior_import_val <= 2500000) {
			under = "Under 2,500,000 ¥ in value";
			import_val = 47.25;
		} else if (ior_import_val == 2500001 || ior_import_val <= 5000000) {
			under = "Under 5,000,000 ¥ in value";
			import_val = 57.25;
		} else if (ior_import_val == 5000001 || ior_import_val <= 10000000) {
			under = "Under 10,000,000 ¥ in value";
			import_val = 99.75;
		} else if (ior_import_val >= 10000001) {
			under = "Over 10,000,000 ¥ in value";
			import_vals = parseFloat(ior_import_val) * 0.00125;
			import_val = parseFloat(import_vals) / 100;
		}
	} else if (
		category == "Food Apparatus" ||
		category == "Food Import - Food Supplement" ||
		category == "Shelf Stable Food" ||
		category == "CBD"
	) {
		if (ior_import_val == 1 || ior_import_val <= 500000) {
			under = "Under 500,000 ¥ (application replication no changes) ";
			import_val = 276.25;
		} else if (ior_import_val == 500001 || ior_import_val <= 1000000) {
			under = "Under 1,000,000 ¥ in value";
			import_val = 286.75;
		} else if (ior_import_val == 1000001 || ior_import_val <= 2500000) {
			under = "Under 2,500,000 ¥ in value";
			import_val = 297.25;
		} else if (ior_import_val == 2500001 || ior_import_val <= 5000000) {
			under = "Under 5,000,000 ¥ in value";
			import_val = 307.35;
		} else if (ior_import_val == 5000001 || ior_import_val <= 10000000) {
			under = "Under 10,000,000 ¥ in value";
			import_val = 349.75;
		} else if (ior_import_val >= 10000001) {
			under = "Over 10,000,000 ¥ in value";
			import_vals = parseFloat(ior_import_val) * 0.0035;
			import_val = parseFloat(import_vals) / 100;
		}
	} else if (category == "Toys under 6 years old and Baby products") {
		if (ior_import_val == 1 || ior_import_val <= 500000) {
			under = "Under 500,000 ¥ (application replication no changes) ";
			import_val = 276.25;
		} else if (ior_import_val == 500001 || ior_import_val <= 1000000) {
			under = "Under 1,000,000 ¥ in value";
			import_val = 286.75;
		} else if (ior_import_val == 1000001 || ior_import_val <= 2500000) {
			under = "Under 2,500,000 ¥ in value";
			import_val = 297.25;
		} else if (ior_import_val == 2500001 || ior_import_val <= 5000000) {
			under = "Under 5,000,000 ¥ in value";
			import_val = 307.35;
		} else if (ior_import_val == 5000001 || ior_import_val <= 10000000) {
			under = "Under 10,000,000 ¥ in value";
			import_val = 349.75;
		} else if (ior_import_val >= 10000001) {
			under = "Over 10,000,000 ¥ in value";
			import_vals = parseFloat(ior_import_val) * 0.0035;
			import_val = parseFloat(import_vals) / 100;
		} else if (ior_import_val == 0 || ior_import_val == " ") {
			import_val = 0;
		}
	} else if (category == "Cosmetics and Personal Care") {
		if (ior_import_val == 0 || ior_import_val == "") {
			under = "Up to 99M  ¥ per year in value";
			import_val = 0;
		} else if (ior_import_val == 99999999 || ior_import_val <= 100000000) {
			under = "Up to 99M  ¥ per year in value";
			import_vals = parseFloat(ior_import_val) * 0.05;
			import_val = parseFloat(import_vals) / 100;
		} else if (ior_import_val >= 100000001) {
			under = "over 100M ¥ per year in value";
			import_vals = parseFloat(ior_import_val) * 0.03;
			import_val = parseFloat(import_vals) / 100;
		}
	} else if (category == "Quasi Drugs") {
		if (ior_import_val == 0 || ior_import_val == "") {
			under = "Up to 99M  ¥ per year in value";
			import_val = 0;
		} else if (ior_import_val == 99999999 || ior_import_val <= 100000000) {
			under = "Up to 99M  ¥ per year in value";
			import_vals = parseFloat(ior_import_val) * 0.05;
			import_val = parseFloat(import_vals) / 100;
		} else if (ior_import_val >= 100000001) {
			under = "over 100M ¥ per year in value";
			import_vals = parseFloat(ior_import_val) * 0.03;
			import_val = parseFloat(import_vals) / 100;
		}
	} else if (category == "Class 1 Medical Devices") {
		if (ior_import_val == 0 || ior_import_val == "") {
			under = "Up to 99M  ¥ per year in value";
			import_val = 0;
		} else if (ior_import_val == 99999999 || ior_import_val <= 100000000) {
			under = "Up to 99M ¥ per year in value";
			import_vals = parseFloat(ior_import_val) * 0.07;
			import_val = parseFloat(import_vals) / 100;
		} else if (ior_import_val >= 100000001) {
			under = "over 100M ¥ per year in value";
			import_vals = parseFloat(ior_import_val) * 0.05;
			import_val = parseFloat(import_vals) / 100;
		}
	} else if (category == "Class 2 Medical Devices") {
		if (ior_import_val == 0 || ior_import_val == "") {
			under = "Up to 99M  ¥ per year in value";
			import_val = 0;
		} else if (ior_import_val == 99999999 || ior_import_val <= 100000000) {
			under = "Up to 99M ¥ per year in value";
			import_vals = parseFloat(ior_import_val) * 0.07;
			import_val = parseFloat(import_vals) / 100;
		} else if (ior_import_val >= 100000001) {
			under = "over 100M ¥ per year in value";
			import_vals = parseFloat(ior_import_val) * 0.05;
			import_val = parseFloat(import_vals) / 100;
		}
	}
	$("#ior_shipping_fees").html(
		'<div class="col-md-12 col-12"><br> <table width="100%">' +
			"<tr><td><h4>IOR SHIPPING FEES</h4></td></tr> " +
			"<tr><td>" +
			under +
			'</td> <td style="text-align:right;"> ' +
			formatDollar(import_val) +
			" </td></tr></table></div>"
	);
}

$("#btn-calculate").click(function () {
	var ior_category = $("#ior_category").val();
	var ior_label = $("#ior_label").val();
	var ior_iv = $("#ior_import_value").val();
	var ior_import_val = ior_iv.replace(/,/g, "");

	$.ajax({
		type: "POST",
		url: "get_category_details",
		data: { category: ior_category },
		success: function (data) {
			$("#category_result").html(data);
		},
	});

	iorLabelFee(ior_category, ior_label);
	shippingFee(ior_category, ior_import_val);
});

$(document).ready(function () {
	iorcategory = $("#ior_category").val();
	ior_import_val = $("#ior_import_value").val().replace(/,/g, "");
	$.ajax({
		type: "POST",
		url: "get_category_details",
		data: { category: iorcategory },
		success: function (data) {
			$("#category_result").html(data);
		},
	});

	if (
		iorcategory == "Cosmetics and Personal Care" ||
		iorcategory == "Quasi Drugs" ||
		iorcategory == "Class 1 Medical Devices" ||
		iorcategory == "Class 2 Medical Devices"
	) {
		$("#product_label").hide();
		$("#ior_label_total").hide();
		$("#ior_label").prop("required", false);
	} else {
		$("#product_label").show();
		$("#ior_label_total").show();
		$("#ior_label").prop("required", true);
	}

	// IOR PRODUCT LABEL //
	ior_label = $("#ior_label").val();
	iorLabelFee(iorcategory, ior_label);

	// SHIPPING FEE - IMPORT VALUE //
	shippingFee(iorcategory, ior_import_val);

	// E-COMMERCE SERVICES //
	// AMAZON CHECKLIST	//
	$(".check1").change(function () {
		amazon = document.getElementById("amazon_total").innerText;
		if (this.checked) {
			$("#check1").show();
			value = parseFloat(amazon.replace(/[$,]/g, "")) + 750;
			$("#amazon_total").text(formatDollar(value));
		} else {
			$("#check1").hide();
			value = parseFloat(amazon.replace(/[$,]/g, "")) - 750;
			$("#amazon_total").text(formatDollar(value));
		}
	});
	$(".check2").change(function () {
		amazon = document.getElementById("amazon_total").innerText;
		if (this.checked) {
			$("#check2").show();
			value = parseFloat(amazon.replace(/[$,]/g, "")) + 500;
			$("#amazon_total").text(formatDollar(value));
		} else {
			$("#check2").hide();
			value = parseFloat(amazon.replace(/[$,]/g, "")) - 500;
			$("#amazon_total").text(formatDollar(value));
		}
	});
	$(".check3").change(function () {
		amazon = document.getElementById("amazon_total").innerText;
		if (this.checked) {
			$("#check3").show();
			value = parseFloat(amazon.replace(/[$,]/g, "")) + 500;
			$("#amazon_total").text(formatDollar(value));
		} else {
			$("#check3").hide();
			value = parseFloat(amazon.replace(/[$,]/g, "")) - 500;
			$("#amazon_total").text(formatDollar(value));
		}
	});
	$(".check4").change(function () {
		amazon = document.getElementById("amazon_total").innerText;
		if (this.checked) {
			$("#check4").show();
			value = parseFloat(amazon.replace(/[$,]/g, "")) + 225;
			$("#amazon_total").text(formatDollar(value));
		} else {
			$("#check4").hide();
			value = parseFloat(amazon.replace(/[$,]/g, "")) - 225;
			$("#amazon_total").text(formatDollar(value));
		}
	});
	$(".check5").change(function () {
		amazon = document.getElementById("amazon_total").innerText;
		if (this.checked) {
			$("#check5").show();
			value = parseFloat(amazon.replace(/[$,]/g, "")) + 675;
			$("#amazon_total").text(formatDollar(value));
		} else {
			$("#check5").hide();
			value = parseFloat(amazon.replace(/[$,]/g, "")) - 675;
			$("#amazon_total").text(formatDollar(value));
		}
	});
	$(".check6").change(function () {
		amazon = document.getElementById("amazon_total").innerText;
		if (this.checked) {
			$("#check6").show();
			value = parseFloat(amazon.replace(/[$,]/g, "")) + 0;
			$("#amazon_total").text(formatDollar(value));
		} else {
			$("#check6").hide();
			value = parseFloat(amazon.replace(/[$,]/g, "")) - 0;
			$("#amazon_total").text(formatDollar(value));
		}
	});
	$(".check7").change(function () {
		amazon = document.getElementById("amazon_total").innerText;
		if (this.checked) {
			$("#check7").show();
			value = parseFloat(amazon.replace(/[$,]/g, "")) + 0;
			$("#amazon_total").text(formatDollar(value));
		} else {
			$("#check7").hide();
			value = parseFloat(amazon.replace(/[$,]/g, "")) - 0;
			$("#amazon_total").text(formatDollar(value));
		}
	});
	$(".check8").change(function () {
		amazon = document.getElementById("amazon_total").innerText;
		if (this.checked) {
			$("#check8").show();
			value = parseFloat(amazon.replace(/[$,]/g, "")) + 0;
			$("#amazon_total").text(formatDollar(value));
		} else {
			$("#check8").hide();
			value = parseFloat(amazon.replace(/[$,]/g, "")) - 0;
			$("#amazon_total").text(formatDollar(value));
		}
	});
	$(".check13").change(function () {
		amazon = document.getElementById("amazon_total").innerText;
		if (this.checked) {
			$("#check13").show();
			value = parseFloat(amazon.replace(/[$,]/g, "")) + 450;
			$("#amazon_total").text(formatDollar(value));
		} else {
			$("#check13").hide();
			value = parseFloat(amazon.replace(/[$,]/g, "")) - 450;
			$("#amazon_total").text(formatDollar(value));
		}
	});
	$(".check14").change(function () {
		amazon = document.getElementById("amazon_total").innerText;
		if (this.checked) {
			$("#check14").show();
			value = parseFloat(amazon.replace(/[$,]/g, "")) + 540;
			$("#amazon_total").text(formatDollar(value));
		} else {
			$("#check14").hide();
			value = parseFloat(amazon.replace(/[$,]/g, "")) - 540;
			$("#amazon_total").text(formatDollar(value));
		}
	});
	$(".check15").change(function () {
		amazon = document.getElementById("amazon_total").innerText;
		if (this.checked) {
			$("#check15").show();
			value = parseFloat(amazon.replace(/[$,]/g, "")) + 1050;
			$("#amazon_total").text(formatDollar(value));
		} else {
			$("#check15").hide();
			value = parseFloat(amazon.replace(/[$,]/g, "")) - 1050;
			$("#amazon_total").text(formatDollar(value));
		}
	});

	// RAKUTEN CHECKLIST //
	$(".check9").change(function () {
		if (this.checked) {
			$("#check9").show();
		} else {
			$("#check9").hide();
		}
	});
	$(".check10").change(function () {
		if (this.checked) {
			$("#check10").show();
		} else {
			$("#check10").hide();
		}
	});
	$(".check11").change(function () {
		if (this.checked) {
			$("#check11").show();
		} else {
			$("#check11").hide();
		}
	});
	$(".check12").change(function () {
		if (this.checked) {
			$("#check12").show();
		} else {
			$("#check12").hide();
		}
	});
});
$("#quoatecategory").on("change", function () {
	if (this.value == "Importer of Record (IOR)") {
		$("#ior").show();
		$("#ior_result").show();

		$("#ecommerce").hide();
		$("#ecommerce_result").hide();
		$("#jbsetup").hide();
		$("#content-other-services").hide();
		$("#otherservices").hide();

		// ** ADD  ATTRIBUTES ** //
		$("#ior_label").prop("required", true);
		$("#ior_import_value").prop("required", true);
		$("#ecommerce_platform").prop("required", false);
	} else if (this.value == "e-Commerce") {
		$("#ecommerce").show();
		$("#ecommerce_result").show();
		$("#ior_result").hide();
		$("#jbsetup").hide();
		$("#ior").hide();
		$("#otherservices").hide();
		$("#content-other-services").hide();

		// ** ADD  ATTRIBUTES ** //
		$("#ecommerce_platform").prop("required", true);
		$("#ior_label").prop("required", false);
		$("#ior_import_value").prop("required", false);
	} else if (this.value == "Japan Business Set-up") {
		$("#jbsetup").show();
		$("#ior").hide();
		$("#ior_result").hide();
		$("#ecommerce").hide();
		$("#ecommerce_result").hide();
		$("#otherservices").hide();
		$("#content-other-services").hide();
	} else if (this.value == "Other Services") {
		$("#otherservices").show();
		$("#jbsetup").show();
		$("#content-other-services").show();

		$("#ior").hide();
		$("#ior_result").hide();
		$("#ecommerce").hide();
		$("#ecommerce_result").hide();
	}
});
$("#ior_category").on("change", function () {
	$.ajax({
		type: "POST",
		url: "get_category_details",
		data: { category: this.value },
		success: function (data) {
			$("#category_result").html(data);
		},
	});

	ior_import_val = $("#ior_import_value").val().replace(/,/g, "");
	ior_label = $("#ior_label").val();

	//** Shipping Fee Computation */

	shippingFee(this.value, ior_import_val);

	iorLabelFee(this.value, ior_label);

	if (
		this.value == "Cosmetics and Personal Care" ||
		this.value == "Quasi Drugs" ||
		this.value == "Class 1 Medical Devices" ||
		this.value == "Class 2 Medical Devices"
	) {
		$("#product_label").hide();
		$("#ior_label_total").hide();
		$("#ior_label").prop("required", false);
	} else {
		$("#product_label").show();
		$("#ior_label_total").show();
		$("#ior_label").prop("required", true);
	}
});

//** E-Commerce Platform Change Function */

$("#ecommerce_platform").on("change", function () {
	if (this.value == "Amazon") {
		$("#amazon").show();
		$("#rakuten").hide();
		$("#table_amazon").show();
		$("#table_amazon_ior").show();
		$("#table_rakuten").hide();
		$("#total_amazon").show();
		$("#total_rakuten").hide();
		$("#register_btn").show();
		$("#totalamazon").show();
		$("#totalrakuten").hide();
		$("#contact_btn").hide();
		$("#table_amazon").attr("style", "width:100%;");
		$("#table_amazon_ior").attr("style", "width:100%;");
	} else if (this.value == "Rakuten") {
		$("#rakuten").show();
		$("#amazon").hide();
		$("#table_amazon").hide();
		$("#table_amazon_ior").hide();
		$("#table_rakuten").show();
		$("#total_amazon").hide();
		$("#total_rakuten").show();
		$("#register_btn").hide();
		$("#contact_btn").show();
		$("#totalamazon").hide();
		$("#totalrakuten").show();
		$("#table_rakuten").attr("style", "width:100%;");
	}
});

//** IOR LABEL FEES Auto Computation */
$("#ior_label").on("input", function (e) {
	ior_label = this.value;
	ior_category = $("#ior_category").val();
	iorLabelFee(ior_category, ior_label);
});
// $("#ior_import_value").on("change", function (e) {
// ior_import_val = this.value.replace(/,/g, "");
// ior_category = $("#ior_category").val();
// shippingFee(ior_category, ior_import_val);
// });
