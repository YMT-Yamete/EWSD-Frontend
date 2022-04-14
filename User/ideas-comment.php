<?php  
  include 'time-since.php';
  include 'idea-react.php';
  include 'email-notification.php';

  $connect = mysqli_connect('localhost', 'root', '', 'hexauniversity');
  if (!isset($_SESSION['UserID'])) 
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


    //to check if a logged in person react the post
    $loggedInUser = $_SESSION['UserID'];

    $likeSelect = "SELECT * FROM Reacts 
                    WHERE IdeaID = '$IdeaID' 
                    AND UserID = '$loggedInUser' 
                    AND React = 'like'";
    $likeSelectQuery = mysqli_query($connect, $likeSelect);
    $likeCount = mysqli_num_rows($likeSelectQuery);
    $likecolor = ($likeCount>0)?'#2F89FC':'';

    $dislikeSelect = "SELECT * FROM Reacts 
                    WHERE IdeaID = '$IdeaID' 
                    AND UserID = '$loggedInUser' 
                    AND React = 'dislike'";
    $dislikeSelectQuery = mysqli_query($connect, $dislikeSelect);
    $dislikeCount = mysqli_num_rows($dislikeSelectQuery);
    $dislikecolor = ($dislikeCount>0)?'#2F89FC':'';
  }

  if (isset($_POST['btnadd'])) {
    $email = $_POST['txtEmail']; //email of the post owner

    $id=AutoID('COM',6,'comments','CommentID');
    $User=$_SESSION['UserID'];
    $EventID = $_POST['txtEventID'];
    $ideaID=$_POST['txtid'];
    $comment=$_POST['txtcomment'];
    $dt = new DateTime("now", new DateTimeZone('Asia/Yangon'));
    $UploadTime = $dt->format("Y-m-d H:i:sa");

    $selectStartClosure = "SELECT * FROM events WHERE EventID = '$EventID'";
    $selectStartClosureQuery = mysqli_query($connect, $selectStartClosure);
    $startClosureArr = mysqli_fetch_array($selectStartClosureQuery);
    $startDate = $startClosureArr['StartDate'];
    $closureDate = $startClosureArr['ClosureDate'];

    $canComment = ($UploadTime>=$startDate and $UploadTime<=$closureDate);
    if (phpversion()>=8) {
       if (str_contains($comment,"'") or str_contains($comment, '"')) { 
          echo "<script>alert('The comment contains invalid characters such as \' or \".')</script>";
          echo "<script>window.location='ideas-comment.php?IdeaID=$ideaID'</script>";
        }
    }

    if ($canComment) {
        if (isset($_POST['chkanonymous'])) {
        $insert = "INSERT INTO comments(CommentID,Comment,Anonymous,UploadTime,IdeaID,UserID) 
                  VALUES ('$id', '$comment',1,'$UploadTime','$ideaID','$User')";
        $query = mysqli_query($connect, $insert);
        }
        else
        {
          $insert = "INSERT INTO comments(CommentID,Comment,Anonymous,UploadTime,IdeaID,UserID) 
                    VALUES ('$id', '$comment',0,'$UploadTime','$ideaID','$User')";
          $query = mysqli_query($connect, $insert);          
        }
        
        if ($query) {
          echo "<script>window.location='ideas-comment.php?IdeaID=$ideaID'</script>";
          $emailBody = "Someone has commented in your post: " . "<b>" . $comment . "</b>";
          EmailNotification($email, "Hexa University Idea Hub", $emailBody);
        }
        else
        {
          echo mysqli_error($connect);
        }
    }
    else {
      echo "<script>alert('Comments are turned off.')</script>";
      echo "<script>window.location='ideas-comment.php?IdeaID=$ideaID'</script>";
    }
  } 
