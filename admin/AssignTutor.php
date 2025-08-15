<?php
// Include database connectivity code
include('includes/config.php');

// Initialize $msg and $error variables
$msg = '';
$error = '';

// Check if form is submitted
if(isset($_POST['assign_staff'])) {
    $staff_id = $_POST['staff_id'];
    $class_id = $_POST['class_id'];

    // Check if the staff is already assigned to a class
    $check_sql = "SELECT * FROM staff_assignments WHERE staff_id = :staff_id";
    $check_query = $dbh->prepare($check_sql);
    $check_query->bindParam(':staff_id', $staff_id, PDO::PARAM_INT);
    $check_query->execute();
    $existing_assignment = $check_query->fetch(PDO::FETCH_ASSOC);

    if($existing_assignment) {
        // If the staff is already assigned, delete the previous assignment
        $delete_sql = "DELETE FROM staff_assignments WHERE staff_id = :staff_id";
        $delete_query = $dbh->prepare($delete_sql);
        $delete_query->bindParam(':staff_id', $staff_id, PDO::PARAM_INT);
        $delete_query->execute();
    }

    // Insert new assignment record
    $sql = "INSERT INTO staff_assignments (staff_id, class_id) VALUES (:staff_id, :class_id)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':staff_id', $staff_id, PDO::PARAM_INT);
    $query->bindParam(':class_id', $class_id, PDO::PARAM_INT);
    $query->execute();
    $lastInsertId = $dbh->lastInsertId();
    
    if ($lastInsertId) {
        $msg = "Staff assigned to class successfully";
        // Redirect to managedepartments.php after 1 second
        header("refresh:1; url=managedepartments.php");
    } else {
        $error = "Something went wrong. Please try again";
    }
}

// Fetch staff members
$sqlStaff = "SELECT ID, StaffName FROM tblstaff";
$staffResult = $dbh->query($sqlStaff);

// Fetch classes
$sqlClasses = "SELECT class_id, year, section, class_name FROM classes";
$classesResult = $dbh->query($sqlClasses);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Assign Staff to Classes</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <meta charset="UTF-8">
    <meta name="description" content="Responsive Admin Dashboard Template"/>
    <meta name="keywords" content="admin,dashboard"/>
    <meta name="author" content="Steelcoders"/>

    <!-- Styles -->
    <link type="text/css" rel="stylesheet" href="../assets/plugins/materialize/css/materialize.min.css"/>
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="../assets/css/alpha.min.css" rel="stylesheet" type="text/css"/>
    <link href="../assets/css/custom.css" rel="stylesheet" type="text/css"/>
    <style>
        body {
            background-color: #2a2a2a;
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        form {
            max-width: 600px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        select, button {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button {
            background-color: #4caf50;
            color: #fff;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        .errorWrap {
            padding: 10px;
            margin: 0 0 20px 0;
            background: #fff;
            border-left: 4px solid #dd3d36;
            box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
        }

        .succWrap {
            padding: 10px;
            margin: 0 0 20px 0;
            background: #fff;
            border-left: 4px solid #5cb85c;
            box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
        }
    </style>
</head>
<body>
    <?php include('includes/header.php'); ?>
    <?php include('includes/sidebar.php'); ?>
    <main class="mn-inner">
        <!-- Add a form for assigning staff to classes -->
        <form method="post" action="">
            <label for="staff_id">Select Staff:</label>
            <select name="staff_id" required>
                <?php while ($staffRow = $staffResult->fetch(PDO::FETCH_ASSOC)) { ?>
                    <option value="<?php echo $staffRow['ID']; ?>"><?php echo $staffRow['StaffName']; ?></option>
                <?php } ?>
            </select>
            
            <label for="class_id">Select Class:</label>
            <select name="class_id" required>
                <?php while ($classRow = $classesResult->fetch(PDO::FETCH_ASSOC)) { ?>
                    <option value="<?php echo $classRow['class_id']; ?>"><?php echo $classRow['class_name']; ?></option>
                <?php } ?>
            </select>

            <button type="submit" name="assign_staff">Assign Staff</button>
        </form>
        <div class="left-sidebar-hover"></div>
        <?php if(!empty($msg)): ?>
            <div class="succWrap"><?php echo $msg; ?></div>
        <?php endif; ?>

        <!-- Display error message -->
        <?php if(!empty($error)): ?>
            <div class="errorWrap"><?php echo $error; ?></div>
        <?php endif; ?>
    </main>

    <!-- Javascripts -->
    <script src="../assets/plugins/jquery/jquery-2.2.0.min.js"></script>
<script src="../assets/plugins/materialize/js/materialize.min.js"></script>
<script src="../assets/plugins/material-preloader/js/materialPreloader.min.js"></script>
<script src="../assets/plugins/jquery-blockui/jquery.blockui.js"></script>
<script src="../assets/js/alpha.min.js"></script>
<script src="../assets/js/pages/form_elements.js"></script>

</body>
</html>
