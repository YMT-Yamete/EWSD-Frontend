<?php
	$connect = mysqli_connect('localhost', 'root', '', 'hexauniversity');
	include 'AutoID.php';
	session_start(); 
	if (isset($_POST['btnLike'])) 
	{
		$reactID = AutoID("Re", 6, 'reacts', 'ReactID'); 
		$react = "like";
		$IdeaID = $_POST['txtIdeaID'];
		$UserID = $_SESSION['UserID'];

		$select = "SELECT * FROM reacts WHERE UserID = '$UserID' AND IdeaID = '$IdeaID'";
		$selectQuery = mysqli_query($connect, $select);
		$count = mysqli_num_rows($selectQuery);

		if ($count == 0) {
			 $like = "INSERT INTO reacts VALUES ('$reactID', '$react', '$IdeaID', '$UserID')";
	    	 $queryreact = mysqli_query($connect, $like);
		}
	   	else {
	   		 $updateReact = "UPDATE reacts SET React = '$react' WHERE UserID = '$UserID' AND IdeaID = '$IdeaID'";
	   		 $queryreact = mysqli_query($connect, $updateReact);
	   	}

	   	//-----------react count----------------------

	   	$selectLike = "SELECT * FROM reacts WHERE IdeaID = '$IdeaID' AND React = 'like'";
	   	$selectLikeQuery = mysqli_query($connect, $selectLike);
	   	$likeCount = mysqli_num_rows($selectLikeQuery);

	   	$selectDislike = "SELECT * FROM reacts WHERE IdeaID = '$IdeaID' AND React = 'dislike'";
	   	$selectDislikeQuery = mysqli_query($connect, $selectDislike);
	   	$dislikeCount = mysqli_num_rows($selectDislikeQuery);

	   	$updateReactCount = "UPDATE ideas 
	   						SET LikeCount = '$likeCount', DislikeCount = '$dislikeCount' 
	   						WHERE IdeaID = '$IdeaID'";
	   	$updateQuery = mysqli_query($connect, $updateReactCount);
	}
	else if(isset($_POST['btnDislike']))
	{
		$reactID = AutoID("Re", 6, 'reacts', 'ReactID'); 
		$react = "dislike";
		$IdeaID = $_POST['txtIdeaID'];
		$UserID = $_SESSION['UserID'];
		
		$select = "SELECT * FROM reacts WHERE UserID = '$UserID' AND IdeaID = '$IdeaID'";
		$selectQuery = mysqli_query($connect, $select);
		$count = mysqli_num_rows($selectQuery);

		if ($count == 0) {
			 $like = "INSERT INTO reacts VALUES ('$reactID', '$react', '$IdeaID', '$UserID')";
	    	 $queryreact = mysqli_query($connect, $like);
		}
	   	else {
	   		 $updateReact = "UPDATE reacts SET React = '$react' WHERE UserID = '$UserID' AND IdeaID = '$IdeaID'";
	   		 $queryreact = mysqli_query($connect, $updateReact);
	   	}

	   	//-----------react count----------------------
	   	$selectLike = "SELECT * FROM reacts WHERE IdeaID = '$IdeaID' AND React = 'like'";
	   	$selectLikeQuery = mysqli_query($connect, $selectLike);
	   	$likeCount = mysqli_num_rows($selectLikeQuery);

	   	$selectDislike = "SELECT * FROM reacts WHERE IdeaID = '$IdeaID' AND React = 'dislike'";
	   	$selectDislikeQuery = mysqli_query($connect, $selectDislike);
	   	$dislikeCount = mysqli_num_rows($selectDislikeQuery);

	   	$updateReactCount = "UPDATE ideas 
	   						SET LikeCount = '$likeCount', DislikeCount = '$dislikeCount' 
	   						WHERE IdeaID = '$IdeaID'";
	   	$updateQuery = mysqli_query($connect, $updateReactCount);
	}
?>