<?php
session_start();
$name=$_SESSION['name'];

if(!$_SESSION['login']){
  header("location:loginpage.php");
  die;
}
$conn = mysqli_connect("localhost", "Nithish", "Hohaahoh","bulletin_board");
if(!$conn){
  die("Error! Cannot connect to the database");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $bullet = $name." says, <br>".htmlspecialchars($_POST['add_post']);

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
   header("location:bulletinpage.php");
}
?>
<html>
  <head>
    <link type="text/css" rel="stylesheet" href="addbulletin.css"/>
    <title>
      Add Post
    </title>
  </head>
  <body >
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" name="bulletin_view">
      <br/><br/>
      <h1>Add a new post</h1>
      <textarea name="add_post" cols="60" rows="20" placeholder="Enter your post here"><?php echo $abtme;?> </textarea>
      <br/><br/>
      <input type="submit" name="submit" value="Add new post" id="new_post" class="button"><br/><br/>
      </form>

  </body>
</html>
