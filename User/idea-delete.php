<?php 
$connect = mysqli_connect('localhost', 'root', '', 'hexauniversity');
session_start();
$ideaID=$_GET['IdeaID'];
	
	$select = "SELECT * FROM Ideas WHERE IdeaID = '$ideaID'";
	$query = mysqli_query($connect, $select);
	$arr = mysqli_fetch_array($query);
	$postOwner= $arr['UserID'];

	if ($_SESSION['UserID'] == $postOwner or $_SESSION['RoleID'] == "R-000001") {
		$deleteCmts = "DELETE FROM comments WHERE IdeaID='$ideaID'";
		$deleteReacts = "DELETE FROM reacts WHERE IdeaID='$ideaID'";
		$delete="Delete from ideas where IdeaID='$ideaID'";
		$resultCmts= mysqli_query($connect,$deleteCmts);
		$resultReacts= mysqli_query($connect,$deleteReacts);
		$result= mysqli_query($connect,$delete);
		if ($result && $resultReacts && $resultCmts) {
		 	echo "<script>window.alert('Idea Deleted!')</script>";
			echo "<script>window.location='ideas.php'</script>";
		 } 
		 else{
		 	echo "<p><script>window.alert('Something went wrong')</script>". mysqli_error($connect) ."</p>";
		 }
	}
	else
	{
		echo "<script>alert('You have no permission to delete this post')</script>";
		echo "<script>window.location='ideas.php'</script>";
	}

?>