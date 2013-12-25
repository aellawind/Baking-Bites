<div class ="recipe">

	<p>Hello, <?=$user->first_name ?> !</p>

	<p>Fill in the following fields to add your own recipe! All fields are required.</p>

	<form method='POST' action ='/recipes/p_add_your_own' onsubmit="return checkSize(2097152)" id="recipeform">

		Title<BR> <input type='text' name='title' class="submissionfield"><br><br>
		Ingredients<BR> <textarea name='ingredients_list' class="submissionfield bigtextfield"></textarea><br><br>
		Directions<BR> <textarea name='directions_list' class="submissionfield bigtextfield"></textarea><br><br>
		Image<BR> <input type='file' name='recipeimages' value='file' id="upload"><br><br>
		
		<input type='submit' value='Submit Your Recipe' id='submit'>


	</form>
<br>
	<!--Ajax results will go here -->
	<div id="ownrecipe"></div>
<br><br><br>
</div>
<br><br>

