// Set up the options for ajax
var options = {
	type: 'POST',
	url: '/recipes/p_search/',
	beforeSubmit: function () {
		$('#searchresults').html("Searching for a recipe..."); 
	},
	success: function(response) {

		if (response) {
			if (response.indexOf("Please enter at least one ingredient.") > -1) {
				$('#searchresults').html(response);
				$('#searchresults').css('color', '#A52A2A');
			}
			else {
				$('#searchresults').css('color', '#555753');
				$('#searchresults').html(response);
				$('html, body').animate({ scrollTop: 850 }, 0);
			}

		}
		else {
			$('#searchresults').html("Sorry, there are no relevant search results. Try again with less keywords.");
			$('#searchresults').css('color', 'red');
		}
	}
};

// Using the above options, ajaxify the form
$('form').ajaxForm(options);