<?php  
	$connect = mysqli_connect('localhost', 'root', '', 'hexauniversity');
	session_start();

	if ($_SESSION['RoleID']!='R-000001') {
		echo "<script>alert('You do not have permission to view this page.')</script>";
	}

	$select = "SELECT * FROM Ideas";
	$query = mysqli_query($connect, $select);

	if ($query->num_rows > 0) {
		$delimiter = ",";
		$filename = "idea-data_" . date('Y-m-d') . ".csv";

		$f = fopen('php://memory', 'w');

		$fields = array('IdeaID', 'Idea', 'Anonymous', "UploadTime", "ViewCount", "LikeCount", "DislikeCount", "CategoryID", "UserID", "EventID");
		fputcsv($f, $fields, $delimiter);

		while ($row = $query -> fetch_assoc()) {
			$lineData = array($row['IdeaID'], $row['Idea'], $row['Anonymous'], $row['UploadTime'], $row['ViewCount'], $row['LikeCount'], $row['DislikeCount'], $row['CategoryID'], $row['UserID'], $row['EventID']);
			fputcsv($f, $lineData, $delimiter);
		}

		fseek($f, 0);

		header('Content-Type: text/csv');
		header('Content-Disposition: attachment; filename="'. $filename .'";');

		fpassthru($f);
	}

	exit;
?>