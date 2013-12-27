<div class="margined"><h2>Dying to bake, but not sure what you can make? Enter up to five search terms
to find the best recipe for you!</h2></div>
<h3>Rank your ingredients in order of importance.</h3>
<br>
<form method='POST' action ='/recipes/p_search' id="searchform">

		<input type='text' name='ingredient1' placeholder='First Ingredient' class="submissionfield ingredientsform"><br><br>
		<input type='text' name='ingredient2' placeholder='Second Ingredient' class="submissionfield ingredientsform"><br><br>
		<input type='text' name='ingredient3' placeholder='Third Ingredient' class="submissionfield ingredientsform"><br><br>
		<input type='text' name='ingredient4' placeholder='Fourth Ingredient' class="submissionfield ingredientsform"><br><br>
		<input type='text' name='ingredient5' placeholder='Fifth Ingredient' class="submissionfield ingredientsform"><br><br>
		<input type='submit' value='Search' id='submit'>


</form>
<br>
<div id="searchresults"></div>