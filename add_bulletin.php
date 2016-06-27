<?php
session_start();
if(!$_SESSION['login']){
  header("location:loginpage.php");
  die;
}
$conn = mysqli_connect("localhost", "Nithish", "Hohaahoh","bulletin_board");
if(!$conn){
  die("Error! Cannot connect to the database");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $bullet = htmlspecialchars($_POST['add_post']);

  $sqlins=$conn->prepare("INSERT INTO board (BULLETIN) VALUES(?)");
  //this will prevent sql injection
  if($sqlins) {
     $sqlins->bind_param("s",$bullet);
  }
 else {
     die("Error preparing statements");
  }
 $regis = $sqlins->execute();
 if(!($regis)) {
   die("Error preparing statements");
 }
}
?>
<html>
  <body >
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" name="bulletin_view">
      <br/><br/>
      <h3>Add a new post</h3>
      <textarea name="add_post" cols="80" rows="10" placeholder="Tell us something about yourself"><?php echo $abtme;?> </textarea>
      <br/><br/>
      <input type="submit" name="submit" value="Add new post"><br/><br/>
      <button type="button" id="bulletinpage" onclick="location.href='bulletinpage.php'">Back to bulletin page</button>
      </form>

  </body>
</html>
