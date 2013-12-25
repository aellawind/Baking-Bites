// Set up the options for ajax
var options = {
	type: 'POST',
	url: '/recipes/p_add_your_own/',
	beforeSubmit: function () {
		$('#ownrecipe').html("Adding your recipe..."); 
	},
	success: function(response) {

		if (response=="Your recipe was added.") {
			$("#recipeform")[0].reset();
			$('#ownrecipe').html(response);
			$('#ownrecipe').css('color', '#A52A2A');
		}
		else {
			$('#ownrecipe').html(response);
			$('#ownrecipe').css('color', 'red');
		}
	}
};

// Using the above options, ajaxify the form
$('form').ajaxForm(options);