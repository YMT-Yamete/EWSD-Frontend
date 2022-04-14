<!doctype html>
<?php 
session_start();
include('AutoID_Functions.php');
$connect = mysqli_connect('localhost', 'root', '', 'hexauniversity');
$AdminID=$_SESSION['AdminID'];
  if (isset($_SESSION['AdminID'])) 
  {
     if (isset($_POST['btnadd'])) 
  {
    $id=AutoID('departments','DepartmentID','Dep-',6);
    $name=$_POST['txtdepartmentname'];
    $type=$_POST['cbodepartmenttype'];      
      $query="Insert Into departments(DepartmentID,DepartmentName,DepartmentTypeID) 
          Values('$id','$name','$type')";
      $result=mysqli_query($connect,$query);
      if ($result) 
      {
        echo"<script>alert('Department Register Successful')</script>";
      }
      else
      {
        echo mysqli_error($connect);
      }
    }
  }
  else
  {
    echo "<script> alert('Please Login first')</script>";
    echo "<script> window.location='login.php'</script>";
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
          <li class="active"> 
              <a href="departments.php"><span class="fa fa-home mr-3"></span>Departments</a>
          </li>
          <li>
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
          <div id="content" class="p-4 p-md-5 pt-5">
            <h2 style="text-align: center;"><b>Add Department</b></h2>
            <div class="container mt-4 mb-4 p-3 d-flex justify-content-center">
              <div class="card p-4">
                  <form action="department-add.php" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                      
                      <label>Department Name</label>
                      <input type="text" name="txtdepartmentname" class="form-control" placeholder="Enter Name" required>
                    </div>
                    
                    <div class="form-group">
                      <label>Department Type</label><br>
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <label class="input-group-text">Options</label>
                        </div>
                        <select class="custom-select" name="cbodepartmenttype" id="inputGroupSelect01" required>
                          <option selected>Choose...</option>
                          <?php 
                              $selectid="Select * from departmenttypes";
                              $ret=mysqli_query($connect,$selectid);
                              $count=mysqli_num_rows($ret);
                              for ($i=0; $i <$count ; $i++) { 
                              $arr=mysqli_fetch_array($ret);

                              $TypeID=$arr['DepartmentTypeID'];
                              $Type=$arr['DepartmentType'];
                              echo"<option value='$TypeID'>$TypeID - $Type</option>";
                            }
                          ?>
                        </select>
                      </div>
                    </div>
                    <button type="submit" class="btn btn-primary" name="btnadd">Add</button>
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