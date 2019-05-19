**************************************** OUTLINE ****************************************



1. Getting Started 		  line 14
2. Login Information 		  line 59
3. MySQL Database Information	  line 77
4. PHP Source Code Information    line 162





************************************ Getting Started ************************************



!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! DO NOT USE A REAL VIRUS !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! DO NOT USE A REAL VIRUS !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! DO NOT USE A REAL VIRUS !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! DO NOT USE A REAL VIRUS !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! DO NOT USE A REAL VIRUS !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

1. Install XAMPP on your computer.
2. Ensure the following files are located in the same directory in the parent folder 
   'htdocs' of the 'xampp' installation directory:
    1. account.php
    2. add_virus.php
    3. authenticate.php
    4. index.php
    5. index_css.css
    6. infected_file.php
    7. login.php
    8. mysql_methods.php
    9. remove_user.php
   10. user_logout.php
   11. verify_session.php
2. Execute the SQL file cs174.sql
3. Modify login.php
    • re-assign the PHP variables to your hostname, username, and password settings.
4. Login as root/admin at 
    
    http://localhost:<port number>/<your directory>/authenticate.php
    
    • email:    admin@sjsu.edu
    • password: cs174
5. Add an infected file
    • !!!!!!!!!!!!!!!!!!!!!!!!!!!!! DO NOT USE A REAL VIRUS !!!!!!!!!!!!!!!!!!!!!!!!!!!!!
6. Logout
7. Login as user with the following credentials:
    • email: 	student@sjsu.edu
    • password: cs174
8. Check if a file is infected by uploading the same infected file added earlier





*********************************** Login Information ***********************************



1. User login information for authenticate.php
    1a. email: 	  student@sjsu.edu
    1b. password: cs174

2. Root/admin login information for authenticate.php
    2a. email:    admin@sjsu.edu
    2b. password: cs174

    • These records already exist in the database in their corresponding table. 





******************************* MySQL Database Information ******************************



cs174.sql
    ♦ Objective: Database backup/restore file.
    ♦ About: 

        SHOW TABLES;
         _________________
        | Tables_in_cs174 |
        |_________________|
        |admin		  |
        |_________________|
        |salt 		  |
        |_________________|
        |users 		  |
        |_________________|
        |virus 		  |
        |_________________|

        DESCRIBE admin;
         __________________________________________________________________
        | Field   | Type 	    | Null | Key | Default | Extra 	   |
        |_________|_________________|______|_____|_________|_______________|
        |fname	  |varchar(128)     |NO	   |	 |NULL 	   |		   |
        |_________|_________________|______|_____|_________|_______________|
        |lname	  |varchar(128)	    |NO	   |	 |NULL 	   |		   |
        |_________|_________________|______|_____|_________|_______________|
        |username |varchar(128)	    |NO	   |UNI	 |NULL 	   |		   |
        |_________|_________________|______|_____|_________|_______________|	
        |password |varchar(128)	    |NO	   |	 |NULL 	   |		   |
        |_________|_________________|______|_____|_________|_______________|
        |salt1 	  |varchar(15) 	    |NO    | 	 |NULL 	   | 		   |
        |_________|_________________|______|_____|_________|_______________|
        |salt2 	  |varchar(15) 	    |NO    | 	 |NULL 	   | 		   |
        |_________|_________________|______|_____|_________|_______________|
        |id 	  |int(10) unsigned |NO	   |PRI	 |NULL 	   |auto_increment |
        |_________|_________________|______|_____|_________|_______________|

        DESCRIBE salt;
         __________________________________________________________________
        | Field   | Type 	    | Null | Key | Default | Extra 	   |
        |_________|_________________|______|_____|_________|_______________|
        |salt1 	  |varchar(15) 	    |NO    | 	 |NULL 	   | 		   |
        |_________|_________________|______|_____|_________|_______________|
        |salt2 	  |varchar(15) 	    |NO    | 	 |NULL 	   | 		   |
        |_________|_________________|______|_____|_________|_______________|
        |id 	  |int(10) unsigned |NO	   |PRI	 |NULL 	   |auto_increment |
        |_________|_________________|______|_____|_________|_______________|

        DESCRIBE users;
         __________________________________________________________________
        | Field   | Type 	    | Null | Key | Default | Extra 	   |
        |_________|_________________|______|_____|_________|_______________|
        |fname	  |varchar(128)     |NO	   |	 |NULL 	   |		   |
        |_________|_________________|______|_____|_________|_______________|
        |lname	  |varchar(128)	    |NO	   |	 |NULL 	   |		   |
        |_________|_________________|______|_____|_________|_______________|
        |username |varchar(128)	    |NO	   |UNI	 |NULL 	   |		   |
        |_________|_________________|______|_____|_________|_______________|	
        |password |varchar(128)	    |NO	   |	 |NULL 	   |		   |
        |_________|_________________|______|_____|_________|_______________|
        |id 	  |int(10) unsigned |NO	   |PRI	 |NULL 	   |auto_increment |
        |_________|_________________|______|_____|_________|_______________|

        DESCRIBE virus;
         __________________________________________________________________
        | Field   | Type 	    | Null | Key | Default | Extra 	   |
        |_________|_________________|______|_____|_________|_______________|
        |name	  |varchar(128)     |NO	   |	 |NULL 	   |		   |
        |_________|_________________|______|_____|_________|_______________|
        |signature|mediumtext       |NO	   |MUL	 |NULL 	   |	           |
        |_________|_________________|______|_____|_________|_______________|
        |date 	  |varchar(128)	    |NO	   |	 |NULL 	   |		   |
        |_________|_________________|______|_____|_________|_______________|	
        |time 	  |varchar(128)	    |NO	   |	 |NULL 	   |		   |
        |_________|_________________|______|_____|_________|_______________|
        |id 	  |int(10) unsigned |NO	   |PRI	 |NULL 	   |auto_increment |
        |_________|_________________|______|_____|_________|_______________|





