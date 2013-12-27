<div class="recipes">


	<h2><?=$user->first_name ?>'s Favorite Recipes</h2>

	<?php if(!$favoriterecipes): ?>
		<p class="margined">   You have no favorite recipes at this time. Search for some <a href='/recipes/search'>here</a> to add recipes to your collection!</p>
	<?php endif ?>
	<?php foreach($favoriterecipes as $favorite): ?>

		<div class="faverecipe">
		<a href="/recipes/removefavorites/<?=$favorite['recipe_id_favorited']?>" class="favoriterecipe">Remove Favorite</a>
		<a href='/recipes/recipe/<?=$favorite['recipe_id_favorited']?>' id="recipelinks"><?=$favorite['title']?></a>
		</div>
		<br>


	<?php endforeach; ?>


</div>
<br><br>
