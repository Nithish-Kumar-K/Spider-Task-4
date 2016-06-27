<!DOCTYPE html>
<script>
  function del(id) {
      if (confirm('Are you sure you want to delete this post?')) {
        document.getElementById("store").value = id;
        document.getElementById("form").submit();
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
  $access = $_SESSION['access'];
  $flag = 0;
  $conn = mysqli_connect("localhost", "Nithish", "Hohaahoh","bulletin_board");
  if(!$conn){
    die("Error! Cannot connect to the database");
  }
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //echo 234;
    $temp = $_POST['store'];
    //echo $temp;
    $selquery = "DELETE FROM board WHERE ID ='$temp'";
    $result =  $conn->query($selquery);
    //if($result)
     //echo 91234;
  }
  $selquery="SELECT * FROM board";

  $result = $conn->query($selquery);
  if($result){
    if($result->num_rows > 0) {
           echo "<table align='center'>";
           echo "<col width = '600vw'>";
           echo '<tr></tr>';
           while($row = mysqli_fetch_assoc($result)) {
             echo "<tr><td height = '100vh'>";
             echo $row['BULLETIN'];
             $id = $row['ID'];

             if((strcmp($access,'admin') == 0)){
               //printf('<a href= "#" onClick="showDetails(\'%s\');">%s</a> ', $node, $insert);
               printf('<img src = "download.png" class="deleteimg" onclick ="del(\'%s\');"
               height ="20" width ="20" ></img>',$id);
               //echo '<img src = "download.png" onclick = "del($id)"
               //height = "20" width = "20"></img>';
           }
           echo '</td>';
           echo '</tr>';
           }
           //echo '</table>';
           echo '<br>';
         }
         else {
           echo "<table align='center'>";
           echo "<col width = '600vw'>";
           echo '<tr></tr>';
           echo "<tr><td height = '100vh'>";
           echo 'No posts here';
           echo '</td></tr>';

           //echo '</table>';
         }
          //echo "sdfdfs";


          //echo $access;echo 123;//echo $access;
          if((strcmp($access,'editor') == 0))
            $flag = 1;
          else if((strcmp($access,'admin') == 0))
            $flag = 2;


  }
  else{
    die("Error getting data!");
     $conn->close();
}

?>

	<html>
		<head>
			<link type="text/css" rel="stylesheet" href="bulletinpage.css"/>

			<title>
        Bulletin Board
      </title>

		</head>

		<body >
      <a href="loginpage.php" class="button" id="logout">Logout</a>
      <?php if($flag == 2) : ?>
        <a href="admin_panel.php" class="button" id="admin_panel">Admin Panel</a>
      <?php endif; ?>
      <br/><br/>
      <h1>Welcome <?php echo $name ?></h1>
      <form id="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" name="studentregistration">
        <input type = 'hidden' id = 'store' name = 'store'>
      </form>
      <?php if($flag) : ?>
        <button type="button" id="add_post" class="button"
        onclick="location.href='add_bulletin.php'">Add Post</button>
      <?php endif; ?>
      <p></p>
      <h1>Bulletin Board</h1>

		</body>
	</html>
