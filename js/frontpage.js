$(document).ready(function () {
	$("#type-filter, #popularity-filter").change(function () {
		//get dropdown selection value from html
		var type_filter = $("#type-filter").val();
		var popularity_filter = $("#popularity-filter").val();

		// chenge chart title based on dropdown selection
		if (type_filter == "*") {
			if (popularity_filter == "year") {
				$("#ranking-title").text("Top 10 Most Recent Contents");
			} else if (popularity_filter == "votes") {
				$("#ranking-title").text("Top 10 Most Voted Contents");
			} else if (popularity_filter == "rate") {
				$("#ranking-title").text("Top 10 Highest Rating Contents");
			}
		} else if (type_filter == "film") {
			if (popularity_filter == "year") {
				$("#ranking-title").text("Top 10 Most Recent Films");
			} else if (popularity_filter == "votes") {
				$("#ranking-title").text("Top 10 Most Voted Films");
			} else if (popularity_filter == "rate") {
				$("#ranking-title").text("Top 10 Highest Rating Films");
			}
		} else if (type_filter == "series") {
			if (popularity_filter == "year") {
				$("#ranking-title").text("Top 10 Most Recent Series");
			} else if (popularity_filter == "votes") {
				$("#ranking-title").text("Top 10 Most Voted Series");
			} else if (popularity_filter == "rate") {
				$("#ranking-title").text("Top 10 Highest Rating Series");
			}
		}

		$.ajax({
			type: "POST",
			url: "frontpage_process.php",
			data: {
				type_filter: type_filter,
				popularity_filter: popularity_filter,
			},
			beforeSend: function (data) {
				$("#frontpage-table").html("<span>Processing...</span>");
			},
			success: function (data) {
				$("#frontpage-table").html(data);
				//console.log("Ajax runs");
			},
			error: function (jqxhr, status, exception) {
				console.log("Error " + exception);
			},
		});
	});
});
