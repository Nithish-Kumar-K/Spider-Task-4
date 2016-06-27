<!DOCTYPE html>
<?php
// define variables and set to empty values
$nameErr = $emailErr = $passwordErr = $conf_passwordErr = "";
$name = $email =$password = $conf_password =$abtme= "";
$flag=1;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $conn = mysqli_connect("localhost", "Nithish", "Hohaahoh","bulletin_board");
  if(!$conn){
    die("Error! Cannot connect to the database");
  }

   if(!preg_match("/^[a-zA-Z\_ ]*$/",$_POST["username"])) {
      $nameErr = "*userame can have only alphanumerals and underscore";
      $flag=0;
   }
   //use of htmlspecialchars is to prevent hacking
   else{
      $name=htmlspecialchars($_POST["username"]);
    //  $abtme=htmlspecialchars($_POST["name"]);
    }
   if(!filter_var($_POST["email"],FILTER_VALIDATE_EMAIL)) {
     $emailErr = "*Email format Invalid";
     $flag = 0;
   }
   else
     $email=htmlspecialchars($_POST["email"]);

   if(!(strlen($_POST['password']) >= 8)){
     $passwordErr = '*Password should be atleast 8 characters';
     $flag = 0;
   }
   else {
     $password = $_POST['password'];
   }

   if(strcmp($password,$_POST['conf_password']) == 0){
     $conf_password = $_POST['conf_password'];
   }
   else{
     $conf_passwordErr = 'These passwords do not match. Please try again.';
   }

   $abtme=htmlspecialchars($_POST["abtme"]);
  //flag is one if data is valid

   if($flag) {

     $sqlins=$conn->prepare("INSERT INTO users (USERNAME,EMAIL,ABOUT_ME,PASSWORD,ACCESS)
     VALUES(?,?,?,?,?)");
     $access = 'viewer';
     //this will prevent sql injection
     if($sqlins) {
        $sqlins->bind_param("sssss",$name,$email,$abtme,$password,$access);
     }
    else {
        die("Error preparing statements");
     }
    $regis = $sqlins->execute();
    if(!($regis)) {
      //echo "Error Type : ",mysqli_error($conn),"<br>";
      die("Username already exists! Give new username");
    }
     //if($regis)
    //  echo "sdf";
     //$sqlins->close();
     //close connection to improve efficiency*/
   }
   $conn->close();
}


?>

  <html>
		<head>
			<link type="text/css" rel="stylesheet" href="studentdatabase.css"/>
      <style>
        body{
          text-align: left;
        }

        h1{
          /*transform: translate(38vw);*/
          text-align: center;
        }

      </style>
      <title>
        User registration page
      </title>
		</head>

		<body >
        <h1 >Student Registration Form</h1>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" name="studentregistration">
          <h3>Username</h3>
          <input type="text" name="username"  placeholder="Type your user name" size="33.8"
          value="<?php echo $name;?>" required >
          <!--the spans are providing error message, nameError stores the error message for name-->
          <span class="error"> <?php echo $nameErr;?></span><br/><br/>

          <h3>E-Mail</h3>
          <input type="text" name="email" placeholder="Type your email" size="33.8"
          value="<?php echo $email;?>" required>
          <span class="error"> <?php echo $emailErr;?></span><br/><br/>

          <h3>About Me</h3>
          <textarea name="abtme" cols="32" rows="5" placeholder="Tell us something about yourself"><?php echo $abtme;?> </textarea>
          <br/><br/>

          <h3>Create a password </h3>
          <input type="password" name="password" placeholder="Type your password" required size="33.8"><br/><br/>
          <span class="error"> <?php echo $passwordErr;?></span><br/><br/>

          <h3>Confirm your password </h3>
          <input type="password" name="conf_password" placeholder="Type your password" required size="33.8"><br/><br/>
          <span class="error"> <?php echo $conf_passwordErr;?></span><br/><br/>

          <input type="submit" name="submit" value="Submit">
          <br/><br/>

          <span>
              <?php
              if($regis) {
                echo '<script type="text/javascript">alert
                ("You have registered successfully");</script>';
                header('Location: loginpage.php');
                //echo "You have registered successfully. <br>";
              }
              ?>
         </span>

        </form>

		</body>
	</html>
