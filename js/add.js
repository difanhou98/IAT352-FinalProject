$(document).ready(function () {
	$("#add-button").on("click", function (event) {
		event.preventDefault();
		var content_id = $("#add-button").attr("class");
		var date_added = new Date().toISOString().slice(0, 10);
		$.ajax({
			type: "post",

			url: "add.php",
			data: {
				content_id: content_id,
				date_added: date_added,
			},
			success: function (data) {
				$("#add-button").val("Added");
				$("#add-button").prop("disabled", true);
				$("#msg").html(data);
				$("#msg").fadeOut(10000, function () {
					$(this).html("");
				});
				//console.log("Ajax runs");
			},
			error: function (jqxhr, status, exception) {
				console.log("Error " + exception);
			},
		});
	});
});
