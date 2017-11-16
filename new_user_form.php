<html>
<head>
<meta content="text/html; charset=ISO-8859-1"
http-equiv="content-type">
<title>New User</title>
</head>
<body>
 <h2>Enter New User Information</h2>
  <?php
$database=mysqli_connect('localhost', 'mgiezema', 'mgiezema01','g1');
?>
 <form method = "post"
		action = "http://g1.psjconsulting.com/new_user.php"
		>

First Name: <input type="text" name="first_name" required pattern="[A-Za-z' -]+" title="Only letters, spaces, apostrophes, and hyphens are allowed."> <br><br>
Last Name: <input type="text" name="last_name" required pattern="[A-Za-z' -]+" title="Only letters, spaces, apostrophes, and hyphens are allowed."> <br><br>
Email: <input type="email" name="email" required> <br><br>
Phone Number: <input type="tel" name="phone" required pattern="[0-9]{3}[ -][0-9]{3}[ -][0-9]{4}" title="Use format 000-000-0000"> <br><br>

<br><br>
<input type="submit" name="submit">
</form>
</body>
</html>
