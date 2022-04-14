<?php  
  $connect = mysqli_connect('localhost', 'root', '', 'hexauniversity');
  session_start();
  if (!isset($_SESSION['UserID'])) 
  {
     echo "<script>alert('Please Login first')</script>";
     echo "<script>window.location='login.php'</script>";
  }
  if (isset($_GET['userID'])) {
      $userID = $_GET['userID'];
      $select = "SELECT * FROM users WHERE UserID = '$userID'";
      $query = mysqli_query($connect, $select);
      $userArray = mysqli_fetch_array($query);

      $roleID = $userArray['RoleID'];
      $select2 = "SELECT * FROM roles WHERE RoleID = '$roleID'";
      $query = mysqli_query($connect, $select2);
      $roleArray = mysqli_fetch_array($query);

      $departmentID = $userArray['DepartmentID'];
      $select3 = "SELECT * FROM departments WHERE DepartmentID = '$departmentID'";
      $query = mysqli_query($connect, $select3);
      $departmentArray = mysqli_fetch_array($query);

      $username = $userArray['Username'];
      $photo = $userArray['Photo'];
      $department = $departmentArray['DepartmentName'];
      $role = $roleArray['Role'];
      $email = $userArray['Email'];
      $phone = $userArray['Phone'];
      $address = $userArray['Address'];
      $photo = $userArray['Photo'];
  }
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
          <div id="content" class="p-4 p-md-5 pt-5">
            <div class="container mt-4 mb-4 p-3 d-flex justify-content-center">
              <div class="card p-4">
                  <div class=" image d-flex flex-column justify-content-center align-items-center"> 
                    <button class="btn btn-secondary"> 
                      <img src=<?php echo $photo ?> height="100" width="100" />
                    </button> 
                      <span class="name mt-3"><?php echo $username ?></span> 
                      <span class="idd"><?php echo $role ?></span>  
                      <div class="text mt-3"> 
                        <span><b>Department:</b> <?php echo $department ?></span><br>
                        <span><b>Email:</b><?php echo $email ?></span><br>
                        <span><b>Phone:</b><?php echo $phone ?></span><br>
                        <span><b>Address:</b><?php echo $address ?></span>
                      </div><br>
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