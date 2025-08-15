<?php
session_start();
error_reporting(0);
include('includes/config.php');

if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
   // Check if the search form is submitted
        if(isset($_GET['search'])) {
            // Get search criteria from the form
            $class_id = $_GET['class_id'];
            $from_date = $_GET['from_date'];
            $to_date = $_GET['to_date'];

            // Modify the SQL query to filter leave details based on search criteria
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
                        AND tblleaves.PostingDate BETWEEN :from_date AND :to_date
                        ORDER BY lid DESC";
            $query_leave = $dbh->prepare($sql_leave);
            $query_leave->bindParam(':class_id', $class_id, PDO::PARAM_INT);
            $query_leave->bindParam(':from_date', $from_date, PDO::PARAM_STR);
            $query_leave->bindParam(':to_date', $to_date, PDO::PARAM_STR);
            $query_leave->execute();
            $leave_details = $query_leave->fetchAll(PDO::FETCH_ASSOC);
        }
        ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Leave Details</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <meta charset="UTF-8">
    <meta name="description" content="Responsive Admin Dashboard Template" />
    <meta name="keywords" content="admin,dashboard" />
    <meta name="author" content="Steelcoders" />
    
    <!-- Styles -->
    <link type="text/css" rel="stylesheet" href="../assets/plugins/materialize/css/materialize.min.css"/>
    <link type="text/css" rel="stylesheet" href="../assets/plugins/materialize/css/materialize.css"/>
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="../assets/plugins/material-preloader/css/materialPreloader.min.css" rel="stylesheet">
    <link href="../assets/plugins/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="../assets/plugins/google-code-prettify/prettify.css" rel="stylesheet" type="text/css"/>  
    <!-- Theme Styles -->
    <link href="../assets/css/alpha.min.css" rel="stylesheet" type="text/css"/>
    <link href="../assets/css/custom.css" rel="stylesheet" type="text/css"/>
    <link href="../assets/css/style.css" rel="stylesheet" type="text/css"/>
    
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #2a2a2a;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h5 {
            margin-top: 0;
            text-align: center;
        }
        form {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
        }
        .input-field {
            margin: 10px;
            width: calc(33.33% - 20px); /* Adjust width as needed */
        }
        .btn-search {
            margin-top: 10px;
            width: 100%;
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
<?php include('includes/header.php');?>
        
        <?php include('includes/sidebar.php');?>
    <div class="container">
        <h5>Search Leave Details</h5>
        <form method="get" action="">
            <div class="input-field">
                <select name="class_id">
                    <option value="" disabled selected>Select Class</option>
                    <!-- Populate the dropdown with class options -->
                    <?php
                    // Fetch and populate class options from the database
                    $sql_classes = "SELECT class_id, class_name FROM classes";
                    $query_classes = $dbh->prepare($sql_classes);
                    $query_classes->execute();
                    $classes = $query_classes->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($classes as $class) {
                        echo "<option value='".$class['class_id']."'>".$class['class_name']."</option>";
                    }
                    ?>
                </select>
                <label>Class Name</label>
            </div>
            <div class="input-field">
                <input type="date" name="from_date">
                <label for="from_date">From </label>
            </div>
            <div class="input-field">
                <input type="date" name="to_date">
                <label for="to_date">To </label>
            </div>
            <button class="btn waves-effect waves-light btn-search" type="submit" name="search">Search</button>
        </form>

        <?php if(isset($leave_details) && !empty($leave_details)): ?>
        <table>
            <thead>
                <tr>
                    <th>Leave ID</th>
                    <th>Student Name</th>
                    <th>Student ID</th>
                    <th>Leave Type</th>
                    <th>Posting Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($leave_details as $leave): ?>
                <tr>
                    <td><?php echo $leave['lid']; ?></td>
                    <td><?php echo $leave['FirstName'] . ' ' . $leave['LastName']; ?></td>
                    <td><?php echo $leave['EmpId']; ?></td>
                    <td><?php echo $leave['LeaveType']; ?></td>
                    <td><?php echo $leave['PostingDate']; ?></td>
                    <td>
                        <?php if($leave['Status'] == 1): ?>
                            <span style="color: green;">Approved</span>
                        <?php elseif($leave['Status'] == 2): ?>
                            <span style="color: red;">Not Approved</span>
                        <?php else: ?>
                            <span style="color: blue;">Waiting for Approval</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php elseif(isset($leave_details) && empty($leave_details)): ?>
        <p>No leave details found for the selected class and dates.</p>
        <?php endif; 
        }?>
    </div>
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

