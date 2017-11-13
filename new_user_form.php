<html>
<head>
<meta content="text/html; charset=ISO-8859-1"
http-equiv="content-type">
<title>New Employee</title>
</head>
<body>
 <h2>Enter a New Employee</h2>
  <?php
$database=mysqli_connect('localhost', 'mgiezema', 'mgiezema01','g1');
?>
 <form method = "post"
		action = "http://g1.psjconsulting.com/new_user.php"
		>

First Name: <input type="text" name="first_name"> <br><br>
Last Name: <input type="text" name="last_name"> <br><br>
Email: <input type="text" name="email"> <br><br>
Phone Number: <input type="text" name="phone"> <br><br>

<br><br>
<input type="submit" name="submit">
</form>
</body>
</html>