<!doctype html>
<?php 
  session_start();
  $connect = mysqli_connect('localhost', 'root', '', 'hexauniversity');
  if (isset($_POST['btnlogin'])) {
      $email=$_POST['txtemail'];
      $password=md5($_POST['txtpassword']);
      $check="Select * From Users
              Where Email='$email' And Password ='$password'";
      $ret=mysqli_query($connect,$check);
      $row=mysqli_fetch_array($ret);
      $count= mysqli_num_rows($ret);
      if ($count<1) {
          echo"<script>window.alert('Please try again')</script>";
          echo"<script>window.location='login.php'</script>";
          echo $check;
      }
      else
      {   
          $_SESSION['UserID']=$row['UserID'];
          $_SESSION['RoleID']=$row['RoleID'];
          echo"<script>window.alert('Login Successful')</script>";
          echo "<script>window.location='ideas.php'</script>";     
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
	  		<h1><a href="login.php" class="logo">Hexa University</a></h1>
        <ul class="list-unstyled components mb-5">
          <li>
            <a href="login.php"><span class="fa fa-sign-in mr-3"></span>Login</a>
          </li>
        </ul>

    	</nav>

        <!-- Page Content  -->
          <div id="content" class="p-4 p-md-5 pt-5">
            <h2 style="text-align: center;"><b>User Login</b></h2>
            <div class="container mt-4 mb-4 p-3 d-flex justify-content-center">
              <div class="card p-4">
                  <form method="POST" action="login.php">
                    <div class="form-group">
                      <label>Email</label>
                      <input type="Email" name="txtemail" class="form-control" placeholder="Enter Email">
                    </div>
                    <div class="form-group">
                      <label>Password</label>
                      <input type="password" name="txtpassword" class="form-control" placeholder="Enter Password">
                    </div>
                    <input type="submit" name="btnlogin" value="Login" class="btn btn-primary">
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