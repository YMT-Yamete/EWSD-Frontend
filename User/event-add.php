<?php
  include 'AutoID.php';
  $connect = mysqli_connect('localhost', 'root', '', 'hexauniversity');
  session_start();  
  if (!isset($_SESSION['UserID'])) 
  {
     echo "<script> alert('Please Login first')</script>";
     echo "<script>window.location='login.php'</script>";
  }
  if ($_SESSION['RoleID'] != 'R-000001') {
    echo "<script> alert('You do not have permission to view this page')</script>";
  }
  
  if (isset($_POST['btnAdd'])) {
    $eventID = AutoID("E", 6, "events", "EventID");
    $eventName = $_POST['txtName'];

    $startDate = $_POST['txtStartDate'];
    $formattedStartDate = date("Y-m-d", strtotime($startDate));

    $closureDate = $_POST['txtClosureDate'];
    $formattedClosureDate = date("Y-m-d", strtotime($closureDate));

    $finalClosureDate = $_POST['txtFinalClosureDate'];
    $formattedFinalClosureDate = date("Y-m-d", strtotime($finalClosureDate));

    if ($formattedStartDate>$formattedClosureDate) {
      echo "<script>alert('Start date must be earlier than closure date.');</script>";
      echo "<script>window.location='event-add.php'</script>";
      exit();
    }
    if ($formattedClosureDate>$formattedFinalClosureDate) {
      echo "<script>alert('Closure date must be earlier than final closure date.');</script>";
      echo "<script>window.location='event-add.php'</script>";
      exit();
    }
    $insert = "INSERT INTO events VALUES ('$eventID', '$eventName', '$formattedStartDate', '$formattedClosureDate', '$formattedFinalClosureDate')";
    $query = mysqli_query($connect, $insert);
    if ($query) 
    {
      echo "<script>alert('New Event Added.')</script>";
      echo "<script>window.location='events.php'</script>";
    }
    else
    {
      echo mysqli_error($connect);
    }
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

    <!-- datepicker -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
    <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />

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
          <li>
            <a href="ideas.php"><span class="fa fa-lightbulb-o mr-3"></span>Ideas</a>
          </li>
          <li>
            <a href="my-ideas.php"><span class="fa fa-lightbulb-o mr-3"></span>My Ideas</a>
          </li>
          <li <?php echo ($_SESSION['RoleID'] == 'R-000001')?'':'hidden' ?>>
            <a href="categories.php"><span class="fa fa-align-left mr-3"></span>Categories</a>
          </li>
          <li class="active">
            <a href="events.php"><span class="fa fa-calendar mr-3"></span>Events</a>
          </li>
          <li> <?php echo ($_SESSION['RoleID'] == 'R-000003')?'hidden':'' ?>
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
        <h2 style="text-align: center;"><b>Add Event</b></h2>
        <div class="container mt-4 mb-4 p-3 d-flex justify-content-center">
          <div class="card p-4">
              <form method="POST" action="event-add.php">
                <div class="form-group">
                  <label>Event Name</label>
                  <input type="text" class="form-control" placeholder="Enter Event Name" name="txtName" required>
                </div>

                <label>Start Date</label>
                <input id="datepicker1" width="100%" name="txtStartDate" required/>

                <label>Closure Date</label>
                <input id="datepicker2" width="100%" name="txtClosureDate" required/>

                <label>Final Closure Date</label>
                <input id="datepicker3" width="100%" name="txtFinalClosureDate" required/><br>

                <input type="submit" name="btnAdd" class="btn btn-primary" value="Add">
              </form>
              </div>
          </div>
      </div>
    </div>
        
    <script>
        $('#datepicker1').datepicker({
            uiLibrary: 'bootstrap4'
        });
        $('#datepicker2').datepicker({
            uiLibrary: 'bootstrap4'
        });
        $('#datepicker3').datepicker({
            uiLibrary: 'bootstrap4'
        });
    </script>
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>


  </body>
</html>