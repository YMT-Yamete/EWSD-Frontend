<?php 
$connect = mysqli_connect('localhost', 'root', '', 'hexauniversity');
$DepartmentID=$_GET['DepartmentID'];
$select = "SELECT * FROM users where DepartmentID = '$DepartmentID'";
$query = mysqli_query($connect ,$select);
$count = mysqli_num_rows($query);
echo $count;
if ($count == 0) {
	$delete="Delete from departments where DepartmentID='$DepartmentID'";
	$result= mysqli_query($connect,$delete);
	if ($result) {
	 	echo "<script>window.alert('Deparment Deleted!')</script>";
		echo "<script>window.location='departments.php'</script>";
	 } 
	 else{
	 	echo "<p><script>window.alert('Something went wrong')</script>". mysqli_error($connect) ."</p>";
	 }
}
else
{	
	echo "<script>alert('Department members should be empty in order to delete.')</script>";
	echo "<script>window.location='departments.php'</script>";
}

?>