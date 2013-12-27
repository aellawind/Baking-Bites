<?php

class recipes_controller extends base_controller {

    public function __construct() {
        parent::__construct();

        # Make sure user is logged in if they want to use anything in this controller
        if(!$this->user) {
            Router::redirect("/");
        
        }
    }

    # This is the page where users can add a post and also see the posts they've already added.
    public function index() {

    }

    # This is the function where users can add a recipe
    public function add_recipes() {

        # Setup view
        $this->template->content = View::instance('v_recipes_add');
        $this->template->title   = "Add Recipe";
        
        # Load JS files
        $client_files_body = Array(
        	"/js/jquery.form.min.js",
        	"/js/recipes_add.js"
        );

        $this->template->client_files_body = Utils::load_client_files($client_files_body);
        # Render template
        echo $this->template;

    }

    public function p_add_recipes() {
    	
    	if($_POST['url'] == "") {
    		echo "Please enter a link.";
    		return;
    	}
    	# Associate this recipe with this user who originally added it
        $_POST['added_by']  = $this->user->username;

        # Unix timestamp of when this post was created / modified
        $_POST['created']  = Time::now();

        function scrape_between($data, $start, $end){
	        $data = stristr($data, $start); // Stripping all data from before $start
	        $data = substr($data, strlen($start));  // Stripping $start
	        $stop = stripos($data, $end);   // Getting the position of the $end of the data to scrape
	        $data = substr($data, 0, $stop);    // Stripping all data from after and including the $end of the data to scrape
	        return $data;   // Returning the scraped data from the function
		}
		
		if (!filter_var($_POST['url'], FILTER_VALIDATE_URL,FILTER_FLAG_PATH_REQUIRED)) {
			echo "Invalid link.";
			return;
		}
		else if (stripos($_POST['url'], 'tasteofhome') !== false) {
        	// TASTE OF HOME RECIPES
        	$source = "<a href=\"tasteofhome.com\">Taste of Home</a>";
	        $results = Utils::curl($_POST['url']);
	        // Get the recipe title
	        $title = trim(strip_tags(scrape_between($results, "<title>", " | Taste of Home</title>"),'<p><b><i>'));
	        //Get an image (if it exists)
	        $imageblock = trim(scrape_between($results, "<div class=\"rd_recipe_img\">", "</div>"));
	        $image = trim(scrape_between($imageblock, "src=\"", "\"")); 
	        // Get the ingredients block
	        $ingredients_list = scrape_between($results, "<ul class=\"rd_ingredients\">", "</ul>");
	        // Put each ingredient into an array
	        $separate_ingredients = explode("<li class=\"rd_ingredient\">", $ingredients_list);
	        foreach ($separate_ingredients as $separate_ingredient) {
	        	if ($separate_ingredient != "") {
	        		$ingredient = trim(strip_tags(scrape_between($separate_ingredient,"itemprop=\"ingredients\">", "</li>"), '<p><b><i>'));
	        		if ($ingredient != "") {
	        			$result_ingredients[] = $ingredient;
	        		}
	        		
	        	}
	        }
	        // Get the directions
	        $directions_list = scrape_between($results, "<ol class=\"rd_directions\">", "</ol>");
	        $separate_directions = explode("<li class=\"rd_ingredient\">", $directions_list);
	        foreach ($separate_directions as $separate_direction) {
	        	if ($separate_direction != "") {
	        		$direction = trim(strip_tags(scrape_between($separate_direction, "<span class=\"rd_name\">", "</span>"),'<p><b><i>'));
	        		if ($direction != "") {
	        			$result_directions[] = $direction;
	        		}
	        	}
	        }
        }
      

        else if (stripos($_POST['url'], 'allrecipes') !== false) {
       
	        //ALLRECIPES 
	        $source = "<a href=\"allrecipes.com\">Allrecipes</a>";
	        $results = Utils::curl($_POST['url']);
	        // Get the title
	        $title = trim(strip_tags(scrape_between($results, "<title>", "- Allrecipes.com"),'<p><b><i>'));
	        //Get an image (if it exists)
	        $imageblock = trim(scrape_between($results, "<img id=\"imgPhoto\" class=\"rec-image", "/>"));
	        $image = trim(scrape_between($imageblock, "src=\"", "\"")); 
	        // Get the ingredients block
	        $ingredients_list = scrape_between($results, "<ul class=\"ingredient-wrap\">", "</ul>");
	        $separate_ingredients = explode("itemprop=\"ingredients\"", $ingredients_list);
	        foreach ($separate_ingredients as $separate_ingredient) {
	        	if ($separate_ingredient !="") {
	        		$amount = scrape_between($separate_ingredient, "class=\"ingredient-amount\">","</span>");
	        		$ingredient = scrape_between($separate_ingredient, "class=\"ingredient-name\">","</span>");
	        		$ingredient = trim(strip_tags($amount." ".$ingredient, '<p><b><i>'));
	        		if ($ingredient != "") {
	        			$result_ingredients[] = $ingredient;
	        		}
	        	}
	        }
	        // Get the directions
	        $directions_list = scrape_between($results, "<div class=\"directions\">", "</ol>");
	        $separate_directions = explode("<li>", $directions_list);
	        foreach ($separate_directions as $separate_direction) {
	        	if ($separate_direction !="") {
	        		$direction = trim(strip_tags(scrape_between($separate_direction, "plaincharacterwrap break\">", "</span>"), '<p><b><i>'));
	        		if ($direction != "") {
	        			$result_directions[] = $direction;
	        		}
	        	}
	        }
        }

        else if (stripos($_POST['url'], 'epicurious') !== false) {
       
	        //EPICURIOUS
	        $source = "<a href=\"epicurious.com\">Epicurious</a>";
	        $results = Utils::curl($_POST['url']);
	        // Get the title
	        $title = trim(strip_tags(scrape_between($results, "<title>", " | Epicurious.com"),'<p><b><i>'));
	        //Get an image (if it exists)
	        $imageblock = trim(scrape_between($results, "<span id=\"recipe_image\">", "<div"));
	        $image = "http://www.epicurious.com".trim(scrape_between($imageblock, "<img src=\"", "\""));

	        // Get the ingredients block
	        $ingredients_list = scrape_between($results, "<div id=\"ingredients\">", "</ul>");
	        $separate_ingredients = explode("<li class=\"ingredient\">", $ingredients_list);
	        foreach ($separate_ingredients as $separate_ingredient) {
	        	if ($separate_ingredient !="") {
	        		$ingredient = trim(strip_tags(scrape_between($separate_ingredient, "<span>","</span>"),'<p><b><i>'));
	        		if ($ingredient != "") {
	        			$result_ingredients[] = $ingredient;
	        		}

	        	}
	        }
	        // Get the directions
	        $directions_list = scrape_between($results, "<div id=\"preparation\" class=\"instructions\">", "</div>");
	        $separate_directions = explode("<p class=", $directions_list);
	        foreach ($separate_directions as $separate_direction) {
	        	if ($separate_direction != "") {
	        		
	        		$direction = trim(strip_tags(scrape_between($separate_direction, "instruction\">", "</p>"),'<p><b><i>'));
	        		if ($direction != "") {
	        			$result_directions[] = $direction;
	        		}

	        	}
	        }
	    }

        else if (stripos($_POST['url'], 'simplyrecipes') !== false) {

	        // Simply Recipes
	        $source = "<a href=\"simplyrecipes.com\">SimplyRecipes</a>";
	        $results = Utils::curl($_POST['url']);
	        // Get the title
	        $title = trim(strip_tags(scrape_between($results, "<title>", " | Simply Recipes"),'<p><b><i>'));
	        // Get the ingredients block
	        //Get an image (if it exists)
	        $imageblock = trim(scrape_between($results, "<div class=\"featured-image\">", "</div>"));
	        $image = trim(scrape_between($imageblock, "src=\"", "\""));
			$ingredients_list = scrape_between($results, "<div id=\"recipe-ingredients\"", "<div id=\"recipe-method\"");
	        $separate_ingredients = explode("<li class=\"ingredient\"", $ingredients_list);
	        foreach ($separate_ingredients as $separate_ingredient) {
	        	if ($separate_ingredient !="") {
	        		$ingredient = trim(strip_tags(scrape_between($separate_ingredient, "itemprop=\"ingredients\">","</li>"),'<p><b><i>'));
	        		if ($ingredient != "") {
	        			$result_ingredients[] = $ingredient;
	        		}
	        	}
	        }
	        // Get the directions
	        $directions_list = scrape_between($results, "<div itemprop=\"recipeInstructions\">", "</div>");
	        $separate_directions = explode("<p>", $directions_list);
	        foreach ($separate_directions as $separate_direction) {
	        	if ($separate_direction !="") {
	        		$direction = trim(strip_tags(scrape_between($separate_direction, "</strong>", "</p>"),'<p><b><i>'));
	        		if ($direction != "") {
	        			$result_directions[] = $direction;
	        		}
	        	}
	        }
	    }

	    else if (stripos($_POST['url'], 'verybestbaking') !== false) {
	        // Very Best baking
	        $source = "<a href=\"verybestbaking.com\">VeryBestBaking</a>";
	        $results = Utils::curl($_POST['url']);
	        // Get the title
	        $title = trim(strip_tags(scrape_between($results, "<title>", "</title>"),'<p><b><i>'));
	        //Get an image (if it exists)
	        $imageblock = trim(scrape_between($results, "<div class=\"column recipePhoto\">", "</div>"));
	        $image = trim(scrape_between($imageblock, "src=\"", "\""));
			// Get the ingredients block
	        $ingredients_list = scrape_between($results, "<div class=\"userIngredients\">", "</div>");
	        $separate_ingredients = explode("<li", $ingredients_list);
	        foreach ($separate_ingredients as $separate_ingredient) {
	        	if ($separate_ingredient !="") {
	        		$ingredient = trim(strip_tags(scrape_between($separate_ingredient, "class=\"ingredient\">","</li>"),'<p><b><i>'));
	        		if ($ingredient != "") {
	        			$result_ingredients[] = $ingredient;
	        		}
	        	}
	        }
	        // Get the directions
	        $directions_list = scrape_between($results, "<div class=\"column directions\">", "<div id=\"bakersComments\"");
	        $separate_directions = explode("<div class=", $directions_list);
	        foreach ($separate_directions as $separate_direction) {
	        	if ($separate_direction !="") {
	        		$direction = trim(strip_tags(scrape_between($separate_direction, "\"instructions\">", "</div>"),'<p><b><i>'));
	        		if ($direction != "") {
	        			$result_directions[] = $direction;
	        		}
	        	}
	        }
	    }
    
	    else {
	    	echo "We do not support extracting recipes from that site.";
	    }

	    if (isset($image) == FALSE) {
	    	$image = "";
	    }


	    if (isset($title, $result_ingredients, $result_directions) == FALSE) {
	    	echo "Unfortunately this does not appear to be a recipe.";
	    }
	    else {
		    $data = Array(
		    'title' => $title, 
		    'image_url' => $image,
		    'ingredients_list' => implode("<br>",$result_ingredients), 
		    'directions_list' =>  implode("<br>",$result_directions),
		    'created' => $_POST['created'],
		    'added_by' => $_POST['added_by'],
		    'source' => $source,
		    'url' => $_POST['url']);

	        # Insert data
	        # Note we didn't have to sanitize any of the $_POST data because we're using the insert method which does it for us
	        $recipe_id = DB::instance(DB_NAME)->insert('recipes', $data);
	        $link = "/recipes/recipe/".$recipe_id;
	        echo "Your recipe was added. Click <a href=$link target=\"_blank\">here</a> to view it, or add another recipe!";
	    	
	    }

    }

