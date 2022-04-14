<?php 
	$connect = mysqli_connect('localhost', 'root', '', 'hexauniversity');

	//delete Comments table
	$delete = "DROP TABLE Reacts";
	$query = mysqli_query($connect, $delete);
	if ($query) {
		echo "<script>alert('Reacts Table Deleted')</script>";
	}
	else {
		echo mysqli_error($connect);
	}

	//delete Comments table
	$delete = "DROP TABLE Comments";
	$query = mysqli_query($connect, $delete);
	if ($query) {
		echo "<script>alert('Comments Table Deleted')</script>";
	}
	else {
		echo mysqli_error($connect);
	}

	//delete Ideas table
	$delete = "DROP TABLE Ideas";
	$query = mysqli_query($connect, $delete);
	if ($query) {
		echo "<script>alert('Ideas Table Deleted')</script>";
	}
	else {
		echo mysqli_error($connect);
	}

	//delete Users table
	$delete = "DROP TABLE Users";
	$query = mysqli_query($connect, $delete);
	if ($query) {
		echo "<script>alert('Users Table Deleted')</script>";
	}
	else {
		echo mysqli_error($connect);
	}

	//delete Departments table
	$delete = "DROP TABLE Departments";
	$query = mysqli_query($connect, $delete);
	if ($query) {
		echo "<script>alert('Departments Table Deleted')</script>";
	}
	else {
		echo mysqli_error($connect);
	}

	//delete Events table
	$delete = "DROP TABLE Events";
	$query = mysqli_query($connect, $delete);
	if ($query) {
		echo "<script>alert('Events Table Deleted')</script>";
	}
	else {
		echo mysqli_error($connect);
	}

	//delete Categories table
	$delete = "DROP TABLE Categories";
	$query = mysqli_query($connect, $delete);
	if ($query) {
		echo "<script>alert('Categories Table Deleted')</script>";
	}
	else {
		echo mysqli_error($connect);
	}

	//delete Department Types table
	$delete = "DROP TABLE DepartmentTypes";
	$query = mysqli_query($connect, $delete);
	if ($query) {
		echo "<script>alert('Department Types Table Deleted')</script>";
	}
	else {
		echo mysqli_error($connect);
	}

	//delete Roles table
	$delete = "DROP TABLE Roles";
	$query = mysqli_query($connect, $delete);
	if ($query) {
		echo "<script>alert('Roles Table Deleted')</script>";
	}
	else {
		echo mysqli_error($connect);
	}

	//delete Admin table
	$delete = "DROP TABLE Admin";
	$query = mysqli_query($connect, $delete);
	if ($query) {
		echo "<script>alert('Admin Table Deleted')</script>";
	}
	else {
		echo mysqli_error($connect);
	}
	
	// -----------------------------------------------------------------------------------------

	//create Admin table
	$create = "CREATE TABLE Admin
				(AdminID varchar(30) NOT NULL PRIMARY KEY,
				Username varchar(30),
				Password varchar(50))";
	$query = mysqli_query($connect, $create);
	if ($query) {
		echo "<script>alert('Admin Table Created')</script>";
	}
	else {
		echo mysqli_error($connect);
	}

	$insert = "INSERT INTO Admin VALUES ('A-000001', 'admin', 'admin')";
	$query = mysqli_query($connect, $insert);

	if ($query) {
		echo "<script>alert('Admin Data Inserted')</script>";
	}
	else {
		echo mysqli_error($connect);
	}
	//create Roles table
	$create = "CREATE TABLE Roles
				(RoleID varchar(30) NOT NULL PRIMARY KEY,
				Role varchar(30))";
	$query = mysqli_query($connect, $create);
	if ($query) {
		echo "<script>alert('Roles Table Created')</script>";
	}
	else {
		echo mysqli_error($connect);
	}

	$insert = "INSERT INTO Roles
				VALUES
				    ('R-000001', 'QA Manager'),
				    ('R-000002', 'QA Coordinator'),
				    ('R-000003', 'Staff');";
	$query = mysqli_query($connect, $insert);

	if ($query) {
		echo "<script>alert('Roles Data Inserted')</script>";
	}
	else {
		echo mysqli_error($connect);
	}

	//create DepartmentTypes table
	$create = "CREATE TABLE DepartmentTypes
				(DepartmentTypeID varchar(30) NOT NULL PRIMARY KEY,
				DepartmentType varchar(30))";
	$query = mysqli_query($connect, $create);
	if ($query) {
		echo "<script>alert('Department Types Table Created')</script>";
	}
	else {
		echo mysqli_error($connect);
	}
	$insert = "INSERT INTO DepartmentTypes
				VALUES
				    ('D-000001', 'Academic'),
				    ('D-000002', 'Support');";
	$query = mysqli_query($connect, $insert);


	//create Categories table
	$create = "CREATE TABLE Categories
				(CategoryID varchar(30) NOT NULL PRIMARY KEY,
				CategoryName varchar(30))";
	$query = mysqli_query($connect, $create);
	if ($query) {
		echo "<script>alert('Categories Table Created')</script>";
	}
	else {
		echo mysqli_error($connect);
	}

	//create Events table
	$create = "CREATE TABLE Events
				(EventID varchar(30) NOT NULL PRIMARY KEY,
				EventName varchar(30),
				StartDate date,
				ClosureDate date,
				FinalClosureDate date)";
	$query = mysqli_query($connect, $create);
	if ($query) {
		echo "<script>alert('Events Table Created')</script>";
	}
	else {
		echo mysqli_error($connect);
	}

	//create Departments table
	$create = "CREATE TABLE Departments
				(DepartmentID varchar(30) NOT NULL PRIMARY KEY,
				DepartmentName varchar(30),
				DepartmentTypeID varchar(30),
				FOREIGN KEY (DepartmentTypeID) REFERENCES DepartmentTypes (DepartmentTypeID))";
	$query = mysqli_query($connect, $create);
	if ($query) {
		echo "<script>alert('Departments Table Created')</script>";
	}
	else {
		echo mysqli_error($connect);
	}

	//create Users table
	$create = "CREATE TABLE Users
				(UserID varchar(30) NOT NULL PRIMARY KEY,
				Username varchar(30),
				Photo text,
				Email varchar(50),
				Password varchar(50),
				DOB date,
				Phone varchar(30),
				Address varchar(255),
				RoleID varchar(30),
				DepartmentID varchar(30),
				FOREIGN KEY (RoleID) REFERENCES	Roles (RoleID),
				FOREIGN KEY (DepartmentID) REFERENCES Departments (DepartmentID))";
	$query = mysqli_query($connect, $create);
	if ($query) {
		echo "<script>alert('Users Table Created')</script>";
	}
	else {
		echo mysqli_error($connect);
	}

	//create Ideas table
	$create = "CREATE TABLE Ideas
				(IdeaID varchar(30) NOT NULL PRIMARY KEY,
				Idea text,
				Anonymous boolean,
				Document text,
				UploadTime datetime,
				ViewCount int,
				LikeCount int,
				DislikeCount int,
				CategoryID varchar(30),
				UserID varchar(30),
				EventID varchar(30),
				FOREIGN KEY (CategoryID) REFERENCES Categories (CategoryID),
				FOREIGN KEY (UserID) REFERENCES Users (UserID),
				FOREIGN KEY (EventID) REFERENCES Events (EventID))";
	$query = mysqli_query($connect, $create);
	if ($query) {
		echo "<script>alert('Ideas Table Created')</script>";
	}
	else {
		echo mysqli_error($connect);
	}

	//create Comments table
	$create = "CREATE TABLE Comments
				(CommentID varchar(30) NOT NULL PRIMARY KEY,
				Comment text,
				Anonymous boolean,
				UploadTime datetime,
				IdeaID varchar(30),
				UserID varchar(30),
				FOREIGN KEY (IdeaID) REFERENCES Ideas (IdeaID),
				FOREIGN KEY (UserID) REFERENCES Users (UserID))";
	$query = mysqli_query($connect, $create);
	if ($query) {
		echo "<script>alert('Comments Table Created')</script>";
	}
	else {
		echo mysqli_error($connect);
	}

	//create Reacts table
	$create = "CREATE TABLE Reacts
				(ReactID varchar(30) NOT NULL PRIMARY KEY,
				React varchar(10),
				IdeaID varchar(30),
				UserID varchar(30),
				FOREIGN KEY (IdeaID) REFERENCES Ideas (IdeaID),
				FOREIGN KEY (UserID) REFERENCES Users (UserID))";
	$query = mysqli_query($connect, $create);
	if ($query) {
		echo "<script>alert('Reacts Table Created')</script>";
	}
	else {
		echo mysqli_error($connect);
	}
?>