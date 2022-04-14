<?php 
	session_start();
	unset($_SESSION['AdminID']);
	unset($_SESSION['Adminname']);
	unset($_SESSION['SortBy']);
	echo "<script>alert('Logged out.');</script>";
	echo "<script>window.location='login.php';</script>";
?>