    public function recipe($recipe_id = NULL) {

        # Users cannot try to access this page unless logged in. They're sent to home if they do.
        if(!$this->user) {
            Router::redirect('/');
        }

        $this->template->content = View::instance('v_recipe_page');
        $this->template->title = "Recipe Page";

        $q = "SELECT title, 
                    ingredients_list,
                    directions_list,
                    added_by,
                    image_url,
                    url,
                    recipeimages,
                    source,
                    recipe_id
                FROM recipes
                WHERE recipe_id = '".$recipe_id."'";
        

        $recipe = DB::instance(DB_NAME)->select_rows($q);

        # Build the query to figure out what connections/favorites the user already has
   		# I.e. the recipes they've favorited already
    	$q = "SELECT * 
        	FROM favorites
        	WHERE user_id = ".$this->user->user_id;

    	# Execute this query with the select_array method
    	# select_array will return our results in an array and use the "users_id_followed" field as the index.
    	$connections = DB::instance(DB_NAME)->select_array($q, 'recipe_id_favorited');
        
        # Pass the data to the view
        $this->template->content->recipe = $recipe; 
        $this->template->content->connections = $connections;  

        echo $this->template;

        
    }

    public function add_your_own() {

        # Users cannot try to access this page unless logged in. They're sent to home if they do.
        if(!$this->user) {
            Router::redirect('/');
        }

        # Setup view
        $this->template->content = View::instance('v_recipes_add_your_own');
        $this->template->title   = "Add Your Own Recipe";
        
        # Load JS files
        $client_files_body = Array(
        	"/js/jquery.form.min.js",
        	"/js/own_recipe_add.js",
        	"/js/checksize.js"
        );

        $this->template->client_files_body = Utils::load_client_files($client_files_body);
        # Render template
        echo $this->template;

    }

