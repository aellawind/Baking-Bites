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
	        $results = Utils::curl($_POST['url']);
	        // Get the recipe title
	        $title = trim(strip_tags(scrape_between($results, "<title>", " | Taste of Home</title>"),'<p><b><i>')); 
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
	        $results = Utils::curl($_POST['url']);
	        // Get the title
	        $title = trim(strip_tags(scrape_between($results, "<title>", "- Allrecipes.com"),'<p><b><i>'));
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
	        $results = Utils::curl($_POST['url']);
	        // Get the title
	        $title = trim(strip_tags(scrape_between($results, "<title>", " | Simply Recipes"),'<p><b><i>'));
	        // Get the ingredients block
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
	        $results = Utils::curl($_POST['url']);
	        // Get the title
	        $title = trim(strip_tags(scrape_between($results, "<title>", "</title>"),'<p><b><i>'));
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
		    'url' => $_POST['url']);

	        # Insert data
	        # Note we didn't have to sanitize any of the $_POST data because we're using the insert method which does it for us
	        DB::instance(DB_NAME)->insert('recipes', $data);
	        echo "Your post was added.";
	    	
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
                    recipeimages
                FROM recipes
                WHERE recipe_id = '".$recipe_id."'";
        

        $recipe = DB::instance(DB_NAME)->select_rows($q);
        
        # Pass the data to the view
        $this->template->content->recipe = $recipe;   

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
		    'ingredients_list' => $_POST['ingredients_list'], 
		    'directions_list' =>  $_POST['directions_list'],
		    'created' => $_POST['created'],
		    'added_by' => $_POST['added_by']);

	    # Insert data
        # Note we didn't have to sanitize any of the $_POST data because we're using the insert method which does it for us
        $recipe_id = DB::instance(DB_NAME)->insert('recipes', $data);

        if($_FILES) {
	        
	        if($_FILES['recipeimages']['error'] ==0) {
		        // Image upload
		        echo "There's an image";
		        Upload::upload($_FILES, "/uploads/recipeimages/", array("JPG", "JPEG", "jpg", "gif", "GIF", "png", "PNG"), $recipe_id);

		        $filename = $_FILES['recipeimages']['name'];
		        $extension = substr($filename, strrpos($filename, '.'));
		        $recipeimages = "/uploads/recipeimages/".$recipe_id.$extension;
		        $img = Array('recipeimages' => $recipeimages);
		        DB::instance(DB_NAME)->update("recipes", $img, "WHERE recipe_id = '".$recipe_id."'");
	        }

	        else if($_FILES['recipeimages']['error']==2) {
	        	echo "Your image exceeds the max file size limit.";
	        }


	    }

	    else {
	    	echo "Your recipe was added.";
	    }

    }







    


}