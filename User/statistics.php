<?php
  $connect = mysqli_connect('localhost', 'root', '', 'hexauniversity');
  session_start();
  if (!isset($_SESSION['UserID'])) 
  {
      echo "<script>alert('Please Login first')</script>";
      echo "<script>window.location='login.php'</script>";
  }
  if ($_SESSION['RoleID'] == 'R-000003') 
  {
      echo "<script> alert('You do not have permission to view this page')</script>";
  }

  $select = "SELECT * FROM departments";
  $query = mysqli_query($connect, $select);
  $count = mysqli_num_rows($query);

  $csvdownload = ($_SESSION['RoleID'] == 'R-000001')?'':'hidden';

  $dataPoints = array();
  for ($i=0; $i < $count; $i++) { 
    $arr = mysqli_fetch_array($query);
    $deptID = $arr['DepartmentID'];

    $ideaSelect = "SELECT * FROM ideas";
    $query1 = mysqli_query($connect, $ideaSelect);
    $ideaCount = mysqli_num_rows($query1);

    $deptIdeaSelect = "SELECT * FROM ideas i, users u
                        WHERE i.UserID = u.UserID
                        AND u.DepartmentID = '$deptID'";
    $query2 = mysqli_query($connect, $deptIdeaSelect);
    $deptIdeaCount = mysqli_num_rows($query2);

    if ($ideaCount > 0) {
      $percent = ($deptIdeaCount/$ideaCount) * 100;
    
    
    $deptArray = array("label"=> $arr['DepartmentName'], "y"=>$percent);
    array_push($dataPoints, $deptArray);
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>

    <script>
      window.onload = function() {
       
       
      var chart = new CanvasJS.Chart("chartContainer", {
        animationEnabled: true,
        title: {
          text: "Ideas made by Departments"
        },
        subtitles: [{
          text: "Hexa University"
        }],
        data: [{
          type: "pie",
          yValueFormatString: "#,##0.00\"%\"",
          indexLabel: "{label} ({y})",
          dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
        }]
      });
      chart.render();
       
      }
    </script>
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
          <li>
            <a href="events.php"><span class="fa fa-calendar mr-3"></span>Events</a>
          </li>
          <li class="active" <?php echo ($_SESSION['RoleID'] == 'R-000003')?'hidden':'' ?>>
            <a href="statistics.php"><span class="fa fa-line-chart mr-3" onclick="location.href = 'logout.php';"></span>Statistics</a>
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
      <div id="content" class="p-4 p-md-5 pt-5"><br>
        <div class="row">
          <div class="col-sm-12">
              <?php
                if ($ideaCount == 0) {
                  echo "<h6 style='text-align:center; margin: 180px;'>No Data To Show</h6>";
                }
                else {
                  echo "<div id='chartContainer' style='height: 370px; width: 100%;'></div>";
                  echo "<script src='https://canvasjs.com/assets/script/canvasjs.min.js'></script>";
                }
              ?>
            <!-- Exceptional Report -->
            <div class="col-sm-12">
              <hr><br>
              <h5 align="center">
              <b>Exceptional Reports</b>
              </h5><br>
              <table align="center" id="myTable" width="20%">
                <tbody>
                  <?php 
                    $select = "SELECT * FROM ideas WHERE Anonymous = 1";
                    $query = mysqli_query($connect, $select);
                    $count = mysqli_num_rows($query);
                  ?>
                  <tr>
                    <td style="text-align: left;"><b>Anonymous Ideas:</b> </td>
                    <td style="text-align: left;"><?php echo $count; ?></td>
                  </tr>
                  <?php 
                    $select = "SELECT * FROM comments WHERE Anonymous = 1";
                    $query = mysqli_query($connect, $select);
                    $count = mysqli_num_rows($query);
                  ?>
                  <tr>
                    <td style="text-align: left;"><b>Anonymous Comments:</b> </td>
                    <td style="text-align: left;"><?php echo $count; ?></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <!-- Number of Ideas made by each departments -->
          <div class="col-sm-12">
            <hr><br>
            <h5 align="center">
              <b>Number of Ideas made by each departments</b>
            </h5><br>
            <div>
              <a href="exportData.php">
                <button type="button" class="btn btn-primary" <?php echo $csvdownload; ?>>Download CSV file</button>
              </a>
            </div>
            <table class="table table-striped" align="center" id="myTable">
              <thead>
                <tr>
                  <th scope="col">Department</th>
                  <th scope="col">Number of Ideas</th>
                  <th scope="col">Percentage of Ideas</th>
                  <th scope="col">Number of Contributors</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <?php  
                    $select = "SELECT * FROM departments";
                    $query = mysqli_query($connect, $select);
                    $count = mysqli_num_rows($query);
                    for ($i=0; $i < $count; $i++) { 
                      $arr1 = mysqli_fetch_array($query);
                      $deptID = $arr1['DepartmentID'];

                      $ideaSelect = "SELECT * FROM ideas";
                      $query1 = mysqli_query($connect, $ideaSelect);
                      $ideaCount = mysqli_num_rows($query1);

                      $deptIdeaSelect = "SELECT * FROM ideas i, users u
                                          WHERE i.UserID = u.UserID
                                          AND u.DepartmentID = '$deptID'";
                      $query2 = mysqli_query($connect, $deptIdeaSelect);
                      $deptIdeaCount = mysqli_num_rows($query2);

                      $contributorSelect = "SELECT DISTINCT u.UserID FROM users u, ideas i
                                            WHERE i.UserID = u.UserID
                                            AND u.DepartmentID = '$deptID'";
                      $query3 = mysqli_query($connect, $contributorSelect);
                      $contributorCount = mysqli_num_rows($query3);

                      $percent = ($deptIdeaCount/$ideaCount) * 100;
                      $twoDecimalPercent = number_format((float)$percent, 2, '.', ''); 

                      echo "<td>". $arr1['DepartmentName']."</td>";
                      echo "<td>". $deptIdeaCount ."</td>";
                      echo "<td>". $twoDecimalPercent . " %". "</td>";
                      echo "<td>". $contributorCount ."</td>";
                      echo "<tr>";
                    }
                  ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>

    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap4.min.js"></script>

    <script type="text/javascript">
      $(document).ready(function() {
          $('#myTable').DataTable();
      } );
    </script>
  </body>
</html>