p4.amiraanuar.com
=================

P4 for CS-15 Dynamic Web Applications. Baking/Cooking Recipes Generator.

I'm an avid baker, but sometimes I don't always have a ton of ingredients. I've always wished there were some sort of website where I could just type in ingredients and it would output recipes that I could make--a filter of sorts. That is what my app revolves around. Users can log in and search through a database of recipes based on one to five ingredients. The search will query the database (which if it were a real app, would have many more recipes but currently just has a small sample) and then return all the recipes that have those ingredients.

~ Sign up 
~ Log in/ log out
~ Edit profile
~ See other users' profiles
~ Add their own recipes (title, ingredients, directions)
~ Upload a photo with their recipe
~ Put in a link to a recipe site and have the relevant recipe info extracted and put into the app database
~ Search through the recipes based off of ingredient
~ Add recipes to favorites
~ Remove recipes from favorites
~ See list of favorites of other users
~ See what recipes other users have added (their own personal ones)
~ Delete recipes user has added through the "add your own" option

Aspects Managed By Javascript
~ Form: I am using jquery/ajax to handle some of the form processing
~ Check size: I am using javascript to check the size of the images that are being uploaded
~ Search: I am using javascript to manage the display of the search results after inputting in ingredients
~ Add Recipes: I am using javascript to manage the feedback after submission of recipes through link inputs
~ Add Your Own Recipe: I am using javascript to manage the results after submitting your own recipe

Notes: Users can only submit recipes from specific websites, for which I've written the code for proper parsing. 