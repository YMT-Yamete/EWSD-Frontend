<?php  
  session_start();
  $connect = mysqli_connect('localhost', 'root', '', 'hexauniversity');
  if (!isset($_SESSION['UserID'])) 
  {
     echo "<script> alert('Please Login first')</script>";
     echo "<script>window.location='login.php'</script>";
  }
  if ($_SESSION['RoleID'] != 'R-000001') {
    echo "<script> alert('You do not have permission to view this page')</script>";
  }
  
  $categoryID = $_GET['categoryID'];
  $select = "SELECT * FROM Ideas WHERE CategoryID = '$categoryID'";
  $query = mysqli_query($connect, $select);
  $count = mysqli_num_rows($query);
  if ($count == 0) {
  	$delete = "DELETE FROM Categories WHERE CategoryID = '$categoryID'";
    $query = mysqli_query($connect, $delete);
  	if ($query) {
  		echo "<script>alert('Category Deleted');</script>";
  		echo "<script>window.location='categories.php'</script>";
  	}
  	else {
  		echo mysqli_error($connect);
  	}
  }
  else
  {
  	echo "<script>alert('Cannot delete. This category is used by some ideas.')</script>";
  	echo "<script>window.location='categories.php'</script>";
  }
?>