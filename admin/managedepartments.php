<?php
// Include database connectivity code
include('includes/config.php');

// Delete staff assignment
if(isset($_GET['delete_id']) && !empty($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $sql = "DELETE FROM staff_assignments WHERE assignment_id = :delete_id";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':delete_id', $delete_id, PDO::PARAM_INT);
    if($stmt->execute()) {
        echo "<script>alert('Staff assignment deleted successfully');</script>";
    } else {
        echo "<script>alert('Error deleting staff assignment');</script>";
    }
}

// Fetch staff assignments
function displayStaffAssignments($dbh) {
    $sql = "SELECT sa.assignment_id, s.StaffName, c.year, c.section, c.class_name FROM staff_assignments sa
            INNER JOIN tblstaff s ON sa.staff_id = s.ID
            INNER JOIN classes c ON sa.class_id = c.class_id";
    $result = $dbh->query($sql);

    if ($result->rowCount() > 0) {
        echo "<table border='1'>";
        echo "<tr><th>Assignment ID</th><th>Staff Name</th><th>Year</th><th>Section</th><th>Class Name</th><th>Action</th></tr>";
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>" . $row["assignment_id"] . "</td>";
            echo "<td>" . $row["StaffName"] . "</td>";
            echo "<td>" . $row["year"] . "</td>";
            echo "<td>" . $row["section"] . "</td>";
            echo "<td>" . $row["class_name"] . "</td>";
            // Add delete option
            echo "<td><a href='?delete_id=" . $row['assignment_id'] . "' onclick=\"return confirm('Are you sure you want to delete this staff assignment?');\">Delete</a></td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No staff assignments found";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>STAFF ASSIGNMENTS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
        <meta charset="UTF-8">
        <meta name="description" content="Responsive Admin Dashboard Template" />
        <meta name="keywords" content="admin,dashboard" />
        <meta name="author" content="Steelcoders" />
        
        <!-- Styles -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
        <link type="text/css" rel="stylesheet" href="../assets/plugins/materialize/css/materialize.css"/>
        <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">    
        <link href="../assets/plugins/metrojs/MetroJs.min.css" rel="stylesheet">
        <link href="../assets/plugins/weather-icons-master/css/weather-icons.min.css" rel="stylesheet">

        	
        <!-- Theme Styles -->
        <link href="../assets/css/alpha.min.css" rel="stylesheet" type="text/css"/>
        <link href="../assets/css/style.css" rel="stylesheet" type="text/css"/>
        <style>
 
        
        body {
            font-family: 'Arial', sans-serif;
            background-color: #2a2a2a;
            margin: 0;
            padding: 0;
        }

        table {
            background-color: white;
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:hover {
            background-color: #f5f5f5;
        }
        h2 {
            color: white;
            text-align: center;
        }
    </style>
</head>
<body>
</head>
    <body>
           <?php include('includes/header.php');?>
            
       <?php include('includes/sidebar.php');?>

            <main class="mn-inner mt-5">
             
    <h2>STAFF ASSIGNMENTS</h2>
    <?php
    // Display staff assignments
    
    displayStaffAssignments($dbh);
   
    ?>
 <div class="left-sidebar-hover"></div>
        
        <!-- Javascripts -->
        <script src="assets/plugins/jquery/jquery-2.2.0.min.js"></script>
        <script src="assets/plugins/materialize/js/materialize.min.js"></script>
        <script src="assets/plugins/material-preloader/js/materialPreloader.min.js"></script>
        <script src="assets/plugins/jquery-blockui/jquery.blockui.js"></script>
        <script src="assets/plugins/datatables/js/jquery.dataTables.min.js"></script>
        <script src="assets/js/alpha.min.js"></script>
        <script src="assets/js/pages/table-data.js"></script>
        
    </body>
</html>
