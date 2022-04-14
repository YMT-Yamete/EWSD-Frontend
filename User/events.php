<?php  
  $connect = mysqli_connect('localhost', 'root', '', 'hexauniversity');
  session_start();
  if (!isset($_SESSION['UserID'])) 
  {
     echo "<script> alert('Please Login first')</script>";
     echo "<script>window.location='login.php'</script>";
  }

  $eventbutton = ($_SESSION['RoleID'] == 'R-000001')?'':'hidden';

  $select ="SELECT * FROM events";
  $query = mysqli_query($connect, $select);
  $count = mysqli_num_rows($query);
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
            <td style="text-align: right;">
              <a href="event-add.php">
                <button type="button" class="btn btn-primary" style="margin-right: auto;" <?php echo $eventbutton ?>>Add event + </button>
              </a>
            </td>
            <tr><td></td></tr>
          </tr>
        </table>
        <?php
          if ($count == 0) {
            echo "<hr>";
            echo "<h6 style='text-align:center;'>No events created yet.</h6>";
            echo "<hr>";
          }
          for ($i=0; $i < $count; $i++) {
            $array = mysqli_fetch_array($query);
            $eventID = $array['EventID'];
            echo "<div class='card' style='width: 100%;'>";
            echo "<div class='card-header' style='background-color: #2F89FC;'>";
            echo "<h5 style='color: white;'>" . $array['EventName'] . "</h5>";
            echo "</div>";
            echo "<div class='card-body'>";
            echo "<p class='card-text'><b>Start Date: </b>" . $array['StartDate'] . "</p>";
            echo "<p class='card-text'><b>Closure Date: </b>" . $array['ClosureDate'] . "</p>";
            echo "<p class='card-text'><b>Final Closure Date: </b>" . $array['FinalClosureDate'] . "</p>";
            echo "<a href='event-delete.php?eventID=$eventID'>";
            echo "<button type='button' class='btn btn-secondary'". $eventbutton .">Delete Event</button>";
            echo "</a>";
            echo "</div>";
            echo "</div><br>";
          }
        ?>
      </div>
    </div>
          
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
  </body>
</html>