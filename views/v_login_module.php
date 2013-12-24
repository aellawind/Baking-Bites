<h2>To log in, please enter your email and password.</h2>

<form method='POST' action='/users/p_login'>

	Email: <input type='text' name='email'><br>
	Password: <input type='password' name ='password'><br><br>

	<?php if(isset($error)): ?>
		<div class='error'>
			Login failed. Please double check your email and password.
		</div>
		<br>
	<?php endif; ?>

	<input type='submit' name='submit' value='Log In' id='submit'>

</form>
<br>
