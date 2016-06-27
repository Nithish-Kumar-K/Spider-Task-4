<!DOCTYPE html>
<?php

// define variables and set to empty values
session_start();
$name = $password = "";
$nameErr = $passwordErr = "";
$flag=1;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	 //use of htmlspecialchars is to prevent hacking
   if(!preg_match("/^[a-zA-Z\_ ]*$/",$_POST["username"])) {
     $nameErr = "*Username can have only alphanumerals and underscore";
     $flag=0;
   }
   else {
     $name=htmlspecialchars($_POST["username"]);
   }
	 $_SESSION['name'] = $name;
   $password = htmlspecialchars($_POST["password"]);
   //if roll no is valid
   if($flag){
		 $conn = mysqli_connect("localhost", "Nithish", "Hohaahoh","bulletin_board");
	   if(!$conn){
	     die("Error! Cannot connect to the database");
	   }//echo $name;

	   $selquery="SELECT * FROM users WHERE USERNAME = '$name'";
     //echo $name;
	   $result = $conn->query($selquery);
	   if ($result->num_rows > 0) {
       //echo "sdfdfs";
	     $row = $result->fetch_assoc();
       if(strcmp($row["PASSWORD"],$_POST['password']) == 0){
        $_SESSION['name'] = $name;
        $_SESSION['login'] = true;
        $_SESSION['access'] = $row['ACCESS'];
        //echo $row['ACCESS'];
        header('Location: bulletinpage.php');
      }
       else {
         $passwordErr = "Incorrect password";
       }

	 }
	 else {
	      //$nameErr = "*No such user";
        echo '<script type="text/javascript">alert("No such user! Please enter your details again!");</script>';
	 }
	    $conn->close();

	 }
}
?>
<html>
  <head>
    <link type="text/css" rel="stylesheet" href="studentdatabase.css"/>
    <style>
      body{
        text-align: center;
      }

      h1{
        /*transform: translate(38vw);*/
        text-align: center;
      }

    </style>
    <title>
      Login
    </title>
  </head>

  <body >
      <h1 >Login to continue to NITT bulletin board</h1>

      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" name="studentlogin">
        <input type="text" name="username"  placeholder="Enter your username" size="33.8"
        value="<?php echo $name;?>" required ><br/>
        <!--the spans are providing error message, nameError stores the error message for name-->
        <span class="error"> <?php echo $nameErr;?></span><br/><br/>
        <input type="password" name="password" placeholder="Type your password" required size="33.8"><br/><br/>
        <span class="error"> <?php echo $passwordErr;?></span><br/>
        <input type="submit" name="submit" value="Login"><br/><br/>
      </form>
      <a href ="registration.php">New registration</a>
  </body>
</html>
