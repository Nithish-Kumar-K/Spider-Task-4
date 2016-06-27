<!DOCTYPE html>
<script>
function update(username,flag) {
    if (confirm('Are you sure you want to make this update?')) {
      document.getElementById("storename").value = username;

        var select = document.getElementById("access2");
        alert(select);
      document.getElementById("storeaccess").value = select;
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
  $flag = 0;
  $conn = mysqli_connect("localhost", "Nithish", "Hohaahoh","bulletin_board");
  if(!$conn){
    die("Error! Cannot connect to the database");
  }

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
     echo 91234;echo $_POST['storename']; echo $_POST['storeaccess'];
     /*$sqlinse=$conn->prepare("UPDATE users SET ACCESS=?  WHERE USERNAME=?");

     //this will prevent sql injection
      if($sqlinse) {
        $sqlinse->bind_param("ss",$name,$dept,$email,$addr,$abtme,$rollno);
      }
      else {
        die("Error preparing statements");
      }
      $regis = $sqlinse->execute();
      if($regis) {
        echo "You have updated successfully. <br>";
      }
     else {
        echo "Error Type : ",mysqli_error($conn),"<br>";
        die("Error updating into database");
      }*/
  }

  $selquery="SELECT * FROM users";

  $result = $conn->query($selquery);
  if($result){
    echo '<br><br>';
    if($result->num_rows > 0) {
      $rsltmess = $result->num_rows.' Results found'.'<br>';
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
        //echo $flag;
        echo '</td><td>';
        if($flag == 1){
          echo'
          <select name="access" id="access1">
            <option value="Editor">Editor</option>
            <option value="Viewer">Viewer</option>
            <option value="Admin">Admin</option>
          </select>';
          echo '<script type="text/javascript">var select = document.getElementById("access1");</script>';
          printf('<button onclick ="update(\'%s\');">
          Update',$row["USERNAME"],$flag);

       }
       else if($flag == 0){
         echo'
         <select name="access" id="access2">
           <option value="Viewer">Viewer</option>
           <option value="Editor">Editor</option>
           <option value="Admin">Admin</option>
         </select>';
         printf('<button onclick ="update(\'%s\');">
         Update',$row["USERNAME"],$flag);
       }
       else
        echo 'Admin';
        echo '</td></tr>';
      }
      echo '</table>';
      echo '<br>';
    }
    else {
    //$rsltmess = $result->num_rows.' Results found'.'<br>';
      echo "<table align='center'>";
      echo "<col width = '500vw'>";
      echo "<col width = '300vw'>";
      echo '<tr><th>Username</th>';
      echo'<th>Access Level</th></tr>';

             echo "<tr><td height = '100vh'>";
             echo 'No posts here';
             echo '</td></tr>';

           echo '</table>';
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
			<link type="text/css" rel="stylesheet" href="studentdatabase.css"/>

			<title>
        Admin Panel
      </title>
      <style>
        body {
          font-family: calibri,sans-serif;
          color: darkslategray;
        }
        th {
          background-color: #58FAF4;
          color:black;
          font-weight: 200;
        }
        th,td {
          text-align: center;
          font-family: calibri,sans-serif;
          padding: 7px;
          border-bottom: 1px solid darkgray;
        }
        tr:nth-child(odd) {
          background-color: lightgray;
          color : black;
        }
    </style>
		</head>

		<body >
      <form id="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" name="studentregistration">
        <input type = 'hidden' id = 'storename' name = 'storename'>
        <input type = 'hidden' id = 'storeaccess' name = 'storeaccess'>
      </form>
      <a href = "bulletinpage.php">Bulletin Page</a>
    </body>
	</html>
