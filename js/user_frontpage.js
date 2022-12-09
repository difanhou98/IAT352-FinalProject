$(document).ready(function () {
	$("#user-custom-filter").change(function () {
		//get dropdown selection value from html
		var user_custom_filter = $("#user-custom-filter").val();

		$.ajax({
			type: "POST",
			url: "user_frontpage_process.php",
			data: {
				user_custom_filter: user_custom_filter,
			},
			beforeSend: function (data) {
				$("#user-custom-table").html("<span>Processing...</span>");
			},
			success: function (data) {
				$("#user-custom-table").html(data);
				//console.log("Ajax runs");
			},
			error: function (jqxhr, status, exception) {
				console.log("Error " + exception);
			},
		});
	});
});
