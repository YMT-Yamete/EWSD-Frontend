<?php  
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

  $select = "SELECT * FROM categories";
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
          <li class="active" <?php echo ($_SESSION['RoleID'] == 'R-000001')?'':'hidden' ?>>
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
        <h2 style="text-align: center;"><b>Categories</b></h2>
          <a href="category-add.php"><button type="button" class="btn btn-primary">Add category + </button></a>
          <table>
            <tr><td></td></tr>
            <tr><td></td></tr>
          </table>
            <table id="myTable" class="table table-striped table-bordered" width="100%">
              <thead style="background-color: #2F89FC; color: white">
                <tr>
                  <th scope="col">ID</th>
                  <th scope="col">Category</th>
                  <th scope="col">Idea Count</th>
                  <th scope="col"></th>
                </tr>
              </thead>
              <tbody>
                <?php
                  if ($count == 0) {
                    echo "<tr>
                            <td colspan='4' style='text-align: center;'>
                              No categories added yet.
                            </td>
                          </tr>";
                  }
                  for ($i=0; $i < $count; $i++) { 
                    $array = mysqli_fetch_array($query);
                    $categoryID = $array['CategoryID'];
                    $select1 = "SELECT * FROM Ideas WHERE CategoryID = '$categoryID'";
                    $query1 = mysqli_query($connect, $select1);
                    $ideaCount = mysqli_num_rows($query1); 
                    echo "<tr>";
                    echo "<th scope='row'>". $array['CategoryID'] . "</th>";
                    echo "<td>" . $array['CategoryName'] . "</td>";
                    echo "<td>" . $ideaCount . "</td>";
                    echo "<td>";
                    echo "<a href='category-delete.php?categoryID=$categoryID' style='color: red;''><b>Delete</b></a>";
                    echo "</td>";
                    echo "</tr>";
                  }
                ?>
              </tbody>
            </table>
      </div>
    </div>
          
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
  </body>
</html>