    public function p_add_your_own() {
       
        # Load JS files
        $client_files_body = Array(
        	"/js/jquery.form.min.js",
        	"/js/recipes_add.js",
        	"/js/checksize.js"
        );

        $this->template->client_files_body = Utils::load_client_files($client_files_body);

        if($_POST['title'] == "" || $_POST['ingredients_list'] =="" || $_POST['directions_list'] =="") {
        	echo "Please fill in all fields.";
        	return;
        }

        # Associate this recipe with this user who originally added it
        $_POST['added_by']  = $this->user->username;

        # Unix timestamp of when this post was created
        $_POST['created']  = Time::now();

        $data = Array(
		    'title' => $_POST['title'], 
		    'ingredients_list' => nl2br($_POST['ingredients_list']), 
		    'directions_list' =>  nl2br($_POST['directions_list']),
		    'created' => $_POST['created'],
		    'added_by' => $_POST['added_by'],
		    'source' => "<a href=\"/users/profile/".$_POST['added_by']."\">".$_POST['added_by']."</a>");

	    # Insert data
        # Note we didn't have to sanitize any of the $_POST data because we're using the insert method which does it for us

        if($_FILES) {
	        
	        if($_FILES['recipeimages']['error'] ==0) {
		         $recipe_id = DB::instance(DB_NAME)->insert('recipes', $data);
		        // Image upload
		        Upload::upload($_FILES, "/uploads/recipeimages/", array("JPG", "JPEG", "jpg", "gif", "GIF", "png", "PNG"), $recipe_id);
		        $filename = $_FILES['recipeimages']['name'];
		        $extension = substr($filename, strrpos($filename, '.'));
		        $recipeimages = "/uploads/recipeimages/".$recipe_id.$extension;
		        $img = Array('recipeimages' => $recipeimages);
		        DB::instance(DB_NAME)->update("recipes", $img, "WHERE recipe_id = '".$recipe_id."'");
		        $link = "/recipes/recipe/".$recipe_id;
	        	echo "Your recipe was added. Click <a href=$link target=\"_blank\">here</a> to view it, or add another recipe!";
	        }

	        else {
	        	echo "There was a problem with your upload. Try again.";
	        }


	    }

	    else {
	    	$recipe_id = DB::instance(DB_NAME)->insert('recipes', $data);
	        $link = "/recipes/recipe/".$recipe_id;
	        echo "Your recipe was added. Click <a href=$link target=\"_blank\">here</a> to view it, or add another recipe!";
	    }

    }

