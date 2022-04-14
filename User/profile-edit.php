<?php  
  $connect = mysqli_connect('localhost', 'root', '', 'hexauniversity');
  session_start();
  if (!isset($_SESSION['UserID'])) 
  {
     echo "<script>alert('Please Login first')</script>";
     echo "<script>window.location='login.php'</script>";
  }

  $userID = $_SESSION['UserID'];
  $select="Select * from users u, departments d, roles r
          Where u.UserID='$userID'
          AND d.DepartmentID=u.DepartmentID
          And u.RoleID=r.RoleID";
  $result=mysqli_query($connect,$select);
  $arr=mysqli_fetch_array($result);

  if (isset($_POST['btnSave'])) {
      $userID = $_POST['txtID'];
      $name = $_POST['txtName'];
      $password = $_POST['txtNewPassword'];
      $phone = $_POST['txtPhone'];
      $address = $_POST['txtAddress'];
      $oldPassword = md5($_POST['txtOldPassword']);

      $folder="../images/";
      $filename='';
      $prevphoto=$_POST['prevphoto'];
      $UserImage=$_FILES['txtphoto']['name'];
      if ($UserImage) 
      {
          $filename=$folder.$UserImage;
          $copy=copy($_FILES['txtphoto']['tmp_name'], $filename);
          if (!$copy) 
          {
              exit();
          }
      }
      else
      {
        $filename=$prevphoto;
      }

      $select = "SELECT Password FROM users WHERE userID = '$userID'";
      $query = mysqli_query($connect, $select);
      $arr = mysqli_fetch_array($query);
      $originalPassword = $arr['Password'];

      if ($originalPassword == $oldPassword) {
        if ($_POST['txtNewPassword']=='') 
        {
            $update="Update users
              Set Username='$name',
              Photo='$filename',
              Phone='$phone',
              Address='$address'
              Where UserID='$userID'";
        }
        else
        {
          $update="Update users
              Set Username='$name',
              Photo='$filename',
              Password=md5('$password'),
              Phone='$phone',
              Address='$address'
              Where UserID='$userID'";
        }  
        $ret=mysqli_query($connect,$update);
        if ($ret) 
        {
          echo"<script>window.alert('Update sucessful')</script>";
          echo "<script>window.location='profile.php'</script>";       
        }
        else 
        {
            echo mysqli_error($connect);
        } 
      }
      else
      {
        echo "<script>alert('Please type in the old password correctly')</script>";
        echo "<script>window.location='profile-edit.php'</script>"; 
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

    <!-- boostrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

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
          <li>
            <a href="events.php"><span class="fa fa-calendar mr-3"></span>Events</a>
          </li>
          <li <?php echo ($_SESSION['RoleID'] == 'R-000003')?'hidden':'' ?>>
            <a href="statistics.php"><span class="fa fa-line-chart mr-3"></span>Statistics</a>
          </li>
          <li class="active">
            <a href="profile.php"><span class="fa fa-user mr-3"></span>Profile</a>
          </li>
          <li style="padding: 10px;">
            <button type="button" class="btn btn-secondary" style="width: 100%;" onclick="location.href = 'logout.php';">Logout</button>
          </li>
        </ul>
    	</nav>

        <!-- Page Content  -->
          <div id="content" class="p-4 p-md-5 pt-5">
            <h2 style="text-align: center;"><b>Edit Profile</b></h2>
            <div class="container mt-4 mb-4 p-3 d-flex justify-content-center">
              <div class="card p-4">
                  <form method="POST" action="profile-edit.php" enctype="multipart/form-data">

                    <div class="form-group">
                      <input type="text" name="txtID" value="<?php echo $userID ?>" hidden>
                      <label>New Name</label>
                      <input type="text" class="form-control" placeholder="Enter Name" name="txtName" value="<?php echo $arr['Username'] ?>" required>
                    </div>

                    <div class="form-group">
                      <label>Photo</label>
                      <input type="file" name="txtphoto" class="form-control" >
                      <input type="hidden" name="prevphoto" value="<?php echo $arr['Photo'] ?>" >
                    </div>

                    <div class="form-group">
                      <label>New Password</label>
                      <input type="password" class="form-control" name="txtNewPassword" placeholder="Password">
                    </div>

                    <div class="form-group">
                      <label>New Phone</label>
                      <input type="Phone" class="form-control" placeholder="Enter Phone" name="txtPhone" value="<?php echo $arr['Phone']; ?>" required>
                    </div>

                    <div class="form-group">
                      <label>New Address</label>
                      <textarea class="form-control" rows="3" name="txtAddress" placeholder="Enter Address" required><?php echo $arr['Address'] ?></textarea>
                    </div>

                    <div class="form-group">
                      <label>Old Password</label>
                      <input type="password" class="form-control" name="txtOldPassword" placeholder="Password" required>
                      <small class="form-text text-muted">You need to type in your old password in order to change any information.</small>
                    </div>

                    <input type="submit" name="btnSave" class="btn btn-primary" value="Save">
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