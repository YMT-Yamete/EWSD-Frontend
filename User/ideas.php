<?php  
  include 'time-since.php';
  $connect = mysqli_connect('localhost', 'root', '', 'hexauniversity');
  session_start();
  if (!isset($_SESSION['UserID'])) 
  {
     echo "<script>alert('Please Login first')</script>";
     echo "<script>window.location='login.php'</script>";
  }

  $select = "SELECT * FROM Ideas";

  $query = mysqli_query($connect, $select);
  $count = mysqli_num_rows($query);

  //--------------pagination-----------------------
  $resultPerPage = 5;
  $numOfPages = ceil($count/$resultPerPage);

  //if page is not seleccted
  if (!isset($_GET['page'])) {
    $page = 1;
  }
  else {
    $page = $_GET['page'];
  }

  $this_page_first_result = ($page - 1) * $resultPerPage;

  if (!isset($_SESSION['SortBy'])) {
    $_SESSION['SortBy'] = "UploadTime";
  }

  //-----------------sort-------------------------
  if (isset($_POST['btnSort'])) {
    if ($_POST['selectSort'] == "popularity") {
      $_SESSION['SortBy'] = "LikeCount";
    }
    else if ($_POST['selectSort'] == "view") {
      $_SESSION['SortBy'] = "ViewCount";
    }
    else {
      $_SESSION['SortBy'] = "UploadTime";
    }
  }

  $sortby = $_SESSION['SortBy'];
  $sql = "SELECT * FROM Ideas ORDER BY $sortby DESC LIMIT " . $this_page_first_result . "," . $resultPerPage;

  $paginatedResult = mysqli_query($connect, $sql);
  $count = mysqli_num_rows($paginatedResult);
?>
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
            <table width="100%">
              <tr>
                <form method="POST" action="ideas.php">
                <td width="100%">
                    <select class="custom-select" id="inputGroupSelect01" name="selectSort">
                      <option selected>Sort by <?php echo $sortby ?></option>
                      <option value="popularity">Popularity (LikeCount)</option>
                      <option value="view">View (ViewCount)</option>
                      <option value="latest">Latest (UploadTime)</option>
                    </select>
                </td>
                <td align="right">
                  <button type="submit" class="btn btn-primary" name="btnSort">Sort</button>
                </td>
                </form>
                <td style="text-align: right;">
                  <a href="idea-add.php">
                    <button type="button" class="btn btn-primary" style="margin-right: auto;">Add idea + </button>
                  </a>
                </td>
              </tr>
            </table>
            <?php
                if ($count == 0) {
                  echo "<hr>";
                  echo "<h6 style='text-align:center;'>No ideas uploaded yet.</h6>";
                  echo "<hr>";
                }
                for ($i=0; $i < $count; $i++) { 
                  $ideaArray = mysqli_fetch_array($paginatedResult);
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

                  echo "<a href = 'ideas-comment.php?IdeaID=$IdeaID'>";
                  echo "<span style='font-size: 16px;'> View Details </span>";
                  echo "<a/>";
                  echo "</div>";
                  echo "</div>";
                }

                //------------------pagination------------------------------

                echo "<br/>";
                echo "<nav aria-label='Page navigation example'>";
                echo "<ul class=pagination>";
                for ($page=1; $page <= $numOfPages; $page++) { 
                  echo "<li class='page-item'>
                          <a class='page-link' href='ideas.php?page=". $page ."'>". $page ."</a>
                        </li>";
                }
                echo "</ul>";
                echo "</div>";
            ?>
            <br>
          </div>
      </div>
    
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
  </body>
</html>