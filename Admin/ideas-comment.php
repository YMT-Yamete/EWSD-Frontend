<?php  
  include 'time-since.php';
  session_start();
  $connect = mysqli_connect('localhost', 'root', '', 'hexauniversity');
  if (!isset($_SESSION['AdminID'])) 
  {
     echo "<script> alert('Please Login first')</script>";
     echo "<script>window.location='login.php'</script>";
  }
 
  if (isset($_GET['IdeaID'])) {
    $IdeaID=$_GET['IdeaID'];
    $select = "SELECT * FROM Ideas Where IdeaID='$IdeaID'";
    $query = mysqli_query($connect, $select);
    $count = mysqli_num_rows($query);

    $cmtSelect = "SELECT * FROM Comments WHERE IdeaID = '$IdeaID'";
    $cmtSelQuery = mysqli_query($connect, $cmtSelect);
    $cmtCount = mysqli_num_rows($cmtSelQuery);
  }
?>
<html lang="en">
  <head>
  	<title>Admin Dashboard</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
	  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	  <link rel="stylesheet" href="css/style.css">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap4.min.css">
  </head>
  <body>
		
		<div class="wrapper d-flex align-items-stretch">
			<nav id="sidebar">
				<div class="custom-menu">
					<button type="button" id="sidebarCollapse" class="btn btn-primary">
	          <i class="fa fa-bars"></i>
	          <span class="sr-only">Toggle Menu</span>
	        </button>
        </div>
	  		<h1><a href="accounts.php" class="logo">Hexa University<br><span style="font-size: 13px;">Admin Dashboard</span></a></h1>
        <ul class="list-unstyled components mb-5">
          <li>
            <a href="accounts.php"><span class="fa fa-users mr-3"></span>Accounts</a>
          </li>
          <li>
              <a href="departments.php"><span class="fa fa-home mr-3"></span>Departments</a>
          </li>
          <li class="active">
            <a href="ideas.php"><span class="fa fa-lightbulb-o mr-3"></span>Ideas</a>
          </li>
          <li>
            <a href="events.php"><span class="fa fa-calendar mr-3"></span>Events</a>
          </li>
          <li>
            <a href="profile.php"><span class="fa fa-user mr-3"></span>Profile</a>
          </li>
          <li style="padding: 10px;">
            <button type="button" class="btn btn-secondary" onclick="location.href = 'logout.php';" style="width: 100%;">Logout</button>
          </li>
        </ul>

    	</nav>

        <!-- Page Content  -->
          <!-- Page Content  -->
          <div id="content" class="p-4 p-md-5 pt-5"><br>
             <?php
                for ($i=0; $i < $count; $i++) { 
                  $ideaArray = mysqli_fetch_array($query);

                  $newViewCount = $ideaArray['ViewCount'] + 1;
                  $viewCountUpdate = "UPDATE ideas SET ViewCount = '$newViewCount' WHERE IdeaID = '$IdeaID'";
                  $viewCountUpdateQuery = mysqli_query($connect, $viewCountUpdate);

                  $IdeaID=$ideaArray['IdeaID'];
                  $userID = $ideaArray['UserID'];
                  $userSelect = "SELECT * FROM Users WHERE UserID = '$userID'";
                  $userSelectQuery = mysqli_query($connect, $userSelect);
                  $userArray = mysqli_fetch_array($userSelectQuery);
                  $userName = $userArray['Username']; 
                  $photo = $userArray['Photo'];

                  $categoryID = $ideaArray['CategoryID'];
                  $categorySelect = "SELECT * FROM Categories WHERE CategoryID = '$categoryID'";
                  $categorySelectQuery = mysqli_query($connect, $categorySelect);
                  $categoryArray = mysqli_fetch_array($categorySelectQuery);
                  $categoryName = $categoryArray['CategoryName'];

                  $accountRedirect = ($ideaArray['Anonymous']==0?"account-view.php?userID=$userID": "#");

                  echo "<div class='bg-white border mt-2'>";
                  echo "<div>";
                  echo "<div class='d-flex flex-row justify-content-between align-items-center p-2 border-bottom'>";
                  echo "<div class='d-flex flex-row align-items-center feed-text px-2'>";
                  echo "<img class='rounded-circle' src=" . ($ideaArray['Anonymous']==0?$photo:'../default-profile/default.jpg') . " width='45'>";
                  echo "<div class='d-flex flex-column flex-wrap ml-2'>";
                  echo "<a href='$accountRedirect' style='color: black;'>";
                  echo "<span class='font-weight-bold'>". ($ideaArray['Anonymous']==0?$userName:'Anonymous') . "</span>";
                  echo "</a>";
                  echo "<span class='text-black-50 time'>" . time_elapsed_string($ideaArray['UploadTime'], true) .  " # " . $categoryName . "</span>";
                  echo "</div>";
                  echo "</div>";
                  echo "</div>";
                  echo "</div>";
                  echo "<div class='p-2 px-3'>";
                  echo "<span>" . $ideaArray['Idea'] . "</span>";
                  echo "<a href='". $ideaArray['Document'] . "' download " . ($ideaArray['Document']==""?'hidden':'') . "></br>Download attached file</a>";
                  echo "</div>";
                  echo "<div class='d-flex justify-content-end socials p-2 py-3'>";

                  //----------------reacts-----------------------
                  echo "<input name='txtIdeaID' value=". $IdeaID ." hidden>";

                  echo "<button style='background: transparent;border: none;' type='submit' name='btnLike'>";
                  echo "<i class='fa fa-thumbs-up'>" . $ideaArray['LikeCount'] . "</i>";
                  echo "</button>";

                  echo "<button style='background: transparent;border: none;' type='submit' name='btnDislike'>";
                  echo "<i class='fa fa-thumbs-down'>" . $ideaArray['DislikeCount'] . "</i>";
                  echo "</button>";

                  echo "<button style='background: transparent;border: none !important;'>";
                  echo "</button>";

                  echo "<a href = 'ideas-comment.php?IdeaID=$IdeaID'>";
                  echo "<i class='fa fa-comments-o'>" . $cmtCount . "</i>";
                  echo "<a/>";
                  echo "</div>";
                  echo "</div>";
                }
            ?>
            <!---------------------- comments ---------------------------->
            <div>
              <div class="form-group"><br>
                <input type="hidden" name="txtid" value=<?php echo $IdeaID;?>>
                <b><p>Comments</p></b>
              </div>
              <?php 
                  $commentSelect = "SELECT c.*,u.*,i.IdeaID FROM comments c, users u, ideas i
                  Where u.UserID=c.UserID
                  And i.IdeaID=c.IdeaID
                  And i.IdeaID='$IdeaID'";
                  $commentSelectQuery = mysqli_query($connect, $commentSelect);   
                  $count = mysqli_num_rows($commentSelectQuery); 
                  for ($i=0; $i <$count ; $i++) { 
                    $arr = mysqli_fetch_array($commentSelectQuery);
                    $User=$arr['UserID'];
                    $IdeaID=$arr['IdeaID'];
                    $Comment=$arr['CommentID'];
                    $accountRedirect = ($arr['Anonymous']==0?"account-view.php?userID=$User": "#");
                    $userName = $arr['Username'];
                    $photo = $arr['Photo'];
                    echo "<div>";
                    echo "<ul class='list-group'>";
                      echo "<li class='list-group-item'>";
                        echo "<div class='d-flex flex-row align-items-center feed-text px-2'>";
                        echo "<img class='rounded-circle' src=" . ($arr['Anonymous']==0?$photo:'../default-profile/default.jpg') . " width='45'>";
                        echo  "<div class='d-flex flex-column flex-wrap ml-2'>";
                        echo "<a href='$accountRedirect' style='color: black;'>
                          <span class='font-weight-bold'>". ($arr['Anonymous']==0?$userName:'Anonymous') . "</span>";
                        echo "</a>";
                        echo "<span class='text-black-50 time'>".time_elapsed_string($arr['UploadTime'], true)."</span>";
                        echo "</div>";
                        echo "<div class='feed-icon px-2' style='position: absolute; right: 10px;'>";
                        echo "</div>";
                        echo "</div>";
                        echo "<br>";
                        echo"<p style='margin-left: 30px;'>".$arr['Comment']."</p>";
                     echo "</li>";
                
                  echo "</ul>";

                echo "</div>";
                    
                  }
               ?>
              
         <!--  -->
        </div>     
          
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
  </body>
</html>