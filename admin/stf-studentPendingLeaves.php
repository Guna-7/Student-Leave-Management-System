<?php
session_start();
include('includes/config.php');

// Redirect to login page if not logged in
if(empty($_SESSION['alogin'])) {
    header('location:index.php');
    exit();
}
error_reporting(E_ALL);
ini_set('display_errors', 1);

if(empty($_SESSION['alogin'])) {
    header('location:index.php');
    exit();
}

// Check if staff_id is provided in the URL
if(!isset($_GET['staff_id']) || empty($_GET['staff_id'])) {
    echo "Staff ID not provided.";
    exit(); // Stop further execution
}

$staff_id = $_GET['staff_id'];

// Fetch assigned class for the staff member
$sql = "SELECT class_id FROM staff_assignments WHERE staff_id = :staff_id";
$query = $dbh->prepare($sql);
$query->bindParam(':staff_id', $staff_id, PDO::PARAM_INT);
$query->execute();
$assigned_class = $query->fetch(PDO::FETCH_ASSOC);

if($assigned_class) {
    $class_id = $assigned_class['class_id'];

    // Fetch leave details of students in the assigned class
    $sql_leave = "SELECT tblleaves.id as lid, 
                        tblemployees.FirstName, 
                        tblemployees.LastName, 
                        tblemployees.EmpId, 
                        tblemployees.id, 
                        tblleaves.LeaveType, 
                        tblleaves.PostingDate, 
                        tblleaves.Status 
                  FROM tblleaves 
                  JOIN tblemployees ON tblleaves.empid = tblemployees.id 
                  WHERE tblemployees.class_id = :class_id 
                  ORDER BY lid DESC";
    $query_leave = $dbh->prepare($sql_leave);
    $query_leave->bindParam(':class_id', $class_id, PDO::PARAM_INT);
    $query_leave->execute();
    $leave_details = $query_leave->fetchAll(PDO::FETCH_ASSOC);
} else {
    echo "No class assigned to this staff member.";
    exit(); // Stop further execution
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin |pending leaves</title>
   
        <!-- Title -->
        <title>Admin |  pending leaves </title>
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
        <meta charset="UTF-8">
        <meta name="description" content="Responsive Admin Dashboard Template" />
        <meta name="keywords" content="admin,dashboard" />
        <meta name="author" content="Steelcoders" />
        
        <!-- Styles -->
        <link type="text/css" rel="stylesheet" href="assets/plugins/materialize/css/materialize.min.css"/>
         <link type="text/css" rel="stylesheet" href="assets/plugins/materialize/css/materialize.css"/>
        <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="assets/plugins/material-preloader/css/materialPreloader.min.css" rel="stylesheet"> 
        <link href="assets/css/alpha.min.css" rel="stylesheet" type="text/css"/>
        <link href="assets/css/custom.css" rel="stylesheet" type="text/css"/>
        <link href="assets/css/style.css" rel="stylesheet" type="text/css"/>
        <style>
             #one{
        background-color: #2a2a2a;
        background-size: 100%;
    }
        
        body {
            background-color: #2a2a2a;
        }
        .errorWrap {
    padding: 10px;
    margin: 0 0 20px 0;
    background: #fff;
    border-left: 4px solid #dd3d36;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
.succWrap{
    padding: 10px;
    margin: 0 0 20px 0;
    background: #fff;
    border-left: 4px solid #5cb85c;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
.btn.btn-sky-blue {
    background-color: skyblue !important; /* Add !important to override existing styles */
    color: black; /* Text color */
}

</style>
    <!-- Include your CSS and JS files here -->
</head>
<body>
<?php include('stf/header.php');?>
            
            <?php include('stf/sidebar.php');?>
                 <main class="mn-inner">
                     <div class="row">
                         <div class="col s12">
                             <div class="page-title" style="color: silver;">Pending Leave History</div>
                         </div>
                        
                         <div class="col s12 m12 l12">
                             <div class="card">
                                 <div class="card-content">
                                    
                                  

    <!-- Leave Details Table -->

    <?php if($assigned_class && !empty($leave_details)): ?>
        <table>
            <thead>
                <tr>
                    <th>Leave ID</th>
                    <th>Student Name</th>
                    <th>Student ID</th>
                    <th>Leave Type</th>
                    <th>Posting Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($leave_details as $leave): ?>
                    <tr>
                        <td><?php echo htmlentities($leave['lid']); ?></td>
                        <td><?php echo htmlentities($leave['FirstName'] . ' ' . $leave['LastName']); ?></td>
                        <td><?php echo htmlentities($leave['EmpId']); ?></td>
                        <td><?php echo htmlentities($leave['LeaveType']); ?></td>
                        <td><?php echo htmlentities($leave['PostingDate']); ?></td>
                        <td>
                            <?php
                            $status = $leave['Status'];
                            if($status == 1) {
                                echo '<span style="color: green;">Approved</span>';
                            } elseif($status == 2) {
                                echo '<span style="color: red;">Not Approved</span>';
                            } else {
                                echo '<span style="color: blue;">Waiting for Approval</span>';
                            }
                            ?>
                        </td>
                        <td>
                            <a href="stf-studentLeaveDetails.php?leaveid=<?php echo htmlentities($leave['lid']); ?>" class="btn btn-sky-blue">View Details</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No leave details found for students in this staff member's class.</p>
    <?php endif; ?>

    <div class="left-sidebar-hover"></div>
        
        <!-- Javascripts -->
        <script src="../assets/plugins/jquery/jquery-2.2.0.min.js"></script>
        <script src="../assets/plugins/materialize/js/materialize.min.js"></script>
        <script src="../assets/plugins/material-preloader/js/materialPreloader.min.js"></script>
        <script src="../assets/plugins/jquery-blockui/jquery.blockui.js"></script>
        <script src="../assets/plugins/datatables/js/jquery.dataTables.min.js"></script>
        <script src="../assets/js/alpha.min.js"></script>
        <script src="../assets/js/pages/table-data.js"></script>
         <script src="assets/js/pages/ui-modals.js"></script>
        <script src="assets/plugins/google-code-prettify/prettify.js"></script>
        
    </body>
</html>
<?php  ?>