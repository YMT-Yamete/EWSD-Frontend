<?php  
	session_start();
	unset($_SESSION['UserID']);
	unset($_SESSION['RoleID']);
	unset($_SESSION['SortBy']);
	echo "<script>alert('Logged out.');</script>";
	echo "<script>window.location='login.php';</script>";
?>