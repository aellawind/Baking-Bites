<?php

class posts_controller extends base_controller {

    public function __construct() {
        parent::__construct();

        # Make sure user is logged in if they want to use anything in this controller
        if(!$this->user) {
            Router::redirect("/");
        
        }
    }

    # This is the page where users can add a post and also see the posts they've already added.
    public function add() {

        # Setup view
        $this->template->content = View::instance('v_posts_add');
        $this->template->title   = "Post";

        # Query
    	$q = "SELECT 
			    posts.content,
	            posts.created,
	           	posts.user_id,
	           	posts.post_id,
	           	users.first_name,
	           	users.last_name
			FROM posts
			INNER JOIN users 
			    ON posts.user_id = '".$this->user->user_id."'
			GROUP BY posts.post_id";

    	# Run the query, store the results in the variable $posts
    	$posts = DB::instance(DB_NAME)->select_rows($q);

    	# Send the reversed array so the most recent one shows first.
    	$posts_reversed = array_reverse($posts);

    	# Pass data to the View
    	$this->template->content->posts = $posts_reversed;

        # Render template
        echo $this->template;

    }

    # This is the function that takes in the given information from adding a post and processes it.
    public function p_add() {

        # Associate this post with this user
        $_POST['user_id']  = $this->user->user_id;

        # Unix timestamp of when this post was created / modified
        $_POST['created']  = Time::now();
        $_POST['modified'] = Time::now();

        # Insert data
        # Note we didn't have to sanitize any of the $_POST data because we're using the insert method which does it for us
        DB::instance(DB_NAME)->insert('posts', $_POST);

        # Send them back to the original page where they can see all their posts.
        Router::redirect("/posts/add");


    }

    # The below shows the page where the user is asked if they really want to delete that post.
    public function delete($post_id) {

        $this->template->content = View::instance('v_post_delete');
    	$this->template->title = "Delete Confirmation";
    	$this->template->content->post_id = $post_id;

    	echo $this->template;

    }

    # This function deletes the post that the user has confirmed to delete, then redirects to add posts page.
    public function p_delete($post_id) {

    	$post_location = 'WHERE post_id = '.$post_id;
    	DB::instance(DB_NAME)->delete('posts', $post_location);

    	Router::redirect("/posts/add");
    }

    # This function represents the index that shows all of the posts that the user is following.
    public function index() {

    	# Set up the View
    	$this->template->content = View::instance('v_posts_index');
    	$this->template->title   = "All Posts";

    	# Query to see all the posts that the user is following
    	$q = 'SELECT 
            	posts.content,
            	posts.created,
            	posts.user_id AS post_user_id,
            	users_users.user_id AS follower_id,
            	users.first_name,
            	users.last_name
        	FROM posts
        	INNER JOIN users_users 
            	ON posts.user_id = users_users.user_id_followed
        	INNER JOIN users 
            	ON posts.user_id = users.user_id
        	WHERE users_users.user_id = '.$this->user->user_id;

    	# Run the query, store the results in the variable $posts
    	$posts = DB::instance(DB_NAME)->select_rows($q);
    	# Send the reversed array so the most recent one shows first.
    	$posts_reversed = array_reverse($posts);

    	# Pass data to the View
    	$this->template->content->posts = $posts_reversed;

    	# Render the View
    	echo $this->template;

	}

    # This function finds all of the users so main user can choose who to follow/unfollow
	public function users() {

		# Set up the View
    	$this->template->content = View::instance("v_posts_users");
   		$this->template->title   = "Users";

   		# Build the query to get all the users
   		$q = "SELECT *
       		FROM users
       		WHERE user_id !=".$this->user->user_id;

   		# Execute the query to get all the users. 
   		# Store the result array in the variable $users
  		$users = DB::instance(DB_NAME)->select_rows($q);

    	# Build the query to figure out what connections does this user already have? 
   		# I.e. who are they following
    	$q = "SELECT * 
        	FROM users_users
        	WHERE user_id = ".$this->user->user_id;

    	# Execute this query with the select_array method
    	# select_array will return our results in an array and use the "users_id_followed" field as the index.
    	$connections = DB::instance(DB_NAME)->select_array($q, 'user_id_followed');

    	# Pass data (users and connections) to the view
    	$this->template->content->users       = $users;
    	$this->template->content->connections = $connections;

    	# Render the view
    	echo $this->template;

	}

    # This function processes the person to be followed.
	public function follow($user_id_followed) {

    	# Prepare the data array to be inserted
    	$data = Array(
        	"created" => Time::now(),
        	"user_id" => $this->user->user_id,
        	"user_id_followed" => $user_id_followed
        	);

    	# Do the insert
    	DB::instance(DB_NAME)->insert('users_users', $data);

    	# Send them back
    	Router::redirect("/posts/users");

	}

    # Unfollow a user.
	public function unfollow($user_id_followed) {

    	# Delete this connection
    	$where_condition = 'WHERE user_id = '.$this->user->user_id.' AND user_id_followed = '.$user_id_followed;
    	DB::instance(DB_NAME)->delete('users_users', $where_condition);

    	# Send them back
    	Router::redirect("/posts/users");

	}
} #eoc