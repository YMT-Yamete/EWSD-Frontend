<?php 
  session_start();
  $connect = mysqli_connect('localhost', 'root', '', 'hexauniversity');
  $AdminID=$_SESSION['AdminID'];

  if (isset($_SESSION['AdminID'])) 
  {
   if (isset($_SESSION['AdminID'])) 
   {
    $select="Select * from admin
    Where AdminID='$AdminID'";
    $result=mysqli_query($connect,$select);
    $arr=mysqli_fetch_array($result);
    
    }
    else
    {
      echo "<script> alert('Please Login first')</script>";
      echo "<script> window.location='login.php'</script>";
    }
  }
    else
    {
    echo "<script> alert('Please Login first')</script>";
    echo "<script> window.location='login.php'</script>";
    }
  
  
 ?>
<!doctype html>
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
          <li>
            <a href="ideas.php"><span class="fa fa-lightbulb-o mr-3"></span>Ideas</a>
          </li>
          <li>
            <a href="events.php"><span class="fa fa-calendar mr-3"></span>Events</a>
          </li>
          <li class="active">
            <a href="profile.php"><span class="fa fa-user mr-3"></span>Profile</a>
          </li>
          <li style="padding: 10px;">
            <button type="button" class="btn btn-secondary" onclick="location.href = 'logout.php';" style="width: 100%;">Logout</button>
          </li>
        </ul>

    	</nav>

        <!-- Page Content  -->
          <div id="content" class="p-4 p-md-5 pt-5">
            <div class="container mt-4 mb-4 p-3 d-flex justify-content-center">
              <div class="card p-4">
                  <div class=" image d-flex flex-column justify-content-center align-items-center"> 
                    <button class="btn btn-secondary"> 
                      <img src="../default-profile/default.jpg" height="100" width="100" />
                    </button> 
                      <span class="name mt-3"><?php echo $arr['Username']; ?></span> 
                      <span class="idd">Admin</span>  
                      
                      <div class=" d-flex mt-2"> 
                        <a href="profile-edit.php"><button class="btn1 btn-primary">Edit Profile</button> </a>
                      </div>
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