<!DOCTYPE html>
<?php
// define variables and set to empty values
$nameErr = $emailErr = $passwordErr = $captcha_error= $conf_passwordErr = "";
$name = $email =$password = $conf_password =$abtme= "";
$flag=1;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $url ='https://www.google.com/recaptcha/api/siteverify';
  $privatekey = "6Le8uSMTAAAAAK8V10SxtuBMh8ghLkWvej5CSu3d";
  $response = file_get_contents($url."?secret=".$privatekey."&response=".
  $_POST['g-recaptcha-response']."&remoteip=".$_SERVER['REMOTE_ADDR']);
  $data = json_decode($response);

  if(isset($data->success) AND $data->success==true){
    $flag=1;
  }
  else{
    $flag=0;
    $captcha_error = 'You have not given the captcha properly';
  }

  $conn = mysqli_connect("localhost", "Nithish", "Hohaahoh","bulletin_board");
  if(!$conn){
    die("Error! Cannot connect to the database");
  }

   if(!preg_match("/^[a-zA-Z0-9\_ ]*$/",$_POST["username"])) {
      $nameErr = "*userame can have only alphanumerals and underscore";
      $flag=0;
   }
   //use of htmlspecialchars is to prevent hacking
   else{
      $name=htmlspecialchars($_POST["username"]);
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
     $flag = 0;
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
      die("Username already exists! Give new username");
    }

   }
   $conn->close();
}


?>

  <html>
		<head>
			<link type="text/css" rel="stylesheet" href="studentdatabase.css"/>
      <style>
      body{
        font-weight: 900;
        background-image: url("registrationbackground.jpg");
        no-repeat center center fixed;
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cove1
        text-align: center;
        display:inline-block;
        transform: translate(35vw);
      }
      #submit{
        font-size: 4vh;
        font-weight: 900;
        width: 21.5vw;
        height: 7vh;
        padding-top: 10px;
        padding-bottom:25px;
        color: #fff;
        background-color: #337ab7;
        border-color: #2e6da4;
      }
      h1{
        /*transform: translate(38vw);verdana,geneva,*/
        text-align: center;
      }
      #transparent{
        background-color:grey;
        padding-left: 5vw;
        padding-right: 5vw;
        border: 1px solid black;
        opacity: 1;
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
        Signup
      </title>
      <script src='https://www.google.com/recaptcha/api.js'></script>
		</head>

		<body >
        <h1 >Signup</h1>
        <div id = "transparent">
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

          <div class="g-recaptcha" data-sitekey="6Le8uSMTAAAAAPBtPryj7IZdGC7SC27uYWfIqUJ_"></div><br><br>
          <span class="error"> <?php echo $captcha_error;?></span><br/><br/>

          <input type="submit" name="submit" value="Submit" id="submit">
          <br/><br/>

          <span>
              <?php
              if($regis) {
                echo '<script type="text/javascript">alert
                ("You have registered successfully");</script>';
                //header('Location: loginpage.php');
                }
              ?>
         </span>

        </form>
      </div>
		</body>
	</html>
