<h2>Sign Up</h2>

<form method='POST' action ='/users/p_signup'>


	First Name<span style="color:red">*</span><br>
	<input type='text' name='first_name' class='submissionfield'><br><br>
	Last Name<span style="color:red">*</span><br>
	<input type='text' name='last_name' class='submissionfield'><br><br>
	Email<span style="color:red">*</span><br>
	<input type='text' name = 'email' class='submissionfield'><br><br>
	Username<span style="color:red">*</span><br>
	<input type='text' name = 'username' class='submissionfield'><br><br>
	Password (mimimum six characters)<span style="color:red">*</span><br>
	<input type='password' name='password' class='submissionfield'><br><br>

	<!-- The below is all error checking for the field inputs.-->
	<?php if($error == 'user-exists'): ?>
			<div class='error'>
				This user already exists. Please try again with a different e-mail address.
			</div>
			<br>
	<?php endif; ?>

	<?php if($error == 'username-exists'): ?>
			<div class='error'>
				This username already exists. Please try again with a different username.
			</div>
			<br>
	<?php endif; ?>

	<?php if($error == 'firstname_required'): ?>
			<div class='error'>
				Please enter your first name.
			</div>
			<br>
	<?php endif; ?>

	<?php if($error == 'lastname_required'): ?>
			<div class='error'>
				Please enter your last name.
			</div>
			<br>
	<?php endif; ?>

	<?php if($error == 'email_required'): ?>
			<div class='error'>
				Please enter your email address.
			</div>
			<br>
	<?php endif; ?>

	<?php if($error == 'username_required'): ?>
			<div class='error'>
				Please enter a username.
			</div>
			<br>
	<?php endif; ?>

	<?php if($error == 'password_required'): ?>
			<div class='error'>
				Please enter a password.
			</div>
			<br>
	<?php endif; ?>

	<?php if($error == 'short_password'): ?>
			<div class='error'>
				Please enter a password with six characters or more.
			</div>
			<br>
	<?php endif; ?>

	<input type='submit' value='Sign Up' id='submit'>


</form>
<br>
Items marked with <span style="color:red">*</span> are required.

