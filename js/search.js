$(document).ready(function () {
	var page;
	$("#search-button").click(function () {
		//get dropdown selection value from html
		var keyword = $("#keyword").val();
		// process checkbox value: https://stackoverflow.com/questions/51719341/jquery-ajax-send-multiple-checkbox-values-to-php
		var category_arr = [];
		$.each($("input[name='category']:checked"), function () {
			category_arr.push($(this).val());
		});
		var nudity_filter = $("#nudity-filter").val();
		var violence_filter = $("#violence-filter").val();
		var profanity_filter = $("#profanity-filter").val();
		var alcohol_filter = $("#alcohol-filter").val();
		var frightening_filter = $("#frightening-filter").val();
		var type_filter = $("#type-filter").val();
		var popularity_filter = $("#popularity-filter").val();

		$.ajax({
			type: "POST",
			url: "search_process.php",
			data: {
				keyword: keyword,
				category_arr: category_arr,
				nudity_filter: nudity_filter,
				violence_filter: violence_filter,
				profanity_filter: profanity_filter,
				alcohol_filter: alcohol_filter,
				frightening_filter: frightening_filter,
				type_filter: type_filter,
				popularity_filter: popularity_filter,
				//page: page,
			},
			beforeSend: function (data) {
				$("#search-table").html("<span>Query Processing...</span>");
			},
			success: function (data) {
				$("#search-table").html(data);
				//console.log("Ajax runs");
			},
			error: function (jqxhr, status, exception) {
				console.log("Error " + exception);
			},
		});
	});

	// //load_data();
	// function load_data(page) {
	// 	$.ajax({
	// 		url: "search_process.php",
	// 		method: "POST",
	// 		data: { page: page },
	// 		success: function (data) {
	// 			$("#search-table").html(data);
	// 		},
	// 	});
	// }

	// $(document).on("click", ".pagination-link", function () {
	// 	page = $(this).attr("id");
	// 	load_data(page);
	// });
});
