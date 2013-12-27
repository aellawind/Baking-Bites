// Set up the options for ajax
var options = {
	type: 'POST',
	url: '/recipes/p_search/',
	beforeSubmit: function () {
		$('#searchresults').html("Searching for a recipe..."); 
	},
	success: function(response) {

		if (response) {
			//var data  =$.parseJSON(response)
			$("#searchform")[0].reset();
			$('#searchresults').html(response);
			$('#searchresults').css('color', '#A52A2A');
		}
		else {
			$('#searchresults').html("Sorry, there are no relevant search results. Try again with less keywords.");
			$('#searchresults').css('color', 'red');
		}
	}
};

// Using the above options, ajaxify the form
$('form').ajaxForm(options);