<h1>Got something cooking in the oven? Let it out!</h1>
<form method='POST' action='/posts/p_add'>

    <textarea name='content' id='bigtextfield' class="submissionfield"></textarea>
    <br>
    <input type='submit' value='New Post' id='submit'>

</form> 

<!--Display all of your posts in one list.-->
<?php foreach($posts as $post): ?>

	<div class="post">
		<!--Delete button-->
		<a href="/posts/delete/<?=$post['post_id']?>" class="deletepost">Delete Post</a>

		<!--Shows post content-->
		<p class="name">You ( <?=$user->first_name ?>  <?=$user->last_name ?>) posted:</p>
		<p><?=$post['content']?></p>
		<time datetime="<?=Time::display($post['created'],'Y-m-d G:i')?>" class="small">
		<?=Time::display($post['created'])?></time><br>   
	</div>

<?php endforeach; ?>

<br><br>