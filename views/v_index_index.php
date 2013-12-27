<div id="main_page">
						
	<?php if(!$user): ?>
		<h1>Welcome to Baking Bites!</h1>
		Ever dying to bake something, but it's 3am and no grocery stores are open? What can you bake with the 
		few items lurking around your pantry, you ask yourself? Two bananas, eggs, a chocolate bar, and sugar are all
		you have. Yes, you could peruse the internet until you find just the perfect recipe that needs no more 
		and no less than what you have, or you could search up Baking Bites! Baking Bites is the perfect place 
		to share your favorite recipes and to find the perfect recipe for your pantry. Sign up now to search through a
		huge database of recipes from all over the web.
		<!--Display the login module-->
		<?php echo $login; ?>

		<p>If you are not yet a member, please <a href="/users/signup" class="userlink">sign up</a>!</p>


	<?php else: ?>
		<h1>Welcome Back to Baking Bites, <?=$user->first_name ?>!</h1>
		<p>
		Ever dying to bake something, but it's 3am and no grocery stores are open? What can you bake with the 
		few items lurking around your pantry, you ask yourself? Two bananas, eggs, a chocolate bar, and sugar are all
		you have. Yes, you could peruse the internet until you find just the perfect recipe that needs no more 
		and no less than what you have, or you could search up Baking Bites! Baking Bites is the perfect place 
		to share your favorite recipes and to find the perfect recipe for your pantry. Search for the perfect recipe, bake it,
		and add it to your favorites!
		</p>
		<img src="http://1.bp.blogspot.com/-8w4STtQghvo/Umk-uf1ChiI/AAAAAAAABcw/8-Fh_fjnIVE/s1600/DSC_1017.JPG" height="222" width="335" alt="cake">
		<br><br>
	<?php endif; ?>

	
	
</div>