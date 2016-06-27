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
	 //$_SESSION['name'] = $name;
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
    <style>
      body{
        text-align: center;
        background-image: url("beforeloginbackground.jpg");
        no-repeat center center fixed;
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cove1
        display:inline-block;

      }
      .button {
          background-color: #337ab7;
          border: none;
          color: white;
          padding: 15px 32px;
          text-align: center;
          text-decoration: none;
          display: inline-block;
          font-size: 16px;
          margin: 4px 2px;
          cursor: pointer;
      }
      #login{
        font-size: 4vh;
        font-family: "Oxygen","Oxygen";
      }
      #link{
        float: right;
        font-size: 4vh;
        font-family: "Oxygen","Oxygen";
        }
      input{
        color: black;
        font-weight: 900;
        width: 21.5vw;
        padding: 12px 0vh;
        background: transparent;
        border: 0;
        border-bottom: 1px solid #435160;
        outline: none;

        font-size: 16px;
      }
    </style>
    <title>
      Login
    </title>
  </head>

  <body >
    <a href ="registration.php" id="link" class="button">Signup?</a>
    <br/><br/><br/>
      <h1>TESV: SKYRIM</h1><h1> BULLETIN BOARD<h1>
      <h1>Log In</h1>
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" name="studentlogin">
        <input type="text" name="username"  placeholder="Enter your username" size="33.8"
        value="<?php echo $name;?>" required ><br/>
        <!--the spans are providing error message, nameError stores the error message for name-->
        <span class="error"> <?php echo $nameErr;?></span><br/><br/>
        <input type="password" name="password" placeholder="Type your password" required size="33.8"><br/><br/>
        <span class="error"> <?php echo $passwordErr;?></span><br/>
        <input type="submit" class="button" name="submit" value="Login" id="login"><br/><br/>
      </form>


  </body>
</html>
