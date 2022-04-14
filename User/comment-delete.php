<?php 
$connect = mysqli_connect('localhost', 'root', '', 'hexauniversity');
$CommentID=$_GET['CommentID'];
$IdeaID=$_GET['IdeaID'];

$delete="Delete from comments where CommentID='$CommentID'";
	$result= mysqli_query($connect,$delete);
	
	if ($result) {
	 	echo "<script>window.alert('Comment Deleted!')</script>";
		echo "<script>window.location='ideas-comment.php?IdeaID=$IdeaID'</script>";
	 } 
	 else{
	 	echo "<p><script>window.alert('Something went wrong')</script>". mysqli_error($connect) ."</p>";
	 }

?>