****************************** PHP Source Code Information ******************************



 1. account.php 	  line 179
 2. add_virus.php 	  line 213
 3. authenticate.php 	  line 242
 4. index.php 		  line 277
 5. infected_file.php 	  line 288
 6. login.php 		  line 324
 7. mysql_methods.php 	  line 335
 8. remove_user.php 	  line 349
 9. user_logout.php 	  line 364
10. verify_session.php    line 375



account.php
    ♦ Objective: Create an account.
    ♦ About: 
        • HTML form for the following required fields:
            1. first name (2-32 characters inclusive)
            2. last name  (2-32 characters inclusive)
            3. email	  (up to 64 characters inclusive)
            4. password   (5-12 characters inclusive)
        • Table: HTML form fields and its corresponding database (Db) fields
         _______________________________________________________________________________
	|              |		     |		       |			|
	|  HTML Field  |   HTML Input Type   |  Db Field Name  |   Db Field Data Type   |
	|	       |		     |  Db: cs174      |			|
	|	       |		     |  Tbl: users     |			|
	|______________|_____________________|_________________|________________________|
	| first name   | type="text"	     | fname	       | varchar     		|
	|______________|_____________________|_________________|________________________|
	| last name    | type="text"	     | lname	       | varchar		|
	|______________|_____________________|_________________|________________________|
	| email        | type="email"	     | email	       | varchar		|
	|______________|_____________________|_________________|________________________|
	| password     | type="password      | password	       | int unsigned		|
	|______________|_____________________|_________________|________________________|
		
        • Form submission if all required fields are filled.
            ○ When the form is submitted, the program checks if the email is unique in 
              the  database 'cs174' for the table 'users'. If the email is unique and 
              all other fields are satisfied, then the user's record is inserted into
              the database and the user is redirect to the home page 'index.php'.
        • If the email already exists in the database then prompt a JavaScript alert box.
            ○ User is returned to 'account.php'.



add_virus.php
    ♦ Objective: Add a virus and its data to the database 'cs174' and table 'virus' if 
                 the record is unique
    ♦ About: 
        •  When a file upload is attempted, the program checks for file upload, file 
           size, and any other related errors.
    
           File upload errors include:
            a. UPLOAD_ERR_INI_SIZE
            b. UPLOAD_ERR_PARTIAL
            c. UPLOAD_ERR_NO_FILE
            d. default case (unknown error)

        • If no error was found, though it may exist undetected, check if the virus' 
          name and signature is unique against the database 'cs174' and table 'virus'.
            ○ If the record is unique, then insert the virus' name and signature into 
              the table 'virus'.
                - If the insert was successful then print an HTML table:
                     _____________________________________________________________________
                    | Virus Name | Virus Signature |    Date    |   Time   |      Id      |
                    |____________|_________________|____________|__________|______________|
                    |   <name>   |     <bytes>     | YYYY-MM-DD | HH:MM:SS | <primary key>|
                    |____________|_________________|____________|__________|______________|
                - Otherwise, print mySQL error message 
            ○  Otherwise, prompt a JavaScript alert box for duplicate record.
        •  Otherwise, prompt a JavaScript alert box for file error. 



