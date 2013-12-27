<div class="recipe">

	<?php if($error): ?>
		<p class = "margined">Sorry, the recipe you are looking for does not exist.</p>
	<?php endif;?>


	<?php foreach($recipe as $rec): ?>

		<!-- If user has already added this to their favorites, they can see the 'remove button'-->
		<?php if(isset($connections[$rec['recipe_id']])): ?>
			<a href="/recipes/removefavorites/<?=$rec['recipe_id']?>" class="favoriterecipe">Remove Favorite</a>

		<?php else: ?>
			<a href="/recipes/addfavorites/<?=$rec['recipe_id']?>" class="favoriterecipe">Add To Favorites</a>
		<?php endif; ?>


		<!-- Basic information for the recipe -->
		<h1><?=$rec['title']?></h1>

		<?php if($rec['image_url'] != ""): ?>
			<img src="<?=$rec['image_url']?>" class="recipe_image"/>
		<?php endif;?>
		<?php if($rec['recipeimages']): ?>
			<img src="<?=$rec['recipeimages']?>" class="recipe_image"/>
		<?php endif;?>

		<p><b>Ingredients: </b><br><?=$rec['ingredients_list']?></p>
		<p><b>Directions: <br></b><?=$rec['directions_list']?></p>
		<p><b>Added by: </b><?=$rec['source']?></p>
		<?php if($rec['url']): ?>
			<p class="small">Taken from <a href='<?=$rec['url']?>' id="recipelinks"><?=$rec['url']?></a></p>
		<?php endif;?>

		<!-- If the user added this recipe, they can delete it-->
		<?php if($thisuserrecipe == "True"): ?>
			<a href="/recipes/remove_your_own/<?=$rec['recipe_id']?>" class="removelinks">Remove Your Recipe</a>
		<?php endif;?>



	<?php endforeach; ?>



</div>
<br><br>
