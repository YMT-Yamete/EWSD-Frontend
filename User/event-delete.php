<?php 
	$connect = mysqli_connect('localhost', 'root', '', 'hexauniversity');
	session_start();
	if (!isset($_SESSION['UserID'])) 
	{
	    echo "<script>alert('Please Login first')</script>";
	    echo "<script>window.location='login.php'</script>";
	}
	if ($_SESSION['RoleID'] != 'R-000001') 
	{
    	echo "<script> alert('You do not have permission to view this page')</script>";
  	}

	if ($_GET['eventID']) {
		$eventID = $_GET['eventID'];
		$select = "SELECT StartDate FROM events WHERE EventID = '$eventID'";
		$query = mysqli_query($connect, $select);
		$arr = mysqli_fetch_array($query);
		$startDate = $arr['StartDate'];
		$todayDate = date("Y-m-d");

		if ($todayDate < $startDate) {
			$delete = "DELETE FROM events WHERE EventID = '$eventID'";
			$query = mysqli_query($connect, $delete);
			if ($query) {
				echo "<script>alert('Event deleted.')</script>";
				echo "<script>window.location='events.php'</script>";
			}
			else
			{
				echo mysqli_error($connect);
			}
		}
		else
		{
			echo "<script>alert('You cannot delete events once they are started.')</script>";
			echo "<script>window.location='events.php'</script>";
		}
		
	}
	
?>