	public function search() {

		# Setup view
        $this->template->content = View::instance('v_recipes_search');
        $this->template->title   = "Search For A Recipe";
        
        # Load JS files
        $client_files_body = Array(
        	"/js/jquery.form.min.js",
        	"/js/own_recipe_add.js",
        	"/js/search.js"
        );

        $this->template->client_files_body = Utils::load_client_files($client_files_body);
        # Render template
        echo $this->template;

	}

	public function p_search() {

        # Load JS files
        $client_files_body = Array(
        	"/js/jquery.form.min.js",
        	"/js/own_recipe_add.js",
        	"/js/search.js"
        );

        $this->template->client_files_body = Utils::load_client_files($client_files_body);
        
        if($_POST['ingredient1'] == "" && $_POST['ingredient2'] =="" && $_POST['ingredient3'] =="" 
        	&& $_POST['ingredient4'] =="" && $_POST['ingredient5'] =="") {
        	echo "Please enter at least one ingredient.";
        	return;
        }

        $firstsearchterm = $_POST['ingredient1'];
        $recipeq = "SELECT *
        	FROM recipes
        	WHERE ingredients_list
        	LIKE '%$firstsearchterm%'";

        if ($_POST['ingredient2'] != "") {


        	$secondsearchterm = $_POST['ingredient2'];
        	$recipeq = "SELECT *
        				FROM recipes
        				WHERE ingredients_list LIKE '%$firstsearchterm%' 
        				AND ingredients_list LIKE '%$secondsearchterm%'";

        	if ($_POST['ingredient3']) {

	        	$thirdsearchterm = $_POST['ingredient3'];
	        	$recipeq = "SELECT *
	        				FROM recipes
	        				WHERE ingredients_list LIKE '%$firstsearchterm%'
	        				AND ingredients_list LIKE '%$secondsearchterm%'
	        				AND ingredients_list LIKE '%$thirdsearchterm%'";

	        	if ($_POST['ingredient4']) {

		        	$fourthsearchterm = $_POST['ingredient4'];
		        	$recipeq = "SELECT *
		        				FROM recipes
		        				WHERE ingredients_list LIKE '%$firstsearchterm%'
		        				AND ingredients_list LIKE '%$secondsearchterm%'
		        				AND ingredients_list LIKE '%$thirdsearchterm%'
		        				AND ingredients_list LIKE '%$fourthsearchterm%'";
		        				
		        	if ($_POST['ingredient5']) {

			        	$fifthsearchterm = $_POST['ingredient5'];
			        	$recipeq = "SELECT *
			        				FROM recipes
			        				WHERE ingredients_list LIKE '%$firstsearchterm%'
			        				AND ingredients_list LIKE '%$secondsearchterm%'
			        				AND ingredients_list LIKE '%$thirdsearchterm%'
			        				AND ingredients_list LIKE '%$fourthsearchterm%'
			        				AND ingredients_list LIKE '%$fifthsearchterm%'";
	        		}
		        }
        	}
        }


        $results =DB::instance(DB_NAME)->select_rows($recipeq);
        $results_array = Array();
        
        foreach ($results as $res) {
        	$image = "";
        	if ($res['image_url'] !== "") {
        		$image = "<img src=\"".$res['image_url']."\" class=\"small_recipe_image\"/>";
        	}
            else if ($res['recipeimages'])  {
            	$image = "<img src=\"".$res['recipeimages']."\" class=\"small_recipe_image\"/>";
            }
            else {
            	$image = "<img src=\"/images/recipedefault.png\"/>";
            }
        	$title = $res['title'];
        	$link = "/recipes/recipe/".$res['recipe_id'];
        	$source = $res['source'];
        	$ingredients = $res['ingredients_list'];
        	$div1 = "<div class=\"left\">".$image."</div>";
        	$div2 = "<div class=\"right\"><span class=\"recipetitle\"><a href=".$link.">".$title."</a></span><br><span class=\"from\">From: ".$source."</span><br>".$ingredients."</div>";
        	$results_array[] = "<div class=\"oneresult\"><br>".$div1.$div2."<div class=\"clear\"><br></div></div>";
        }

        #echo json_encode($results_array);
        foreach ($results_array as $result) {
        	echo $result;
        }


	}