authenticate.php
    ♦ Objective: User/root login page.
    ♦ About: 
        • HTML form for the following required fields:
            1. email
            2. password
        • Authenticate a user with the sequential steps:
            1. Execute a search query of the userd filled username field against the 
               database 'cs174' and table 'users' for the field 'username'
                1a. If a match is found, then retrieve the salt values from the table 
                    'salt' for the fields 'salt1' and 'salt2'.
                    Store the results into PHP variables.
                1b. Otherwise, prompt a JavaScript alert box for a invalid username and/
                    or password error.
                    Do not proceed any further steps. 
                    User may re-attempt login, repeating step 1.
            2. Invoke the PHP hash function with 'md5' as the first argument and 
               the salt values and user filled password field as the second argument, eg 
                   "$salt1$pw$salt2"

                   hash('md5', "$salt1$pw$salt2");
                
	       Store the result, a RIPEND-128 hash value, into a PHP variable.

	           <PHP variable> = hash('md5', "$salt1$pw$salt2");

            3. Execute a search query of the hash value against the table 'users' for 
               the field 'password'
                3a. If there's a match, then the user is authenticate and may proceed to 
                    infected_file.php. 
                3b. Otherwise, prompt a JavaScript alert box for a invalid username and/
                    or password error. 



index.php
    ♦ Objective: A homepage.
    ♦ About:
        • The styling is derived from the cascading style sheet file index_css.css.
        • A user has the option of either:
            1. logging in,
            2. creating an account,
         or 3. deleting an account



infected_file.php
    ♦ Objective: Grants the root user permission to add a virus to the database and/or 
                 check if a file is infected.

                 A user may only check if a file is infected.
    ♦ About:
        1. Check if a file is infected.
            • If the file is infected, then promot a JavaScript alert box.
                ○ Print the file's signature and highlight the infected bytes in 
                  red text onto the webpage. 
                ○ Print HTML table with the name of the virus and its signature (first 20 
                  bytes). Eg
                     ______________________________
                    | Virus Name | Virus Signature |
                    |____________|_________________|
                    |   <name>   |     <bytes>     |
                    |____________|_________________|

        2. Adding a virus
            • HTML form for the following fields:
                a) virus name
                b) file upload
            • Root user has privilege to insert a record, a known and newly discovered 
              infected file, the virus' name, and first 20 bytes of the file. 
                ○ Prompt a JavaScript alert box for a successful insert or error message.
                ○ If the insert was successful, then print an HTML table for the newly 
                  added virus, its name, signature, and timestamp when it was added to 
                  the database. Eg
                     _____________________________________________________________________
                    | Virus Name | Virus Signature |    Date    |   Time   |      Id      |
                    |____________|_________________|____________|__________|______________|
                    |   <name>   |     <bytes>     | YYYY-MM-DD | HH:MM:SS | <primary key>|
                    |____________|_________________|____________|__________|______________|



login.php
    ♦ Objective: A file containing login credentials to the database.
    ♦ About:
        • This file contains PHP variables for the following database login credentials 
            1. host name, 
            2. database name, 
            3. username, and 
            4. password 



mysql_methods.php
    ♦ Objective: A module for handling mySQL error messages and sanitizing input.
    ♦ About:
        • To include the module in the PHP script (assuming both the script and module 
          are located in the same directory) use:
    
            require_once 'mysql_methods.php';

        • The purpose of this module is to output mySQL error messages to the user and 
          sanitize input before it is inserted into the database. This attempts to 
          prevent cross-site scripting, also known as XSS.



remove_user.php 
    ♦ Objective: Remove a user.
    ♦ About: 
        • HTML form for the following required fields:
            1. email
            2. password
        • Form submission if all required fields are filled.
            ○  When the form is submitted, the user's filled email and password fields 
               are used to execute a database search. 
                - If there's a result found from the search then perform a query to 
                  remove the user from the database 'cs174' and table 'users'.
                - Otherwise, prompt a JavaScript alert box.



user_logout.php
    ♦ Objective: Logout a user
    ♦ About:
        • Logout a user with the following sequential steps:
            1. initialize the PHP session array to an empty array 
            2. destroy cookie
            3. destroy session
            4. redirect the user to the home page at index.php



verify_session.php
    ♦ Objective: Verify a PHP session
    ♦ About:
        • Check if a user's stored IP address matches the current one.
            ○ If it matches, then the user has been successfully authenticated.
                - Redirect user to infected_file.php
            ○ Otherwise, the session has been hijacked. 
                - Delete the current session and prompt the user to re-attempt login.
