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
<a href="http://allrecipes.com/" id="recipelinks">Allrecipes.com</a><br>
<a href="http://www.epicurious.com/" id="recipelinks">Epicurious.com</a><br>
<a href="http://www.simplyrecipes.com/" id="recipelinks">SimplyRecipes.com</a><br>
<a href="http://www.tasteofhome.com/" id="recipelinks">TasteofHome.com</a><br>
<a href="http://www.verybestbaking.com/" id="recipelinks">VeryBestBaking.com</a>
</h4>