	public function addfavorites($recipe_id) {

		$q = "SELECT title
			FROM recipes
			WHERE recipe_id = ".$recipe_id;

		$titles = DB::instance(DB_NAME)->select_rows($q);
		$title = array_values($titles)[0]['title'];

		#Prepare the data array to be inserted
		$data = Array(
			"created" => Time::now(),
			"user_id" => $this->user->user_id,
			"recipe_id_favorited" => $recipe_id,
			"title" => $title
			);

		#Do the insert
		DB::instance(DB_NAME)->insert('favorites', $data);

		Router::redirect("/recipes/favorites");

	}

    public function favorites() {

		# Users cannot try to access this page unless logged in. They're sent to home if they do.
        if(!$this->user) {
            Router::redirect('/');
        }

        $this->template->content = View::instance('v_recipes_favorites');
        $this->template->title = "My Favorites";

        $q = "SELECT *
                FROM favorites
                WHERE user_id = ".$this->user->user_id;
        
        $favoriterecipes = DB::instance(DB_NAME)->select_rows($q);
        
        # Pass the data to the view
        $this->template->content->favoriterecipes = $favoriterecipes;  

        echo $this->template;


    }

    public function removefavorites($recipe_id) {

		# Delete this favorite
    	$where_condition = 'WHERE recipe_id_favorited = '.$recipe_id.' AND user_id = '.$this->user->user_id;
    	DB::instance(DB_NAME)->delete('favorites', $where_condition);

		Router::redirect("/recipes/favorites");

	}

	





    


}