?>
<!doctype html>
<html lang="en">
  <head>
    <title>Hexa University</title>
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
        <h1><a href="ideas.php" class="logo">Hexa University</a></h1>
        <ul class="list-unstyled components mb-5">
          <li class="active">
            <a href="ideas.php"><span class="fa fa-lightbulb-o mr-3"></span>Ideas</a>
          </li>
          <li>
            <a href="my-ideas.php"><span class="fa fa-lightbulb-o mr-3"></span>My Ideas</a>
          </li>
          <li <?php echo ($_SESSION['RoleID'] == 'R-000001')?'':'hidden' ?>>
            <a href="categories.php"><span class="fa fa-align-left mr-3"></span>Categories</a>
          </li>
          <li>
            <a href="events.php"><span class="fa fa-calendar mr-3"></span>Events</a>
          </li>
          <li <?php echo ($_SESSION['RoleID'] == 'R-000003')?'hidden':'' ?>>
            <a href="statistics.php"><span class="fa fa-line-chart mr-3"></span>Statistics</a>
          </li>
          <li>
            <a href="profile.php"><span class="fa fa-user mr-3"></span>Profile</a>
          </li>
          <li style="padding: 10px;">
            <button type="button" class="btn btn-secondary" style="width: 100%;" onclick="location.href = 'logout.php';">Logout</button>
          </li>
        </ul>
      </nav>

        <!-- Page Content  -->
          <div id="content" class="p-4 p-md-5 pt-5"><br>
             <?php
                for ($i=0; $i < $count; $i++) { 
                  $ideaArray = mysqli_fetch_array($query);

                  $newViewCount = $ideaArray['ViewCount'] + 1;
                  $viewCountUpdate = "UPDATE ideas SET ViewCount = '$newViewCount' WHERE IdeaID = '$IdeaID'";
                  $viewCountUpdateQuery = mysqli_query($connect, $viewCountUpdate);

                  $IdeaID=$ideaArray['IdeaID'];
                  $EventID=$ideaArray['EventID'];
                  $userID = $ideaArray['UserID'];
                  $userSelect = "SELECT * FROM Users WHERE UserID = '$userID'";
                  $userSelectQuery = mysqli_query($connect, $userSelect);
                  $userArray = mysqli_fetch_array($userSelectQuery);
                  $userName = $userArray['Username'];
                  $email = $userArray['Email'];
                  $photo = $userArray['Photo'];

                  $categoryID = $ideaArray['CategoryID'];
                  $categorySelect = "SELECT * FROM Categories WHERE CategoryID = '$categoryID'";
                  $categorySelectQuery = mysqli_query($connect, $categorySelect);
                  $categoryArray = mysqli_fetch_array($categorySelectQuery);
                  $categoryName = $categoryArray['CategoryName'];

                  $accountRedirect = ($ideaArray['Anonymous']==0?"account-view.php?userID=$userID": "#");
                  $deleteButton = ($_SESSION['UserID'] == $userArray['UserID'] or $_SESSION['RoleID'] == "R-000001")?'':'hidden';

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
                  echo "<a href='idea-delete.php?IdeaID=$IdeaID'>
                          <div class='feed-icon px-2'". $deleteButton ."> 
                            <i class='fa fa-trash text-black-50'></i>
                          </div>
                        </a>";
                  echo "</div>";
                  echo "</div>";
                  echo "<div class='p-2 px-3'>";
                  echo "<span>" . $ideaArray['Idea'] . "</span>";
                  echo "<a href='". $ideaArray['Document'] . "' download " . ($ideaArray['Document']==""?'hidden':'') . "></br>Download attached file</a>";
                  echo "</div>";
                  echo "<div class='d-flex justify-content-end socials p-2 py-3'>";

                  //----------------reacts-----------------------
                  echo "<form method='POST' action='ideas-comment.php?IdeaID=". $IdeaID ."'>";
                  echo "<input name='txtIdeaID' value=". $IdeaID ." hidden>";
                  
                  echo "<button style='background: transparent;border: none;' type='submit' name='btnLike'>";
                  echo "<i class='fa fa-thumbs-up' style='color:". $likecolor ."'>" . $ideaArray['LikeCount'] . "</i>";
                  echo "</button>";

                  echo "<button style='background: transparent;border: none;' type='submit' name='btnDislike'>";
                  echo "<i class='fa fa-thumbs-down' style='color:". $dislikecolor ."'>" . $ideaArray['DislikeCount'] . "</i>";
                  echo "</button>";

                  echo "<button style='background: transparent;border: none !important;'>";
                  echo "</button>";

                  echo "</form>";

                  echo "<a href = 'ideas-comment.php?IdeaID=$IdeaID'>";
                  echo "<i class='fa fa-comments-o'>" . $cmtCount . "</i>";
                  echo "<a/>";
                  echo "</div>";
                  echo "</div>";
                }
            ?>
            <!---------------------- comments ---------------------------->
            <div>
              <form action="ideas-comment.php" method="post" enctype="multipart/form-data">
                <div class="form-group"><br>
                  <input type="hidden" name="txtid" value=<?php echo $IdeaID;?>>
                  <input type="hidden" name='txtEmail' value=<?php echo $email ?>>

                  <b><p>Comments</p></b>
                  <table width="100%">
                    <tr>
                      <td width="100%">
                        <input type="text" name="txtcomment" class="form-control" placeholder="Enter Comment">
                      </td>
                      <div class="form-check">
                          <input class="form-check-input" name="chkanonymous" type="checkbox" value="" id="flexCheckDefault">
                          <input name='txtEventID' value=<?php echo $EventID ?> hidden>

                          <label class="form-check-label" for="flexCheckDefault">
                            Comment anonymously
                          </label>
                      </div>
                      <td align="right">
                        <button type="submit" name="btnadd" class="btn btn-primary">Add</button>
                      </td>
                    </tr>
                  </table>
                </div>
              </form>
              
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

                    $cmtdeleteButton = ($_SESSION['UserID'] == $arr['UserID'] or $_SESSION['RoleID'] == "R-000001")?'':'hidden';
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
                        echo " <a href='comment-delete.php?CommentID=$Comment&IdeaID=$IdeaID'><i class='fa fa-trash text-black-50'". $cmtdeleteButton ."></i></a>";
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