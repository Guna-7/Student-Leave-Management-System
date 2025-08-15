<?php
session_start();
include('includes/config.php');

// Check if user is logged in
if(empty($_SESSION['alogin'])) {
    header('location:index.php');
    exit();
}

// Fetch staff details based on session ID
$staff_id = $_SESSION['eid']; // Assuming 'eid' is the session variable for staff ID
$sql = "SELECT * FROM tblstaff WHERE ID = :staff_id";
$query = $dbh->prepare($sql);
$query->bindParam(':staff_id', $staff_id, PDO::PARAM_INT);
$query->execute();
$staff = $query->fetch(PDO::FETCH_ASSOC);

// Check if staff member exists
if(!$staff) {
    echo "Staff member not found.";
    exit();
}

// Update staff details if form is submitted
if(isset($_POST['submit'])) {
    $staffName = $_POST['StaffName'];
    $dob = $_POST['DOB'];
    $designation = $_POST['Designation'];
    $email = $_POST['Email'];

    $sql_update = "UPDATE tblstaff SET StaffName = :staffName, DOB = :dob, Designation = :designation, Email = :email WHERE ID = :staff_id";
    $query_update = $dbh->prepare($sql_update);
    $query_update->bindParam(':staffName', $staffName, PDO::PARAM_STR);
    $query_update->bindParam(':dob', $dob, PDO::PARAM_STR);
    $query_update->bindParam(':designation', $designation, PDO::PARAM_STR);
    $query_update->bindParam(':email', $email, PDO::PARAM_STR);
    $query_update->bindParam(':staff_id', $staff_id, PDO::PARAM_INT);
    $query_update->execute();

    // Redirect to the same page after updating
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
        <meta charset="UTF-8">
        <meta name="description" content="Responsive Admin Dashboard Template" />
        <meta name="keywords" content="admin,dashboard" />
        <meta name="author" content="Steelcoders" />
        
        <!-- Styles -->
        <link type="text/css" rel="stylesheet" href="assets/plugins/materialize/css/materialize.min.css"/>
        <link type="text/css" rel="stylesheet" href="assets/plugins/materialize/css/materialize.css"/>
        <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="assets/plugins/material-preloader/css/materialPreloader.min.css" rel="stylesheet"> 
        <link href="../assets/css/alpha.min.css" rel="stylesheet" type="text/css"/><link href="../assets/css/alpha.min.css" rel="stylesheet" type="text/css"/>
        <link href="assets/css/custom.css" rel="stylesheet" type="text/css"/>
  
    <style>
     
    body{
        
    }
        .errorWrap {
    padding: 10px;
    margin: 0 0 20px 0;
    background: black;
    border-left: 4px solid #dd3d36;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
.succWrap{
    padding: 10px;
    margin: 0 0 20px 0;
    background: black;
    border-left: 4px solid #5cb85c;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}


   
    #one{
        background-color: #2a2a2a;
        background-size: 100%;
    }
        
        body {
            background-color: #2a2a2a;
        }
        .form-container {
            margin-top: 10px;
            margin-left: 20px; /* Adjust as needed */
        }

        /* Add this CSS code */
        .sidebar-container {
            background-color: skyblue;
            background-size: 100%; /* Change the background color of the sidebar */
        }
    </style>
</head>
<body>
<?php include('stf/header.php');?>
            
<?php include('stf/sidebar.php');?>
<main class="mn-inner" id="one">
    <div class="container text-center form-container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title" style="color: green;">My Profile</h5>
                        <form method="post">
                            <div class="form-group">
                                <label for="StaffName">Staff Name</label>
                                <input type="text" class="form-control" name="StaffName" value="<?php echo htmlentities($staff['StaffName']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="DOB">Date of Birth</label>
                                <input type="date" class="form-control" name="DOB" value="<?php echo htmlentities($staff['DOB']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="Designation">Designation</label>
                                <input type="text" class="form-control" name="Designation" value="<?php echo htmlentities($staff['Designation']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="Email">Email</label>
                                <input type="email" class="form-control" name="Email" value="<?php echo htmlentities($staff['Email']); ?>" required>
                            </div>
                            <button type="submit" class="btn btn-primary" name="submit">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="assets/plugins/jquery/jquery-2.2.0.min.js"></script>
<script src="assets/plugins/materialize/js/materialize.min.js"></script>
<script src="assets/plugins/material-preloader/js/materialPreloader.min.js"></script>
<script src="assets/plugins/jquery-blockui/jquery.blockui.js"></script>
<script src="assets/js/alpha.min.js"></script>
<script src="assets/js/pages/form_elements.js"></script>
</body>
</html>
