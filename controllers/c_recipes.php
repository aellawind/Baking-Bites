<?php

class recipes_controller extends base_controller {

    #public function __construct() {
    #    parent::__construct();

        # Make sure user is logged in if they want to use anything in this controller
    #    if(!$this->user) {
    #        Router::redirect("/");
        
    #    }
    #}

    # This is the page where users can add a post and also see the posts they've already added.
    public function index() {

    }

    # This is the function where users can add a recipe
    public function add_recipes() {

        # Setup view
        $this->template->content = View::instance('v_recipes_add');
        $this->template->title   = "Add A Recipe";
        echo $this->template;

    }

    public function p_add_recipes() {
    	
    	# Associate this post with this user
        #$_POST['user_id']  = $this->user->user_id;

        # Unix timestamp of when this post was created / modified
        $_POST['created']  = Time::now();
        $_POST['modified'] = Time::now();

        function scrape_between($data, $start, $end){
	        $data = stristr($data, $start); // Stripping all data from before $start
	        $data = substr($data, strlen($start));  // Stripping $start
	        $stop = stripos($data, $end);   // Getting the position of the $end of the data to scrape
	        $data = substr($data, 0, $stop);    // Stripping all data from after and including the $end of the data to scrape
	        return $data;   // Returning the scraped data from the function
		}
		
		if (!filter_var($_POST['url'], FILTER_VALIDATE_URL,FILTER_FLAG_PATH_REQUIRED)) {
			echo "Invalid link.";
		}
		else if (stripos($_POST['url'], 'tasteofhome') !== false) {
        	// TASTE OF HOME RECIPES
	        $results = Utils::curl('http://www.tasteofhome.com/recipes/crab-cheese-fondue');
	        // Get the recipe title
	        $title = scrape_between($results, "<title>", " | Taste of Home</title>"); 
	        // Get the ingredients block
	        $ingredients_list = scrape_between($results, "<ul class=\"rd_ingredients\">", "</ul>");
	        // Put each ingredient into an array
	        $separate_ingredients = explode("<li class=\"rd_ingredient\">", $ingredients_list);
	        foreach ($separate_ingredients as $separate_ingredient) {
	        	if ($separate_ingredient != "") {
	        		$result_ingredients[] = scrape_between($separate_ingredient,"itemprop=\"ingredients\">", "</li>");
	        		#echo 'this is one:', $separate_ingredient;
	        	}
	        }
	        // Get the directions
	        $directions_list = scrape_between($results, "<ol class=\"rd_directions\">", "</ol>");
	        $separate_directions = explode("<li class=\"rd_ingredient\">", $directions_list);
	        foreach ($separate_directions as $separate_direction) {
	        	if ($separate_direction != "") {
	        		$result_directions[] = scrape_between($separate_direction, "<span class=\"rd_name\">", "</span>");
	        	}
	        }
        }
      

        else if (stripos($_POST['url'], 'allrecipes') !== false) {
       
	        //ALLRECIPES 
	        $results = Utils::curl('http://allrecipes.com/Recipe/Good-Old-Fashioned-Pancakes');
	        // Get the title
	        $title = scrape_between($results, "<title>", "- Allrecipes.com");
	        // Get the ingredients block
	        $ingredients_list = scrape_between($results, "<ul class=\"ingredient-wrap\">", "</ul>");
	        $separate_ingredients = explode("itemprop=\"ingredients\"", $ingredients_list);
	        foreach ($separate_ingredients as $separate_ingredient) {
	        	if ($separate_ingredient !="") {
	        		$amount = scrape_between($separate_ingredient, "class=\"ingredient-amount\">","</span>");
	        		$ingredient = scrape_between($separate_ingredient, "class=\"ingredient-name\">","</span>");
	        		$result_ingredients[] = $amount." ".$ingredient;
	        	}
	        }
	        // Get the directions
	        $directions_list = scrape_between($results, "<div class=\"directions\">", "</ol>");
	        $separate_directions = explode("<li>", $directions_list);
	        foreach ($separate_directions as $separate_direction) {
	        	if ($separate_direction !="") {
	        		$result_directions[] = scrape_between($separate_direction, "plaincharacterwrap break\">", "</span>");
	        	}
	        }
        }

        else if (stripos($_POST['url'], 'epicurious') !== false) {
       
	        //EPICURIOUS
	        $results = Utils::curl('http://www.epicurious.com/recipes/food/views/Slow-Roasted-Salmon-with-Fennel-Citrus-and-Chiles-51210470');
	        // Get the title
	        $title = scrape_between($results, "<title>", " | Epicurious.com");
	        // Get the ingredients block
	        $ingredients_list = scrape_between($results, "<div id=\"ingredients\">", "</ul>");
	        $separate_ingredients = explode("<li class=\"ingredient\">", $ingredients_list);
	        foreach ($separate_ingredients as $separate_ingredient) {
	        	if ($separate_ingredient !="") {
	        		$result_ingredients[] = scrape_between($separate_ingredient, "<span>","</span>");
	        	}
	        }
	        // Get the directions
	        $directions_list = scrape_between($results, "<div id=\"preparation\" class=\"instructions\">", "</div>");
	        $separate_directions = explode("<p class=", $directions_list);
	        foreach ($separate_directions as $separate_direction) {
	        	if ($separate_direction !="") {
	        		$result_directions[] = scrape_between($separate_direction, "instruction\">", "</p>");
	        	}
	        }
	    }

        else if (stripos($_POST['url'], 'simplyrecipes') !== false) {

	        // Simply Recipes
	        $results = Utils::curl('http://www.simplyrecipes.com/recipes/pear_tarte_tatin/');
	        // Get the title
	        $title = scrape_between($results, "<title>", " | Simply Recipes");
	        // Get the ingredients block
	        $ingredients_list = scrape_between($results, "<div id=\"recipe-ingredients\"", "<div id=\"recipe-method\"");
	        $separate_ingredients = explode("<li class=\"ingredient\"", $ingredients_list);
	        foreach ($separate_ingredients as $separate_ingredient) {
	        	if ($separate_ingredient !="") {
	        		$result_ingredients[] = scrape_between($separate_ingredient, "itemprop=\"ingredients\">","</li>");
	        	}
	        }
	        // Get the directions
	        $directions_list = scrape_between($results, "<div itemprop=\"recipeInstructions\">", "</div>");
	        $separate_directions = explode("<p>", $directions_list);
	        foreach ($separate_directions as $separate_direction) {
	        	if ($separate_direction !="") {
	        		$result_directions[] = scrape_between($separate_direction, "</strong>", "</p>");
	        	}
	        }
	    }

	    else if (stripos($_POST['url'], 'verybestbaking') !== false) {
	        // Very Best baking
	        $results = Utils::curl('http://www.verybestbaking.com/recipes/138504/Puerto-Rican-Coconut-Dessert/detail.aspx');
	        // Get the title
	        $title = scrape_between($results, "<title>", "</title>");
	        // Get the ingredients block
	        $ingredients_list = scrape_between($results, "<div class=\"userIngredients\">", "</div>");
	        $separate_ingredients = explode("<li", $ingredients_list);
	        foreach ($separate_ingredients as $separate_ingredient) {
	        	if ($separate_ingredient !="") {
	        		$result_ingredients[] = scrape_between($separate_ingredient, "class=\"ingredient\">","</li>");
	        	}
	        }
	        // Get the directions
	        $directions_list = scrape_between($results, "<div class=\"column directions\">", "<div id=\"bakersComments\"");
	        $separate_directions = explode("<div class=", $directions_list);
	        foreach ($separate_directions as $separate_direction) {
	        	if ($separate_direction !="") {
	        		$result_directions = scrape_between($separate_direction, "\"instructions\">", "</div>");
	        		#echo $result_directions;
	        	}
	        }
	    }
    
	    else {
	    	echo "We do not support extracting recipes from that site.";
	    }

	    $data = Array(
	    'title' => $title, 
	    'ingredients_list' => implode(",",$result_ingredients), 
	    'directions_list' =>  implode(",",$result_directions),
	    'url' => $_POST['url']);

        # Insert data
        # Note we didn't have to sanitize any of the $_POST data because we're using the insert method which does it for us
        DB::instance(DB_NAME)->insert('recipes', $data);
        
    	# Send them back to the original page where they can see all their posts.
        Router::redirect("/recipes/add_recipes");

    }






    


}