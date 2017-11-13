<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
extract ( $_POST );
?>
<html xmlns = "http://www.w3.org/1999/xhtml">
   <head>
      <title>New User</title>
   </head>

   <body style = "font-family: arial,sans-serif">

      <strong>The following user information has been saved 
          in our database:</strong><br />
   
      <table width="410" height="66" border = "0" cellpadding = "0" cellspacing = "10">
         <tr>
            <td width="90" bgcolor = "#ffffaa">First Name</td>
            <td width="90" bgcolor = "#ffffbb">Last Name</td>
            <td width="120" bgcolor = "#ffffbb">Email</td>
            <td width="80" bgcolor = "#ffffbb">Phone</td>
         </tr>

         <tr>
            <?php

               // print each form field’s value
               print( "<td>$first_name</td>
			   	  <td>$last_name</td>
				  <td>$email</td>
				  <td>$phone</td>" );
				  ?>
         </tr>
      </table>
   
      <br /><br /><br />

	  <?php

		// Create connection
		$database = new mysqli("localhost", "mgiezema", "mgiezema01", "g1");
	    // Check connection
       if ($database->connect_error) {
        die("Connection failed: " . $database->connect_error);
      }
	  // Start by checking if the user email is already in the database - if yes, update user info.
	  // If not, add the new user.
	  	if ( !( $result = $database->query ( "SELECT user_id FROM user 
		    WHERE (email = '$email')") ) )
			print ("Warning!   could not execute user query <br />" );
	    $row = $result->fetch_assoc();
		$user_id = $row["user_id"];
		if ($user_id != 0) { print("User $email is already in the database. User information has been updated to match the above.<br>");
			$database->query("UPDATE user SET first_name = '$first_name', last_name = '$last_name', phone = '$phone' WHERE user_id = '$user_id'");
			}
		else
		{
			$database->query("INSERT INTO user (first_name,last_name,email,phone) VALUES ('$first_name','$last_name','$email','$phone')");
			$user_id = $database->insert_id;
		}
		
		$database-close();

	  			?>
	  
   </body>
</html>
