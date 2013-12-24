<div class="post">

	<?php foreach($profile as $prof): ?>

		<!--Only shows if it's default user-->
		<?php if($username): ?>
			<br>
			<a href="/users/editprofile" class='editprofile'>Edit Your Profile</a>
			<br>
		<?php endif; ?>

		<h1><?=$prof['first_name']?>'s Profile</h1>


		<p><b>Name: </b><?=$prof['first_name']?> <?=$prof['last_name']?></p>
		<p><b>Username: </b><?=$prof['username']?></p>
		<p><b>Nickname: </b><?=$prof['nickname']?></p>
		<p><b>Baked Good of Choice: </b><?=$prof['bakedgood']?></p>
		<p><b>Favorite Type of Cake: </b><?=$prof['cake']?></p>
		<p><b>Favorite Type of Cookies: </b><?=$prof['cookie']?></p>
		<p><b>Your Baking Advice Catchphrase: </b><?=$prof['bakingadvice']?></p>
		<p><b>Mini Bio: </b><?=$prof['bio']?></p>
		<p><b>Favorite Recipes: </b><?=$prof['recipes']?></p>


	<?php endforeach; ?>



</div>
<br><br>
