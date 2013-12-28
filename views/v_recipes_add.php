<h2>Got a recipe you love? Paste in the link to add it to your favorites--then 
your fellow bakers can find it too!</h2>
<form method='POST' action='/recipes/p_add_recipes' id='linkform'>

    <textarea name='url' id='linktextfield' class="submissionfield" maxlength="160"></textarea>
    <br><br>
    <input type='submit' value='Add Your Recipe!' id='submit'>

</form> 
<br>
<!--Ajax results will go here -->
<div id="reciperesults"></div>

<br>
<h3>We accept recipes from...</h3>
<h4>
	<a href="http://allrecipes.com/" class="recipelinks">Allrecipes.com</a><br>
	<a href="http://www.epicurious.com/" class="recipelinks">Epicurious.com</a><br>
	<a href="http://www.simplyrecipes.com/" class="recipelinks">SimplyRecipes.com</a><br>
	<a href="http://www.tasteofhome.com/" class="recipelinks">TasteofHome.com</a><br>
	<a href="http://www.verybestbaking.com/" class="recipelinks">VeryBestBaking.com</a>
</h4>

<h5>Or... <a href="/recipes/add_your_own">add your own!</a></h5>
<br><br>