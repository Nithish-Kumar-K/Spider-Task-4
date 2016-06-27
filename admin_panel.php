<!DOCTYPE html>
<script>
var access;
function user(flag){
  access = flag;
  document.getElementById("storeaccess").value = access;
  document.getElementById("form").submit();
  }
function update(username) {
    if (confirm('Are you sure you want to make this update?')) {
      document.getElementById("storename").value = username;
      }
  }
</script>
<?php
// define variables and set to empty values
  session_start();

  if(!$_SESSION['login']){
    header("location:loginpage.php");
    die;
  }
  $name=$_SESSION['name'];
  $flag = 0;
  $conn = mysqli_connect("localhost", "Nithish", "Hohaahoh","bulletin_board");
  if(!$conn){
    die("Error! Cannot connect to the database");
  }

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
     //echo 91234;echo $_POST['storename']; echo $_POST['storeaccess'];
      $uname = $_POST['storename'];
      $acces = $_POST['storeaccess'];
      $sqlinse=$conn->prepare("UPDATE users SET ACCESS=?  WHERE USERNAME=?");

     //this will prevent sql injection
      if($sqlinse) {
        $sqlinse->bind_param("ss",$acces,$uname);
      }
      else {
        die("Error preparing statements");
      }
      $regis = $sqlinse->execute();
  }

  $selquery="SELECT * FROM users";

  $result = $conn->query($selquery);
  if($result){
    if($result->num_rows > 0) {
      echo "<table align='center'>";
      echo "<col width = '500vw'>";
      echo "<col width = '300vw'>";
      echo '<tr><th>Username</th><th>Access Level</th></tr>';
      while($row = mysqli_fetch_assoc($result)) {
          $flag = 0;
        if((strcmp($row['ACCESS'],'editor') == 0))
          $flag = 1;
        else if((strcmp($row['ACCESS'],'admin') == 0))
          $flag = 2;
        echo "<tr><td height = '100vh'>";
        echo $row['USERNAME'];
        $editor = 'editor'; $admin = 'admin'; $viewer = 'viewer';
        //echo $flag;
        echo '</td><td>';
        if($flag == 1){
          echo 'Current Status: Editor';
          echo '<br>';
          echo 'Change to:';
          printf('<button class="butto" onclick ="update(\'%s\');user(\'%s\');">
          Viewer',$row["USERNAME"],$viewer);
          printf('<button class="butto"  onclick ="update(\'%s\');user(\'%s\');">
          Admin',$row["USERNAME"],$admin);
       }
       else if($flag == 0){
         echo 'Current Status: Viewer';
         echo '<br>';
         echo 'Change to:';
         printf('<button class="butto"  onclick ="update(\'%s\');user(\'%s\');">
         Editor',$row["USERNAME"],$editor);
         printf('<button class="butto"  onclick ="update(\'%s\');user(\'%s\');">
         Admin',$row["USERNAME"],$admin);
       }
       else
        echo 'Current Status: Admin';
        echo '<br>';
        echo '</td></tr>';
      }
      echo '<br>';
    }
         $selquery="SELECT * FROM users WHERE USERNAME = '$name'";
         //echo $name;
         $result = $conn->query($selquery);
         if ($result->num_rows > 0) {
           //echo "sdfdfs";
          $row = $result->fetch_assoc();
          $access = $row['ACCESS'];//echo $access;
          if((strcmp($row['ACCESS'],'editor') == 0))
            $flag = 1;
          else if((strcmp($row['ACCESS'],'admin') == 0))
            $flag = 2;

       }
  }
  else{
    die("Error getting data!");
     $conn->close();
}

?>

	<html>
		<head>
			<link type="text/css" rel="stylesheet" href="adminpanel.css"/>

			<title>
        Admin Panel
      </title>
      <style>

    </style>
		</head>

		<body >
      <a href = "bulletinpage.php" class="button" id="b">Back to Bulletin Page</a>
      <br><br><br>
      <h1>Admin Panel</h1>
      <form id="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" name="studentregistration">
        <input type = 'hidden' id = 'storename' name = 'storename'>
        <input type = 'hidden' id = 'storeaccess' name = 'storeaccess'>
      </form>
    </body>
	</html>
