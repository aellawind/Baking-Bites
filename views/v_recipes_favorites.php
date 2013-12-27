<div class="recipes">

	<h2><?=$user->first_name ?>'s Favorite Recipes</h2>
	<?php foreach($favoriterecipes as $favorite): ?>

		<div class="faverecipe">
		<a href="/recipes/removefavorites/<?=$favorite['recipe_id_favorited']?>" class="favoriterecipe">Remove Favorite</a>
		<a href='/recipes/recipe/<?=$favorite['recipe_id_favorited']?>' id="recipelinks"><?=$favorite['title']?></a>
		</div>
		<br>


	<?php endforeach; ?>


</div>
<br><br>
