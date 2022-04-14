<?php
  session_start(); 
  $connect = mysqli_connect('localhost', 'root', '', 'hexauniversity');
  $AdminID=$_SESSION['AdminID'];
  if (!isset($_SESSION['AdminID'])) 
  {
     echo "<script> alert('Please Login first')</script>";
     echo "<script> window.location='login.php'</script>";
  }
  
 if (isset($_GET['UserID'])) 
 {
      $user=$_GET['UserID'];
      $select="Select * from users u, departments d, roles r
              Where u.UserID='$user'
              AND d.DepartmentID=u.DepartmentID
              And u.RoleID=r.RoleID";
      $result=mysqli_query($connect,$select);
      $arr=mysqli_fetch_array($result);
 }
  if (isset($_POST['btnsave'])) 
  {
    $id=$_POST['txtid'];
    $name=$_POST['txtname'];
    $prevphoto=$_POST['prevphoto'];
    $folder="../images/";
      $filename='';
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

    $email=$_POST['txtemail'];
    $password=md5($_POST['txtpassword']);
    $dob=$_POST['txtdob'];
    $phone=$_POST['txtphone'];
    $address=$_POST['txtaddress'];
    $role=$_POST['cborole'];
    $department=$_POST['cbodepartment'];

    if ($_POST['txtpassword']!='') 
    {
     $update="Update users
            Set Username='$name',
            Photo='$filename',
            Email='$email',
            Password='$password',
            DOB='$dob',
            Phone='$phone',
            Address='$address',
            RoleID='$role',
            DepartmentID='$department'
            Where UserID='$id'";
    }
    else
    {
      $update="Update users
            Set Username='$name',
            Photo='$filename',
            Email='$email',
            DOB='$dob',
            Phone='$phone',
            Address='$address',
            RoleID='$role',
            DepartmentID='$department'
            Where UserID='$id'";
    }  
    
    $ret=mysqli_query($connect,$update);

    if ($ret) 
      {
        echo"<script>window.alert('Update sucessful')</script>";
        echo "<script>window.location='accounts.php'</script>";       
      }

     else 
     {
        echo "<p>Something went wrong in Staff Update " . mysqli_error($connect) . "</p>";
     }   
  }

 if (isset($_POST['btndelete'])) {
    $userid = $_POST['txtid'];

    //Delete comments and reacts of the user
    $deleteReact="Delete from reacts where UserID='$userid'";
    $result1= mysqli_query($connect,$deleteReact);

    $deleteComment="Delete from comments where UserID='$userid'";
    $result2= mysqli_query($connect,$deleteComment);

    //Delete comments and reacts related to ideas uploaded by user
    $selectIdea = "SELECT * FROM ideas WHERE UserID='$userid'";
    $selectIdeaRes = mysqli_query($connect, $selectIdea);
    $ideaCount = mysqli_num_rows($selectIdeaRes);

    for ($i=0; $i < $ideaCount; $i++) { 
      $ideaArr = mysqli_fetch_array($selectIdeaRes);
      $relatedIdeaID = $ideaArr['IdeaID'];

      $deleteRelatedReact = "Delete from reacts where IdeaID='$relatedIdeaID'";
      $deleteRelatedReactResult = mysqli_query($connect,$deleteRelatedReact);

      $deleteRelatedComment = "Delete from comments where IdeaID='$relatedIdeaID'";
      $deleteRelatedCommentResult = mysqli_query($connect,$deleteRelatedComment);
    }

    $deleteIdea="Delete from ideas where UserID='$userid'";
    $result3= mysqli_query($connect,$deleteIdea);

    $deleteUser="Delete from users where UserID='$userid'";
    $result4= mysqli_query($connect,$deleteUser);

    if ($result1 and $result2 and $result3 and $result4) 
    {
      echo "<script>window.alert('User Deleted!')</script>";
      echo "<script>window.location='accounts.php'</script>";
    } 

    else
    {
      //echo "<p><script>window.alert('Something went wrong')</script>". mysqli_error($connect) ."</p>";
      echo "Result 1 is " . $result1 . " ";
      echo "Result 2 is " . $result2 . " "; 
      echo "Result 3 is " . $result3 . " ";
      echo "Result 4 is " . $result4 . " ";
    }
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
	  		<h1><a href="accounts.php" class="logo">Hexa University<br><span style="font-size: 13px;">Admin Dashboard</span></a></h1>
        <ul class="list-unstyled components mb-5">
          <li class="active">
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
            <h2 style="text-align: center;"><b>Edit User Account</b></h2>
            <div class="container mt-4 mb-4 p-3 d-flex justify-content-center">
              <div class="card p-4">
                  <form action="account-edit.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="txtid" value="<?php echo $arr['UserID'] ?>">
                    <div class="form-group">
                      <label>New Name</label>
                      <input type="text" name="txtname" class="form-control" value="<?php echo $arr['Username'] ?>" required>
                    </div>
                    
                    <div class="form-group">
                      <label>Photo</label>
                      <input type="file" name="txtphoto" class="form-control" >
                      <input type="hidden" name="prevphoto" value="<?php echo $arr['Photo'] ?>" >
                    </div>

                    <div class="form-group">
                      <label>New Email address</label>
                      <input type="email" name="txtemail" class="form-control" aria-describedby="emailHelp" value="<?php echo $arr['Email'] ?>" required>
                    </div>

                    <div class="form-group">
                      <label>New Password</label>
                      <input type="password" name="txtpassword" class="form-control" placeholder="Password" >
                    </div>

                    <div class="form-group">
                      <label>Date Of birth</label>
                      <input type="date" name="txtdob" class="form-control" value="<?php echo $arr['DOB'] ?>" required>
                    </div>

                    <div class="form-group">
                      <label>Phone</label>
                      <input type="text" name="txtphone" class="form-control" value="<?php echo $arr['Phone'] ?>" required>
                    </div>

                    <div class="form-group">
                      <label>Address</label>
                      <textarea class="form-control" name="txtaddress" rows="3" required><?php echo $arr['Address'] ?></textarea>
                    </div>

                    <div class="form-group">
                      <label>Role</label><br>
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <label class="input-group-text" for="inputGroupSelect01">Options</label>
                        </div>
                        <select class="custom-select" name="cborole" id="inputGroupSelect01">
                          <option value="<?php echo $arr['RoleID']?>"><?php echo $arr['RoleID']?>- <?php echo $arr['Role'] ?></option>
                          <?php 
                              $selectid="Select * from roles";
                              $ret=mysqli_query($connect,$selectid);
                              $count=mysqli_num_rows($ret);
                              for ($i=0; $i <$count ; $i++) { 
                              $arr1=mysqli_fetch_array($ret);

                              $RoleID=$arr1['RoleID'];
                              $Role=$arr1['Role'];
                              echo"<option value='$RoleID'>$RoleID - $Role</option>";
                            }
                          ?>
                        </select>
                      </div>
                    </div>

                   
                    <div class="form-group">
                      <label>Department</label><br>
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <label class="input-group-text" for="inputGroupSelect01">Options</label>
                        </div>
                        <select class="custom-select" name="cbodepartment" id="inputGroupSelect01">
                          <option value="<?php echo $arr['DepartmentID']?>"><?php echo $arr['DepartmentID']?>- <?php echo $arr['DepartmentName'] ?></option>
                          <?php 
                              $selectid="Select * from departments";
                              $ret=mysqli_query($connect,$selectid);
                              $count=mysqli_num_rows($ret);
                              for ($i=0; $i <$count ; $i++) { 
                              $arr2=mysqli_fetch_array($ret);

                              $ID=$arr2['DepartmentID'];
                              $Name=$arr2['DepartmentName'];
                              echo"<option value='$ID'>$ID - $Name</option>";
                            }
                          ?>
                        </select>
                      </div>
                    </div>
                    <button type="submit" name="btnsave" class="btn btn-primary">Save</button>
                    <button type="submit" name="btndelete" class="btn btn-danger">Delete This Account</button>
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