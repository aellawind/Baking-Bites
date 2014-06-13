Baking Bites
=================

Baking/Cooking Recipes Generator.

I'm an avid baker, but sometimes I don't always have a ton of ingredients. I've always wished there were some sort of website where I could just type in ingredients and it would output recipes that I could make--a filter of sorts. That is what my app revolves around (written with PHP, JavaScript, Ajax). Users can log in and search through a database of recipes based on one to five ingredients. The search will query the database (which if it were a real app, would have many more recipes but currently just has a small sample) and then return all the recipes that have those ingredients.

~ Sign up <br>
~ Log in/ log out<br>
~ Edit profile<br>
~ See other users' profiles<br>
~ Add their own recipes (title, ingredients, directions)<br>
~ Upload a photo with their recipe<br>
~ Put in a link to a recipe site and have the relevant recipe info extracted and put into the app database<br>
~ Search through the recipes based off of ingredient<br>
~ Add recipes to favorites<br>
~ Remove recipes from favorites<br>
~ See list of favorites of other users<br>
~ See what recipes other users have added (their own personal ones)<br>
~ Delete recipes user has added through the "add your own" option<br>

Aspects Managed By Javascript<br>
~ Form: I am using jquery/ajax to handle some of the form processing<br>
~ Check size: I am using javascript to check the size of the images that are being uploaded<br>
~ Search: I am using javascript to manage the display of the search results after inputting in ingredients<br>
~ Add Recipes: I am using javascript to manage the feedback after submission of recipes through link inputs<br>
~ Add Your Own Recipe: I am using javascript to manage the results after submitting your own recipe<br>
<br><br>
Notes: Users can only submit recipes from specific websites, for which I've written the code for proper parsing. 
