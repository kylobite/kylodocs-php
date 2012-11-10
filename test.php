<?php
	require_once("kd.php");

	/*

		KyloDocs needs to be started as an object to work properly.
		The parameter given is the desired name of the JSON document that will be used to store our date in the /docs/ folder.
		The docs folder can be placed anywhere, but be sure you have no other folder anywhere in your project named "docs".

	*/

	$sounds = new KyloDocs("sounds"); #sounds.json will be created in /docs/ folder
	
	# First we will add in some keys and values for KyloDocs to use.

	$sounds->dog = "bark";
	$sounds->cat = "meow";
	$sounds->cow = "moo";

	/*

		KyloDocs has four main functions: Create, Read, Update, and Delete. Your CRUD commands.

		Create: You won't ever need to use Create because KyloDocs does that automatically when you make an object with it.

		Read: Read simply returns an array format of the JSON document you are working with.

		Update: Update is the most complex because you are given three modes: Default, Array, and Delete
				We will go over the functions of those three modes later on.
		
		Delete: Delete will remove the entire JSON document from the /docs/ folder.

		In this case, we will be using Update in Default mode.
		To make things simple, we will make a section in the JSON document called "animals".

	*/

	$sounds->update("animals");

	/*

		And that is all you need to do in Default mode.
		What is going on is the three keys and values we made above became an array like this:

			Array ( [dog] => bark [cat] => meow [cow] => moo )

		And the array was then encoded as JSON.
		Seems really simple now, but we can do other things that are more complex.
		To demonstrate, we will make a new object.
		
	*/

	$users = new KyloDocs("users");
	$users->user = "Bob";
	$users->pass = 123;
	$users->update("*","array");

	$users->user = "Joe";
	$users->pass = "password";
	$users->update(null,"array");

	$users->user = "Kylo";
	$users->pass = "secret"; # Totally my real password
	$users->update("admins","array");

	/*

		So what is going on over here? You can probably guess that it is registering users, but what is all this "*", null, and "array" stuff?
		To simply working with KyloDocs, I added in some sub-commands for Update.
		To begin, I added modes. Default requires no parameter to be given, but you can assign one where "array" is at if you really want to.
		Array mode is for when you want an array of data inside the JSON document. This is very useful for dealing with users.
		To explain what is going on, this is what users.json would look like right now if it were uncompressed:
		
			{
				"users":
				[
					{"user":"Bob","pass":123},
					{"user":"Joe","pass":"password"},
					"admins":
					[
						{"user":"Kylo","secret"}
					]
				]
			}

		If you are not familiar with JSON, it would be best to learn a bit about how it works before you carry on. For those that know it, keep reading.
		We have made an array in JSON with out Bob and Joe users, and then another "admins" array inside the "users" array.
		This kind of data organization will be very useful later on, but for now I will explain what "*" and null mean to us in KyloDocs.
		By default, KyloDocs will create the JSON file and put data inside it that looks like this:

			{"users":null}

		So you have a JSON variable named after the file with a value of null. This is mainly for giving the Update command something to dump data into.
		The Array mode turned that null into array brackets, [], and then dumped in the data.
		So why is "*" needed? The first parameter in Update is a way to naviagate through the arrays we are making.
		If left blank with Default mode, you will be dumping data straight into the users variable. However, we don't always use default mode.
		In those cases, you can either use "*" or null to target the users variable.

		Now to get a bit more complicated.

	*/

	$people = new KyloDocs("people");

	$people->Bob = "sports";
	$people->Joe = "art";
	$people->update("users/new");
	$people->Kylo = "programming";
	$people->update("users/admin");
	print_r($people->read());
	$people->delete = "Joe"; # Bye bye Joe.
	$people->update("users/new","delete");
	print_r($people->read());
	$people->delete();

	/*
		
		To clear things up now, here is what it will look like uncompressed on the last update:

			{
				"people":
				{
					"users":
					{
						"new":{"Bob":"sports"},
						"admin":{"Kylo":"programming"}
					}
				}
			}
		
		So first off, I showed an example on how to navigate deeper into the array by using a slash, /, much like a URL or folder directory.
		This logic shows how "users/new" goes down into users and then into new, like a folder.
		I also showed the Read command. This will give you an array form of the JSON that you can print out. This explains shows the changes after the delete.
		Then there is the Delete mode for Update that allows you to use the delete key. You give the delete a value, and it will delete the corresponding key in the array.
		Last thing I added in is the Delete command, not to be confused with Delete mode. This deletes the entire file, not just a key in the array.
		Even though the file is deleted, you can still display the data that was there prior to the deletion.


		That is the basics on operating KyloDocs, the rest is up to you to experiment with and use at your leisure.

		-Kylobite

	*/






