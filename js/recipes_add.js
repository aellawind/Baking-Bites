// Set up the options for ajax
var options = {
	type: 'POST',
	url: '/recipes/p_add_recipes/',
	beforeSubmit: function () {
		$('#reciperesults').html("Looking for your recipe..."); 
	},
	success: function(response) {

		if (response=="Your post was added.") {
			$("#linkform")[0].reset();
			$('#reciperesults').html(response);
			$('#reciperesults').css('color', '#A52A2A');
		}
		else {
			$('#reciperesults').html(response);
			$('#reciperesults').css('color', 'red');
		}
	}
};

// Using the above options, ajaxify the form
$('form').ajaxForm(options);