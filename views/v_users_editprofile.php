<div class ="profile">

<?php foreach($profileinfo as $info): ?>

	<p>Hello, <?=$user->first_name ?> !</p>

	<p>Fill in the following fields to update your profile. None of the fields are required.</p>

	<form method='POST' action ='/users/p_profile'>

		First Name: <input type='text' name='first_name' placeholder='<?=$info['first_name']?>' class="submissionfield"><br><br>
		Last Name: <input type='text' name='last_name' placeholder='<?=$info['last_name']?>' class="submissionfield"><br><br>
		Baked Good of Choice: <input type='text' name='bakedgood' placeholder='<?=$info['bakedgood']?>' class="submissionfield"><br><br>
		Favorite Type of Cake: <input type='text' name='cake' placeholder='<?=$info['cake']?>' class="submissionfield"><br><br>
		Favorite Type of Cookies: <input type='text' name='cookie' placeholder='<?=$info['cookie']?>' class="submissionfield"><br><br>
		Your Baking Advice Catchphrase!: <input type='text' placeholder='<?=$info['bakingadvice']?>' name='bakingadvice' class="submissionfield"><br><br>
		Mini Bio: <br><textarea  name='bio' placeholder='<?=$info['bio']?>' class="submissionfield" ></textarea><br><br>
		
		<input type='submit' value='Submit Profile' id='submit'>


	</form>

<?php endforeach; ?>


</div>
<br><br>