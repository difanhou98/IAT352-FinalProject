$("document").ready(function () {
	$(".delete-button").click(function (event) {
		event.preventDefault();
		var content_id = this.classList[0];
		$.ajax({
			type: "POST",
			url: "remove.php",
			data: {
				content_id: content_id,
			},
			success: function (data) {
				$(event.target).closest("tr").remove();
				$("#msg").html(data);
				$("#msg").fadeOut(2000, function () {
					$(this).html("");
				});
			},
			error: function (jqxhr, status, exception) {
				console.log("Error " + exception);
			},
		});
	});
});
