<div class ="post">

	<p>Hello, <?=$user->first_name ?> !</p>

	<p>Fill in the following fields to update your profile. None of the fields are required.</p>

	<form method='POST' action ='/users/p_profile'>

		First Name: <input type='text' name='first_name' class="submissionfield"><br><br>
		Last Name: <input type='text' name='last_name' class="submissionfield"><br><br>
		Nickname: <input type='text' name='nickname' class="submissionfield"><br><br>
		Baked Good of Choice: <input type='text' name='bakedgood' class="submissionfield"><br><br>
		Favorite Type of Cake: <input type='text' name='cake' class="submissionfield"><br><br>
		Favorite Type of Cookies: <input type='text' name='cookie' class="submissionfield"><br><br>
		Your Baking Advice Catchphrase!: <input type='text' name='bakingadvice' class="submissionfield"><br><br>
		Mini Bio: <br><textarea  name='bio' class="submissionfield"></textarea><br><br>
		Share some links to your favorite recipes: <br><textarea name='recipes' class="submissionfield"></textarea><br><br>

		<input type='submit' value='Submit Profile' id='submit'>


	</form>

</div>
<br><br>