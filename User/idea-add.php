<?php

    include 'AutoID.php';
    include 'email-notification.php';

    $connect = mysqli_connect('localhost', 'root', '', 'hexauniversity');
    session_start();
    if (!isset($_SESSION['UserID'])) 
    {
       echo "<script> alert('Please Login first')</script>";
       echo "<script>window.location='login.php'</script>";
    }

    //to check if a user can upload at the moment
    $dt = new DateTime("now", new DateTimeZone('Asia/Yangon'));
    $currentTime = $dt->format("Y-m-d H:i:sa");
    $select = "SELECT * FROM events 
              WHERE '$currentTime' >= StartDate
              AND   '$currentTime' <= ClosureDate";
    $query = mysqli_query($connect, $select);
    $arr1 = mysqli_fetch_array($query);

    //fetch coordinator gmail
    $userID = $_SESSION['UserID'];
    $selectDept = "SELECT * FROM users u, departments d
                    WHERE u.UserID = '$userID'
                    AND d.DepartmentID = u.DepartmentID";
    $selectDeptQuery = mysqli_query($connect, $selectDept);
    $deptArr = mysqli_fetch_array($selectDeptQuery);
    $departmentID = $deptArr['DepartmentID'];

    $selectCoor = "SELECT * FROM users u
                    WHERE RoleID = 'R-000002'
                    AND DepartmentID = '$departmentID'";

    $selectCoorQuery = mysqli_query($connect, $selectCoor);
    $coorArr = mysqli_fetch_array($selectCoorQuery);
    $coorcount=mysqli_num_rows($selectCoorQuery);
    
    if ($coorcount!=0) {
      $coorEmail = $coorArr['Email'];
    }
    if (isset($_POST['btnUpload'])) 
    {
        // upload times ------------------------------------------
        $dt = new DateTime("now", new DateTimeZone('Asia/Yangon'));
        $uploadTime = $dt->format("Y-m-d H:i:sa");

        // eventID ------------------------------------------
        $select = "SELECT * FROM events 
                  WHERE '$uploadTime' >= StartDate
                  AND   '$uploadTime' <= ClosureDate";
        $query = mysqli_query($connect, $select);
        $arr2 = mysqli_fetch_array($query);
        $eventID = $arr2['EventID'];

        // user and idea ------------------------------------------
        $userID = $_POST['txtID'];
        $ideaID = AutoID("I", 6, "Ideas", "IdeaID");
        $idea = $_POST['txtIdea']; 

        // category ------------------------------------------
        $categoryID = $_POST['txtCategory'];
        if ($categoryID == "Choose...") {
          echo "<script>alert('You must choose a category')</script>";
          echo "<script>window.location='idea-add.php'</script>";
          exit();
        }
        else {
          $categoryID = $_POST['txtCategory'];
        }

        // counts ------------------------------------------
        $viewCount = 0;
        $likeCount = 0;
        $dislikeCount = 0;

        // check boxes ------------------------------------------
        $checkTerms = $_POST['checkTerms'];
        $checkAnonymous = ($_POST['checkAnon']=="true")?1:0;

        // optional document ------------------------------------------
        $folder = "../idea-documents/";
        $documentName = $_FILES['fileDocument']['name'];
        $fileDir = "";
        if ($documentName) {
          $fileDir = $folder . $ideaID . "_"  . $documentName;
          $copy = copy($_FILES['fileDocument']['tmp_name'], $fileDir);
        }

        // upload ------------------------------------------
        $insert = "INSERT INTO ideas
                   VALUES ('$ideaID', '$idea', '$checkAnonymous', '$fileDir', '$uploadTime', '$viewCount', '$likeCount', '$dislikeCount', '$categoryID', '$userID', '$eventID')";
        $query = mysqli_query($connect, $insert);
        if (phpversion()>=8) {
          if (str_contains($idea,"'") or str_contains($idea, '"')) { 
              echo "<script>alert('The idea contains invalid characters such as \' or \".')</script>";
              echo "<script>window.location='ideas.php'</script>";
            }   
        }


        if ($query) {
          $emailBody = "Someone in your department has posted: " . "<b>" . $idea . "</b>";
          if ($coorcount!=0) {
              EmailNotification($coorEmail, "Hexa University Idea Hub", $emailBody);
          }
          
          echo "<script>alert('Upload Complete');</script>";
          echo "<script>window.location='ideas.php'</script>";
        }
        else {
          echo mysqli_error($connect);
        }
    }
?>
<html lang="en">
  <head>
  	<title>Hexa University</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- boostrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

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
           <h2 style="text-align: center;"><b>Upload Idea</b></h2>
            <div class="container mt-4 mb-4 p-3 d-flex justify-content-center">
              <div class="card p-4">
                    <p>What's your idea?</p>
                    <form method="POST" action="idea-add.php" enctype="multipart/form-data">
                      <div class="form-group">
                        <input type="text" name="txtID" value=<?php echo $_SESSION['UserID']; ?> hidden>
                        <textarea placeholder="Type your idea here" name="txtIdea" required></textarea>
                        <div class="form-group">
                          <label>Category</label><br>
                          <div class="input-group mb-3">
                            <div class="input-group-prepend">
                              <label class="input-group-text">Options</label>
                            </div>
                            <select class="custom-select" id="inputGroupSelect01" name="txtCategory" required>
                              <option selected>Choose...</option>
                              <?php 
                                  $selectid="Select * from categories";
                                  $ret=mysqli_query($connect,$selectid);
                                  $count=mysqli_num_rows($ret);
                                  for ($i=0; $i <$count ; $i++) { 
                                  $arr=mysqli_fetch_array($ret);

                                  $categoryID=$arr['CategoryID'];
                                  $category=$arr['CategoryName'];
                                  echo"<option value='$categoryID'>$categoryID - $category</option>";
                                }
                              ?>
                            </select>
                          </div>
                        </div>
                        <div class="mb-3">
                          <label for="formFile" class="form-label">Optional Document</label>
                          <input class="form-control" type="file" id="formFile" name ="fileDocument">
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" value="asdf" id="flexCheckDefault" name="checkTerms" required>
                          <label class="form-check-label" for="flexCheckDefault">
                            I agree to the <a href="https://www.termsandconditionsgenerator.com/live.php?token=PWKa9s8NpNpsDMXvxvU0IApWaQZiMONi">terms and conditions</a>
                          </label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" value="false" id="flexCheckDefault" name="checkAnon" hidden checked>
                          <input class="form-check-input" type="checkbox" value="true" id="flexCheckDefault" name="checkAnon">
                          <label class="form-check-label" for="flexCheckDefault">
                            Upload anonymously
                          </label>
                        </div>
                        <p style="color: red;">
                          <?php echo (empty($arr1))?"You cannot upload before the event is started.":"" ?>
                        </p>
                        <input type="submit" name="btnUpload" value="Upload" class="btn btn-primary" 
                        <?php echo (empty($arr1))?"disabled":"" ?>>
                      </div>
                    </form>
                  </div>
              </div>
          </div>
      </div>
          
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
  </body>
</html>