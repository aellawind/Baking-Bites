<?php

class users_controller extends base_controller {

    public function __construct() {
        parent::__construct();
       
    } 

    public function index() {

        #Assumes people who go to /users wants to see the list of users, which is in posts controller, so redirect.
        Router::redirect('/posts/users');
    }

    public function signup($error=NULL) {
        
        # Set up the view
        $this->template->content = View::instance('v_users_signup');
        $this->template->title = "Sign Up";

        # If the user doesn't input all the fields, it needs to output an error.
        $this->template->content->error = $error;
        # If email has already been used, we need to output an error.
        #$this->template->content->duplicate_email_error = $duplicate_email_error

        
        #Render the view
        echo $this->template;

    }

    public function p_signup() {

         # Sanitize the user entered data to prevent any funny-business (re: SQL Injection Attacks)
        $_POST = DB::instance(DB_NAME)->sanitize($_POST);

        # Set up the email and password query
        $q = "SELECT * FROM users WHERE email = '".$_POST['email']."'";

        # Query the database for the email
        $user_exists = DB::instance(DB_NAME)->select_rows($q);

        # Set up the username query
        $q = "SELECT * FROM users WHERE username = '".$_POST['username']."'";

        # Query the database for the email
        $username_exists = DB::instance(DB_NAME)->select_rows($q);

        # Check if this email exists in the database
        if(!empty($user_exists)){
            # Send the person back to the sign in page with an error
            Router::redirect('/users/signup/user-exists');
        }

        # Check if this email exists in the database
        if(!empty($username_exists)){
            # Send the person back to the sign in page with an error
            Router::redirect('/users/signup/username-exists');
        }


        # Check to make sure the fields entered are acceptable.
        if ($_POST['first_name'] == "") {
            Router::redirect('/users/signup/firstname_required');
        }

        if ($_POST['last_name'] == "") {
            Router::redirect('/users/signup/lastname_required');
        }


        if ($_POST['email'] == "") {
            Router::redirect('/users/signup/email_required');
        }

        if ($_POST['username'] == "") {
            Router::redirect('/users/signup/username_required');
        }

        if ($_POST['password'] == "") {
            Router::redirect('/users/signup/password_required');
        }

        if (strlen($_POST['password']) <= 5) {
            Router::redirect('/users/signup/short_password');
         }
            

        # More data we want stored with the user
        $_POST['created'] = Time::now();
        $_POST['modified'] = Time::now();

        # Encrypt the password
        $_POST['password'] = sha1(PASSWORD_SALT.$_POST['password']);

        # Create an encrypted token via their email address and a random string
        $_POST['token'] = sha1(TOKEN_SALT.$_POST['email'].Utils::generate_random_string());

        # Insert this user into the database
        $user_id = DB::instance(DB_NAME)->insert_row('users', $_POST);

        # Now that the user has signed up, we want to automatically log them in so they can edit their profile.
        if($user_id) {
            setcookie('token',$_POST['token'], strtotime('+1 year'), '/');
        }


        # Send them to the edit profile page, once signed up
        Router::redirect("/users/editprofile");
    }

    public function login($error=NULL) {
        
        $this->template->content = View::instance('v_users_login');

        $this->template->content->error = $error;

        echo $this->template;
    }

    public function p_login() {

        # Sanitize the user entered data to prevent any funny-business (re: SQL Injection Attacks)
        $_POST = DB::instance(DB_NAME)->sanitize($_POST);

        # Hash submitted password so we can compare it against one in the db
        $_POST['password'] = sha1(PASSWORD_SALT.$_POST['password']);

        # Search the db for this email and password
        # Retrieve the token if it's available
        $q = "SELECT token 
            FROM users 
            WHERE email = '".$_POST['email']."' 
            AND password = '".$_POST['password']."'";

        $token = DB::instance(DB_NAME)->select_field($q);

        # If we didn't find a matching token in the database, it means login failed
        if(!$token) {

            # Send them back to the login page
            Router::redirect("/index/index/error");

        # Login succeeded! 
        } 

        else {

            /* 
            Store this token in a cookie using setcookie()
            Important Note: *Nothing* else can echo to the page before setcookie is called
            Not even one single white space.
            param 1 = name of the cookie
            param 2 = the value of the cookie
            param 3 = when to expire
            param 4 = the path of the cooke (a single forward slash sets it for the entire domain)
            */
            setcookie("token", $token, strtotime('+2 weeks'), '/');

            # Send them to the main page - or whever you want them to go
            Router::redirect("/");
        }

    }
    

    public function logout() {
         # Generate and save a new token for next login
        $new_token = sha1(TOKEN_SALT.$this->user->email.Utils::generate_random_string());

        # Create the data array we'll use with the update method
        # In this case, we're only updating one field, so our array only has one entry
        $data = Array("token" => $new_token);

        # Do the update
        DB::instance(DB_NAME)->update("users", $data, "WHERE token = '".$this->user->token."'");

        # Delete their token cookie by setting it to a date in the past - effectively logging them out
        setcookie("token", "", strtotime('-1 year'), '/');

        # Send them back to the main index.
        Router::redirect("/");


    }

    public function editprofile() {

        # Users cannot try to access this page unless logged in. They're sent to home if they do.
        if(!$this->user) {
            Router::redirect('/');
        }

        # Set up the view
        $this->template->content = View::instance('v_users_editprofile');
        $this->template->title = "Edit Your Profile";

        echo $this->template;
     
    }

    # The below function does nothing but proces the info from editprofile for profile to use.
    public function p_profile() {

        # Sanitize the data
        $_POST = DB::instance(DB_NAME)->sanitize($_POST);

        # DO NOT INSERT BLANK DATA
        foreach($_POST as $field_name => $value) {
            if($value == "") {
                unset($_POST[$field_name]);
            }
        }

        # Insert submission into database if there is any data
        if($_POST) {
            $q = DB::instance(DB_NAME)->update('users', $_POST, "WHERE user_id = '".$this->user->user_id."'");
        }

        Router::redirect('/users/profile');

    }


    public function profile($username = NULL) {

        # Users cannot try to access this page unless logged in. They're sent to home if they do.
        if(!$this->user) {
            Router::redirect('/');
        }

        $this->template->content = View::instance('v_users_profile');
        $this->template->title = "User Profile";

        # Passes in empty string to the view so we can evalluate if we show "Edit Profile" for the user
        if($username) {
            $this->template->content->username = "";
        }

        # Looking at your own profile
        else {
            # Change the variable
            $username = $this->user->username;
            $this->template->content->username = $username;
        }   
        

        $q = "SELECT first_name, 
                    last_name, 
                    nickname,
                    bakedgood,
                    cake,
                    cookie,
                    bakingadvice,
                    bio,
                    recipes,
                    username
                FROM users
                WHERE users.username = '".$username."'";
        

        $profile = DB::instance(DB_NAME)->select_rows($q);
        
        # Pass the data to the view
        $this->template->content->profile = $profile;    

        echo $this->template;

        
    }

} # eoc