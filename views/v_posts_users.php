<h2>Who Is A Baker Worthy of Following?</h2>
<h3>You decide.</h3>
<br><br>
<?php foreach($users as $user): ?>

	<div class="follow">
	    <!-- Print this user's name -->
	    <a href='/users/profile/<?=$user['username']?>' class="userlink">
	    <?=$user['first_name']?> <?=$user['last_name']?>
	    </a>

	    <!-- If there exists a connection with this user, show a unfollow link -->
	    <?php if(isset($connections[$user['user_id']])): ?>
	    	<img src="http://3.bp.blogspot.com/-P87VGfPnOFo/Tsf86vgg4jI/AAAAAAAAAfM/1qy0e395Rww/s1600/Who+Took+the+Cookie+-+cookie.png" alt="Following!" class="small_image">
	        <a href='/posts/unfollow/<?=$user['user_id']?>' class="unfollow_button">Unfollow</a>

	    <!-- Otherwise, show the follow link -->
	    <?php else: ?>
	        <a href='/posts/follow/<?=$user['user_id']?>' class="follow_button">Follow</a>
	    <?php endif; ?>
    </div>
    <br><br>


<?php endforeach; ?>